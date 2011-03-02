<?php  // $Id: settings.php,v 1.1 2008/10/22 22:39:00 alanbarrett Exp $
/**
*
* Change Settings for applications.php for use by Peoples-Uni
*
*/

/*	Setup by hand...
CREATE TABLE mdl_semesters (
	id BIGINT(10) unsigned NOT NULL auto_increment,
	semester VARCHAR(255) NOT NULL,
	CONSTRAINT PRIMARY KEY (id)
);

CREATE TABLE mdl_activemodules (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  fullname VARCHAR(254) NOT NULL,
  modulefull TINYINT(2) NOT NULL DEFAULT 0,
  course_id BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  CONSTRAINT PRIMARY KEY (id)
);
(ALTER TABLE mdl_activemodules ADD course_id BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER modulefull;)

CREATE TABLE mdl_peoples_course_codes (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  type VARCHAR(100) NOT NULL,
  course_code VARCHAR(100) NOT NULL,
  CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoples_course_code_ix ON mdl_peoples_course_codes (course_code);
*/


$closednotice = 'APPLICATIONS CLOSED, WILL REOPEN SOON FOR NEXT SEMESTER';


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/settings.php'); // Defined here to avoid notices on errors etc

$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();

require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Settings for Student Applications');
$PAGE->set_heading('Settings for Student Applications');
echo $OUTPUT->header();


if (!empty($_POST['markaddsemester']) && !empty($_POST['semester'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
	$_POST['semester'] = dontstripslashes($_POST['semester']);
	// Special characters will allways be converted to entities for display so not needed (but Bug in Drupal which converts twice, see below)
	// $_POST['semester'] = strip_tags($_POST['semester']);
	$newsemester = $_POST['semester'];
	// Drupal Bug: Webform Select messes up: &, <, >
	$newsemester = str_replace("&", '', $newsemester);
	$newsemester = str_replace("<", '', $newsemester);
	$newsemester = str_replace(">", '', $newsemester);

  $semesters = $DB->get_records('semesters');

	$found = false;
	foreach ($semesters as $semester) {
		if ($newsemester === $semester->semester) $found = true;
	}

	if (!$found) {
    $record->semester = dontaddslashes($newsemester);
    $DB->insert_record('semesters', $record);
	}

	// http://www.peoples-uni.org/forms/application-form-returning-students
  $semestercomponent = $DB->get_record_sql('SELECT value, extra FROM d5_webform_component WHERE nid=80 AND cid=2');

	$extra = unserialize($semestercomponent->extra);
	// echo '----------------------------------------------<br />';
	// echo var_dump($extra) . '<br />';
	// echo '----------------------------------------------<br />';

	$extra['items'] = $newsemester;

  $ret = $DB->execute("UPDATE d5_webform_component SET value=?, extra=? WHERE nid=80 AND cid=2", array($newsemester, serialize($extra)));

	// http://www.peoples-uni.org/forms/peoples-uni-course-application-form
  $semestercomponent = $DB->get_record_sql('SELECT value, extra FROM d5_webform_component WHERE nid=71 AND cid=16');
	$extra = unserialize($semestercomponent->extra);
	$extra['items'] = $newsemester;
  $ret = $DB->execute("UPDATE d5_webform_component SET value=?, extra=? WHERE nid=71 AND cid=16", array($newsemester, serialize($extra)));
}
if (!empty($_POST['markaddfoundation']) && !empty($_POST['foundation'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $_POST['foundation'] = strip_tags($_POST['foundation']);

  $record->type = 'foundation';
  $record->course_code = $_POST['foundation'];
  $DB->insert_record('peoples_course_codes', $record);
}
if (!empty($_POST['markaddproblems']) && !empty($_POST['problems'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $_POST['problems'] = strip_tags($_POST['problems']);

  $record->type = 'problems';
  $record->course_code = $_POST['problems'];
  $DB->insert_record('peoples_course_codes', $record);
}
if (!empty($_POST['markclosesemester'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

	$newsemester = $closednotice;

	// Subsequent Modules Form
  $semestercomponent = $DB->get_record_sql('SELECT value, extra FROM d5_webform_component WHERE nid=80 AND cid=2');

	$extra = unserialize($semestercomponent->extra);
	$extra['items'] = $newsemester;

  $ret = $DB->execute("UPDATE d5_webform_component SET value=?, extra=? WHERE nid=80 AND cid=2", array($newsemester, serialize($extra)));

	// Main form...
  $semestercomponent = $DB->get_record_sql('SELECT value, extra FROM d5_webform_component WHERE nid=71 AND cid=16');
	$extra = unserialize($semestercomponent->extra);
	$extra['items'] = $newsemester;
  $ret = $DB->execute("UPDATE d5_webform_component SET value=?, extra=? WHERE nid=71 AND cid=16", array($newsemester, serialize($extra)));

  $activemodules = $DB->get_records('activemodules');
	foreach ($activemodules as $activemodule) {
    $activemodule->fullname = dontaddslashes($activemodule->fullname);
		if (!$activemodule->modulefull) {
			$activemodule->modulefull = 1;
      $DB->update_record('activemodules', $activemodule);
		}
	}

	updateformmoduleselections();
}
if (!empty($_POST['markaddnewmodule']) && !empty($_POST['moduletoadd'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
	$moduletoadd = dontstripslashes($_POST['moduletoadd']);

  $activemodules = $DB->get_records('activemodules');

	$found = false;
	foreach ($activemodules as $activemodule) {
		if ($moduletoadd === $activemodule->fullname) $found = true;
	}

  if (!$found) {
    $record->fullname = dontaddslashes($moduletoadd);
    $courseforid = $DB->get_record('course', array('fullname' => $record->fullname));
    $record->course_id = $courseforid->id;
    $DB->insert_record('activemodules', $record);
  }
}
if (!empty($_POST['markupdatemodules'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $activemodules = $DB->get_records('activemodules');

  foreach ($activemodules as $activemodule) {
    $activemodule->fullname = dontaddslashes($activemodule->fullname);

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

  updateformmoduleselections();
}
if (!empty($_POST['marksetstudentscorner']) && !empty($_POST['studentscorner'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $studentscorner = dontstripslashes($_POST['studentscorner']);
  set_config('peoples_students_corner_id', $studentscorner);
}
if (!empty($_POST['mark_approval_email']) && !empty($_POST['value_approval_email'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $value_approval_email = dontstripslashes($_POST['value_approval_email']);
  set_config('peoples_approval_email', $value_approval_email);
}
if (!empty($_POST['mark_approval_old_students_email']) && !empty($_POST['value_approval_old_students_email'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $value_approval_old_students_email = dontstripslashes($_POST['value_approval_old_students_email']);
  set_config('peoples_approval_old_students_email', $value_approval_old_students_email);
}
if (!empty($_POST['mark_batch_reminder_email']) && !empty($_POST['value_batch_reminder_email'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $value_batch_reminder_email = dontstripslashes($_POST['value_batch_reminder_email']);
  set_config('peoples_batch_reminder_email', $value_batch_reminder_email);
}
if (!empty($_POST['mark_batch_email_to_enrolled']) && !empty($_POST['value_batch_email_to_enrolled'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $value_batch_email_to_enrolled = dontstripslashes($_POST['value_batch_email_to_enrolled']);
  set_config('peoples_batch_email_to_enrolled', $value_batch_email_to_enrolled);
}
if (!empty($_POST['mark_interest_email']) && !empty($_POST['value_interest_email'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $value_interest_email = dontstripslashes($_POST['value_interest_email']);
  set_config('peoples_interest_email', $value_interest_email);
}
if (!empty($_POST['mark_batch_email_to_enrolled_missing']) && !empty($_POST['value_batch_email_to_enrolled_missing'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $value_batch_email_to_enrolled_missing = dontstripslashes($_POST['value_batch_email_to_enrolled_missing']);
  set_config('peoples_batch_email_to_enrolled_missing', $value_batch_email_to_enrolled_missing);
}


echo '<h2>Semester...</h2>';

$semesters = $DB->get_records('semesters', NULL, 'id ASC');

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";
echo "<td>Semester Names...</td>";
echo "</tr>";

$currentsemester = '';
foreach ($semesters as $semester) {
	echo "<tr>";
	echo "<td>" . htmlspecialchars($semester->semester, ENT_COMPAT, 'UTF-8') . "</td>";
	echo "</tr>";
	$currentsemester = $semester->semester;
}
echo '</table>';
echo '<br /><br />';

$semestercomponent = $DB->get_record_sql('SELECT value, extra FROM d5_webform_component WHERE nid=71 AND cid=16');
// echo var_dump($semestercomponent) . '<br />';
$extra = unserialize($semestercomponent->extra);
$semesterfromform = $extra['items'];
if ($semesterfromform === $closednotice) {
	echo 'Application forms are currently closed.<br />';
	$closed = true;
}
else {
	echo 'Application forms are currently open for semester: "' . $semesterfromform . '".<br />';
	$closed = false;
}

?>
<form id="addsemesterform" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markaddsemester" value="1" />
<input type="submit" name="addsemester" value="Open Application Forms & Set Current Semester to:" style="width:45em" />
<input type="text" size="40" name="semester" value="<?php echo htmlspecialchars($currentsemester, ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br />
<?php
if (!$closed) {
?>
<form id="closesemesterform" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markclosesemester" value="1" />
<input type="submit" name="closesemester" value="Close Application Forms & Mark All Modules as Full" style="width:45em" />
</form>
<br />
<?php
}


echo '<h2>Modules for Semester...</h2>';

$courses = $DB->get_records('course', NULL, 'fullname ASC');

$activemodules = $DB->get_records('activemodules', NULL, 'fullname ASC');
?>

<form id="updatemodulesform" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<?php

echo '<table border="1" BORDERCOLOR="RED">';
echo '<tr>';
echo '<td>Modules on Application Forms...</td>';
echo '<td>Check to mark Module as Full</td>';
echo '<td>Check to completely Remove from Forms</td>';
echo '</tr>';

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
<input type="submit" name="updatemodules" value="Update Modules for Application Forms from list above" style="width:45em" />
</form>
<br />

<form id="addnewmoduleform" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markaddnewmodule" value="1" />
<input type="submit" name="addnewmodule" value="Add this Module to list above:" style="width:45em" />
<select name="moduletoadd">
<?php
foreach ($courses as $course) {
	$modulename = htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"'; ?> ><?php echo $modulename; ?></option>
<?php
}
?>
</select>
</form>

<?php
echo '<br />Here is are lists of valid Peoples-uni agreed Course Codes (Course ID numbers)...';
echo '<br />Foundation Sciences:';
$foundation_records = $DB->get_records('peoples_course_codes', array('type' => 'foundation'), 'course_code ASC');
foreach ($foundation_records as $record) {
  $foundation[$record->course_code] = 1;
  echo ' ' . $record->course_code;
}

echo '<br />Public Health Problems:';
$problems_records = $DB->get_records('peoples_course_codes', array('type' => 'problems'),   'course_code ASC');
foreach ($problems_records as $record) {
  $problems[$record->course_code] = 1;
  echo ' ' . $record->course_code;
}

//// TEMPORARY FOR TEST...
//echo '<br />';
//$f['PUBIOS'] = 1;  // Biostatistics
//$f['PUEBP']  = 1;  // Evidence Based Practice
//$f['PUEPI']  = 1;  // Introduction to Epidemiology
//$f['PUETH']  = 1;  // Public Health Ethics
//$f['PUEVAL'] = 1;  // Evaluation of Interventions
//$f['PUHECO'] = 1;  // Health Economics
//$f['PUISDH'] = 1;  // Inequalities and the social determinants of health
//$f['PUPHC']  = 1;  // Public Health Concepts for Policy Makers
//foreach ($f as $key => $value) {
//  if ($foundation[$key] != $value) echo 'missing(foundation): ' . $key . '<br />';
//}
//$p['PUCOMDIS']  = 1; // Communicable Disease
//$p['PUDMEP']    = 1; // Disaster Management and Emergency Planning
//$p['PUEH']      = 1; // Environmental Health: Investigating a problem
//$p['PUHIVAIDS'] = 1; // HIV/AIDS
//$p['PUMM']      = 1; // Maternal Mortality
//$p['PUNCD']     = 1; // Non-Communicable Diseases 1: Diabetes and Cardiovascular Diseases
//$p['PUPCM']     = 1; // Preventing Child Mortality
//$p['PUPHNUT']   = 1; // Public Health Nutrition
//$p['PUPSAFE']   = 1; // Patient Safety
//foreach ($p as $key => $value) {
//  if ($problems[$key] != $value) echo 'missing(problems): ' . $key . '<br />';
//}

$idnumbers = $DB->get_records_sql('SELECT a.id, c.idnumber, a.fullname FROM mdl_activemodules a LEFT JOIN mdl_course c ON a.fullname=c.fullname order by a.fullname');
$first_one = TRUE;
foreach ($idnumbers as $idnumber) {
  $matched = preg_match('/^(.{4,}?)[012]+[0-9]+/', $idnumber->idnumber, $matches); // Take out course code without Year/Semester part
  if (!$matched) {
    echo '<br /><br /><b>WARNING: ' . $idnumber->fullname . ' HAS NO Course ID number(Course Code), you must assign a suitable one in Course Settings.</b>';
  }
  elseif (empty($foundation[$matches[1]]) && empty($problems[$matches[1]])) {
    if ($first_one) {
      $first_one = FALSE;
      echo '<br /><br /><b>WARNING: ' . $idnumber->fullname . ' HAS A Course ID number(Course Code) of ' . $idnumber->idnumber . ' which does not match a Peoples-uni agreed Course Code, you must assign a suitable one in Course Settings OR...';
      echo '<br />Enter a new Peoples-uni agreed Course Code for either Foundation Sciences or Public Health Problems here...</b>';
?>
<form id="addfoundationform" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markaddfoundation" value="1" />
<input type="submit" name="addfoundation" value="Add a New Foundation Sciences Course Code (DO NOT INCLUDE YEAR etc.):" style="width:45em" />
<input type="text" size="40" name="foundation" value="" />
</form>
<br />

<form id="addproblemsform" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markaddproblems" value="1" />
<input type="submit" name="addproblems" value="Add a New Public Health Problems Course Code (DO NOT INCLUDE YEAR etc.):" style="width:45em" />
<input type="text" size="40" name="problems" value="" />
</form>
<br />
<?php

    }
  }
}

?>
<br /><br />

<form id="setstudentscornerform" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="marksetstudentscorner" value="1" />
<input type="submit" name="setstudentscorner" value="Make this Module the Students Corner for future enrolments:" style="width:45em" />
<select name="studentscorner">
<?php
foreach ($courses as $course) {
  $modulename = htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8');
  if ($course->id == get_config(NULL, 'peoples_students_corner_id')) $selected = 'selected';
  else $selected = '';
?>
<option <?php echo $selected; ?> value="<?php echo $course->id; ?>" ><?php echo $modulename; ?></option>
<?php
}
?>
</select>
</form>
<br /><br />

<form id="approval_email_form" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<textarea name="value_approval_email" rows="15" cols="75" wrap="hard">
<?php echo htmlspecialchars(get_config(NULL, 'peoples_approval_email'), ENT_COMPAT, 'UTF-8'); ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="mark_approval_email" value="1" />
<input type="submit" name="set_approval_email" value="Set the above text as the New Students Approval e-mail wording (in Application Details/app.php)" style="width:45em" />
</form>
<br />

<form id="approval_old_students_email_form" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<textarea name="value_approval_old_students_email" rows="15" cols="75" wrap="hard">
<?php echo htmlspecialchars(get_config(NULL, 'peoples_approval_old_students_email'), ENT_COMPAT, 'UTF-8'); ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="mark_approval_old_students_email" value="1" />
<input type="submit" name="set_approval_old_students_email" value="Set the above text as the Returning Students Approval e-mail wording (in Application Details/app.php)" style="width:45em" />
</form>
<br />

<form id="batch_reminder_email_form" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<textarea name="value_batch_reminder_email" rows="15" cols="75" wrap="hard">
<?php echo htmlspecialchars(get_config(NULL, 'peoples_batch_reminder_email'), ENT_COMPAT, 'UTF-8'); ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="mark_batch_reminder_email" value="1" />
<input type="submit" name="set_batch_reminder_email" value="Set above text as Batch Reminder e-mail wording (in applications.php spreadsheet)" style="width:45em" />
</form>
<br />

<form id="batch_email_to_enrolled_form" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<textarea name="value_batch_email_to_enrolled" rows="15" cols="75" wrap="hard">
<?php echo htmlspecialchars(get_config(NULL, 'peoples_batch_email_to_enrolled'), ENT_COMPAT, 'UTF-8'); ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="mark_batch_email_to_enrolled" value="1" />
<input type="submit" name="set_batch_email_to_enrolled" value="Set above text as wording for the Batch e-mail to enrolled students (in coursegrades.php)" style="width:45em" />
</form>
<br />

<form id="interest_email_form" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<textarea name="value_interest_email" rows="15" cols="75" wrap="hard">
<?php echo htmlspecialchars(get_config(NULL, 'peoples_interest_email'), ENT_COMPAT, 'UTF-8'); ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="mark_interest_email" value="1" />
<input type="submit" name="set_interest_email" value="Set above text as Reply e-mail wording for Expressions of Interest (in int.php)" style="width:45em" />
</form>
<br />

<form id="batch_email_to_enrolled_missing_form" method="post" action="<?php echo $CFG->wwwroot . '/course/settings.php'; ?>">
<textarea name="value_batch_email_to_enrolled_missing" rows="15" cols="75" wrap="hard">
<?php echo htmlspecialchars(get_config(NULL, 'peoples_batch_email_to_enrolled_missing'), ENT_COMPAT, 'UTF-8'); ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="mark_batch_email_to_enrolled_missing" value="1" />
<input type="submit" name="set_batch_email_to_enrolled_missing" value="Set above text as wording for the Batch e-mail to Not Logged on students (in coursegrades.php)" style="width:45em" />
</form>
<br />

<?php
echo '<br /><br /><br />';

echo $OUTPUT->footer();


function updateformmoduleselections() {
  global $DB;

  $activemodules = $DB->get_records('activemodules');

	$listforselect = array();
	$listforunavailable = array();
	foreach ($activemodules as $activemodule) {
		if (!$activemodule->modulefull) {
			$listforselect[] = $activemodule->fullname;
		}
		else {
			$listforunavailable[] = "'" . $activemodule->fullname . "'";
		}
	}
	sort($listforselect);
	sort($listforunavailable);
	$count = count($listforunavailable);
	$listforselect = implode("\n", $listforselect);
	$listforunavailable = implode(", ", $listforunavailable);

	$text = 'Please select the first course module you are applying for from the drop down box.';
	if ($count > 1) {
		$text .= ' Note: ' . $listforunavailable . ' are not available for this semester because they are full.';
	}
	elseif ($count == 1) {
		$text .= ' Note: ' . $listforunavailable . ' is not available for this semester because it is full.';
	}

	// http://www.peoples-uni.org/forms/application-form-returning-students
  $semestercomponent = $DB->get_record_sql('SELECT value, extra FROM d5_webform_component WHERE nid=80 AND cid=3');

	$extra = unserialize($semestercomponent->extra);
	$extra['items'] = $listforselect;
	$extra['description'] = $text;

  $ret = $DB->execute("UPDATE d5_webform_component SET extra=? WHERE nid=80 AND cid=3", array(serialize($extra)));

  $semestercomponent = $DB->get_record_sql('SELECT value, extra FROM d5_webform_component WHERE nid=80 AND cid=4');

	$extra = unserialize($semestercomponent->extra);
	$extra['items'] = $listforselect;

  $ret = $DB->execute("UPDATE d5_webform_component SET extra=? WHERE nid=80 AND cid=4", array(serialize($extra)));

	// http://www.peoples-uni.org/forms/peoples-uni-course-application-form
  $semestercomponent = $DB->get_record_sql('SELECT value, extra FROM d5_webform_component WHERE nid=71 AND cid=18');
	$extra = unserialize($semestercomponent->extra);
	$extra['items'] = $listforselect;
	$extra['description'] = $text;
  $ret = $DB->execute("UPDATE d5_webform_component SET extra=? WHERE nid=71 AND cid=18", array(serialize($extra)));
  $semestercomponent = $DB->get_record_sql('SELECT value, extra FROM d5_webform_component WHERE nid=71 AND cid=19');
	$extra = unserialize($semestercomponent->extra);
	$extra['items'] = $listforselect;
  $ret = $DB->execute("UPDATE d5_webform_component SET extra=? WHERE nid=71 AND cid=19", array(serialize($extra)));
}


function dontaddslashes($x) {
  return $x;
}


function dontstripslashes($x) {
  return $x;
}
?>
