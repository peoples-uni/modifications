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

$SESSION->wantsurl = "$CFG->wwwroot/course/application_form_returning_student.php"; // Redirect to here after login [will not be used see below]
//require_login(NULL, FALSE, NULL, FALSE);  // No course, Don't make user a Guest, No course, Don't override $SESSION->wantsurl
require_login(NULL, FALSE);  // No course, Don't make user a Guest [actually if they click "Guest" by mistake it is better to force them to login below (see "if (isguestuser())"), so DO allow override of $SESSION->wantsurl]
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

if (isguestuser()) {  // In case user has specifically logged in as Guest (or has been logged in automatically as Guest on some other page)
  $SESSION->wantsurl = "$CFG->wwwroot/course/application_form_returning_student.php";
  notice('<br /><br /><b>You must be logged in to do this! Please Click "Continue" below, and then log in with your username and password above!</b><br /><br /><br />', "$CFG->wwwroot/");
}

redirect($CFG->wwwroot . '/course/application_form_returning_student.php'); // If is already logged in, redirect

$PAGE->set_title('Redirect to Application Form');
$PAGE->set_heading('Redirect to Application Form');
echo $OUTPUT->header();

echo $OUTPUT->footer();
?>
