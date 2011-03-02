<?php  // $Id: posts.php,v 1.1 2008/12/15 22:33:00 alanbarrett Exp $
/**
*
* Lists Forum Posts
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');


if (!empty($_POST['markfilter'])) {
	redirect($CFG->wwwroot . '/course/posts.php?'
		. 'chosensemester=' . urlencode(stripslashes($_POST['chosensemester']))
		. '&chosenmodule=' . urlencode(stripslashes($_POST['chosenmodule']))
		. (empty($_POST['skipintro']) ? '&skipintro=0' : '&skipintro=1')
		. (empty($_POST['suppressnames']) ? '&suppressnames=0' : '&suppressnames=1')
		. (empty($_POST['showyesonly']) ? '&showyesonly=0' : '&showyesonly=1')
		);
}


require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = isteacherinanycourse();
if (!$isteacher) {
	echo '<h1>You must be a teacher to do this!</h1>';
	notice('Please Login Below', "$CFG->wwwroot/");
}

print_header('Posts for Enrolled Students');
echo '<h1>Posts for Enrolled Students</h1>';


if (!empty($_REQUEST['chosensemester'])) $chosensemester = stripslashes($_REQUEST['chosensemester']);
if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = stripslashes($_REQUEST['chosenmodule']);
if (!empty($_REQUEST['skipintro'])) $skipintro = true;
else $skipintro = false;
if (!empty($_REQUEST['suppressnames'])) $suppressnames = true;
else $suppressnames = false;
if (!empty($_REQUEST['showyesonly'])) $showyesonly = true;
else $showyesonly = false;

$semesters = get_records('semesters', '', '', 'id DESC');
foreach ($semesters as $semester) {
	$listsemester[] = $semester->semester;
	if (!isset($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

$courses = get_records_sql(
"SELECT DISTINCT c.id AS courseid, c.fullname
FROM mdl_enrolment e, mdl_course c
WHERE e.courseid=c.id
ORDER BY fullname ASC"
);
if (!isset($chosenmodule)) $chosenmodule = 'All';
$listmodule[] = 'All';
foreach ($courses as $course) {
	$listmodule[] = htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8');
}


?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/posts.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
	<tr>
		<td>Semester</td>
		<td>Module</td>
		<td>Skip Introduction Topics</td>
		<td>Suppress Names on Posts by Student by Forum Topic Report for each Course (& use SID)</td>
		<td>Don't Show Number of Posts</td>
	</tr>
	<tr>
		<?php
		displayoptions('chosensemester', $listsemester, $chosensemester);
		displayoptions('chosenmodule', $listmodule, $chosenmodule);
		?>
		<td><input type="checkbox" name="skipintro" <?php if ($skipintro) echo ' CHECKED'; ?>></td>
		<td><input type="checkbox" name="suppressnames" <?php if ($suppressnames) echo ' CHECKED'; ?>></td>
		<td><input type="checkbox" name="showyesonly" <?php if ($showyesonly) echo ' CHECKED'; ?>></td>
	</tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/posts.php">Reset Filters</a>
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


if (empty($chosensemester) || ($chosensemester == 'All')) {
	$semestersql = '';
}
else {
	$semestersql = "AND e.semester='" . addslashes($chosensemester) . "'";
}
if (empty($chosenmodule) || ($chosenmodule == 'All')) {
	$modulesql = '';
}
else {
	$modulesql = "AND c.fullname='" . addslashes($chosenmodule) . "'";
}

$enrols = get_records_sql(
"SELECT fp.id AS postid, fd.id AS discid, e.semester, u.id as userid, u.lastname, u.firstname, c.fullname, f.name AS forumname, fp.subject
FROM mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp
WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id $semestersql $modulesql
ORDER BY e.semester, u.lastname ASC, u.firstname ASC, fullname ASC, forumname ASC, fp.subject ASC"
);

$sidsbyuseridsemester = get_records_sql('SELECT CONCAT(userid, semester) AS i, sid FROM mdl_peoplesapplication WHERE (((state & 0x38)>>3)=3 OR (state & 0x7)=3)');

echo '<table border="1" BORDERCOLOR="RED">';
echo '<tr>';
echo '<td>Family name</td>';
echo '<td>Given name</td>';
echo '<td>Module</td>';
echo '<td>Semester</td>';
echo '<td>Discussion Forum Topic</td>';
echo '<td>Subject</td>';
echo '</tr>';

$usercount = array();
$usermodulecount = array();
$topiccount = array();
$n = 0;
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {
		if ($skipintro && (substr(strtolower(trim(strip_tags($enrol->forumname))), 0, 12) === 'introduction')) {
				continue;
		}

		echo '<tr>';
		echo '<td>' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</td>';
		echo '<td>' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</td>';
		echo '<td>' . htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
		echo '<td>' . htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8') . '</td>';
		echo '<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>';
		echo '<td><a href="' . $CFG->wwwroot . '/mod/forum/discuss.php?d=' . $enrol->discid . '#p' . $enrol->postid . '" target="_blank">' . htmlspecialchars($enrol->subject, ENT_COMPAT, 'UTF-8') . '</a></td>';
		echo '</tr>';


		$hashforcourse = htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8');
		$courseswithstudentforumstats[$hashforcourse]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;

		$hashforstudent = $enrol->userid;
		if (empty($courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent])) {
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['last'] = '<td>' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['first'] = '<td>' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['course'] = '<td>' . htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['userid'] = $enrol->userid;
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['semester'] = $enrol->semester;


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
	}
}
echo '</table>';
echo '<br/>Number of Forum Postings: ' . $n;
echo '<br /><br />';


ksort($courseswithstudentforumstats);
foreach ($courseswithstudentforumstats as $coursekey => $coursewithstudentforumstats) {
	echo '<b>Posts by Student by Forum Topic for: ' . $coursekey . '...</b><br />';

	echo '<table border="1" BORDERCOLOR="RED">';
	echo '<tr>';
	if ($suppressnames) echo '<td>SID</td>';
	else echo '<td></td><td></td>';

	ksort($coursewithstudentforumstats['forums']);
	foreach ($coursewithstudentforumstats['forums'] as $forumkey => $anything) {
		echo $forumkey;
	}
	echo '</tr>';

	foreach ($coursewithstudentforumstats['students'] as $studententry) {
		echo '<tr>';
		if ($suppressnames) echo '<td>' . $sidsbyuseridsemester[$studententry['userid'] . $studententry['semester']]->sid . '</td>';
		else echo $studententry['last'] . $studententry['first'];

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

print_footer();


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
?>
