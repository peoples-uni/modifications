<?php  // $Id: reset_studentscorner_subscriptions.php,v 1.1 2015/01/15 18:31:00 alanbarrett Exp $
/**
*
* Determine if Student Support Forum Subscriptions in Students Corner have changed and change back if desired
*
*/

/*
CREATE TABLE mdl_forum_subscriptions_specified (
  id bigint(10) NOT NULL AUTO_INCREMENT,
  userid bigint(10) NOT NULL DEFAULT '0',
  forum bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `mdl_forusspec_use_ix` (`userid`),
  KEY `mdl_forusspec_for_ix` (`forum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
*/

require("../config.php");

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/reset_studentscorner_subscriptions.php'); // Defined here to avoid notices on errors etc

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
  $SESSION->wantsurl = "$CFG->wwwroot/course/reset_studentscorner_subscriptions.php";
  notice('<br /><br /><b>Click Continue and Login</b><br /><br />', "$CFG->wwwroot/");
}


$PAGE->set_title('Determine if Student Support Forum Subscriptions have changed');
$PAGE->set_heading('Determine if Student Support Forum Subscriptions have changed');
echo $OUTPUT->header();
echo '<strong>Determine if Student Support Forum Subscriptions have changed</strong><br /><br />';


$sc = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_students_corner_id')));
if (!empty($sc)) {
  $sc_id = $sc->id;
}
else {
  $sc_id = -1;
  echo 'Students Corner Course not found!<br />';
}


if (!empty($_POST['markresetsubscriptions'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  if (!empty($_POST['resetoriginal'])) {
    foreach ($_POST['resetoriginal'] as $userid => $value) {
      if (empty($_POST['acceptchanged'][$userid])) { // Make sure both checkboxes not set
        remove_subscriptions($userid, $sc_id, 'forum_subscriptions');
        remove_subscriptions_recorded($userid, $sc_id, 'forum_subscriptions_recorded');
        copy_subscriptions($userid, $sc_id, 'forum_subscriptions_specified', '', 'forum_subscriptions'); // Copy subscriptions_specified into subscriptions
      }
    }
  }

  if (!empty($_POST['acceptchanged'])) {
    foreach ($_POST['acceptchanged'] as $userid => $value) {
      if (empty($_POST['resetoriginal'][$userid])) { // Make sure both checkboxes not set
        remove_subscriptions_specified($userid, $sc_id, 'forum_subscriptions_specified');
        copy_subscriptions($userid, $sc_id, 'forum_subscriptions', 'forum_subscriptions_recorded', 'forum_subscriptions_specified'); // Copy subscriptions & subscriptions_recorded to subscriptions_specified
      }
    }
  }
}


$forum_subscriptions           = get_forum_subscriptions($sc_id, 'forum_subscriptions');
$forum_subscriptions_recorded  = get_forum_subscriptions($sc_id, 'forum_subscriptions_recorded');
$forum_subscriptions_specified = get_forum_subscriptions($sc_id, 'forum_subscriptions_specified');

$forum_subscriptions_userids           = array_keys($forum_subscriptions);
$forum_subscriptions_recorded_userids  = array_keys($forum_subscriptions_recorded);
$forum_subscriptions_specified_userids = array_keys($forum_subscriptions_specified);
$userids = implode(',', array_unique(array_merge($forum_subscriptions_userids, $forum_subscriptions_recorded_userids, $forum_subscriptions_specified_userids)));
echo $userids;//(**)
if (empty($userids)) $userids = '-1';

$users_list = $DB->get_records_sql("
SELECT
  u.id,
  u.lastname,
  u.firstname
FROM mdl_user u
WHERE id IN ($userids)
ORDER BY u.lastname ASC, u.firstname ASC, u.id");


?>
<form id="resetsubscriptionsform" method="post" action="<?php echo $CFG->wwwroot . '/course/reset_studentscorner_subscriptions.php'; ?>">
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<table border="1" BORDERCOLOR="RED">
<tr>
<td>Family name</td>
<td>Given name</td>
<td>Original Forum Subscriptions, Check if Subscription should be Changed back to Original</td>
<td>Changed Forum Subscriptions, Check if Changed Subscription should be Accepted</td>
</tr>
<?php


foreach ($users_list as $userid => $user_record) {
  if (empty($forum_subscriptions_specified[$userid]) || empty($forum_subscriptions_specified[$userid]->fs_names)) {
    $forum_specified = array();
  }
  else {
    $forum_specified = explode('XQ,YQ', $forum_subscriptions_specified[$userid]->fs_names);
  }
  $original = array_unique($forum_specified);
  natcasesort($original);
  $original = implode(', ', $original);

  if (empty($forum_subscriptions[$userid]) || empty($forum_subscriptions[$userid]->fs_names)) {
    $forum_subscription = array();
  }
  else {
    $forum_subscription = explode('XQ,YQ', $forum_subscriptions[$userid]->fs_names);
  }
  if (empty($forum_subscriptions_recorded[$userid]) || empty($forum_subscriptions_recorded[$userid]->fs_names)) {
    $forum_recorded = array();
  }
  else {
    $forum_recorded = explode('XQ,YQ', $forum_subscriptions_recorded[$userid]->fs_names);
  }
  $changed = array_unique(array_merge($forum_subscription, $forum_recorded));
  natcasesort($changed);
  $changed = implode(', ', $changed);


  if (TRUE || $original != $changed) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($user_record->lastname, ENT_COMPAT, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($user_record->firstname, ENT_COMPAT, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($original, ENT_COMPAT, 'UTF-8') . ' <input type="checkbox" name="resetoriginal[' . $userid . ']"></td>';
    echo '<td>' . htmlspecialchars($changed, ENT_COMPAT, 'UTF-8') . ' <input type="checkbox" name="acceptchanged[' . $userid . ']"></td>';
    echo '</tr>';
  }
}
?>
</table><br />

<input type="hidden" name="markresetsubscriptions" value="1" />
<input type="submit" name="resetsubscriptions" value="Change Back Subscriptions (or keep them) based on checkboxes above" style="width:50em" />
</form>
<br />


<?php
echo '<br /><br /><br />';

echo $OUTPUT->footer();


function get_forum_subscriptions($sc_id, $table) {
  global $DB;

  return $DB->get_records_sql("
SELECT
  fs.userid,
  GROUP_CONCAT(fs.id) AS fs_ids,
  GROUP_CONCAT(REPLACE(f.name, 'Student Support Group ', '') ORDER BY f.name SEPARATOR 'XQ,YQ') AS fs_names,
  u.lastname,
  u.firstname
FROM mdl_forum f
JOIN mdl_$table fs ON f.id=fs.forum
JOIN mdl_user u ON fs.userid=u.id
WHERE
  f.course=$sc_id AND
  f.forcesubscribe!=1 AND
  f.name LIKE 'Student Support Group%' AND
  fs.userid IN (
    SELECT r.userid
    FROM mdl_peoplesregistration r
    WHERE r.hidden=0 AND r.state=1) AND
  fs.userid IN ( /* The subscriber is a Student in Students Corner */
    SELECT ue.userid
    FROM mdl_user_enrolments ue
    JOIN mdl_enrol e ON e.id=ue.enrolid AND e.courseid=$sc_id) AND
  fs.userid NOT IN ( /* The subscriber does not have any role other than Student (we do not want to remove Tutors or Viewer etc.) */
    SELECT ra.userid
    FROM
      mdl_role_assignments ra,
      mdl_role ro
    WHERE
      ra.roleid=ro.id AND
      ro.shortname!='student')
/*AND u.id=2895*/ /* (**) */
GROUP BY fs.userid
ORDER BY u.lastname ASC, u.firstname ASC, u.id");
}


function remove_subscriptions($userid, $sc_id, $table) {
  global $DB;

  $records = $DB->get_records_sql("
    SELECT
      fs.id
    FROM mdl_forum f
    JOIN mdl_$table fs ON f.id=fs.forum
    WHERE
      f.course=$sc_id AND
      f.forcesubscribe!=1 AND
      f.name LIKE 'Student Support Group%' AND
      fs.userid=$userid");
  foreach ($records as $record) {
    $DB->delete_records($table, array('id' => $record->id));
  }
}


function copy_subscriptions($userid, $sc_id, $table_from1, $table_from2, $table_to) {
  global $DB;

  $records = $DB->get_records_sql("
    SELECT DISTINCT
      fs.forum,
      fs.userid
    FROM mdl_forum f
    JOIN mdl_$table_from1 fs ON f.id=fs.forum
    WHERE
      f.course=$sc_id AND
      f.forcesubscribe!=1 AND
      f.name LIKE 'Student Support Group%' AND
      fs.userid=$userid");
  foreach ($records as $record) {
    if (!$DB->record_exists($table_to, array('userid' => $record->userid, 'forum' => $record->forum))) {
      $DB->insert_record($table_to, $record);
    }
  }

  if (empty($table_from2)) return;
  $records = $DB->get_records_sql("
    SELECT DISTINCT
      fs.forum,
      fs.userid
    FROM mdl_forum f
    JOIN mdl_$table_from2 fs ON f.id=fs.forum
    WHERE
      f.course=$sc_id AND
      f.forcesubscribe!=1 AND
      f.name LIKE 'Student Support Group%' AND
      fs.userid=$userid");
  foreach ($records as $record) {
    if (!$DB->record_exists($table_to, array('userid' => $record->userid, 'forum' => $record->forum))) {
      $DB->insert_record($table_to, $record);
    }
  }
}
?>