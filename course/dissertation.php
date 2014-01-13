<?php

/**
 * Dissertation Topic Form
 */

/*
CREATE TABLE mdl_peoplesdissertation (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) unsigned NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) unsigned NOT NULL DEFAULT 0,
  semester VARCHAR(255) NOT NULL DEFAULT '',
  dissertation text NOT NULL,
  CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplesdissertation_uid_ix ON mdl_peoplesdissertation (userid);
*/


require_once('../config.php');
require_once('dissertation_form.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/dissertation.php');


require_login();
// (Might possibly be Guest)

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userid = $USER->id;
if (empty($userid)) {echo '<h1>$userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$fullname = fullname($userrecord);

if (empty($fullname) || trim($fullname) == 'Guest User') {
  $SESSION->wantsurl = "$CFG->wwwroot/course/dissertation.php";
  notice('<br /><br /><b>You have not logged in. Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}


$editform = new dissertation_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $dissertation = new object();
  $dissertation->userid  = $userid;
  $dissertation->datesubmitted  = time();

  $semesters = $DB->get_records_sql("
    SELECT DISTINCT d.semester
    FROM mdl_peoplesdissertation d
    ORDER BY d.semester DESC");
  foreach ($semesters as $semester) {
    if (empty($dissertation->semester)) $dissertation->semester = $semester->semester;
  }

  $dataitem = $data->dissertation;
  if (empty($dataitem)) $dataitem = '';
  $dissertation->dissertation = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $DB->insert_record('peoplesdissertation', $dissertation);

  $message  = "Dissertation Submission for...\n\n";
  $message .= "Family Name: $userrecord->lastname\n\n";
  $message .= "First Name: $userrecord->firstname\n\n";
  $message .= "Date Submitted: " . gmdate('d/m/Y H:i', $dissertation->datesubmitted) . "\n\n";
  $message .= "Semester: $dissertation->semester\n\n";
  $message .= "Dissertation:\n" . htmlspecialchars_decode($dissertation->dissertation, ENT_COMPAT) . "\n";

  sendapprovedmail($userrecord->email, "Peoples-uni Dissertation Form Submission From: $userrecord->lastname, $userrecord->firstname", $message);
  sendapprovedmail('apply@peoples-uni.org', "Peoples-uni Dissertation Form Submission From: $userrecord->lastname, $userrecord->firstname", $message);

  redirect(new moodle_url($CFG->wwwroot . '/course/dissertation_form_success.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Dissertation Topic Form");
$PAGE->set_heading('Peoples-uni Dissertation Topic Form');

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
