<?php

/**
 * Registration form for Peoples-uni for New Students
 */

/*
CREATE TABLE mdl_peoplesregistration (
  id BIGINT(10) unsigned NOT NULL auto_increment,
  datesubmitted BIGINT(10) unsigned NOT NULL DEFAULT 0,
  state BIGINT(10) unsigned NOT NULL,
  userid BIGINT(10) unsigned NOT NULL DEFAULT 0,
  username VARCHAR(100) NOT NULL DEFAULT '',
  firstname VARCHAR(100) NOT NULL DEFAULT '',
  lastname VARCHAR(100) NOT NULL DEFAULT '',
  email VARCHAR(100) NOT NULL DEFAULT '',
  city VARCHAR(120) NOT NULL DEFAULT '',
  country VARCHAR(2) NOT NULL DEFAULT '',
  qualification BIGINT(10) unsigned NOT NULL DEFAULT 0,
  higherqualification BIGINT(10) unsigned NOT NULL DEFAULT 0,
  employment BIGINT(10) unsigned NOT NULL DEFAULT 0,
  howfoundpeoples BIGINT(10) unsigned NOT NULL DEFAULT 0,
  howfoundorganisationname TEXT,
  dobday VARCHAR(2) NOT NULL DEFAULT '',
  dobmonth VARCHAR(2) NOT NULL DEFAULT '',
  dobyear VARCHAR(4) NOT NULL DEFAULT '',
  gender VARCHAR(6) NOT NULL DEFAULT '',
  applicationaddress text NOT NULL,
  currentjob text NOT NULL,
  education text NOT NULL,
  reasons text NOT NULL,
  whatlearn VARCHAR(100) NOT NULL DEFAULT '',
  whylearn VARCHAR(100) NOT NULL DEFAULT '',
  whyelearning VARCHAR(100) NOT NULL DEFAULT '',
  howuselearning VARCHAR(100) NOT NULL DEFAULT '',
  sponsoringorganisation text NOT NULL DEFAULT '',
  datefirstapproved BIGINT(10) unsigned NOT NULL DEFAULT 0,
  datelastapproved BIGINT(10) unsigned NOT NULL DEFAULT 0,
  hidden TINYINT(2) unsigned NOT NULL DEFAULT 0,
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplesregistration_uid_ix ON mdl_peoplesregistration (userid);

ALTER TABLE mdl_peoplesregistration ADD howfoundorganisationname TEXT AFTER howfoundpeoples;
UPDATE mdl_peoplesregistration SET howfoundorganisationname='';

ALTER TABLE mdl_peoplesregistration ADD whatlearn VARCHAR(100) NOT NULL DEFAULT '' AFTER reasons;
ALTER TABLE mdl_peoplesregistration ADD whylearn VARCHAR(100) NOT NULL DEFAULT '' AFTER whatlearn;
ALTER TABLE mdl_peoplesregistration ADD whyelearning VARCHAR(100) NOT NULL DEFAULT '' AFTER whylearn;
ALTER TABLE mdl_peoplesregistration ADD howuselearning VARCHAR(100) NOT NULL DEFAULT '' AFTER whyelearning;

ALTER TABLE mdl_peoplesregistration MODIFY city VARCHAR(120) NOT NULL DEFAULT '';
*/


require_once('../config.php');
require_once('registration_form.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/registration.php');


$editform = new registration_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $application = new object();

  $application->userid = 0;

  $application->state = 0;

  $application->datesubmitted = time();

  // Some of the data cleaning done may be obsolete as the Moodle Form can do it now
  $dataitem = $data->lastname;
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->lastname = $dataitem;

  $dataitem = $data->firstname;
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->firstname = $dataitem;

  $dataitem = $data->email;
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->email = $dataitem;

  $dataitem = $data->gender;
  $application->gender = $dataitem;

  $dataitem = $data->dobyear;
  $application->dobyear = $dataitem;

  $dataitem = $data->dobmonth;
  $application->dobmonth = $dataitem;

  $dataitem = $data->dobday;
  $application->dobday = $dataitem;

  $dataitem = $data->applicationaddress;
  $application->applicationaddress = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->city;
  $dataitem = trim(strip_tags($dataitem));
  $dataitem = mb_substr($dataitem, 0, 120, 'UTF-8');
  $application->city = $dataitem;

  $dataitem = $data->country;
  $dataitem = trim(strip_tags($dataitem));
  // (Drupal select fields are protected by Drupal Form API)
  $application->country = $dataitem;

  $dataitem = $data->employment;
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $application->employment = $dataitem;

  $dataitem = $data->currentjob;
  if (empty($dataitem)) $dataitem = '';
  $application->currentjob = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->qualification;
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $application->qualification = $dataitem;

  $dataitem = $data->higherqualification;
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $application->higherqualification = $dataitem;

  $dataitem = $data->howfoundpeoples;
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $application->howfoundpeoples = $dataitem;

  $dataitem = $data->howfoundorganisationname;
  if (empty($dataitem)) $dataitem = '';
  $application->howfoundorganisationname = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->education;
  if (empty($dataitem)) $dataitem = '';
  $application->education = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->reasons;
  $application->reasons = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->whatlearn;
  $arraystring = '';
  foreach ($dataitem as $datax) {
    $datax = (int)$datax;
    $arraystring .= $datax . ',';
  }
  $application->whatlearn = $arraystring;

  $dataitem = $data->whylearn;
  $arraystring = '';
  foreach ($dataitem as $datax) {
    $datax = (int)$datax;
    $arraystring .= $datax . ',';
  }
  $application->whylearn = $arraystring;

  $dataitem = $data->whyelearning;
  $arraystring = '';
  foreach ($dataitem as $datax) {
    $datax = (int)$datax;
    $arraystring .= $datax . ',';
  }
  $application->whyelearning = $arraystring;

  $dataitem = $data->howuselearning;
  $arraystring = '';
  foreach ($dataitem as $datax) {
    $datax = (int)$datax;
    $arraystring .= $datax . ',';
  }
  $application->howuselearning = $arraystring;

  $dataitem = $data->sponsoringorganisation;
  if (empty($dataitem)) $dataitem = '';
  $application->sponsoringorganisation = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->username;
  $dataitem = strip_tags($dataitem);
  $dataitem = str_replace("<", '', $dataitem);
  $dataitem = str_replace(">", '', $dataitem);
  $dataitem = str_replace("/", '', $dataitem);
  $dataitem = str_replace("#", '', $dataitem);
  $dataitem = trim(core_text::strtolower($dataitem));
  if (empty($dataitem)) $dataitem = 'user1';  // Just in case it becomes empty
  $dataitem = mb_substr($dataitem, 0, 100, 'UTF-8');
  $application->username = $dataitem;

  $DB->insert_record('peoplesregistration', $application);


  $message  = "Registration request for...\n\n";
  $message .= "Family Name: $application->lastname\n\n";
  $message .= "First Name: $application->firstname\n\n";
  $message .= "e-mail: $application->email\n\n";
  $message .= "Date Submitted: " . gmdate('d/m/Y H:i', $application->datesubmitted) . "\n\n";
  $message .= "Date of Birth: $application->dobday/$application->dobmonth/$application->dobyear\n\n";
  $message .= "Gender: $application->gender\n\n";
  $message .= "Application Address:\n" . htmlspecialchars_decode($application->applicationaddress, ENT_COMPAT) . "\n\n";
  $message .= "City: $application->city\n\n";
  $countryname = get_string_manager()->get_list_of_countries(false);
  $message .= "Country: " . $countryname[$application->country] . "\n\n";
  $message .= "Preferred Username: $application->username\n\n";
  $message .= "Reasons for wanting to enrol:\n" . htmlspecialchars_decode($application->reasons, ENT_COMPAT) . "\n\n";

    $whatlearnname['10'] = 'I want to improve my knowledge of public health';
    $whatlearnname['20'] = 'I want to improve my academic skills';
    $whatlearnname['30'] = 'I want to improve my skills in research';
    $whatlearnname['40'] = 'I am not sure';
  $message .= "What do you want to learn:\n";
  $arrayvalues = explode(',', $application->whatlearn);
  foreach ($arrayvalues as $v) {
    if (!empty($v)) $message .= $whatlearnname[$v] . "\n";
  }
  $message .= "\n";
    $whylearnname['10'] = 'I want to apply what I learn to my current/future work';
    $whylearnname['20'] = 'I want to improve my career opportunities';
    $whylearnname['30'] = 'I want to get academic credit';
    $whylearnname['40'] = 'I am not sure';
  $message .= "Why do you want to learn:\n";
  $arrayvalues = explode(',', $application->whylearn);
  foreach ($arrayvalues as $v) {
    if (!empty($v)) $message .= $whylearnname[$v] . "\n";
  }
  $message .= "\n";
    $whyelearningname['10'] = 'I want to meet and learn with people from other countries';
    $whyelearningname['20'] = 'I want the opportunity to be flexible about my study time';
    $whyelearningname['30'] = 'I want a public health training that is affordable';
    $whyelearningname['40'] = 'I am not sure';
  $message .= "Reasons you want to do an e-learning course:\n";
  $arrayvalues = explode(',', $application->whyelearning);
  foreach ($arrayvalues as $v) {
    if (!empty($v)) $message .= $whyelearningname[$v] . "\n";
  }
  $message .= "\n";
    $howuselearningname['10'] = 'Share knowledge skills with other colleagues';
    $howuselearningname['20'] = 'Start a new project';
    $howuselearningname['30'] = 'I am not sure';
  $message .= "How will you use your new knowledge and skills to improve population health:\n";
  $arrayvalues = explode(',', $application->howuselearning);
  foreach ($arrayvalues as $v) {
    if (!empty($v)) $message .= $howuselearningname[$v] . "\n";
  }
  $message .= "\n";

  $message .= "Sponsoring organisation:\n" . htmlspecialchars_decode($application->sponsoringorganisation, ENT_COMPAT) . "\n\n";

    $employmentname[  ''] = 'Select...';
    $employmentname[ '1'] = 'None';
    $employmentname['10'] = 'Student';
    $employmentname['20'] = 'Non-health';
    $employmentname['30'] = 'Clinical (not specifically public health)';
    $employmentname['40'] = 'Public health';
    $employmentname['50'] = 'Other health related';
    $employmentname['60'] = 'Academic occupation (e.g. lecturer)';
  $message .= "Current Employment: " . $employmentname[$application->employment] . "\n\n";
    $qualificationname[  ''] = 'Select...';
    $qualificationname[ '1'] = 'None';
    $qualificationname['10'] = 'Degree (not health related)';
    $qualificationname['20'] = 'Health qualification (non-degree)';
    $qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
    $qualificationname['40'] = 'Medical degree';
  $message .= "Higher Education Qualification: " . $qualificationname[$application->qualification] . "\n\n";
    $higherqualificationname[  ''] = 'Select...';
    $higherqualificationname[ '1'] = 'None';
    $higherqualificationname['10'] = 'Certificate';
    $higherqualificationname['20'] = 'Diploma';
    $higherqualificationname['30'] = 'Masters';
    $higherqualificationname['40'] = 'Ph.D.';
    $higherqualificationname['50'] = 'Other';
  $message .= "Postgraduate Qualification: " . $higherqualificationname[$application->higherqualification] . "\n\n";

  $message .= "Current Employment Details:\n" . htmlspecialchars_decode($application->currentjob, ENT_COMPAT) . "\n\n";
  $message .= "Other relevant qualifications or educational experience:\n" . htmlspecialchars_decode($application->education, ENT_COMPAT) . "\n\n";

    $howfoundpeoplesname[  ''] = 'Select...';
    $howfoundpeoplesname['10'] = 'Informed by another Peoples-uni student';
    $howfoundpeoplesname['20'] = 'Informed by someone else';
    $howfoundpeoplesname['30'] = 'Facebook';
    $howfoundpeoplesname['40'] = 'Internet advertisement';
    $howfoundpeoplesname['50'] = 'Link from another website or discussion forum';
    $howfoundpeoplesname['60'] = 'I used a search engine to look for courses';
    $howfoundpeoplesname['70'] = 'Referral from Partnership Institution';
  $message .= "How heard about Peoples-uni: " . $howfoundpeoplesname[$application->howfoundpeoples] . "\n\n";

  $message .= "Name of the organisation or person:\n" . htmlspecialchars_decode($application->howfoundorganisationname, ENT_COMPAT) . "\n";

  sendapprovedmail($application->email, "Peoples-uni Registration request Form Submission From: $application->lastname, $application->firstname", $message);
  sendapprovedmail('apply@peoples-uni.org', "Peoples-uni Registration request Form Submission From: $application->lastname, $application->firstname", $message);

  redirect(new moodle_url($CFG->wwwroot . '/course/registration_form_success.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Registration Form");
$PAGE->set_heading('Peoples-uni Registration Form');

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