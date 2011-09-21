<?php  // $Id: pay.php,v 1.1 2009/02/28 16:42:25 alanbarrett Exp $
/**
*
* Make a payment to WorldPay
*
*/

$test = true;
$test = false;


$countryname['AF'] = 'Afghanistan';
$countryname['AX'] = 'Åland Islands';
$countryname['AL'] = 'Albania';
$countryname['DZ'] = 'Algeria';
$countryname['AS'] = 'American Samoa';
$countryname['AD'] = 'Andorra';
$countryname['AO'] = 'Angola';
$countryname['AI'] = 'Anguilla';
$countryname['AQ'] = 'Antarctica';
$countryname['AG'] = 'Antigua And Barbuda';
$countryname['AR'] = 'Argentina';
$countryname['AM'] = 'Armenia';
$countryname['AW'] = 'Aruba';
$countryname['AU'] = 'Australia';
$countryname['AT'] = 'Austria';
$countryname['AZ'] = 'Azerbaijan';
$countryname['BS'] = 'Bahamas';
$countryname['BH'] = 'Bahrain';
$countryname['BD'] = 'Bangladesh';
$countryname['BB'] = 'Barbados';
$countryname['BY'] = 'Belarus';
$countryname['BE'] = 'Belgium';
$countryname['BZ'] = 'Belize';
$countryname['BJ'] = 'Benin';
$countryname['BM'] = 'Bermuda';
$countryname['BT'] = 'Bhutan';
$countryname['BO'] = 'Bolivia';
$countryname['BA'] = 'Bosnia And Herzegovina';
$countryname['BW'] = 'Botswana';
$countryname['BV'] = 'Bouvet Island';
$countryname['BR'] = 'Brazil';
$countryname['IO'] = 'British Indian Ocean Territory';
$countryname['BN'] = 'Brunei Darussalam';
$countryname['BG'] = 'Bulgaria';
$countryname['BF'] = 'Burkina Faso';
$countryname['BI'] = 'Burundi';
$countryname['KH'] = 'Cambodia';
$countryname['CM'] = 'Cameroon';
$countryname['CA'] = 'Canada';
$countryname['CV'] = 'Cape Verde';
$countryname['KY'] = 'Cayman Islands';
$countryname['CF'] = 'Central African Republic';
$countryname['TD'] = 'Chad';
$countryname['CL'] = 'Chile';
$countryname['CN'] = 'China';
$countryname['CX'] = 'Christmas Island';
$countryname['CC'] = 'Cocos (Keeling) Islands';
$countryname['CO'] = 'Colombia';
$countryname['KM'] = 'Comoros';
$countryname['CG'] = 'Congo';
$countryname['CD'] = 'Congo, The Democratic Republic Of The';
$countryname['CK'] = 'Cook Islands';
$countryname['CR'] = 'Costa Rica';
$countryname['CI'] = 'Côte D\'Ivoire';
$countryname['HR'] = 'Croatia';
$countryname['CU'] = 'Cuba';
$countryname['CY'] = 'Cyprus';
$countryname['CZ'] = 'Czech Republic';
$countryname['DK'] = 'Denmark';
$countryname['DJ'] = 'Djibouti';
$countryname['DM'] = 'Dominica';
$countryname['DO'] = 'Dominican Republic';
$countryname['EC'] = 'Ecuador';
$countryname['EG'] = 'Egypt';
$countryname['SV'] = 'El Salvador';
$countryname['GQ'] = 'Equatorial Guinea';
$countryname['ER'] = 'Eritrea';
$countryname['EE'] = 'Estonia';
$countryname['ET'] = 'Ethiopia';
$countryname['FK'] = 'Falkland Islands (Malvinas)';
$countryname['FO'] = 'Faroe Islands';
$countryname['FJ'] = 'Fiji';
$countryname['FI'] = 'Finland';
$countryname['FR'] = 'France';
$countryname['GF'] = 'French Guiana';
$countryname['PF'] = 'French Polynesia';
$countryname['TF'] = 'French Southern Territories';
$countryname['GA'] = 'Gabon';
$countryname['GM'] = 'Gambia';
$countryname['GE'] = 'Georgia';
$countryname['DE'] = 'Germany';
$countryname['GH'] = 'Ghana';
$countryname['GI'] = 'Gibraltar';
$countryname['GR'] = 'Greece';
$countryname['GL'] = 'Greenland';
$countryname['GD'] = 'Grenada';
$countryname['GP'] = 'Guadeloupe';
$countryname['GU'] = 'Guam';
$countryname['GT'] = 'Guatemala';
$countryname['GG'] = 'Guernsey';
$countryname['GN'] = 'Guinea';
$countryname['GW'] = 'Guinea-Bissau';
$countryname['GY'] = 'Guyana';
$countryname['HT'] = 'Haiti';
$countryname['HM'] = 'Heard Island And Mcdonald Islands';
$countryname['VA'] = 'Holy See (Vatican City State)';
$countryname['HN'] = 'Honduras';
$countryname['HK'] = 'Hong Kong';
$countryname['HU'] = 'Hungary';
$countryname['IS'] = 'Iceland';
$countryname['IN'] = 'India';
$countryname['ID'] = 'Indonesia';
$countryname['IR'] = 'Iran, Islamic Republic Of';
$countryname['IQ'] = 'Iraq';
$countryname['IE'] = 'Ireland';
$countryname['IM'] = 'Isle Of Man';
$countryname['IL'] = 'Israel';
$countryname['IT'] = 'Italy';
$countryname['JM'] = 'Jamaica';
$countryname['JP'] = 'Japan';
$countryname['JE'] = 'Jersey';
$countryname['JO'] = 'Jordan';
$countryname['KZ'] = 'Kazakhstan';
$countryname['KE'] = 'Kenya';
$countryname['KI'] = 'Kiribati';
$countryname['KP'] = 'Korea, Democratic People\'s Republic Of';
$countryname['KR'] = 'Korea, Republic Of';
$countryname['KW'] = 'Kuwait';
$countryname['KG'] = 'Kyrgyzstan';
$countryname['LA'] = 'Lao People\'s Democratic Republic';
$countryname['LV'] = 'Latvia';
$countryname['LB'] = 'Lebanon';
$countryname['LS'] = 'Lesotho';
$countryname['LR'] = 'Liberia';
$countryname['LY'] = 'Libyan Arab Jamahiriya';
$countryname['LI'] = 'Liechtenstein';
$countryname['LT'] = 'Lithuania';
$countryname['LU'] = 'Luxembourg';
$countryname['MO'] = 'Macao';
$countryname['MK'] = 'Macedonia, The Former Yugoslav Republic Of';
$countryname['MG'] = 'Madagascar';
$countryname['MW'] = 'Malawi';
$countryname['MY'] = 'Malaysia';
$countryname['MV'] = 'Maldives';
$countryname['ML'] = 'Mali';
$countryname['MT'] = 'Malta';
$countryname['MH'] = 'Marshall Islands';
$countryname['MQ'] = 'Martinique';
$countryname['MR'] = 'Mauritania';
$countryname['MU'] = 'Mauritius';
$countryname['YT'] = 'Mayotte';
$countryname['MX'] = 'Mexico';
$countryname['FM'] = 'Micronesia, Federated States Of';
$countryname['MD'] = 'Moldova, Republic Of';
$countryname['MC'] = 'Monaco';
$countryname['MN'] = 'Mongolia';
$countryname['ME'] = 'Montenegro';
$countryname['MS'] = 'Montserrat';
$countryname['MA'] = 'Morocco';
$countryname['MZ'] = 'Mozambique';
$countryname['MM'] = 'Myanmar';
$countryname['NA'] = 'Namibia';
$countryname['NR'] = 'Nauru';
$countryname['NP'] = 'Nepal';
$countryname['NL'] = 'Netherlands';
$countryname['AN'] = 'Netherlands Antilles';
$countryname['NC'] = 'New Caledonia';
$countryname['NZ'] = 'New Zealand';
$countryname['NI'] = 'Nicaragua';
$countryname['NE'] = 'Niger';
$countryname['NG'] = 'Nigeria';
$countryname['NU'] = 'Niue';
$countryname['NF'] = 'Norfolk Island';
$countryname['MP'] = 'Northern Mariana Islands';
$countryname['NO'] = 'Norway';
$countryname['OM'] = 'Oman';
$countryname['PK'] = 'Pakistan';
$countryname['PW'] = 'Palau';
$countryname['PS'] = 'Palestinian Territory, Occupied';
$countryname['PA'] = 'Panama';
$countryname['PG'] = 'Papua New Guinea';
$countryname['PY'] = 'Paraguay';
$countryname['PE'] = 'Peru';
$countryname['PH'] = 'Philippines';
$countryname['PN'] = 'Pitcairn';
$countryname['PL'] = 'Poland';
$countryname['PT'] = 'Portugal';
$countryname['PR'] = 'Puerto Rico';
$countryname['QA'] = 'Qatar';
$countryname['RE'] = 'Réunion';
$countryname['RO'] = 'Romania';
$countryname['RU'] = 'Russian Federation';
$countryname['RW'] = 'Rwanda';
$countryname['BL'] = 'Saint Barthélemy';
$countryname['SH'] = 'Saint Helena';
$countryname['KN'] = 'Saint Kitts And Nevis';
$countryname['LC'] = 'Saint Lucia';
$countryname['MF'] = 'Saint Martin';
$countryname['PM'] = 'Saint Pierre And Miquelon';
$countryname['VC'] = 'Saint Vincent And The Grenadines';
$countryname['WS'] = 'Samoa';
$countryname['SM'] = 'San Marino';
$countryname['ST'] = 'Sao Tome And Principe';
$countryname['SA'] = 'Saudi Arabia';
$countryname['SN'] = 'Senegal';
$countryname['RS'] = 'Serbia';
$countryname['SC'] = 'Seychelles';
$countryname['SL'] = 'Sierra Leone';
$countryname['SG'] = 'Singapore';
$countryname['SK'] = 'Slovakia';
$countryname['SI'] = 'Slovenia';
$countryname['SB'] = 'Solomon Islands';
$countryname['SO'] = 'Somalia';
$countryname['ZA'] = 'South Africa';
$countryname['GS'] = 'South Georgia And The South Sandwich Islands';
$countryname['ES'] = 'Spain';
$countryname['LK'] = 'Sri Lanka';
$countryname['SD'] = 'Sudan';
$countryname['SR'] = 'Suriname';
$countryname['SJ'] = 'Svalbard And Jan Mayen';
$countryname['SZ'] = 'Swaziland';
$countryname['SE'] = 'Sweden';
$countryname['CH'] = 'Switzerland';
$countryname['SY'] = 'Syrian Arab Republic';
$countryname['TW'] = 'Taiwan, Province Of China';
$countryname['TJ'] = 'Tajikistan';
$countryname['TZ'] = 'Tanzania, United Republic Of';
$countryname['TH'] = 'Thailand';
$countryname['TL'] = 'Timor-Leste';
$countryname['TG'] = 'Togo';
$countryname['TK'] = 'Tokelau';
$countryname['TO'] = 'Tonga';
$countryname['TT'] = 'Trinidad And Tobago';
$countryname['TN'] = 'Tunisia';
$countryname['TR'] = 'Turkey';
$countryname['TM'] = 'Turkmenistan';
$countryname['TC'] = 'Turks And Caicos Islands';
$countryname['TV'] = 'Tuvalu';
$countryname['UG'] = 'Uganda';
$countryname['UA'] = 'Ukraine';
$countryname['AE'] = 'United Arab Emirates';
$countryname['GB'] = 'United Kingdom';
$countryname['US'] = 'United States';
$countryname['UM'] = 'United States Minor Outlying Islands';
$countryname['UY'] = 'Uruguay';
$countryname['UZ'] = 'Uzbekistan';
$countryname['VU'] = 'Vanuatu';
$countryname['VE'] = 'Venezuela';
$countryname['VN'] = 'Viet Nam';
$countryname['VG'] = 'Virgin Islands, British';
$countryname['VI'] = 'Virgin Islands, U.S.';
$countryname['WF'] = 'Wallis And Futuna';
$countryname['EH'] = 'Western Sahara';
$countryname['YE'] = 'Yemen';
$countryname['ZM'] = 'Zambia';
$countryname['ZW'] = 'Zimbabwe';


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

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

$amount = $application->costowed - $application->costpaid;
if ($amount < .01) {
	notice('Error: There is zero owed for this application to Peoples-uni! Payment cannot be completed.', "$CFG->wwwroot");
}
$currency = $application->currency;

$updated = new object();
$updated->id = $application->id;
$updated->dateattemptedtopay = time();
$DB->update_record('peoplesapplication', $updated);


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

echo "<p><br /><br /><b>Cost for your chosen modules (UK Pounds Sterling):&nbsp;&nbsp;&nbsp;$amount $currency</b></p>";
// echo '<p><img alt="WorldPay" src="https://www.paypal.com/en_US/i/logo/PayPal_mark_60x38.gif" /></p>';
echo "<p>Use the button below to pay for your enrolment in $modulespurchasedlong with RBS WorldPay.<br />
(Or to pay for Manchester Metropolitan University Master of Public Health programme.)</p>";
echo '<p>(note our refund policy: <a href="http://www.peoples-uni.org/content/refund-policy" target="_blank">http://www.peoples-uni.org/content/refund-policy</a>)</p>';
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
Name on Credit Card: <input type="text" size="30" name="name" /><br />
<?php
}
else {
?>
Name on Credit Card: <input type="text" size="30" name="name" /><br />
<?php
}
?>

Your e-mail: <input type="text" size="30" name="email" /><br />
Your Address (matching Credit Card): <input type="text" size="30" name="address" /><br />
Your Country (matching Credit Card): <select name="country">
<?php
foreach ($countryname as $key => $countryvalue) {
?>
<option value="<?php echo $key . '"'; ?> ><?php echo $countryvalue; ?></option>
<?php
}
?>
</select><br /><br />

<input type="hidden" name="M_sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="M_dateattemptedtopay" value="<?php echo $updated->dateattemptedtopay; ?>" />

<?php
// resultFile: The name of one of your uploaded files, which will be used to format the result.
// Please refer to Configuring Your Installation.
// If this is not specified, resultY.html or resultC.html are used as described in Payment Result - to You.
// accId<n>: specifies which merchant code should receive funds for this payment. By default our server tries accId1.
?>

<input type="submit" value="Click this to go to the RBS WorldPay website to securely pay <?php echo "$amount $currency"; ?>" />

</form>
<br /><br />

<?php
//<script language="JavaScript" src="https://select.worldpay.com/wcc/logo?instId=XXXXX"></script>
?>

<img src=https://www.worldpay.com/cgenerator/logos/visa.gif border=0 alt="Visa Credit payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/visa_debit.gif border=0 alt="Visa Debit payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/visa_electron.gif border=0 alt="Visa Electron payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/mastercard.gif border=0 alt="Mastercard payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/maestro.gif border=0 alt="Maestro payments supported by RBS WorldPay">
<?php if (false) { ?>
<img src=https://www.worldpay.com/cgenerator/logos/amex.gif border=0 alt="American Express payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/diners.gif border=0 alt="Diners payments supported by RBS WorldPay">
<?php } ?>
<img src=https://www.worldpay.com/cgenerator/logos/jcb.gif border=0 alt="JCB">
<img src=https://www.worldpay.com/cgenerator/logos/solo.gif border=0 alt="Solo payments supported by RBS WorldPay">
<?php if (false) { ?>
<img src=https://www.worldpay.com/cgenerator/logos/laser.gif border=0 alt="Laser payments supported by RBS WorldPay">
<img src=https://www.worldpay.com/cgenerator/logos/ELV.gif border=0 alt="ELV payments supported by RBS WorldPay">
<?php } ?>
<?php if (true) { ?>
<a href=http://www.worldpay.com/index.php?CMP=BA2713><img src=https://www.worldpay.com/cgenerator/logos/poweredByWorldPay.gif border=0 alt="Powered By RBS WorldPay"></a>
<?php } ?>
<?php if (false) { ?>
// Security Certificate Errors...
<a href=http://www.worldpay.com/index.php?CMP=BA2713><img src=https://www.rbsworldpay.com/images/cardlogos/poweredByRBSWorldPay.gif border=0 alt="Powered By RBS WorldPay"></a>
<?php } ?>

</div>

<?php

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
?>
