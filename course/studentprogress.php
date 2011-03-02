<?php  // $Id: studentprogress.php,v 1.1 2010/08/27 15:15:00 alanbarrett Exp $
/**
*
* Summary of exams passed and qualification for each student.
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');


require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = isteacherinanycourse();
if (!$isteacher) {
  echo '<h1>You must be a teacher to do this!</h1>';
  notice('Please Login Below', "$CFG->wwwroot/");
}

print_header('Student Progress');

echo '<h1>Student Progress</h1>';


$enrols = get_records_sql("
SELECT
  u.id,
  u.lastname,
  u.firstname,
  u.lastaccess,
  COUNT(*) AS numberpassed,
  GROUP_CONCAT(c.idnumber ORDER BY c.idnumber ASC SEPARATOR ', ') AS codespassed,
  SUM(IF(codes.type='foundation', 1, 0)) AS foundationspassed,
  SUM(IF(codes.type='problems', 1, 0)) AS problemspassed,
  IF(COUNT(*)>=8 AND SUM(IF(codes.type='foundation', 1, 0))>=2 AND SUM(IF(codes.type='problems', 1, 0)>=2), 'Diploma', IF(COUNT(*)>=4, 'Certificate', '')) AS qualification
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
  IFNULL(g.finalgrade, 2.0)<=1.99999 AND
  c.id=i.courseid AND
  g.itemid=i.id AND
  i.itemtype='course' AND
  c.idnumber LIKE BINARY CONCAT(codes.course_code, '%')
GROUP BY e.userid
ORDER BY numberpassed DESC, u.lastname, u.firstname
");

echo '<table border="1" BORDERCOLOR="RED">';
echo '<tr>';
echo '<td>Family name</td>';
echo '<td>Given name</td>';
echo '<td>Last access</td>';
echo '<td># Passed</td>';
echo '<td>Passed</td>';
echo '<td># Foundation</td>';
echo '<td># Problems</td>';
echo '<td>Qualification</td>';
echo '<td></td>';
echo '</tr>';

$n = 0;
foreach ($enrols as $enrol) {
  echo '<tr>';
  echo '<td><a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->id . '" target="_blank">' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</a></td>';
  echo '<td><a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->id . '" target="_blank">' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</a></td>';
  echo '<td>' . ($enrol->lastaccess ? format_time(time() - $enrol->lastaccess) : get_string('never')) . '</td>';
  echo "<td>{$enrol->numberpassed}</td>";
  echo '<td>' . htmlspecialchars($enrol->codespassed, ENT_COMPAT, 'UTF-8') . '</td>';
  echo "<td>{$enrol->foundationspassed}</td>";
  echo "<td>{$enrol->problemspassed}</td>";
  echo "<td>{$enrol->qualification}</td>";
  echo '<td><a href="' . $CFG->wwwroot . '/course/student.php?id=' . $enrol->id . '" target="_blank">Student Grades</a></td>';
  echo '</tr>';
  $n++;
}

echo '</table>';
echo '<br/>Number of Students: ' . $n;

echo '<br /><br /><br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

echo '<br />';
echo '<a href="' . $CFG->wwwroot . '/course/coursegrades.php" target="_blank">Course Grades</a>';

echo '<br /><br />';

print_footer();
?>
