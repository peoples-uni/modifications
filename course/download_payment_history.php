<?php  // $Id: download_payment_history.php,v 1.0 2017/10/10 17:42:00 alanbarrett Exp $

// http://courses.peoples-uni.org/course/download_payment_history.php

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

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

$PAGE->set_url('/course/download_payment_history.php'); // Defined here to avoid notices on errors etc

$PAGE->set_pagelayout('embedded');   // Needs as much space as possible

require_login();

// Access to applications.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('download_payment_history.php');
$PAGE->set_heading('download_payment_history.php');

$data = "\xEF\xBB\xBF" . '"Family name","Given name","Email address","Date","Detail","Transaction Amount ' . "\xC2\xA3" . 's","Confirmed?","Balance ' . "\xC2\xA3" . 's (+ve means the Student Owes Peoples-uni)","Income category","Country","MPH"' . "\n";

$applications = $DB->get_records_sql("
SELECT
  b.id as balanceid,
  u.id as userid,
  u.email,
  u.lastname,
  u.firstname,
  u.country,
  b.date,
  b.detail,
  b.amount_delta,
  b.not_confirmed,
  b.balance,
  IFNULL(m.mphstatus, 0) AS mphstatus,
  IFNULL(m.mphstatus, 0) AS mph,
  m.datesubmitted AS mphdatestamp,
  IFNULL(ic.income_category, 0) AS income_category
FROM      mdl_user u
JOIN      mdl_peoples_student_balance b ON u.id=b.userid
LEFT JOIN mdl_peoplesmph2 m ON u.id=m.userid
LEFT JOIN mdl_peoples_income_category ic ON u.id=ic.userid
WHERE u.id IN (SELECT e.userid FROM mdl_enrolment e)
ORDER BY b.date ASC, b.id ASC");

if (empty($applications)) {
  $applications = array();
}

foreach ($applications as $application) {
  $data .= '"';

  $userid = (int)$application->userid;

  $data .= str_replace('"', '""', $application->lastname) . '","';
  $data .= str_replace('"', '""', $application->firstname) . '","';
  $data .= str_replace('"', '""', $application->email) . '","';

  $data .= str_replace('"', '""', gmdate('d/m/Y H:i', $application->date)) . '","';
  $data .= str_replace('"', '""', $application->detail) . '","';
  $data .= str_replace('"', '""', number_format($application->amount_delta, 2)) . '","';

  if ($application->not_confirmed) {
    $confirmed = '(not confirmed)';
  }
  else {
    $confirmed = '';
  }
  $data .= str_replace('"', '""', $confirmed) . '","';

  $data .= str_replace('"', '""', number_format($application->balance, 2)) . '","';
  
  if (empty($application->income_category)) $application->income_category = 0;
  $data .= str_replace('"', '""', $income_category_texts[$application->income_category]) . '","';

  if (empty($countryname[$application->country])) $z = '';
  else $z = $countryname[$application->country];
  $data .= str_replace('"', '""', $z) . '","';

  if (empty($application->mphstatus)) $application->mphstatus = 0;
  $data .= str_replace('"', '""', $mphstatus_texts[$application->mphstatus]) . '"' . "\n";
}

header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="payment_history.csv"');
header('Content-length: ' . strlen($data));
header('X-Frame-Options: ALLOWALL');
header('Pragma: no-cache');
header('Cache-control: no-cache, must-revalidate, no-transform');
echo $data;
?>
