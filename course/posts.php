<?php  // $Id: posts.php,v 1.1 2008/12/15 22:33:00 alanbarrett Exp $
/**
*
* Lists Forum Posts
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/posts.php');


if (!empty($_POST['markfilter'])) {
	redirect($CFG->wwwroot . '/course/posts.php?'
		. 'chosensemester=' . urlencode(dontstripslashes($_POST['chosensemester']))
		. '&chosenmodule=' . urlencode(dontstripslashes($_POST['chosenmodule']))
    . '&chosenssf=' . urlencode(dontstripslashes($_POST['chosenssf']))
    . '&chosenusersearch=' . urlencode(dontstripslashes($_POST['chosenusersearch']))
    . '&acceptedmmu=' . urlencode(dontstripslashes($_POST['acceptedmmu']))
		. (empty($_POST['skipintro']) ? '&skipintro=0' : '&skipintro=1')
		. (empty($_POST['suppressnames']) ? '&suppressnames=0' : '&suppressnames=1')
		. (empty($_POST['showyesonly']) ? '&showyesonly=0' : '&showyesonly=1')
		);
}


$PAGE->set_pagelayout('embedded');

require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
if (!$isteacher) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/posts.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please Click "Continue" below, and then log in with your username and password above!</b><br /><br /><br />', "$CFG->wwwroot/");
}

echo '<h1>Posts for Enrolled Students</h1>';
$PAGE->set_title('Posts for Enrolled Students');
$PAGE->set_heading('Posts for Enrolled Students');
echo $OUTPUT->header();


if (!empty($_REQUEST['chosensemester'])) $chosensemester = dontstripslashes($_REQUEST['chosensemester']);
if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = dontstripslashes($_REQUEST['chosenmodule']);
if (!empty($_REQUEST['chosenssf'])) $chosenssf = dontstripslashes($_REQUEST['chosenssf']);
if (!empty($_REQUEST['chosenusersearch'])) $chosenusersearch = dontstripslashes($_REQUEST['chosenusersearch']);
else $chosenusersearch = '';
if (!empty($_REQUEST['acceptedmmu'])) $acceptedmmu = dontstripslashes($_REQUEST['acceptedmmu']);
if (!empty($_REQUEST['skipintro'])) $skipintro = true;
else $skipintro = false;
if (!empty($_REQUEST['suppressnames'])) $suppressnames = true;
else $suppressnames = false;
if (!empty($_REQUEST['showyesonly'])) $showyesonly = true;
else $showyesonly = false;

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
	$listsemester[] = $semester->semester;
	if (!isset($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

$courses = $DB->get_records_sql(
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

$studentsupportforumsnames = $DB->get_records('forum', array('course' => get_config(NULL, 'peoples_student_support_id')));
if (!isset($chosenssf)) $chosenssf = 'All';
$listssf[] = 'All';
foreach ($studentsupportforumsnames as $studentsupportforumsname) {
  $listssf[] = htmlspecialchars($studentsupportforumsname->name, ENT_COMPAT, 'UTF-8');
}
natsort($listssf);

$listacceptedmmu[] = 'Any';
if (!isset($acceptedmmu)) $acceptedmmu = 'Any';
$listacceptedmmu[] = 'Yes';
$listacceptedmmu[] = 'No';
for ($year = 11; $year <= 16; $year++) {
  $listacceptedmmu[] = "Accepted {$year}a";
  $listacceptedmmu[] = "Accepted {$year}b";

  $stamp_range["Accepted {$year}a"]['start'] = gmmktime( 0, 0, 0,  1,  1, 2000 + $year);
  $stamp_range["Accepted {$year}a"]['end']   = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['start'] = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['end']   = gmmktime(24, 0, 0, 12, 31, 2000 + $year);
}


?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/posts.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
	<tr>
		<td>Semester</td>
		<td>Module</td>
    <td>Students from this SSF only</td>
    <td>User Name Contains</td>
    <td>Accepted MMU?</td>
		<td>Skip Introduction Topics</td>
		<td>Suppress Names on Posts by Student by Forum Topic Report for each Course (& use SID)</td>
		<td>Don't Show Number of Posts</td>
	</tr>
	<tr>
		<?php
		displayoptions('chosensemester', $listsemester, $chosensemester);
		displayoptions('chosenmodule', $listmodule, $chosenmodule);
    displayoptions('chosenssf', $listssf, $chosenssf);
    ?>
    <td><input type="text" size="15" name="chosenusersearch" value="<?php echo htmlspecialchars($chosenusersearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <?php
    displayoptions('acceptedmmu', $listacceptedmmu, $acceptedmmu);
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
  $chosensemester = 'All';
  $semestersql = 'AND e.semester!=?';
}
else {
  $semestersql = 'AND e.semester=?';
}
if (empty($chosenmodule) || ($chosenmodule == 'All')) {
  $chosenmodule = 'All';
  $modulesql = 'AND c.fullname!=?';
}
else {
  $modulesql = 'AND c.fullname=?';
}
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
    $ssfsql = '';
  }
}


$enrols = $DB->get_records_sql(
"SELECT fp.id AS postid, fd.id AS discid, e.semester, u.id as userid, u.lastname, u.firstname, c.fullname, f.name AS forumname, fp.subject, m.id IS NOT NULL AS mph, m.datesubmitted AS mphdatestamp
FROM (mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp)
LEFT JOIN mdl_peoplesmph m ON e.userid=m.userid
WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id $semestersql $modulesql $ssfsql
ORDER BY e.semester, u.lastname ASC, u.firstname ASC, fullname ASC, forumname ASC, fp.subject ASC",
array($chosensemester, $chosenmodule)
);

$sidsbyuseridsemester = $DB->get_records_sql('SELECT CONCAT(userid, semester) AS i, sid FROM mdl_peoplesapplication WHERE (((state & 0x38)>>3)=3 OR (state & 0x7)=3)');

$table = new html_table();
$table->head = array(
  'Family name',
  'Given name',
  'Module',
  'Semester',
  'Discussion Forum Topic',
  'Subject'
  );

$usercount = array();
$usermodulecount = array();
$topiccount = array();
$n = 0;
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {

    if (!empty($chosenusersearch) &&
      stripos($enrol->lastname, $chosenusersearch) === false &&
      stripos($enrol->firstname, $chosenusersearch) === false) {
      continue;
    }

    if (!empty($acceptedmmu) && $acceptedmmu !== 'Any') {
      if ($acceptedmmu === 'No' && $enrol->mph) {
        continue;
      }
      if ($acceptedmmu === 'Yes' && !$enrol->mph) {
        continue;
      }
      if ($acceptedmmu !== 'No' && $acceptedmmu !== 'Yes') {
        if (!$enrol->mph || $enrol->mphdatestamp < $stamp_range[$acceptedmmu]['start'] || $enrol->mphdatestamp >= $stamp_range[$acceptedmmu]['end']) {
          continue;
        }
      }
    }

		if ($skipintro && (substr(strtolower(trim(strip_tags($enrol->forumname))), 0, 12) === 'introduction')) {
				continue;
		}

    $rowdata = array();
    $rowdata[] = htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8');
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
      r.name IN ('Module Leader', 'Tutors', 'Student coordinator', 'Education coordinator_old') AND
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
