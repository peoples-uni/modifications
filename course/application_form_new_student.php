<?php

/**
 * Application form for Peoples-uni for New Students
 */

require_once('../config.php');
//require_once('lib.php');
require_once('application_form_new_student_form.php');

$PAGE->set_pagelayout('embedded');
$PAGE->set_url('/course/application_form_new_student.php');

$editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes'=>$CFG->maxbytes, 'trusttext'=>false, 'noclean'=>true);
$editform = new application_form_new_student_form(NULL, array('editoroptions'=>$editoroptions, 'returnto'=>0));
if ($editform->is_cancelled()) {
  switch ($returnto) {
    case 'category':
      $url = new moodle_url($CFG->wwwroot.'/course/category.php', array('id'=>$categoryid));
      break;
    default:
      $url = new moodle_url('http://courses.peoples-uni.org');
      break;
  }
  redirect($url);
}
elseif ($data = $editform->get_data()) {
  switch ($returnto) {
    case 'category':
      $url = new moodle_url($CFG->wwwroot.'/course/category.php', array('id'=>$categoryid));
      break;
    default:
      $url = new moodle_url('http://courses.peoples-uni.org');
      break;
  }
  redirect($url);
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Application Form");
$PAGE->set_heading('Peoples-uni Course Application form for New Students');

echo $OUTPUT->header();
echo $OUTPUT->heading('Peoples-uni Course Application form for New Students');

$editform->display();

echo $OUTPUT->footer();
