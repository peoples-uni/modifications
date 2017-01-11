<?php

/**
 * Tutor Registration form for Peoples-uni for New Tutors (who have existing Moodle Account)
 */

require_once('../config.php');
require_once('tutor_registration_existing_form.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/tutor_registration_existing.php');


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
  $SESSION->wantsurl = "$CFG->wwwroot/course/tutor_registration_existing.php";
  notice('<br /><br /><b>You have not logged in. Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}

$application = $DB->get_record('peoples_tutor_registration', array('userid' => $userid));
if (!empty($application)) {
  echo '<h1>You have already volunteered, no need to fill in form again!<br />
  For inquiries about volunteering please send an email to <a href="mailto:contact@peoples-uni.org?subject=Volunteering query">contact@peoples-uni.org</a></h1>';
  die();
}


$editform = new tutor_registration_existing_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $application = new stdClass();

  $application->datesubmitted = time();

  $application->state = 1;

  $application->userid = $USER->id;

  $application->volunteertype = ''; // Ensure set to default...
  $application->modulesofinterest = '';
  $application->notes = '';

  $application->username = $userrecord->username;
  $application->lastname = $userrecord->lastname;
  $application->firstname = $userrecord->firstname;

  $application->gender = '';
  $prof = $DB->get_record('user_info_field', array('shortname' => 'gender'));
  if (!empty($prof->id)) $genderid = $prof->id;
  if ($genderid) {
    $user_info_data = $DB->get_record('user_info_data', array('userid' => $application->userid, 'fieldid' => $genderid));
    if (!empty($user_info_data->data)) {
      $application->gender = $user_info_data->data;
    }
  }

  $application->email = $userrecord->email;
  $application->city = $userrecord->city;
  $application->country = $userrecord->country;
  $application->datefirstapproved = $userrecord->timecreated;
  $application->datelastapproved = $userrecord->timecreated;
  $application->hidden = 0;

  $dataitem = $data->reasons;
  if (empty($dataitem)) $dataitem = '';
  $application->reasons = $dataitem;

  $dataitem = $data->education;
  if (empty($dataitem)) $dataitem = '';
  $application->education = $dataitem;

  $dataitem = $data->tutoringexperience;
  if (empty($dataitem)) $dataitem = '';
  $application->tutoringexperience = $dataitem;

  $dataitem = $data->currentjob;
  if (empty($dataitem)) $dataitem = '';
  $application->currentjob = $dataitem;

  $dataitem = $data->currentrole;
  if (empty($dataitem)) $dataitem = '';
  $application->currentrole = $dataitem;

  $dataitem = $data->otherinformation;
  if (empty($dataitem)) $dataitem = '';
  $application->otherinformation = $dataitem;

  $dataitem = $data->howfoundpeoples;
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $application->howfoundpeoples = $dataitem;

  $dataitem = $data->howfoundorganisationname;
  if (empty($dataitem)) $dataitem = '';
  $application->howfoundorganisationname = $dataitem;

  $DB->insert_record('peoples_tutor_registration', $application);


  $message  = "Tutor Registration request (existing account) for...\n\n";
  $message .= "Family Name: $application->lastname\n\n";
  $message .= "First Name: $application->firstname\n\n";
  $message .= "Gender: $application->gender\n\n";
  $message .= "e-mail: $application->email\n\n";
  $message .= "City: $application->city\n\n";
  $countryname = get_string_manager()->get_list_of_countries(false);
  $message .= "Country: " . $countryname[$application->country] . "\n\n";
  $message .= "Date Submitted: " . gmdate('d/m/Y H:i', $application->datesubmitted) . "\n\n";
  $message .= "Username: $application->username\n\n";
  $message .= "Reasons for wanting to volunteer for Peoples-uni:\n" . $application->reasons . "\n\n";
  $message .= "Relevant qualifications:\n" . $application->education . "\n\n";
  $message .= "Educational/tutoring experience:\n" . $application->tutoringexperience . "\n\n";
  $message .= "Current employer:\n" . $application->currentjob . "\n\n";
  $message .= "Current role:\n" . $application->currentrole . "\n\n";
  $message .= "Other information:\n" . $application->otherinformation . "\n\n";

    $howfoundpeoplesname[  ''] = 'Select...';
    $howfoundpeoplesname['10'] = 'Informed by another Peoples-uni student or tutor';
    $howfoundpeoplesname['20'] = 'Informed by someone else';
    $howfoundpeoplesname['30'] = 'Facebook';
    $howfoundpeoplesname['40'] = 'Internet advertisement';
    $howfoundpeoplesname['50'] = 'Link from another website or discussion forum';
    $howfoundpeoplesname['60'] = 'I used a search engine to look for courses, volunteering opportunities or other';
    $howfoundpeoplesname['70'] = 'Referral from Partnership Institution';
    $howfoundpeoplesname['80'] = 'Read or heard about from news article, journal or advertisement';
  $message .= "How heard about Peoples-uni: " . $howfoundpeoplesname[$application->howfoundpeoples] . "\n\n";

  $message .= "Name of the organisation or person:\n" . $application->howfoundorganisationname . "\n";

  sendapprovedmail($application->email, "Peoples-uni Tutor Registration request Form Submission From: $application->lastname, $application->firstname", $message);
  // This makes it easier for the Help Desk to work with the volunteer because the e-mail comes from them...
  sendapprovedmail_from_applicant('volunteer@peoples-uni.org', $application, "Peoples-uni Tutor Registration request Form Submission From: $application->lastname, $application->firstname", $message);

  redirect(new moodle_url($CFG->wwwroot . '/course/tutor_registration_form_success.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Tutor Registration Form");
$PAGE->set_heading('Peoples-uni Tutor Registration Form');

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
  $supportuser->email = 'volunteer@peoples-uni.org';
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


function sendapprovedmail_from_applicant($email, $application, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999; $user->username = 'none';
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->email = $application->email;
  $supportuser->firstname = $application->firstname;
  $supportuser->lastname = $application->lastname;
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