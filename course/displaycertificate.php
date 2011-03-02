<?php  // $Id: displaycertificate.php,v 1.1 2009/04/17 17:30:00 alanbarrett Exp $
/**
*
* Display a certificate for a Volunteer
*
*/

require("../config.php");

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/displaycertificate.php');
$PAGE->set_pagelayout('embedded');

$PAGE->set_title('Display Certificate');
$PAGE->set_heading('Display Certificate');
echo $OUTPUT->header();

echo '<h1>Display Certificate, Click on link below!</h1>';

$id = required_param('id', PARAM_INT);

echo '<a href="' . $CFG->wwwroot . '/course/volunteercertificate.php?id=' . $id . '" target="_blank">Display Certificate</a><br /><br />';

echo $OUTPUT->footer();
?>
