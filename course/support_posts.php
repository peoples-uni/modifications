<?php  // $Id: support_posts.php,v 1.1 2013/03/07 12:40:00 alanbarrett Exp $
/**
*
* Lists Student Support Forum Posts
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/support_posts.php');


if (!empty($_POST['markfilter'])) {
	redirect($CFG->wwwroot . '/course/support_posts.php?'
    . '&chosenstartyear=' . $_POST['chosenstartyear']
    . '&chosenstartmonth=' . $_POST['chosenstartmonth']
    . '&chosenstartday=' . $_POST['chosenstartday']
    . '&chosenendyear=' . $_POST['chosenendyear']
    . '&chosenendmonth=' . $_POST['chosenendmonth']
    . '&chosenendday=' . $_POST['chosenendday']
    . '&chosenforumsearch=' . urlencode(dontstripslashes($_POST['chosenforumsearch']))
    . '&chosenusersearch=' . urlencode(dontstripslashes($_POST['chosenusersearch']))
		. (empty($_POST['skipintro']) ? '&skipintro=0' : '&skipintro=1')
		);
}


$PAGE->set_pagelayout('embedded');

require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
if (!$isteacher) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/support_posts.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please Click "Continue" below, and then log in with your username and password above!</b><br /><br /><br />', "$CFG->wwwroot/");
}

echo '<h1>Posts in Student Support Forums</h1>';
$PAGE->set_title('Posts in Student Support Forums');
$PAGE->set_heading('Posts in Student Support Forums');
echo $OUTPUT->header();


if (!empty($_REQUEST['chosenstartyear']) && !empty($_REQUEST['chosenstartmonth']) && !empty($_REQUEST['chosenstartday'])) {
  $chosenstartyear = (int)$_REQUEST['chosenstartyear'];
  $chosenstartmonth = (int)$_REQUEST['chosenstartmonth'];
  $chosenstartday = (int)$_REQUEST['chosenstartday'];
  $starttime = gmmktime(0, 0, 0, $chosenstartmonth, $chosenstartday, $chosenstartyear);
}
else {
  $starttime = 0;
}
if (!empty($_REQUEST['chosenendyear']) && !empty($_REQUEST['chosenendmonth']) && !empty($_REQUEST['chosenendday'])) {
  $chosenendyear = (int)$_REQUEST['chosenendyear'];
  $chosenendmonth = (int)$_REQUEST['chosenendmonth'];
  $chosenendday = (int)$_REQUEST['chosenendday'];
  $endtime = gmmktime(24, 0, 0, $chosenendmonth, $chosenendday, $chosenendyear);
}
else {
  $endtime = 1.0E+20;
}

if (!empty($_REQUEST['chosenforumsearch'])) $chosenforumsearch = dontstripslashes($_REQUEST['chosenforumsearch']);
else $chosenforumsearch = '';

if (!empty($_REQUEST['chosenusersearch'])) $chosenusersearch = dontstripslashes($_REQUEST['chosenusersearch']);
else $chosenusersearch = '';

if (!empty($_REQUEST['skipintro'])) $skipintro = true;
else $skipintro = false;


for ($i = 2008; $i <= (int)gmdate('Y'); $i++) {
  if (!isset($chosenstartyear)) $chosenstartyear = $i;
  $liststartyear[] = $i;
}

for ($i = 1; $i <= 12; $i++) {
  if (!isset($chosenstartmonth)) $chosenstartmonth = $i;
  $liststartmonth[] = $i;
}

for ($i = 1; $i <= 31; $i++) {
  if (!isset($chosenstartday)) $chosenstartday = $i;
  $liststartday[] = $i;
}

for ($i = (int)gmdate('Y'); $i >= 2008; $i--) {
  if (!isset($chosenendyear)) $chosenendyear = $i;
  $listendyear[] = $i;
}

for ($i = 12; $i >= 1; $i--) {
  if (!isset($chosenendmonth)) $chosenendmonth = $i;
  $listendmonth[] = $i;
}

for ($i = 31; $i >= 1; $i--) {
  if (!isset($chosenendday)) $chosenendday = $i;
  $listendday[] = $i;
}


?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/support_posts.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
	<tr>
    <td>Start Year</td>
    <td>Start Month</td>
    <td>Start Day</td>
    <td>End Year</td>
    <td>End Month</td>
    <td>End Day</td>
    <td>Forum Name Contains</td>
    <td>User Name Contains</td>
		<td>Skip Introduction Topics</td>
	</tr>
	<tr>
		<?php
    displayoptions('chosenstartyear', $liststartyear, $chosenstartyear);
    displayoptions('chosenstartmonth', $liststartmonth, $chosenstartmonth);
    displayoptions('chosenstartday', $liststartday, $chosenstartday);
    displayoptions('chosenendyear', $listendyear, $chosenendyear);
    displayoptions('chosenendmonth', $listendmonth, $chosenendmonth);
    displayoptions('chosenendday', $listendday, $chosenendday);
		?>
    <td><input type="text" size="15" name="chosenforumsearch" value="<?php echo htmlspecialchars($chosenforumsearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <td><input type="text" size="15" name="chosenusersearch" value="<?php echo htmlspecialchars($chosenusersearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
		<td><input type="checkbox" name="skipintro" <?php if ($skipintro) echo ' CHECKED'; ?>></td>
	</tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/support_posts.php">Reset Filters</a>
</form>
<br />
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


$studentsupportforums = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_student_support_id')));

$enrols = $DB->get_records_sql(
"SELECT fp.id AS postid, fd.id AS discid, u.id as userid, u.lastname, u.firstname, c.fullname, f.name AS forumname, fp.subject, fp.modified
FROM mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp
WHERE u.id=fp.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id AND c.id=?
ORDER BY u.lastname ASC, u.firstname ASC, fullname ASC, forumname ASC, fp.subject ASC",
array($studentsupportforums->id)
);

$table = new html_table();
$table->head = array(
  'Family name',
  'Given name',
  'Discussion Forum Topic',
  'Subject'
  );

$usercount = array();
$usermodulecount = array();
$topiccount = array();
$n = 0;
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {

    if (
      $enrol->modified < $starttime ||
      $enrol->modified > $endtime
      ) {
      continue;
    }

    if (!empty($chosenforumsearch) &&
      stripos($enrol->forumname, $chosenforumsearch) === false) {
      continue;
    }

    if (!empty($chosenusersearch) &&
      stripos($enrol->lastname, $chosenusersearch) === false &&
      stripos($enrol->firstname, $chosenusersearch) === false) {
      continue;
    }

		if ($skipintro && (substr(strtolower(trim(strip_tags($enrol->forumname))), 0, 12) === 'introduction')) {
				continue;
		}

    $rowdata = array();
    $rowdata[] = htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/mod/forum/discuss.php?d=' . $enrol->discid . '#p' . $enrol->postid . '" target="_blank">' . htmlspecialchars($enrol->subject, ENT_COMPAT, 'UTF-8') . '</a>';

		$hashforcourse = htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8');
		$courseswithstudentforumstats[$hashforcourse]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;

		$hashforstudent = $enrol->userid;
		if (empty($courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent])) {
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['last'] = '<td>' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['first'] = '<td>' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['course'] = '<td>' . htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['userid'] = $enrol->userid;

			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;
		}
		else {
			if (empty($courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>'])) {
				$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;
			}
			else {
				$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>']++;
			}
		}


		$name = htmlspecialchars(strtolower(trim($enrol->lastname . ', ' . $enrol->firstname)), ENT_COMPAT, 'UTF-8');
		if (empty($usercount[$name])) {
			$usercount[$name] = 1;
		}
		else {
			$usercount[$name]++;
		}

		$name = htmlspecialchars(strtolower(trim($enrol->lastname . ', ' . $enrol->firstname . ', ' . $enrol->fullname)), ENT_COMPAT, 'UTF-8');
		if (empty($usermodulecount[$name])) {
			$usermodulecount[$name] = 1;
		}
		else {
			$usermodulecount[$name]++;
		}

		$name = htmlspecialchars(strtolower(trim($enrol->fullname . ', ' . $enrol->forumname)), ENT_COMPAT, 'UTF-8');
		if (empty($topiccount[$name])) {
			$topiccount[$name] = 1;
		}
		else {
			$topiccount[$name]++;
		}

		$n++;
    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);
echo '<br/>Number of Forum Postings: ' . $n;
echo '<br /><br />';


ksort($courseswithstudentforumstats);
foreach ($courseswithstudentforumstats as $coursekey => $coursewithstudentforumstats) {
	echo '<b>Posts by Student by Forum Topic for: ' . $coursekey . '...</b><br />';

	echo '<table border="1" BORDERCOLOR="RED">';
	echo '<tr>';
	echo '<td></td><td></td>';

	ksort($coursewithstudentforumstats['forums']);
	foreach ($coursewithstudentforumstats['forums'] as $forumkey => $anything) {
		echo $forumkey;
	}
	echo '</tr>';

	foreach ($coursewithstudentforumstats['students'] as $studententry) {
		echo '<tr>';
		echo $studententry['last'] . $studententry['first'];

		foreach ($coursewithstudentforumstats['forums'] as $forumkey => $anything) {
			if (empty($studententry['forums'][$forumkey])) echo '<td></td>';
			elseif ($showyesonly) echo '<td>Yes</td>';
			else echo '<td>' . $studententry['forums'][$forumkey] . '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	echo '<br /><br />';
}
echo '<br />';


displaystat($usercount, 'Student Posts');
echo 'Number of Students who Posted: ' . count($usercount);
echo '<br /><br />';

displaystat($usermodulecount, 'Student Posts per Module');
echo 'Number of Students who Posted per Module: ' . count($usermodulecount);
echo '<br /><br />';

displaystat($topiccount, 'Student Posts by Forum Topic');
echo 'Number of Forum Topics with Posts: ' . count($topiccount);


echo '<br /><br /><br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

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


function dontstripslashes($x) {
  return $x;
}
?>
