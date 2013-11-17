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
    . (empty($_POST['displayforexcel']) ? '&displayforexcel=0' : '&displayforexcel=1')
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
  $PAGE->set_pagelayout('standard');
  $SESSION->wantsurl = "$CFG->wwwroot/course/dissertations.php";
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
if (empty($_REQUEST['displayforexcel'])) echo "<h1>Student Dissertation Proposals</h1>";


if (!empty($_REQUEST['displayforexcel'])) $displayforexcel = true;
else $displayforexcel = false;

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


if (!$displayforexcel) {
?>
<div style="text-align:left">
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
    <td><input type="checkbox" name="displayforexcel" <?php if ($displayforexcel) echo ' CHECKED'; ?>></td>
  </tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/dissertations.php">Reset Filters</a>
</form>
</div>
<br /><br />
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


$dissertations = $DB->get_records_sql("
  SELECT d.*, u.lastname, u.firstname, u.email, u.username, u.lastaccess, u.country
  FROM mdl_peoplesdissertation d, mdl_user u
  WHERE d.userid=u.id $semestersql
  ORDER BY d.id DESC",
  array($chosensemester));

$table = new html_table();
$table->head = array(
  'Submitted',
  'Semester',
  'Family name',
  'Given name',
  'Email address',
  'Dissertation',
  );
$table->align = array('left','left', 'left', 'left', 'left', 'left');

$n = 0;
if (!empty($dissertations)) {
	foreach ($dissertations as $dissertation) {
    $rowdata = array();

    if (!$displayforexcel) {
      $rowdata[] = '<a name="' .  $dissertation->id . '"></a>' . gmdate('d/m/Y H:i', $dissertation->datesubmitted);

      $a  = '<form id="dissertationsemester<?php echo $dissertation->id; ?>" class="dissertationsemesterform" method="post" action="http://courses.peoples-uni.org/SHOULDNOTBEHERE.php">';
      $a .= '  <input type="hidden" class="dissertationsemesterinput" name="dissertationid" value="<?php echo $dissertation->id; ?>" />';
      $a .= '  <input type="hidden" class="dissertationsemesterinput" name="sesskey" value="<?php echo $USER->sesskey; ?>" />';

      $a .= '  <select class="select dissertationsemestermenu dissertationsemesterinput" id="menudissertationsemester<?php echo $dissertation->id; ?>" name="dissertationsemester">';
      $year = (int)gmdate('Y');
      $options = array();
      $options[] = ($year - 1) . 'a';
      $options[] = ($year - 1) . 'b';
      $options[] = ($year + 0) . 'a';
      $options[] = ($year + 0) . 'b';
      $options[] = ($year + 1) . 'a';
      $options[] = ($year + 1) . 'b';
      foreach ($options as $option) {
        if ($option === $dissertation->semester) $selected = 'selected="selected"';
        else $selected = '';

        $opt = htmlspecialchars($option, ENT_COMPAT, 'UTF-8');
        $a .= '<option value="' . $opt . '" ' . $selected . '>' . $opt . '</option>';
      }
      $a .= '  </select>';
      $a .= '  <input type="submit" class="dissertationsemestermenusubmit" id="dissertationsemestersubmit<?php echo $dissertation->id; ?>" value="SHOULD NOT SEE THIS" />';
      $a .= '</form>';
      $rowdata[] = $a;

      $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $dissertation->userid . '" target="_blank">' . htmlspecialchars($dissertation->lastname, ENT_COMPAT, 'UTF-8') . '</a>';
      $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $dissertation->userid . '" target="_blank">' . htmlspecialchars($dissertation->firstname, ENT_COMPAT, 'UTF-8') . '</a>';
      $rowdata[] = '<a href="mailto:' . $dissertation->email . '" target="_blank">' . htmlspecialchars($dissertation->email, ENT_COMPAT, 'UTF-8') . '</a>';
      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $dissertation->dissertation));
    }
    else {
      $rowdata[] = gmdate('d/m/Y H:i', $dissertation->datesubmitted);
      $rowdata[] = $dissertation->semester;
      $rowdata[] = htmlspecialchars($dissertation->lastname, ENT_COMPAT, 'UTF-8');
      $rowdata[] = htmlspecialchars($dissertation->firstname, ENT_COMPAT, 'UTF-8');
      $rowdata[] = htmlspecialchars($dissertation->email, ENT_COMPAT, 'UTF-8');
      $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $dissertation->dissertation));
    }

		$listofemails[]  = htmlspecialchars($dissertation->email, ENT_COMPAT, 'UTF-8');

		$n++;
    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);

if ($displayforexcel) {
  echo $OUTPUT->footer();
  die();
}

echo '<br/>Number of Records: ' . $n;
echo '<br /><br />';

natcasesort($listofemails);
echo 'e-mails of Above Students...<br />' . implode(', ', array_unique($listofemails)) . '<br /><br />';

echo $OUTPUT->footer();


?>
<script type="text/javascript">
//<![CDATA[
M.yui.add_module({"dissertation_semester":{"name":"dissertation_semester","fullpath":"http:\/\/courses.peoples-uni.org\/course\/dissertation_semester.js","requires":["node","event","overlay","io-base","json"]}});

Y.use('dissertation_semester', function(Y) { M.dissertation_semester.init(Y); });

//]]>
</script>
<?php


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
