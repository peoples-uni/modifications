<?php  // $Id: tutorposts.php,v 1.1 2011/02/02 14:33:00 alanbarrett Exp $
/**
*
* Lists Forum Posts for Tutors
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');


if (!empty($_POST['markfilter'])) {
	redirect($CFG->wwwroot . '/course/tutorposts.php?'
		. 'chosensemester=' . urlencode(stripslashes($_POST['chosensemester']))
		. '&chosenmodule=' . urlencode(stripslashes($_POST['chosenmodule']))
		. (empty($_POST['skipintro']) ? '&skipintro=0' : '&skipintro=1')
		);
}


require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = isteacherinanycourse();
if (!$isteacher) {
	echo '<h1>You must be a teacher to do this!</h1>';
	notice('Please Login Below', "$CFG->wwwroot/");
}

print_header('Posts for Tutors');
echo '<h1>Posts for Tutors</h1>';


if (!empty($_REQUEST['chosensemester'])) $chosensemester = stripslashes($_REQUEST['chosensemester']);
if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = stripslashes($_REQUEST['chosenmodule']);
if (!empty($_REQUEST['skipintro'])) $skipintro = true;
else $skipintro = false;

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
<form method="post" action="<?php echo $CFG->wwwroot . '/course/tutorposts.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
	<tr>
		<td>Semester</td>
		<td>Module</td>
		<td>Skip Introduction Topics</td>
	</tr>
	<tr>
		<?php
		displayoptions('chosensemester', $listsemester, $chosensemester);
		displayoptions('chosenmodule', $listmodule, $chosenmodule);
		?>
		<td><input type="checkbox" name="skipintro" <?php if ($skipintro) echo ' CHECKED'; ?>></td>
	</tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/tutorposts.php">Reset Filters</a>
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

$modules = get_records_sql("
  SELECT DISTINCT e.courseid, c.fullname
  FROM mdl_enrolment e, mdl_course c
  WHERE e.enrolled!=0 AND e.courseid=c.id $semestersql $modulesql
  ORDER BY e.semester, c.fullname ASC");

echo '<table border="1" BORDERCOLOR="RED">';
echo '<tr>';
echo '<td>Module</td>';
echo '<td>Discussion Forum Topic</td>';
echo '<td>Subject</td>';
echo '<td>Date</td>';
echo '<td>Family name</td>';
echo '<td>Given name</td>';
echo '<td>e-mail</td>';
echo '</tr>';

$usercount = array();
$usermodulecount = array();
$topiccount = array();
$n = 0;
foreach($modules as $module) {
  echo '<tr>';
  echo '<td colspan="7"><b>' . $module->fullname . '</b></td>';
  echo '</tr>';

  $context = get_context_instance(CONTEXT_COURSE, $module->courseid);

  $tutors = get_record_sql("
    SELECT GROUP_CONCAT(ra.userid SEPARATOR ', ') AS tutors
    FROM mdl_role_assignments ra, mdl_role r
    WHERE
      ra.contextid=$context->id AND
      ra.roleid=r.id AND
      r.name IN ('Teacher', 'Teachers')");

  $posts = get_records_sql("
    SELECT fp.id AS postid, fd.id AS discid, u.id as userid, u.lastname, u.firstname, u.email, c.fullname, f.name AS forumname, fp.subject, fp.modified
    FROM mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp
    WHERE c.id=$module->courseid AND fp.userid=u.id AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id AND u.id IN ($tutors->tutors)
    ORDER BY fp.modified DESC, u.lastname ASC, u.firstname ASC, forumname ASC, fp.subject ASC");

	foreach ($posts as $post) {
		if ($skipintro && (substr(strtolower(trim(strip_tags($post->forumname))), 0, 12) === 'introduction')) {
				continue;
		}

		echo '<tr>';
		//echo '<td>' . htmlspecialchars($post->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
    echo '<td></td>';
    echo '<td>' . htmlspecialchars($post->forumname, ENT_COMPAT, 'UTF-8') . '</td>';
		echo '<td><a href="' . $CFG->wwwroot . '/mod/forum/discuss.php?d=' . $post->discid . '#p' . $post->postid . '" target="_blank">' . htmlspecialchars($post->subject, ENT_COMPAT, 'UTF-8') . '</a></td>';
    echo '<td>' . gmdate('d/m/Y', $post->modified) . '</td>';
    echo '<td>' . htmlspecialchars($post->lastname, ENT_COMPAT, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($post->firstname, ENT_COMPAT, 'UTF-8') . '</td>';
    echo '<td><a href="mailto:' . $post->email . '">' . $post->email . '</a></td>';
		echo '</tr>';


		$hashforcourse = htmlspecialchars($post->fullname, ENT_COMPAT, 'UTF-8');
		$courseswithstudentforumstats[$hashforcourse]['forums']['<td>' . htmlspecialchars($post->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;

		$hashforstudent = $post->userid;
		if (empty($courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent])) {
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['last'] = '<td>' . htmlspecialchars($post->lastname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['first'] = '<td>' . htmlspecialchars($post->firstname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['course'] = '<td>' . htmlspecialchars($post->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['userid'] = $post->userid;
			//$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['semester'] = $post->semester;


			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($post->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;
		}
		else {
			if (empty($courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($post->forumname, ENT_COMPAT, 'UTF-8') . '</td>'])) {
				$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($post->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;
			}
			else {
				$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($post->forumname, ENT_COMPAT, 'UTF-8') . '</td>']++;
			}
		}


		$name = htmlspecialchars(strtolower(trim($post->lastname . ', ' . $post->firstname)), ENT_COMPAT, 'UTF-8');
		if (empty($usercount[$name])) {
			$usercount[$name] = 1;
		}
		else {
			$usercount[$name]++;
		}

		$name = htmlspecialchars(strtolower(trim($post->lastname . ', ' . $post->firstname . ', ' . $post->fullname)), ENT_COMPAT, 'UTF-8');
		if (empty($usermodulecount[$name])) {
			$usermodulecount[$name] = 1;
		}
		else {
			$usermodulecount[$name]++;
		}

		$name = htmlspecialchars(strtolower(trim($post->fullname . ', ' . $post->forumname)), ENT_COMPAT, 'UTF-8');
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
	echo '<b>Posts by Tutor by Forum Topic for: ' . $coursekey . '...</b><br />';

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
      else echo '<td>' . $studententry['forums'][$forumkey] . '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	echo '<br /><br />';
}
echo '<br />';


displaystat($usercount, 'Tutor Posts');
echo 'Number of Tutors who Posted: ' . count($usercount);
echo '<br /><br />';

displaystat($usermodulecount, 'Tutor Posts per Module');
echo 'Number of Tutors who Posted per Module: ' . count($usermodulecount);
echo '<br /><br />';

displaystat($topiccount, 'Tutor Posts by Forum Topic');
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
