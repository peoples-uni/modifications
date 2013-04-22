<?php

/**
 * Discussion Feedback Form RESET
 */

require_once('../config.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/discussionfeedback_reset.php');


$isteacher = is_peoples_teacher();
//$islurker = has_capability('moodle/course:view', get_context_instance(CONTEXT_SYSTEM));
$islurker = FALSE;
if (!$isteacher && !$islurker) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/discussionfeedback.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}


unset($_SESSION['peoples_course_id_for_discussion_feedback']);

redirect(new moodle_url("$CFG->wwwroot/course/discussionfeedback.php"));


function is_peoples_teacher() {
  global $USER;
  global $DB;

  $teachers = $DB->get_records_sql("
    SELECT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors', 'edu_officer', 'edu_officer_old') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>