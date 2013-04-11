<?php

/**
 * Manage "Peoples-uni Record Files" for a Student.
 *
 */

require('../config.php');
require_once("$CFG->dirroot/course/peoples_user_files_form.php");
require_once("$CFG->dirroot/repository/lib.php");

require_login();
if (isguestuser()) {
  die();
}

$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
if (empty($returnurl)) {
  $returnurl = new moodle_url('/course/peoples_files.php');
}

// Access to applications.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/peoples_files.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_title('Manage Peoples-uni Record Files for a Student');
$PAGE->set_heading('Manage Peoples-uni Record Files for a Student');
$PAGE->set_pagelayout('mydashboard');
//$PAGE->set_pagetype('user-files');

$data = new stdClass();
$data->returnurl = $returnurl;

$options = array('subdirs' => 1, 'maxbytes' => 0, 'maxfiles' => -1, 'accepted_types' => '*', 'areamaxbytes' => FILE_AREA_MAX_BYTES_UNLIMITED);

$student_id = optional_param('student_id', -1, PARAM_INT);
$student = $DB->get_record('user', array('id' => $student_id));
if (empty($student)) {
  die();
}
$context = context_user::instance($student_id);

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
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
