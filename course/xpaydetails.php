<?php  // $Id: paydetails.php,v 1.1 2009/08/16 15:11:44 alanbarrett Exp $
/**
*
* Gather details of a payment from a user who has made a payment
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/paydetails.php');
$PAGE->set_pagelayout('embedded');

$PAGE->set_title('Peoples-uni Payment Details');
$PAGE->set_heading('Peoples-uni Payment Details');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');


$name = 'a b';

$modulespurchased = "Application number 999 for semester 'now'";
$modulespurchased = htmlspecialchars($modulespurchased, ENT_COMPAT, 'UTF-8');
$modulespurchasedlong = "Peoples-uni module 'ccc' for semester 'sss'";
$modulespurchasedlong = htmlspecialchars($modulespurchasedlong, ENT_COMPAT, 'UTF-8');

$amount = 1;
$original_amount = $amount;

$currency = 'cur';


if (!empty($_POST['markpaydetails'])) {

  $message  = "$name indicates that payment has been made using AB.\n";
  $message .= "Applicant's balance has been adjusted by $amount pounds (not confirmed).\n\n";
  $message .= "Payment info that was entered by applicant: $info\n";

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999;
  $user->email = 'alanabarrett0@gmail.com';
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = core_user::get_support_user();

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $name . " Indicates that payment has been made (AB)", $message);

  notice('Success! Data saved!', "$CFG->wwwroot");
}

echo '<div align="center">';
echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';

echo "<p><br /><br /><b>Amount that you owe up to and including this semester (UK Pounds Sterling):&nbsp;&nbsp;&nbsp;999 UKP</b></p>";

echo "<p>Select the method you used to pay.<br />Then enter confirmation/receipt information you received when you paid.<br />Then click Submit.</p>";

?>
<br /><br />
<form id="paydetailsform" method="post" action="<?php echo $CFG->wwwroot . '/course/xpaydetails.php'; ?>">

<input type="hidden" name="sid" value="<?php echo 999; ?>" />
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
?>
