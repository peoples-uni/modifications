<?php  // $Id: studentsubmissions.php,v 1.1 2009/5/14 18:42:00 alanbarrett Exp $
/**
*
* List all (re)submissions and (re)grades for a user
*
*/

/*
CREATE TABLE mdl_recorded_submissions (
  id BIGINT(10) unsigned NOT NULL auto_increment,
  submission BIGINT(10) unsigned NOT NULL DEFAULT 0,
  assignment BIGINT(10) unsigned NOT NULL DEFAULT 0,
  userid BIGINT(10) unsigned NOT NULL DEFAULT 0,
  timemodified BIGINT(10) unsigned NOT NULL DEFAULT 0,
  data1 TEXT,
  data2 TEXT,
  course BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  assign BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  turnitintooltwo_submission_part BIGINT(10) unsigned NOT NULL DEFAULT 0,
  name VARCHAR(255) NOT NULL DEFAULT '',
  assignmenttype VARCHAR(50) NOT NULL DEFAULT '',
  CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_recorded_submissions_sid_ix ON mdl_recorded_submissions (submission);
CREATE INDEX mdl_recorded_submissions_aid_ix ON mdl_recorded_submissions (assignment);
CREATE INDEX mdl_recorded_submissions_a1id_ix ON mdl_recorded_submissions (assign);
CREATE INDEX mdl_recorded_submissions_a2id_ix ON mdl_recorded_submissions (turnitintooltwo_submission_part);
CREATE INDEX mdl_recorded_submissions_uid_ix ON mdl_recorded_submissions (userid);
CREATE INDEX mdl_recorded_submissions_tim_ix ON mdl_recorded_submissions (timemodified);

mdl_assignment table entries will be deleted as it is upgraded to mdl_assign (Moodle 2.3) so keep all relevant data in this table
ALTER TABLE mdl_recorded_submissions ADD course BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER data2;
ALTER TABLE mdl_recorded_submissions ADD assign BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER course;
ALTER TABLE mdl_recorded_submissions ADD name VARCHAR(255) NOT NULL DEFAULT '' AFTER assign;
ALTER TABLE mdl_recorded_submissions ADD turnitintooltwo_submission_part BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER assign;
ALTER TABLE mdl_recorded_submissions ADD assignmenttype VARCHAR(50) NOT NULL DEFAULT '' AFTER name;
*/


require("../config.php");
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/lib/weblib.php');
require_once $CFG->libdir . '/gradelib.php';
require_once($CFG->libdir . '/filelib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/studentsubmissions.php');

$PAGE->set_pagelayout('embedded');

require_login();
// Might possibly be Guest??... Anyway Guest user will not have any enrolment
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die(); }

$isteacher = is_peoples_teacher();
$islurker = has_capability('moodle/grade:viewall', context_system::instance());
if (!$isteacher && !$islurker)  {echo '<h1>You do not have rights to do this!</h1>'; die(); };

$userid = required_param('id', PARAM_INT);
$hidequiz = optional_param('hidequiz', 0, PARAM_INT);

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$PAGE->set_title('Student (re)Submissions & (re)Grades for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
$PAGE->set_heading('Student (re)Submissions & (re)Grades for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();

echo '<h1>Student (re)Submissions & (re)Grades for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</h1>';
echo '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $userid . '" target="_blank">User Profile for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</a>, e-mail: ' . $userrecord->email;
echo ', Last access: ' . ($userrecord->lastaccess ? format_time(time() - $userrecord->lastaccess) : get_string('never'));
echo '<br /><br /><br />';

$recorded_submissions = $DB->get_records_sql("SELECT s.*, c.fullname FROM mdl_recorded_submissions s, mdl_course c WHERE s.userid=$userid AND s.course=c.id ORDER BY fullname ASC, name ASC, timemodified ASC");

$context = context_user::instance($userid);

$table = new html_table();
$table->head = array(
  'Module',
  'Assignment',
  //'Assignment Type',
  'Submission Date',
  'Text Submitted',
  'Files Submitted'
  );

if (!empty($recorded_submissions)) {
  $contenthash_all_files = array();
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
      if ($recorded_submission->assign == 0) {
        $rowdata[] = '<a href="' . "$CFG->wwwroot/mod/assignment/view.php?a=$recorded_submission->assignment" . '" target="_blank">' . htmlspecialchars($recorded_submission->name, ENT_COMPAT, 'UTF-8') . '</a>';
      }
      else {
        $course_module = $DB->get_record_sql("SELECT cm.id FROM mdl_course_modules cm, mdl_modules m WHERE cm.instance=:instance AND cm.module=m.id AND m.name='assign'", array('instance' => $recorded_submission->assign));
        $rowdata[] = '<a href="' . "$CFG->wwwroot/mod/assign/view.php?id=$course_module->id" . '" target="_blank">' . htmlspecialchars($recorded_submission->name, ENT_COMPAT, 'UTF-8') . '</a>';
      }
      //$rowdata[] = $recorded_submission->assignmenttype;
    }
    else {
      $rowdata[] = '';
      //$rowdata[] = '';
    }
    $lastname = $recorded_submission->name;

    $rowdata[] = gmdate('d/M/Y H:i', $recorded_submission->timemodified);

    if ($recorded_submission->assign == 0) {
      if ($recorded_submission->assignmenttype === 'online') {
        $rowdata[] = format_text($recorded_submission->data1, $recorded_submission->data2);
      }
      elseif ($recorded_submission->assignmenttype === 'upload') {
        $rowdata[] = format_text($recorded_submission->data1, FORMAT_HTML);
      }
      else {
        $rowdata[] = '';
      }
    }
    else {
      $rowdata[] = $recorded_submission->data1; // format_text() already applied
    }

    if ($recorded_submission->assign == 0) {
      if ($recorded_submission->assignmenttype === 'upload' || $recorded_submission->assignmenttype === 'uploadsingle') {
        // echo '<td><a href="' . "$CFG->dataroot/$recorded_submission->course/moddata/assignmentsubmissionrecord/$recorded_submission->assignment/$recorded_submission->userid/$recorded_submission->timemodified" . '" target="_blank">Sumbitted Files</a></td>';

        $basedir  = "$CFG->dataroot/$recorded_submission->course/moddata/assignmentsubmissionrecord/$recorded_submission->assignment/$recorded_submission->userid/$recorded_submission->timemodified";
        $filearea = "/$recorded_submission->course/moddata/assignmentsubmissionrecord/$recorded_submission->assignment/$recorded_submission->userid/$recorded_submission->timemodified";

        $output = '';
        if ($files = get_directory_list($basedir)) {
          foreach ($files as $key => $file) {

            //$ffurl = file_encode_url($CFG->wwwroot . '/course/peoplesfile.php' . $filearea . '/' . $file);
            $ffurl = moodle_url::make_file_url($CFG->wwwroot . '/course/peoplesfile.php', $filearea . '/' . $file);
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
    }
    else {
      $output = '';
      $fs = get_file_storage();
      $stored_files = $fs->get_area_files($context->id, 'peoples_recordedsubmissions', 'student', $recorded_submission->id, 'filepath, filename', false);
      if (!empty($stored_files)) {
        foreach ($stored_files as $pathnamehash => $stored_file) {
          $filepath = $stored_file->get_filepath();
          $filename = $stored_file->get_filename();

          $fullpath = '/' . $context->id . '/peoples_recordedsubmissions/student/' . $recorded_submission->id . $filepath . $filename;
          //$ffurl = file_encode_url($CFG->wwwroot . '/course/recordedsubmissionfile.php' .  $fullpath);
          $ffurl = moodle_url::make_file_url($CFG->wwwroot . '/course/recordedsubmissionfile.php', $fullpath);
          $output .= '<a href="' . $ffurl . '" >';

          $icon = mimeinfo('icon', $filename);
          $mimetype = mimeinfo('type', $filename);
          $output .= '<img src="' . $OUTPUT->pix_url(file_mimetype_icon($mimetype)) . '" class="icon" alt="' . $mimetype . '" />';

          $output .= s($filepath . $filename);
          $output .= '</a>';

          $contenthash = $stored_file->get_contenthash();
          if (!in_array($contenthash, $contenthash_all_files)) $output .= '(*)';
          $contenthash_all_files[] = $contenthash;
          $output .= '<br />';
        }
      }
      $rowdata[] = '<div class="files">' . $output . '</div>';
    }

    $table->data[] = $rowdata;
  }
}
echo html_writer::table($table);
echo '<div style="text-align:left">(*) => file is changed.</div><br /><br />';


//$grade_grades_historys = get_records_sql("SELECT g.id AS gid, g.source, g.timemodified AS gtimemodified, g.finalgrade, g.feedback, g.feedbackformat, g.information, g.informationformat, s.scale, i.*, c.fullname FROM mdl_grade_grades_history g LEFT JOIN mdl_scale s ON g.rawscaleid=s.id, mdl_grade_items i, mdl_course c WHERE g.userid=$userid AND g.itemid=i.id AND i.courseid=c.id ORDER BY fullname ASC, itemname ASC, g.timemodified ASC");
$grade_grades_historys = $DB->get_records_sql("
  SELECT
    g.id AS gid,
    g.source,
    g.timemodified AS gtimemodified,
    g.finalgrade,
    g.feedback,
    g.feedbackformat,
    g.information,
    g.informationformat,
    i.*,
    c.fullname
  FROM
    mdl_grade_grades_history g,
    mdl_grade_items i,
    mdl_course c
  WHERE
    g.userid=$userid AND
    g.itemid=i.id AND
    i.courseid=c.id
  ORDER BY fullname ASC, itemname ASC, g.timemodified ASC");
//    g.userid!=g.usermodified AND Removed as it suppresses course grades and autograded test modules (e.g. FPH)

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
//    if (empty($grade_grades_history->finalgrade)) {
//      echo 'No Grade';
//    }
//    elseif (empty($grade_grades_history->scale)) {
//      echo $grade_grades_history->finalgrade;
//    }
//    else {
//      $scale = explode(',', $grade_grades_history->scale);
//      $grade = (int)($grade_grades_history->finalgrade + .000001);
//      if (empty($scale[$grade - 1])) {
//        echo $grade_grades_history->finalgrade;
//      }
//      else {
//        echo trim($scale[$grade - 1]);
//      }
//    }

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
    SELECT DISTINCT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', context_system::instance())) return true;
  else return false;
}
?>
