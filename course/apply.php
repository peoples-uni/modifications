<?php
/**
*
* Force Student to login before going to normal application form.
*
*/


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/apply.php'); // Defined here to avoid notices on errors etc
$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();
// Might possibly be Guest... Anyway Guest user will not be able to do anything useful
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

//redirect($CFG->wwwroot . '/course/application_form_returning_student.php');

$PAGE->set_title('Redirect to Application Form');
$PAGE->set_heading('Redirect to Application Form');
echo $OUTPUT->header();

echo $OUTPUT->footer();
?>
