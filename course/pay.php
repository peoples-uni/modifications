<?php  // $Id: pay.php,v 1.1 2009/02/28 16:42:25 alanbarrett Exp $
/**
*
* Make a payment to WorldPay
*
*/

$test = true;
$test = false;

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$countryname = get_string_manager()->get_list_of_countries(false);

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/pay.php');
$PAGE->set_pagelayout('embedded');

$PAGE->set_title('Peoples-uni Payment');
$PAGE->set_heading('Peoples-uni Payment');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');


$sid = (int)$_REQUEST['sid'];
$application = $DB->get_record('peoplesapplication', array('sid' => $sid));
if (empty($application)) {
	notice('Error: The parameter passed does not correspond to a valid application to Peoples-uni!', "$CFG->wwwroot");
}

$name = htmlspecialchars($application->firstname . ' ' . $application->lastname, ENT_COMPAT, 'UTF-8');
$email = $application->email;

// Main entity escapes already added
$address = str_replace("\r", '', str_replace("\n", '&#10;', $application->applicationaddress));
$address2 = str_replace("\r", '', str_replace("\n", '<br />', $application->applicationaddress));
	// htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8');

$country = $application->country;

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

$amount = amount_to_pay($application->userid);
$original_amount = $amount;

if ($amount < .01) {
  // They have already paid their current instalment... allow them to pay their next instalment, if there is one (even though it is not due)
  $amount = get_next_unpaid_instalment($application->userid);

  if ($amount == 0) {
    notice('Error: There is zero owed for this application to Peoples-uni! Payment cannot be completed.', "$CFG->wwwroot");
  }
}
$currency = $application->currency;

$updated = new object();
$updated->id = $application->id;
$updated->dateattemptedtopay = time();
$DB->update_record('peoplesapplication', $updated);


// In e-mail from WorldPay on 20130219 they say by 30th April don't use IP (which we do not... so we should be OK), but use...
// Test environment:       https://secure-test.worldpay.com/wcc/purchase
// Production environment: https://secure.worldpay.com/wcc/purchase
// (this would apply to other payment pages)
// I assume, by strictly following their wording, that what we currently use will be OK...
if ($test) {
	$payurl = 'https://select-test.worldpay.com/wcc/purchase';
	$testresult = 'REFUSED';
	$testresult = 'ERROR';
	$testresult = 'CAPTURED';
	$testresult = 'AUTHORISED';
	$testresult = $name;		// will be AUTHORISED
}
else {
	$payurl = 'https://select.worldpay.com/wcc/purchase';
}

echo '<div align="center">';

echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';
echo '<p>(Our legal registration details: <a href="http://www.peoples-uni.org/content/details-registration-peoples-open-access-education-initiative" target="_blank">http://www.peoples-uni.org/content/details-registration-peoples-open-access-education-initiative</a>)</p>';

if ($amount == $original_amount) {
  echo "<p><br /><br /><b>Cost for your chosen modules (UK Pounds Sterling):&nbsp;&nbsp;&nbsp;$amount $currency</b></p>";

  echo "<p>Use the button below to pay for your enrolment in $modulespurchasedlong with WorldPay.<br />
  (Or to pay for Manchester Metropolitan University Master of Public Health programme.)</p>";
}
else {
  echo "<p><br /><br /><b>You have already paid your main instalment for this semester.</b></p>";

  echo "<p><b>Amount of your next instalment (UK Pounds Sterling):&nbsp;&nbsp;&nbsp;$amount $currency</b></p>";

  echo "<p>Use the button below to pay for your next unpaid instalment for Manchester Metropolitan University Master of Public Health programme.</p>";
  $modulespurchasedlong = "Next unpaid instalment for Manchester Metropolitan University Master of Public Health programme";
}

echo '<p>(note our refund policy: <a href="http://www.peoples-uni.org/content/refund-policy" target="_blank">http://www.peoples-uni.org/content/refund-policy</a>)</p>';

echo '<p>Your contact details...<br />';
echo "Name: $name<br />";
echo "e-mail: $email<br />";
echo "Address: $address2<br />";
$country2 = $countryname[$country];
echo "Country: $country2<br />";
echo 'If these do not match the credit card you are going to use then please click <a href="http://courses.peoples-uni.org/course/pay2.php?sid=' . $sid . '">HERE</a> to go to a different screen which will allow you to enter the correct details for your credit card and then make a payment.<br /></p>'

?>
<form action="<?php echo $payurl; ?>" method="post">
<input type="hidden" name="instId" value="232634" />
<input type="hidden" name="cartId" value="<?php echo $modulespurchased; ?>" />
<input type="hidden" name="currency" value="<?php echo $currency; ?>" />
<input type="hidden" name="amount" value="<?php echo $amount; ?>" />
<input type="hidden" name="desc" value="<?php echo $modulespurchasedlong; ?>" />

<?php
if ($test) {
?>
<input type="hidden" name="testMode" value="100" />
<input type="hidden" name="name" value="<?php echo $testresult; ?>" />
<?php
}
else {
?>
<input type="hidden" name="name" value="<?php echo $name; ?>" />
<?php
}
?>

<input type="hidden" name="email" value="<?php echo $email; ?>" />
<input type="hidden" name="address" value="<?php echo $address; ?>" />
<input type="hidden" name="country" value="<?php echo $country; ?>" />
<input type="hidden" name="M_sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="M_dateattemptedtopay" value="<?php echo $updated->dateattemptedtopay; ?>" />

<?php
// resultFile: The name of one of your uploaded files, which will be used to format the result.
// Please refer to Configuring Your Installation.
// If this is not specified, resultY.html or resultC.html are used as described in Payment Result - to You.
// accId<n>: specifies which merchant code should receive funds for this payment. By default our server tries accId1.
?>

<input type="submit" value="Click this to go to the WorldPay website to securely pay <?php echo "$amount $currency"; ?>" />

</form>
<br /><br />

<?php
//<script language="JavaScript" src="https://select.worldpay.com/wcc/logo?instId=XXXXX"></script>
?>

<img src=https://www.worldpay.com/cgenerator/logos/visa.gif border=0 alt="Visa Credit payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/visa_debit.gif border=0 alt="Visa Debit payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/visa_electron.gif border=0 alt="Visa Electron payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/mastercard.gif border=0 alt="Mastercard payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/maestro.gif border=0 alt="Maestro payments supported by WorldPay">
<?php if (false) { ?>
<img src=https://www.worldpay.com/cgenerator/logos/amex.gif border=0 alt="American Express payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/diners.gif border=0 alt="Diners payments supported by WorldPay">
<?php } ?>
<img src=https://www.worldpay.com/cgenerator/logos/jcb.gif border=0 alt="JCB">
<img src=https://www.worldpay.com/cgenerator/logos/solo.gif border=0 alt="Solo payments supported by WorldPay">
<?php if (false) { ?>
<img src=https://www.worldpay.com/cgenerator/logos/laser.gif border=0 alt="Laser payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/ELV.gif border=0 alt="ELV payments supported by WorldPay">
<?php } ?>
<?php if (true) { ?>
<a href=http://www.worldpay.com/index.php?CMP=BA2713><img src=https://www.worldpay.com/cgenerator/logos/poweredByWorldPay.gif border=0 alt="Powered By WorldPay"></a>
<?php } ?>
<?php if (false) { ?>
// Security Certificate Errors...
<a href=http://www.worldpay.com/index.php?CMP=BA2713><img src=https://www.rbsworldpay.com/images/cardlogos/poweredByRBSWorldPay.gif border=0 alt="Powered By WorldPay"></a>
<?php } ?>

</div>

<?php

echo $OUTPUT->box_end();
echo $OUTPUT->footer();


function amount_to_pay($userid) {
  global $DB;

  $amount = get_balance($userid);

  $inmmumph = FALSE;
  $mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE userid={$userid} AND userid!=0 LIMIT 1");
  if (!empty($mphs)) {
    foreach ($mphs as $mph) {
      $inmmumph = TRUE;
    }
  }

  $payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));

  if ($inmmumph) {
    // MPH: Take Outstanding Balance and adjust for instalments if necessary
    if (!empty($payment_schedule)) {
      $now = time();
      if     ($now < $payment_schedule->expect_amount_2_date) $amount -= ($payment_schedule->amount_2 + $payment_schedule->amount_3 + $payment_schedule->amount_4);
      elseif ($now < $payment_schedule->expect_amount_3_date) $amount -= (                              $payment_schedule->amount_3 + $payment_schedule->amount_4);
      elseif ($now < $payment_schedule->expect_amount_4_date) $amount -= (                                                            $payment_schedule->amount_4);
      // else the full balance should be paid (which is normally equal to amount_4, but the balance might have been adjusted or the student still might not be up to date with payments)
    }
  }

  if ($amount < 0) $amount = 0;
  return $amount;
}


function get_balance($userid) {
  global $DB;

  $balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} ORDER BY date DESC, id DESC LIMIT 1");
  $amount = 0;
  if (!empty($balances)) {
    foreach ($balances as $balance) {
      $amount = $balance->balance;
    }
  }

  return $amount;
}


function get_next_unpaid_instalment($userid) {
  global $DB;

  $original_amount = get_balance($userid);

  $inmmumph = FALSE;
  $mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE userid={$userid} AND userid!=0 LIMIT 1");
  if (!empty($mphs)) {
    foreach ($mphs as $mph) {
      $inmmumph = TRUE;
    }
  }
  if (!$inmmumph) return 0;

  $payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));
  if (empty($payment_schedule)) return 0;

  $now = time();

  // This assumes that zero is currently owing which implies that (at least) instalment 1 has been paid, see amount_to_pay() which has already been called
  // So let us see if instalment 2 is owing...
  $amount = $original_amount;
  if     ($now < $payment_schedule->expect_amount_3_date) $amount -= (                              $payment_schedule->amount_3 + $payment_schedule->amount_4);
  elseif ($now < $payment_schedule->expect_amount_4_date) $amount -= (                                                            $payment_schedule->amount_4);
  // else the full balance should be paid (which is normally equal to amount_4, but the balance might have been adjusted or the student still might not be up to date with payments)

  if ($amount < .01) { // So let us see if instalment 3 is owing...
    $amount = $original_amount;
    if ($now < $payment_schedule->expect_amount_4_date) $amount -= $payment_schedule->amount_4;
    // else the full balance should be paid (which is normally equal to amount_4, but the balance might have been adjusted or the student still might not be up to date with payments)
  }
  if ($amount < .01) { // So let us see if instalment 4 is owing...
    $amount = $original_amount;
  }

  if ($amount < .01) $amount = 0;
  return $amount;
}
?>
