<?php
require("../config.php");
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/lib/weblib.php');
require_once $CFG->libdir . '/gradelib.php';
require_once($CFG->libdir . '/filelib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/studentsubmissions.php');

$PAGE->set_pagelayout('embedded');

require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die(); }

$isteacher = has_capability('moodle/site:config', context_system::instance());
if (!$isteacher)  {echo '<h1>You do not have rights to do this!</h1>'; die(); };

$PAGE->set_title('Migrate to Recorded Submissions');
$PAGE->set_heading('Migrate to Recorded Submissions');
echo $OUTPUT->header();

echo '<h1>Migrate to Recorded Submissions</h1>';
echo '<br /><br /><br />';


$recorded_submissions = $DB->get_records_sql("SELECT * FROM mdl_recorded_submissions WHERE turnitintooltwo_submission_part!=0 ORDER BY id ASC");


$table = new html_table();
$table->head = array(
  'Submisison ID',
  'Part ID',
  'User ID',
  'Submission Date',
  'Course ID',
  'Name',
  'File Info'
  );

if (!empty($recorded_submissions)) {
  foreach ($recorded_submissions as $recorded_submission) {
    $rowdata = array();
    $rowdata[] = $recorded_submission->submission;
    $rowdata[] = $recorded_submission->turnitintooltwo_submission_part;
    $rowdata[] = $recorded_submission->userid;
    $rowdata[] = gmdate('d/M/Y H:i', $recorded_submission->timemodified);
    $rowdata[] = $recorded_submission->course;
    $rowdata[] = $recorded_submission->name;

    $turnitintooltwo_part = $DB->get_record('turnitintooltwo_parts', array('id' => $recorded_submission->turnitintooltwo_submission_part));
    $cm = $DB->get_record_sql("SELECT cm.id FROM mdl_course_modules cm, mdl_modules m WHERE cm.instance=:instance AND cm.module=m.id AND m.name='turnitintooltwo'", array('instance' => $turnitintooltwo_part->turnitintooltwoid));

    $rowdata[] = record_file_for_turnitintooltwo_submission($cm, $recorded_submission->submission, $recorded_submission->course, $recorded_submission);

    $table->data[] = $rowdata;
  }
}
echo html_writer::table($table);


echo '<br /><br /><br />';

echo $OUTPUT->footer();


function record_file_for_turnitintooltwo_submission($cm, $submission_id, $course_id, $recorded_submission) { // ALAN 20150820
  global $DB;

  $return_string = '';

  $turnitintooltwo_submission = $DB->get_record('turnitintooltwo_submissions', array('id' => $submission_id));
  $turnitintooltwo_part       = $DB->get_record('turnitintooltwo_parts',       array('id' => $turnitintooltwo_submission->submission_part));
  $turnitintooltwo            = $DB->get_record('turnitintooltwo',             array('id' => $turnitintooltwo_part->turnitintooltwoid));

  $recorded_submission_id = $recorded_submission->id;

  $turnitintooltwo_submission_fs = get_file_storage();
  $context = context_module::instance($cm->id);
  $files = $turnitintooltwo_submission_fs->get_area_files($context->id, 'mod_turnitintooltwo', 'submissions', $submission_id, "timecreated", false);
  foreach ($files as $submitted_file) {
    if (empty($submitted_file)) continue;

    $newfilename = $submitted_file->get_filename();
    if ($newfilename === '.') continue; // by the way, a '.' directory will be auto generated
    $newfilename = clean_param($newfilename, PARAM_FILE);

    $newfilepath = $submitted_file->get_filepath();

    $filedata = $submitted_file->get_content();

    $recorded_submission_fs = get_file_storage();

    $context = context_user::instance($turnitintooltwo_submission->userid);

    $newrecord = new stdClass();
    $newrecord->contextid = $context->id;
    $newrecord->component = 'peoples_recordedsubmissions';
    $newrecord->filearea  = 'student';
    $newrecord->itemid    = $recorded_submission_id;
    $newrecord->filepath  = $newfilepath;
    $newrecord->filename  = $newfilename;
    if (!$recorded_submission_fs->file_exists($newrecord->contextid, $newrecord->component, $newrecord->filearea, $newrecord->itemid, $newrecord->filepath, $newrecord->filename)) {
      $newrecord->source        = $submitted_file->get_source();
      $newrecord->author        = $submitted_file->get_author();
      $newrecord->license       = $submitted_file->get_license();
      $newrecord->timecreated   = $submitted_file->get_timecreated();
      $newrecord->timemodified  = $submitted_file->get_timemodified();
      $newrecord->mimetype      = mimeinfo('type', $newfilename);
      $newrecord->userid        = $turnitintooltwo_submission->userid;
      //$recorded_submission_fs->create_file_from_string($newrecord, $filedata);

      $return_string .= "$newfilepath/$newfilename";
    }
  }

  return $return_string;
} // ALAN 20150820 END
?>
