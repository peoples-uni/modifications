<?php

/**
 * Discussion Feedback Form (to send e-mail to student and records data also)
 */

/*
CREATE TABLE mdl_discussionfeedback (
  id BIGINT(10) unsigned NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  course_id BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  user_id_submitted BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) unsigned NOT NULL DEFAULT 0,
  refered_to_resources BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  critical_approach BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  provided_references BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  assessment_text TEXT NOT NULL,
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_discussionfeedback_uid_ix ON mdl_discussionfeedback (userid);
CREATE INDEX mdl_discussionfeedback_cid_ix ON mdl_discussionfeedback (course_id);
*/


require_once('../config.php');
require_once('discussionfeedback_form.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/discussionfeedback.php');


$isteacher = is_peoples_teacher();
//$islurker = has_capability('moodle/course:view', get_context_instance(CONTEXT_SYSTEM));
$islurker = FALSE;
if (!$isteacher && !$islurker) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/discussionfeedback.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}

if (empty($_SESSION['peoples_course_id_for_discussion_feedback'])) { // Form required to select Module
  $editform = new discussionfeedback_module_selection_form(NULL, array('customdata' => array()));
  if ($editform->is_cancelled()) {
    redirect(new moodle_url('http://peoples-uni.org'));
  }
  elseif ($data = $editform->get_data()) {

    $dataitem = $data->course_id;
    if (!empty($dataitem) && is_numeric($dataitem)) {
      $_SESSION['peoples_course_id_for_discussion_feedback'] = $data->course_id;
    }

    redirect(new moodle_url($CFG->wwwroot . '/course/discussionfeedback.php'));
  }
}
else { // We already know the module... need Form to to collect criteria for a Student in given Module
  $editform = new discussionfeedback_form(NULL, array('customdata' => array()));
  if ($editform->is_cancelled()) {
    redirect(new moodle_url('http://peoples-uni.org'));
  }
  elseif ($data = $editform->get_data()) {

    $discussionfeedback = $DB->get_record('discussionfeedback', array('course_id' => $_SESSION['peoples_course_id_for_discussion_feedback'], 'userid' => $data->student_id));

    if (empty($discussionfeedback)) {
      $discussionfeedback = new object();

      $doinsert = TRUE;
    }
    else {
      $doinsert = FALSE;
    }

    $discussionfeedback->refered_to_resources = $data->refered_to_resources;
    $discussionfeedback->critical_approach = $data->critical_approach;
    $discussionfeedback->provided_references = $data->provided_references;

    $dataitem = $data->assessment_text;
    if (empty($dataitem)) $dataitem = '';
    $discussionfeedback->assessment_text = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

    $discussionfeedback->course_id = $_SESSION['peoples_course_id_for_discussion_feedback'];
    $discussionfeedback->userid = $data->student_id;
    $discussionfeedback->user_id_submitted = $USER->id;
    $discussionfeedback->datesubmitted = time();

    if ($doinsert) {
      $DB->insert_record('discussionfeedback', $discussionfeedback);
    }
    else {
      $DB->update_record('discussionfeedback', $discussionfeedback);
    }

    $peoples_discussion_feedback_email = get_config(NULL, 'peoples_discussion_feedback_email');
    $peoples_discussion_feedback_email = str_replace("\r", '', $peoples_discussion_feedback_email);

    $userrecord = $DB->get_record('user', array('id' => $discussionfeedback->userid));
    $peoples_discussion_feedback_email = str_replace('GIVEN_NAME_HERE', $userrecord->firstname, $peoples_discussion_feedback_email);

    $assessmentname['10'] = 'Yes';
    $assessmentname['20'] = 'No';
    $assessmentname['30'] = 'Could be improved';
    $refered_to_resources = $discussionfeedback->refered_to_resources;
    $critical_approach = $discussionfeedback->critical_approach;
    $provided_references = $discussionfeedback->provided_references;
    $criteria  = "Referred to resources in the topics: $assessmentname[$refered_to_resources]\n\n";
    $criteria .= "Included critical approach to information: $assessmentname[$critical_approach]\n\n";
    $criteria .= "Provided references in an appropriate format: $assessmentname[$provided_references]\n";
    if (!empty($discussionfeedback->assessment_text)) $criteria .= "\n" . $discussionfeedback->assessment_text . "\n";
    $peoples_discussion_feedback_email = str_replace('DISCUSSION_CRITERIA_HERE', $criteria, $peoples_discussion_feedback_email);

    $peoples_discussion_feedback_email = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $peoples_discussion_feedback_email); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                                                                               // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

    $course = $DB->get_record('course', array('id' => $_SESSION['peoples_course_id_for_discussion_feedback']));
    $student_name = fullname($userrecord);
    sendapprovedmail($userrecord->email, "Peoples-uni Discussion Feedback for $course->fullname ($student_name)", $peoples_discussion_feedback_email);

    redirect(new moodle_url($CFG->wwwroot . '/course/discussionfeedback.php'));
  }
}

// Print the form

$PAGE->set_title("People's Open Access Education Initiative Discussion Feedback Form");
$PAGE->set_heading('Peoples-uni Discussion Feedback Form');

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
  $supportuser->email = 'education@helpdesk.peoples-uni.org';
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

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>