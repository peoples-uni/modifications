<?php  // $Id: allow_modules.php,v 1.1 2012/12/26 22:39:00 alanbarrett Exp $
/**
*
* Mark that one or modules for the student should not be discounted, no matter what (for those with good reasons and/or successful appeals)
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/peoples_lib.php');
require_once($CFG->dirroot .'/course/peoples_awards_lib.php');

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
  notice('<br /><br /><b>Click Continue and Login</b><br /><br />', "$CFG->wwwroot/");
}

$PAGE->set_title('Review Award and Mark modules that should not be discounted for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
$PAGE->set_heading('Review Award and Mark modules that should not be discounted for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();
echo '<strong>Review Award and Mark modules that should not be discounted for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</strong><br /><br />';

if (!empty($_POST['markupdatemodules'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  if (!empty($_POST['moduleaccepted'])) {
    foreach ($_POST['moduleaccepted'] as $enrolid => $value) {
      $peoples_accept_module = $DB->get_record('peoples_accept_module', array('userid' => $userid, 'enrolid' => $enrolid));
      if (empty($peoples_accept_module)) {
        $peoples_accept_module = new stdClass();
        $peoples_accept_module->enrolid = $enrolid;
        $peoples_accept_module->userid = $userid;
        $peoples_accept_module->whosubmitted = $USER->id;
        $peoples_accept_module->datesubmitted = time();
        $DB->insert_record('peoples_accept_module', $peoples_accept_module);
      }
    }
  }

  $peoples_accept_modules = $DB->get_records('peoples_accept_module', array('userid' => $userid));
  foreach ($peoples_accept_modules as $peoples_accept_module) {
    if (empty($_POST['moduleaccepted'][$peoples_accept_module->enrolid])) {
      $DB->delete_records('peoples_accept_module', array('userid' => $userid, 'enrolid' => $peoples_accept_module->enrolid));
    }
  }
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
$passes_notified_or_not = 0;
$qualification = get_student_award($userid, $enrols, $passed_or_cpd_enrol_ids, $modules, $percentages, $nopercentage, $lastestdate, $cumulative_enrolled_ids_to_discount, $pass_type, $foundation_problems, $passes_notified_or_not);

$accreditation_of_prior_learnings = $DB->get_records_sql("
  SELECT userid, prior_foundation, prior_problems
  FROM mdl_peoples_accreditation_of_prior_learning
  WHERE userid=:userid", array('userid' => $userid));
if (!empty($accreditation_of_prior_learnings)) {
  if ($accreditation_of_prior_learnings[$userid]->prior_foundation) {
    echo '(Accreditation of Prior Learnings (Foundation): ' . $accreditation_of_prior_learnings[$userid]->prior_foundation . ')<br />';
  }
  if ($accreditation_of_prior_learnings[$userid]->prior_problems) {
    echo '(Accreditation of Prior Learnings (Problems): ' . $accreditation_of_prior_learnings[$userid]->prior_problems . ')<br />';
  }
}

if ($qualification & 2) {
  echo '<strong>Award Achieved: Diploma</strong><br /><br />';
}
elseif ($qualification & 1) {
  echo '<strong>Award Achieved: Certificate</strong><br /><br />';
}


?>
<form id="updatemodulesform" method="post" action="<?php echo $CFG->wwwroot . '/course/allow_modules.php?userid=' . $userid; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<table border="1" BORDERCOLOR="RED">
<tr>
<td>Semester</td>
<td>Module</td>
<td>Pass type</td>
<td>Foundation/Problems</td>
<td>Check if this module should not be discounted (even if academic rules on elapsed time or cummulative number of fails indicate it should be)</td>
</tr>
<?php


foreach ($enrols as $enrolid => $enrol) {
  echo '<tr>';
  echo '<td>' . htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8') . '</td>';
  echo '<td>' . htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
  echo "<td>$pass_type[$enrolid]</td>";

  if (!empty($foundation_problems[$enrolid])) echo "<td>$foundation_problems[$enrolid]</td>";
  else echo '<td></td>';

  echo '<td>';
  $show_checkbox = FALSE;
  if (in_array($enrolid, $cumulative_enrolled_ids_to_discount)) {
    echo 'Discounted because of academic rules ';
    $show_checkbox = TRUE;
    $value_checkbox = FALSE;
  }
  if (!empty($accept_modules[$enrolid])) {
    $show_checkbox = TRUE;
    $value_checkbox = TRUE;
  }
  if ($show_checkbox) {
    if ($value_checkbox) {
      echo '<input type="checkbox" name="moduleaccepted[' . $enrolid . ']" CHECKED>';
    }
    else {
      echo '<input type="checkbox" name="moduleaccepted[' . $enrolid . ']">';
    }
  }
  echo '</td>';

  echo '</tr>';
}
?>
</table><br />

<input type="hidden" name="markupdatemodules" value="1" />
<input type="submit" name="updatemodules" value="Mark Modules that Should be Discounted (or not)" style="width:50em" />
</form>
<br />


<?php
echo '<br /><br /><br />';

echo $OUTPUT->footer();
?>
