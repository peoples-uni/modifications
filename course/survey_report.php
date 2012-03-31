<?php

require("../config.php");
//require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/course_report.php');

$PAGE->set_pagelayout('embedded');

require_login();

if ($USER->id != 337) { // Debs Thompson
  // Access is given by the "Manager" role which has moodle/site:viewparticipants
  // (administrator also has moodle/site:viewparticipants)
  require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));
}

$PAGE->set_title('Survey');
$PAGE->set_heading('Survey');
echo $OUTPUT->header();

echo "<h1>Survey</h1>";

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
  'Organisations that deliver public health training',
  'Bodies',
  'Benefits',
  'Organisations that fund public health training?',
  'Bodies',
  'Organisations that deliver health promotion/health care?',
  'Bodies',
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

  $rowdata[] = $survey->deliver_body;

  $text = '';
  $text = add_benefit($text, $survey->deliver_diversify, "Training delivery routes");
  $text = add_benefit($text, $survey->deliver_research, "International research");
  $text = add_benefit($text, $survey->deliver_trainers, "Accredited training for trainers");
  $text = add_benefit($text, $survey->deliver_materials, "Training materials");
  $text = add_benefit($text, $survey->deliver_network, "Professional network");
  $text = add_benefit($text, $survey->deliver_students, "Attract students");
  $text = add_benefit($text, $survey->deliver_tutors, "Attract tutors");
  $text = add_benefit($text, $survey->deliver_pastoral, "Pastoral support");
  $text = add_benefit($text, $survey->deliver_other, "Other");
  $rowdata[] = $text;

  $text = '';
  $text = add_link($text, $survey->fund_national_governments, 'National government');
  $text = add_link($text, $survey->fund_local_governments, 'Local government');
  $text = add_link($text, $survey->fund_local_ngo, 'Local NGO');
  $text = add_link($text, $survey->fund_national_ngo, 'National NGO');
  $text = add_link($text, $survey->fund_international_ngo, 'International NGO');
  $rowdata[] = $text;

  $rowdata[] = $survey->fund_body;

  $text = add_link($text, $survey->care_national_governments, 'National governments');
  $text = add_link($text, $survey->care_local_governments, 'Local governments');
  $text = add_link($text, $survey->care_local_ngo, 'Local NGO');
  $text = add_link($text, $survey->care_national_ngo, 'National NGO');
  $text = add_link($text, $survey->care_international_ngo, 'International NGO');
  $rowdata[] = $text;

  $rowdata[] = $survey->care_body;

  $text = add_benefit($text, $survey->care_practice, "Support students to putinto practice");
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
?>
