<?php

/**
 * Rating Response Form to allow Students to respond to their Discussion Feedback from the SSOs
 */

/*
CREATE TABLE mdl_student_ratingresponse (
  id BIGINT(10) unsigned NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  course_id BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  what_skills_need_to_improve TEXT NOT NULL,
  what_do_to_improve_academic_skills TEXT NOT NULL,
  what_do_differently_when_prepare_post TEXT NOT NULL,
  datesubmitted BIGINT(10) unsigned NOT NULL DEFAULT 0,
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_student_ratingresponse_uid_ix ON mdl_student_ratingresponse (userid);
CREATE INDEX mdl_student_ratingresponse_cid_ix ON mdl_student_ratingresponse (course_id);
*/


require_once('../config.php');
require_once('ratingresponse_form.php');

$PAGE->set_context(context_system::instance());

//$PAGE->set_pagelayout('standard');
$PAGE->set_pagelayout('embedded');   // Needs as much space as possible

$PAGE->set_url('/course/ratingresponse.php');


if (!empty($_SESSION['peoples_submitted_student_ratingresponse']) && empty($_SESSION['peoples_course_id_for_student_ratingresponse'])) {
  $_SESSION['peoples_submitted_student_ratingresponse'] = FALSE;
  $course_id = required_param('course_id', PARAM_INT); // Should only get here, if ever, after a session timeout
  die(); // In case, for some reason?, code got through previous line!
}

$course_id = optional_param('course_id', 0, PARAM_INT);
if (!empty($_SESSION['peoples_submitted_student_ratingresponse'])) { // Form submitted
  $course_id = $_SESSION['peoples_course_id_for_student_ratingresponse'];
}

$_SESSION['peoples_submitted_student_ratingresponse'] = FALSE;


require_login();
// (Might possibly be Guest)

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $USER->id));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$fullname = fullname($userrecord);
if (empty($fullname) || trim($fullname) == 'Guest User') {
  if ($course_id) {
    $SESSION->wantsurl = "$CFG->wwwroot/course/ratingresponse.php?course_id=$course_id";
  }
  else {
    $SESSION->wantsurl = "$CFG->wwwroot/course/ratingresponse.php";
  }
  redirect($CFG->wwwroot . '/login/index.php');
}


$_SESSION['peoples_course_id_for_student_ratingresponse'] = $course_id;


if ($course_id) $discussionfeedback_present = $DB->get_record('discussionfeedback', array('course_id' => $course_id, 'userid' => $USER->id));

if ($course_id && !empty($discussionfeedback_present)) {
  $editform = new ratingresponse_form(NULL, array('customdata' => array()));
  if ($editform->is_cancelled()) {
    redirect(new moodle_url('http://courses.peoples-uni.org'));
  }
  elseif ($data = $editform->get_data()) {

    $student_ratingresponse = $DB->get_record('student_ratingresponse', array('course_id' => $course_id, 'userid' => $USER->id));

    if (empty($student_ratingresponse)) {
      $student_ratingresponse = new object();

      $doinsert = TRUE;
    }
    else {
      $doinsert = FALSE;
    }

    $student_ratingresponse->userid = $USER->id;
    $student_ratingresponse->course_id = $course_id;


    $dataitem = $data->what_skills_need_to_improve;
    if (empty($dataitem)) $dataitem = '';
    $student_ratingresponse->what_skills_need_to_improve = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

    $dataitem = $data->what_do_to_improve_academic_skills;
    if (empty($dataitem)) $dataitem = '';
    $student_ratingresponse->what_do_to_improve_academic_skills = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

    $dataitem = $data->what_do_differently_when_prepare_post;
    if (empty($dataitem)) $dataitem = '';
    $student_ratingresponse->what_do_differently_when_prepare_post = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');


    $student_ratingresponse->datesubmitted = time();

    if ($doinsert) {
      $DB->insert_record('student_ratingresponse', $student_ratingresponse);
    }
    else {
      $DB->update_record('student_ratingresponse', $student_ratingresponse);
    }

    redirect(new moodle_url($CFG->wwwroot . '/course/ratingresponse.php', array('course_id' => $course_id)));
  }
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Discussion Forum Contributions");
$PAGE->set_heading('Peoples-uni Discussion Forum Contributions');

echo $OUTPUT->header();

if ($course_id) {
  if (!empty($discussionfeedback_present)) {
    $editform->display();
  }
  else {
    echo '<p><strong>';
    echo 'You have not been given discussion feedback for this module yet, so cannot respond to the feedback yet.<br />';
    echo 'Below you can see past ratings on your discussion contributions by Student Support Officers for all modules along with any reflections on these ratings that you have previously submitted.';
    echo '</strong></p><br />';
  }
  echo '<br />';
}

echo '<p><strong>Discussion Feedback you have received (and any reflections you made in response)...</strong></p>';

$discussionfeedbacks = $DB->get_records_sql("
  SELECT DISTINCT
    d.*,
    c.fullname,
    e.semester,
    r.id IS NOT NULL AS rating_submitted,
    r.what_skills_need_to_improve,
    r.what_do_to_improve_academic_skills,
    r.what_do_differently_when_prepare_post
  FROM mdl_discussionfeedback d
  INNER JOIN mdl_course c ON d.course_id=c.id
  INNER JOIN mdl_enrolment e ON d.userid=e.userid AND d.course_id=e.courseid
  LEFT JOIN mdl_student_ratingresponse r ON d.userid=r.userid AND d.course_id=r.course_id
  WHERE d.userid=$USER->id
  ORDER BY e.semester, c.fullname");
if (empty($discussionfeedbacks)) {
  $discussionfeedbacks = array();
}

$table = new html_table();

$table->head = array(
  'Semester',
  'Module',
  'Referred to resources in the topics',
  'Included critical approach to information',
  'Provided references in an appropriate format',
  'Free text',
  'Your reflection: What skills do I need to improve?',
  'Your reflection: What will I do to improve my academic skills? (and when?)',
  'Your reflection: What will I do differently when I prepare a discussion post?',
  );

foreach ($discussionfeedbacks as $discussionfeedback) {
  $rowdata = array();

  $rowdata[] = htmlspecialchars($discussionfeedback->semester, ENT_COMPAT, 'UTF-8');

  $rowdata[] = htmlspecialchars($discussionfeedback->fullname, ENT_COMPAT, 'UTF-8');

  $assessmentname['10'] = 'Yes';
  $assessmentname['20'] = 'No';
  $assessmentname['30'] = 'Could be improved';
  $assessmentname['40'] = 'Not applicable';

  $rowdata[] =  $assessmentname[$discussionfeedback->refered_to_resources];
  $rowdata[] =  $assessmentname[$discussionfeedback->critical_approach];
  $rowdata[] =  $assessmentname[$discussionfeedback->provided_references];

  $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->assessment_text));

  if ($discussionfeedback->rating_submitted) {
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->what_skills_need_to_improve));
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->what_do_to_improve_academic_skills));
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->what_do_differently_when_prepare_post));
  }
  else {
    $linktoform = '<a href="http://courses.peoples-uni.org/course/ratingresponse.php?course_id=' . $discussionfeedback->course_id . '">Click here to add your reflections</a>';
    $rowdata[] = $linktoform;
    $rowdata[] = $linktoform;
    $rowdata[] = $linktoform;
  }

  $table->data[] = $rowdata;
}
echo html_writer::table($table);

echo '<br /><a href="http://courses.peoples-uni.org/">Click here to return to Moodle</a>';


echo $OUTPUT->footer();
?>