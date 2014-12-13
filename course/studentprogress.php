<?php  // $Id: studentprogress.php,v 1.1 2010/08/27 15:15:00 alanbarrett Exp $
/**
*
* Summary of exams passed and qualification for each student.
*
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
  notice('<br /><br /><b>Click Continue and Login</b><br /><br />');
}

echo '<h1>Student Progress</h1>';
$PAGE->set_title('Student Progress');
$PAGE->set_heading('Student Progress');

echo $OUTPUT->header();


$enrols = $DB->get_records_sql("
SELECT
  u.id,
  u.lastname,
  u.firstname,
  u.lastaccess,
  COUNT(*) AS diploma_passes,
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
        ( SUM((e.percentgrades=0) OR (g.finalgrade>49.99999)) >= 6)                      /* 6 Masters passes for Diploma */
          OR
        ((SUM((e.percentgrades=0) OR (g.finalgrade>49.99999))  = 5) AND (COUNT(*) >= 6)) /* 5 Masters passes for Diploma & 1 condonement*/
      )
        AND
      (
        (
          (SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='foundation') >= 2) /* meets_foundation_criterion */
            AND
          (SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='problems'  ) >= 2) /* meets_problems_criterion */
        )
          OR
        (
          ( SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='foundation') >= 2) /* meets_foundation_criterion */
            AND
          ((SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='problems'  )  = 1) AND (SUM(IF(codes.type='problems'  , 1, 0)) >= 2)) /* almost_meets_problems_criterion */
        )
          OR
        (
          ( SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='problems'  ) >= 2) /* meets_problems_criterion */
            AND
          ((SUM(((e.percentgrades=0) OR (g.finalgrade>49.99999)) AND codes.type='foundation')  = 1) AND (SUM(IF(codes.type='foundation', 1, 0)) >= 2)) /* $almost_meets_foundation_criterion */
        )
      )
    THEN 'Diploma'

    WHEN
      ( SUM((e.percentgrades=0) OR (g.finalgrade>49.99999)) >= 3)                    /* 3 Masters passes for Certificate */
        OR
      ((SUM((e.percentgrades=0) OR (g.finalgrade>49.99999))  = 2) && (COUNT(*)>= 3)) /* 2 Masters passes for Certificate & 1 condonement*/
    THEN 'Certificate'

    ELSE ''
  END AS qualification
FROM
  mdl_enrolment e,
  mdl_course c,
  mdl_user u,
  mdl_grade_grades g,
  mdl_grade_items i,
  mdl_peoples_course_codes codes
WHERE
  e.courseid=c.id AND
  e.userid=u.id AND
  e.userid=g.userid AND
  e.notified=1 AND
  ((e.percentgrades=0 AND IFNULL(g.finalgrade, 2.0)<=1.99999) OR (e.percentgrades=1 AND IFNULL(g.finalgrade, 0.0) >44.99999)) AND
  c.id=i.courseid AND
  g.itemid=i.id AND
  i.itemtype='course' AND
  c.idnumber LIKE BINARY CONCAT(codes.course_code, '%')
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

$table = new html_table();

$table->head = array(
  'Family name',
  'Given name',
  'Last access',
  '# Passed @Masters (@Diploma)',
  'Passed',
  '# Foundation',
  '# Problems',
  'Qualification',
  ''
  );

$n = 0;
foreach ($enrols as $enrol) {
  $rowdata = array();
  $rowdata[] =  '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->id . '" target="_blank">' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</a>';
  $rowdata[] =  '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->id . '" target="_blank">' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</a>';
  $rowdata[] =  ($enrol->lastaccess ? format_time(time() - $enrol->lastaccess) : get_string('never'));

  $text = "$enrol->grandfathered_passes";
  if (!empty($enrol->diploma_only)) $text .= " ($enrol->diploma_only)";
  if (!empty($enrol->pre_percentage_passes)) $text .= " Note: $enrol->pre_percentage_passes of the passes are pre-percentage";
  $rowdata[] =  $text;

  $rowdata[] =  htmlspecialchars($enrol->codespassed, ENT_COMPAT, 'UTF-8');
  $rowdata[] =  $enrol->foundationspassed;
  $rowdata[] =  $enrol->problemspassed;
  $mphtext = '';
  if (!empty($peoplesmph2s[$enrol->id])) {
    $peoplesmph2 = $peoplesmph2s[$enrol->id];
    $type_of_pass = array(0 => '', 1 => ' (MPH)', 2 => ' (MPH Merit)', 3 => ' (MPH Distinction)');
    $mphtext = $type_of_pass[$peoplesmph2->graduated];
  }
  $rowdata[] =  $enrol->qualification . $mphtext;
  $rowdata[] =  '<a href="' . $CFG->wwwroot . '/course/student.php?id=' . $enrol->id . '" target="_blank">Student Grades</a>';
  $n++;
  $table->data[] = $rowdata;
}
echo html_writer::table($table);

echo '<br/>Number of Students: ' . $n;

echo '<br /><br /><br /><br /><br />';
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
