<?php  // $Id: allow_modules.php,v 1.1 2012/12/26 22:39:00 alanbarrett Exp $
/**
*
* Mark that one or modules for the student should not be discounted, no matter what (for those with good reasons and/or successful appeals)
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/peoples_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/allow_modules.php'); // Defined here to avoid notices on errors etc

$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userid = required_param('userid', PARAM_INT);

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$isteacher = is_peoples_teacher();
$fullname = fullname($userrecord);
if (empty($fullname) || trim($fullname) == 'Guest User' || !$isteacher) {
  echo '<h1>You must be a tutor to do this!</h1>';
  $SESSION->wantsurl = "$CFG->wwwroot/course/allow_modules.php?userid=$userid";
  notice('<br /><br /><b>Click Continue and Login</b><br /><br />');
}

$PAGE->set_title('Review Award and Mark modules that should not be discounted for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
$PAGE->set_heading('Review Award and Mark modules that should not be discounted for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();


if (!empty($_POST['markupdatemodules'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $activemodules = $DB->get_records('activemodules');

  foreach ($activemodules as $activemodule) {

    $fullname_escaped = $activemodule->fullname;
    $fullname_escaped = str_replace('[', 'XLBRACKETX', $fullname_escaped);
    $fullname_escaped = str_replace(']', 'XRBRACKETX', $fullname_escaped);

    if (!empty($_POST[modulefull][$fullname_escaped])) {
      if (!$activemodule->modulefull) {
        $activemodule->modulefull = 1;
        $DB->update_record('activemodules', $activemodule);
      }
    }
    else {
      if ($activemodule->modulefull) {
        $activemodule->modulefull = 0;
        $DB->update_record('activemodules', $activemodule);
      }
    }
    if (!empty($_POST[removemodule][$fullname_escaped])) {
      $DB->delete_records('activemodules', array('id' => $activemodule->id));
    }
  }
}


$foundation_records = $DB->get_records('peoples_course_codes', array('type' => 'foundation'), 'course_code ASC');
$foundation = array();
foreach ($foundation_records as $record) {
  $foundation[$record->course_code] = 1;
}
$problems_records = $DB->get_records('peoples_course_codes', array('type' => 'problems'), 'course_code ASC');
$problems = array();
foreach ($problems_records as $record) {
  $problems[$record->course_code] = 1;
}

$enrols = $DB->get_records_sql("SELECT * FROM
(SELECT e.*, c.fullname, c.idnumber, c.id AS cid FROM mdl_enrolment e, mdl_course c WHERE e.courseid=c.id AND e.userid=$userid) AS x
LEFT JOIN
(SELECT g.finalgrade, i.courseid AS icourseid FROM mdl_grade_grades g, mdl_grade_items i WHERE g.itemid=i.id AND i.itemtype='course' AND g.userid=$userid) AS y
ON cid=icourseid
ORDER BY datefirstenrolled ASC, fullname ASC");

$peoples_accept_modules = $DB->get_records('peoples_accept_module', array('userid' => $userid));
$accept_modules = array();
  foreach ($peoples_accept_modules as $record) {
    $accept_modules[$record->enrolid] = 1;
  }

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
$qualification = get_student_award($userid, $enrols, $passed_or_cpd_enrol_ids, $modules, $percentages, $nopercentage, $lastestdate, $cumulative_enrolled_ids_to_discount, $pass_type, $foundation_problems);

if ($qualification & 1) {
  echo '<br /><strong>Qualification Achieved: Certificate</strong><br />';
}
if ($qualification & 2) {
  echo '<br /><strong>Qualification Achieved: Diploma</strong><br />';
}


?>
<table border="1" BORDERCOLOR="RED">
<tr>
<td>Semester</td>
<td>Module</td>
<td>Pass type</td>
<td>Foundation/Problems</td>
<td>Check if this module should not be discounted (even if academic rules on elapsed time or cummulative number of fails indicate it should be)</td>
</tr>

<form id="updatemodulesform" method="post" action="<?php echo $CFG->wwwroot . '/course/allow_modules.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<?php


foreach ($enrols as $enrol) {

  echo '<tr>';
  echo '<td>' . htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8') . '</td>';
  echo '<td>' . htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
  echo "<td>$pass_type[$enrol->id]</td>";

  if (!empty($foundation_problems[$enrol->id])) echo "<td>$foundation_problems[$enrol->id]</td>";
  else echo '<td></td>';

USE...
  $accept_modules[$record->enrolid] = 1;
  $cumulative_enrolled_ids_to_discount

, , SOMETIME CHECKBOX...
IF A ROW BLOCKS $cumulative_enrolled_ids_to_discount OR mdl_peoples_accept_module add a checkbox
  echo '</tr>';
}







(**)===================================================================
$activemodules = $DB->get_records('activemodules', NULL, 'fullname ASC');


foreach ($activemodules as $activemodule) {
  echo '<tr>';
  echo '<td>' . htmlspecialchars($activemodule->fullname, ENT_COMPAT, 'UTF-8') . '</td>';

  $fullname_escaped = htmlspecialchars($activemodule->fullname, ENT_COMPAT, 'UTF-8');
  $fullname_escaped = str_replace('[', 'XLBRACKETX', $fullname_escaped);
  $fullname_escaped = str_replace(']', 'XRBRACKETX', $fullname_escaped);

  if (empty($activemodule->modulefull)) {
    echo '<td><input type="checkbox" name="modulefull[' . $fullname_escaped . ']"></td>';
  }
  else {
    echo '<td><input type="checkbox" name="modulefull[' . $fullname_escaped . ']" CHECKED></td>';
  }
  echo '<td><input type="checkbox" name="removemodule[' . $fullname_escaped . ']"></td>';
  echo '</tr>';
}


echo '</table>';
?>
<input type="hidden" name="markupdatemodules" value="1" />
<input type="submit" name="updatemodules" value="Mark Modules as Full or to be Removed based on Check Boxes Above" style="width:50em" />
</form>
<br />


<?php
echo '<br /><br /><br />';

echo $OUTPUT->footer();
?>
