<?php  // $Id: paydetails.php,v 1.1 2009/08/16 15:11:44 alanbarrett Exp $
/**
*
* Gather details of a payment from a user who has made a payment
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/paydetails.php');
$PAGE->set_pagelayout('embedded');

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
	$modulespurchasedlong = "Peoples-uni modules '$application->coursename1' and '$application->coursename2' for semester '$application->semester'";
}
$modulespurchasedlong = htmlspecialchars($modulespurchasedlong, ENT_COMPAT, 'UTF-8');

$amount = $application->costowed - $application->costpaid;
if ($amount < .01) {
	notice('You have already indicated that you have paid the fees for this application to Peoples-uni!', "$CFG->wwwroot");
}
$currency = $application->currency;


if (!empty($_POST['markpaydetails'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $updated = new object();
  $updated->id = $application->id;

  if (empty($_POST['paymentmechanism'])) notice('You must select the method you used for payment. Press Continue and re-select.', "$CFG->wwwroot/course/paydetails.php?sid=$sid");

  if ($_POST['paymentmechanism'] == 2) {
    $updated->paymentmechanism = 2;
    $mechanism = 'Barclays';
  }
  elseif ($_POST['paymentmechanism'] == 3) {
    $updated->paymentmechanism = 3;
    $mechanism = 'Diamond';
  }
  elseif ($_POST['paymentmechanism'] ==10) {
    $updated->paymentmechanism = 10;
    $mechanism = 'Ecobank';
  }
  elseif ($_POST['paymentmechanism'] == 4) {
    $updated->paymentmechanism = 4;
    $mechanism = 'Western Union';
  }
  elseif ($_POST['paymentmechanism'] == 5) {
    $updated->paymentmechanism = 5;
    $mechanism = 'Indian Confederation for Healthcare Accreditation for those taking Patient Safety module from India';
  }
  elseif ($_POST['paymentmechanism'] == 7) {
    $updated->paymentmechanism = 7;
    $mechanism = 'Posted Travellers Cheques';
  }
  elseif ($_POST['paymentmechanism'] == 8) {
    $updated->paymentmechanism = 8;
    $mechanism = 'Posted Cash';
  }
  elseif ($_POST['paymentmechanism'] == 9) {
    $updated->paymentmechanism = 9;
    $mechanism = 'MoneyGram';
  }
  else notice('You must select the method you used for payment. Press Continue and re-select.', "$CFG->wwwroot/course/paydetails.php?sid=$sid");

  if (empty($_POST['datafromworldpay'])) notice('You must enter text with details of the payment. Press Continue and re-enter.', "$CFG->wwwroot/course/paydetails.php?sid=$sid");

  $updated->datafromworldpay = $_POST['datafromworldpay'];

  $updated->costpaid = $application->costowed;

  $updated->datepaid = time();

  $DB->update_record('peoplesapplication', $updated);

  $info = strip_tags(dontstripslashes($_POST['datafromworldpay']));

  $message = "$name indicates that payment has been made using $mechanism.
The application has been marked as paid, assuming that this reflects reality.
Payment info that was entered by applicant: $info";

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999;
  $user->email = 'payments@peoples-uni.org';
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = generate_email_supportuser();

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $name . " Indicates that payment has been made ($mechanism)", $message);

  notice('Success! Data saved!', "$CFG->wwwroot");
}

echo '<div align="center">';
echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';
echo "<p><br /><br /><b>Cost for your chosen modules (UK Pounds Sterling):&nbsp;&nbsp;&nbsp;$amount $currency</b></p>";

// echo "<p>Select the method you used to pay.<br />Then enter confirmation/receipt information you received when you paid.<br />In particular, if you paid by Western Union, you must enter the Money Transfer Control Number (MTCN).<br />Then click Submit.</p>";
echo "<p>Select the method you used to pay.<br />Then enter confirmation/receipt information you received when you paid.<br />Then click Submit.</p>";

?>
<br /><br />
<form id="paydetailsform" method="post" action="<?php echo $CFG->wwwroot . '/course/paydetails.php'; ?>">

<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

Select the method you used for Payment: <select name="paymentmechanism">
<option value="0">Select one...</option>
<option value="2">Barclays Bank Transfer</option>
<option value="10">Ecobank Nigeria PLC. Transfer</option>
<option value="9">MoneyGram Payment</option>
<?php
//<option value="3">Diamond Bank Plc. Transfer</option>
//<option value="4">Western Union Payment</option>
//<option value="5">Indian Confederation for Healthcare Accreditation for those taking Patient Safety module from India</option>
//<option value="7">Posted Travellers Cheques</option>
//<option value="8">Posted Cash</option>
?>
</select><br /><br />

Enter confirmation/receipt information you received when you paid: <input type="text" size="60" name="datafromworldpay" />

<input type="hidden" name="markpaydetails" value="1" /><br /><br />
<input type="submit" name="paydetails" value="Submit your Payment Details" />
</form>
<br /><br />
</div>

<?php

echo $OUTPUT->box_end();
echo $OUTPUT->footer();


function dontstripslashes($x) {
  return $x;
}
?>
