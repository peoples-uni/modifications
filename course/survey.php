<?php

/**
 * Survey form for Peoples-uni
 */

/*
CREATE TABLE mdl_peoples_survey (
  id BIGINT(10) unsigned NOT NULL auto_increment,
  datesubmitted BIGINT(10) unsigned NOT NULL DEFAULT 0,
  state BIGINT(10) unsigned NOT NULL DEFAULT 0,
  userid BIGINT(10) unsigned NOT NULL DEFAULT 0,

  deliver_university VARCHAR(20) NOT NULL DEFAULT '',
  deliver_local_ngo VARCHAR(20) NOT NULL DEFAULT '',
  deliver_national_ngo VARCHAR(20) NOT NULL DEFAULT '',
  deliver_international_ngo VARCHAR(20) NOT NULL DEFAULT '',
  deliver_professional_bodies VARCHAR(20) NOT NULL DEFAULT '',
  deliver_other VARCHAR(20) NOT NULL DEFAULT '',
  deliver_body VARCHAR(255) NOT NULL DEFAULT '',
  deliver_diversify VARCHAR(20) NOT NULL DEFAULT '',
  deliver_research VARCHAR(20) NOT NULL DEFAULT '',
  deliver_trainers VARCHAR(20) NOT NULL DEFAULT '',
  deliver_materials VARCHAR(20) NOT NULL DEFAULT '',
  deliver_network VARCHAR(20) NOT NULL DEFAULT '',
  deliver_students VARCHAR(20) NOT NULL DEFAULT '',
  deliver_tutors VARCHAR(20) NOT NULL DEFAULT '',
  deliver_pastoral VARCHAR(20) NOT NULL DEFAULT '',
  deliver_other VARCHAR(20) NOT NULL DEFAULT '',

  fund_national_governments VARCHAR(20) NOT NULL DEFAULT '',
  fund_local_governments VARCHAR(20) NOT NULL DEFAULT '',
  fund_local_ngo VARCHAR(20) NOT NULL DEFAULT '',
  fund_national_ngo VARCHAR(20) NOT NULL DEFAULT '',
  fund_international_ngo VARCHAR(20) NOT NULL DEFAULT '',
  fund_body VARCHAR(255) NOT NULL DEFAULT '',

  care_national_governments VARCHAR(20) NOT NULL DEFAULT '',
  care_local_governments VARCHAR(20) NOT NULL DEFAULT '',
  care_local_ngo VARCHAR(20) NOT NULL DEFAULT '',
  care_national_ngo VARCHAR(20) NOT NULL DEFAULT '',
  care_international_ngo VARCHAR(20) NOT NULL DEFAULT '',
  care_body VARCHAR(255) NOT NULL DEFAULT '',
  care_practice VARCHAR(20) NOT NULL DEFAULT '',
  care_routes VARCHAR(20) NOT NULL DEFAULT '',
  care_materials VARCHAR(20) NOT NULL DEFAULT '',
  care_cost VARCHAR(20) NOT NULL DEFAULT '',
  care_other VARCHAR(20) NOT NULL DEFAULT '',

  CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoples_survey_uid_ix ON mdl_peoples_survey (userid);
*/


require_once('../config.php');
require_once('survey_form.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/survey.php');

require_login();

$editform = new survey_form(NULL, array('customdata' => array()));
if ($editform->is_cancelled()) {
  redirect(new moodle_url('http://peoples-uni.org'));
}
elseif ($data = $editform->get_data()) {

  $application = new object();

  $application->userid = 0;

  $application->state = 0;

  $application->datesubmitted = time();


TEXT ALL
'select', 'deliver_university', 'University', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'deliver_local_ngo', 'Local NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'deliver_national_ngo', 'National NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'deliver_international_ngo', 'International NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'deliver_professional_bodies', 'Professional Body', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'deliver_other', 'Other', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'text', 'deliver_body', 'Names of Bodies Indicated Above', 'maxlength="255" size="50"');

Yes/''
'checkbox', 'deliver_diversify', "Diversify the organisation’s range of training delivery routes");
'checkbox', 'deliver_research', "Provide opportunities for international research");
'checkbox', 'deliver_trainers', "Provide high quality, accredited training opportunities for trainers");
'checkbox', 'deliver_materials', "Provide access to high standard training materials");
'checkbox', 'deliver_network', "Provide access to international professional network (via web platform)");
'checkbox', 'deliver_students', "Attract students to Peoples-uni");
'checkbox', 'deliver_tutors', "Attract tutors to Peoples-uni");
'checkbox', 'deliver_pastoral', "Provide pastoral support");
'checkbox', 'deliver_other', "Other");

'select', 'fund_national_governments', 'National governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'fund_local_governments', 'Local governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'fund_local_ngo', 'Local NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'fund_national_ngo', 'National NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'fund_international_ngo', 'International NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'text', 'fund_body', 'Names of Bodies Indicated Above', 'maxlength="255" size="50"');

'select', 'care_national_governments', 'National governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'care_local_governments', 'Local governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'care_local_ngo', 'Local NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'care_national_ngo', 'National NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'select', 'care_international_ngo', 'International NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
'text', 'care_body', 'Names of Bodies Indicated Above', 'maxlength="255" size="50"');

'checkbox', 'care_practice', "Support students to put what they learnt into practice");
'checkbox', 'care_routes', "Diversify their range of training delivery routes");
'checkbox', 'care_materials', "Provide access to high standard training materials");
'checkbox', 'care_cost', "provide low cost training");
'checkbox', 'care_other', "Other");


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
  $dataitem = mb_substr($dataitem, 0, 20, 'UTF-8');
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

  $dataitem = $data->education;
  if (empty($dataitem)) $dataitem = '';
  $application->education = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->reasons;
  $application->reasons = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

  $dataitem = $data->sponsoringorganisation;
  if (empty($dataitem)) $dataitem = '';
  $application->sponsoringorganisation = htmlspecialchars($dataitem, ENT_COMPAT, 'UTF-8');

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

  $DB->insert_record('peoples_survey', $application);

  redirect(new moodle_url($CFG->wwwroot . '/course/survey_form_success.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Survey Form");
$PAGE->set_heading('Peoples-uni Survey Form');

echo $OUTPUT->header();

$editform->display();

echo $OUTPUT->footer();
