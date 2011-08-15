<?php  // $Id: paymph.php,v 1.1 2011/07/19 15:02:00 alanbarrett Exp $
/**
*
* Pay for MMU MPH
*
*/

$test = true;
$test = false;


require("../config.php");

print_header('Payment for MMU MPH');

print_simple_box_start("center");

if ($test) {
	$payurl = 'https://select-test.worldpay.com/wcc/purchase';
}
else {
	$payurl = 'https://select.worldpay.com/wcc/purchase';
}

echo '<div align="center">';

echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';
echo '<p>(Our legal registration details: <a href="http://www.peoples-uni.org/content/details-registration-peoples-open-access-education-initiative" target="_blank">http://www.peoples-uni.org/content/details-registration-peoples-open-access-education-initiative</a>)</p><br />';

echo '<p><b>You should only pay if you have been notified that you have been accepted on the Manchester Metropolitan University Master of Public Health programme.</b></p>';

echo '<p><b>Enter the amount 1500 UK Pounds (or instalment amount if this has been agreed) if you wish to pay for the MMU MPH course, enter your contact information and then click the button below to make your payment with RBS WorldPay.</b></p>';

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

<form action="<?php echo $payurl; ?>" method="post" onSubmit="return verify()" name="donateform">
<input type="hidden" name="instId" value="232634" />
<input type="hidden" name="cartId" value="MMU MPH <?php echo $donatetime; ?>" />
<input type="hidden" name="currency" value="GBP" />

<strong>Amount you wish to Pay (in UK Pounds):&nbsp;</strong><input type="text" size="10" name="amount" /><br /><br />
<input type="hidden" name="desc" value="MMU MPH Course Payment <?php echo $donatetime; ?>" />

<?php
if ($test) {
?>
<input type="hidden" name="testMode" value="100" />
<?php
}
?>
<table border="2" cellpadding="2">
<tr>
<td>Your name:</td><td><input type="text" size="75" name="name" /></td>
</tr>
<tr>
<td>Your e-mail:</td><td><input type="text" size="75" name="email" /></td>
</tr>
<tr>
<td>Your address:</td><td><input type="text" size="75" name="address" /></td>
</tr>
<tr>
<td>Your country:</td><td><select name="country"><option value="" selected="selected">select...</option><option value="AF">Afghanistan</option><option value="AX">Åland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua And Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia And Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei Darussalam</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CD">Congo, The Democratic Republic Of The</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="CI">Côte D&#039;Ivoire</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands (Malvinas)</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island And Mcdonald Islands</option><option value="VA">Holy See (Vatican City State)</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran, Islamic Republic Of</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle Of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KP">Korea, Democratic People&#039;s Republic Of</option><option value="KR">Korea, Republic Of</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Lao People&#039;s Democratic Republic</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libyan Arab Jamahiriya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MK">Macedonia, The Former Yugoslav Republic Of</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia, Federated States Of</option><option value="MD">Moldova, Republic Of</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestinian Territory, Occupied</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Réunion</option><option value="RO">Romania</option><option value="RU">Russian Federation</option><option value="RW">Rwanda</option><option value="BL">Saint Barthélemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts And Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre And Miquelon</option><option value="VC">Saint Vincent And The Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome And Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia And The South Sandwich Islands</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard And Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syrian Arab Republic</option><option value="TW">Taiwan, Province Of China</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania, United Republic Of</option><option value="TH">Thailand</option><option value="TL">Timor-Leste</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad And Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks And Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VE">Venezuela</option><option value="VN">Viet Nam</option><option value="VG">Virgin Islands, British</option><option value="VI">Virgin Islands, U.S.</option><option value="WF">Wallis And Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select></td>
</tr>
</table>
<br />
<input type="hidden" name="M_mph" value="<?php echo $donatetime; ?>" />
<input type="submit" value="Click this to go to the RBS WorldPay website to securely make your payment" />

</form>
<br /><br />


<img src=https://www.worldpay.com/cgenerator/logos/visa.gif border=0 alt="Visa Credit payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/visa_debit.gif border=0 alt="Visa Debit payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/visa_electron.gif border=0 alt="Visa Electron payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/mastercard.gif border=0 alt="Mastercard payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/maestro.gif border=0 alt="Maestro payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/jcb.gif border=0 alt="JCB">
<img src=https://www.worldpay.com/cgenerator/logos/solo.gif border=0 alt="Solo payments supported by RBS WorldPay">
<a href=http://www.worldpay.com/index.php?CMP=BA2713><img src=https://www.worldpay.com/cgenerator/logos/poweredByWorldPay.gif border=0 alt="Powered By RBS WorldPay"></a>

</div>

<?php

print_simple_box_end();
print_footer();
?>
