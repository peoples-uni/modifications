<?php
// recordedsubmissionfile.php 20130503
// Serve up a peoples_recordedsubmissions Moodle stored_file to browser

require_once('../config.php');
require_once('../lib/filelib.php');

$relativepath = get_file_argument();
$forcedownload = optional_param('forcedownload', 0, PARAM_BOOL);

if (!$relativepath) {
  send_header_404();
  print_error('invalidargorconf');
}
elseif (strpos($relativepath, '/peoples_recordedsubmissions/student/') === false) {
  send_header_404();
  print_error('invalidargorconf'); // Only allow for peoples_recordedsubmissions files!
}
elseif ($relativepath[0] != '/') {
  send_header_404();
  print_error('pathdoesnotstartslash');
}

require_login();
$isteacher = is_peoples_teacher();
$islurker = has_capability('moodle/grade:viewall', get_context_instance(CONTEXT_SYSTEM));
if (!$isteacher && !$islurker) {
  send_header_404();
  print_error('invalidargorconf');
}

$fs = get_file_storage();

$file = $fs->get_file_by_hash(sha1($relativepath));
if (empty($file) || $file->is_directory()) {
  send_header_404();
  print_error('filenotfound');
}

send_stored_file($file, 86400, 0, true);


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
    SELECT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>
