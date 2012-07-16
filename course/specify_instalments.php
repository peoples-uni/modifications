<?php  // $Id: specify_instalments.php,v 1.1 2012/07/16 15:27:00 alanbarrett Exp $
/**
*
* Specify Instalments for a Student
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/specify_instalments.php');
$PAGE->set_pagelayout('standard');


require_login();
// (Might possibly be Guest?)

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

// Full access is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
$ismanager = has_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$userid = optional_param('userid', 0, PARAM_INT);
if (empty($userid) || !$ismanager) $userid = $USER->id;
if (empty($userid)) {echo '<h1>$userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}


$PAGE->set_title('Specify Instalments');
$PAGE->set_heading('Specify Instalments');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');


if (!empty($_POST['markspecifyinstalments'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  if (empty($_POST['paymentmechanism'])) notice('You must select the Payment Method/Status. Press Continue and re-select.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  Any MMU student (if they wanted to pay in instalments) would enter an (up to four semester) schedule for payments. If this is not done the student would have to pay the full amount in one go. Any individual (non zero) payment would have to be at least 25% of what is owed. The form will have a message: "Note: you must have completed all payment before you enrol for the Masters dissertation."


  $peoples_payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));
  if (empty($peoples_payment_schedule)) {
    $peoples_payment_schedule = new object();
    $insert = TRUE;
    $peoples_payment_schedule->userid = $userid;
    $peoples_payment_schedule->currency = 'GBP';
  }
  else {
    $insert = FALSE;
  }
  $peoples_payment_schedule->amount_1 = $_POST[''];
  $peoples_payment_schedule->amount_2 = $_POST[''];
  $peoples_payment_schedule->amount_3 = $_POST[''];
  $peoples_payment_schedule->amount_4 = $_POST[''];
  $peoples_payment_schedule->due_date_1 = $_POST[''];
  $peoples_payment_schedule->due_date_2 = $_POST[''];
  $peoples_payment_schedule->due_date_3 = $_POST[''];
  $peoples_payment_schedule->due_date_4 = $_POST[''];
  $peoples_payment_schedule->user_who_modified = $USER->id;
  $peoples_payment_schedule->date_modified = time();
  if ($insert) {
    $DB->insert_record('peoples_payment_schedule', $peoples_payment_schedule);
  }
  else {
    $DB->update_record('peoples_payment_schedule', $peoples_payment_schedule);
  }
}


echo '<div align="center">';
echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';

echo '<p><b>';

echo '<br /><br />' . fullname($userrecord);

$payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));
if (!empty($payment_schedule)) {
  echo '<br /><br /><br />';
  $table = new html_table();
  $table->head = array(
    'Last Date for Payment of Instalment 1',
    'Instalment 1 Amount',
    'Last Date for Payment of Instalment 2',
    'Instalment 2 Amount',
    'Last Date for Payment of Instalment 3',
    'Instalment 3 Amount',
    'Last Date for Payment of Instalment 4',
    'Instalment 4 Amount',
  );
  $rowdata = array();
  $rowdata[] = gmdate('d/m/Y', $payment_schedule->due_date_1);
  $rowdata[] = '&pound;' . number_format($payment_schedule->amount_1, 2);
  $rowdata[] = gmdate('d/m/Y', $payment_schedule->due_date_2);
  $rowdata[] = '&pound;' . number_format($payment_schedule->amount_2, 2);
  $rowdata[] = gmdate('d/m/Y', $payment_schedule->due_date_3);
  $rowdata[] = '&pound;' . number_format($payment_schedule->amount_3, 2);
  $rowdata[] = gmdate('d/m/Y', $payment_schedule->due_date_4);
  $rowdata[] = '&pound;' . number_format($payment_schedule->amount_4, 2);
  $table->data[] = $rowdata;
  echo html_writer::table($table);

  $user_who_modified = $DB->get_record('user', array('id' => $payment_schedule->user_who_modified));
  echo '<br />(last modified by ' . fullname($user_who_modified) . ' on ' . gmdate('d/m/Y H:i', $payment_schedule->date_modified) . ')';
}

echo '</b></p>';

if (empty($payment_schedule) || $ismanager) {
?>
<br /><br /><br /><p>Specify the Payment Schedule and then click "Submit the Instalment Payment Schedule".<br />

<?php
  if (!$ismanager) {
    echo <b>!NOTE CAN ONLY BE DOEN ONCE FOR STUDNET</b><br />;

    Like... not disertation.
    "All payments [[(including all instalment payments)]] must be completed before you can graduate"
    NO...
    Much as I'd like to agree with the proposal in your reply to Dick I'm still of the view that, as we discussed, the break point, for now, needs to come before the dissertation and that we review annually.
    Any MMU student (if they wanted to pay in instalments) would enter an (up to four semester) schedule for payments. If this is not done the student would have to pay the full amount in one go. Any individual (non zero) payment would have to be at least 25% of what is owed. The form will have a message: "Note: you must have completed all payment before you enrol for the Masters dissertation."

  }
?>

<form id="specifyinstalmentsform" method="post" action="<?php echo $CFG->wwwroot . '/course/specify_instalments.php?userid=' . $userid; ?>">

<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />


Payment Amount: <input type="text" size="60" name="amount_delta" value="" /><br />
are they allowed set any time yes base date on start of semester or half year????

<input type="hidden" name="markspecifyinstalments" value="1" />
<input type="submit" name="specifyinstalments" value="Submit the Instalment Payment Schedule" />
</form>

<?php
}
else {
  YOU HAVE ALREADY SET YOUR PAYMENT SCHEDUEL MAIL TO PAYMENTS IF NOT??????
}

echo '<br /><br /></div>';

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
?>
