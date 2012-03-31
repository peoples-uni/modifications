<?php

/**
 * Survey form for Peoples-uni
 */

/*
CREATE TABLE mdl_peoples_survey (
  id BIGINT(10) unsigned NOT NULL auto_increment,
  survey_name VARCHAR(255) NOT NULL DEFAULT '',
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
  deliver_other_benefit VARCHAR(20) NOT NULL DEFAULT '',

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
  hidden BIGINT(10) unsigned NOT NULL DEFAULT 0,

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
elseif ($survey = $editform->get_data()) {

  $survey->survey_name = '2012 Spring';

  $survey->userid = $USER->id;

  $survey->state = 0;

  $survey->datesubmitted = time();

  $survey->deliver_body = htmlspecialchars($survey->deliver_body, ENT_COMPAT, 'UTF-8');

  if (!empty(survey->deliver_diversify)) survey->deliver_diversify = 'Yes';
  if (!empty(survey->deliver_research)) survey->deliver_research = 'Yes';
  if (!empty(survey->deliver_trainers)) survey->deliver_trainers = 'Yes';
  if (!empty(survey->deliver_materials)) survey->deliver_materials = 'Yes';
  if (!empty(survey->deliver_network)) survey->deliver_network = 'Yes';
  if (!empty(survey->deliver_students)) survey->deliver_students = 'Yes';
  if (!empty(survey->deliver_tutors)) survey->deliver_tutors = 'Yes';
  if (!empty(survey->deliver_pastoral)) survey->deliver_pastoral = 'Yes';
  if (!empty(survey->deliver_other_benefit)) survey->deliver_other_benefit = 'Yes';

  $survey->fund_body = htmlspecialchars($survey->fund_body, ENT_COMPAT, 'UTF-8');

  $survey->care_body = htmlspecialchars($survey->care_body, ENT_COMPAT, 'UTF-8');

  if (!empty(survey->care_practice)) survey->care_practice = 'Yes';
  if (!empty(survey->care_routes)) survey->care_routes = 'Yes';
  if (!empty(survey->care_materials)) survey->care_materials = 'Yes';
  if (!empty(survey->care_cost)) survey->care_cost = 'Yes';
  if (!empty(survey->care_other)) survey->care_other = 'Yes';

  $DB->insert_record('peoples_survey', $survey);

  redirect(new moodle_url($CFG->wwwroot . '/course/survey_form_success.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Survey Form");
$PAGE->set_heading('Peoples-uni Survey Form');

echo $OUTPUT->header();

$editform->display();

echo $OUTPUT->footer();
