<?php

function updateapplication($sid, $field, $value, $deltamodules = 0, $coursename = '') {
  global $DB;

  $record = $DB->get_record('peoplesapplication', array('sid' => $sid));
  $application = new stdClass();
  $application->id = $record->id;
  $application->{$field} = $value;

  if ($deltamodules != 0) {
    if ($deltamodules == 1) {
      $module_cost = get_module_cost($record->userid, $coursename, '');
      $coursename2 = '';
    }
    elseif ($deltamodules == -1) {
      $module_cost = - get_module_cost($record->userid, $coursename, '');
      $coursename2 = '';
    }
    else { // ($deltamodules == 2)
      $module_cost = get_module_cost($record->userid, $record->coursename1, $record->coursename2);
      $coursename  = $record->coursename1;
      $coursename2 = $record->coursename2;
    }

    $application->costowed = $record->costowed + $module_cost;
    if ($application->costowed < 0) $application->costowed = 0;
  }

  $DB->update_record('peoplesapplication', $application);

  if ($deltamodules != 0) {
    $mphstatus = get_mph_status($record->userid);

    if (($mphstatus != 1) && !empty($record->userid)) { // $record->userid should NOT be empty, but just in case
      // Update Balance only if this is not an MMU MPH student as MMU MPH students pay an all inclusive fee which is previously set.

      $amount = get_balance($record->userid);

      $peoples_student_balance = new stdClass();
      $peoples_student_balance->userid = $record->userid;
      $peoples_student_balance->amount_delta = $module_cost;
      $peoples_student_balance->balance = $amount + $peoples_student_balance->amount_delta;
      $peoples_student_balance->currency = 'GBP';
      if (!empty($coursename2)) {
        $course2 = " & '{$coursename2}'";
      }
      else {
        $course2 = '';
      }
      $peoples_student_balance->detail = "Adjustment for modules '$coursename'{$course2} for Semester $record->semester";
      $peoples_student_balance->date = time();
      $DB->insert_record('peoples_student_balance', $peoples_student_balance);
    }
  }
}


function get_income_category($userid) {
  global $DB;

  $peoples_income_category = $DB->get_record('peoples_income_category', array('userid' => $userid));
  if (empty($peoples_income_category)) {
    $income_category = 0;
  }
  else {
    $income_category = $peoples_income_category->income_category;
  }
  return $income_category;
}


function get_mph_status($userid) {
  global $DB;

  if (empty($userid)) return 0;

  $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $userid));
  if (!empty($peoplesmph2)) {
    $mphstatus = $peoplesmph2->mphstatus;
  }
  else {
    $mphstatus = 0;
  }
  return $mphstatus;
}


function get_mph_suspended($userid) {
  global $DB;

  if (empty($userid)) return 0;

  $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $userid));
  if (!empty($peoplesmph2)) {
    $mphsuspended = $peoplesmph2->suspended;
  }
  else {
    $mphsuspended = 0;
  }
  return $mphsuspended;
}


function instalments_allowed($userid) {
  $mphstatus = get_mph_status($userid);
  $instalments_allowed = FALSE;
  if ($mphstatus == 1) $instalments_allowed = TRUE; // 1 => MMU MPH

  return $instalments_allowed;
}


function get_module_cost($userid, $coursename1, $coursename2) {
  global $DB;

  $peoples_ceatup_courses_names = array();
  $peoples_ceatup = $DB->get_record('peoples_ceatup', array('userid' => $userid));
  if (!empty($peoples_ceatup) && $peoples_ceatup->ceatup_status > 0) {
    $peoples_ceatup_courses = $DB->get_records_sql('
      SELECT up.course_id, c.fullname
      FROM mdl_peoples_ceatup_courses up
      JOIN mdl_course c ON up.course_id=c.id
      ORDER BY c.fullname ASC');
    if (!empty($peoples_ceatup_courses)) {
      foreach ($peoples_ceatup_courses as $peoples_ceatup_course) {
          $peoples_ceatup_courses_names[] = $peoples_ceatup_course->fullname;
      }
    }
  }

  if (empty($coursename2)) {
    $deltamodules = 1;
    if (in_array($coursename1, $peoples_ceatup_courses_names)) $deltamodules = 0; // No charge for Enterprises University of Pretoria modules
  } else {
    $deltamodules = 2;
    if (in_array($coursename1, $peoples_ceatup_courses_names)) $deltamodules--;
    if (in_array($coursename2, $peoples_ceatup_courses_names)) $deltamodules--;
  }

  $income_category = get_income_category($userid);

  $mphstatus = get_mph_status($userid);

  $dissertation = 0;
  if (stripos($coursename1, 'dissertation') !== FALSE) {
    $dissertation++;
    $deltamodules--;
  }
  if (stripos($coursename2, 'dissertation') !== FALSE) {
    $dissertation++;
    $deltamodules--;
  }

  if ($mphstatus == 1) { // MMU MPH
    $module_cost = 0;
  }
  //elseif ($income_category == 0) { // Existing Students
  //  $module_cost = $dissertation*100 + $deltamodules*40;
  //}
  elseif ($income_category == 0 || $income_category == 1) { // LMIC Students
    $module_cost = $dissertation*100 + $deltamodules*50; // For 18a onwards
    //$module_cost = $dissertation*180 + $deltamodules*50; // Just for 17b
    //$module_cost = $dissertation*180 + $deltamodules*40;
    //$module_cost = $dissertation*260 + $deltamodules*40;
  }
  elseif ($income_category == 2) { // HIC Students
    $module_cost = $dissertation*800 + $deltamodules*400; // 20170705
    //$module_cost = $dissertation*600 + $deltamodules*300;
    //$module_cost = $dissertation*1200 + $deltamodules*300;
  }
  else { // Should not get here!
    $module_cost = $dissertation*800 + $deltamodules*400; // 20170705
    //$module_cost = $dissertation*260 + $deltamodules*40;
  }

  return $module_cost;
}


function get_balance($userid) {
  global $DB;

  $balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} ORDER BY date DESC, id DESC LIMIT 1");
  $amount = 0;
  if (!empty($balances)) {
    foreach ($balances as $balance) {
      $amount = $balance->balance;
    }
  }

  return $amount;
}


function amount_to_pay($userid) {
  global $DB;

  $amount = get_balance($userid);

  if (instalments_allowed($userid)) {
    // MMU MPH: Take Outstanding Balance and adjust for instalments if necessary

    $payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));
    if (!empty($payment_schedule)) {
      $now = time();
      if     ($now < $payment_schedule->expect_amount_2_date) $amount -= ($payment_schedule->amount_2 + $payment_schedule->amount_3 + $payment_schedule->amount_4);
      elseif ($now < $payment_schedule->expect_amount_3_date) $amount -= (                              $payment_schedule->amount_3 + $payment_schedule->amount_4);
      elseif ($now < $payment_schedule->expect_amount_4_date) $amount -= (                                                            $payment_schedule->amount_4);
      // else the full balance should be paid (which is normally equal to amount_4, but the balance might have been adjusted or the student still might not be up to date with payments)
    }
  }

  if ($amount < 0) $amount = 0;
  return $amount;
}


function amount_to_pay_adjusted($application, $payment_schedule) {

  $amount = get_balance($application->userid);

  if (instalments_allowed($application->userid)) {
    // MMU MPH: Take Outstanding Balance and adjust for instalments if necessary

    if (!empty($payment_schedule)) {
      $now = time();
      if     ($now < $payment_schedule->expect_amount_2_date) $amount -= ($payment_schedule->amount_2 + $payment_schedule->amount_3 + $payment_schedule->amount_4);
      elseif ($now < $payment_schedule->expect_amount_3_date) $amount -= (                              $payment_schedule->amount_3 + $payment_schedule->amount_4);
      elseif ($now < $payment_schedule->expect_amount_4_date) $amount -= (                                                            $payment_schedule->amount_4);
      // else the full balance should be paid (which is normally equal to amount_4, but the balance might have been adjusted or the student still might not be up to date with payments)
    }
  }
  else {
    // NON MMU MPH: Take Outstanding Balance and adjust for new modules

    $module_cost = get_module_cost($application->userid, $application->coursename1, $application->coursename2);
    $amount += $module_cost;
  }

  if ($amount < 0) $amount = 0;
  return $amount;
}


function get_next_unpaid_instalment($userid) {
  global $DB;

  $original_amount = get_balance($userid);

  if (!instalments_allowed($userid)) return 0;

  $payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));
  if (empty($payment_schedule)) return 0;

  $now = time();

  // This assumes that zero is currently owing which implies that (at least) instalment 1 has been paid, see amount_to_pay() which has already been called
  // So let us see if instalment 2 is owing...
  $amount = $original_amount;
  if     ($now < $payment_schedule->expect_amount_3_date) $amount -= (                              $payment_schedule->amount_3 + $payment_schedule->amount_4);
  elseif ($now < $payment_schedule->expect_amount_4_date) $amount -= (                                                            $payment_schedule->amount_4);
  // else the full balance should be paid (which is normally equal to amount_4, but the balance might have been adjusted or the student still might not be up to date with payments)

  if ($amount < .01) { // So let us see if instalment 3 is owing...
    $amount = $original_amount;
    if ($now < $payment_schedule->expect_amount_4_date) $amount -= $payment_schedule->amount_4;
    // else the full balance should be paid (which is normally equal to amount_4, but the balance might have been adjusted or the student still might not be up to date with payments)
  }
  if ($amount < .01) { // So let us see if instalment 4 is owing...
    $amount = $original_amount;
  }

  if ($amount < .01) $amount = 0;
  return $amount;
}


function is_not_confirmed($userid) {
  global $DB;

  $balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} AND not_confirmed=1");
  if (!empty($balances)) return TRUE;
  return FALSE;
}


function enrolincourse($course, $user, $semester) {
  global $DB;

  $timestart = time();
  // remove time part from the timestamp and keep only the date part
  $timestart = make_timestamp(date('Y', $timestart), date('m', $timestart), date('d', $timestart), 0, 0, 0);

  $roles = get_archetype_roles('student');
  $role = reset($roles);

  if (enrol_try_internal_enrol($course->id, $user->id, $role->id, $timestart, 0)) {

    $enrolment = $DB->get_record('enrolment', array('userid' => $user->id, 'courseid' => $course->id));
    if (!empty($enrolment)) {
      $enrolment->semester = dontaddslashes($enrolment->semester);
      $enrolment->enrolled = 1;
      $DB->update_record('enrolment', $enrolment);
    }
    else {
      $enrolment = new stdClass();
      $enrolment->userid = $user->id;
      $enrolment->courseid = $course->id;
      $enrolment->semester = $semester;
      $enrolment->datefirstenrolled = time();
      $enrolment->enrolled = 1;
      $enrolment->percentgrades = 1;

      $DB->insert_record('enrolment', $enrolment);
    }

    $forum_subscriptions_recordeds = $DB->get_records('forum_subscriptions_recorded', array('userid' => $user->id));
    if (!empty($forum_subscriptions_recordeds)) {
      foreach ($forum_subscriptions_recordeds as $forum_subscriptions_recorded) {
        $forum_subscriptions = new stdClass();
        $forum_subscriptions->userid = $forum_subscriptions_recorded->userid;
        $forum_subscriptions->forum  = $forum_subscriptions_recorded->forum;

        if ($DB->record_exists('forum', array('id' => $forum_subscriptions->forum))) {
          if (!$DB->record_exists('forum_subscriptions', array('userid' => $forum_subscriptions->userid, 'forum' => $forum_subscriptions->forum))) {
            $DB->insert_record('forum_subscriptions', $forum_subscriptions);
          }
        }

        $DB->delete_records('forum_subscriptions_recorded', array('id' => $forum_subscriptions_recorded->id));
      }
    }

    emailwelcome($course, $user);

    $message = '';
    if (!empty($user->firstname))  $message .= $user->firstname;
    if (!empty($user->lastname)) $message .= ' ' . $user->lastname;
    if (!empty($role->name)) $message .= ' as ' . $role->name;
    if (!empty($course->fullname)) $message .= ' in ' . $course->fullname;
    // add_to_log($course->id, 'course', 'enrol', '../enrol/users.php?id=' . $course->id, $message, 0, $user->id);

    return true;
  }
  else {
    return false;
  }
}


function enrolincoursesimple($course, $user) {
  global $DB;

  $timestart = time();
  // remove time part from the timestamp and keep only the date part
  $timestart = make_timestamp(date('Y', $timestart), date('m', $timestart), date('d', $timestart), 0, 0, 0);

  $roles = get_archetype_roles('student');
  $role = reset($roles);

  enrol_try_internal_enrol($course->id, $user->id, $role->id, $timestart, 0);

  // emailwelcome($course, $user);

  $message = '';
  if (!empty($user->firstname))  $message .= $user->firstname;
  if (!empty($user->lastname)) $message .= ' ' . $user->lastname;
  if (!empty($role->name)) $message .= ' as ' . $role->name;
  if (!empty($course->fullname)) $message .= ' in ' . $course->fullname;
  // add_to_log($course->id, 'course', 'enrol', '../enrol/users.php?id=' . $course->id, $message, 0, $user->id);
}


function emailwelcome($course, $user) {
  global $CFG;

  $subject = "New enrolment in $course->fullname";
  $message = "Welcome to $course->fullname!

If you have not done so already, you should edit your profile page
so that we can learn more about you:

  $CFG->wwwroot/user/view.php?id=$user->id&amp;course=$course->id

There is a link to your course at the bottom of the profile or you can click:

  $CFG->wwwroot/course/view.php?id=$course->id";

  $teacher = get_peoples_teacher($course);
  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $teacher, $subject, $message);

//  $eventdata = new stdClass();
//  $eventdata->modulename        = 'moodle';
//  $eventdata->component         = 'course';
//  $eventdata->name              = 'flatfile_enrolment';
//  $eventdata->userfrom          = $teacher;
//  $eventdata->userto            = $user;
//  $eventdata->subject           = $subject;
//  $eventdata->fullmessage       = $message;
//  $eventdata->fullmessageformat = FORMAT_PLAIN;
//  $eventdata->fullmessagehtml   = '';
//  $eventdata->smallmessage      = '';
//  message_send($eventdata);
}


function sendapprovedmail($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999; $user->username = 'none';
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  //$supportuser = generate_email_supportuser();
  $supportuser = new stdClass();
  $supportuser->id = 999999998; $supportuser->username = 'none';
  $supportuser->email = 'apply@peoples-uni.org';
  $supportuser->firstname = "People's Open Access Education Initiative: Peoples-uni";
  $supportuser->lastname = '';
  $supportuser->firstnamephonetic = NULL;
  $supportuser->lastnamephonetic = NULL;
  $supportuser->middlename = NULL;
  $supportuser->alternatename = NULL;
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  $user->email = 'applicationresponses@peoples-uni.org';

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}


function sendapprovedmail_from_support($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999; $user->username = 'none';
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = core_user::get_support_user();

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  $user->email = 'applicationresponses@peoples-uni.org';

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}


function sendapprovedmail_from_payments($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999; $user->username = 'none';
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->id = 999999998; $supportuser->username = 'none';
  $supportuser->email = 'payments@peoples-uni.org';
  $supportuser->firstname = 'Peoples-uni Payments';
  $supportuser->lastname = '';
  $supportuser->firstnamephonetic = NULL;
  $supportuser->lastnamephonetic = NULL;
  $supportuser->middlename = NULL;
  $supportuser->alternatename = NULL;
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  $user->email = 'applicationresponses@peoples-uni.org';

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}


function unenrolstudent($userid, $modulename) {
  global $DB;

  // Student is probably (but not for sure) enrolled in this module

  if (!empty($userid)) {
    $coursetoremove = $DB->get_record('course', array('fullname' => $modulename));
    if (!empty($coursetoremove)) {

      if (!enrol_is_enabled('manual')) {
        return false;
      }
      if (!$enrol = enrol_get_plugin('manual')) {
        return false;
      }
      if (!$instances = $DB->get_records('enrol', array('enrol'=>'manual', 'courseid'=>$coursetoremove->id, 'status'=>ENROL_INSTANCE_ENABLED), 'sortorder,id ASC')) {
        return false;
      }
      $instance = reset($instances);

      $enrol->unenrol_user($instance, $userid);

      $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $coursetoremove->id));

      if (!empty($enrolment)) {
        $enrolment->semester = dontaddslashes($enrolment->semester);
        $enrolment->dateunenrolled = time();
        $enrolment->enrolled = 0;
        $DB->update_record('enrolment', $enrolment);
      }

      $message = '';
      $user = $DB->get_record('user', array('id' => $userid));
      if (!empty($user->firstname))  $message .= $user->firstname;
      if (!empty($user->lastname))   $message .= ' ' . $user->lastname;
      $message .= ' as Student in ' . dontstripslashes($modulename);
      // add_to_log($coursetoremove->id, 'course', 'unenrol', '../enrol/users.php?id=' . $coursetoremove->id, $message, 0, $userid);
    }
  }
}


function get_peoples_teacher($course) {
  global $DB;

  $context = context_course::instance($course->id);

  $role = $DB->get_record('role', array('name' => 'Module Leader'));

  if ($teachers = get_role_users($role->id, $context)) {
    foreach ($teachers as $teacher) {
      $teacheruserid = $teacher->id;
    }
  }

  if (isset($teacheruserid)) {
    $teacher = $DB->get_record('user', array('id' => $teacheruserid));
  }
  else {
    $teacher = get_admin();
  }
  return $teacher;
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


function dontaddslashes($x) {
  return $x;
}


function dontstripslashes($x) {
  return $x;
}
