<?php

require("../config.php");
//require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/course_report.php');

$PAGE->set_pagelayout('embedded');

require_login();

if ($USER->id != 337) { // Debs Thompson
  // Access is given by the "Manager" role which has moodle/site:viewparticipants
  // (administrator also has moodle/site:viewparticipants)
  require_capability('moodle/site:viewparticipants', context_system::instance());
}

$PAGE->set_title('Survey Results');
$PAGE->set_heading('Survey Results');
echo $OUTPUT->header();

echo "<h1>Survey Results</h1>";

$surveys = $DB->get_records_sql('
  SELECT s.*, u.lastname, u.firstname
  FROM mdl_peoples_survey s
  LEFT JOIN mdl_user u ON s.userid=u.id
  WHERE s.hidden=0
  ORDER BY s.datesubmitted DESC');
if (empty($surveys)) {
  $surveys = array();
}

$table = new html_table();

$table->head = array(
  'Submitted',
  'Name',
  'Organisations that deliver public health training...',
  'Organisation -1',
  'Organisation -2',
  'Benefits',
  'Organisations that fund public health training...',
  'Organisation -1',
  'Organisation -2',
  'Organisations that deliver health promotion/health care...',
  'Organisation -1',
  'Organisation -2',
  'Benefits',
);

$n = 0;
foreach ($surveys as $sid => $survey) {
  $rowdata = array();
  $rowdata[] = gmdate('d/m/Y H:i', $survey->datesubmitted);
  $rowdata[] = $survey->lastname . ', ' . $survey->firstname;

  $text = '';
  $text = add_link($text, $survey->deliver_university, 'University');
  $text = add_link($text, $survey->deliver_local_ngo, 'Local NGO');
  $text = add_link($text, $survey->deliver_national_ngo, 'National NGO');
  $text = add_link($text, $survey->deliver_international_ngo, 'International NGO');
  $text = add_link($text, $survey->deliver_professional_bodies, 'Professional Body');
  $text = add_link($text, $survey->deliver_other, 'Other');
  $rowdata[] = $text;

  $rowdata[] = showbody($survey->deliver_body_1, $survey->country_deliver_body_1, $survey->interested_deliver_body_1, $survey->informed_deliver_body_1, $survey->best_way_deliver_body_1);

  $rowdata[] = showbody($survey->deliver_body_2, $survey->country_deliver_body_2, $survey->interested_deliver_body_2, $survey->informed_deliver_body_2, $survey->best_way_deliver_body_2);

  $text = '';
  $text = add_benefit($text, $survey->deliver_diversify, "Training delivery routes");
  $text = add_benefit($text, $survey->deliver_research, "International research");
  $text = add_benefit($text, $survey->deliver_trainers, "Accredited training for trainers");
  $text = add_benefit($text, $survey->deliver_materials, "Training materials");
  $text = add_benefit($text, $survey->deliver_network, "Professional network");
  $text = add_benefit($text, $survey->deliver_students, "Attract students");
  $text = add_benefit($text, $survey->deliver_tutors, "Attract tutors");
  $text = add_benefit($text, $survey->deliver_pastoral, "Pastoral support");
  $text = add_benefit($text, $survey->deliver_other_benefit, "Other");
  $rowdata[] = $text;

  $text = '';
  $text = add_link($text, $survey->fund_national_governments, 'National government');
  $text = add_link($text, $survey->fund_local_governments, 'Local government');
  $text = add_link($text, $survey->fund_local_ngo, 'Local NGO');
  $text = add_link($text, $survey->fund_national_ngo, 'National NGO');
  $text = add_link($text, $survey->fund_international_ngo, 'International NGO');
  $rowdata[] = $text;

  $rowdata[] = showbody($survey->fund_body_1, $survey->country_fund_body_1, $survey->interested_fund_body_1, $survey->informed_fund_body_1, $survey->best_way_fund_body_1);

  $rowdata[] = showbody($survey->fund_body_2, $survey->country_fund_body_2, $survey->interested_fund_body_2, $survey->informed_fund_body_2, $survey->best_way_fund_body_2);

  $text = '';
  $text = add_link($text, $survey->care_national_governments, 'National governments');
  $text = add_link($text, $survey->care_local_governments, 'Local governments');
  $text = add_link($text, $survey->care_local_ngo, 'Local NGO');
  $text = add_link($text, $survey->care_national_ngo, 'National NGO');
  $text = add_link($text, $survey->care_international_ngo, 'International NGO');
  $rowdata[] = $text;

  $rowdata[] = showbody($survey->care_body_1, $survey->country_care_body_1, $survey->interested_care_body_1, $survey->informed_care_body_1, $survey->best_way_care_body_1);

  $rowdata[] = showbody($survey->care_body_2, $survey->country_care_body_2, $survey->interested_care_body_2, $survey->informed_care_body_2, $survey->best_way_care_body_2);

  $text = '';
  $text = add_benefit($text, $survey->care_practice, "Support students to put into practice");
  $text = add_benefit($text, $survey->care_routes, "Training delivery routes");
  $text = add_benefit($text, $survey->care_materials, "Training materials");
  $text = add_benefit($text, $survey->care_cost, "Low cost training");
  $text = add_benefit($text, $survey->care_other, "Other");
  $rowdata[] = $text;

  $table->data[] = $rowdata;
  $n++;
}
echo html_writer::table($table);

echo '<br />Total Surveys: ' . $n;

echo $OUTPUT->footer();


function add_link($text, $link, $statement) {
  if (!empty($link)) {
    if (!empty($text)) $text .= ', ';
    $text .= $statement;
    if ($link == 'Former Link') $text .= '(former)';
  }
  return $text;
}


function add_benefit($text, $link, $statement) {
  if (!empty($link)) {
    if (!empty($text)) $text .= ', ';
    $text .= $statement;
  }
  return $text;
}


function showbody($body, $country, $interested, $informed, $best_way) {
  $select_array = array('' => 'Select...', 'R0' => 'Worldwide', 'R1' => 'Africa', 'R2' => 'Americas', 'R3' => 'Asia', 'R4' => 'Europe', 'R5' => 'Oceania');
  $countryname = get_string_manager()->get_list_of_countries(false);
  $countryname = array_merge($select_array, $countryname);

  $text = "$body";
  if (!empty($country)) $text .= "($countryname[$country])";

  if ($interested == 'Yes, they are already a partner') $text .= ', Interested(already a partner)';
  if ($interested == 'Yes, they are not a partner yet') $text .= ', Interested';
  if ($interested == 'Not Yet') $text .= ', Not Yet Interested';
  if ($interested == "Don't Know") $text .= ", Don't Know Interested";

  if ($informed == 'Yes') $text .= ', Linked';
  if ($informed == 'Not Yet') $text .= ', Not Yet Linked';

  if (!empty($best_way)) $text .= ", $best_way";
  return $text;
}
?>
