<?php

/**
 * Manage "Peoples-uni Record Files" for a Student.
 *
 */

require('../config.php');
require_once("$CFG->dirroot/course/peoples_user_files_form.php");
require_once("$CFG->dirroot/repository/lib.php");

$student_id = optional_param('student_id', -1, PARAM_INT);

require_login();
if (isguestuser()) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/peoples_files.php?student_id=$student_id";
  notice('<br /><br /><b>You must be logged in to do this! Please Click "Continue" below, and then log in with your username and password above!</b><br /><br /><br />', "$CFG->wwwroot/");
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
if (empty($returnurl)) {
  $returnurl = new moodle_url('/course/peoples_files.php', array('student_id' => $student_id));
}
else {
  $parts = parse_url($returnurl);
  $query = $parts['query'];
  $parms = array();
  parse_str($query, $parms);
  $student_id = (int)($parms['student_id']);
}

// Access to applications.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
//require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));
$is_manager = has_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/peoples_files.php', array('student_id' => $student_id));
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_title('Peoples-uni Record Files for a Student');
$PAGE->set_heading('Peoples-uni Record Files for a Student');
$PAGE->set_pagelayout('mydashboard');
//$PAGE->set_pagetype('user-files');

$data = new stdClass();
$data->returnurl = $returnurl;

if ($is_manager) {
  $options = array('subdirs' => 1, 'maxbytes' => 0, 'maxfiles' => -1, 'accepted_types' => '*', 'areamaxbytes' => -1, 'is_manager' => TRUE);
}
else {
  $options = array('subdirs' => 0, 'maxbytes' => 1, 'maxfiles' => 0, 'accepted_types' => '', 'areamaxbytes' => 0, 'is_manager' => FALSE);
}

$student = $DB->get_record('user', array('id' => $student_id));
if (empty($student)) {
  echo '<h2>No student_id was specified!</h2>';
  die();
}
$context = context_user::instance($student_id);

if (!$is_manager && ($USER->id != $student_id)) {
  echo '<h2>You can only look at your own files!</h2>';
  die();
}


//function file_prepare_standard_filemanager($data, $field[in form], array $options, $context=null, $component=null, $filearea=null, $itemid=null) {...}
file_prepare_standard_filemanager($data, 'files', $options, $context, 'peoples_record', 'student', 0);

$mform = new peoples_user_files_form(NULL, array('data' => $data, 'options' => $options));

if ($mform->is_cancelled()) {
  redirect($returnurl);
}
elseif ($formdata = $mform->get_data()) {
  $formdata = file_postupdate_standard_filemanager($formdata, 'files', $options, $context, 'peoples_record', 'student', 0);
  redirect($returnurl);
}

echo $OUTPUT->header();
echo $OUTPUT->box_start('generalbox');

echo "<br /><h2>Peoples-uni Record Files for $student->lastname, $student->firstname ($student->id)</h2><br />";

$mform->display();

if (!$is_manager) {
  echo '<br /><br /><br /><strong><a href="javascript:window.close();">Close Window</a></strong><br />';
}

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
