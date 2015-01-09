<?php  // $Id: clean_studentscorner_subscriptions.php,v 1.1 2015/01/06 15:53:00 alanbarrett Exp $
/**
*
* Clean out old Discussion Forum Subscriptions in Students Corner and keep record so they can be reinstated when Module re-enrolments happen for the Student
*
*/

/*
CREATE TABLE `mdl_forum_subscriptions_recorded` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `userid` bigint(10) NOT NULL DEFAULT '0',
  `forum` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `mdl_forusrec_use_ix` (`userid`),
  KEY `mdl_forusrec_for_ix` (`forum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

require("../config.php");
require_once($CFG->dirroot .'/course/peoples_lib.php');//(**)DEL

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/clean_studentscorner_subscriptions.php'); // Defined here to avoid notices on errors etc

$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $USER->id));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$is_admin = has_capability('moodle/site:viewparticipants', context_system::instance());
$fullname = fullname($userrecord);
if (empty($fullname) || trim($fullname) == 'Guest User' || !$is_admin) {
  echo '<h1>You must be an admin to do this!</h1>';
  $SESSION->wantsurl = "$CFG->wwwroot/course/clean_studentscorner_subscriptions.php";
  notice('<br /><br /><b>Click Continue and Login</b><br /><br />', "$CFG->wwwroot/");
}

$PAGE->set_title('Clean out old Discussion Forum Subscriptions in Students Corner');
$PAGE->set_heading('Clean out old Discussion Forum Subscriptions in Students Corner');
echo $OUTPUT->header();
echo '<h2>Clean out old Discussion Forum Subscriptions in Students Corner</h2>';


$sc = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_students_corner_id')));
if (!empty($sc)) {
  $sc_id = $sc->id;
}
else {
  $sc_id = -1;
  echo 'Students Corner Course not found!<br />';
}


$cutoff_time = time() - 2*30*24*60*60; /* 2 months ago */
$forum_subscriptions = $DB->get_records_sql("
SELECT
  fs.id,
  fs.userid,
  fs.forum,
  f.name,
  u.lastname,
  u.firstname
FROM mdl_forum f
JOIN mdl_xxforum_subscriptions fs ON f.id=fs.forum
JOIN mdl_user u ON fs.userid=u.id
WHERE
  f.course=$sc_id AND
  f.forcesubscribe!=1 AND
  fs.userid NOT IN ( /* The subscriber does not have any role other than Student (we do not want to remove Tutors or Viewer etc. */
    SELECT ra.userid
    FROM
      mdl_role_assignments ra,
      mdl_role r
    WHERE
      ra.roleid=r.id AND
      r.shortname!='student'
    ) AND
  fs.userid NOT IN ( /* The subscriber is not enrolled in current Semester */
    SELECT userid
    FROM mdl_enrolment e
    JOIN mdl_semester_current curr ON BINARY e.semester=curr.semester AND curr.id=1
    WHERE
      e.enrolled=1
    ) AND
  u.lastaccess<$cutoff_time
ORDER BY f.name ASC, u.lastname ASC, u.firstname ASC");


if (!empty($_POST['markcleanout'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  //if (!empty($_POST['doforreal'])) {}

  echo '<strong>Starting Removing Student Subscriptions...</strong><br />';
  $forum_n = array();
  $user_n = array();
  $n = 0;
  foreach ($forum_subscriptions as $forum_subscription) {
    $forum_subscriptions_recorded = new object();
    $forum_subscriptions_recorded->userid = $forum_subscription->userid;
    $forum_subscriptions_recorded->forum  = $forum_subscription->forum;
    $DB->insert_record('forum_subscriptions_recorded', $forum_subscriptions_recorded);

    $DB->delete_records('xxforum_subscriptions', array('id' => $forum_subscription->id));

    echo htmlspecialchars($forum_subscription->lastname, ENT_COMPAT, 'UTF-8')  . ', ' .
         htmlspecialchars($forum_subscription->firstname, ENT_COMPAT, 'UTF-8') . ', ' .
         htmlspecialchars($forum_subscription->name, ENT_COMPAT, 'UTF-8')      . '<br />';

    $forum_n[$forum_subscription->forum] = 1;
    $user_n[$forum_subscription->userid] = 1;
    $n++;
  }
  echo 'Number of Forums: ' . count($forum_n) . '<br />';
  echo 'Number of Students: ' . count($user_n) . '<br />';
  echo "Number of Subscriptions: $n<br /><br />";
}
else {
  echo '<strong>Student Subscriptions that will be Removed (and remembered for later)...</strong>';
  $table = new html_table();
  $table->head = array(
    'Family name',
    'Given name',
    'Forum',
    );
  $forum_n = array();
  $user_n = array();
  $n = 0;
  foreach ($forum_subscriptions as $forum_subscription) {
    $rowdata = array();
    $rowdata[] = htmlspecialchars($forum_subscription->lastname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($forum_subscription->firstname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($forum_subscription->name, ENT_COMPAT, 'UTF-8');
    $table->data[] = $rowdata;

    $forum_n[$forum_subscription->forum] = 1;
    $user_n[$forum_subscription->userid] = 1;
    $n++;
  }
  echo html_writer::table($table);
  echo 'Number of Forums: ' . count($forum_n) . '<br />';
  echo 'Number of Students: ' . count($user_n) . '<br />';
  echo "Number of Subscriptions: $n<br /><br />";
}

?>
<form id="cleanoutform" method="post" action="<?php echo $CFG->wwwroot . '/course/clean_studentscorner_subscriptions.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<?php
//<input type="checkbox" name="doforreal">
?>

<input type="hidden" name="markcleanout" value="1" />
<input type="submit" name="cleanout" value="Remove old Discussion Forum Subscriptions in Students Corner" style="width:50em" />
</form>
<br />
//DEL(**)AND ABOVE
xxenrolincourse($sc, $USER, 'XXXXX');
//DEL(**)


<?php
echo '<br /><br /><br />';

echo $OUTPUT->footer();


/*
$forum_digests = $DB->get_records_sql("
SELECT
  fs.id,
  fs.userid,
  fs.forum,
  fs.maildigest,
  f.name,
  u.lastname,
  u.firstname
FROM mdl_forum f
JOIN mdl_forum_digests fs ON f.id=fs.forum
JOIN mdl_user u ON fs.userid=u.id
WHERE
  f.course=$sc_id AND
  f.forcesubscribe!=1 AND
  fs.userid NOT IN (
    SELECT ra.userid
    FROM
      mdl_role_assignments ra,
      mdl_role r
    WHERE
      ra.roleid=r.id AND
      r.shortname!='student'
    ) AND
  fs.userid NOT IN (
    SELECT userid
    FROM mdl_enrolment e
    JOIN mdl_semester_current curr ON BINARY e.semester=curr.semester AND curr.id=1
    WHERE
      e.enrolled=1
    ) AND
  u.lastaccess<$cutoff_time
ORDER BY f.name ASC, u.lastname ASC, u.firstname ASC");

echo '<strong>Student Digest Subscriptions that will be Removed (and remembered for later)...</strong>';
$table = new html_table();
$table->head = array(
  'Forum',
  'Family name',
  'Given name',
  );
foreach ($forum_digests as $forum_digest) {
  $rowdata = array();
  $rowdata[] = htmlspecialchars($forum_digest->forum, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($forum_digest->lastname, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($forum_digest->firstname, ENT_COMPAT, 'UTF-8');
  $table->data[] = $rowdata;
}
echo html_writer::table($table);

foreach ($forum_digests as $forum_digest) {
  fs.id,
  fs.userid,
  fs.forum,
  fs.maildigest,
}
*/
?>
