<?php  // $Id: enroltutorscorner.php,v 1.1 2009/04/05 18:06:00 alanbarrett Exp $
/**
*
* Enrol All Current Teacher/Teachers/Education Officer in Tutors Corner and Guide for online facilitators
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

require_login();

require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

print_header('Enrol All Current Teacher/Teachers/Education Officer in "Tutors Corner" and "Guide for online facilitators"');

echo '<h1>Enrol All Current Teacher/Teachers/Education Officer in "Tutors Corner" and "Guide for online facilitators"</h1>';


// Tutors Corner
$missingfromtutors = get_records_sql("
	SELECT module.userid
	FROM
		(SELECT userid
			FROM mdl_role_assignments
			WHERE
				(roleid=3 OR roleid=17 OR roleid=19) AND
				contextid IN (
					SELECT id FROM mdl_context WHERE contextlevel=50 AND instanceid IN
						(SELECT c.id FROM mdl_activemodules AS a, mdl_course AS c WHERE a.fullname=c.fullname)
				)
		) AS module
		LEFT JOIN (
			SELECT userid
			FROM mdl_role_assignments
			WHERE roleid=5 AND contextid=1641
		) AS tutors
	ON module.userid=tutors.userid
	WHERE ISNULL(tutors.userid)");
	// contextid=1641 comes from hovering over Assign roles in the course
if (empty($missingfromtutors)) {
	$missingfromtutors = array();
	echo 'No new Teacher/Teachers/Education Officer found to add to "Tutors Corner"<br />';
}

foreach ($missingfromtutors as $missing) {

	$tutorscorner = get_record('course', 'fullname', 'Tutors Corner');
	if (!empty($tutorscorner)) {
		$user = get_record('user', 'id', $missing->userid);
		if (!empty($user)) {
			echo 'Adding to Tutors Corner: ' . $user->firstname . ' ' . $user->lastname . '<br />';
			enrolincoursesimple($tutorscorner, $user, 'manual');
		}
	}
}


// Guide for online facilitators
$missingfromtutors = get_records_sql("
	SELECT module.userid
	FROM
		(SELECT userid
			FROM mdl_role_assignments
			WHERE
				(roleid=3 OR roleid=17 OR roleid=19) AND
				contextid IN (
					SELECT id FROM mdl_context WHERE contextlevel=50 AND instanceid IN
						(SELECT c.id FROM mdl_activemodules AS a, mdl_course AS c WHERE a.fullname=c.fullname)
				)
		) AS module
		LEFT JOIN (
			SELECT userid
			FROM mdl_role_assignments
			WHERE roleid=5 AND contextid=765
		) AS tutors
	ON module.userid=tutors.userid
	WHERE ISNULL(tutors.userid)");
	// roleid=4 is used because the default role is (for some reason) Non-editing teacher
  // 20101001 Changed back to 5 (Student) as default role has been changed
	// contextid=765 comes from hovering over Assign roles in the course 765
if (empty($missingfromtutors)) {
	$missingfromtutors = array();
	echo 'No new Teacher/Teachers/Education Officer found to add to "Guide for online facilitators"<br />';
}

foreach ($missingfromtutors as $missing) {

	$tutorscorner = get_record('course', 'fullname', 'Guide for online facilitators');
	if (!empty($tutorscorner)) {
		$user = get_record('user', 'id', $missing->userid);
		if (!empty($user)) {
			echo 'Adding to Guide for online facilitators: ' . $user->firstname . ' ' . $user->lastname . '<br />';
			enrolincoursesimple($tutorscorner, $user, 'manual');
		}
	}
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

		$context = get_context_instance(CONTEXT_COURSE, $course->id);

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
		add_to_log($course->id, 'course', 'enrol', 'view.php?id='.$course->id, $message);

		return true;
	}

	return false;
}
?>
