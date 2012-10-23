<?php

/**
 * Discussion Feedback Form (to send e-mail to student and records data also)
 */

require_once('../config.php');
require_once('discussionfeedback_form.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/discussionfeedback.php');


$editform = new discussionfeedback_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $discussionfeedback = new object();

  $discussionfeedback->state = 0;

  $dataitem = $data->course_id_1;
  if ($dataitem === '' || (is_numeric($dataitem) && $dataitem == 0)) {
    $discussionfeedback->course_id_1 = 0;
    $discussionfeedback->coursename1 = '';
  }
  else {
    $discussionfeedback->course_id_1 = $dataitem; // $discussionfeedback->course_id_1 is not used
    $course = $DB->get_record('course', array('id' => $dataitem));
    $discussionfeedback->coursename1 = $course->fullname;
  }

  $dataitem = $data->course_id_2;
  if ($dataitem === '' || (is_numeric($dataitem) && $dataitem == 0)) {
    $discussionfeedback->course_id_2 = 0;
    $discussionfeedback->coursename2 = '';
  }
  else {
    $discussionfeedback->course_id_2 = $dataitem; // $discussionfeedback->course_id_2 is not used
    $course = $DB->get_record('course', array('id' => $dataitem));
    $discussionfeedback->coursename2 = $course->fullname;
  }

  $dataitem = $data->applymmumph;
  if (empty($dataitem)) $dataitem = 0;
  $discussionfeedback->applymmumph = $dataitem;
  $applymmumphtext = array(0 => '', 1 => 'No', 2 => 'Yes', 3 => 'Already');
  $applymmumphtext = $applymmumphtext[$discussionfeedback->applymmumph];

  $dataitem = $data->scholarship;
  if (empty($dataitem)) $dataitem = '';
  $discussionfeedback->scholarship = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->whynotcomplete;
  if (empty($dataitem)) $dataitem = '';
  $discussionfeedback->whynotcomplete = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $user_record = $DB->get_record('user', array('username' => $data->username));

  $discussionfeedback->username  = $user_record->username;
  $discussionfeedback->userid    = $user_record->id;

  $discussionfeedback->email     = $user_record->email;
  $discussionfeedback->lastname  = $user_record->lastname;
  $discussionfeedback->firstname = $user_record->firstname;
  $discussionfeedback->city      = $user_record->city;
  $discussionfeedback->country   = $user_record->country;

  $discussionfeedback->reenrolment = 1;
  $oldapplication = $DB->get_record('peoplesapplication', array('userid' => $discussionfeedback->userid), '*', IGNORE_MULTIPLE);
  if (empty($oldapplication)) {
    $oldapplication = $DB->get_record('peoplesregistration', array('userid' => $discussionfeedback->userid), '*', IGNORE_MULTIPLE);
    $discussionfeedback->reenrolment = 0;
  }

  $discussionfeedback->gender                = $oldapplication->gender;
  $discussionfeedback->applicationaddress    = $oldapplication->applicationaddress;
  $discussionfeedback->currentjob            = $oldapplication->currentjob;
  $discussionfeedback->education             = $oldapplication->education;
  $discussionfeedback->reasons               = $oldapplication->reasons;
  $discussionfeedback->sponsoringorganisation= $oldapplication->sponsoringorganisation;

  $discussionfeedback->dobyear               = $oldapplication->dobyear;
  $discussionfeedback->dobmonth              = $oldapplication->dobmonth;
  $discussionfeedback->dobday                = $oldapplication->dobday;
  $discussionfeedback->dob                   = sprintf('%04d-%02d-%02d', $discussionfeedback->dobyear, $discussionfeedback->dobmonth, $discussionfeedback->dobday); // Actually $discussionfeedback->dob is not used

  $discussionfeedback->employment            = $oldapplication->employment;
  $discussionfeedback->qualification         = $oldapplication->qualification;
  $discussionfeedback->higherqualification   = $oldapplication->higherqualification;

  $discussionfeedback->nid                   = 80; // Returning Student Application

  $discussionfeedback->datesubmitted         = time();

  $semester_current = $DB->get_record('semester_current', array('id' => 1));
  $discussionfeedback->semester = $semester_current->semester;

  $discussionfeedback->currency = 'GBP'; // The DB default is no longer correct 20090526!
  $discussionfeedback->methodofpayment = '';
  $discussionfeedback->paymentidentification = '';

  $DB->insert_record('peoplesapplication', $discussionfeedback);


  if ($discussionfeedback->reenrolment == 0) {
    $message = "First Application for...\n\n";
    $returning_in_title = 'First';
  }
  else {
    $message = "Returning Student Application for...\n\n";
    $returning_in_title = 'Returning';
  }
  $message .= "Last Name: $discussionfeedback->lastname\n\n";
  $message .= "First Name: $discussionfeedback->firstname\n\n";
  $message .= "e-mail: $discussionfeedback->email\n\n";
  $message .= "Submission ID (SID): $discussionfeedback->sid\n\n";
  $message .= "Date Submitted: " . gmdate('d/m/Y H:i', $discussionfeedback->datesubmitted) . "\n\n";
  $message .= "Semester: $discussionfeedback->semester\n\n";
  $message .= "Module 1: $discussionfeedback->coursename1\n\n";
  $message .= "Module 2: $discussionfeedback->coursename2\n\n";
  $message .= "Apply for MMU MPH: $applymmumphtext\n\n";
  $message .= "City: $discussionfeedback->city\n\n";
  $message .= "Country: " . $countryname[$discussionfeedback->country] . "\n\n";
  $message .= "Username: $discussionfeedback->username\n\n";
  $message .= "Data from original application...\n\n";
  $message .= "Date of Birth: $discussionfeedback->dob\n\n";
  $message .= "Gender: $discussionfeedback->gender\n\n";
  $message .= "Application Address:\n" . htmlspecialchars_decode($discussionfeedback->applicationaddress, ENT_COMPAT) . "\n\n";
  $message .= "Reasons for wanting to enrol:\n" . htmlspecialchars_decode($discussionfeedback->reasons, ENT_COMPAT) . "\n\n";
  $message .= "Sponsoring organisation:\n" . htmlspecialchars_decode($discussionfeedback->sponsoringorganisation, ENT_COMPAT) . "\n\n";

    $employmentname[  ''] = 'Select...';
    $employmentname[ '1'] = 'None';
    $employmentname['10'] = 'Student';
    $employmentname['20'] = 'Non-health';
    $employmentname['30'] = 'Clinical (not specifically public health)';
    $employmentname['40'] = 'Public health';
    $employmentname['50'] = 'Other health related';
    $employmentname['60'] = 'Academic occupation (e.g. lecturer)';
  $message .= "Current Employment: " . $employmentname[$discussionfeedback->employment] . "\n\n";
    $qualificationname[  ''] = 'Select...';
    $qualificationname[ '1'] = 'None';
    $qualificationname['10'] = 'Degree (not health related)';
    $qualificationname['20'] = 'Health qualification (non-degree)';
    $qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
    $qualificationname['40'] = 'Medical degree';
  $message .= "Higher Education Qualification: " . $qualificationname[$discussionfeedback->qualification] . "\n\n";
    $higherqualificationname[  ''] = 'Select...';
    $higherqualificationname[ '1'] = 'None';
    $higherqualificationname['10'] = 'Certificate';
    $higherqualificationname['20'] = 'Diploma';
    $higherqualificationname['30'] = 'Masters';
    $higherqualificationname['40'] = 'Ph.D.';
    $higherqualificationname['50'] = 'Other';
  $message .= "Postgraduate Qualification: " . $higherqualificationname[$discussionfeedback->higherqualification] . "\n\n";

  $message .= "Current Employment Details:\n" . htmlspecialchars_decode($discussionfeedback->currentjob, ENT_COMPAT) . "\n\n";
  $message .= "Other relevant qualifications or educational experience:\n" . htmlspecialchars_decode($discussionfeedback->education, ENT_COMPAT) . "\n\n";
  $message .= "Scholarship:\n" . htmlspecialchars_decode($discussionfeedback->scholarship, ENT_COMPAT) . "\n\n";
  $message .= "Why Not Completed Previous Semester:\n" . htmlspecialchars_decode($discussionfeedback->whynotcomplete, ENT_COMPAT) . "\n";

  sendapprovedmail($discussionfeedback->email, "Peoples-uni $returning_in_title Application Form Submission From: $discussionfeedback->lastname, $discussionfeedback->firstname", $message);
  sendapprovedmail('apply@peoples-uni.org', "Peoples-uni $returning_in_title Application Form Submission From: $discussionfeedback->lastname, $discussionfeedback->firstname", $message);

  redirect(new moodle_url($CFG->wwwroot . '/course/application_form_success.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Discussion Feedback Form");
$PAGE->set_heading('Peoples-uni Discussion Feedback Form');

echo $OUTPUT->header();

$editform->display();

echo $OUTPUT->footer();


function sendapprovedmail($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999;
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->email = 'apply@peoples-uni.org';
  $supportuser->firstname = "People's Open Access Education Initiative: Peoples-uni";
  $supportuser->lastname = '';
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  //$user->email = 'applicationresponses@peoples-uni.org';
  //$user->email = 'alanabarrett0@gmail.com';
  //email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}