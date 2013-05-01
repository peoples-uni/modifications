<?php

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/testrecordsubmissions.php'); // Defined here to avoid notices on errors etc
$PAGE->set_pagelayout('embedded');   // Needs as much space as possible

require_login(NULL, FALSE);  // No course, Don't make user a Guest [actually if they click "Guest" by mistake it is better to force them to login below (see "if (isguestuser())"), so DO allow override of $SESSION->wantsurl]
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

if (isguestuser()) {  // In case user has specifically logged in as Guest (or has been logged in automatically as Guest on some other page)
  $SESSION->wantsurl = "$CFG->wwwroot/course/testrecordsubmissions.php";
  notice('<br /><br /><b>You must be logged in to do this! Please Click "Continue" below, and then log in with your username and password above!</b><br /><br /><br />', "$CFG->wwwroot/");
}

require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('testrecordsubmissions.php');
$PAGE->set_heading('testrecordsubmissions.php');
echo $OUTPUT->header();
echo "<h1>testrecordsubmissions.php</h1>";


/*
select userid, contextid, itemid AS submissionid, filepath, filename from mdl_files where component='assignsubmission_file' AND filearea='submission_files' limit 2;
+--------+-----------+--------------+----------+-----------------------+
| userid | contextid | submissionid | filepath | filename              |
+--------+-----------+--------------+----------+-----------------------+
|   1446 |     16692 |            1 | /        | KabezaPUCOMDIS 12adoc |
|   1446 |     16692 |            1 | /        | .                     |
+--------+-----------+--------------+----------+-----------------------+
*/

$itemid = 1; // Submission
$contextid = 16692;

require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir.'/eventslib.php');

$assign_submission = $DB->get_record('assign_submission', array('id' => $itemid));
$userid = $assign_submission->userid;

// context->id... mdl_context
// context.instanceid... mdl_course_module
// course_module.instance... mdl_assign
// course_module.course... mdl_course
//SELECT cm.course, cm.instance as assignid FROM mdl_course_modules cm, mdl_context con WHERE cm.id=con.instanceid AND con.id=16692;
//+--------+----------+
//| course | assignid |
//+--------+----------+
//|    182 |        1 |
//+--------+----------+
$course_module = $DB->get_record_sql("SELECT cm.id, cm.course, cm.instance as assignid FROM mdl_course_modules cm, mdl_context con WHERE cm.id=con.instanceid AND con.id=$contextid");
$courseid = $course_module->course;
$assignid = $course_module->assignid;

$fs = get_file_storage();
$files = $fs->get_area_files($contextid, 'assignsubmission_file', 'submission_files', $itemid, 'id', false);

$eventdata = new stdClass();
$eventdata->modulename = 'assign';
$eventdata->itemid = $itemid;
$eventdata->courseid = $courseid;
$eventdata->userid = $userid;
$eventdata->pathnamehashes = array_keys($files);
$eventdata->content = 'abc<br />def';
echo '<pre>';
print_r($eventdata);
echo '</pre>';
//events_trigger('assessable_file_uploaded', $eventdata);


echo $OUTPUT->footer();
