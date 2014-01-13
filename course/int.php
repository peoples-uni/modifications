<?php  // $Id: int.php,v 1.1 2008/11/09 21:13:00 alanbarrett Exp $
/**
*
* e-mail a person who has expresed an interest
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/int.php'); // Defined here to avoid notices on errors etc

$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();

//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

$sid = $_REQUEST['sid'];

if (empty($_REQUEST['familyname'])) $_REQUEST['familyname'] = '';
$familyname = dontstripslashes($_REQUEST['familyname']);
$familyname = trim(strip_tags($familyname));

if (empty($_REQUEST['givenname'])) $_REQUEST['givenname'] = '';
$givenname = dontstripslashes($_REQUEST['givenname']);
$givenname = trim(strip_tags($givenname));

if (empty($_REQUEST['email'])) $_REQUEST['email'] = '';
$email = dontstripslashes($_REQUEST['email']);
$email = trim(strip_tags($email));

if (empty($_REQUEST['comment'])) $_REQUEST['comment'] = '';
$comment = dontstripslashes($_REQUEST['comment']);
if ($comment === ' ') $comment = '';

if (!empty($familyname)) {
  $PAGE->set_title('e-mail: ' . htmlspecialchars($familyname, ENT_COMPAT, 'UTF-8') . ', ' . htmlspecialchars($givenname, ENT_COMPAT, 'UTF-8'));
  $PAGE->set_heading('e-mail: ' . htmlspecialchars($familyname, ENT_COMPAT, 'UTF-8') . ', ' . htmlspecialchars($givenname, ENT_COMPAT, 'UTF-8'));
}
echo $OUTPUT->header();

if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

echo '<script type="text/JavaScript">function areyousuredeleteentry() { var sure = false; sure = confirm("Are you sure you want to Hide this Application Form Entry for ' . htmlspecialchars($givenname, ENT_COMPAT, 'UTF-8') . ' ' . htmlspecialchars($familyname, ENT_COMPAT, 'UTF-8') . ' from All Future Processing?"); return sure;}</script>';


if (!empty($_POST['defertext']) && !empty($_POST['markdeferapplication'])) {
  $body = dontstripslashes($_POST['defertext']);
  $body = strip_tags($body);
  $body = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $body); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                   // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

  $subject = 'Peoples-Uni Expression of Interest';

	if (!sendapprovedmail($email, $subject, $body)) {
		echo '<br/><br/><br/><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>';
	}
	else {
    $interest = $DB->get_record('peoplesinterest', array('id' => $_POST['sid']));
    $interest->state = 1;
    $DB->update_record('peoplesinterest', $interest);
    echo '<script type="text/javascript">if (!window.opener.closed) {window.opener.location.reload();}</script>';
    echo '<script type="text/javascript">window.close();</script>';
	}
}
elseif (!empty($_POST['markupdatecomment'])) {
  $interest = $DB->get_record('peoplesinterest', array('id' => $_POST['sid']));
  $interest->comment = htmlspecialchars($comment, ENT_COMPAT, 'UTF-8');
  $DB->update_record('peoplesinterest', $interest);
  echo '<script type="text/javascript">if (!window.opener.closed) {window.opener.location.reload();}</script>';
  echo '<script type="text/javascript">window.close();</script>';
}
elseif (!empty($_POST['markdeleteentry'])) {
  $interest = $DB->get_record('peoplesinterest', array('id' => $_POST['sid']));
  $interest->hidden = 1;
  $DB->update_record('peoplesinterest', $interest);
  echo '<script type="text/javascript">if (!window.opener.closed) {window.opener.location.reload();}</script>';
  echo '<script type="text/javascript">window.close();</script>';
}
else {
  $peoples_interest_email = get_config(NULL, 'peoples_interest_email');
  $peoples_interest_email = str_replace('GIVEN_NAME_HERE', $givenname, $peoples_interest_email);
  $peoples_interest_email = htmlspecialchars($peoples_interest_email, ENT_COMPAT, 'UTF-8');
?>
<br />Edit the e-mail text below, then press "e-mail".
<form id="deferapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/int.php'; ?>">
<input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_COMPAT, 'UTF-8'); ?>" />
<textarea name="defertext" rows="16" cols="75" wrap="hard">
<?php echo $peoples_interest_email; ?>
</textarea>
<input type="hidden" name="sid" value="<?php echo $sid ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeferapplication" value="1" />
<input type="submit" name="deferapplication" value="e-mail" />
</form>

<br /><br /><br />Enter/Update the comment text below for this expression of interest, then press "Update".
<form id="updatecommentform" method="post" action="<?php echo $CFG->wwwroot . '/course/int.php'; ?>">

<textarea name="comment" rows="5" cols="75" wrap="hard"><?php echo htmlspecialchars($comment, ENT_COMPAT, 'UTF-8'); ?></textarea>

<input type="hidden" name="sid" value="<?php echo $sid ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdatecomment" value="1" />
<input type="submit" name="updatecomment" value="Update" />
</form>

<?php
}
?>
<br /><br /><br /><br />
<strong><a href="javascript:window.close();">Close Window</a></strong>
<br /><br /><br /><br /><br /><br /><br /><br />
<form id="deleteentryform" method="post" action="<?php echo $CFG->wwwroot . '/course/int.php'; ?>" onSubmit="return areyousuredeleteentry()">
<input type="hidden" name="sid" value="<?php echo $sid ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeleteentry" value="1" />
<input type="submit" name="deleteentry" value="Hide this Application Form Entry from All Future Processing" />
</form>
<br /><br /><br />
<?php

echo $OUTPUT->footer();


function sendapprovedmail($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999;
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = generate_email_supportuser();

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  $user->email = 'applicationresponses@peoples-uni.org';

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}


function dontstripslashes($x) {
  return $x;
}
?>
