<?php  // $Id: give_tutors_viewprofiles.php,v 1.1 2013/12/29 15:22:00 alanbarrett Exp $
/**
*
* Give all Module Leader/Tutors/Student coordinator the Sitewide Moodle Role "View Full User Profiles"
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/give_tutors_viewprofiles.php');
$PAGE->set_pagelayout('standard');

require_login();

require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Give all Module Leader/Tutors/Student coordinator the Sitewide Moodle Role "View Full User Profiles"');
$PAGE->set_heading('Give all Module Leader/Tutors/Student coordinator the Sitewide Moodle Role "View Full User Profiles"');
echo $OUTPUT->header();


// Module Leader/Tutors/Education Officers/Old Education Officers without "View Full User Profiles" (roleid 41) sitewide (contextid 1)
$tutorswithoutrole = $DB->get_records_sql("
  SELECT alltutors.userid
  FROM
    (SELECT DISTINCT userid
      FROM mdl_role_assignments
      WHERE
        (roleid=3 OR roleid=17 OR roleid=38 OR roleid=30) AND
        contextid IN (
          SELECT id FROM mdl_context WHERE contextlevel=50 AND instanceid IN
            (SELECT e.courseid FROM mdl_enrolment as e)
        )
    ) AS alltutors
    LEFT JOIN (
      SELECT userid
      FROM mdl_role_assignments
      WHERE roleid=41 AND contextid=1
    ) AS viewprofilesrole
  ON alltutors.userid=viewprofilesrole.userid
  WHERE ISNULL(viewprofilesrole.userid)");

if (empty($tutorswithoutrole)) {
  echo 'No new Module Leader/Tutors/Student coordinator found who need role "View Full User Profiles"<br />';
}
else {
  foreach ($tutorswithoutrole as $missing) {

    role_assign(41, $missing->userid, 1);

    $userrecord = $DB->get_record('user', array('id' => $missing->userid));
    if (!empty($userrecord)) {
      echo "Adding to \"View Full User Profiles\" Role: $userrecord->lastname, $userrecord->firstname<br />";
    }
  }
  // add_to_log(1, 'role', 'assign', 'admin/roles/assign.php?contextid=1&roleid=41', 'View Full User Profiles', '', $USER->id);
}

echo $OUTPUT->footer();
?>
