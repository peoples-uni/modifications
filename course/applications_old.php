<?php  // $Id: applications.php,v 1.1 2008/08/02 17:18:32 alanbarrett Exp $
/**
*
* List all course applications from Drupal
*
*/

/*
CREATE TABLE mdl_peoplesapplication (
	id BIGINT(10) unsigned NOT NULL auto_increment,
	datesubmitted BIGINT(10) unsigned NOT NULL DEFAULT 0,
	sid BIGINT(10) unsigned NOT NULL,
	nid BIGINT(10) unsigned NOT NULL,
  state BIGINT(10) unsigned NOT NULL,
  state_1 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  state_2 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  state_3 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  state_4 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
	userid BIGINT(10) unsigned NOT NULL DEFAULT 0,
	username VARCHAR(100) NOT NULL DEFAULT '',
	firstname VARCHAR(100) NOT NULL DEFAULT '',
	lastname VARCHAR(100) NOT NULL DEFAULT '',
	email VARCHAR(100) NOT NULL DEFAULT '',
	city VARCHAR(20) NOT NULL DEFAULT '',
	country VARCHAR(2) NOT NULL DEFAULT '',
	qualification BIGINT(10) unsigned NOT NULL DEFAULT 0,
	higherqualification BIGINT(10) unsigned NOT NULL DEFAULT 0,
	employment BIGINT(10) unsigned NOT NULL DEFAULT 0,
  course_id_1 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  course_id_2 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  course_id_3 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  course_id_4 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  coursename1 VARCHAR(255) NOT NULL DEFAULT '',
  coursename2 VARCHAR(255) NOT NULL DEFAULT '',
  coursename3 VARCHAR(255) NOT NULL DEFAULT '',
  coursename4 VARCHAR(255) NOT NULL DEFAULT '',
  semester VARCHAR(255) NOT NULL DEFAULT '',
  dob VARCHAR(20) NOT NULL DEFAULT '',
	dobday VARCHAR(2) NOT NULL DEFAULT '',
	dobmonth VARCHAR(2) NOT NULL DEFAULT '',
	dobyear VARCHAR(4) NOT NULL DEFAULT '',
	gender VARCHAR(6) NOT NULL DEFAULT '',
	applicationaddress text NOT NULL,
	currentjob text NOT NULL,
	education text NOT NULL,
	reasons text NOT NULL,
	methodofpayment VARCHAR(255) NOT NULL DEFAULT '',
	paymentidentification VARCHAR(255) NOT NULL DEFAULT '',
	costowed VARCHAR(10) NOT NULL DEFAULT '0',
	costpaid VARCHAR(10) NOT NULL DEFAULT '0',
	paymentmechanism BIGINT(10) unsigned NOT NULL DEFAULT 0,
	currency VARCHAR(3) NOT NULL DEFAULT 'USD',
	datefirstapproved BIGINT(10) unsigned NOT NULL DEFAULT 0,
	datelastapproved BIGINT(10) unsigned NOT NULL DEFAULT 0,
	dateattemptedtopay BIGINT(10) unsigned NOT NULL DEFAULT 0,
	datepaid BIGINT(10) unsigned NOT NULL DEFAULT 0,
	datafromworldpay VARCHAR(255) NOT NULL DEFAULT '',
	hidden TINYINT(2) unsigned NOT NULL DEFAULT 0,
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplesapplication_sid_ix ON mdl_peoplesapplication (sid);
CREATE INDEX mdl_peoplesapplication_uid_ix ON mdl_peoplesapplication (userid);

((ALTER TABLE mdl_peoplesapplication ADD hidden TINYINT(2) unsigned NOT NULL DEFAULT 0;
  ALTER TABLE mdl_peoplesapplication ADD paymentmechanism BIGINT(10) unsigned NOT NULL DEFAULT 0;

For possible future use only...
ALTER TABLE mdl_peoplesapplication ADD state_1 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state;
ALTER TABLE mdl_peoplesapplication ADD state_2 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state_1;
ALTER TABLE mdl_peoplesapplication ADD state_3 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state_2;
ALTER TABLE mdl_peoplesapplication ADD state_4 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state_3;

Will be used to support new Webform...
ALTER TABLE mdl_peoplesapplication ADD course_id_1 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER employment;
ALTER TABLE mdl_peoplesapplication ADD course_id_2 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER course_id_1;

For possible future use only...
ALTER TABLE mdl_peoplesapplication ADD course_id_3 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER course_id_2;
ALTER TABLE mdl_peoplesapplication ADD course_id_4 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER course_id_3;

For possible future use only...
ALTER TABLE mdl_peoplesapplication ADD coursename3 VARCHAR(255) NOT NULL DEFAULT '' AFTER coursename2;
ALTER TABLE mdl_peoplesapplication ADD coursename4 VARCHAR(255) NOT NULL DEFAULT '' AFTER coursename3;

Will be used to support new Webform...
ALTER TABLE mdl_peoplesapplication ADD dob VARCHAR(20) NOT NULL DEFAULT '' AFTER semester;
))
*/

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

$qualificationname[ '1'] = 'None';
$qualificationname['10'] = 'Degree (not health related)';
$qualificationname['20'] = 'Health qualification (non-degree)';
$qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
$qualificationname['40'] = 'Medical degree';

$higherqualificationname[ '1'] = 'None';
$higherqualificationname['10'] = 'Certificate';
$higherqualificationname['20'] = 'Diploma';
$higherqualificationname['30'] = 'Masters';
$higherqualificationname['40'] = 'Ph.D.';
$higherqualificationname['50'] = 'Other';

$employmentname[ '1'] = 'None';
$employmentname['10'] = 'Student';
$employmentname['20'] = 'Non-health';
$employmentname['30'] = 'Clinical (not specifically public health)';
$employmentname['40'] = 'Public health';
$employmentname['50'] = 'Other health related';
$employmentname['60'] = 'Academic occupation (e.g. lecturer)';


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

if (!empty($_POST['markfilter'])) {
	redirect($CFG->wwwroot . '/course/applications.php?'
		. 'chosensemester=' . urlencode(stripslashes($_POST['chosensemester']))
		. '&chosenstatus=' . urlencode($_POST['chosenstatus'])
		. '&chosenstartyear=' . $_POST['chosenstartyear']
		. '&chosenstartmonth=' . $_POST['chosenstartmonth']
		. '&chosenstartday=' . $_POST['chosenstartday']
		. '&chosenendyear=' . $_POST['chosenendyear']
		. '&chosenendmonth=' . $_POST['chosenendmonth']
		. '&chosenendday=' . $_POST['chosenendday']
		. '&chosensearch=' . urlencode(stripslashes($_POST['chosensearch']))
		. '&chosenpay=' . urlencode($_POST['chosenpay'])
		. (empty($_POST['displayextra']) ? '&displayextra=0' : '&displayextra=1')
		);
}
elseif (!empty($_POST['markemailsend']) && !empty($_POST['emailsubject']) && !empty($_POST['emailbody'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $sendemails = true;
}
else {
  $sendemails = false;
}


require_login();

// Access to applications.php is given by the "Manage Applications" role
// which is based on authenticated user with moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

print_header('Student Applications');

$time1 = time();

$rows = get_recordset_sql('SELECT s.*, sd.cid, sd.no, sd.data FROM d5_webform_submitted_data AS sd LEFT JOIN d5_webform_submissions AS s ON sd.sid=s.sid WHERE s.nid=71 OR s.nid=80 ORDER BY s.submitted DESC', '', '');

$time2 = time();

while (!empty($rows) && !$rows->EOF) {

	$row = $rows->fields;
	// echo var_dump($row) . '<br />';

	$registrations[$row['sid']]['submitted'] = $row['submitted'];
	$registrations[$row['sid']]['nid'] = $row['nid'];

	if ($row['cid']==='17' && $row['no']==='0' && $row['nid']==='71') {
		$dobmonth[$row['sid']] = $row['data'];
	}
	elseif ($row['cid']==='17' && $row['no']==='1') {
		$dobday[$row['sid']] = $row['data'];
	}
	elseif ($row['cid']==='17' && $row['no']==='2') {
		$dobyear[$row['sid']] = $row['data'];
	}
	else {
		$registrations[$row['sid']][$row['cid']] = $row['data'];
	}

	$rows->MoveNext();
}

$time3 = time();

if (empty($registrations)) {
	$registrations = array();
}


echo "<h1>Student Applications</h1>";

if (!empty($_REQUEST['chosensemester'])) $chosensemester = stripslashes($_REQUEST['chosensemester']);
if (!empty($_REQUEST['chosenstatus'])) $chosenstatus = $_REQUEST['chosenstatus'];
if (!empty($_REQUEST['chosenstartyear']) && !empty($_REQUEST['chosenstartmonth']) && !empty($_REQUEST['chosenstartday'])) {
	$chosenstartyear = (int)$_REQUEST['chosenstartyear'];
	$chosenstartmonth = (int)$_REQUEST['chosenstartmonth'];
	$chosenstartday = (int)$_REQUEST['chosenstartday'];
	$starttime = gmmktime(0, 0, 0, $chosenstartmonth, $chosenstartday, $chosenstartyear);
	//echo gmdate('d/m/Y H:i', $starttime) . '<br />';
}
else {
	$starttime = 0;
}
if (!empty($_REQUEST['chosenendyear']) && !empty($_REQUEST['chosenendmonth']) && !empty($_REQUEST['chosenendday'])) {
	$chosenendyear = (int)$_REQUEST['chosenendyear'];
	$chosenendmonth = (int)$_REQUEST['chosenendmonth'];
	$chosenendday = (int)$_REQUEST['chosenendday'];
	$endtime = gmmktime(24, 0, 0, $chosenendmonth, $chosenendday, $chosenendyear);
	//echo gmdate('d/m/Y H:i', $endtime) . '<br />';
}
else {
	$endtime = 1.0E+20;
}
if (!empty($_REQUEST['chosensearch'])) $chosensearch = stripslashes($_REQUEST['chosensearch']);
else $chosensearch = '';
if (!empty($_REQUEST['chosenpay'])) $chosenpay = $_REQUEST['chosenpay'];
if (!empty($_REQUEST['displayextra'])) $displayextra = true;
else $displayextra = false;

$semesters = get_records('semesters', '', '', 'id DESC');
foreach ($semesters as $semester) {
	$listsemester[] = $semester->semester;
	if (!isset($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

$liststatus[] = 'All';
if (!isset($chosenstatus)) $chosenstatus = 'All';
$liststatus[] = 'Not fully Approved';
$liststatus[] = 'Not fully Registered';
$liststatus[] = 'Part or Fully Approved';
$liststatus[] = 'Part or Fully Registered';

$listchosenpay[] = 'Any';
if (!isset($chosenpay)) $chosenpay = 'Any';
$listchosenpay[] = 'No Indication Given';
$listchosenpay[] = 'Not Confirmed (all)';
$listchosenpay[] = 'Barclays not confirmed';
$listchosenpay[] = 'Diamond not confirmed';
$listchosenpay[] = 'Western Union not confirmed';
$listchosenpay[] = 'Indian Confederation not confirmed';
$listchosenpay[] = 'Posted Travellers Cheques not confirmed';
$listchosenpay[] = 'Posted Cash not confirmed';
$listchosenpay[] = 'Promised End Semester';
$listchosenpay[] = 'Waiver';
$listchosenpay[] = 'RBS Confirmed';
$listchosenpay[] = 'Barclays Confirmed';
$listchosenpay[] = 'Diamond Confirmed';
$listchosenpay[] = 'Western Union Confirmed';
$listchosenpay[] = 'Indian Confederation Confirmed';
$listchosenpay[] = 'Posted Travellers Cheques Confirmed';
$listchosenpay[] = 'Posted Cash Confirmed';

for ($i = 2008; $i <= (int)gmdate('Y'); $i++) {
	if (!isset($chosenstartyear)) $chosenstartyear = $i;
	$liststartyear[] = $i;
}

for ($i = 1; $i <= 12; $i++) {
	if (!isset($chosenstartmonth)) $chosenstartmonth = $i;
	$liststartmonth[] = $i;
}

for ($i = 1; $i <= 31; $i++) {
	if (!isset($chosenstartday)) $chosenstartday = $i;
	$liststartday[] = $i;
}

for ($i = (int)gmdate('Y'); $i >= 2008; $i--) {
	if (!isset($chosenendyear)) $chosenendyear = $i;
	$listendyear[] = $i;
}

for ($i = 12; $i >= 1; $i--) {
	if (!isset($chosenendmonth)) $chosenendmonth = $i;
	$listendmonth[] = $i;
}

for ($i = 31; $i >= 1; $i--) {
	if (!isset($chosenendday)) $chosenendday = $i;
	$listendday[] = $i;
}

?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/applications.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
	<tr>
		<td>Semester</td>
		<td>Status</td>
		<td>Start Year</td>
		<td>Start Month</td>
		<td>Start Day</td>
		<td>End Year</td>
		<td>End Month</td>
		<td>End Day</td>
		<td>Name or e-mail Contains</td>
		<td>"Paid?" Value</td>
		<td>Show Extra Details</td>
	</tr>
	<tr>
		<?php
		displayoptions('chosensemester', $listsemester, $chosensemester);
		displayoptions('chosenstatus', $liststatus, $chosenstatus);
		displayoptions('chosenstartyear', $liststartyear, $chosenstartyear);
		displayoptions('chosenstartmonth', $liststartmonth, $chosenstartmonth);
		displayoptions('chosenstartday', $liststartday, $chosenstartday);
		displayoptions('chosenendyear', $listendyear, $chosenendyear);
		displayoptions('chosenendmonth', $listendmonth, $chosenendmonth);
		displayoptions('chosenendday', $listendday, $chosenendday);
		?>
		<td><input type="text" size="40" name="chosensearch" value="<?php echo htmlspecialchars($chosensearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
		<?php
		displayoptions('chosenpay', $listchosenpay, $chosenpay);
		?>
		<td><input type="checkbox" name="displayextra" <?php if ($displayextra) echo ' CHECKED'; ?>></td>
	</tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/applications.php">Reset Filters</a>
</form>
<br />
<?php


function displayoptions($name, $options, $selectedvalue) {
	echo '<td><select name="' . $name . '">';
	foreach ($options as $option) {
		if ($option === $selectedvalue) $selected = 'selected="selected"';
		else $selected = '';

		$opt = htmlspecialchars($option, ENT_COMPAT, 'UTF-8');
		echo '<option value="' . $opt . '" ' . $selected . '>' . $opt . '</option>';
	}
	echo '</select></td>';
}


foreach ($registrations as $sid => $registration) {
	if ($registration['nid'] == 80) {
		// Fixup for different numbering in second form (note that e-mail is the same!)
		$registrations[$sid]['30'] = $registration['13'];
		$registrations[$sid]['29'] = $registration['10'];
		$registrations[$sid]['16'] = $registration['2'];
		$registrations[$sid]['18'] = $registration['3'];

		if (empty($registration['4'])) $registrations[$sid]['19'] = '';
		else $registrations[$sid]['19'] = $registration['4'];

		$registrations[$sid]['31'] = $registration['6'];

		if (empty($registration['7'])) $registrations[$sid]['32'] = '';
		else $registrations[$sid]['32'] = $registration['7'];

		$registrations[$sid]['32'] = $registration['7'];
		$registrations[$sid]['21'] = $registration['8'];

		if (empty($registration['14'])) $registrations[$sid]['1'] = '';
		else $registrations[$sid]['1'] = $registration['14'];
		if (empty($registration['15'])) $registrations[$sid]['2'] = '';
		else $registrations[$sid]['2'] = $registration['15'];

		if (empty($registration['16']) || empty($registration['17']) || empty($registration['18'])) {
			$dobmonth[$sid] = '';
			$dobday[$sid] = '';
			$dobyear[$sid] = '';
		}
		else {
			$dobmonth[$sid] = $registration['16'];
			$dobday[$sid] = $registration['17'];
			$dobyear[$sid] = $registration['18'];
		}

		if (empty($registration['19'])) $registrations[$sid]['12'] = '';
		else $registrations[$sid]['12'] = $registration['19'];
		if (empty($registration['20'])) $registrations[$sid]['3'] = '';
		else $registrations[$sid]['3'] = $registration['20'];
		if (empty($registration['21'])) $registrations[$sid]['14'] = '';
		else $registrations[$sid]['14'] = $registration['21'];
		if (empty($registration['22'])) $registrations[$sid]['13'] = '';
		else $registrations[$sid]['13'] = $registration['22'];
		if (empty($registration['26'])) $registrations[$sid]['34'] = '';
		else $registrations[$sid]['34'] = $registration['26'];
		if (empty($registration['27'])) $registrations[$sid]['35'] = '';
		else $registrations[$sid]['35'] = $registration['27'];
		if (empty($registration['28'])) $registrations[$sid]['36'] = '';
		else $registrations[$sid]['36'] = $registration['28'];
		if (empty($registration['23'])) $registrations[$sid]['7'] = '';
		else $registrations[$sid]['7'] = $registration['23'];
		if (empty($registration['24'])) $registrations[$sid]['8'] = '';
		else $registrations[$sid]['8'] = $registration['24'];
		if (empty($registration['25'])) $registrations[$sid]['10'] = '';
		else $registrations[$sid]['10'] = $registration['25'];
	}
}


// Find and insert all missing peoplesapplication database rows
$applications = get_records_sql('SELECT s.sid FROM d5_webform_submissions AS s LEFT JOIN mdl_peoplesapplication AS p ON s.sid=p.sid WHERE (s.nid=71 OR s.nid=80) AND p.id IS NULL');
foreach ($applications as $sid => $application) {
	insertapplication($sid, $registrations[$sid], $dobmonth[$sid], $dobday[$sid], $dobyear[$sid]);
}

// Retrieve all relevent rows
$applications = get_records_sql('SELECT a.sid AS appsid, a.* FROM mdl_peoplesapplication AS a WHERE hidden=0 ORDER BY datesubmitted DESC');
if (empty($applications)) {
	$applications = array();
}


$emaildups = 0;
foreach ($registrations as $sid => $registration) {
	if (empty($registration['30'])) $state = 0;
	else $state = (int)$registration['30'];
	if ($state === 1) $state = 011;

	if (
    $registration['submitted'] < $starttime ||
		$registration['submitted'] > $endtime ||
		(($chosensemester !== 'All') && ($registration['16'] !== $chosensemester)) ||
    (($chosenstatus  === 'Not fully Approved')       && ($state === 011 || $state === 033)) ||
    (($chosenstatus  === 'Not fully Registered')     && ($state === 033)) ||
    (($chosenstatus  === 'Part or Fully Approved')   && (!($state === 011 || $state === 012 || $state === 021 || $state === 023 || $state === 032 || $state === 013 || $state === 031 || $state === 033))) ||
    (($chosenstatus  === 'Part or Fully Registered') && (!($state === 023 || $state === 032 || $state === 013 || $state === 031 || $state === 033)))
    ) {

		unset($registrations[$sid]);
		continue;
	}

	if (!empty($chosensearch) &&
		stripos($registration['1'], $chosensearch) === false &&
		stripos($registration['2'], $chosensearch) === false &&
		stripos($registration['11'], $chosensearch) === false) {

		unset($registrations[$sid]);
		continue;
	}

	if (!empty($chosenpay) && $chosenpay !== 'Any') {
		$application = $applications[$sid];
		if ($chosenpay === 'No Indication Given' && $application->paymentmechanism != 0) {
			unset($registrations[$sid]);
			continue;
		}
		if ($chosenpay === 'Not Confirmed (all)' && ($application->paymentmechanism == 1 || $application->paymentmechanism >= 100)) {
			unset($registrations[$sid]);
			continue;
		}
		if ($chosenpay === 'Barclays not confirmed' && $application->paymentmechanism != 2) {
			unset($registrations[$sid]);
			continue;
		}
		if ($chosenpay === 'Diamond not confirmed' && $application->paymentmechanism != 3) {
			unset($registrations[$sid]);
			continue;
		}
		if ($chosenpay === 'Western Union not confirmed' && $application->paymentmechanism != 4) {
			unset($registrations[$sid]);
			continue;
		}
    if ($chosenpay === 'Indian Confederation not confirmed' && $application->paymentmechanism != 5) {
      unset($registrations[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Travellers Cheques not confirmed' && $application->paymentmechanism != 7) {
      unset($registrations[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Cash not confirmed' && $application->paymentmechanism != 8) {
      unset($registrations[$sid]);
      continue;
    }
		if ($chosenpay === 'Promised End Semester' && $application->paymentmechanism != 6) {
			unset($registrations[$sid]);
			continue;
		}
		if ($chosenpay === 'Waiver' && $application->paymentmechanism != 100) {
			unset($registrations[$sid]);
			continue;
		}
		if ($chosenpay === 'RBS Confirmed' && $application->paymentmechanism != 1) {
			unset($registrations[$sid]);
			continue;
		}
		if ($chosenpay === 'Barclays Confirmed' && $application->paymentmechanism != 102) {
			unset($registrations[$sid]);
			continue;
		}
		if ($chosenpay === 'Diamond Confirmed' && $application->paymentmechanism != 103) {
			unset($registrations[$sid]);
			continue;
		}
		if ($chosenpay === 'Western Union Confirmed' && $application->paymentmechanism != 104) {
			unset($registrations[$sid]);
			continue;
		}
    if ($chosenpay === 'Indian Confederation Confirmed' && $application->paymentmechanism != 105) {
      unset($registrations[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Travellers Cheques Confirmed' && $application->paymentmechanism != 107) {
      unset($registrations[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Cash Confirmed' && $application->paymentmechanism != 108) {
      unset($registrations[$sid]);
      continue;
    }
	}

	if (substr($registration['31'], 0, 6) === 'HIDDEN') {
		unset($registrations[$sid]);
		continue;
	}

	if (empty($registration['11'])) $registration['11'] = '';
	$registration['11'] = strip_tags($registration['11']);

	if (empty($emailcounts[$registration['11']])) $emailcounts[$registration['11']] = 1;
	else {
		$emailcounts[$registration['11']]++;
		$emaildups++;
	}
}


if ($sendemails) {
  if (empty($_POST['reg'])) $_POST['reg'] = '/^[a-zA-Z0-9_.-]/';
  sendemails($registrations, $applications, strip_tags(stripslashes($_POST['emailsubject'])), strip_tags(stripslashes($_POST['emailbody'])), stripslashes($_POST['reg']));
}


echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";

/*
state
30
moodleuserid
29
Family name
1
Given name
2
Email address
11
Semester
16
First module
18
Second module
19
DOB
***
Gender
12
Address
3
City/Town
14
Country
13
Current employment
36
Current employment details
7
qualification
34
higherqualification
35
Previous educational experience
8
Reasons for wanting to enrol
10
Method of payment
31
Payment Identification
32
Desired Moodle Username
21
*/

echo '<td>Submitted</td>';
echo '<td>sid</td>';
echo '<td>Approved?</td>';
echo '<td>Paid?</td>';
echo '<td>Registered?</td>';
if (!$displayextra) echo '<td></td>';
echo '<td>Family name</td>';
echo '<td>Given name</td>';
echo '<td>Email address</td>';
echo '<td>Semester</td>';
echo '<td>First module</td>';
echo '<td>Second module</td>';
echo '<td>DOB dd/mm/yyyy</td>';
echo '<td>Gender</td>';
echo '<td>City/Town</td>';
echo '<td>Country</td>';
//echo '<td>Method of payment</td>';
//echo '<td>Payment Identification</td>';
if ($displayextra) {
	echo "<td>Address</td>";
	echo "<td>Current employment</td>";
	echo "<td>Current employment details</td>";
	echo "<td>Qualification</td>";
	echo "<td>Postgraduate Qualification</td>";
	echo "<td>Education Details</td>";
	echo "<td>Reasons for wanting to enrol</td>";
	echo "<td>Desired Moodle Username</td>";
	echo "<td>Moodle UserID</td>";
	//echo "<td>Application SID</td>";
}
echo '<td></td>';
echo '<td></td>';
echo "</tr>";

$n = 0;
$napproved = 0;
$nregistered = 0;

$modules = array();
foreach ($registrations as $sid => $registration) {
	if (empty($registration['30'])) $registration['30'] = '0';
	$state = (int)$registration['30'];
	// Legacy fixups...
	if ($state === 2) {
		$state = 022;
	}
	if ($state === 1) {
		$state = 011;
	}
	// Allowed transitions for Module 1 state (00X0) or Module 2 state (0X00):
	// state 0 (not processed) ..> state 2 (defered) OR state 1 (approved)
	// state 2 (defered) ..> state 1 (approved)
	// state 1 (approved) ..> state 3 (registered) OR state 2 (defered)
	// state 3 (registered) ..> state 2 (defered)
	// If any state changes from 0, all must change from 0!
	// If Module 2 is empty, its state should change along with Module 1's

	// Allowed States:
	// 00	0
	// 22	18
	// 12	10
	// 21	17
	// 11	9
	// 23	19
	// 32	26
	// 13	11
	// 31	25
	// 33	27
	// If there are any 3's, Moodle UserID must be set

	$state1 = $state & 07;
	$state2 = $state & 070;

	if (empty($registration['29'])) $registration['29'] = '0';
	$registration['29'] = (int)$registration['29'];

	if (empty($registration['1'])) $registration['1'] = '';
	if (empty($registration['2'])) $registration['2'] = '';
	if (empty($registration['11'])) $registration['11'] = '';
	if (empty($registration['16'])) $registration['16'] = '';
	if (empty($registration['18'])) $registration['18'] = '';
	if (empty($registration['19'])) $registration['19'] = '';
	if (empty($dobmonth[$sid])) $dobmonth[$sid] = '';
	if (empty($dobday[$sid])) $dobday[$sid] = '';
	if (empty($dobyear[$sid])) $dobyear[$sid] = '';
	if (empty($registration['12'])) $registration['12'] = '';
	if (empty($registration['3'])) $registration['3'] = '';
	if (empty($registration['14'])) $registration['14'] = '';
	if (empty($registration['13'])) $registration['13'] = '';
	if (empty($registration['36'])) $registration['36'] = '0';
	if (empty($registration['7'])) $registration['7'] = '';
	if (empty($registration['34'])) $registration['34'] = '0';
	if (empty($registration['35'])) $registration['35'] = '0';
	if (empty($registration['8'])) $registration['8'] = '';
	if (empty($registration['10'])) $registration['10'] = '';
	if (empty($registration['31'])) $registration['31'] = '';
	if (empty($registration['32'])) $registration['32'] = '';
	if (empty($registration['21'])) $registration['21'] = '';

	$registration['1'] = trim(strip_tags($registration['1']));
	$registration['2'] = trim(strip_tags($registration['2']));
	$registration['11'] = trim(strip_tags($registration['11']));
	$registration['14'] = trim(strip_tags($registration['14']));
	$registration['13'] = strip_tags($registration['13']);
	$registration['36'] = strip_tags($registration['36']);
	$registration['34'] = strip_tags($registration['34']);
	$registration['35'] = strip_tags($registration['35']);
	$registration['21'] = strip_tags($registration['21']);

	$registration['21'] = str_replace("<", '', $registration['21']);
	$registration['21'] = str_replace(">", '', $registration['21']);
	$registration['21'] = str_replace("/", '', $registration['21']);
	$registration['21'] = str_replace("#", '', $registration['21']);
	$registration['21'] = trim(moodle_strtolower($registration['21']));
	// $registration['21'] = eregi_replace("[^(-\.[:alnum:])]", '', $registration['21']);
	if (empty($registration['21'])) $registration['21'] = 'user1';	// Just in case it becomes empty

	// Moodle limits...
	$registration['1'] = mb_substr($registration['1'], 0, 100, 'UTF-8');
	$registration['2'] = mb_substr($registration['2'], 0, 100, 'UTF-8');
	$registration['11'] = mb_substr($registration['11'], 0, 100, 'UTF-8');
	$registration['14'] = mb_substr($registration['14'], 0, 20, 'UTF-8');
	$registration['21'] = mb_substr($registration['21'], 0, 100, 'UTF-8');


	$application = $applications[$sid];

	testmatch($application, $state, $sid, $registration, $dobmonth[$sid], $dobday[$sid], $dobyear[$sid]);

	if (true) {
		echo '<tr>';
		echo '<td>' . gmdate('d/m/Y H:i', $registration['submitted']) . '</td>';
		echo '<td>' . $sid . '</td>';

		if ($state === 0) echo '<td><span style="color:red">No</span></td>';
		elseif ($state === 022) echo '<td><span style="color:blue">Denied or Deferred</span></td>';
		elseif ($state1===02 || $state2===020) echo '<td><span style="color:blue">Some</span></td>';
		else echo '<td><span style="color:green">Yes</span></td>';

		if (empty($application->paymentmechanism)) $mechanism = '';
		elseif ($application->paymentmechanism == 1) $mechanism = ' RBS Confirmed';
		elseif ($application->paymentmechanism == 2) $mechanism = ' Barclays';
		elseif ($application->paymentmechanism == 3) $mechanism = ' Diamond';
		elseif ($application->paymentmechanism == 4) $mechanism = ' Western Union';
		elseif ($application->paymentmechanism == 5) $mechanism = ' Indian Confederation';
		elseif ($application->paymentmechanism == 6) $mechanism = ' Promised End Semester';
    elseif ($application->paymentmechanism == 7) $mechanism = ' Posted Travellers Cheques';
    elseif ($application->paymentmechanism == 8) $mechanism = ' Posted Cash';
		elseif ($application->paymentmechanism == 100) $mechanism = ' Waiver';
		elseif ($application->paymentmechanism == 102) $mechanism = ' Barclays Confirmed';
		elseif ($application->paymentmechanism == 103) $mechanism = ' Diamond Confirmed';
		elseif ($application->paymentmechanism == 104) $mechanism = ' Western Union Confirmed';
		elseif ($application->paymentmechanism == 105) $mechanism = ' Indian Confederation Confirmed';
    elseif ($application->paymentmechanism == 107) $mechanism = ' Posted Travellers Cheques Confirmed';
    elseif ($application->paymentmechanism == 108) $mechanism = ' Posted Cash Confirmed';
		else  $mechanism = '';

		if ($application->costpaid < .01) echo '<td><span style="color:red">No' . $mechanism . '</span></td>';
		elseif (abs($application->costowed - $application->costpaid) < .01) echo '<td><span style="color:green">Yes' . $mechanism . '</span></td>';
		else echo '<td><span style="color:blue">' . "Paid $application->costpaid out of $application->costowed" . $mechanism . '</span></td>';

		if (!($state1===03 || $state2===030)) echo '<td><span style="color:red">No</span></td>';
		elseif ($state === 033) echo '<td><span style="color:green">Yes</span></td>';
		else echo '<td><span style="color:blue">Some</span></td>';

//		echo '<td><a href="' . $CFG->wwwroot . '/course/app.php?'
//			.'30='.urlencode($registration['30'])
//			.'&29='.urlencode($registration['29'])
//			.'&1='.urlencode($registration['1'])
//			.'&2='.urlencode($registration['2'])
//			.'&11='.urlencode($registration['11'])
//			.'&16='.urlencode($registration['16'])
//			.'&18='.urlencode($registration['18'])
//			.'&19='.urlencode($registration['19'])
//			.'&dobday='.urlencode($dobday[$sid])
//			.'&dobmonth='.urlencode($dobmonth[$sid])
//			.'&dobyear='.urlencode($dobyear[$sid])
//			.'&12='.urlencode($registration['12'])
//			.'&3='.urlencode($registration['3'])
//			.'&14='.urlencode($registration['14'])
//			.'&13='.urlencode($registration['13'])
//			.'&7='.urlencode($registration['7'])
//			.'&8='.urlencode($registration['8'])
//			.'&10='.urlencode($registration['10'])
//			.'&31='.urlencode($registration['31'])
//			.'&32='.urlencode($registration['32'])
//			.'&21='.urlencode($registration['21'])
//			.'&sid='.$sid
//			.'&sesskey='.$USER->sesskey
//			.'" target="_blank">More Info.</a></td>';
		if (!$displayextra) {
?>
<td>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>" target="_blank">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($registration['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($registration['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($registration['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($registration['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($registration['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($registration['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($registration['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $dobday[$sid]; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $dobmonth[$sid]; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $dobyear[$sid]; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($registration['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($registration['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($registration['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($registration['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($registration['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($registration['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($registration['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($registration['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($registration['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($registration['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($registration['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($registration['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="nid" value="<?php echo $registration['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapp" value="1" />
<input type="submit" name="approveapplication" value="Details" />
</form>
<?php
		if ($registration['nid'] == 80) echo 'Re&#8209;enrolment';
		echo '</td>';
		}
		echo "<td>" . htmlspecialchars($registration['1'], ENT_COMPAT, 'UTF-8') . "</td>";
		echo "<td>" . htmlspecialchars($registration['2'], ENT_COMPAT, 'UTF-8') . "</td>";
		if ($emailcounts[$registration['11']] === 1) {
			echo "<td>" . htmlspecialchars($registration['11'], ENT_COMPAT, 'UTF-8') . "</td>";
		}
		else {
			echo "<td>" . '<span style="color:navy">**</span>' . htmlspecialchars($registration['11'], ENT_COMPAT, 'UTF-8') . "</td>";
		}
		echo "<td>" . htmlspecialchars($registration['16'], ENT_COMPAT, 'UTF-8') . "</td>";

		echo '<td>';
		if ($state1 === 02) {
			echo '<span style="color:red">';
		}
		elseif ($state1 === 01) {
			echo '<span style="color:#FF8C00">';
		}
		elseif ($state1 === 03) {
			echo '<span style="color:green">';
		}
		else {
			echo '<span>';
		}
		echo htmlspecialchars($registration['18'], ENT_COMPAT, 'UTF-8') . '</span></td>';

		echo '<td>';
		if ($state2 === 020) {
			echo '<span style="color:red">';
		}
		elseif ($state2 === 010) {
			echo '<span style="color:#FF8C00">';
		}
		elseif ($state2 === 030) {
			echo '<span style="color:green">';
		}
		else {
			echo '<span>';
		}
		echo htmlspecialchars($registration['19'], ENT_COMPAT, 'UTF-8') . '</span></td>';

		echo "<td>" . $dobday[$sid] . '/' . $dobmonth[$sid] . '/' . $dobyear[$sid] . "</td>";
		echo "<td>" . $registration['12'] . "</td>";
		echo "<td>" . htmlspecialchars($registration['14'], ENT_COMPAT, 'UTF-8') . "</td>";
		if (empty($countryname[$registration['13']])) echo "<td></td>";
		else echo "<td>" . $countryname[$registration['13']] . "</td>";
		//echo "<td>" . $registration['31'] . "</td>";
		//echo "<td>" . htmlspecialchars($registration['32'], ENT_COMPAT, 'UTF-8') . "</td>";

		if ($displayextra) {
			echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8'))) . "</td>";

			if (empty($employmentname[$registration['36']])) echo "<td></td>";
			else echo "<td>" . $employmentname[$registration['36']] . "</td>";

			echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['7'], ENT_COMPAT, 'UTF-8'))) . "</td>";

			if (empty($qualificationname[$registration['34']])) echo "<td></td>";
			else echo "<td>" . $qualificationname[$registration['34']] . "</td>";
			if (empty($higherqualificationname[$registration['35']])) echo "<td></td>";
			else echo "<td>" . $higherqualificationname[$registration['35']] . "</td>";

			echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['8'], ENT_COMPAT, 'UTF-8'))) . "</td>";
			echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['10'], ENT_COMPAT, 'UTF-8'))) . "</td>";
			echo "<td>" . htmlspecialchars($registration['21'], ENT_COMPAT, 'UTF-8') . "</td>";
			if (empty($registration['29'])) echo '<td></td>';
			else echo "<td>" . $registration['29'] . "</td>";
			//echo '<td>' . $sid . '</td>';
		}
		if (empty($registration['29'])) echo '<td></td>';
		else echo '<td><a href="' . $CFG->wwwroot . '/course/student.php?id=' . $registration['29'] . '" target="_blank">Student Grades</a></td>';
		if (empty($registration['29'])) echo '<td></td>';
		else echo '<td><a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $registration['29'] . '" target="_blank">Student Submissions</a></td>';
		echo "</tr>";

		if (empty($modules[$registration['18']])) {
			$modules[$registration['18']] = 1;
		}
		else {
			$modules[$registration['18']]++;
		}
		if (!empty($registration['19'])) {
			if (empty($modules[$registration['19']])) {
				$modules[$registration['19']] = 1;
			}
			else {
				$modules[$registration['19']]++;
			}
		}

		$n++;

		if ($state1===01 || $state1===03 || $state2===010 || $state2===030) {
			$napproved++;

			// Is Module 1 Approved/Registered
			if ($state1===01 || $state1===03) {
				if (empty($moduleapprovals[$registration['18']])) {
					$moduleapprovals[$registration['18']] = 1;
				}
				else {
					$moduleapprovals[$registration['18']]++;
				}
			}

			// Is Module 2 Approved/Registered
			if ($state2===010 || $state2===030) {
				if (!empty($registration['19'])) {
					if (empty($moduleapprovals[$registration['19']])) {
						$moduleapprovals[$registration['19']] = 1;
					}
					else {
						$moduleapprovals[$registration['19']]++;
					}
				}
			}

			if (empty($gender[$registration['12']])) {
				$gender[$registration['12']] = 1;
			}
			else {
				$gender[$registration['12']]++;
			}

			if (empty($dobyear[$sid])) $range = '';
			elseif ($dobyear[$sid] >= 1990) $range = '1990+';
			elseif ($dobyear[$sid] >= 1980) $range = '1980-1989';
			elseif ($dobyear[$sid] >= 1970) $range = '1970-1979';
			elseif ($dobyear[$sid] >= 1960) $range = '1960-1969';
			elseif ($dobyear[$sid] >= 1950) $range = '1950-1959';
			else $range = '1900-1950';
			if (empty($age[$range])) {
				$age[$range] = 1;
			}
			else {
				$age[$range]++;
			}

			if (empty($country[$countryname[$registration['13']]])) {
				$country[$countryname[$registration['13']]] = 1;
			}
			else {
				$country[$countryname[$registration['13']]]++;
			}

			$listofemails[]  = htmlspecialchars($registration['11'], ENT_COMPAT, 'UTF-8');
		}
		if ($state1===03 || $state2===030) {
			$nregistered++;

			// Is Module 1 Registered
			if ($state1 === 03) {
				if (empty($moduleregistrations[$registration['18']])) {
					$moduleregistrations[$registration['18']] = 1;
				}
				else {
					$moduleregistrations[$registration['18']]++;
				}
			}

			// Is Module 2 Registered
			if ($state2 === 030) {
				if (!empty($registration['19'])) {
					if (empty($moduleregistrations[$registration['19']])) {
						$moduleregistrations[$registration['19']] = 1;
					}
					else {
						$moduleregistrations[$registration['19']]++;
					}
				}
			}
		}
	}
}
echo '</table>';
echo '<br />Total Applications: ' . $n;
echo '<br />Total Approved (or part Approved): ' . $napproved;
echo '<br />Total Registered (or part Registered): ' . $nregistered;
echo '<br /><br />(Duplicated e-mails: ' . $emaildups . ',  see <span style="color:navy">**</span>)';
echo '<br/><br/>';

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";
echo "<td>Module</td>";
echo "<td>Number of Applications</td>";
echo "<td>Number Approved</td>";
echo "<td>Number Registered</td>";
echo "</tr>";

ksort($modules);

$n = 0;

foreach ($modules as $product => $number) {
	echo "<tr>";
	echo "<td>" . $product . "</td>";
	echo "<td>" . $number . "</td>";
	if (empty($moduleapprovals[$product])) { echo "<td>0</td>";} else { 	echo "<td>" . $moduleapprovals[$product] . "</td>";}
	if (empty($moduleregistrations[$product])) { echo "<td>0</td>";} else { echo "<td>" . $moduleregistrations[$product] . "</td>";}
    echo "</tr>";

	$n++;
}
echo '</table>';
echo '<br/>Number of Modules: ' . $n . '<br /><br />';

natcasesort($listofemails);
echo 'e-mails of Approved Students...<br />' . implode(', ', array_unique($listofemails)) . '<br /><br />';

echo 'Statistics for Approved Students...<br />';
displaystat($gender,'Gender');
displaystat($age,'Year of Birth');
displaystat($country,'Country');


$peoples_batch_reminder_email = get_config(NULL, 'peoples_batch_reminder_email');

$peoples_batch_reminder_email = htmlspecialchars($peoples_batch_reminder_email, ENT_COMPAT, 'UTF-8');
?>
<br />To send an e-mail to all the students in the main spreadsheet above...
enter BOTH a subject and optionally edit the e-mail text below and click "Send e-mail to All".<br />
<br />
NOTE, to send an e-mail only to approved and registered students for the current semester who have not indicated that they have paid
or have otherwise been marked as paid or have a waiver... BEFORE SENDING THE E_MAIL,
set the filters at the top of this page as follows...<br />
Status: "Part or Fully Approved"<br />
"Paid?" Value: "No Indication Given"<br />
<br />
Also look at list of e-mails sent to verify they went! (No subject and they will not go!)<br /><br />
<form id="emailsendform" method="post" action="<?php
  echo $CFG->wwwroot . '/course/applications.php?'
    . 'chosensemester=' . urlencode(stripslashes($_REQUEST['chosensemester']))
    . '&chosenstatus=' . urlencode($_REQUEST['chosenstatus'])
    . '&chosenstartyear=' . $_REQUEST['chosenstartyear']
    . '&chosenstartmonth=' . $_REQUEST['chosenstartmonth']
    . '&chosenstartday=' . $_REQUEST['chosenstartday']
    . '&chosenendyear=' . $_REQUEST['chosenendyear']
    . '&chosenendmonth=' . $_REQUEST['chosenendmonth']
    . '&chosenendday=' . $_REQUEST['chosenendday']
    . '&chosensearch=' . urlencode(stripslashes($_REQUEST['chosensearch']))
    . '&chosenpay=' . urlencode($_REQUEST['chosenpay'])
    . (empty($_REQUEST['displayextra']) ? '&displayextra=0' : '&displayextra=1');
?>">
Subject:&nbsp;<input type="text" size="75" name="emailsubject" /><br />
<textarea name="emailbody" rows="15" cols="75" wrap="hard">
<?php echo $peoples_batch_reminder_email; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markemailsend" value="1" />
<input type="submit" name="emailsend" value="Send e-mail to All" />
<br />Regular expression for included e-mails (defaults to all, so do not change!):&nbsp;<input type="text" size="20" name="reg" value="/^[a-zA-Z0-9_.-]/" />
</form>
<br /><br />
<?php


$time4 = time();
echo 'Query seconds: ' . ($time2-$time1) . ', Process rows: ' . ($time3-$time2) . ', Generate tables: ' . ($time4-$time3) . ', Total: ' . ($time4-$time1);

echo '<br /><br /><br />';

notice(get_string('continue'), "$CFG->wwwroot/");


function displaystat($stat, $title) {
	echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
	echo "<tr>";
	echo "<td>$title</td>";
	echo "<td>Number</td>";
	echo "</tr>";

	ksort($stat);

	foreach ($stat as $key => $number) {
		echo "<tr>";
		echo "<td>" . $key . "</td>";
		echo "<td>" . $number . "</td>";
	    echo "</tr>";
	}
	echo '</table>';
	echo '<br/>';
}


function insertapplication($sid, $registration, $dobmonth, $dobday, $dobyear) {

	if (empty($registration['30'])) $registration['30'] = '0';

	$state = (int)$registration['30'];
	// Legacy fixups...
	if ($state === 2) {
		$state = 022;
	}
	if ($state === 1) {
		$state = 011;
	}

	if (empty($registration['29'])) $registration['29'] = '0';
	$registration['29'] = (int)$registration['29'];

	if (empty($registration['1'])) $registration['1'] = '';
	if (empty($registration['2'])) $registration['2'] = '';
	if (empty($registration['11'])) $registration['11'] = '';
	if (empty($registration['16'])) $registration['16'] = '';
	if (empty($registration['18'])) $registration['18'] = '';
	if (empty($registration['19'])) $registration['19'] = '';
	if (empty($dobmonth)) $dobmonth = '';
	if (empty($dobday)) $dobday = '';
	if (empty($dobyear)) $dobyear = '';
	if (empty($registration['12'])) $registration['12'] = '';
	if (empty($registration['3'])) $registration['3'] = '';
	if (empty($registration['14'])) $registration['14'] = '';
	if (empty($registration['13'])) $registration['13'] = '';
	if (empty($registration['36'])) $registration['36'] = '0';
	if (empty($registration['7'])) $registration['7'] = '';
	if (empty($registration['34'])) $registration['34'] = '0';
	if (empty($registration['35'])) $registration['35'] = '0';
	if (empty($registration['8'])) $registration['8'] = '';
	if (empty($registration['10'])) $registration['10'] = '';
	if (empty($registration['31'])) $registration['31'] = '';
	if (empty($registration['32'])) $registration['32'] = '';
	if (empty($registration['21'])) $registration['21'] = '';

  $registration['1'] = trim(strip_tags($registration['1']));
  $registration['2'] = trim(strip_tags($registration['2']));
  $registration['11'] = trim(strip_tags($registration['11']));
  $registration['14'] = trim(strip_tags($registration['14']));
	$registration['13'] = strip_tags($registration['13']);
	$registration['36'] = strip_tags($registration['36']);
	$registration['34'] = strip_tags($registration['34']);
	$registration['35'] = strip_tags($registration['35']);
	$registration['21'] = strip_tags($registration['21']);

	$registration['21'] = str_replace("<", '', $registration['21']);
	$registration['21'] = str_replace(">", '', $registration['21']);
	$registration['21'] = str_replace("/", '', $registration['21']);
	$registration['21'] = str_replace("#", '', $registration['21']);
	$registration['21'] = trim(moodle_strtolower($registration['21']));
	// $registration['21'] = eregi_replace("[^(-\.[:alnum:])]", '', $registration['21']);
	if (empty($registration['21'])) $registration['21'] = 'user1';	// Just in case it becomes empty

	// Moodle limits...
	$registration['1'] = mb_substr($registration['1'], 0, 100, 'UTF-8');
	$registration['2'] = mb_substr($registration['2'], 0, 100, 'UTF-8');
	$registration['11'] = mb_substr($registration['11'], 0, 100, 'UTF-8');
	$registration['14'] = mb_substr($registration['14'], 0, 20, 'UTF-8');
	$registration['21'] = mb_substr($registration['21'], 0, 100, 'UTF-8');

	// Over time, rows from this datbase (retrieved based on 'sid') should replace nearly all the data passed via form hidden fields
	// But it is also the driver of payments by students for modules
	$application = new object();
	$application->datesubmitted = $registration['submitted'];
	$application->sid = $sid;
	$application->nid = $registration['nid'];

	// hidden fields (e.g. state & userid are cleaned above)
	// However a malicious applicant could, in theory, have set a dodgy state or userid. So ideally, in the future, first time though here, state (and userid for initial application) should be set to zero here (when this database becomes the master copy of applications)
	$application->state = $state;
	$application->userid = $registration['29'];

	// fields such as username are cleaned above
	$application->username = addslashes($registration['21']);
	$application->firstname = addslashes($registration['2']);
	$application->lastname = addslashes($registration['1']);
	$application->email = addslashes($registration['11']);
	$application->city = addslashes($registration['14']);

	// Drupal select fields are protected by Drupal Form API
	$application->country = $registration['13'];
	$application->qualification = $registration['34'];
	$application->higherqualification = $registration['35'];
	$application->employment = $registration['36'];
	$application->coursename1 = addslashes($registration['18']);
	$application->coursename2 = addslashes($registration['19']);
	$application->semester = addslashes($registration['16']);
	$application->dobday = $dobday;
	$application->dobmonth = $dobmonth;
	$application->dobyear = $dobyear;
	$application->gender = $registration['12'];

	// Currently appaction.php does cleaning, so if these data are used in the future in appaction.php, do not do cleaning twice
	$application->applicationaddress = addslashes(htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8'));
	$application->currentjob = addslashes(htmlspecialchars($registration['7'], ENT_COMPAT, 'UTF-8'));
	$application->education = addslashes(htmlspecialchars($registration['8'], ENT_COMPAT, 'UTF-8'));
	$application->reasons = addslashes(htmlspecialchars($registration['10'], ENT_COMPAT, 'UTF-8'));
	$application->methodofpayment = addslashes(htmlspecialchars($registration['31'], ENT_COMPAT, 'UTF-8'));
	$application->paymentidentification = addslashes(htmlspecialchars($registration['32'], ENT_COMPAT, 'UTF-8'));

	$application->currency = 'GBP'; // The DB default is no longer correct 20090526!

	if (substr($registration['31'], 0, 6) === 'HIDDEN') {
		$application->hidden = 1;
	}

	insert_record('peoplesapplication', $application);
}



function testmatch($application, $state, $sid, $registration, $dobmonth, $dobday, $dobyear) {
	$failed = false;

	if ($application->datesubmitted != $registration['submitted']) {$failed = true; echo 'datesubmitted<br />';}
	if ($application->sid != $sid) {$failed = true; echo 'sid<br />';}
	if ($application->nid != $registration['nid']) {$failed = true; echo 'nid<br />';}
	if ($application->state != $state) {$failed = true; echo 'state<br />';}
	if ($application->userid != $registration['29']) {$failed = true; echo 'userid<br />';}
	if ($application->username != ($registration['21'])) {$failed = true; echo 'username<br />';}
  if (trim($application->firstname) != ($registration['2'])) {$failed = true; echo 'firstname<br />';}
  if (trim($application->lastname) != ($registration['1'])) {$failed = true; echo 'lastname<br />';}
  if (trim($application->email) != ($registration['11'])) {$failed = true; echo 'email<br />';}
  if (trim($application->city) != ($registration['14'])) {$failed = true; echo 'city<br />';}
	if ($application->country != $registration['13']) {$failed = true; echo 'country<br />';}
	if ($application->qualification != $registration['34']) {$failed = true; echo 'qualification<br />';}
	if ($application->higherqualification != $registration['35']) {$failed = true; echo 'higherqualification<br />';}
	if ($application->employment != $registration['36']) {$failed = true; echo 'employment<br />';}
	if ($application->coursename1 != ($registration['18'])) {$failed = true; echo 'coursename1<br />';}
	if ($application->coursename2 != ($registration['19'])) {$failed = true; echo 'coursename2<br />';}
	if ($application->semester != ($registration['16'])) {$failed = true; echo 'semester<br />';}
	if ($application->dobday != $dobday) {$failed = true; echo 'dobday<br />';}
	if ($application->dobmonth != $dobmonth) {$failed = true; echo 'dobmonth<br />';}
	if ($application->dobyear != $dobyear) {$failed = true; echo 'doyear<br />';}
	if ($application->gender != $registration['12']) {$failed = true; echo 'gender<br />';}
	if ($application->applicationaddress != (htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8'))) {$failed = true; echo 'applicationaddress<br />';}
	if ($application->currentjob != (htmlspecialchars($registration['7'], ENT_COMPAT, 'UTF-8'))) {$failed = true; echo 'currentjob<br />';}
	if ($application->education != (htmlspecialchars($registration['8'], ENT_COMPAT, 'UTF-8'))) {$failed = true; echo 'education<br />';}
	if ($application->reasons != (htmlspecialchars($registration['10'], ENT_COMPAT, 'UTF-8'))) {$failed = true; echo 'reasons<br />';}
	if ($application->methodofpayment != (htmlspecialchars($registration['31'], ENT_COMPAT, 'UTF-8'))) {$failed = true; echo 'methodofpayment<br />';}
	if ($application->paymentidentification != (htmlspecialchars($registration['32'], ENT_COMPAT, 'UTF-8'))) {$failed = true; echo 'paymentidentification<br />';}

	if ($failed) {
		echo 'Compare Failed for application, tell Alan!...<br />';
		echo var_dump($application) . '<br />';
		echo var_dump($sid) . '<br />';
		echo var_dump($dobday) . '<br />';
		echo var_dump($dobmonth) . '<br />';
		echo var_dump($dobyear) . '<br />';
		echo var_dump($registration) . '<br />';
		die();
	}
}


function sendemails($registrations, $applications, $emailsubject, $emailbody, $reg) {

  echo '<br />';
  $i = 1;
  foreach ($registrations as $sid => $registration) {
    $application = $applications[$sid];

    $email = trim($application->email);

    if (!preg_match($reg, $email)) {
      echo "&nbsp;&nbsp;&nbsp;&nbsp;($email skipped because of regular expression.)<br />";
      continue;
    }

    $emailbodytemp = str_replace('GIVEN_NAME_HERE', trim($application->firstname), $emailbody);
    $emailbodytemp = str_replace('SID_HERE', $sid, $emailbodytemp);
    $emailbodytemp = str_replace('AMOUNT_OWED_HERE', $application->costowed, $emailbodytemp);

    $emailbodytemp = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $emailbodytemp); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                                       // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

    if (sendapprovedmail($email, $emailsubject, $emailbodytemp)) {
      echo "($i) $email successfully sent.<br />";
    }
    else {
      echo "FAILURE TO SEND $email !!!<br />";
    }
    $i++;
  }
}


function sendapprovedmail($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new object;
  $user->id = 999999999;
  // $user->email = 'alanabarrett0@gmail.com';
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = 1;

  // $supportuser = generate_email_supportuser();
  $supportuser = new object;
  $supportuser->email = 'payments@peoples-uni.org';
  $supportuser->firstname = 'Peoples-uni Payments';
  $supportuser->lastname = '';
  $supportuser->maildisplay = true;

  $messagehtml = text_to_html($message, false, false, true);

  $user->mailformat = 1;  // Always send HTML version as well

  $ret = email_to_user($user, $supportuser, $subject, $message, $messagehtml);

  $user->email = 'applicationresponses@peoples-uni.org';

  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message, $messagehtml);

  return $ret;
}
?>
