<?php

/**
 * Interest form Successfully Submitted
 */

require_once('../config.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');
$PAGE->set_url('/course/interest_form_success.php');

$PAGE->set_title("People's Open Access Education Initiative Interest Form Successfully Submitted");
$PAGE->set_heading("People's Open Access Education Initiative Interest Form Successfully Submitted");

echo $OUTPUT->header();
echo $OUTPUT->heading("People's Open Access Education Initiative Expression of Interest Form Successfully Submitted");

echo '<p>';
echo 'Thank you for expressing an interesting doing one or two course modules. You should receive an email copy of your expression of interest. If after an hour or two you have not received the email contact our support staff at - <strong><a href="mailto:techsupport@peoples-uni.org">techsupport@peoples-uni.org</a></strong> with your details.';
echo '</p>';
echo '<p>';
echo 'We will send you further information when applications open.';
echo '</p>';

echo $OUTPUT->footer();
