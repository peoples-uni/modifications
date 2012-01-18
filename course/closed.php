<?php

/**
 * Applications are Closed
 */

require_once('../config.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/closed.php');

$PAGE->set_title("Applications are currently Closed");
$PAGE->set_heading('Applications are currently Closed');

echo $OUTPUT->header();

$semester_current = $DB->get_record('semester_current', array('id' => 1));

$found = preg_match('/^Starting (.{3,3}).* ([0-9]+)/', $semester_current->semester, $matches);
if ($found) {
  if ($matches[1] === 'Feb' || $matches[1] === 'Mar' || $matches[1] === 'Apr' || $matches[1] === 'May') {
    $next_date = 'September ' . $matches[2];
  }
  else {
    $next_date = 'March ' . ($matches[2] + 1);
  }
}
else {
  $next_date = 'after the current one';
}


echo '<p>Applications for the Semester ' . $semester_current->semester . ' Course Modules have now closed.</p>';

echo '<p><strong>If you are already registered in Moodle you will have to wait untill you are informed that Course Applications are open.<br />';

echo 'Note:</strong> The closing date for applications for enrolment in courses for the up coming semester is ' . gmdate('jS F Y', get_config(NULL, 'peoples_last_application_date')) . '. When enrolments are open you will be informed (this is normally about 2 to 3 weeks before that date).</p>';

echo '<p><strong>If you have not been registered in Moodle you must apply by <a href="http://courses.peoples-uni.org/course/registration.php">clicking here</a></strong></p>';

echo '<p>For inquires about course enrolment or payment please send an e-mail to <a href="mailto:apply@peoples-uni.org?subject=Registration or payment query">apply@peoples-uni.org</a>.</p>';


echo $OUTPUT->footer();
