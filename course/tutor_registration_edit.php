<?php

/**
 * Tutor Registration Edit form for Peoples-uni Tutors
 */

require_once('../config.php');
require_once('tutor_registration_edit_form.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/tutor_registration_edit.php');


require_login();

// Access is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));


$userid = optional_param('id', 0, PARAM_INT);
if (empty($userid)) {echo '<h1>$userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid));(**)verify is a tutor??? YES CHECK THER IS A RECORD... OR NO???
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}


$editform = new tutor_registration_edit_form(NULL, array('customdata' => array('userid' => $userid)));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $application = new object();(**) set id!

  $dataitem = $data->reasons;
  if (empty($dataitem)) $dataitem = '';
  $application->reasons = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->education;
  if (empty($dataitem)) $dataitem = '';
  $application->education = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->tutoringexperience;
  if (empty($dataitem)) $dataitem = '';
  $application->tutoringexperience = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->currentjob;
  if (empty($dataitem)) $dataitem = '';
  $application->currentjob = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->currentrole;
  if (empty($dataitem)) $dataitem = '';
  $application->currentrole = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->otherinformation;
  if (empty($dataitem)) $dataitem = '';
  $application->otherinformation = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->howfoundpeoples;
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $application->howfoundpeoples = $dataitem;

  $dataitem = $data->howfoundorganisationname;
  if (empty($dataitem)) $dataitem = '';
  $application->howfoundorganisationname = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $DB->update_record('peoples_tutor_registration', $application);

  redirect(new moodle_url($CFG->wwwroot . '/course/tutor_registration_form_success.php'));(**)
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Tutor Registration Edit Form");
$PAGE->set_heading('Peoples-uni Tutor Registration Edit Form');

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