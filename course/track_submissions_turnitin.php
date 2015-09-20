<?php  // $Id: track_submissions_turnitin.php,v 1.1 2014/01/14 18:17:00 alanbarrett Exp $
/**
*
* Track Student Submissions for Turnitin
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/track_submissions_turnitin.php'); // Defined here to avoid notices on errors etc

require_once($CFG->dirroot .'/course/peoples_filters.php');

$peoples_filters = new peoples_filters();

$peoples_filters->set_page_url("$CFG->wwwroot/course/track_submissions_turnitin.php");

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
$listmph[] = 'MMU MPH';
$listmph[] = 'Peoples MPH';
$listmph[] = 'OTHER MPH';
$listmph[] = 'Not MMU MPH';
$listmph[] = 'Not Peoples MPH';
$listmph[] = 'Not OTHER MPH';
$peoples_mmu_filter = new peoples_mph_filter('MPH?', 'mph', $listmph, 'Any');
$peoples_filters->add_filter($peoples_mmu_filter);

$listsubmission[] = 'Any';
$listsubmission[] = 'Not submitted';
$listsubmission[] = 'Submitted';
$listsubmission[] = 'Submitted, No Final Grade';
$listsubmission[] = 'Submitted, Final Grade <50';
$listsubmission[] = 'Submitted, Final Grade =0';
$listsubmission[] = 'Submitted, Outside Due/Extension';
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
  redirect($CFG->wwwroot . '/course/track_submissions_turnitin.php?' . $peoples_filters->get_url_parameters());
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
  $SESSION->wantsurl = "$CFG->wwwroot/course/track_submissions_turnitin.php";
  redirect($CFG->wwwroot . '/login/index.php');
}

// Access to track_submissions_turnitin.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Track Turnitin Submissions');
$PAGE->set_heading('Track TurnitinSubmissions');
echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


if (!$displayforexcel) echo "<h1>Track Turnitin Submissions</h1>";


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
    part_user.*,
    FROM_UNIXTIME(g.timecreated, '%Y-%m-%d') AS created,
    FROM_UNIXTIME(g.timemodified, '%Y-%m-%d') AS modified,
    g.timemodified AS time_modified_grade,
    '' AS cutoff,
    '' AS extension,
    IFNULL(FROM_UNIXTIME(IF(MAX(IFNULL(asub.submission_modified, 0))=0, NULL, MAX(IFNULL(asub.submission_modified, 0))), '%Y-%m-%d'), '') AS submissiontime,
    IFNULL(IF(MAX(IFNULL(asub.submission_modified, 0))=0, NULL, MAX(IFNULL(asub.submission_modified, 0))), '') AS time_of_submissiontime,
    MAX(IF(IFNULL(asub.id, 0)>0, 'submitted', '')) AS submissionstatus,
    '' AS submissionhistory,
    GROUP_CONCAT(DISTINCT CONCAT(IFNULL(FROM_UNIXTIME(IF(r.timemodified=0, NULL, r.timemodified), '%Y-%m-%d'), '')) ORDER BY r.timemodified SEPARATOR ', ') AS submissionhistoryall,
    IFNULL(FORMAT(g.finalgrade, 0), '') AS grade,
    IFNULL(mphstatus, 0) AS mph,
    IFNULL(m.suspended, 0) AS mphsuspended,
    IFNULL(GREATEST(IF(MAX(IFNULL(asub.submission_modified, 0))=0, NULL, MAX(IFNULL(asub.submission_modified, 0))), GREATEST(IFNULL(g.timecreated, 0), IFNULL(g.timemodified, 0))), part_user.dtdue) AS mostrecent
  FROM (
    SELECT
      CONCAT(e.id, '#', i.id, '#', t2p.id) AS unique_id,
      c.fullname AS course,
      c.fullname AS coursename1,
      c.fullname AS coursename2,
      u.id AS userid,
      CONCAT(u.lastname, ', ', u.firstname) AS name,
      u.email AS mail,
      a.id AS t2id,
      CONCAT(a.name, ' (', t2p.partname, ')') AS assignment,
      t2p.id AS part_id,
      CONCAT(a.id, '-', t2p.id) AS assign_id,
      i.id AS itemid,
      t2p.dtdue,
      FROM_UNIXTIME(t2p.dtdue, '%Y-%m-%d') AS due
    FROM       mdl_enrolment             e
    INNER JOIN mdl_course                c   ON e.courseid=c.id
    INNER JOIN mdl_course_modules        cm  ON c.id=cm.course
    INNER JOIN mdl_modules               mo  ON mo.name='turnitintooltwo' AND cm.module=mo.id
    INNER JOIN mdl_grade_items           i   ON cm.instance=i.iteminstance AND i.itemmodule='turnitintooltwo'
    INNER JOIN mdl_turnitintooltwo       a   ON cm.instance=a.id
    INNER JOIN mdl_turnitintooltwo_parts t2p ON cm.instance=t2p.turnitintooltwoid
    INNER JOIN mdl_user                  u   ON e.userid=u.id
    WHERE
      e.semester IN (?, ?) AND
      e.enrolled!=0
  ) AS part_user
  LEFT JOIN mdl_turnitintooltwo_submissions asub ON part_user.part_id=asub.submission_part AND part_user.userid=asub.userid
  LEFT JOIN mdl_grade_grades                g    ON part_user.itemid=g.itemid AND part_user.userid=g.userid
  LEFT JOIN mdl_peoplesmph2                 m    ON part_user.userid=m.userid
  LEFT JOIN mdl_recorded_submissions        r    ON part_user.part_id=r.turnitintooltwo_submission_part AND part_user.userid=r.userid
  GROUP BY part_user.part_id, part_user.userid
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
    g.finalgrade IS NOT NULL AND
    g.userid!=g.usermodified
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
  'Assignment-part (ids)',
  'Due Date',
  //'Cut-off Date',
  //'Extension Date',
  'Submission Date',
  'Submission Status',
  //'Submission History',
  'All Recorded Submissions',
  //'All Assignment Grades',
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
  //$rowdata[] = $track_submission->cutoff;
  //$rowdata[] = $track_submission->extension;
  $rowdata[] = $track_submission->submissiontime;
  $rowdata[] = $track_submission->submissionstatus;

  //if (substr_count($track_submission->submissionhistory, '(')  > 1) $rowdata[] = $track_submission->submissionhistory;
  //else $rowdata[] = '';

  if (!$displayforexcel) {
    $rowdata[] = '<a href="' . "$CFG->wwwroot/course/studentsubmissions.php?id={$track_submission->userid}&hidequiz=1" . '" target="_blank">' . $track_submission->submissionhistoryall . '</a>';
  }
  else {
    $rowdata[] = $track_submission->submissionhistoryall;
  }

  //$rowdata[] = $track_submission->assignmentgrades;

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
  //if (($track_submission->submissionstatus === 'submitted') && ($track_submission->grade !== '') && ($track_submission->time_of_submissiontime >= $track_submission->time_of_last_assignmentgrade)) {
  //  $warningtext = "WARNING: Assignment Grade ($track_submission->date_of_last_assignmentgrade) earlier than Submission!!!";
  //  if (empty($z)) {
  //    $z = $warningtext;
  //  }
  //  else {
  //    $z .= "; $warningtext";
  //  }
  //}
  //else
  if (($track_submission->submissionstatus === 'submitted') && ($track_submission->grade !== '') && ($track_submission->time_of_submissiontime >= $track_submission->time_modified_grade)) {
    $warningtext = "WARNING: Final Grade ($track_submission->modified) earlier than Submission!!!";
    if (empty($z)) {
      $z = $warningtext;
    }
    else {
      $z .= "; $warningtext";
    }
  }
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
