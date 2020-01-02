<?php  // display_receipt.php 20151109
/**
*
* Display a receipt for a Student
*
*/

require("../config.php");

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/display_receipt.php');
$PAGE->set_pagelayout('embedded');

$PAGE->set_title('Display Receipt');
$PAGE->set_heading('Display Receipt');
echo $OUTPUT->header();

echo '<h1>Display Receipt/Invoice, Click on link below (or Right Click to download)!</h1>';

$id = required_param('id', PARAM_INT);

echo '<a href="' . $CFG->wwwroot . '/course/fee_receipt.php?id=' . $id . '" target="_blank">Display/Download Receipt/Invoice</a><br /><br />';

echo $OUTPUT->footer();
?>
