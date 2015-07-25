<?php  // bursary.php
/**
*
* List all Bursary entries
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

$countryname = get_string_manager()->get_list_of_countries(false);

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/bursary.php'); // Defined here to avoid notices on errors etc


require_once($CFG->dirroot .'/course/peoples_filters.php');

$peoples_filters = new peoples_filters();

$peoples_filters->set_page_url("$CFG->wwwroot/course/bursary.php");

$peoples_daterange_filter = new peoples_daterange_filter();
$peoples_filters->add_filter($peoples_daterange_filter);

$peoples_chosensearch_filter = new peoples_chosensearch_filter('Name or e-mail Contains', 'chosensearch');
$peoples_filters->add_filter($peoples_chosensearch_filter);

$listacceptedmmu[] = 'Any';
$listacceptedmmu[] = 'Yes';
$listacceptedmmu[] = 'No';
$listacceptedmmu[] = 'MMU MPH';
$listacceptedmmu[] = 'Peoples MPH';
$listacceptedmmu[] = 'OTHER MPH';
for ($year = 11; $year <= 17; $year++) {
  $listacceptedmmu[] = "Accepted {$year}a";
  $listacceptedmmu[] = "Accepted {$year}b";

  $stamp_range["Accepted {$year}a"]['start'] = gmmktime( 0, 0, 0,  1,  1, 2000 + $year);
  $stamp_range["Accepted {$year}a"]['end']   = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['start'] = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['end']   = gmmktime(24, 0, 0, 12, 31, 2000 + $year);
}
$peoples_acceptedmmu_filter = new peoples_acceptedmmu_filter('Accepted MPH?', 'acceptedmmu', $listacceptedmmu, 'Any');
$peoples_acceptedmmu_filter->set_stamp_range($stamp_range);
$peoples_filters->add_filter($peoples_acceptedmmu_filter);

$listsuspendedmmu[] = 'Any';
$listsuspendedmmu[] = 'Suspended';
$listsuspendedmmu[] = 'Not Suspended';
$listsuspendedmmu[] = 'Graduated';
$listsuspendedmmu[] = 'Not Graduated';
$listsuspendedmmu[] = 'Not Graduated or Suspended';
$peoples_suspendedmmu_filter = new peoples_suspendedmmu_filter('Suspended MPH?', 'suspendedmmu', $listsuspendedmmu, 'Any');
$peoples_filters->add_filter($peoples_suspendedmmu_filter);

$listincome_category[] = 'Any';
$listincome_category[] = 'LMIC';
$listincome_category[] = 'HIC';
$listincome_category[] = 'Existing Student';
$peoples_income_category_filter = new peoples_income_category_filter('Income Category', 'income_category', $listincome_category, 'Any');
$peoples_filters->add_filter($peoples_income_category_filter);

$peoples_sortbyname_filter = new peoples_boolean_filter('Sort by Student Name', 'sortbyname');
$peoples_filters->add_filter($peoples_sortbyname_filter);

$peoples_displaystandardforexcel_filter = new peoples_boolean_filter('Display for Copying and Pasting to Excel', 'displaystandardforexcel');
$peoples_filters->add_filter($peoples_displaystandardforexcel_filter);

$sortbyname              = $peoples_sortbyname_filter->get_filter_setting();
$displaystandardforexcel = $peoples_displaystandardforexcel_filter->get_filter_setting();


if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/bursary.php?' . $peoples_filters->get_url_parameters());
}


$PAGE->set_pagelayout('embedded');   // Needs as much space as possible
//$PAGE->set_pagelayout('base');     // Most backwards compatible layout without the blocks - this is the layout used by default
//$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information
//$PAGE->set_pagelayout('course');
//$PAGE->set_pagetype('course-view-' . 1);
//$PAGE->set_other_editing_capability('moodle/course:manageactivities');


require_login();

// Access to bursary.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Bursary Entries in Student Account');
$PAGE->set_heading('Bursary Entries in Student Account');
echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


if (!$displaystandardforexcel) echo "<h1>Bursary Entries in Student Account</h1>";


if (!$displaystandardforexcel) $peoples_filters->show_filters();


if ($sortbyname) {
  $sortorder = 'u.lastname, u.firstname, u.id';
}
else {
  $sortorder = 'b.date DESC';
}

$applications = $DB->get_records_sql("
SELECT
  u.lastname,
  u.firstname,
  u.email,
  u.country,
  b.date,
  b.date AS datesubmitted,
  b.amount_delta,
  b.detail,
  b.userid,
  m.id IS NOT NULL AS mph,
  m.mphstatus,
  m.datesubmitted AS mphdatestamp
FROM      mdl_peoples_student_balance b
JOIN      mdl_user        u ON b.userid=u.id
LEFT JOIN mdl_peoplesmph2 m ON b.userid=m.userid AND m.userid!=0
WHERE
  detail LIKE '%scholarship%' OR
  detail LIKE '%bursa%' OR
  detail LIKE '%busar%' OR
  detail LIKE '%bursr%'
ORDER BY $sortorder");
if (empty($applications)) {
  $applications = array();
}

$applications = $peoples_filters->filter_entries($applications);


$table = new html_table();

$table->head = array(
  'Family name',
  'Given name',
  'Email address',
  'Country',
  'MPH',
  'Date',
  'Amount',
  'Detail',
  );

$n = 0;
foreach ($applications as $application) {
  $application->userid = (int)$application->userid;

  $rowdata = array();
  $rowdata[] = htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8');

  $rowdata[] = htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
  if (empty($countryname[$application->country])) $z = '';
  else $z = $countryname[$application->country];
  $rowdata[] = $z;

  if     ($application->mph && ($application->mphstatus == 1)) $z = 'MMU MPH';
  elseif ($application->mph && ($application->mphstatus == 2)) $z = 'Peoples MPH';
  elseif ($application->mph && ($application->mphstatus == 3)) $z = 'OTHER MPH';
  else $z = '';
  $rowdata[] = $z;

  $rowdata[] = gmdate('d/m/Y', $application->date);
  $rowdata[] = '&pound;' . number_format($application->amount_delta, 2);
 
  $rowdata[] = htmlspecialchars($application->detail, ENT_COMPAT, 'UTF-8');

  $table->data[] = $rowdata;
}

echo html_writer::table($table);

if ($displaystandardforexcel) {
  echo $OUTPUT->footer();
  die();
}

echo '<br />Total Entries: ' . $n;
echo '<br /><br />';

echo $OUTPUT->footer();
?>