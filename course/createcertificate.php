<?php  // $Id: createcertificate.php,v 1.1 2009/04/16 15:16:00 alanbarrett Exp $
/**
*
* Create a certificate for a Volunteer
*
*/

/*
CREATE TABLE mdl_volunteercertificate (
	id BIGINT(10) unsigned NOT NULL auto_increment,
	datecreated BIGINT(10) unsigned NOT NULL,
	name VARCHAR(255) NOT NULL,
	title VARCHAR(255) NOT NULL,
	body1 TEXT,
	body2 VARCHAR(255),
	body3 VARCHAR(255),
	body4 VARCHAR(255),
	body5 VARCHAR(255),
CONSTRAINT  PRIMARY KEY (id)
);
*/


require("../config.php");

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/createcertificate.php');
$PAGE->set_pagelayout('standard');

require_login();

require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Create Volunteer Certificate');
$PAGE->set_heading('Create Volunteer Certificate');
echo $OUTPUT->header();


$name = '';
$title = 'Certificate of Academic Input to the Peoples Open Access Education Initiative - Peoples-uni';
$title = "People's Open Access Education Initiative";
$body1 = 'has contributed to the academic activities of the Peoples-uni.';
$body2 = 'We gratefully acknowledge this.';
$body3 = '';
$body4 = '';
$body5 = '';

if (!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['title']) && !empty($_POST['markupdatecertificate']) && !empty($_POST['updatecertificate'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
	$volunteercertificate = new object();
	$_POST['id'] = (int)$_POST['id'];
	if (empty($_POST['id'])) {
	      notice('Bad ID!', "$CFG->wwwroot/index.php");
	}
	$volunteercertificate->id = $_POST['id'];
	$volunteercertificate->datecreated = time();
	$volunteercertificate->name = $_POST['name'];
	$volunteercertificate->title = $_POST['title'];
	if (empty($_POST['body1'])) $_POST['body1'] = '';
	if (empty($_POST['body2'])) $_POST['body2'] = '';
	if (empty($_POST['body3'])) $_POST['body3'] = '';
	if (empty($_POST['body4'])) $_POST['body4'] = '';
	if (empty($_POST['body5'])) $_POST['body5'] = '';
	$volunteercertificate->body1 = $_POST['body1'];
	$volunteercertificate->body2 = $_POST['body2'];
	$volunteercertificate->body3 = $_POST['body3'];
	$volunteercertificate->body4 = $_POST['body4'];
	$volunteercertificate->body5 = $_POST['body5'];
	$DB->update_record('volunteercertificate', $volunteercertificate);

	$id = $_POST['id'];

	$name = $_POST['name'];
	$title = $_POST['title'];
	$body1 = $_POST['body1'];
	$body2 = $_POST['body2'];
	$body3 = $_POST['body3'];
	$body4 = $_POST['body4'];
	$body5 = $_POST['body5'];

	$name = htmlspecialchars(dontstripslashes($name), ENT_COMPAT, 'UTF-8');
	$title = htmlspecialchars(dontstripslashes($title), ENT_COMPAT, 'UTF-8');
	$body1 = htmlspecialchars(dontstripslashes($body1), ENT_COMPAT, 'UTF-8');
	$body2 = htmlspecialchars(dontstripslashes($body2), ENT_COMPAT, 'UTF-8');
	$body3 = htmlspecialchars(dontstripslashes($body3), ENT_COMPAT, 'UTF-8');
	$body4 = htmlspecialchars(dontstripslashes($body4), ENT_COMPAT, 'UTF-8');
	$body5 = htmlspecialchars(dontstripslashes($body5), ENT_COMPAT, 'UTF-8');
}
elseif (!empty($_POST['name']) && !empty($_POST['title']) && !empty($_POST['markupdatecertificate']) && !empty($_POST['createcertificate'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
	$volunteercertificate = new object();
	$volunteercertificate->datecreated = time();
	$volunteercertificate->name = $_POST['name'];
	$volunteercertificate->title = $_POST['title'];
	if (empty($_POST['body1'])) $_POST['body1'] = '';
	if (empty($_POST['body2'])) $_POST['body2'] = '';
	if (empty($_POST['body3'])) $_POST['body3'] = '';
	if (empty($_POST['body4'])) $_POST['body4'] = '';
	if (empty($_POST['body5'])) $_POST['body5'] = '';
	$volunteercertificate->body1 = $_POST['body1'];
	$volunteercertificate->body2 = $_POST['body2'];
	$volunteercertificate->body3 = $_POST['body3'];
	$volunteercertificate->body4 = $_POST['body4'];
	$volunteercertificate->body5 = $_POST['body5'];
	$id = $DB->insert_record('volunteercertificate', $volunteercertificate);

	$name = $_POST['name'];
	$title = $_POST['title'];
	$body1 = $_POST['body1'];
	$body2 = $_POST['body2'];
	$body3 = $_POST['body3'];
	$body4 = $_POST['body4'];
	$body5 = $_POST['body5'];

	$name = htmlspecialchars(dontstripslashes($name), ENT_COMPAT, 'UTF-8');
	$title = htmlspecialchars(dontstripslashes($title), ENT_COMPAT, 'UTF-8');
	$body1 = htmlspecialchars(dontstripslashes($body1), ENT_COMPAT, 'UTF-8');
	$body2 = htmlspecialchars(dontstripslashes($body2), ENT_COMPAT, 'UTF-8');
	$body3 = htmlspecialchars(dontstripslashes($body3), ENT_COMPAT, 'UTF-8');
	$body4 = htmlspecialchars(dontstripslashes($body4), ENT_COMPAT, 'UTF-8');
	$body5 = htmlspecialchars(dontstripslashes($body5), ENT_COMPAT, 'UTF-8');
}

if (!empty($id)) {
	echo '<a href="' . $CFG->wwwroot . '/course/volunteercertificate.php?id=' . $id . '" target="_blank">Click THIS LINK to Preview Certificate</a><br />';
?>
<br />Change the text and then click "Update Certificate"...<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR
<?php
}
else {
	$id ='';
}
?>
<br />Enter something in at least the Title & Name fields and then click "Create New Certificate"...<br />
<form id="updatecertificateform" method="post" action="<?php echo $CFG->wwwroot . '/course/createcertificate.php'; ?>">
Title&nbsp;of&nbsp;Certificate:&nbsp;<input type="text" size="100" name="title" value="<?php echo $title; ?>" /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that<br />
Person's&nbsp;Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="100" name="name" value="<?php echo $name; ?>" /><br />
Body:&nbsp;<input type="text" size="200" name="body1" value="<?php echo $body1; ?>" /><br />
<input type="hidden" name="id" value="<?php echo $id ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdatecertificate" value="1" />

<?php
if (!empty($id)) {
?>
<br /><input type="submit" name="updatecertificate" value="Update Certificate" style="width:40em" />
<?php
}
?>
<br />
<br /><input type="submit" name="createcertificate" value="Create New Certificate" style="width:40em" />
</form>
<br /><br />
<?php

echo '<br /><br /><br />';
if (!empty($id)) {
	echo 'Send this EXACT link to Cerificate Recipient: <a href="' . $CFG->wwwroot . '/course/displaycertificate.php?id=' . $id . '" target="_blank">' . $CFG->wwwroot . '/course/displaycertificate.php?id=' . $id . '</a><br /><br />';
}

?>
<br/><strong><a href="javascript:window.close();">Close Window</a></strong><br />
<br /><a href="<?php echo $CFG->wwwroot ?>/course/listcertificates.php">List All Certificates</a>
<br />
<?php

echo $OUTPUT->footer();


function dontstripslashes($x) {
  return $x;
}
?>
