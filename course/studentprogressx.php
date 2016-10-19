<?php  // $Id: studentprogress.php,v 1.1 2010/08/27 15:15:00 alanbarrett Exp $
/**
*
* Summary of exams passed and qualification for each student.
*
*/

/*
CREATE TABLE mdl_peoples_accreditation_of_prior_learning (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  prior_foundation BIGINT(10) UNSIGNED NOT NULL,
  prior_problems BIGINT(10) UNSIGNED NOT NULL,
  userid_approver BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
  note text NOT NULL,
CONSTRAINT PRIMARY KEY (id)
);

CREATE UNIQUE INDEX mdl_peoples_accreditation_of_prior_learning_uid_ix ON mdl_peoples_accreditation_of_prior_learning (userid);

CREATE TABLE mdl_frozen_award (
  id bigint(10) NOT NULL AUTO_INCREMENT,
  userid bigint(10) NOT NULL DEFAULT '0',
  award bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY mdl_frozen_uid_ix (userid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

award...
1 => Certificate
2 => Diploma
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/studentprogress.php');
$PAGE->set_pagelayout('embedded');

require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
if (!$isteacher) {
  echo '<h1>You must be a tutor to do this!</h1>';
  $SESSION->wantsurl = "$CFG->wwwroot/course/studentprogress.php";
  notice('<br /><br /><b>Click Continue and Login</b><br /><br />', "$CFG->wwwroot/");
}

echo '<h1>Student Progress</h1>';
$PAGE->set_title('Student Progress');
$PAGE->set_heading('Student Progress');

echo $OUTPUT->header();


// First work out what modules should be discounted because of academic rules (maximum of 10 semesters to date, maximum of 1 fail to date, maximum of 3 unfinished modules)
// We include enrollments even if they were enrolled and then unenrolled, could change this.
$all_enrols = $DB->get_records_sql("
  SELECT
    CONCAT(e.userid, '#', s.id),
    e.userid,
    s.id,
    COUNT(*) AS num_enrolments,
    SUM(e.notified=1 AND ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0) >1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0)<=44.99999))) AS num_fails,
    SUM(e.notified=1 AND ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0)<=1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0) >44.99999))) AS num_passes,
    SUM(e.notified=1 AND ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0)<=1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0) >49.99999))) AS num_passes_masters,
    SUM(
      ((e.enrolled!=0) AND g.finalgrade IS NULL)
      AND NOT (e.notified IN (3,5)) /* Not Certificate of Participation/Exceptional Factors */
    ) AS num_unfinished,
    SUM(e.enrolled=0
    ) AS num_unenrolled,
    SUM(g.finalgrade IS NULL
    ) AS num_gradenull,
    GROUP_CONCAT(IF(e.id=a.enrolid, 9999999, e.id) SEPARATOR ',') AS enrolled_ids_to_discount
  FROM mdl_enrolment    e
  JOIN mdl_grade_items  i ON e.courseid=i.courseid AND i.itemtype='course'
  JOIN mdl_semesters    s ON e.semester=s.semester
  LEFT JOIN mdl_grade_grades g ON e.userid=g.userid AND i.id=g.itemid
  LEFT JOIN mdl_peoples_accept_module a ON e.id=a.enrolid /* If there is a match, then this module should not be discounted, no matter what */
  GROUP BY e.userid, s.id
  ORDER BY e.userid ASC, s.id ASC");


$user_list = $DB->get_records_sql("SELECT DISTINCT e.userid FROM mdl_enrolment e ORDER BY e.userid ASC");
$semester_list = $DB->get_records('semesters', NULL, 'id ASC');

$enrolls_discounted_by_semester = array();
$semester_list_descending = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semester_list_descending as $semester) {
  $enrolls_discounted_by_semester[$semester->semester] = array();
}

$cumulative_enrolled_ids_to_discount_string = '9999999';
$some_enrolls_discounted = array();
foreach ($user_list as $userid => $record) {
  $first_semester_enrolled = 9999999;
  $total_fails = 0;
  $total_unfinished = 0;
  $discount_all = false;
  $i = 0;
  foreach ($semester_list as $semester) {
    if (!empty($all_enrols["$userid#$semester->id"])) {
      if ($first_semester_enrolled == 9999999) $first_semester_enrolled = $i;

      $semester_enrolls = $all_enrols["$userid#$semester->id"];
      $total_fails += $semester_enrolls->num_fails;
      $total_unfinished += $semester_enrolls->num_unfinished;
      $elapsed_semesters = $i + 1 - $first_semester_enrolled;
      if ($semester->id >= 20) { // New rules for semester Starting March 2015
        if ($total_fails > 0) $discount_all = true;
        if ($semester_enrolls->num_passes_masters != $semester_enrolls->num_passes) $discount_all = true; // No Diploma level passes
      }
      // 20150726 removed: || ($total_unfinished > 3)...
      if ($discount_all || ($total_fails > 1) || ($elapsed_semesters > 10)) { // If TRUE, then discount this Semester's Modules by academic rules
        $cumulative_enrolled_ids_to_discount_string .= ",$semester_enrolls->enrolled_ids_to_discount";   // But note comment above: "If there is a match, then this module should not be discounted, no matter what"
        if (str_replace(',9999999', '', ",$semester_enrolls->enrolled_ids_to_discount") != '' && $semester_enrolls->num_passes > 0) {
          // Some actual passes are discounted for this semester/student
          $some_enrolls_discounted[$userid] = $userid;
          $enrolls_discounted_by_semester[$semester->semester][] = $userid;
        }
      }
    }
    $i++;
  }
}


// If an identical module has already been passed, then do not count the first pass and count the second
$all_enrols = $DB->get_records_sql("
  SELECT
    e.id,
    e.userid,
    codes.course_code
  FROM mdl_enrolment    e
  JOIN mdl_course       c ON e.courseid=c.id
  JOIN mdl_peoples_course_codes codes ON c.idnumber LIKE BINARY CONCAT(codes.course_code, '%')
  JOIN mdl_grade_items  i ON e.courseid=i.courseid AND i.itemtype='course'
  JOIN mdl_semesters    s ON e.semester=s.semester
  LEFT JOIN mdl_grade_grades g ON e.userid=g.userid AND i.id=g.itemid
  WHERE
    e.notified=1 AND ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0)<=1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0) >44.99999))
  ORDER BY s.id DESC, e.id DESC");
$module_already_encountered = array();
foreach ($all_enrols as $all_enrol) { // Note we are starting with most recent first
  if (empty($module_already_encountered[$all_enrol->userid]) || empty($module_already_encountered[$all_enrol->userid][$all_enrol->course_code])) {
    $module_already_encountered[$all_enrol->userid][$all_enrol->course_code] = $all_enrol->course_code;
  }
  else {
    // Do not count the older module (because there is a more recent pass (maybe at a higher level?))
    $cumulative_enrolled_ids_to_discount_string .= ",$all_enrol->id";
  }
}


$enrols = $DB->get_records_sql("
SELECT
  u.id,
  u.lastname,
  u.firstname,
  u.lastaccess,
  COUNT(*) AS diploma_passes,
  GROUP_CONCAT(codes.course_code ORDER BY codes.course_code ASC SEPARATOR ',') AS course_codes_passed_diploma,
  SUM((e.percentgrades=0) OR (g.finalgrade>49.99999)) AS grandfathered_passes,
  COUNT(*) - SUM((e.percentgrades=0) OR (g.finalgrade>49.99999)) AS diploma_only,
  SUM(e.percentgrades=0) AS pre_percentage_passes,
  GROUP_CONCAT(c.idnumber ORDER BY c.idnumber ASC SEPARATOR ', ') AS codespassed,
  SUM(IF(codes.type='foundation', 1, 0)) AS foundationspassed,
  SUM(IF(codes.type='problems', 1, 0)) AS problemspassed,
  SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='foundation') AS countf_grandfathered,
  SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='problems') AS countp_grandfathered,

  CASE
    WHEN
      COUNT(*)>=6 AND
      SUM(IF(codes.type='foundation', 1, 0))>=2 AND
      SUM(IF(codes.type='problems', 1, 0))>=2
    THEN 'Diploma'
    WHEN
      COUNT(*)>=3
    THEN 'Certificate'
    ELSE ''
  END AS qualificationold,

  CASE
    WHEN
      (
        ( SUM((e.percentgrades=0) OR (g.finalgrade>49.99999))+IFNULL(a.prior_foundation, 0)+IFNULL(a.prior_problems, 0) >= 8)    /* 8 Masters passes for Diploma */
          OR
        ((SUM((e.percentgrades=0) OR (g.finalgrade>49.99999))+IFNULL(a.prior_foundation, 0)+IFNULL(a.prior_problems, 0)  = 7) AND (COUNT(*)+IFNULL(a.prior_foundation, 0)+IFNULL(a.prior_problems, 0) >= 8)) /* 7 Masters passes for Diploma & 1 condonement */
      )
        AND
      (
        (
          (SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='foundation')+IFNULL(a.prior_foundation, 0) >= 2) /* meets_foundation_criterion */
            AND
          (SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='problems'  )+IFNULL(a.prior_problems,   0) >= 2) /* meets_problems_criterion */
        )
          OR
        (
          ( SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='foundation')+IFNULL(a.prior_foundation, 0) >= 2) /* meets_foundation_criterion */
            AND
          ((SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='problems'  )+IFNULL(a.prior_problems,   0)  = 1) AND (SUM(IF(codes.type='problems'  , 1, 0))+IFNULL(a.prior_problems,   0) >= 2)) /* almost_meets_problems_criterion */
        )
          OR
        (
          ( SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='problems'  )+IFNULL(a.prior_problems,   0) >= 2) /* meets_problems_criterion */
            AND
          ((SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='foundation')+IFNULL(a.prior_foundation, 0)  = 1) AND (SUM(IF(codes.type='foundation', 1, 0))+IFNULL(a.prior_foundation, 0) >= 2)) /* almost_meets_foundation_criterion */
        )
      )
    THEN 'Diploma'

    WHEN
      ( SUM((e.percentgrades=0) OR (g.finalgrade>49.99999))+IFNULL(a.prior_foundation, 0)+IFNULL(a.prior_problems, 0) >= 4)       /* 4 Masters passes for Certificate */
        OR
      ((SUM((e.percentgrades=0) OR (g.finalgrade>49.99999))+IFNULL(a.prior_foundation, 0)+IFNULL(a.prior_problems, 0)  = 3) && (COUNT(*)+IFNULL(a.prior_foundation, 0)+IFNULL(a.prior_problems, 0)>= 4)) /* 3 Masters passes for Certificate & 1 condonement*/
    THEN 'Certificate'

    ELSE ''
  END AS qualification
FROM (
  mdl_enrolment e,
  mdl_course c,
  mdl_user u,
  mdl_grade_grades g,
  mdl_grade_items i,
  mdl_peoples_course_codes codes)
LEFT JOIN mdl_peoples_accreditation_of_prior_learning a ON e.userid=a.userid
WHERE
  e.courseid=c.id AND
  e.userid=u.id AND
  e.userid=g.userid AND
  e.notified=1 AND
  ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0)<=1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0) >44.99999)) AND
  c.id=i.courseid AND
  g.itemid=i.id AND
  i.itemtype='course' AND
  c.idnumber LIKE BINARY CONCAT(codes.course_code, '%') AND
  e.id NOT IN ($cumulative_enrolled_ids_to_discount_string)
GROUP BY e.userid
ORDER BY diploma_passes DESC, u.lastname, u.firstname
");

$peoplesmph2s = $DB->get_records_sql("
SELECT
  userid,
  graduated
FROM
  mdl_peoplesmph2
");

$semester_durations = $DB->get_records_sql("
SELECT
  u.id,
  MAX(s.id) - IF(MIN(s.id)=1, 7, MIN(s.id)) + 1 AS semester_duration
FROM
  mdl_enrolment e,
  mdl_course c,
  mdl_user u,
  mdl_grade_grades g,
  mdl_grade_items i,
  mdl_semesters s
WHERE
  e.courseid=c.id AND
  e.userid=u.id AND
  e.userid=g.userid AND
  e.enrolled!=0 AND
  c.id=i.courseid AND
  g.itemid=i.id AND
  i.itemtype='course' AND
  e.semester=s.semester
GROUP BY e.userid
");

$accreditation_of_prior_learnings = $DB->get_records_sql("
  SELECT userid, prior_foundation, prior_problems
  FROM mdl_peoples_accreditation_of_prior_learning");
if (empty($accreditation_of_prior_learnings)) $accreditation_of_prior_learnings = array();

$frozen_awards = $DB->get_records_sql("SELECT userid, award FROM mdl_frozen_award");

$table = new html_table();

$table->head = array(
  'Family name',
  'Given name',
  'Last access (elapsed time for all modules)',
  '# Passed @Masters (@Diploma)',
  'Passed',
  '# Foundation',
  '# Problems',
  'Qualification',
  '',
  ''
  );

$n = 0;
foreach ($enrols as $enrol) {
  $rowdata = array();
  $rowdata[] =  '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->id . '" target="_blank">' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</a>';
  $rowdata[] =  '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->id . '" target="_blank">' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</a>';

  $text = '';
  if (!empty($semester_durations[$enrol->id])) {
    $semester_duration = $semester_durations[$enrol->id];
    $text = " ($semester_duration->semester_duration semesters)";
  }
  $rowdata[] =  ($enrol->lastaccess ? format_time(time() - $enrol->lastaccess) : get_string('never')) . $text;

  $text = "$enrol->grandfathered_passes";
  if (!empty($enrol->diploma_only)) $text .= " ($enrol->diploma_only)";
  if (!empty($enrol->pre_percentage_passes)) $text .= " Note: $enrol->pre_percentage_passes of the passes are pre-percentage";
  $rowdata[] =  $text;

  $rowdata[] =  preg_replace(array('/^PU/', '/, PU/'), array('', ', '), htmlspecialchars($enrol->codespassed, ENT_COMPAT, 'UTF-8'));
  $text = '';
  if (!empty($accreditation_of_prior_learnings[$enrol->id])) {
    if ($accreditation_of_prior_learnings[$enrol->id]->prior_foundation) {
      $number = $accreditation_of_prior_learnings[$enrol->id]->prior_foundation;
      $text = " (+ $number for Accreditation of Prior Learnings)";
    }
  }
  $rowdata[] =  $enrol->foundationspassed . $text;

  $text = '';
  if (!empty($accreditation_of_prior_learnings[$enrol->id])) {
    if ($accreditation_of_prior_learnings[$enrol->id]->prior_problems) {
      $number = $accreditation_of_prior_learnings[$enrol->id]->prior_problems;
      $text = " (+ $number for Accreditation of Prior Learnings)";
    }
  }
  $rowdata[] =  $enrol->problemspassed . $text;

  $mphtext = '';
  if (!empty($peoplesmph2s[$enrol->id])) {
    $peoplesmph2 = $peoplesmph2s[$enrol->id];
    $type_of_pass = array(0 => '', 1 => ' (MPH)', 2 => ' (MPH Merit)', 3 => ' (MPH Distinction)');
    $mphtext = $type_of_pass[$peoplesmph2->graduated];
  }
  if ($enrol->qualification == 'Diploma') {
    if (empty($enrol->course_codes_passed_diploma)) {
      $met_core_modules_requirement = false;
    }
    else {
      $met_core_modules_requirement = true;

      $course_codes_passed_diploma = explode(',', $enrol->course_codes_passed_diploma);

      if (!in_array('PUBIOS',  $course_codes_passed_diploma)) $met_core_modules_requirement = false; // Biostatistics
      if (!in_array('PUEPI',   $course_codes_passed_diploma)) $met_core_modules_requirement = false; // Introduction to Epidemiology
      // New University may want these...
    //if (!in_array('PUHPROM', $course_codes_passed_diploma)) $met_core_modules_requirement = false; // Health Promotion
    //if (!in_array('PUEBP',   $course_codes_passed_diploma)) $met_core_modules_requirement = false;
    }

    if (!$met_core_modules_requirement) $enrol->qualification = 'Certificate';
  }
  if (!empty($frozen_awards[$enrol->id]) && ($frozen_awards[$enrol->id]->award == 2)) {
    $enrol->qualification = 'Diploma(pre 16b)';
  }
  if (!empty($frozen_awards[$enrol->id]) && ($frozen_awards[$enrol->id]->award == 1) && ($enrol->qualification != 'Diploma')) {
    $enrol->qualification = 'Certificate(pre 16b)';
  }
  $rowdata[] =  $enrol->qualification . $mphtext;
  $rowdata[] =  '<a href="' . $CFG->wwwroot . '/course/student.php?id=' . $enrol->id . '" target="_blank">Student Grades</a>';

  $text = 'Mark Discounted Modules';
  if (!empty($some_enrolls_discounted[$enrol->id])) $text .= " (<strong>Some Discounted!</strong>)";
  $rowdata[] =  '<a href="' . $CFG->wwwroot . '/course/allow_modules.php?userid=' . $enrol->id . '" target="_blank">' . $text . '</a>';

  $n++;
  $table->data[] = $rowdata;
}
echo html_writer::table($table);

echo '<br/>Number of Students: ' . $n;

echo '<br /><br />';
echo 'Here are (listed by Semester) Students who have had modules discounted by academic rules in that Semester.<br />';
echo 'Click on the Student name to be brought to "Mark Discounted Modules" page for that Student<br />';
echo '(so you can stop a module being discounted).<br />';
foreach ($enrolls_discounted_by_semester as $semester => $users_discounted) {
  echo "<strong>Semester $semester...</strong><br />";

  $users_discounted_keyed = array();
  foreach ($users_discounted as $userid) {
    if (empty($enrols[$userid])) {
      $userrecord = $DB->get_record('user', array('id' => $userid));
      $enrols[$userid] = $userrecord;
    }
    $key = htmlspecialchars(strtolower($enrols[$userid]->lastname), ENT_COMPAT, 'UTF-8') . ', ' . htmlspecialchars(strtolower($enrols[$userid]->firstname), ENT_COMPAT, 'UTF-8');
    $users_discounted_keyed[$key] = $userid;
  }
  ksort($users_discounted_keyed);

  foreach ($users_discounted_keyed as $key => $userid) {
    echo '&nbsp;&nbsp;&nbsp;<a href="' . $CFG->wwwroot . '/course/allow_modules.php?userid=' . $userid . '" target="_blank">' . $key . '</a><br />';
  }
}

echo '<br /><br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

echo '<br />';
echo '<a href="' . $CFG->wwwroot . '/course/coursegrades.php" target="_blank">Course Grades</a>';

echo '<br /><br />';

echo $OUTPUT->footer();


function is_peoples_teacher() {
  global $USER;
  global $DB;

  /* All Teacher, Teachers...
  SELECT u.lastname, r.name, c.fullname
  FROM mdl_user u, mdl_role_assignments ra, mdl_role r, mdl_context con, mdl_course c
  WHERE
  u.id=ra.userid AND
  ra.roleid=r.id AND
  ra.contextid=con.id AND
  r.name IN ('Teacher', 'Teachers') AND
  con.contextlevel=50 AND
  con.instanceid=c.id ORDER BY c.fullname, r.name;
  */

  $teachers = $DB->get_records_sql("
    SELECT DISTINCT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', context_system::instance())) return true;
  else return false;
}
?>
