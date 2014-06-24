<?php

function updateapplication($sid, $field, $value, $deltamodules = 0) {
  global $DB;

  $record = $DB->get_record('peoplesapplication', array('sid' => $sid));
  $application = new object();
  $application->id = $record->id;
  $application->{$field} = $value;

  if ($deltamodules != 0) {
    if (($deltamodules > 1) && empty($record->coursename2)) $deltamodules = 1;

    $module_cost = get_module_cost($record->userid, $record->coursename1);
    $application->costowed = $record->costowed + $deltamodules * $module_cost;
    if ($application->costowed < 0) $application->costowed = 0;
  }

  $DB->update_record('peoplesapplication', $application);

  if ($deltamodules != 0) {
    $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $record->userid));
    if (!empty($peoplesmph2)) {
      $mphstatus = $peoplesmph2->mphstatus;
    }
    else {
      $mphstatus = 0;
    }

    if (($mphstatus != 1) && !empty($record->userid)) { // $record->userid should NOT be empty, but just in case
      // Update Balance only if this is not an MMU MPH student as MMU MPH students pay an all inclusive fee which is previously set.

      $amount = get_balance($record->userid);

      $peoples_student_balance = new object();
      $peoples_student_balance->userid = $record->userid;
      $peoples_student_balance->amount_delta = $deltamodules * $module_cost;
      $peoples_student_balance->balance = $amount + $peoples_student_balance->amount_delta;
      $peoples_student_balance->currency = 'GBP';
      if (!empty($record->coursename2)) {
        $course2 = " & '{$record->coursename2}'";
      }
      else {
        $course2 = '';
      }
      $peoples_student_balance->detail = "Adjustment for modules '$record->coursename1'{$course2} for Semester $record->semester";
      $peoples_student_balance->date = time();
      $DB->insert_record('peoples_student_balance', $peoples_student_balance);
    }
  }
}


function get_module_cost($userid, $coursename) {
  global $DB;

  $peoples_income_category = $DB->get_record('peoples_income_category', array('userid' => $userid));
  if (empty($peoples_income_category)) {
    $income_category = 0;
  }
  else {
    $income_category = $peoples_income_category->income_category;
  }

  $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $userid));
  if (!empty($peoplesmph2)) {
    $mphstatus = $peoplesmph2->mphstatus;
  }
  else {
    $mphstatus = 0;
  }

  if (stripos($coursename, 'dissertation') !== FALSE) {
    $dissertation = TRUE;
  }
  else {
    $dissertation = FALSE;
  }

  if ($mphstatus == 1) { // MMU MPH
    $module_cost = 0;
  }
  elseif ($income_category == 0) { // Existing Students
    if ($dissertation) $module_cost = 100;
    else $module_cost = 40;
  }
  elseif ($income_category == 1) { // LMIC Students
    if ($dissertation) $module_cost = 260;
    else $module_cost = 40;
  }
  elseif ($income_category == 2) { // HIC Students
    if ($dissertation) $module_cost = 1200;
    else $module_cost = 300;
  }
  else { // Should not get here!
    if ($dissertation) $module_cost = 260;
    else $module_cost = 40;
  }

  return $module_cost;
}
