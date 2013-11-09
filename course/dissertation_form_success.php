<?php

/**
 * Dissertation Form Successfully Submitted
 */

require_once('../config.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/dissertation_form_success.php');

$PAGE->set_title("People's Open Access Education Initiative Dissertation Form Successfully Submitted");
$PAGE->set_heading("People's Open Access Education Initiative Dissertation Form Successfully Submitted");

echo $OUTPUT->header();
echo $OUTPUT->heading("People's Open Access Education Initiative Dissertation Form Successfully Submitted");


$semester_current = $DB->get_record('semester_current', array('id' => 1));
$submitted = $DB->get_record('peoplesapplication', array('userid' => $USER->id, 'semester' => $semester_current->semester, 'hidden' => 0), '*', IGNORE_MULTIPLE);


echo '<p>Thank you for submitting your dissertation idea. You should receive an email copy of your Dissertation Form. If after an hour or two you have not received the email contact our support staff at - <strong><a href="mailto:apply@peoples-uni.org">apply@peoples-uni.org</a></strong> with your details.</p>';

$_SESSION['peoples_filling_in_application_form'] = time() + 40*60;////////////////////////////////////////////////
if (empty($submitted)) { // Is the Course Application Form yet to be submitted for this Semester?
  echo '<p>Please note that you still have to submit the Course Application Form</p>';
  if (empty($_SESSION['peoples_filling_in_application_form']) || ((time() - $_SESSION['peoples_filling_in_application_form']) > (20 * 60))) { // Has 20 minutes passed?
    echo '<p><strong><a href="' . $CFG->wwwroot . '/course/application_form_student.php">Click here to fill in the Course Application Form</a></strong></p>';
  }
  else {
    echo '<p><strong><a href="javascript:window.close();">Click here to Close this Window and Return to your Course Application Form (if you are in the middle of filling it out)</a></strong></p>';
    echo '<p><strong>OR</strong></p>';
    echo '<p><strong><a href="' . $CFG->wwwroot . '/course/application_form_student.php">Click here to fill in a new Course Application Form</a></strong></p>';
  }
}

echo $OUTPUT->footer();
