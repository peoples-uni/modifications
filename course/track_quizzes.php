<?php  // $Id: track_quizzes.php,v 1.1 2014/01/14 18:17:00 alanbarrett Exp $
/**
*
* Track Student Quizzes
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/track_quizzes.php'); // Defined here to avoid notices on errors etc

require_once($CFG->dirroot .'/course/peoples_filters.php');

$peoples_filters = new peoples_filters();

$peoples_filters->set_page_url("$CFG->wwwroot/course/track_quizzes.php");

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
$listsemester = array();
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
  if (!isset($defaultsemester)) $defaultsemester = $semester->semester;
}
$peoples_chosensemester_filter = new peoples_select_filter('Semester', 'chosensemester', $listsemester, $defaultsemester);
$peoples_filters->add_filter($peoples_chosensemester_filter);

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
$listsemester = array();
$listsemester[] = 'None';
$defaultsemester = 'None';
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
}
$peoples_chosensemester2_filter = new peoples_select_filter('Additional Semester to Include', 'chosensemester2', $listsemester, $defaultsemester);
$peoples_filters->add_filter($peoples_chosensemester2_filter);

$peoples_chosenmodule_filter = new peoples_chosenmodule_filter('Module Name Contains', 'chosenmodule');
$peoples_filters->add_filter($peoples_chosenmodule_filter);

$listmph[] = 'Any';
$listmph[] = 'Yes';
$listmph[] = 'No';
$peoples_mmu_filter = new peoples_mph_filter('MPH?', 'mph', $listmph, 'Any');
$peoples_filters->add_filter($peoples_mmu_filter);

$listsubmission[] = 'Any';
$listsubmission[] = 'Not submitted';
$listsubmission[] = 'Submitted';
$listsubmission[] = 'Submitted, No Final Grade';
$listsubmission[] = 'Submitted, Final Grade <50';
$listsubmission[] = 'Submitted, Final Grade =0';
$peoples_submission_filter = new peoples_submission_filter('Status', 'submission', $listsubmission, 'Any');
$peoples_filters->add_filter($peoples_submission_filter);

$peoples_mostrecentontop_filter = new peoples_boolean_filter('Sort Most Recent on Top', 'mostrecentontop');
$peoples_filters->add_filter($peoples_mostrecentontop_filter);

$peoples_displayforexcel_filter = new peoples_boolean_filter('Display for Copying and Pasting to Excel', 'displayforexcel');
$peoples_filters->add_filter($peoples_displayforexcel_filter);

//$peoples_displayextra_filter = new peoples_boolean_filter('Show Extra Details', 'displayextra');
//$peoples_filters->add_filter($peoples_displayextra_filter);

$chosensemester     = $peoples_chosensemester_filter->get_filter_setting();
$chosensemester2    = $peoples_chosensemester2_filter->get_filter_setting();
$mostrecentontop    = $peoples_mostrecentontop_filter->get_filter_setting();
$displayforexcel    = $peoples_displayforexcel_filter->get_filter_setting();
//$displayextra       = $peoples_displayextra_filter->get_filter_setting();


if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/track_quizzes.php?' . $peoples_filters->get_url_parameters());
}

$PAGE->set_pagelayout('embedded');   // Needs as much space as possible

require_login();
// (Might possibly be Guest)

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $USER->id));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$fullname = fullname($userrecord);
if (empty($fullname) || trim($fullname) == 'Guest User') {
  $SESSION->wantsurl = "$CFG->wwwroot/course/track_quizzes.php";
  redirect($CFG->wwwroot . '/login/index.php');
}

// Access to track_quizzes.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Track Quizzes');
$PAGE->set_heading('Track Quizzes');
echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


if (!$displayforexcel) echo "<h1>Track Quizzes</h1>";


if (!$displayforexcel) $peoples_filters->show_filters();


$peoples_track_submissions_exclusions = get_config(NULL, 'peoples_track_submissions_exclusions');

if ($mostrecentontop) {
  $order_string = 'mostrecent DESC, fullname ASC, u.lastname ASC, u.firstname ASC, itemname ASC';
}
else {
  $order_string = 'fullname ASC, u.lastname ASC, u.firstname ASC, itemname ASC';
}
$track_submissions = $DB->get_records_sql("
  SELECT
    CONCAT(e.id, '#', i.id),
    c.fullname AS course,
    c.fullname AS coursename1,
    c.fullname AS coursename2,
    u.id AS userid,
    CONCAT(u.lastname, ', ', u.firstname) AS name,
    u.email AS mail,
    a.name AS assignment,
    a.id AS assign_id,
    i.id AS itemid,
    FROM_UNIXTIME(g.timecreated, '%Y-%m-%d') AS created,
    FROM_UNIXTIME(g.timemodified, '%Y-%m-%d') AS modified,
    FROM_UNIXTIME(a.timeclose, '%Y-%m-%d') AS due,
    '' AS cutoff,
    '' AS extension,
    IFNULL(FROM_UNIXTIME(IF(MAX(IFNULL(asub.timefinish, 0))=0, NULL, MAX(IFNULL(asub.timefinish, 0))), '%Y-%m-%d'), '') AS submissiontime,
    SUBSTRING(MAX(CONCAT(LPAD(IFNULL(asub.timefinish, 0), 12, '0'), IFNULL(asub.state, ' '))), 13) submissionstatus,
    GROUP_CONCAT(DISTINCT CONCAT(IFNULL(asub.state, ''), '(', IFNULL(FROM_UNIXTIME(IF(asub.timefinish=0, NULL, asub.timefinish), '%Y-%m-%d'), ''), ')') ORDER BY asub.timefinish SEPARATOR ', ') AS submissionhistory,
    '' AS submissionhistoryall,
    GROUP_CONCAT(DISTINCT CONCAT(IFNULL(FORMAT(asub.sumgrades, 0), ''), IF(asub.timefinish IS NULL, '', '('), IFNULL(FROM_UNIXTIME(IF(asub.timefinish=0, NULL, asub.timefinish), '%Y-%m-%d'), ''), IF(asub.timefinish IS NULL, '', ')')) ORDER BY asub.timefinish SEPARATOR ', ') AS assignmentgrades,
    IFNULL(FORMAT(g.finalgrade, 0), '') AS grade,
    IFNULL(mphstatus, 0) AS mph,
    IFNULL(m.suspended, 0) AS mphsuspended,
    IFNULL(GREATEST(IF(MAX(IFNULL(asub.timefinish, 0))=0, NULL, MAX(IFNULL(asub.timefinish, 0))), GREATEST(IFNULL(g.timecreated, 0), IFNULL(g.timemodified, 0))), a.timeclose) AS mostrecent
  FROM (mdl_enrolment e, mdl_course c, mdl_grade_items i, mdl_quiz a, mdl_user u)
  LEFT JOIN mdl_quiz_attempts asub ON u.id=asub.userid AND a.id=asub.quiz
  LEFT JOIN mdl_grade_grades g ON i.id=g.itemid AND u.id=g.userid
  LEFT JOIN mdl_peoplesmph2 m ON u.id=m.userid
  WHERE
    e.semester IN (?, ?) AND
    e.enrolled!=0 AND
    e.courseid=c.id AND
    c.id=a.course AND
    c.id=i.courseid AND
    i.iteminstance=a.id AND
    e.userid=u.id
  GROUP BY a.id, u.id
  ORDER BY $order_string", array($chosensemester, $chosensemester2));
if (empty($track_submissions)) {
  $track_submissions = array();
}

$grade_grade_historys = $DB->get_records_sql("
  SELECT DISTINCT
    CONCAT(g.userid, '#', i.id, '#', FROM_UNIXTIME(g.timemodified, '%Y-%m-%d'), IFNULL(FORMAT(g.finalgrade, 0), '')),
    g.userid,
    i.id AS itemid,
    FROM_UNIXTIME(g.timemodified, '%Y-%m-%d') As modified,
    IFNULL(FORMAT(g.finalgrade, 0), '') AS grade
  FROM mdl_grade_grades_history g, mdl_grade_items i
  WHERE
    g.itemid=i.id AND
    i.courseid IN (SELECT DISTINCT courseid FROM mdl_enrolment WHERE semester IN (?, ?)) AND
    g.finalgrade IS NOT NULL
  ORDER BY g.timemodified",
  array($chosensemester, $chosensemester2));

$item_to_grades = array();
$item_to_grade_times = array();
foreach ($grade_grade_historys as $grade_grade_history) {
  $index_element = "{$grade_grade_history->itemid}#{$grade_grade_history->userid}";

  if (!empty($item_to_grades[$index_element])) {
    $item_to_grades[$index_element][] = $grade_grade_history->grade;
    $item_to_grade_times[$index_element][] = $grade_grade_history->modified;
  }
  else {
    $item_to_grades[$index_element] = array($grade_grade_history->grade);
    $item_to_grade_times[$index_element] = array($grade_grade_history->modified);
  }
}


$track_submissions = $peoples_filters->filter_entries($track_submissions);

$table = new html_table();
$table->head = array(
  'Module',
  'Name',
  'ID',
  'e-mail',
  'Assignment (id)',
  'Due Date',
  'Cut-off Date',
  'Extension Date',
  'Submission Date',
  'Submission Status',
  'Submission History',
  'All Recorded Submissions',
  'All Assignment Grades',
  'Final Grade',
  'MPH',
  'Grading History',
  '');

//$table->align = array ("left", "left", "left", "left", "left", "center", "center", "center");
//$table->width = "95%";

$n = 0;
foreach ($track_submissions as $index => $track_submission) {
  $rowdata = array();

  $rowdata[] = htmlspecialchars($track_submission->course, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($track_submission->name, ENT_COMPAT, 'UTF-8');
  $rowdata[] = $track_submission->userid;
  $rowdata[] = htmlspecialchars($track_submission->mail, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($track_submission->assignment, ENT_COMPAT, 'UTF-8') . " ($track_submission->assign_id)";
  $rowdata[] = $track_submission->due;
  $rowdata[] = $track_submission->cutoff;
  $rowdata[] = $track_submission->extension;
  $rowdata[] = $track_submission->submissiontime;
  $rowdata[] = $track_submission->submissionstatus;

  if (substr_count($track_submission->submissionhistory, '(')  > 1) $rowdata[] = $track_submission->submissionhistory;
  else $rowdata[] = '';

  if (!$displayforexcel) {
    $rowdata[] = '<a href="' . "$CFG->wwwroot/course/studentsubmissions.php?id={$track_submission->userid}&hidequiz=1" . '" target="_blank">' . $track_submission->submissionhistoryall . '</a>';
  }
  else {
    $rowdata[] = $track_submission->submissionhistoryall;
  }

  $rowdata[] = $track_submission->assignmentgrades;

  $rowdata[] = $track_submission->grade;

  $mphname = array(0 => '', 1 => 'MMU MPH', 2 => 'Peoples MPH', 3 => 'OTHER MPH');
  $rowdata[] = $mphname[$track_submission->mph];

  $index_element = "{$track_submission->itemid}#{$track_submission->userid}";
  if (!empty($item_to_grades[$index_element])) {
    $text = '';
    foreach ($item_to_grades[$index_element] as $i => $grade) {
      $text .= "$grade({$item_to_grade_times[$index_element][$i]}) ";
    }
    $rowdata[] = $text;
  }
  else {
    $rowdata[] = '';
  }

  if ($track_submission->submissionstatus !== 'submitted') $z = 'No Submission';
  elseif (                                         $track_submission->submissiontime <= $track_submission->due       ) $z = '';
  elseif (!empty($track_submission->extension) && ($track_submission->submissiontime <= $track_submission->extension)) $z = 'Within Extension';
  elseif (!empty($track_submission->cutoff   ) && ($track_submission->submissiontime <= $track_submission->cutoff   )) $z = 'Within Cut-off';
  elseif (!empty($track_submission->extension)) $z = 'Outside Extension!!!';
  elseif (!empty($track_submission->cutoff   )) $z = 'Outside Cut-off!!!';
  else                                          $z = 'Outside Due Date!!!';
  $rowdata[] = $z;

  $n++;
  $table->data[] = $rowdata;
}
echo html_writer::table($table);

if ($displayforexcel) {
  echo $OUTPUT->footer();
  die();
}

echo '<br />Total: ' . $n;
echo '<br /><br /><br /><br />';

//echo html_writer::end_tag('div');

echo $OUTPUT->footer();
