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
    . 'chosensemester=' . urlencode($_POST['chosensemester'])
    . '&chosenssf=' . urlencode($_POST['chosenssf'])
    . '&chosenmodule=' . urlencode($_POST['chosenmodule'])
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
  notice('<br /><br /><b>You must be a Tutor to do this! <i><a href="' . $CFG->wwwroot . '">Click Here</a></i>, log in and come back to this page!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}


$PAGE->set_title('Discussion Feedback to Students');
$PAGE->set_heading('Discussion Feedback to Students');
echo $OUTPUT->header();

if (empty($_REQUEST['displayforexcel'])) echo "<h1>Discussion Feedback to Students</h1>";

if (!empty($_REQUEST['chosensemester'])) $chosensemester = $_REQUEST['chosensemester'];
if (!empty($_REQUEST['chosenssf'])) $chosenssf = $_REQUEST['chosenssf'];
if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = $_REQUEST['chosenmodule'];
else $chosenmodule = '';
if (!empty($_REQUEST['displayforexcel'])) $displayforexcel = true;
else $displayforexcel = false;

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
  if (!isset($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

$studentsupportforumsnames = $DB->get_records('forum', array('course' => get_config(NULL, 'peoples_student_support_id')));
if (empty($chosenssf)) $chosenssf = 'All';
$listssf[] = 'All';
foreach ($studentsupportforumsnames as $studentsupportforumsname) {
  $listssf[] = htmlspecialchars($studentsupportforumsname->name, ENT_COMPAT, 'UTF-8');
}
natsort($listssf);

if (empty($chosenssf) || ($chosenssf == 'All')) {
  $chosenssf = 'All';
  $ssfsql = '';
}
else {
  $chosenforumid = $DB->get_record('forum', array('name' => $chosenssf));

  // Look for all User Subscriptions to a Forum in the 'Student Support Forums' Course which are for Students Enrolled in the Course (not Tutors)
  $recordforselecteduserids = $DB->get_record_sql(
    "SELECT
      GROUP_CONCAT(u.id SEPARATOR ', ') AS userids
    FROM
      mdl_forum_subscriptions fs,
      mdl_user u
    WHERE
      forum=? AND
      fs.userid=u.id AND
      u.id IN
        (
          SELECT userid from mdl_user_enrolments where enrolid=?
        )",
    array($chosenforumid->id, get_config(NULL, 'peoples_student_support_id'))
  );

  if (!empty($recordforselecteduserids->userids)) {
    $ssfsql = "AND e.userid IN($recordforselecteduserids->userids)";
  }
  else {
    $ssfsql = "AND e.userid IN(-1)";
  }
}

if (!$displayforexcel) {
?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/discussionfeedbacks.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Semester</td>
    <td>Module Name Contains</td>
    <td>Display for Copying and Pasting to Excel</td>
    <td>Students from this SSF only</td>
  </tr>
  <tr>
    <?php
    displayoptions('chosensemester', $listsemester, $chosensemester);
    ?>
    <td><input type="text" size="15" name="chosenmodule" value="<?php echo htmlspecialchars($chosenmodule, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <td><input type="checkbox" name="displayforexcel" <?php if ($displayforexcel) echo ' CHECKED'; ?>></td>
    <?php
    displayoptions('chosenssf', $listssf, $chosenssf);
    ?>
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


$discussionfeedbacks = $DB->get_records_sql("
  SELECT DISTINCT d.*, u.lastname, u.firstname, c.fullname, e.semester
  FROM mdl_discussionfeedback d
  INNER JOIN mdl_user u ON d.userid=u.id
  INNER JOIN mdl_course c ON d.course_id=c.id
  INNER JOIN mdl_enrolment e ON d.userid=e.userid AND d.course_id=e.courseid $ssfsql
  ORDER BY e.semester, c.fullname, u.lastname, u.firstname");
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
  $n++;
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
    SELECT DISTINCT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors', 'edu_officer', 'edu_officer_old') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>
