<?php  // $Id: education_committee_report.php,v 1.1 2014/01/14 18:17:00 alanbarrett Exp $
/**
*
* Education Committee Report
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');
require_once($CFG->dirroot .'/course/peoples_awards_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/education_committee_report.php'); // Defined here to avoid notices on errors etc

require_once($CFG->dirroot .'/course/peoples_filters.php');

$peoples_filters = new peoples_filters();

$peoples_filters->set_page_url("$CFG->wwwroot/course/education_committee_report.php");

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
$listsemester = array();
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
  if (!isset($defaultsemester)) $defaultsemester = $semester->semester;
}
$peoples_chosensemester_filter = new peoples_select_filter('Semester', 'chosensemester', $listsemester, $defaultsemester);
$peoples_filters->add_filter($peoples_chosensemester_filter);

$peoples_date_filter = new peoples_date_filter("Last Exam Board Year</td><td>Last Exam Board Month</td><td>Last Exam Board Day (include resubmissions since)");
$peoples_filters->add_filter($peoples_date_filter);

$listmph[] = 'Any';
$listmph[] = 'Yes';
$listmph[] = 'No';
$listmph[] = 'MMU MPH';
$listmph[] = 'Peoples MPH';
$listmph[] = 'OTHER MPH';
$peoples_mmu_filter = new peoples_mph_filter('MPH?', 'mph', $listmph, 'Any');
$peoples_filters->add_filter($peoples_mmu_filter);

$listdiploma[] = 'Any';
$listdiploma[] = 'Has 6 Passes';
$listdiploma[] = 'Has Diploma';
$peoples_diploma_filter = new peoples_select_filter('Has Diploma?', 'diploma', $listdiploma, 'Any');
$peoples_filters->add_filter($peoples_diploma_filter);

$listmphdissertation[] = 'Any';
$listmphdissertation[] = 'Yes';
$listmphdissertation[] = 'No';
$peoples_mph_dissertation_filter = new peoples_mph_dissertation_filter('Dissertation Grade available?', 'mphdissertation', $listmphdissertation, 'Any');
$peoples_filters->add_filter($peoples_mph_dissertation_filter);

$peoples_displayforexcel_filter = new peoples_boolean_filter('Display for Copying and Pasting to Excel', 'displayforexcel');
$peoples_filters->add_filter($peoples_displayforexcel_filter);

$chosensemester = $peoples_chosensemester_filter->get_filter_setting();
$last_education_committee = $peoples_date_filter->get_filter_setting();
$diploma_setting = $peoples_diploma_filter->get_filter_setting();
$displayforexcel = $peoples_displayforexcel_filter->get_filter_setting();


if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/education_committee_report.php?' . $peoples_filters->get_url_parameters());
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
  $SESSION->wantsurl = "$CFG->wwwroot/course/education_committee_report.php";
  redirect($CFG->wwwroot . '/login/index.php');
}

// Access to education_committee_report.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Education Committee Report');
$PAGE->set_heading('Education Committee Report');
echo $OUTPUT->header();


if (!$displayforexcel) echo "<h1>Education Committee Report</h1>";

if (!$displayforexcel) $peoples_filters->show_filters();


$semester = $DB->get_record('semesters', array('semester' => $chosensemester));
$semester_id = $semester->id;


$idnumbers = $DB->get_records_sql("
  SELECT
    c.idnumber,
    c.fullname
  FROM mdl_course c
  LEFT JOIN mdl_peoples_course_codes codes ON c.idnumber LIKE BINARY CONCAT(codes.course_code, '%')
  WHERE
    c.id IN (SELECT DISTINCT courseid FROM mdl_enrolment) AND
    codes.course_code IS NULL
  ");
foreach ($idnumbers as $idnumber) {
  echo '<br /><br /><b>WARNING: ' . $idnumber->fullname . ' HAS NO Course ID number(Course Code), you must assign a suitable one in Course Settings.</b>';
}


$userdatas = $DB->get_records_sql("
  SELECT
    u.id,
    u.lastname,
    u.firstname,
    CONCAT(u.lastname, ', ', u.firstname) AS name,
    IFNULL(m.mphstatus, 0) AS mph,
    IFNULL(m.suspended, 0) AS mphsuspended,
    m.note
  FROM mdl_user u
  LEFT JOIN mdl_peoplesmph2 m ON u.id=m.userid
  WHERE
    u.id IN (SELECT DISTINCT e.userid FROM mdl_enrolment e)
  ORDER BY u.lastname, u.firstname, u.id");


$peoplesmph2s = $DB->get_records_sql("
SELECT
  userid,
  note
FROM
  mdl_peoplesmph2
");


$enrols = $DB->get_records_sql("
  SELECT
    e.id,
    e.userid,
    e.courseid,
    e.notified,
    e.semester,
    e.datefirstenrolled,
    e.dateunenrolled,
    e.enrolled,
    e.datenotified,
    e.percentgrades,
    c.fullname,
    c.idnumber,
    g.finalgrade,
    CASE
      WHEN g.finalgrade IS NULL THEN ''
      WHEN e.percentgrades=0 AND g.finalgrade<=1.99999 THEN 'Pass'
      WHEN e.percentgrades=0 AND g.finalgrade> 1.99999 THEN 'Fail'
      ELSE CONCAT(FORMAT(g.finalgrade, 0), '%')
    END AS grade,
    ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0)<=1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0) >44.99999)) AS diploma_pass,
    ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0)<=1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0) >49.99999)) AS masters_pass,
    codes.course_code
  FROM mdl_enrolment e
  JOIN mdl_course c ON e.courseid=c.id
  JOIN mdl_grade_items i ON c.id=i.courseid AND i.itemtype='course'
  JOIN mdl_grade_grades g ON e.userid=g.userid AND i.id=g.itemid
  JOIN mdl_peoples_course_codes codes ON c.idnumber LIKE BINARY CONCAT(codes.course_code, '%')
  JOIN mdl_semesters s ON e.semester=s.semester
  WHERE
    (
      e.userid IN (SELECT DISTINCT e2.userid FROM mdl_enrolment e2 WHERE e2.semester=?) OR
      e.userid IN (
        SELECT x.userid FROM (
          SELECT
            e3.userid,
            IFNULL(g3.timecreated, 0) AS created,
            IFNULL(g3.timemodified, 0) AS modified
          FROM mdl_enrolment e3
          JOIN mdl_grade_items i3 ON i3.itemtype='course' AND e3.courseid=i3.courseid
          JOIN mdl_grade_grades g3 ON i3.id=g3.itemid AND e3.userid=g3.userid
          LEFT JOIN mdl_grade_grades_history gh ON g3.id=gh.oldid
          WHERE
            e3.enrolled!=0 AND
            g3.finalgrade IS NOT NULL
          GROUP BY gh.oldid
          HAVING
            GREATEST(created, modified, IFNULL(MAX(gh.timemodified), 0)) >= $last_education_committee
        ) AS x
      )
    ) AND
    s.id<=$semester_id
  ORDER BY s.id ASC", array($chosensemester));


$idnumbers = $DB->get_records_sql("
  SELECT DISTINCT
    codes.course_code
  FROM mdl_course c
  JOIN mdl_peoples_course_codes codes ON c.idnumber LIKE BINARY CONCAT(codes.course_code, '%')
  WHERE
    c.id IN (SELECT DISTINCT courseid FROM mdl_enrolment)
  ORDER BY codes.course_code
  ");
unset($idnumbers['PUDISS']);
$a =  new stdClass();
$a->course_code = 'PUDISS';
$idnumbers['PUDISS'] = $a; // Place dissertation last


$user_rows = array();
$first_semester = array();
foreach ($enrols as $enrol) {
  if (empty($first_semester[$enrol->userid])) $first_semester[$enrol->userid] = $enrol->semester;

  $text = '';
  if (preg_match('/^(.{4,}?)([012]+[0-9]+[ab]?)/', $enrol->idnumber, $matches)) $text = $matches[2];
  if (!empty($enrol->grade)) $text .= "($enrol->grade)";

  if     ($enrol->enrolled == 0) $text .= ' Unenrolled';
  elseif ($enrol->notified == 0) $text .= ' <b>Not Notified</b>';
  elseif ($enrol->notified == 2) $text .= ' Not Graded, Not Complete';
  elseif ($enrol->notified == 3) $text .= ' Participation/CPD';
  elseif ($enrol->notified == 4) $text .= ' Not Graded, Did Not Pay';
  elseif ($enrol->notified == 5) $text .= ' Not Graded, Exceptional Factors';

  if (empty($user_rows[$enrol->userid]) || empty($user_rows[$enrol->userid][$enrol->course_code])) {
    $user_rows[$enrol->userid][$enrol->course_code] = $text;
  }
  else {
    $user_rows[$enrol->userid][$enrol->course_code] .= " $text";
  }

  if ($enrol->diploma_pass) { // Approx count of passes (approx because there could be discounted/duplicates etc.)
    if (empty($userdatas[$enrol->userid]->diploma_passes)) {
      $userdatas[$enrol->userid]->diploma_passes = 1;
    }
    else {
      $userdatas[$enrol->userid]->diploma_passes++;
    }
  }

  if (!empty($enrol->grade) && $enrol->course_code == 'PUDISS') $userdatas[$enrol->userid]->dissertation_grade_available = TRUE;
}


$userdatas = $peoples_filters->filter_entries($userdatas);


$table = new html_table();
$table->head = array();
$table->head[] = 'Student Number';
$table->head[] = 'Family name';
$table->head[] = 'Given name';
foreach ($idnumbers as $idnumber) {
  $table->head[] = preg_replace('/^PU/', '', $idnumber->course_code);
}
$table->head[] = '';
$table->head[] = 'MPH Status changes';
$table->head[] = 'Notes';
$table->head[] = 'Recommendations';

$n = 0;
foreach ($userdatas as $index => $userdata) {
  $qualification = '';
  $passes_notified_or_not = 0;

  if (!empty($user_rows[$userdata->id])) {
    if ($diploma_setting !== 'Any' && !empty($userdatas[$userdata->id]->diploma_passes) && $userdatas[$userdata->id]->diploma_passes >= 6) {
      // Call get_student_award() to get precise Diploma/count status (we think there are 6 Diploma Passes)
      $userid = $userdata->id;
      $enrols2 = $DB->get_records_sql("SELECT * FROM
(SELECT e.*, c.fullname, c.idnumber, c.id AS cid FROM mdl_enrolment e, mdl_course c WHERE e.courseid=c.id AND e.userid=$userid) AS x
LEFT JOIN
(SELECT g.finalgrade, i.courseid AS icourseid FROM mdl_grade_grades g, mdl_grade_items i WHERE g.itemid=i.id AND i.itemtype='course' AND g.userid=$userid) AS y
ON cid=icourseid
ORDER BY datefirstenrolled ASC, fullname ASC");

      $passed_or_cpd_enrol_ids = array();
      $modules = array();
      $modules[] = 'Modules completed (Grade):';
      $percentages = array();
      $percentages[] = '';
      $nopercentage = 0;
      $lastestdate = 0;
      $cumulative_enrolled_ids_to_discount = array();
      $pass_type = array();
      $foundation_problems = array();
      $passes_notified_or_not = 0;
      $qualification = get_student_award($userid, $enrols2, $passed_or_cpd_enrol_ids, $modules, $percentages, $nopercentage, $lastestdate, $cumulative_enrolled_ids_to_discount, $pass_type, $foundation_problems, $passes_notified_or_not);

      if ($qualification & 2) $qualification = 'Diploma';
      else                    $qualification = '';
    }

    if ($diploma_setting === 'Any' || ($diploma_setting === 'Has 6 Passes' && $passes_notified_or_not >= 6) || ($diploma_setting === 'Has Diploma' && $qualification === 'Diploma')) {
      $rowdata = array();
      $rowdata[] = $userdata->id;
      $rowdata[] = htmlspecialchars($userdata->lastname, ENT_COMPAT, 'UTF-8');
      $rowdata[] = htmlspecialchars($userdata->firstname, ENT_COMPAT, 'UTF-8');

      foreach ($idnumbers as $idnumber) {
        if (!empty($user_rows[$userdata->id][$idnumber->course_code])) $rowdata[] = $user_rows[$userdata->id][$idnumber->course_code];
        else $rowdata[] = '';
      }

      $rowdata[] = '';

      $text = '';
      if (!empty($userdata->note)) $text .= $userdata->note . '<br />';
      if ($displayforexcel) {
        $text = str_replace('<br />', '; ', $text);
        $text = substr($text, 0, -2);
      }
      $rowdata[] = $text;

      if (!empty($qualification)) $text = $qualification . '<br />';
      else                        $text = '';
      $text .= htmlspecialchars($first_semester[$userdata->id], ENT_COMPAT, 'UTF-8') . '<br />';
      $notes = $DB->get_records('peoplesstudentnotes', array('userid' => $userdata->id), 'datesubmitted ASC');
      foreach ($notes as $note) {
        $text .= gmdate('d/m/Y', $note->datesubmitted) . ': ' .  $note->note . '<br />';
      }
      if ($displayforexcel) {
        $text = str_replace('<br />', '; ', $text);
        $text = substr($text, 0, -2);
      }
      $rowdata[] = $text;

      $rowdata[] = '';

      $n++;
      $table->data[] = $rowdata;
    }
  }
}
echo html_writer::table($table);


if ($displayforexcel) {
  echo $OUTPUT->footer();
  die();
}

echo '<br />Total: ' . $n;
echo '<br /><br /><br /><br />';

echo $OUTPUT->footer();
