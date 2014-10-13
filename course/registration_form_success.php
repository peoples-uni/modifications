<?php

/**
 * Registration form Successfully Submitted
 */

require_once('../config.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/registration_form_success.php');

$PAGE->set_title("People's Open Access Education Initiative Registration Form Successfully Submitted");
$PAGE->set_heading("People's Open Access Education Initiative Registration Form Successfully Submitted");

echo $OUTPUT->header();
echo $OUTPUT->heading("People's Open Access Education Initiative Registration Form Successfully Submitted");

echo '<p>';
echo 'Thank you for filling in this form. You should receive an email copy of your form with further information. If after an hour or two you have not received the email contact our support staff at - <strong><a href="mailto:apply@peoples-uni.org">apply@peoples-uni.org</a></strong> with your details.';
echo '</p>';

echo $OUTPUT->footer();
