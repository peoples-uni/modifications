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

  $dissertation = new stdClass();
  $dissertation->userid  = $userid;
  $dissertation->datesubmitted  = time();

  $semesters = $DB->get_records_sql("
    SELECT d.id, d.semester
    FROM mdl_semesters d
    ORDER BY d.id DESC");
  foreach ($semesters as $semester) {
    if (empty($dissertation->semester)) {
      $found = preg_match('/^Starting (.{3,3}).* ([0-9]+)/', $semester->semester, $matches);
      if ($found) {
        if ($matches[1] === 'Jan' || $matches[1] === 'Feb' || $matches[1] === 'Mar' || $matches[1] === 'Apr' || $matches[1] === 'May' || $matches[1] === 'Jun') {
          $dissertation_semester = $matches[2] . 'a';
        }
        else {
          $dissertation_semester = $matches[2] . 'b';
        }
      }
      else {
        $dissertation_semester = '';
      }
      $dissertation->semester = $dissertation_semester;
    }
  }

  $dataitem = $data->dissertation;
  if (empty($dataitem)) $dataitem = '';
  $dissertation->dissertation = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $DB->insert_record('peoplesdissertation', $dissertation);

  $message  = "Thank you for your dissertation submission.\n";
  $message .= "\n";
  $message .= "We strongly advise students who did not previously enrol and pass the\n";
  $message .= "epidemiology module (at Pu or equivalent) to learn about research\n";
  $message .= "methodology in public health.\n";
  $message .= "There are numerous excellent resources available for free;\n";
  $message .= "for example the WHO book \"Basic Epidemiology\" by Bonita,\n";
  $message .= "Beaglehole and Kjellstroem:\n";
  $message .= "http://apps.who.int/bookorders/anglais/detart1.jsp?codlan=1&codcol=80&codcch=18\n";
  $message .= "\n";
  $message .= "The website from Boston University provides their entire epidemiology\n";
  $message .= "and biostatistics modules:\n";
  $message .= "http://sphweb.bumc.bu.edu/otlt/MPH-Modules/Modules_Menu.html\n";
  $message .= "\n";
  $message .= "Even if you have taken epidemiology as Pu modules, you may want to\n";
  $message .= "refresh your skills before you start the next semester,\n";
  $message .= "by looking at the Dissertation section on the Students Corner.\n";
  $message .= "\n";
  $message .= "The Epidemiology:\n";
  $message .= "http://courses.peoples-uni.org/mod/url/view.php?id=11948\n";
  $message .= "\n";
  $message .= "Evidence-based practice:\n";
  $message .= "http://courses.peoples-uni.org/mod/url/view.php?id=11949\n";
  $message .= "\n";
  $message .= "General public health:\n";
  $message .= "http://ssc.bibalex.org/classification/list.jsf?aid=F749A4C0BC3130E62DF0AF5E593F2979\n";
  $message .= "\n";
  $message .= "and Biostatistics resources:\n";
  $message .= "http://courses.peoples-uni.org/pluginfile.php/20079/mod_resource/content/1/Basics%20of%20Biostatistics.pdf\n";
  $message .= "\n";
  $message .= "are all very helpful and you are more likely to be successful with your\n";
  $message .= "dissertation if you spend time studying these resources.\n";
  $message .= "\n";
  $message .= "Details of Submission...\n\n";
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
  $user->id = 999999999; $user->username = 'none';
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->email = 'apply@peoples-uni.org';
  $supportuser->firstname = "People's Open Access Education Initiative: Peoples-uni";
  $supportuser->lastname = '';
  $supportuser->firstnamephonetic = NULL;
  $supportuser->lastnamephonetic = NULL;
  $supportuser->middlename = NULL;
  $supportuser->alternatename = NULL;
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  //$user->email = 'applicationresponses@peoples-uni.org';
  //$user->email = 'alanabarrett0@gmail.com';
  //email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}
