<?php  // $Id: dissertations.php,v 1.1 2008/11/26 17:30:00 alanbarrett Exp $
/**
*
* List Student Dissertation Proposals
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/dissertations.php');


if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/dissertations.php?'
    . '&chosensemester=' . urlencode($_POST['chosensemester'])
    );
}


$PAGE->set_pagelayout('embedded');


require_login();
// (Might possibly be Guest)

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userid = $USER->id;
if (empty($userid)) {echo '<h1>$userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$fullname = fullname($userrecord);

if (empty($fullname) || trim($fullname) == 'Guest User') {
  $SESSION->wantsurl = "$CFG->wwwroot/course/dissertation.php";
  notice('<br /><br /><b>You have not logged in. Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}

$isteacher = is_peoples_teacher();
$islurker = has_capability('moodle/grade:viewall', get_context_instance(CONTEXT_SYSTEM));
if (!$isteacher && !$islurker) {
	echo '<h1>You must be a tutor to do this!</h1>';
	notice('Please Login Below', "$CFG->wwwroot/");
}

$PAGE->set_title('Student Dissertation Proposals');
$PAGE->set_heading('Student Dissertation Proposals');

echo $OUTPUT->header();


$chosensemester = optional_param('chosensemester', '', PARAM_NOTAGS);

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
	$listsemester[] = $semester->semester;
	if (empty($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

if (empty($chosensemester) || ($chosensemester == 'All')) {
	$chosensemester = 'All';
  $semestersql = 'AND d.semester!=?';
}
else {
  $semestersql = 'AND d.semester=?';
}


?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/dissertations.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Semester</td>
  </tr>
  <tr>
    <?php
		displayoptions('chosensemester', $listsemester, $chosensemester);
		?>
	</tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/dissertations.php">Reset Filters</a>
</form>
<br /><br />
<?php


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


$dissertations = $DB->get_records_sql("
  SELECT d.*, u.lastname, u.firstname, u.email, u.username, u.lastaccess, u.country
  FROM mdl_peoplesdissertation d, mdl_user u
  WHERE d.userid=u.id $semestersql
  ORDER BY d.id DESC",
  array($chosensemester));

$table = new html_table();
$table->head = array(
  'Submitted',
  'Family name',
  'Given name',
  'Email address',
  'Dissertation',
  );

$n = 0;
if (!empty($dissertations)) {
	foreach ($dissertations as $dissertation) {
    $rowdata = array();
    $rowdata[] = gmdate('d/m/Y H:i', $dissertation->datesubmitted);
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $dissertation->userid . '" target="_blank">' . htmlspecialchars($dissertation->lastname, ENT_COMPAT, 'UTF-8') . '</a>';
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $dissertation->userid . '" target="_blank">' . htmlspecialchars($dissertation->firstname, ENT_COMPAT, 'UTF-8') . '</a>';
    $rowdata[] = '<a href="mailto:' . $dissertation->email . '">' . htmlspecialchars($dissertation->email, ENT_COMPAT, 'UTF-8') . '</a>';
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $dissertation->dissertation));

		$listofemails[]  = htmlspecialchars($dissertation->email, ENT_COMPAT, 'UTF-8');

		$n++;
    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);

echo '<br/>Number of Records: ' . $n;
echo '<br /><br />';

natcasesort($listofemails);
echo 'e-mails of Above Students...<br />' . implode(', ', array_unique($listofemails)) . '<br /><br />';

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

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>
