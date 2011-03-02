<?php  // $Id: int.php,v 1.1 2008/11/09 21:13:00 alanbarrett Exp $
/**
*
* e-mail a person who has expresed an interest
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

require_login();

//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

print_header();

if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

$sid = $_REQUEST['sid'];
$familyname = stripslashes($_REQUEST['familyname']);
$familyname = strip_tags($familyname);
$givenname = stripslashes($_REQUEST['givenname']);
$givenname = strip_tags($givenname);
$email = stripslashes($_REQUEST['email']);
$email = strip_tags($email);
$comment = stripslashes($_REQUEST['comment']);
$comment = strip_tags($comment);
if ($comment === ' ') $comment = '';

if (!empty($_POST['defertext']) && !empty($_POST['markdeferapplication'])) {
	$body = stripslashes($_POST['defertext']);
	$body = strip_tags($body);
  $body = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $body); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                   // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

	$subject = 'Peoples-Uni Expression of Interest';

	if (!sendapprovedmail($email, $subject, $body)) {
		echo '<br/><br/><br/><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>';
	}
	else {
		$cid = '10';
		$ret = execute_sql('UPDATE d5_webform_submitted_data SET data=1 WHERE cid=' . $cid . ' AND sid=' . $_POST['sid']);
		echo '<script type="text/javascript">if (!window.opener.closed) {window.opener.location.reload();}</script>';
		echo '<script type="text/javascript">window.close();</script>';
	}
}
elseif (!empty($_POST['markupdatecomment'])) {
	$cid = '9';
	$ret = execute_sql("UPDATE d5_webform_submitted_data SET data='" . addslashes($comment) . "' WHERE cid=" . $cid . ' AND sid=' . $_POST['sid']);
	echo '<script type="text/javascript">if (!window.opener.closed) {window.opener.location.reload();}</script>';
	echo '<script type="text/javascript">window.close();</script>';
}
else {
  echo '<h1>e-mail: ' . htmlspecialchars($familyname, ENT_COMPAT, 'UTF-8') . ', ' . htmlspecialchars($givenname, ENT_COMPAT, 'UTF-8') . '</h1>';

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
<br /><br /><br />
<?php

print_footer();


function sendapprovedmail($email, $subject, $message) {

	// Dummy User
    $user = new object;
	$user->id = 999999999;
    $user->email = $email;
    $user->maildisplay = true;
	$user->mnethostid = 1;

    $supportuser = generate_email_supportuser();

    $messagehtml = text_to_html($message, false, false, true);

    $user->mailformat = 1;  // Always send HTML version as well

    $ret = email_to_user($user, $supportuser, $subject, $message, $messagehtml);

    $user->email = 'applicationresponses@peoples-uni.org';

    email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message, $messagehtml);

    return $ret;
}
?>
