<?php
/**
*
* copy_moodle_student_data_to_registrations_applications.php
*
*/


$qualificationname[ '1'] = 'None';
$qualificationname['10'] = 'Degree (not health related)';
$qualificationname['20'] = 'Health qualification (non-degree)';
$qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
$qualificationname['40'] = 'Medical degree';

$higherqualificationname[ '1'] = 'None';
$higherqualificationname['10'] = 'Certificate';
$higherqualificationname['20'] = 'Diploma';
$higherqualificationname['30'] = 'Masters';
$higherqualificationname['40'] = 'Ph.D.';
$higherqualificationname['50'] = 'Other';

$employmentname[ '1'] = 'None';
$employmentname['10'] = 'Student';
$employmentname['20'] = 'Non-health';
$employmentname['30'] = 'Clinical (not specifically public health)';
$employmentname['40'] = 'Public health';
$employmentname['50'] = 'Other health related';
$employmentname['60'] = 'Academic occupation (e.g. lecturer)';


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/copy_moodle_student_data_to_registrations_applications.php'); // Defined here to avoid notices on errors etc

$PAGE->set_pagelayout('embedded');

require_login();

require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('copy_moodle_student_data_to_registrations_applications.php');
$PAGE->set_heading('copy_moodle_student_data_to_registrations_applications.php');
echo $OUTPUT->header();


$all_users = $DB->get_records('user', array('deleted' => 0));

$n = 0;
foreach ($all_users as $a_user) {
  $userid = $a_user->id;

  $record = new object();

  $userrecord = $DB->get_record('user', array('id' => $userid));
  if (!empty($userrecord->username)) $record->username = $userrecord->username;
  if (!empty($userrecord->firstname)) $record->firstname = $userrecord->firstname;
  if (!empty($userrecord->lastname)) $record->lastname = $userrecord->lastname;
  if (!empty($userrecord->email)) $record->email = $userrecord->email;
  if (!empty($userrecord->city)) $record->city = $userrecord->city;
  if (!empty($userrecord->country)) $record->country = $userrecord->country;

  $profile_items = $DB->get_records('user_info_data', array('userid' => $userid));
  if (!empty($profile_items)) {
    foreach ($profile_items as $profile_item) {

      if ($profile_item->fieldid == 1) {
        if (!empty($profile_item->data)) {
          $dob_array = explode(' ', trim($profile_item->data));
          if (!empty($dob_array[0]) && !empty($dob_array[1]) && !empty($dob_array[2])) {
            $monthnames = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
            $month = array_search($dob_array[1], $monthnames);
            if (!empty($month) && ($dob_array[0] > 0) && ($dob_array[0] <= 31) && ($dob_array[2] > 1900) && ($dob_array[2] < 2100)) {
              $record->dobday = $dob_array[0];
              $record->dobmonth = $month;
              $record->dobyear = $dob_array[2];
              $record->dob = sprintf('%04d-%02d-%02d', $record->dobyear, $record->dobmonth, $record->dobday);
            }
          }
        }
      }

      if ($profile_item->fieldid == 2) {
        if (!empty($profile_item->data) && ($profile_item->data == 'Female' || $profile_item->data == 'Male')) $record->gender = $profile_item->data;
      }

      if ($profile_item->fieldid == 3) {
        if (!empty($profile_item->data)) $record->applicationaddress = trim(strip_tags(str_replace('<br />', "\r\n", $profile_item->data)));
      }

      if ($profile_item->fieldid == 4) {
        if (!empty($profile_item->data)) $record->currentjob = trim(strip_tags(str_replace('<br />', "\r\n", $profile_item->data)));
      }

      if ($profile_item->fieldid == 5) {
        if (!empty($profile_item->data)) $record->education = trim(strip_tags(str_replace('<br />', "\r\n", $profile_item->data)));
      }

      if ($profile_item->fieldid == 6) {
        if (!empty($profile_item->data)) $record->reasons = trim(strip_tags(str_replace('<br />', "\r\n", $profile_item->data)));
      }

      if ($profile_item->fieldid == 10) {
        if (!empty($profile_item->data)) $record->sponsoringorganisation = trim(strip_tags(str_replace('<br />', "\r\n", $profile_item->data)));
      }

      if ($profile_item->fieldid == 7) {
        $key = array_search($profile_item->data, $qualificationname);
        if (!empty($key)) $record->qualification = $key;
      }

      if ($profile_item->fieldid == 8) {
        $key = array_search($profile_item->data, $higherqualificationname);
        if (!empty($key)) $record->higherqualification = $key;
      }

      if ($profile_item->fieldid == 9) {
        $key = array_search($profile_item->data, $employmentname);
        if (!empty($key)) $record->employment = $key;
      }
    }
  }


  $copied_data = FALSE;
  $records_to_update = $DB->get_records('temppeoplesregistration', array('userid' => $userid));
//  $records_to_update = $DB->get_records('peoplesregistration', array('userid' => $userid));
  if (!empty($records_to_update)) {
    foreach ($records_to_update as $record_to_update) {
      $record->id = $record_to_update->id;
      $DB->update_record('temppeoplesregistration', $record);
//      $DB->update_record('peoplesregistration', $record);
      $copied_data = TRUE;
    }
  }

  $records_to_update = $DB->get_records('temppeoplesapplication', array('userid' => $userid));
//  $records_to_update = $DB->get_records('peoplesapplication', array('userid' => $userid));
  if (!empty($records_to_update)) {
    foreach ($records_to_update as $record_to_update) {
      $record->id = $record_to_update->id;
      $DB->update_record('temppeoplesapplication', $record);
//      $DB->update_record('peoplesapplication', $record);
      $copied_data = TRUE;
    }
  }

  if ($copied_data) $n++;
}

echo '<br/>Number of Students that had data copied across: ' . $n . '<br /><br />';


echo $OUTPUT->footer();
?>
