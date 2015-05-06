<?php  // payment_history.php 20150505

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');
require_once($CFG->dirroot .'/course/peoples_filters.php');

$income_category_texts = array();
$income_category_texts[0] = '';
$income_category_texts[1] = 'LMIC';
$income_category_texts[2] = 'HIC';

$countryname = get_string_manager()->get_list_of_countries(false);

$mphstatus_texts = array();
$mphstatus_texts[0] = '';
$mphstatus_texts[1] = 'MMU MPH';
$mphstatus_texts[2] = 'Peoples MPH';
$mphstatus_texts[3] = 'OTHER MPH';

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/payment_history.php'); // Defined here to avoid notices on errors etc


$peoples_filters = new peoples_filters();

$peoples_filters->set_page_url("$CFG->wwwroot/course/payment_history.php");

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
  if (!isset($defaultsemester)) $defaultsemester = $semester->semester;
}
$peoples_chosensemester_filter = new peoples_chosensemester_filter('Semester', 'chosensemester', $listsemester, $defaultsemester);
$peoples_filters->add_filter($peoples_chosensemester_filter);

$listchosenpaidornot[] = 'Any';
$listchosenpaidornot[] = 'Yes';
$listchosenpaidornot[] = 'No';
$peoples_chosenpaidornot_filter = new peoples_chosenpaidornot_filter('Payment up to date?', 'chosenpaidornot', $listchosenpaidornot, 'Any');
$peoples_filters->add_filter($peoples_chosenpaidornot_filter);

$listincome_category[] = 'Any';
$listincome_category[] = 'LMIC';
$listincome_category[] = 'HIC';
$listincome_category[] = 'Existing Student';
$peoples_income_category_filter = new peoples_income_category_filter('Income Category', 'income_category', $listincome_category, 'Any');
$peoples_filters->add_filter($peoples_income_category_filter);

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

$peoples_displayforexcel_filter = new peoples_boolean_filter('Display for Copying and Pasting to Excel', 'displayforexcel');
$peoples_filters->add_filter($peoples_displayforexcel_filter);


$chosensemester = $peoples_chosensemester_filter->get_filter_setting();
$displayforexcel = $peoples_displayforexcel_filter->get_filter_setting();


if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/payment_history.php?' . $peoples_filters->get_url_parameters());
}


$PAGE->set_pagelayout('embedded');   // Needs as much space as possible

require_login();

// Access to payment_history.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Payment History');
$PAGE->set_heading('Payment History');
echo $OUTPUT->header();

if (!$displayforexcel) echo "<h1>Payment History</h1>";
if (!$displayforexcel) $peoples_filters->show_filters();

$applications = $DB->get_records_sql("
SELECT
  u.id as userid,
  u.email,
  u.lastname,
  u.firstname,
  u.country,
  IFNULL(m.mphstatus, 0) AS mphstatus,
  IFNULL(m.mphstatus, 0) AS mph,
  m.datesubmitted AS mphdatestamp,
  IFNULL(ic.income_category, 0) AS income_category,
  ? AS semester
FROM      mdl_user u
LEFT JOIN mdl_peoplesmph2 m ON u.id=m.userid
LEFT JOIN mdl_peoples_income_category ic ON u.id=ic.userid
WHERE u.id IN (SELECT e.userid FROM mdl_enrolment e WHERE e.semester=?)
ORDER BY TRIM(u.lastname), TRIM(u.firstname)",
array($chosensemester, $chosensemester));

if (empty($applications)) {
  $applications = array();
}

$applications = $peoples_filters->filter_entries($applications);


$table = new html_table();

if (!$displayforexcel) {
  $table->head = array(
    'Family name',
    'Given name',
    'Email address',
    'Payment up to date?',
    'Previous balance',
    'Balance before that',
    'Other balances',
    'Income category',
    'Country',
    'MPH',
    '',
  );
}
else {
  $table->head = array(
    'Family name',
    'Given name',
    'Email address',
    'Payment up to date?',
    'Previous balance',
    'Balance before that',
    'Other balances',
    'Income category',
    'Country',
    'MPH',
  );
}

$n = 0;
foreach ($applications as $application) {
  $rowdata = array();
  $userid = (int)$application->userid;

  $rowdata[] = htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8');
  $rowdata[] = $application->email;

  $amount_owed = 0;
  $not_confirmed_text = '';
  if (is_not_confirmed($userid)) $not_confirmed_text = ' (not confirmed)';
  $amount = amount_to_pay($userid);
  $amount_owed = $amount;
  if (!$displayforexcel) {
    if ($amount >= .01) $z = '<span style="color:red">No: &pound;' . $amount . ' Owed now' . $not_confirmed_text . '</span>';
    elseif (abs($amount) < .01) $z = '<span style="color:green">Yes' . $not_confirmed_text . '</span>';
    else $z = '<span style="color:blue">' . "Overpaid: &pound;$amount" . $not_confirmed_text . '</span>'; // Will never be Overpaid here because of function used
  }
  else {
    if ($amount >= .01) $z = 'No: &pound;' . $amount . ' Owed now' . $not_confirmed_text;
    elseif (abs($amount) < .01) $z = 'Yes' . $not_confirmed_text;
    else $z = "Overpaid: &pound;$amount" . $not_confirmed_text; // Will never be Overpaid here because of function used
  }
  $rowdata[] = $z;

  $balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} ORDER BY date DESC, id DESC");
  $balance_array = array();
  if (!empty($balances)) {
    foreach ($balances as $balance) {
      $balance_array[] = $balance->balance . gmdate('(d/m/Y)', $balance->date);
    }
  }
  if (empty($balance_array[1])) $balance_array[1] = '';
  if (empty($balance_array[2])) $balance_array[2] = '';
  if (empty($balance_array[3])) $balance_array[3] = '';
  $rowdata[] = $balance_array[1];
  $rowdata[] = $balance_array[2];

  $i = 4;
  while (!empty($balance_array[$i])) {
    $balance_array[3] .= ', ' . $balance_array[$i];
    $i++;
  }
  $rowdata[] = $balance_array[3];

  if (empty($application->income_category)) $application->income_category = 0;
  $rowdata[] = $income_category_texts[$application->income_category];

  if (empty($countryname[$application->country])) $z = '';
  else $z = $countryname[$application->country];
  $rowdata[] = $z;

  if (empty($application->mphstatus)) $application->mphstatus = 0;
  $rowdata[] = $mphstatus_texts[$application->mphstatus];

  $applications_for_sid = $DB->get_records_sql("SELECT sid FROM mdl_peoplesapplication WHERE userid=$userid ORDER BY sid DESC");
  foreach ($applications_for_sid as $sid => $app) {
    break;
  }
  if (!$displayforexcel) $rowdata[] = '<a href="' . $CFG->wwwroot . '/course/payconfirm.php?sid=' . $sid . '" target="_blank">Payment Amounts</a>';

  $n++;
  $table->data[] = $rowdata;
}
echo html_writer::table($table);

if ($displayforexcel) {
  echo $OUTPUT->footer();
  die();
}

echo '<br />Total Entries: ' . $n;

echo $OUTPUT->footer();
?>
