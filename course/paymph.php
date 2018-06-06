<?php  // $Id: paymph.php,v 1.1 2011/07/19 15:02:00 alanbarrett Exp $
/**
*
* Pay for EUCLID University MPH
*
*/

$test = true;
$test = false;


require("../config.php");

$countryname = get_string_manager()->get_list_of_countries(false);

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/paymph.php');
$PAGE->set_pagelayout('embedded');

$PAGE->set_title('Payment for EUCLID University MPH');
$PAGE->set_heading('Payment for EUCLID University MPH');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');

if ($test) {
	$payurl = 'https://select-test.worldpay.com/wcc/purchase';
}
else {
	$payurl = 'https://select.worldpay.com/wcc/purchase';
}

echo '<div align="center">';

echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';
echo '<p>(Our legal registration details: <a href="https://www.peoples-uni.org/content/details-registration-peoples-open-access-education-initiative" target="_blank">https://www.peoples-uni.org/content/details-registration-peoples-open-access-education-initiative</a>)</p><br />';

//echo '<p><b>You should only pay if you have been notified that you have been accepted on the Manchester Metropolitan University Master of Public Health programme.</b></p>';

echo '<p><b>Enter the agreed amount in UK Pounds to pay for the EUCLID University MPH, enter your contact information and then click the button below to make your payment with WorldPay.</b></p>';

$donatetime = time();
?>
<script type="text/JavaScript">
function verify() {
  var amount = document.donateform.amount.value;
  if (isNaN(amount)) {
    alert("The amount you specified is not a valid number, please input it again");
    document.donateform.amount.focus();
    return false;
  }
  if (amount < 1) {
    alert("You must enter a payment amount, please input it again");
    document.donateform.amount.focus();
    return false;
  }

  var name = document.donateform.name.value;
  if (name == "") {
    alert("You must enter your name, please input it again");
    document.donateform.name.focus();
    return false;
  }

  var email = document.donateform.email.value;
  if (email == "") {
    alert("You must enter an e-mail address, please input it again");
    document.donateform.email.focus();
    return false;
  }
  if (!checkemail(email)) {
    alert("The e-mail you specified is not valid, please input it again");
    document.donateform.email.focus();
    return false;
  }

  var address = document.donateform.address.value;
  if (address == "") {
    alert("You must enter your address, please input it again");
    document.donateform.address.focus();
    return false;
  }

  var country = document.donateform.country.value;
  if (country == "") {
    alert("You must enter your country, please input it again");
    document.donateform.country.focus();
    return false;
  }

  return true;
}

function checkemail(str) {
  if (!str.match(/^[\w]{1}[\w\.\&\-_]*@[\w]{1}[\w\-_\.]*\.[\w]{2,6}$/i)) {
    return false;
  }
  else {
    return true;
  }
}
</script>

<p>(note our refund policy: <a href="https://www.peoples-uni.org/content/refund-policy" target="_blank">https://www.peoples-uni.org/content/refund-policy</a>)</p>

<form action="<?php echo $payurl; ?>" method="post" onSubmit="return verify()" name="donateform">
<input type="hidden" name="instId" value="232634" />
<input type="hidden" name="cartId" value="EUCLID University MPH <?php echo $donatetime; ?>" />
<input type="hidden" name="currency" value="GBP" />

<strong>Amount in UK Pounds:&nbsp;</strong><input type="text" size="10" name="amount" /><br /><br />
<input type="hidden" name="desc" value="EUCLID University MPH Course Payment <?php echo $donatetime; ?>" />

<?php
if ($test) {
?>
<input type="hidden" name="testMode" value="100" />
<?php
}
?>
<table border="2" cellpadding="2">
<tr>
<td>Your name on Credit Card:</td><td><input type="text" size="75" name="name" /></td>
</tr>
<tr>
<td>Your email:</td><td><input type="text" size="75" name="email" /></td>
</tr>
<tr>
<td>Your Address (matching Credit Card):</td><td><input type="text" size="75" name="address" /></td>
</tr>
<tr>
<td>Your Country (matching Credit Card):</td><td><select name="country">
<option value="" selected="selected">select...</option>
<?php
foreach ($countryname as $key => $countryvalue) {
?>
<option value="<?php echo $key . '"'; ?> ><?php echo $countryvalue; ?></option>
<?php
}
?>
</select>
</td>
</tr>
</table>
<br />
<input type="hidden" name="M_mph" value="<?php echo $donatetime; ?>" />
<input type="submit" value="Click this to go to the WorldPay website to securely make your payment" />

</form>
<br /><br />


<img src=https://www.worldpay.com/cgenerator/logos/visa.gif border=0 alt="Visa Credit payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/visa_debit.gif border=0 alt="Visa Debit payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/visa_electron.gif border=0 alt="Visa Electron payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/mastercard.gif border=0 alt="Mastercard payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/maestro.gif border=0 alt="Maestro payments supported by WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/jcb.gif border=0 alt="JCB">
<img src=https://www.worldpay.com/cgenerator/logos/solo.gif border=0 alt="Solo payments supported by WorldPay">
<a href=http://www.worldpay.com/index.php?CMP=BA2713><img src=https://www.worldpay.com/cgenerator/logos/poweredByWorldPay.gif border=0 alt="Powered By WorldPay"></a>

</div>

<?php

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
?>
