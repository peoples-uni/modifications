<?php

/**
 * Survey form Successfully Submitted
 */

require_once('../config.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/survey_form_success.php');

$PAGE->set_title("People's Open Access Education Initiative Survey Form Successfully Submitted");
$PAGE->set_heading("People's Open Access Education Initiative Survey Form Successfully Submitted");

echo $OUTPUT->header();
echo $OUTPUT->heading("People's Open Access Education Initiative Survey Form Successfully Submitted");

echo '<p>';
echo 'Thank you for completing the survey.';
echo '</p>';

echo $OUTPUT->footer();
