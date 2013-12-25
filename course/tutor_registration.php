<?php

/**
 * Tutor Registration form for Peoples-uni for New Tutors
 */

/*
CREATE TABLE mdl_peoples_tutor_registration (
  id BIGINT(10) unsigned NOT NULL auto_increment,
  datesubmitted BIGINT(10) unsigned NOT NULL DEFAULT 0,
  state BIGINT(10) unsigned NOT NULL,
  userid BIGINT(10) unsigned NOT NULL DEFAULT 0,
  username VARCHAR(100) NOT NULL DEFAULT '',
  lastname VARCHAR(100) NOT NULL DEFAULT '',
  firstname VARCHAR(100) NOT NULL DEFAULT '',
  gender VARCHAR(6) NOT NULL DEFAULT '',
  email VARCHAR(100) NOT NULL DEFAULT '',
  city VARCHAR(120) NOT NULL DEFAULT '',
  country VARCHAR(2) NOT NULL DEFAULT '',
  reasons text NOT NULL,
  education text NOT NULL,
  tutoringexperience text NOT NULL,
  currentjob text NOT NULL,
  currentrole text NOT NULL,
  otherinformation text NOT NULL,
  howfoundpeoples BIGINT(10) unsigned NOT NULL DEFAULT 0,
  howfoundorganisationname TEXT,
  datefirstapproved BIGINT(10) unsigned NOT NULL DEFAULT 0,
  datelastapproved BIGINT(10) unsigned NOT NULL DEFAULT 0,
  volunteertype VARCHAR(100) NOT NULL DEFAULT '',
  modulesofinterest TEXT NOT NULL DEFAULT '',
  notes TEXT NOT NULL DEFAULT '',
  hidden TINYINT(2) unsigned NOT NULL DEFAULT 0,
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_peoples_tutor_registration_uid_ix ON mdl_peoples_tutor_registration (userid);

ALTER TABLE mdl_peoples_tutor_registration ADD volunteertype VARCHAR(100) NOT NULL DEFAULT '' AFTER datelastapproved;
ALTER TABLE mdl_peoples_tutor_registration ADD modulesofinterest TEXT NOT NULL DEFAULT '' AFTER volunteertype;
ALTER TABLE mdl_peoples_tutor_registration ADD notes TEXT NOT NULL DEFAULT '' AFTER modulesofinterest;

UPDATE mdl_peoples_tutor_registration SET volunteertype='';
UPDATE mdl_peoples_tutor_registration SET modulesofinterest='';
UPDATE mdl_peoples_tutor_registration SET notes='';
*/


require_once('../config.php');
require_once('tutor_registration_form.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/tutor_registration.php');


$editform = new tutor_registration_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $application = new object();

  $application->datesubmitted = time();

  $application->state = 0;

  $application->userid = 0;

  $dataitem = $data->username;
  $dataitem = strip_tags($dataitem);
  $dataitem = str_replace("<", '', $dataitem);
  $dataitem = str_replace(">", '', $dataitem);
  $dataitem = str_replace("/", '', $dataitem);
  $dataitem = str_replace("#", '', $dataitem);
  $dataitem = trim(moodle_strtolower($dataitem));
  if (empty($dataitem)) $dataitem = 'user1';  // Just in case it becomes empty
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->username = $dataitem;

  // Some of the data cleaning done may be obsolete as the Moodle Form can do it now
  $dataitem = $data->lastname;
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->lastname = $dataitem;

  $dataitem = $data->firstname;
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->firstname = $dataitem;

  $dataitem = $data->gender;
  $application->gender = $dataitem;

  $dataitem = $data->email;
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->email = $dataitem;

  $dataitem = $data->city;
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 120, 'UTF-8');
  $application->city = $dataitem;

  $dataitem = $data->country;
  $dataitem = trim(strip_tags($dataitem));
  $application->country = $dataitem;

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

  $DB->insert_record('peoples_tutor_registration', $application);


  $message  = "Tutor Registration request for...\n\n";
  $message .= "Family Name: $application->lastname\n\n";
  $message .= "First Name: $application->firstname\n\n";
  $message .= "Gender: $application->gender\n\n";
  $message .= "e-mail: $application->email\n\n";
  $message .= "City: $application->city\n\n";
  $countryname = get_string_manager()->get_list_of_countries(false);
  $message .= "Country: " . $countryname[$application->country] . "\n\n";
  $message .= "Date Submitted: " . gmdate('d/m/Y H:i', $application->datesubmitted) . "\n\n";
  $message .= "Preferred Username: $application->username\n\n";
  $message .= "Reasons for wanting to volunteer for Peoples-uni:\n" . htmlspecialchars_decode($application->reasons, ENT_COMPAT) . "\n\n";
  $message .= "Relevant qualifications:\n" . htmlspecialchars_decode($application->education, ENT_COMPAT) . "\n\n";
  $message .= "Educational/tutoring experience:\n" . htmlspecialchars_decode($application->tutoringexperience, ENT_COMPAT) . "\n\n";
  $message .= "Current employer:\n" . htmlspecialchars_decode($application->currentjob, ENT_COMPAT) . "\n\n";
  $message .= "Current role:\n" . htmlspecialchars_decode($application->currentrole, ENT_COMPAT) . "\n\n";
  $message .= "Other information:\n" . htmlspecialchars_decode($application->otherinformation, ENT_COMPAT) . "\n\n";

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

  $message .= "Name of the organisation or person:\n" . htmlspecialchars_decode($application->howfoundorganisationname, ENT_COMPAT) . "\n";

  sendapprovedmail($application->email, "Peoples-uni Tutor Registration request Form Submission From: $application->lastname, $application->firstname", $message);
  sendapprovedmail('apply@peoples-uni.org', "Peoples-uni Tutor Registration request Form Submission From: $application->lastname, $application->firstname", $message);

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