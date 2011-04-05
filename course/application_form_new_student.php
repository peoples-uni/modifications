<?php

/**
 * Application form for Peoples-uni for New Students
 */

require_once('../config.php');
require_once('application_form_new_student_form.php');

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/application_form_new_student.php');


$editform = new application_form_new_student_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $application = new object();

  // CREATE TABLE mdl_peoplessid (
  //   id BIGINT(10) unsigned NOT NULL auto_increment,
  //   sid BIGINT(10) unsigned NOT NULL,
  // CONSTRAINT  PRIMARY KEY (id)
  // );
  // INSERT INTO mdl_peoplessid VALUES (1, XXXX);
  // Should be a transaction! (or use $application->id, but id is less than sid and I do not want to mess with live system now)
  $peoplessid = $DB->get_record('peoplessid', array('id' => 1));
  $peoplessid->sid = $peoplessid->sid + 1;
  $DB->update_record('peoplessid', $peoplessid);
  $application->sid = $peoplessid->sid;

  $application->userid = 0;

  $application->state = 0;

  $application->nid = 71; // First Application

  $application->datesubmitted = time();

  $semester_current = $DB->get_record('semester_current', array('id' => 1));
  $application->semester = $semester_current->semester;

  $application->currency = 'GBP'; // The DB default is no longer correct 20090526!
  $application->methodofpayment = '';
  $application->paymentidentification = '';


  // Some of the data cleaning done may be obsolete as the Moodle Form can do it now
  $dataitem = $data['lastname'];
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->lastname = $dataitem;

  $dataitem = $data['firstname'];
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->firstname = $dataitem;

  $dataitem = $data['email'];
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->email = $dataitem;

  $dataitem = $data['course_id_1'];
  if ($dataitem === '' || (is_numeric($dataitem) && $dataitem == 0)) {
    $application->course_id_1 = 0;
    $application->coursename1 = '';
  }
  else {
    $application->course_id_1 = $dataitem; // $application->course_id_1 is not used
    $course = $DB->get_record('course', array('id' => $dataitem));
    $application->coursename1 = $course->fullname;
  }

  $dataitem = $data['course_id_2'];
  if ($dataitem === '' || (is_numeric($dataitem) && $dataitem == 0)) {
    $application->course_id_2 = 0;
    $application->coursename2 = '';
  }
  else {
    $application->course_id_2 = $dataitem; // $application->course_id_2 is not used
    $course = $DB->get_record('course', array('id' => $dataitem));
    $application->coursename2 = $course->fullname;
  }

  $dataitem = $data['gender'];
  $application->gender = $dataitem;

  $dataitem = $data['dob'];
  $application->dobmonth = gmdate('m', $dataitem);
  $application->dobday = gmdate('d', $dataitem);
  $application->dobyear = gmdate('Y', $dataitem);
  $application->dob = gmdate('d-m-Y', $dataitem); // Actually $application->dob is not used

  $dataitem = $data['applicationaddress'];
  // Currently appaction.php does cleaning, so if these data are used in the future in appaction.php, do not do cleaning twice
  $application->applicationaddress = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data['city'];
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 20, 'UTF-8');
  $application->city = $dataitem;

  $dataitem = $data['country'];
  $dataitem = trim(strip_tags($dataitem));
  // (Drupal select fields are protected by Drupal Form API)
  $application->country = $dataitem;

  $dataitem = $data['employment'];
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $application->employment = $dataitem;

  $dataitem = $data['currentjob'];
  if (empty($dataitem)) $dataitem = '';
  // Currently appaction.php does cleaning, so if these data are used in the future in appaction.php, do not do cleaning twice
  $application->currentjob = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data['qualification'];
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $application->qualification = $dataitem;

  $dataitem = $data['higherqualification'];
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $application->higherqualification = $dataitem;

  $dataitem = $data['education'];
  if (empty($dataitem)) $dataitem = '';
  // Currently appaction.php does cleaning, so if these data are used in the future in appaction.php, do not do cleaning twice
  $application->education = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data['reasons'];
  // Currently appaction.php does cleaning, so if these data are used in the future in appaction.php, do not do cleaning twice
  $application->reasons = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data['username'];
  $dataitem = strip_tags($dataitem);
  $dataitem = str_replace("<", '', $dataitem);
  $dataitem = str_replace(">", '', $dataitem);
  $dataitem = str_replace("/", '', $dataitem);
  $dataitem = str_replace("#", '', $dataitem);
  $dataitem = trim(moodle_strtolower($dataitem));
  if (empty($dataitem)) $dataitem = 'user1';  // Just in case it becomes empty
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->username = $dataitem;

  $DB->insert_record('peoplesapplication', $application);

  redirect(new moodle_url($CFG->wwwroot . '/course/application_form_success.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Application Form");
$PAGE->set_heading('Peoples-uni Course Application form for New Students');

echo $OUTPUT->header();

$editform->display();

echo $OUTPUT->footer();
