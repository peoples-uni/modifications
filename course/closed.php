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


echo '<p>Applications for the Semester ' . $semester_current->semester . ' Course Modules have now closed.</p>
<p><strong>Please use this form to tell us if you might be interested in enrolling for the Semester Starting <u>'
. $next_date .
'</u>

Go to REegistartion..
<a href="http://www.peoples-uni.org/book/courses-offered">http://www.peoples-uni.org/book/courses-offered</a>.<br /></strong></p>

IF YOU ARE A CURRENT STUDNET YOU WILL BE NOTIFIED WHEN APPLICATIONS OPEN
<p><strong>We will then send you further information when applications open.</strong></p>');

DICK I SAID...
a)  Applications are closed for the semester... It will just display a message indicating that (maybe with a note indication that if they have never registered with Peoples-uni before to use the registration form


echo $OUTPUT->footer();
