<?php  // $Id: payconfirm.php,v 1.1 2009/09/14 12:00:00 alanbarrett Exp $
/**
*
* Update details of a payment by a user
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/payconfirm.php');
$PAGE->set_pagelayout('standard');

require_login();
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Peoples-uni Payment Details');
$PAGE->set_heading('Peoples-uni Payment Details');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');


$sid = (int)$_REQUEST['sid'];
$application = $DB->get_record('peoplesapplication', array('sid' => $sid));
if (empty($application)) {
	notice('Error: The parameter passed does not correspond to a valid application to Peoples-uni!', "$CFG->wwwroot");
}

$name = htmlspecialchars($application->firstname . ' ' . $application->lastname, ENT_COMPAT, 'UTF-8');

$modulespurchased = "Application number $sid for semester '$application->semester'";
$modulespurchased = htmlspecialchars($modulespurchased, ENT_COMPAT, 'UTF-8');
if (empty($application->coursename2)) {
	$modulespurchasedlong = "Peoples-uni module '$application->coursename1' for semester '$application->semester'";
}
else {
  $state = (int)$application->state;
  // Legacy fixups...
  if ($state === 2) {
    $state = 022;
  }
  if ($state === 1) {
    $state = 011;
  }

  $state1 = $state & 07;
  $state2 = $state & 070;

  $module_1_approved = ($state1 ===  01) || ($state1 ===  03);
  $module_2_approved = ($state2 === 010) || ($state2 === 030);

  if     ($module_1_approved && !$module_2_approved) {
    $modulespurchasedlong = "Peoples-uni module '$application->coursename1' for semester '$application->semester'";
  }
  elseif ($module_2_approved && !$module_1_approved) {
    $modulespurchasedlong = "Peoples-uni module '$application->coursename2' for semester '$application->semester'";
  }
  else {
    $modulespurchasedlong = "Peoples-uni modules '$application->coursename1' and '$application->coursename2' for semester '$application->semester'";
  }
}
$modulespurchasedlong = htmlspecialchars($modulespurchasedlong, ENT_COMPAT, 'UTF-8');

$amount = $application->costowed;
$currency = $application->currency;


if (!empty($_POST['markpayconfirm'])) {
    if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

    $updated = new object();
    $updated->id = $application->id;

    if (empty($_POST['paymentmechanism'])) notice('You must select the method you used for payment. Press Continue and re-select.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");

    $updated->paymentmechanism = (int)$_POST['paymentmechanism'];
    if ($updated->paymentmechanism != 6) {
		$updated->costpaid = $application->costowed;
	}

    $DB->update_record('peoplesapplication', $updated);

    notice('Success! Data saved!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
}
elseif (!empty($_POST['marksetowed'])) {
    if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

    $updated = new object();
    $updated->id = $application->id;

    if (!isset($_POST['costpaid']) || !is_numeric($_POST['costpaid'])) {
		notice('Amount Paid must be a number. Press Continue and re-select.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
	}
    if (!isset($_POST['costowed']) || !is_numeric($_POST['costowed'])) {
		notice('Amount Owed must be a number. Press Continue and re-select.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
	}

	$updated->costpaid = $_POST['costpaid'];
	$updated->costowed = $_POST['costowed'];

    $DB->update_record('peoplesapplication', $updated);

    notice('Success! Data saved!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
}

echo '<div align="center">';
echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';

echo "<p><br /><br /><b>$name<br />$modulespurchasedlong<br />Amount Owed:&nbsp;&nbsp;&nbsp;$amount $currency<br />Amount Paid:&nbsp;&nbsp;&nbsp;{$application->costpaid} $currency</b></p>";

echo '<br /><p>Update the payment confirmation status and then click "Submit the Payment Status".<br />(Note: Amount Paid will be set equal to Amount Owed,<br /> except when "Promised to Pay by End of Semester" is selected.)</p>';

?>
<form id="payconfirmform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">

<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

Select the new payment status: <select name="paymentmechanism">
<option value="0">Select one...</option>
<option value="2">Barclays Bank Transfer</option>
<option value="3">Diamond Bank Plc. Transfer</option>
<option value="9">MoneyGram Payment</option>
<option value="4">Western Union Payment</option>
<option value="5">Indian Confederation for Healthcare Accreditation for those taking Patient Safety module from India</option>
<option value="7">Posted Travellers Cheques</option>
<option value="8">Posted Cash</option>
<option value="6">Promised to Pay by End of Semester</option>
<option value="100">Waiver</option>
<option value="102">Confirmed: Barclays Bank Transfer</option>
<option value="103">Confirmed: Diamond Bank Transfer</option>
<option value="109">Confirmed: MoneyGram</option>
<option value="104">Confirmed: Western Union</option>
<option value="105">Confirmed: Indian Confederation</option>
<option value="107">Confirmed: Posted Travellers Cheques</option>
<option value="108">Confirmed: Posted Cash</option>
</select><br /><br />

<input type="hidden" name="markpayconfirm" value="1" />
<input type="submit" name="payconfirm" value="Submit the Payment Status" />
</form>
<br /><br /><br />
<p>If the person did not pay the full amount (or even overpaid) set the Amount Paid here and then click "Submit the New Amount Paid".<br />
(You can also set the Amount Owed if that has to be changed for some special reason.)</p>

<form id="setowedform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">

<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

Amount Paid: <input type="text" size="60" name="costpaid" value="<?php echo $application->costpaid ?>" /><br />
Amount Owed: <input type="text" size="60" name="costowed" value="<?php echo $application->costowed ?>" /><br />
<br />

<input type="hidden" name="marksetowed" value="1" />
<input type="submit" name="setowed" value="Submit the New Amount Paid (& Owed)" />
</form>
<br /><br />
</div>

<?php

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
?>
