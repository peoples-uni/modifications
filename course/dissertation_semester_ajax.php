<?php

// Handles an AJAX Change of Dissertion Semester Post (see course/dissertation_semester.js in course/dissertations.php)

define('AJAX_SCRIPT', true);

require_once('../config.php');


$dissertation = new stdClass;
$dissertation->id = required_param('dissertationid', PARAM_INT);
$dissertation->semester = required_param('dissertationsemester', PARAM_ALPHANUM);


$result = new stdClass;


if( !isloggedin() ){
  $result->error = get_string('sessionerroruser', 'error');
  echo json_encode($result);
  die();
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/dissertation_semester_ajax.php');


$isteacher = is_peoples_teacher();
$islurker = has_capability('moodle/grade:viewall', context_system::instance());
if (!confirm_sesskey() || (!$isteacher && !$islurker)) {
  echo $OUTPUT->header();
  echo 'You are not allowed to this!';
  echo $OUTPUT->footer();
  die();
}


$DB->update_record('peoplesdissertation', $dissertation);


// JSON to return to Client
$result->success = true;

echo json_encode($result);


function is_peoples_teacher() {
  global $USER;
  global $DB;

  /* All Teacher, Teachers...
  SELECT u.lastname, r.name, c.fullname
  FROM mdl_user u, mdl_role_assignments ra, mdl_role r, mdl_context con, mdl_course c
  WHERE
  u.id=ra.userid AND
  ra.roleid=r.id AND
  ra.contextid=con.id AND
  r.name IN ('Teacher', 'Teachers') AND
  con.contextlevel=50 AND
  con.instanceid=c.id ORDER BY c.fullname, r.name;
  */

  $teachers = $DB->get_records_sql("
    SELECT DISTINCT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', context_system::instance())) return true;
  else return false;
}
