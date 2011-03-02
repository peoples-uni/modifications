<?php  // $Id: studentsubmissions.php,v 1.1 2009/5/14 18:42:00 alanbarrett Exp $
/**
*
* List all (re)submissions and (re)grades for a user
*
*/

require("../config.php");
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/lib/weblib.php');
require_once $CFG->libdir . '/gradelib.php';

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/studentsubmissions.php');

$PAGE->set_pagelayout('embedded');

require_login();
// Might possibly be Guest??... Anyway Guest user will not have any enrolment
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die(); }

// has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))
if (!is_peoples_teacher())  {echo '<h1>You do not have rights to do this!</h1>'; die(); };

$userid = required_param('id', PARAM_INT);
$hidequiz = optional_param('hidequiz', 0, PARAM_INT);

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
	echo '<h1>User does not exist!</h1>';
	die();
}

$PAGE->set_title('Student (re)Submisions & (re)Grades for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
$PAGE->set_heading('Student (re)Submisions & (re)Grades for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();

echo '<h1>Student (re)Submisions & (re)Grades for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</h1>';
echo '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $userid . '" target="_blank">User Profile for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</a>, e-mail: ' . $userrecord->email;
echo ', Last access: ' . ($userrecord->lastaccess ? format_time(time() - $userrecord->lastaccess) : get_string('never'));
echo '<br /><br /><br />';

$recorded_submissions = $DB->get_records_sql("SELECT s.*, a.course, a.name, a.assignmenttype, c.fullname FROM mdl_recorded_submissions s, mdl_assignment a, mdl_course c WHERE s.userid=$userid AND s.assignment=a.id AND a.course=c.id ORDER BY fullname ASC, name ASC, timemodified ASC");

$table = new html_table();
$table->head = array(
  'Module',
  'Assignment',
  'Assignment Type',
  'Submission Date',
  'Text Submitted',
  'Files Submitted'
  );

if (!empty($recorded_submissions)) {
	$lastmodule = '';
	$lastname = '';
	foreach ($recorded_submissions as $recorded_submission) {
    $rowdata = array();
		if ($lastmodule !== $recorded_submission->fullname) {
      $rowdata[] = '<a href="' . "$CFG->wwwroot/course/view.php?id=$recorded_submission->course" . '" target="_blank">' . htmlspecialchars($recorded_submission->fullname, ENT_COMPAT, 'UTF-8') . '</a>';
			$lastname = '';
		}
		else {
      $rowdata[] = '';
		}
		$lastmodule = $recorded_submission->fullname;

		if ($lastname !== $recorded_submission->name) {
      $rowdata[] = '<a href="' . "$CFG->wwwroot/mod/assignment/view.php?a=$recorded_submission->assignment" . '" target="_blank">' . htmlspecialchars($recorded_submission->name, ENT_COMPAT, 'UTF-8') . '</a>';
      $rowdata[] = $recorded_submission->assignmenttype;
		}
		else {
      $rowdata[] = '';
      $rowdata[] = '';
		}
		$lastname = $recorded_submission->name;

    $rowdata[] = gmdate('d/M/Y H:i', $recorded_submission->timemodified);

		if ($recorded_submission->assignmenttype === 'online') {
      $rowdata[] = format_text($recorded_submission->data1, $recorded_submission->data2);
		}
		elseif ($recorded_submission->assignmenttype === 'upload') {
      $rowdata[] = format_text($recorded_submission->data1, FORMAT_HTML);
		}
		else {
      $rowdata[] = '';
		}

		if ($recorded_submission->assignmenttype === 'upload' || $recorded_submission->assignmenttype === 'uploadsingle') {
			// echo '<td><a href="' . "$CFG->dataroot/$recorded_submission->course/moddata/assignmentsubmissionrecord/$recorded_submission->assignment/$recorded_submission->userid/$recorded_submission->timemodified" . '" target="_blank">Sumbitted Files</a></td>';

	    $basedir  = "$CFG->dataroot/$recorded_submission->course/moddata/assignmentsubmissionrecord/$recorded_submission->assignment/$recorded_submission->userid/$recorded_submission->timemodified";
			$filearea = "/$recorded_submission->course/moddata/assignmentsubmissionrecord/$recorded_submission->assignment/$recorded_submission->userid/$recorded_submission->timemodified";

			$output = '';
        if ($files = get_directory_list($basedir)) {
          require_once($CFG->libdir.'/filelib.php');
          foreach ($files as $key => $file) {

            $ffurl = file_encode_url($CFG->wwwroot . '/course/peoplesfile.php' . $filearea . '/' . $file);
            $output .= '<a href="' . $ffurl . '" >';

            $icon = mimeinfo('icon', $file);
            $mimetype = mimeinfo('type', $file);
            $output .= '<img src="' . $OUTPUT->pix_url(file_mimetype_icon($mimetype)) . '" class="icon" alt="' . $mimetype . '" />';

            $output .= s($file);
            $output .= '</a><br />';
          }
        }
      $rowdata[] = '<div class="files">'.$output.'</div>';
		}
		else {
      $rowdata[] = '';
		}

    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);
echo '<br /><br />';


//$grade_grades_historys = get_records_sql("SELECT g.id AS gid, g.source, g.timemodified AS gtimemodified, g.finalgrade, g.feedback, g.feedbackformat, g.information, g.informationformat, s.scale, i.*, c.fullname FROM mdl_grade_grades_history g LEFT JOIN mdl_scale s ON g.rawscaleid=s.id, mdl_grade_items i, mdl_course c WHERE g.userid=$userid AND g.itemid=i.id AND i.courseid=c.id ORDER BY fullname ASC, itemname ASC, g.timemodified ASC");
$grade_grades_historys = $DB->get_records_sql("SELECT g.id AS gid, g.source, g.timemodified AS gtimemodified, g.finalgrade, g.feedback, g.feedbackformat, g.information, g.informationformat, i.*, c.fullname FROM mdl_grade_grades_history g, mdl_grade_items i, mdl_course c WHERE g.userid=$userid AND g.itemid=i.id AND i.courseid=c.id ORDER BY fullname ASC, itemname ASC, g.timemodified ASC");

$table = new html_table();
$table->head = array(
  'Module',
  'Grade Item',
  'Grade Type',
  'Grade Date',
  'Grade',
  'Feedback',
  'Information'
  );

if (!empty($grade_grades_historys)) {
	$lastmodule = 'XxxxYxxxX';
	$lastname = 'XxxxYxxxX';
	$lastsource = 'XxxxYxxxX';
	foreach ($grade_grades_historys as $grade_grades_history) {
    $rowdata = array();

		if (!empty($grade_grades_history->source) && !empty($grade_grades_history->itemtype) && (
				(($grade_grades_history->source . ' ' . $grade_grades_history->itemtype) === 'system course') ||
				((($grade_grades_history->source . ' ' . $grade_grades_history->itemtype) === 'mod/quiz mod') && $hidequiz)
		)) {
			continue;
		}

		if ($lastmodule !== $grade_grades_history->fullname) {
      $rowdata[] = '<a href="' . "$CFG->wwwroot/course/view.php?id=$grade_grades_history->courseid" . '" target="_blank">' . htmlspecialchars($grade_grades_history->fullname, ENT_COMPAT, 'UTF-8') . '</a>';
			$lastname = 'XxxxYxxxX';
		}
		else {
      $rowdata[] = '';
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
      $rowdata[] = $prefix . htmlspecialchars($grade_grades_history->itemname, ENT_COMPAT, 'UTF-8') . $outcome . $suffix;
			$lastsource = 'XxxxYxxxX';
		}
		else {
      $rowdata[] = '';
		}
		$lastname = $grade_grades_history->itemname;

		if (empty($grade_grades_history->source)) $grade_grades_history->source = ' ';
		if (empty($grade_grades_history->itemtype)) $grade_grades_history->itemtype = ' ';
		if ($lastsource !== ($grade_grades_history->source . ' ' . $grade_grades_history->itemtype)) {
      $rowdata[] = $grade_grades_history->source . ' ' . $grade_grades_history->itemtype;
		}
		else {
      $rowdata[] = '';
		}
		$lastsource = $grade_grades_history->source . ' ' . $grade_grades_history->itemtype;

    $rowdata[] = gmdate('d/M/Y H:i', $grade_grades_history->gtimemodified);

    $rowdata[] = $prefix . grade_format_gradevalue($grade_grades_history->finalgrade, new grade_item($grade_grades_history, false), true) . $suffix;
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

		if (!empty($grade_grades_history->feedback)) {
      $rowdata[] = format_text($grade_grades_history->feedback, $grade_grades_history->feedbackformat);
		}
		else {
      $rowdata[] = '';
		}

		if (!empty($grade_grades_history->information)) {
      $rowdata[] = format_text($grade_grades_history->information, $grade_grades_history->informationformat);
		}
		else {
      $rowdata[] = '';
		}

    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);
echo '<br /><br />';


echo '<a href="' . $CFG->wwwroot . '/course/student.php?id=' . $userid . '" >Student Grades</a><br />';


echo '<br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';

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
    SELECT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.name IN ('Teacher', 'Teachers') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>
