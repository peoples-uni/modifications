<?php  // $Id: tempenrolstudentscorner.php,v 1.1 2009/09/25 14:18:00 alanbarrett Exp $

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

require_login();

require_capability('moodle/site:viewparticipants', context_system::instance());

print_header('tempenrolstudentscorner.php');


$studentscorner = get_record('course', 'fullname', 'Students corner 10a');
if (empty($studentscorner)) {
	echo '$studentscorner EMPTY!<br />';
	die();
}


$enrols = get_records_sql("SELECT DISTINCT userid FROM mdl_enrolment WHERE semester='Starting March 2010' AND enrolled!=0");


foreach ($enrols as $enrol) {
	$user = get_record('user', 'id', $enrol->userid);
	enrolincoursesimple($studentscorner, $user, 'manual');
	$name = fullname($user);
	echo "enrolled: $name($user->id)<br />";
}


function enrolincoursesimple($course, $user, $enrol) {

	$timestart = time();
	// remove time part from the timestamp and keep only the date part
	$timestart = make_timestamp(date('Y', $timestart), date('m', $timestart), date('d', $timestart), 0, 0, 0);
	if ($course->enrolperiod) {
		$timeend = $timestart + $course->enrolperiod;
	} else {
		$timeend = 0;
	}

	if ($role = get_default_course_role($course)) {

		$context = context_course::instance($course->id);

		if (!role_assign($role->id, $user->id, 0, $context->id, $timestart, $timeend, 0, $enrol)) {
			return false;
		}

		// force accessdata refresh for users visiting this context...
		mark_context_dirty($context->path);

//		emailwelcome($course, $user);

		$message = '';
		if (!empty($user->firstname))  $message .= $user->firstname;
		if (!empty($user->lastname)) $message .= ' ' . $user->lastname;
		if (!empty($role->name)) $message .= ' as ' . $role->name;
		if (!empty($course->fullname)) $message .= ' in ' . $course->fullname;
		// add_to_log($course->id, 'course', 'enrol', 'view.php?id='.$course->id, $message);

		return true;
	}

	return false;
}
?>