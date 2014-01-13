<?php

/**
 * Application form for Peoples-uni Students
 */

require_once('../config.php');
require_once('application_form_returning_student_form.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/application_form_student.php');


$editform = new application_form_returning_student_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {
  unset($_SESSION['peoples_filling_in_application_form']);

  $application = new object();

  // Should be a transaction! (or use $application->id, but id is less than sid and I do not want to mess with live system now)
  $peoplessid = $DB->get_record('peoplessid', array('id' => 1));
  $peoplessid->sid = $peoplessid->sid + 1;
  $DB->update_record('peoplessid', $peoplessid);
  $application->sid = $peoplessid->sid;

  $application->state = 0;

  $dataitem = $data->course_id_1;
  if ($dataitem === '' || (is_numeric($dataitem) && $dataitem == 0)) {
    $application->course_id_1 = 0;
    $application->coursename1 = '';
  }
  else {
    $application->course_id_1 = $dataitem; // $application->course_id_1 is not used
    $course = $DB->get_record('course', array('id' => $dataitem));
    $application->coursename1 = $course->fullname;
  }

  $dataitem = $data->course_id_2;
  if ($dataitem === '' || (is_numeric($dataitem) && $dataitem == 0)) {
    $application->course_id_2 = 0;
    $application->coursename2 = '';
  }
  else {
    $application->course_id_2 = $dataitem; // $application->course_id_2 is not used
    $course = $DB->get_record('course', array('id' => $dataitem));
    $application->coursename2 = $course->fullname;
  }

  $dataitem = $data->applymmumph;
  if (empty($dataitem)) $dataitem = 0;
  $application->applymmumph = $dataitem;
  $applymmumphtext = array(0 => '', 1 => 'No', 2 => 'Yes', 3 => 'Already');
  $applymmumphtext[1] = 'No, continue with Peoples-uni';
  $applymmumphtext[2] = 'Yes, apply for MMU MPH';
  $applymmumphtext[3] = 'I am already enrolled in MMU MPH';
  $applymmumphtext[4] = 'Yes, apply for Peoples-uni MPH';
  $applymmumphtext[5] = 'I am already enrolled in Peoples-uni MPH';
  $applymmumphtext[6] = 'Yes, apply for OTHER MPH';
  $applymmumphtext[7] = 'I am already enrolled in OTHER MPH';
  $applymmumphtext = $applymmumphtext[$application->applymmumph];

  $dataitem = $data->applycertpatientsafety;
  if (empty($dataitem)) $dataitem = 0;
  $application->applycertpatientsafety = $dataitem;
  $applycertpatientsafetytext = array(0 => '', 1 => 'No', 2 => 'Yes', 3 => 'Already');
  $applycertpatientsafetytext = $applycertpatientsafetytext[$application->applycertpatientsafety];

  $dataitem = $data->scholarship;
  if (empty($dataitem)) $dataitem = '';
  $application->scholarship = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->whynotcomplete;
  if (empty($dataitem)) $dataitem = '';
  $application->whynotcomplete = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $user_record = $DB->get_record('user', array('username' => $data->username));

  $application->username  = $user_record->username;
  $application->userid    = $user_record->id;

  $application->email     = $user_record->email;
  $application->lastname  = $user_record->lastname;
  $application->firstname = $user_record->firstname;
  $application->city      = $user_record->city;
  $application->country   = $user_record->country;

  $oldapplication = $DB->get_record('peoplesapplication', array('userid' => $application->userid), '*', IGNORE_MULTIPLE);
  if (empty($oldapplication)) {
    $oldapplication = $DB->get_record('peoplesregistration', array('userid' => $application->userid), '*', IGNORE_MULTIPLE);
  }

  $application->reenrolment = 0;
  // Set reenrolment only if the Student was actually at least partially enrolled in a previous (not current) semester
  // Partially enrolled states:
  // Octal Decimal
  //    23      19
  //    32      26
  //    13      11
  //    31      25
  //    33      27
  $semester_current = $DB->get_record('semester_current', array('id' => 1));
  $previous_enrolments = $DB->get_records_sql('
    SELECT id
    FROM mdl_peoplesapplication
    WHERE
      userid=? AND
      semester!=? AND
      state IN (19, 26, 11, 25, 27)',
    array($application->userid, $semester_current->semester));
  if (!empty($previous_enrolments)) {
    $application->reenrolment = 1;
  }

  $application->gender                = $oldapplication->gender;
  $application->applicationaddress    = $oldapplication->applicationaddress;
  $application->currentjob            = $oldapplication->currentjob;
  $application->education             = $oldapplication->education;
  $application->reasons               = $oldapplication->reasons;
  $application->sponsoringorganisation= $oldapplication->sponsoringorganisation;

  $application->dobyear               = $oldapplication->dobyear;
  $application->dobmonth              = $oldapplication->dobmonth;
  $application->dobday                = $oldapplication->dobday;
  $application->dob                   = sprintf('%04d-%02d-%02d', $application->dobyear, $application->dobmonth, $application->dobday); // Actually $application->dob is not used

  $application->employment            = $oldapplication->employment;
  $application->qualification         = $oldapplication->qualification;
  $application->higherqualification   = $oldapplication->higherqualification;

  $application->nid                   = 80; // Returning Student Application

  $application->datesubmitted         = time();

  $semester_current = $DB->get_record('semester_current', array('id' => 1));
  $application->semester = $semester_current->semester;

  $application->currency = 'GBP'; // The DB default is no longer correct 20090526!
  $application->methodofpayment = '';
  $application->paymentidentification = '';

  $DB->insert_record('peoplesapplication', $application);


  if ($application->reenrolment == 0) {
    $message = "First Application for...\n\n";
    $returning_in_title = 'First';
  }
  else {
    $message = "Returning Student Application for...\n\n";
    $returning_in_title = 'Returning';
  }
  $message .= "Family Name: $application->lastname\n\n";
  $message .= "First Name: $application->firstname\n\n";
  $message .= "e-mail: $application->email\n\n";
  $message .= "Submission ID (SID): $application->sid\n\n";
  $message .= "Date Submitted: " . gmdate('d/m/Y H:i', $application->datesubmitted) . "\n\n";
  $message .= "Semester: $application->semester\n\n";
  $message .= "Module 1: $application->coursename1\n\n";
  $message .= "Module 2: $application->coursename2\n\n";
  $message .= "Apply for MPH: $applymmumphtext\n\n";
  $message .= "Apply for Certificate in Patient Safety: $applycertpatientsafetytext\n\n";
  $message .= "City: $application->city\n\n";
  $countryname = get_string_manager()->get_list_of_countries(false);
  $message .= "Country: " . $countryname[$application->country] . "\n\n";
  $message .= "Username: $application->username\n\n";
  $message .= "Data from original application...\n\n";
  $message .= "Date of Birth: $application->dob\n\n";
  $message .= "Gender: $application->gender\n\n";
  $message .= "Application Address:\n" . htmlspecialchars_decode($application->applicationaddress, ENT_COMPAT) . "\n\n";
  $message .= "Reasons for wanting to enrol:\n" . htmlspecialchars_decode($application->reasons, ENT_COMPAT) . "\n\n";
  $message .= "Sponsoring organisation:\n" . htmlspecialchars_decode($application->sponsoringorganisation, ENT_COMPAT) . "\n\n";

    $employmentname[  ''] = 'Select...';
    $employmentname[ '1'] = 'None';
    $employmentname['10'] = 'Student';
    $employmentname['20'] = 'Non-health';
    $employmentname['30'] = 'Clinical (not specifically public health)';
    $employmentname['40'] = 'Public health';
    $employmentname['50'] = 'Other health related';
    $employmentname['60'] = 'Academic occupation (e.g. lecturer)';
  $message .= "Current Employment: " . $employmentname[$application->employment] . "\n\n";
    $qualificationname[  ''] = 'Select...';
    $qualificationname[ '1'] = 'None';
    $qualificationname['10'] = 'Degree (not health related)';
    $qualificationname['20'] = 'Health qualification (non-degree)';
    $qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
    $qualificationname['40'] = 'Medical degree';
  $message .= "Higher Education Qualification: " . $qualificationname[$application->qualification] . "\n\n";
    $higherqualificationname[  ''] = 'Select...';
    $higherqualificationname[ '1'] = 'None';
    $higherqualificationname['10'] = 'Certificate';
    $higherqualificationname['20'] = 'Diploma';
    $higherqualificationname['30'] = 'Masters';
    $higherqualificationname['40'] = 'Ph.D.';
    $higherqualificationname['50'] = 'Other';
  $message .= "Postgraduate Qualification: " . $higherqualificationname[$application->higherqualification] . "\n\n";

  $message .= "Current Employment Details:\n" . htmlspecialchars_decode($application->currentjob, ENT_COMPAT) . "\n\n";
  $message .= "Other relevant qualifications or educational experience:\n" . htmlspecialchars_decode($application->education, ENT_COMPAT) . "\n\n";
  $message .= "Scholarship:\n" . htmlspecialchars_decode($application->scholarship, ENT_COMPAT) . "\n\n";
  $message .= "Why Not Completed Previous Semester:\n" . htmlspecialchars_decode($application->whynotcomplete, ENT_COMPAT) . "\n";

  sendapprovedmail($application->email, "Peoples-uni $returning_in_title Application Form Submission From: $application->lastname, $application->firstname", $message);
  sendapprovedmail('apply@peoples-uni.org', "Peoples-uni $returning_in_title Application Form Submission From: $application->lastname, $application->firstname", $message);

  redirect(new moodle_url($CFG->wwwroot . '/course/application_form_success.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Application Form");
$PAGE->set_heading('Peoples-uni Course Application Form');

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