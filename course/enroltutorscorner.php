<?php  // $Id: enroltutorscorner.php,v 1.1 2009/04/05 18:06:00 alanbarrett Exp $
/**
*
* Enrol All Current Module Leader/Tutors/Student coordinator in Tutors Corner and Guide for online facilitators
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/enroltutorscorner.php');
$PAGE->set_pagelayout('standard');

require_login();

require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Enrol All Current Module Leader/Tutors/Student coordinator in "Tutors Corner" and "Guide for online facilitators"');
$PAGE->set_heading('Enrol All Current Module Leader/Tutors/Student coordinator in "Tutors Corner" and "Guide for online facilitators"');
echo $OUTPUT->header();


// Tutors Corner
$missingfromtutors = $DB->get_records_sql("
	SELECT module.userid
	FROM
		(SELECT userid
			FROM mdl_role_assignments
			WHERE
        (roleid=3 OR roleid=17 OR roleid=38 OR roleid=30) AND
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
  echo 'No new Module Leader/Tutors/Student coordinator found to add to "Tutors Corner"<br />';
}

foreach ($missingfromtutors as $missing) {

  $tutorscorner = $DB->get_record('course', array('fullname' => 'Tutors Corner'));
	if (!empty($tutorscorner)) {
    $user = $DB->get_record('user', array('id' => $missing->userid));
		if (!empty($user)) {
			echo 'Adding to Tutors Corner: ' . $user->firstname . ' ' . $user->lastname . '<br />';
			enrolincoursesimple($tutorscorner, $user);
		}
	}
}


// Guide for online facilitators
$missingfromtutors = $DB->get_records_sql("
	SELECT module.userid
	FROM
		(SELECT userid
			FROM mdl_role_assignments
			WHERE
        (roleid=3 OR roleid=17 OR roleid=38 OR roleid=30) AND
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
  echo 'No new Module Leader/Tutors/Student coordinator found to add to "Guide for online facilitators"<br />';
}

foreach ($missingfromtutors as $missing) {

  $tutorscorner = $DB->get_record('course', array('fullname' => 'Guide for online facilitators'));
	if (!empty($tutorscorner)) {
    $user = $DB->get_record('user', array('id' => $missing->userid));
		if (!empty($user)) {
			echo 'Adding to Guide for online facilitators: ' . $user->firstname . ' ' . $user->lastname . '<br />';
			enrolincoursesimple($tutorscorner, $user);
		}
	}
}

echo $OUTPUT->footer();


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
  add_to_log($course->id, 'course', 'enrol', '../enrol/users.php?id=' . $course->id, $message, 0, $user->id);
}
?>
