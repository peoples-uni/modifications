<?php

/**
 * Registration form for Peoples-uni Students (to be used by Tech Support)
 * registration_manual.php
 */

require_once('../config.php');
require_once('registration_manual_form.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/registration_manual.php');


$editform = new registration_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $application = new stdClass();

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

  redirect(new moodle_url($CFG->wwwroot . '/course/registration_form_success.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Registration Form");
$PAGE->set_heading('Peoples-uni Registration Form');

echo $OUTPUT->header();

$editform->display();

echo $OUTPUT->footer();
