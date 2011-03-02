<?php  // $Id: listcertificates.php,v 1.1 2009/04/1 22:17:00 alanbarrett Exp $
/**
*
* List Certificates for Volunteers
*
*/

require("../config.php");

require_login();

require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

print_header('List Volunteer Certificates');

echo '<h1>List Volunteer Certificates</h1>';

$volunteercertificates = get_records_sql('SELECT * FROM mdl_volunteercertificate ORDER BY name ASC');

echo '<table border="1" BORDERCOLOR="RED">';

foreach ($volunteercertificates as $volunteercertificate) {
	echo '<tr>';
	echo '<td>';
	echo '<a href="' . $CFG->wwwroot . '/course/displaycertificate.php?id=' . $volunteercertificate->id . '" target="_blank">' . $CFG->wwwroot . '/course/displaycertificate.php?id=' . $volunteercertificate->id . '</a>';
	echo '</td>';
	echo '<td>';
?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/createcertificate.php'; ?>" target="_blank">
<input type="hidden" name="id" value="<?php echo $volunteercertificate->id; ?>" /><br />
<input type="hidden" name="title" value="<?php echo htmlspecialchars($volunteercertificate->title, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="name" value="<?php echo htmlspecialchars($volunteercertificate->name, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="body1" value="<?php echo htmlspecialchars($volunteercertificate->body1, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdatecertificate" value="1" />
<input type="submit" name="updatecertificate" value="Edit" />
</form>
<?php
	echo '</td>';
	echo '<td>';
	echo htmlspecialchars($volunteercertificate->title, ENT_COMPAT, 'UTF-8');
	echo '</td>';
	echo '<td>';
	echo htmlspecialchars($volunteercertificate->name, ENT_COMPAT, 'UTF-8');
	echo '</td>';
	echo '<td>';
	echo htmlspecialchars($volunteercertificate->body1, ENT_COMPAT, 'UTF-8');
	echo '</td>';
	echo '</tr>';
}

echo '</table>';

?>
<br /><br /><a href="<?php echo $CFG->wwwroot ?>/course/createcertificate.php" target="_blank">Create New Certificate</a>
<?php

print_footer();
?>
