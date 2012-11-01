<?php
/**
*
* List all Discussion Feedback Forms
*
*/

$assessmentname['10'] = 'Yes';
$assessmentname['20'] = 'No';
$assessmentname['30'] = 'Could be improved';


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/discussionfeedbacks.php'); // Defined here to avoid notices on errors etc

if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/discussionfeedbacks.php?'
    . 'chosensemester=' . urlencode(dontstripslashes($_POST['chosensemester']))
    . '&chosenmodule=' . urlencode(dontstripslashes($_POST['chosenmodule']))
    . (empty($_POST['displayforexcel']) ? '&displayforexcel=0' : '&displayforexcel=1')
    );
}


$PAGE->set_pagelayout('embedded');   // Needs as much space as possible


require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
//$islurker = has_capability('moodle/course:view', get_context_instance(CONTEXT_SYSTEM));
$islurker = FALSE;
if (!$isteacher && !$islurker) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/discussionfeedbacks.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}


$PAGE->set_title('Discussion Feedback');
$PAGE->set_heading('Discussion Feedback');
echo $OUTPUT->header();

if (empty($_REQUEST['displayforexcel'])) echo "<h1>Discussion Feedback</h1>";

if (!empty($_REQUEST['chosensemester'])) $chosensemester = dontstripslashes($_REQUEST['chosensemester']);
if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = dontstripslashes($_REQUEST['chosenmodule']);
else $chosenmodule = '';
if (!empty($_REQUEST['displayforexcel'])) $displayforexcel = true;
else $displayforexcel = false;

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
  if (!isset($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

if (!$displayforexcel) {
?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/discussionfeedbacks.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Semester</td>
    <td>Module Name Contains</td>
    <td>Display for Copying and Pasting to Excel</td>
  </tr>
  <tr>
    <?php
    displayoptions('chosensemester', $listsemester, $chosensemester);
    ?>
    <td><input type="text" size="15" name="chosenmodule" value="<?php echo htmlspecialchars($chosenmodule, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <td><input type="checkbox" name="displayforexcel" <?php if ($displayforexcel) echo ' CHECKED'; ?>></td>
  </tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/discussionfeedbacks.php">Reset Filters</a>
</form>
<br />
<?php
}


function displayoptions($name, $options, $selectedvalue) {
  echo '<td><select name="' . $name . '">';
  foreach ($options as $option) {
    if ($option === $selectedvalue) $selected = 'selected="selected"';
    else $selected = '';

    $opt = htmlspecialchars($option, ENT_COMPAT, 'UTF-8');
    echo '<option value="' . $opt . '" ' . $selected . '>' . $opt . '</option>';
  }
  echo '</select></td>';
}


$discussionfeedbacks = $DB->get_records_sql('
  SELECT DISTINCT d.*, u.lastname, u.firstname, c.fullname, e.semester
  FROM mdl_discussionfeedback d
  INNER JOIN mdl_user u ON d.userid=u.id
  INNER JOIN mdl_course c ON d.course_id=c.id
  INNER JOIN mdl_enrolment e ON d.userid=e.userid AND d.course_id=e.courseid
  ORDER BY e.semester, c.fullname, u.lastname, u.firstname');
if (empty($discussionfeedbacks)) {
  $discussionfeedbacks = array();
}

foreach ($discussionfeedbacks as $id => $discussionfeedback) {
  if ((($chosensemester !== 'All') && ($discussionfeedback->semester !== $chosensemester))) {
    unset($discussionfeedbacks[$id]);
    continue;
  }

  if (!empty($chosenmodule) && stripos($discussionfeedback->fullname, $chosenmodule) === false) {
    unset($discussionfeedbacks[$id]);
    continue;
  }
}


$table = new html_table();

$table->head = array(
  'Family name',
  'Given name',
  'Semester',
  'Module',
  'Referred to resources in the topics',
  'Included critical approach to information',
  'Provided references in an appropriate format',
  'Free text',
  );

$n = 0;
foreach ($discussionfeedbacks as $discussionfeedback) {
  $rowdata = array();

  $rowdata[] = htmlspecialchars($discussionfeedback->lastname, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($discussionfeedback->firstname, ENT_COMPAT, 'UTF-8');

  $rowdata[] = htmlspecialchars($discussionfeedback->semester, ENT_COMPAT, 'UTF-8');

  $rowdata[] = htmlspecialchars($discussionfeedback->fullname, ENT_COMPAT, 'UTF-8');

  $rowdata[] =  $assessmentname[$discussionfeedback->refered_to_resources];
  $rowdata[] =  $assessmentname[$discussionfeedback->critical_approach];
  $rowdata[] =  $assessmentname[$discussionfeedback->provided_references];

  if ($displayforexcel) {
    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $discussionfeedback->assessment_text));
  }
  else {
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->assessment_text));
  }

  $table->data[] = $rowdata;
}
echo html_writer::table($table);

if ($displayforexcel) {
  echo $OUTPUT->footer();
  die();
}

echo '<br />Total Entries: ' . $n;
echo '<br/><br/>';
echo '<a href="' . $CFG->wwwroot . '/course/discussionfeedback.php" target="_blank">Click Here to add a new Entry</a>';
echo '<br/><br/>';

echo $OUTPUT->footer();


function displaystat($stat, $title) {
  echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
  echo "<tr>";
  echo "<td>$title</td>";
  echo "<td>Number</td>";
  echo "</tr>";

  ksort($stat);

  foreach ($stat as $key => $number) {
    echo "<tr>";
    echo "<td>" . $key . "</td>";
    echo "<td>" . $number . "</td>";
      echo "</tr>";
  }
  echo '</table>';
  echo '<br/>';
}


function is_peoples_teacher() {
  global $USER;
  global $DB;

  $teachers = $DB->get_records_sql("
    SELECT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.name IN ('Module Leader', 'Tutors', 'Education coordinator') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>
