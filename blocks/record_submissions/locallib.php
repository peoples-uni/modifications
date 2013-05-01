<?php

require_once($CFG->libdir . '/filelib.php');


function file_submission_uploaded($eventdata) {
  record_assign_submission($eventdata);
}


function onlinetext_submission_uploaded($eventdata) {
  record_assign_submission($eventdata);
}


function record_assign_submission($eventdata) {
  global $DB;
  global $CFG;

  $assign_submission = $DB->get_record('assign_submission', array('id' => $eventdata->itemid));

  $recorded_submission = new object();
  $recorded_submission->submission   = $eventdata->itemid;
  $recorded_submission->assignment   = 0; // This is not mod assignment (2.2)
  $recorded_submission->assign       = $assign_submission->assignment; // mod assign (2.3)
  $recorded_submission->userid       = $assign_submission->userid; // Might be 0 if group (we do not handle); Also there seemed to be some Peoples-uni staff id(s)... hopefully a test?
  $recorded_submission->timemodified = $assign_submission->timemodified;
  $recorded_submission->course       = $eventdata->courseid;
  $assignment = $DB->get_record('assign', array('id' => $assign_submission->assignment));
  $recorded_submission->name         = $assignment->name;
  $recorded_submission->assignmenttype = '';
  if (!empty($eventdata->content)) {
    $recorded_submission->data1 = $eventdata->content;
  }
  else {
    $recorded_submission->data1 = '';
  }
  $recorded_submission->data2 = ''; // format_text() already applied
  $recorded_submission_id = $DB->insert_record('recorded_submissions', $recorded_submission);

  if (!empty($eventdata->pathnamehashes)) {
    foreach ($eventdata->pathnamehashes as $hash) {

      $assign_submission_fs = get_file_storage();
      $submitted_file = $assign_submission_fs->get_file_by_hash($hash);
      if (empty($submitted_file)) continue;

      $newfilename = $submitted_file->get_filename();
      if ($newfilename === '.') continue;
      $newfilename = clean_param($newfilename, PARAM_FILE);

      $newfilepath = $submitted_file->get_filepath();

      $recorded_submission_fs = get_file_storage();

      $newrecord = new stdClass();
      $context = context_user::instance($assign_submission->userid);
      $newrecord->contextid = $context->id;
      $newrecord->component = 'peoples_recordedsubmissions';
      $newrecord->filearea  = 'student';
      $newrecord->itemid    = $recorded_submission_id;
      $newrecord->filepath  = $newfilepath;
      $newrecord->filename  = $newfilename;
      if (!$recorded_submission_fs->file_exists($newrecord->contextid, $newrecord->component, $newrecord->filearea, $newrecord->itemid, $newrecord->filepath, $newrecord->filename)) {
        $newrecord->timecreated  = $assign_submission->timemodified;
        $newrecord->timemodified = $assign_submission->timemodified;
        $newrecord->mimetype     = mimeinfo('type', $newfilename);
        $newrecord->userid       = $userid;
        $recorded_submission_fs->create_file_from_string($newrecord, $content);
      }
    }
  }
}
