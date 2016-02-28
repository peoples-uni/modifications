<?php

/**
 * Accreditation of Prior Learnings Form
 */

require_once('../config.php');
require_once('accreditation_of_prior_learnings_form.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/accreditation_of_prior_learnings.php');


$isteacher = is_peoples_teacher();
//$islurker = has_capability('moodle/course:view', context_system::instance());
$islurker = FALSE;
if (!$isteacher && !$islurker) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/accreditation_of_prior_learnings.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}

$editform = new accreditation_of_prior_learnings_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $accreditation_of_prior_learnings = $DB->get_record('peoples_accreditation_of_prior_learning', array('userid' => $data->student_id));

  if (empty($accreditation_of_prior_learnings)) {
    $accreditation_of_prior_learnings = new object();

    $doinsert = TRUE;
  }
  else {
    $doinsert = FALSE;
  }

  $accreditation_of_prior_learnings->userid = $data->student_id;
  $accreditation_of_prior_learnings->prior_foundation = $data->prior_foundation;
  $accreditation_of_prior_learnings->prior_problems = $data->prior_problems;
  $accreditation_of_prior_learnings->userid_approver = $USER->id;
  $accreditation_of_prior_learnings->datesubmitted = time();

  $dataitem = $data->note;
  if (empty($dataitem)) $dataitem = '';
  $accreditation_of_prior_learnings->note = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  if ($doinsert) {
    $DB->insert_record('peoples_accreditation_of_prior_learning', $accreditation_of_prior_learnings);
  }
  else {
    $DB->update_record('peoples_accreditation_of_prior_learning', $accreditation_of_prior_learnings);
  }

  redirect(new moodle_url($CFG->wwwroot . '/course/accreditation_of_prior_learnings.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Accreditation of Prior Learnings Form");
$PAGE->set_heading('Peoples-uni Accreditation of Prior Learnings Form');

echo $OUTPUT->header();

$editform->display();

echo $OUTPUT->footer();


function is_peoples_teacher() {
  global $USER;
  global $DB;

  $teachers = $DB->get_records_sql("
    SELECT DISTINCT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors', 'edu_officer', 'edu_officer_old') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', context_system::instance())) return true;
  else return false;
}
?>