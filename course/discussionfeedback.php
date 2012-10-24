<?php

/**
 * Discussion Feedback Form (to send e-mail to student and records data also)
 */

require_once('../config.php');
require_once('discussionfeedback_form.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/discussionfeedback.php');


$isteacher = is_peoples_teacher();
//$islurker = has_capability('moodle/course:view', get_context_instance(CONTEXT_SYSTEM));
$islurker = FALSE;
if (!$isteacher && !$islurker) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/discussionfeedback.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}


$editform = new discussionfeedback_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  if (empty($_SESSION['peoples_course_id_for_discussion_feedback'])) {

    $dataitem = $data->course_id;
    if (!empty($dataitem) && is_numeric($dataitem)) {
      $_SESSION['peoples_course_id_for_discussion_feedback'] = $data->course_id;
    }
  }
  else {

    $discussionfeedback = $DB->get_record('discussionfeedback', array('course_id' => $_SESSION['peoples_course_id_for_discussion_feedback'], 'userid' => $data->student_id));

    if (empty($discussionfeedback)) {
      $discussionfeedback = new object();

      $doinsert = TRUE;
    }
    else {
      $doinsert = FALSE;
    }

    $discussionfeedback->refered_to_resources = $data->refered_to_resources;
    $discussionfeedback->critical_approach = $data->critical_approach;
    $discussionfeedback->provided_references = $data->provided_references;

    $dataitem = $data->assessment_text;
    if (empty($dataitem)) $dataitem = '';
    $discussionfeedback->assessment_text = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

    $discussionfeedback->course_id = $_SESSION['peoples_course_id_for_discussion_feedback'];
    $discussionfeedback->userid = $data->student_id;
    $discussionfeedback->user_id_submitted = $USER->id;
    $discussionfeedback->datesubmitted = time();

    if ($doinsert) {
      $DB->insert_record('discussionfeedback', $discussionfeedback);
    }
    else {
      $DB->update_record('discussionfeedback', $discussionfeedback);
    }

    $message = "Returning Student Application for...\n\n";
    $returning_in_title = 'Returning';
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

  }

  //redirect(new moodle_url($CFG->wwwroot . '/course/application_form_success.php'));
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


function is_peoples_teacher() {
  global $USER;
  global $DB;

  $teachers = $DB->get_records_sql("
    SELECT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.name IN ('Module Leader', 'Tutors') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>