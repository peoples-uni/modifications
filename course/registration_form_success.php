<?php

/**
 * Registration form Successfully Submitted
 */

require_once('../config.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/registration_form_success.php');

$PAGE->set_title("People's Open Access Education Initiative Registration Form Successfully Submitted");
$PAGE->set_heading("People's Open Access Education Initiative Registration Form Successfully Submitted");

echo $OUTPUT->header();
echo $OUTPUT->heading("People's Open Access Education Initiative Registration Form Successfully Submitted");

echo '<p>';
echo 'Thank you for registering. You should receive an email copy of your registration. If after an hour or two you have not received the email contact our support staff at - <strong><a href="mailto:techsupport@peoples-uni.org">techsupport@peoples-uni.org</a></strong> with your details.';
echo '</p>';

echo $OUTPUT->footer();
