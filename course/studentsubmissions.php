<?php  // $Id: studentsubmission.php,v 1.1 2009/5/14 18:42:00 alanbarrett Exp $
/**
*
* List all (re)submissions and (re)grades for a user
*
*/

require("../config.php");
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/lib/weblib.php');
require_once $CFG->libdir . '/gradelib.php';


require_login();
// Might possibly be Guest??... Anyway Guest user will not have any enrolment
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die(); }

// has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))
if (!isteacherinanycourse())  {echo '<h1>You do not have rights to do this!</h1>'; die(); };

print_header('Student (re)Submissions & (re)Grades');

$userid = required_param('id', PARAM_INT);
$hidequiz = optional_param('hidequiz', 0, PARAM_INT);

$userrecord = get_record('user', 'id', $userid);
if (empty($userrecord)) {
	echo '<h1>User does not exist!</h1>';
	die();
}

echo '<h1>Student (re)Submisions & (re)Grades for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</h1>';
echo '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $userid . '" target="_blank">User Profile for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</a>, e-mail: ' . $userrecord->email;
echo ', Last access: ' . ($userrecord->lastaccess ? format_time(time() - $userrecord->lastaccess) : get_string('never'));
echo '<br /><br /><br />';

$recorded_submissions = get_records_sql("SELECT s.*, a.course, a.name, a.assignmenttype, c.fullname FROM mdl_recorded_submissions s, mdl_assignment a, mdl_course c WHERE s.userid=$userid AND s.assignment=a.id AND a.course=c.id ORDER BY fullname ASC, name ASC, timemodified ASC");

echo '<table border="1" BORDERCOLOR="RED">';
echo '<tr>';
echo '<td>Module</td>';
echo '<td>Assignment</td>';
echo '<td>Assignment Type</td>';
echo '<td>Submission Date</td>';
echo '<td>Text Submitted</td>';
echo '<td>Files Submitted</td>';
echo "</tr>";

if (!empty($recorded_submissions)) {
	$lastmodule = '';
	$lastname = '';
	foreach ($recorded_submissions as $recorded_submission) {
		echo '<tr>';
		if ($lastmodule !== $recorded_submission->fullname) {
			echo '<td><a href="' . "$CFG->wwwroot/course/view.php?id=$recorded_submission->course" . '" target="_blank">' . htmlspecialchars($recorded_submission->fullname, ENT_COMPAT, 'UTF-8') . '</a></td>';
			$lastname = '';
		}
		else {
			echo '<td></td>';
		}
		$lastmodule = $recorded_submission->fullname;

		if ($lastname !== $recorded_submission->name) {
			echo '<td><a href="' . "$CFG->wwwroot/mod/assignment/view.php?a=$recorded_submission->assignment" . '" target="_blank">' . htmlspecialchars($recorded_submission->name, ENT_COMPAT, 'UTF-8') . '</a></td>';
			echo '<td>' . $recorded_submission->assignmenttype . '</td>';
		}
		else {
			echo '<td></td><td></td>';
		}
		$lastname = $recorded_submission->name;

		echo '<td>' . gmdate('d/M/Y H:i', $recorded_submission->timemodified) . '</td>';

		if ($recorded_submission->assignmenttype === 'online') {
			echo '<td>';
			echo format_text($recorded_submission->data1, $recorded_submission->data2);
			echo '</td>';
		}
		elseif ($recorded_submission->assignmenttype === 'upload') {
			echo '<td>';
			echo format_text($recorded_submission->data1, FORMAT_HTML);
			echo '</td>';
		}
		else {
			echo '<td></td>';
		}

		if ($recorded_submission->assignmenttype === 'upload' || $recorded_submission->assignmenttype === 'uploadsingle') {
			// echo '<td><a href="' . "$CFG->dataroot/$recorded_submission->course/moddata/assignmentsubmissionrecord/$recorded_submission->assignment/$recorded_submission->userid/$recorded_submission->timemodified" . '" target="_blank">Sumbitted Files</a></td>';

	        $basedir  = "$CFG->dataroot/$recorded_submission->course/moddata/assignmentsubmissionrecord/$recorded_submission->assignment/$recorded_submission->userid/$recorded_submission->timemodified";
			$filearea = "/$recorded_submission->course/moddata/assignmentsubmissionrecord/$recorded_submission->assignment/$recorded_submission->userid/$recorded_submission->timemodified";

			$output = '';
            if ($files = get_directory_list($basedir)) {
                require_once($CFG->libdir.'/filelib.php');
                foreach ($files as $key => $file) {
                    $icon = mimeinfo('icon', $file);
                    $ffurl = get_file_url("$filearea/$file", array('forcedownload'=>1));

                    $output .= '<img src="'.$CFG->pixpath.'/f/'.$icon.'" class="icon" alt="'.$icon.'" />'.'<a href="'.$ffurl.'" >'.$file.'</a><br />';
                }
            }
			echo '<td><div class="files">'.$output.'</div></td>';
		}
		else {
			echo '<td></td>';
		}

		echo '</tr>';
	}

}

echo '</table>';
echo '<br /><br />';


//$grade_grades_historys = get_records_sql("SELECT g.id AS gid, g.source, g.timemodified AS gtimemodified, g.finalgrade, g.feedback, g.feedbackformat, g.information, g.informationformat, s.scale, i.*, c.fullname FROM mdl_grade_grades_history g LEFT JOIN mdl_scale s ON g.rawscaleid=s.id, mdl_grade_items i, mdl_course c WHERE g.userid=$userid AND g.itemid=i.id AND i.courseid=c.id ORDER BY fullname ASC, itemname ASC, g.timemodified ASC");
$grade_grades_historys = get_records_sql("SELECT g.id AS gid, g.source, g.timemodified AS gtimemodified, g.finalgrade, g.feedback, g.feedbackformat, g.information, g.informationformat, i.*, c.fullname FROM mdl_grade_grades_history g, mdl_grade_items i, mdl_course c WHERE g.userid=$userid AND g.itemid=i.id AND i.courseid=c.id ORDER BY fullname ASC, itemname ASC, g.timemodified ASC");

echo '<table border="1" BORDERCOLOR="RED">';
echo '<tr>';
echo '<td>Module</td>';
echo '<td>Grade Item</td>';
echo '<td>Grade Type</td>';
echo '<td>Grade Date</td>';
echo '<td>Grade</td>';
echo '<td>Feedback</td>';
echo '<td>Information</td>';
echo "</tr>";

if (!empty($grade_grades_historys)) {
	$lastmodule = 'XxxxYxxxX';
	$lastname = 'XxxxYxxxX';
	$lastsource = 'XxxxYxxxX';
	foreach ($grade_grades_historys as $grade_grades_history) {

		if (!empty($grade_grades_history->source) && !empty($grade_grades_history->itemtype) && (
				(($grade_grades_history->source . ' ' . $grade_grades_history->itemtype) === 'system course') ||
				((($grade_grades_history->source . ' ' . $grade_grades_history->itemtype) === 'mod/quiz mod') && $hidequiz)
		)) {
			continue;
		}

		echo '<tr>';
		if ($lastmodule !== $grade_grades_history->fullname) {
			echo '<td><a href="' . "$CFG->wwwroot/course/view.php?id=$grade_grades_history->courseid" . '" target="_blank">' . htmlspecialchars($grade_grades_history->fullname, ENT_COMPAT, 'UTF-8') . '</a></td>';
			$lastname = 'XxxxYxxxX';
		}
		else {
			echo '<td></td>';
		}
		$lastmodule = $grade_grades_history->fullname;

		if ($grade_grades_history->itemtype === 'course') {
			$grade_grades_history->itemname = 'Overall Module Grade';
			$prefix = '<strong>';
			$suffix = '</strong>';
		}
		else {
			$prefix = '';
			$suffix = '';
		}

		if (empty($grade_grades_history->itemname)) $grade_grades_history->itemname = '';
		if ($lastname !== $grade_grades_history->itemname) {
			if (!empty($grade_grades_history->outcomeid)) $outcome = ' (Outcome)';
			else  $outcome = '';
			echo '<td>' . $prefix . htmlspecialchars($grade_grades_history->itemname, ENT_COMPAT, 'UTF-8') . $outcome . $suffix . '</td>';
			$lastsource = 'XxxxYxxxX';
		}
		else {
			echo '<td></td>';
		}
		$lastname = $grade_grades_history->itemname;

		if (empty($grade_grades_history->source)) $grade_grades_history->source = ' ';
		if (empty($grade_grades_history->itemtype)) $grade_grades_history->itemtype = ' ';
		if ($lastsource !== ($grade_grades_history->source . ' ' . $grade_grades_history->itemtype)) {
			echo '<td>' . $grade_grades_history->source . ' ' . $grade_grades_history->itemtype . '</td>';
		}
		else {
			echo '<td></td>';
		}
		$lastsource = $grade_grades_history->source . ' ' . $grade_grades_history->itemtype;

		echo '<td>' . gmdate('d/M/Y H:i', $grade_grades_history->gtimemodified) . '</td>';

		echo '<td>';

		echo $prefix . grade_format_gradevalue($grade_grades_history->finalgrade, new grade_item($grade_grades_history, false), true) . $suffix;

//		if (empty($grade_grades_history->finalgrade)) {
//			echo 'No Grade';
//		}
//		elseif (empty($grade_grades_history->scale)) {
//			echo $grade_grades_history->finalgrade;
//		}
//		else {
//			$scale = explode(',', $grade_grades_history->scale);
//			$grade = (int)($grade_grades_history->finalgrade + .000001);
//			if (empty($scale[$grade - 1])) {
//				echo $grade_grades_history->finalgrade;
//			}
//			else {
//				echo trim($scale[$grade - 1]);
//			}
//		}
		echo '</td>';

		if (!empty($grade_grades_history->feedback)) {
			echo '<td>';
			echo format_text($grade_grades_history->feedback, $grade_grades_history->feedbackformat);
			echo '</td>';
		}
		else {
			echo '<td></td>';
		}

		if (!empty($grade_grades_history->information)) {
			echo '<td>';
			echo format_text($grade_grades_history->information, $grade_grades_history->informationformat);
			echo '</td>';
		}
		else {
			echo '<td></td>';
		}

		echo '</tr>';
	}
}

echo '</table>';
echo '<br /><br />';


echo '<a href="' . $CFG->wwwroot . '/course/student.php?id=' . $userid . '" >Student Grades</a><br />';


echo '<br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';

print_footer();
?>
