<?php  // $Id: track_submissions.php,v 1.1 2014/01/14 18:17:00 alanbarrett Exp $
/**
*
* Track Student Submissions
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/track_submissions.php'); // Defined here to avoid notices on errors etc

if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/track_submissions.php?'
    . '&chosensemester=' . urlencode($_POST['chosensemester'])
    . '&chosenmodule=' . urlencode($_POST['chosenmodule'])
    . (empty($_POST['displayforexcel']) ? '&displayforexcel=0' : '&displayforexcel=1')
    );
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
  $SESSION->wantsurl = "$CFG->wwwroot/course/track_submissions.php";
  redirect($CFG->wwwroot . '/login/index.php');
}

// Access to track_submissions.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', context_system::instance());
$is_admin = has_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Tutor Registrations');
$PAGE->set_heading('Tutor Registrations');
echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


if (empty($_REQUEST['displayforexcel'])) echo "<h1>Track Submissions</h1>";


if (!empty($_REQUEST['chosensemester'])) $chosensemester = $_REQUEST['chosensemester'];
if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = $_REQUEST['chosenmodule'];
else $chosenmodule = '';
if (!empty($_REQUEST['displayforexcel'])) $displayforexcel = true;
else $displayforexcel = false;


$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
  if (!isset($chosensemester)) $chosensemester = $semester->semester;
}


if (!$displayforexcel) {
?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/track_submissions.php'; ?>">
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
<a href="<?php echo $CFG->wwwroot; ?>/course/track_submissions.php">Reset Filters</a>
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


$peoples_track_submissions = $DB->get_records_sql("
  SELECT
    CONCAT(e.id, '#', i.id),
    c.fullname AS course,
    u.id AS userid,
    CONCAT(u.lastname, ', ', u.firstname) AS name,
    u.email AS mail,
    a.name AS assignment,
    i.id AS itemid,
    FROM_UNIXTIME(g.timecreated, '%Y-%m-%d') AS created,
    FROM_UNIXTIME(g.timemodified, '%Y-%m-%d') AS modified,
    FROM_UNIXTIME(duedate, '%Y-%m-%d') AS due,
    IFNULL(FROM_UNIXTIME(IF(      cutoffdate=0, NULL,       cutoffdate), '%Y-%m-%d'), '') AS cutoff,
    IFNULL(FROM_UNIXTIME(IF(extensionduedate=0, NULL, extensionduedate), '%Y-%m-%d'), '') AS extension,
    IFNULL(FROM_UNIXTIME(IF(asub.timemodified=0, NULL, asub.timemodified), '%Y-%m-%d'), '') AS submissiontime,
    IFNULL(asub.status, '') AS submissionstatus,
    IFNULL(FORMAT(g.finalgrade, 0), '') AS grade,
    IFNULL(mphstatus, '') AS mph
  FROM (mdl_enrolment e, mdl_course c, mdl_grade_items i, mdl_assign a, mdl_user u)
  LEFT JOIN mdl_assign_user_flags auf ON u.id=auf.userid AND a.id=auf.assignment
  LEFT JOIN mdl_assign_submission asub ON u.id=asub.userid AND a.id=asub.assignment
  LEFT JOIN mdl_grade_grades g ON i.id=g.itemid AND u.id=g.userid
  LEFT JOIN mdl_peoplesmph2 m ON u.id=m.userid
  WHERE
    e.semester=? AND
    e.enrolled!=0 AND
    e.courseid=c.id AND
    c.id=a.course AND
    c.id=i.courseid AND
    i.iteminstance=a.id AND
    e.userid=u.id
  ORDER BY fullname ASC, u.lastname ASC, u.firstname ASC, itemname ASC", array($chosensemester));
if (empty($peoples_track_submissions)) {
  $peoples_track_submissions = array();
}

$grade_grade_historys = $DB->get_records_sql("
  SELECT
    g.id,
    g.userid,
    i.id AS itemid,
    FROM_UNIXTIME(g.timemodified, '%Y-%m-%d') As modified,
    IFNULL(FORMAT(g.finalgrade, 0), '') AS grade
  FROM mdl_grade_grades_history g, mdl_grade_items i
  WHERE
    g.itemid=i.id AND
    g.source='mod/assign' AND
    i.courseid IN (SELECT DISTINCT courseid FROM mdl_enrolment WHERE semester=?) AND
    g.finalgrade IS NOT NULL
  ORDER BY g.timemodified DESC",
  array($chosensemester));

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


foreach ($peoples_track_submissions as $index => $peoples_track_submission) {

  if (!empty($chosenmodule) && ((stripos($peoples_track_submission->course, $chosenmodule) === false))) {
    unset($peoples_track_submissions[$index]);
    continue;
  }
}


$table = new html_table();
$table->head = array(
  'Module',
  'Name',
  'ID',
  'e-mail',
  'Assignment',
  'Created',
  'Modified',
  'Due',
  'Cut-off',
  'Extension',
  'Submission Time',
  'Submission Status',
  'Grade',
  'MPH',
  'Grading History',);

//$table->align = array ("left", "left", "left", "left", "left", "center", "center", "center");
//$table->width = "95%";

$n = 0;
foreach ($peoples_track_submissions as $index => $peoples_track_submission) {
  $rowdata = array();

  $rowdata[] = htmlspecialchars($peoples_track_submission->course, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($peoples_track_submission->name, ENT_COMPAT, 'UTF-8');
  $rowdata[] = $peoples_track_submission->userid;
  $rowdata[] = htmlspecialchars($peoples_track_submission->mail, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($peoples_track_submission->assignment, ENT_COMPAT, 'UTF-8');
  $rowdata[] = $peoples_track_submission->created;
  $rowdata[] = $peoples_track_submission->modified;
  $rowdata[] = $peoples_track_submission->due;
  $rowdata[] = $peoples_track_submission->cutoff;
  $rowdata[] = $peoples_track_submission->extension;
  $rowdata[] = $peoples_track_submission->submissiontime;
  $rowdata[] = $peoples_track_submission->submissionstatus;
  $rowdata[] = $peoples_track_submission->grade;

  $mphname = array(0 => '', 1 => 'MMU MPH', 2 => 'Peoples MPH', 3 => 'OTHER MPH');
  $rowdata[] = $mphname[$peoples_track_submission->mph];

  $index_element = "{$peoples_track_submission->itemid}#{$peoples_track_submission->userid}";
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
