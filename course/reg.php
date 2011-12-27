<?php  // $Id: reg.php,v 1.1 2012/12/18 14:30:00 alanbarrett Exp $
/**
*
* List a single Registration application
*
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

$howfoundpeoplesname['10'] = 'Informed by another Peoples-uni student';
$howfoundpeoplesname['20'] = 'Informed by someone else';
$howfoundpeoplesname['30'] = 'Facebook';
$howfoundpeoplesname['40'] = 'Internet advertisement';
$howfoundpeoplesname['50'] = 'Link from another website or discussion forum';
$howfoundpeoplesname['60'] = 'I used a search engine to look for courses';



require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/reg.php'); // Defined here to avoid notices on errors etc

//$PAGE->set_pagelayout('embedded');   // Needs as much space as possible
//$PAGE->set_pagelayout('base');     // Most backwards compatible layout without the blocks - this is the layout used by default
$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();

//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Student Registration Details');
$application = $DB->get_record('peoplesregistration', array('id' => $_REQUEST['id']));
$PAGE->set_heading('Details for '. htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8') . ', ' . htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();

if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');


echo '<script type="text/JavaScript">function areyousuredeleteentry() { var sure = false; sure = confirm("Are you sure you want to Hide this Application Form Entry for ' . htmlspecialchars(($application->firstname), ENT_COMPAT, 'UTF-8') . ' ' . htmlspecialchars(($application->lastname), ENT_COMPAT, 'UTF-8') . ' from All Future Processing?"); return sure;}</script>';


$refreshparent = false;
if (!empty($_POST['markchangeemail']) && !empty($_POST['11'])) {
  $application->email = trim($application->email);

  updateapplication($_POST['id'], 'email', $application->email);

  $refreshparent = true;
}


if ($refreshparent) {
?>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
<?php
}


$application = $DB->get_record('peoplesapplication', array('id' => $_REQUEST['id']));


$state = (int)$application->state;
if ($state === 0) {
	$state = 022;
}
$state1 = $state & 07;
$state2 = $state & 070;

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";
echo "<td>Family name</td>";
echo "<td>" . htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Given name</td>";
echo "<td>" . htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Email address</td>";
echo "<td>" . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>DOB</td>";
echo "<td>" . $application->dobday . "/" . $application->dobmonth . "/" . $application->dobyear . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Gender</td>";
echo "<td>" . $application->gender . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Address</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($application->applicationaddress, ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>City/Town</td>";
echo "<td>" . htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Country</td>";
if (empty($countryname[$application->country])) echo "<td></td>";
else echo "<td>" . $countryname[$application->country] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Current Employment</td>";
if (empty($employmentname[$application->employment])) echo "<td></td>";
else echo "<td>" . $employmentname[$application->employment] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Current Employment Details</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($application->currentjob, ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Higher Education Qualification</td>";
if (empty($qualificationname[$application->qualification])) echo "<td></td>";
else echo "<td>" . $qualificationname[$application->qualification] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Postgraduate Qualification</td>";
if (empty($higherqualificationname[$application->higherqualification])) echo "<td></td>";
else echo "<td>" . $higherqualificationname[$application->higherqualification] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Other relevant qualifications or educational experience</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($application->education, ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Reasons for wanting to enrol</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($application->reasons, ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";
echo '<tr>';
echo '<td>Sponsoring organisation</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($application->sponsoringorganisation, ENT_COMPAT, 'UTF-8'))) . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Scholarship</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($application->scholarship, ENT_COMPAT, 'UTF-8'))) . '</td>';
echo '</tr>';
echo '<tr>';
if (empty($howfoundpeoplesname[$application->howfoundpeoples])) echo "<td></td>";
else echo "<td>" . $howfoundpeoplesname[$application->howfoundpeoples] . "</td>";
echo '</tr>';
echo '<tr>';
echo '<td>Desired Moodle Username</td>';
echo '<td>' . htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8') . '</td>';
echo '</tr>';
if (!empty($application->userid)) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/student.php?id=' . $application->userid . '" target="_blank">Student Grades</a></td></tr>';
if (!empty($application->userid)) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $application->userid . '" target="_blank">Student Submissions</a></td></tr>';

$sid = $_REQUEST['sid'];
echo '</table>';

if ($state === 022) {
  $given_name = $application->firstname;
  $sid        = $_REQUEST['sid'];

  if ($application->nid == 80) $peoples_approval_email = get_config(NULL, 'peoples_approval_old_students_email');
  else                         $peoples_approval_email = get_config(NULL, 'peoples_approval_email');

  $peoples_approval_email = str_replace('GIVEN_NAME_HERE',           $given_name, $peoples_approval_email);
  $peoples_approval_email = str_replace('COURSE_MODULE_1_NAME_HERE', $course1, $peoples_approval_email);
  $peoples_approval_email = str_replace('SID_HERE',                  $sid, $peoples_approval_email);
  if (!empty($course2)) {
    $peoples_approval_email = str_replace('COURSE_MODULE_2_TEXT_HERE', "and the Course Module '" . $course2 . "' ", $peoples_approval_email);
    $peoples_approval_email = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', "Please note that you have applied to take two modules, these run at the
same time and will involve a heavy workload - please be sure you do have the time for this.", $peoples_approval_email);
  }
  else {
    $peoples_approval_email = str_replace('COURSE_MODULE_2_TEXT_HERE',         '', $peoples_approval_email);
    $peoples_approval_email = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', '', $peoples_approval_email);
  }

  $peoples_approval_email = htmlspecialchars($peoples_approval_email, ENT_COMPAT, 'UTF-8');

  if ($application->nid == 80) $peoples_approval_email_bursary = get_config(NULL, 'peoples_approval_old_students_bursary_email');
  else                         $peoples_approval_email_bursary = get_config(NULL, 'peoples_approval_bursary_email');

  $peoples_approval_email_bursary = str_replace('GIVEN_NAME_HERE',           $given_name, $peoples_approval_email_bursary);
  $peoples_approval_email_bursary = str_replace('COURSE_MODULE_1_NAME_HERE', $course1, $peoples_approval_email_bursary);
  $peoples_approval_email_bursary = str_replace('SID_HERE',                  $sid, $peoples_approval_email_bursary);
  if (!empty($course2)) {
    $peoples_approval_email_bursary = str_replace('COURSE_MODULE_2_TEXT_HERE', "and the Course Module '" . $course2 . "' ", $peoples_approval_email_bursary);
    $peoples_approval_email_bursary = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', "Please note that you have applied to take two modules, these run at the
same time and will involve a heavy workload - please be sure you do have the time for this.", $peoples_approval_email_bursary);
  }
  else {
    $peoples_approval_email_bursary = str_replace('COURSE_MODULE_2_TEXT_HERE',         '', $peoples_approval_email_bursary);
    $peoples_approval_email_bursary = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', '', $peoples_approval_email_bursary);
  }

  $peoples_approval_email_bursary = htmlspecialchars($peoples_approval_email_bursary, ENT_COMPAT, 'UTF-8');

?>
<br />To approve this application and send an e-mail to applicant (edit e-mail text if you wish), press "Approve Full Application".
<form id="approveapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8'); ?>" />
<textarea name="approvedtext" rows="15" cols="75" wrap="hard">
<?php echo $peoples_approval_email; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapproveapplication" value="1" />
<input type="submit" name="approveapplication" value="Approve Full Application" />
</form>
<br />

<br />To approve this application WITH BURSARY TEXT and send an e-mail to applicant (edit e-mail text if you wish), press "Approve Full Application BURSARY".
<form id="approveapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8'); ?>" />
<textarea name="approvedtext" rows="15" cols="75" wrap="hard">
<?php echo $peoples_approval_email_bursary; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapproveapplication" value="1" />
<input type="submit" name="approveapplication" value="Approve Full Application BURSARY" />
</form>
<br />
<?php
}
else {
	echo '<span style="color:green">This application is already (part) approved.</span><br />';
}

if ($state1 === 02) {
	if (empty($_REQUEST['19'])) {
		$newstate = 011;
	}
	else {
		$newstate = 01 | $state2;
	}
}

if (($state2===020) && !empty($_REQUEST['19'])) {
	if (empty($_REQUEST['19'])) {
		$newstate = 011;
	}
	else {
		$newstate = $state1 | 010;
	}
}

if ($state1===01 || $state1===03) {
	if (empty($_REQUEST['19'])) {
		$newstate = 022;
	}
	else {
		$newstate = 02 | $state2;
	}
}

if (($state2===010 || $state2===030) && !empty($_REQUEST['19'])) {
	if (empty($_REQUEST['19'])) {
		$newstate = 022;
	}
	else {
		$newstate = $state1 | 020;
	}
}

?>
<br />To send an e-mail to this applicant (EDIT the e-mail text below!), press "e-mail Applicant".
<form id="deferapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8'); ?>" />
<textarea name="defertext" rows="10" cols="75" wrap="hard">
Dear <?php echo htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8'); ?>,

You have applied to take the Course Module '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>'
<?php if (!empty($_REQUEST['19'])) echo "and the Course Module '" . htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8') . "'"; ?>.

     Peoples Open Access Education Initiative Administrator.
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeferapplication" value="1" />
<input type="submit" name="deferapplication" value="e-mail Applicant" />
</form>
<br />
<?php

if (!empty($application->userid)) {
  $userrecord = $DB->get_record('user', array('id' => ($application->userid)));
}
elseif (!empty($application->username)) {
	if ($_REQUEST['nid'] === '80') echo 'ERROR, THIS SHOULD NOT HAPPEN, TALK TO ALAN<br /><br />';

  $userrecord = $DB->get_record('user', array('username' => ($application->username)));
}
if (!empty($userrecord)) {
	if (empty($application->userid)) {
		echo "<strong>This applicant has not been Registered but there is already a Moodle user with the Username: '" . htmlspecialchars($userrecord->username, ENT_COMPAT, 'UTF-8') . "'...</strong>";
	}
	else {
		echo "<strong>Corresponding Registered Moodle Username: '" . htmlspecialchars($userrecord->username, ENT_COMPAT, 'UTF-8') . "'...</strong>";
	}

	echo "<table border=\"1\" BORDERCOLOR=\"RED\">";

	echo "<tr>";
	echo "<td>lastname</td>";
	if (!empty($userrecord->lastname)) { echo "<td>" . $userrecord->lastname . "</td>"; } else { echo "<td></td>"; }
	echo "</tr>";

	echo "<tr>";
	echo "<td>firstname</td>";
	if (!empty($userrecord->firstname)) { echo "<td>" . $userrecord->firstname . "</td>"; } else { echo "<td></td>"; }
	echo "</tr>";

	echo "<tr>";
	echo "<td>email</td>";
	if (!empty($userrecord->email)) { echo "<td>" . $userrecord->email . "</td>"; } else { echo "<td></td>"; }
	echo "</tr>";

	echo "<tr>";
	echo "<td>city</td>";
	if (!empty($userrecord->city)) { echo "<td>" . $userrecord->city . "</td>"; } else { echo "<td></td>"; }
	echo "</tr>";

	echo "<tr>";
	echo "<td>country</td>";
	if (!empty($countryname[$userrecord->country])) { echo "<td>" . $countryname[$userrecord->country] . "</td>"; } else { echo "<td></td>"; }
	echo "</tr>";

	echo "<tr>";
	echo "<td>id</td>";
	if (!empty($userrecord->id)) { echo "<td>" . $userrecord->id . "</td>"; } else { echo "<td></td>"; }
	echo "</tr>";

	echo '</table>';

	echo '<br />';

  $courses = enrol_get_users_courses($userrecord->id);

	if (!empty($courses)) {
		echo "User's courses...";
		echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
		foreach ($courses as $key => $course) {
			echo "<tr>";
			if (!empty($course->fullname)) { echo "<td>" . $course->fullname . "</td>"; } else { echo "<td></td>"; }
			echo "</tr>";
		}
		echo '</table>';
	}
	else {
		echo 'User ' . htmlspecialchars($userrecord->username, ENT_COMPAT, 'UTF-8') . ' is not enrolled in any courses.';
	}
//	$assigments = get_records('role_assignments', 'userid', $userrecord->id);
//
//	echo '<br />';
//
//	foreach ($assigments as $key => $assigment) {
//		echo "id: $assigment->id,";
//		echo "roleid: $assigment->roleid,";
//		echo "contextid: $assigment->contextid,";
//		echo "enrol: $assigment->enrol<br />";
//	}
	if (empty($application->userid)) {
?>

<br />Enter a new suggested user name here (maybe add "1" at the end of the existing name) and then press "Update Username" (you will need to come back to this page to register them).
<form id="appusernameform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdateusername" value="1" />
<input type="submit" name="updateusername" value="Update Username to:" style="width:40em" />
<input type="text" size="40" name="username" value="<?php echo htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br />
<?php
	}
	else {
		// We have a Moodle UserID

		if ($state1 === 01) {
			if (empty($_REQUEST['19'])) {
				$newstate = 033;
			}
			else {
				$newstate = $state2 | 03;
			}
		}
		if ($state2===010 && !empty($_REQUEST['19'])) {
			if (empty($_REQUEST['19'])) {
				$newstate = 033;
			}
			else {
				$newstate = $state1 | 030;
			}
		}
		if ($state1===01 && $state2===010 && !empty($_REQUEST['19'])) {
			$newstate = 033;
		}
	}
}
else {
?>
No Moodle user with the Username: '<?php echo htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8'); ?>'...<br />
<?php
	if ($state1 === 01) {
		if (empty($_REQUEST['19'])) {
			$newstate = 033;
		}
		else {
			$newstate = $state2 | 03;
		}
	}
	if ($state2===010 && !empty($_REQUEST['19'])) {
		if (empty($_REQUEST['19'])) {
			$newstate = 033;
		}
		else {
			$newstate = $state1 | 030;
		}
	}

	if ($state1===01 && $state2===010 && !empty($_REQUEST['19'])) {
		$newstate = 033;
?>
<form id="appcreateuserform12" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($application->country, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($application->qualification, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($application->higherqualification, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($application->employment, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $application->dobday; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $application->dobmonth; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $application->dobyear; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($application->gender, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->applicationaddress, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->currentjob, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->education, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->reasons, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->sponsoringorganisation, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->scholarship, ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markcreateuser12" value="1" />
<input type="submit" name="createuser12" value="Create User & Enrol in Modules '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' and '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>'" />
</form>
<br />
<?php
	}
}

if ($state1 !== 030 && $state2 !== 030 && empty($application->userid)) { // Allow applicant e-mail to be changed
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($application->userid, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $application->dobday; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $application->dobmonth; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $application->dobyear; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($application->gender, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($application->country, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($application->qualification, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($application->higherqualification, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($application->employment, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->applicationaddress, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->currentjob, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->education, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->reasons, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->sponsoringorganisation, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($application->scholarship, ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markchangeemail" value="1" />
<input type="submit" name="changeemail" value="Change Applicant e-mail to:" style="width:40em" />

<input type="text" size="40" name="11" value="<?php echo htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br />
<?php
}


echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';

?>
<br /><br /><br /><br /><br /><br /><br /><br />
<form id="deleteentryform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>" onSubmit="return areyousuredeleteentry()">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="newpaymentmethod" value="<?php echo 'HIDDEN' . htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeleteentry" value="1" />
<input type="submit" name="deleteentry" value="Hide this Application Form Entry from All Future Processing" style="width:40em" />
</form>
<?php

//print_footer();
echo $OUTPUT->footer();

function unenrolstudent($userid, $modulename) {
  global $DB;

	// Student is probably (but not for sure) enrolled in this module

	if (!empty($userid)) {
    $coursetoremove = $DB->get_record('course', array('fullname' => $modulename));
		if (!empty($coursetoremove)) {

      if (!enrol_is_enabled('manual')) {
        return false;
      }
      if (!$enrol = enrol_get_plugin('manual')) {
        return false;
      }
      if (!$instances = $DB->get_records('enrol', array('enrol'=>'manual', 'courseid'=>$coursetoremove->id, 'status'=>ENROL_INSTANCE_ENABLED), 'sortorder,id ASC')) {
        return false;
      }
      $instance = reset($instances);

      $enrol->unenrol_user($instance, $userid);

      $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $coursetoremove->id));

      if (!empty($enrolment)) {
        $enrolment->semester = ($enrolment->semester);
        $enrolment->dateunenrolled = time();
        $enrolment->enrolled = 0;
        $DB->update_record('enrolment', $enrolment);
      }

      $message = '';
      $user = $DB->get_record('user', array('id' => $userid));
      if (!empty($user->firstname))  $message .= $user->firstname;
      if (!empty($user->lastname))   $message .= ' ' . $user->lastname;
      $message .= ' as Student in ' . ($modulename);
      add_to_log($coursetoremove->id, 'course', 'unenrol', '../enrol/users.php?id=' . $coursetoremove->id, $message, 0, $userid);
		}
	}
}


function updateapplication($sid, $field, $value, $deltamodules = 0) {
  global $DB;

  $record = $DB->get_record('peoplesapplication', array('sid' => $sid));
	$application = new object();
	$application->id = $record->id;
	$application->{$field} = $value;

	if ($deltamodules != 0) {
		if (($deltamodules > 1) && empty($record->coursename2)) $deltamodules = 1;

		$application->costowed = $record->costowed + $deltamodules * MODULE_COST;
		if ($application->costowed < 0) $application->costowed = 0;
	}

  $DB->update_record('peoplesapplication', $application);
}


function enrolincourse($course, $user, $semester) {
  global $DB;

  $timestart = time();
  // remove time part from the timestamp and keep only the date part
  $timestart = make_timestamp(date('Y', $timestart), date('m', $timestart), date('d', $timestart), 0, 0, 0);

  $roles = get_archetype_roles('student');
  $role = reset($roles);

  if (enrol_try_internal_enrol($course->id, $user->id, $role->id, $timestart, 0)) {

    $enrolment = $DB->get_record('enrolment', array('userid' => $user->id, 'courseid' => $course->id));
    if (!empty($enrolment)) {
      $enrolment->semester = ($enrolment->semester);
      $enrolment->enrolled = 1;
      $DB->update_record('enrolment', $enrolment);
    }
    else {
      $enrolment->userid = $user->id;
      $enrolment->courseid = $course->id;
      $enrolment->semester = $semester;
      $enrolment->datefirstenrolled = time();
      $enrolment->enrolled = 1;
      $enrolment->percentgrades = 1;

      $DB->insert_record('enrolment', $enrolment);
    }

    emailwelcome($course, $user);

    $message = '';
    if (!empty($user->firstname))  $message .= $user->firstname;
    if (!empty($user->lastname)) $message .= ' ' . $user->lastname;
    if (!empty($role->name)) $message .= ' as ' . $role->name;
    if (!empty($course->fullname)) $message .= ' in ' . $course->fullname;
    add_to_log($course->id, 'course', 'enrol', '../enrol/users.php?id=' . $course->id, $message, 0, $user->id);

    return true;
  }
  else {
    return false;
  }
}


function emailwelcome($course, $user) {
  global $CFG;

  $subject = "New enrolment in $course->fullname";
  $message = "Welcome to $course->fullname!

If you have not done so already, you should edit your profile page
so that we can learn more about you:

  $CFG->wwwroot/user/view.php?id=$user->id&amp;course=$course->id

There is a link to your course at the bottom of the profile or you can click:

  $CFG->wwwroot/course/view.php?id=$course->id";

  $teacher = get_peoples_teacher($course);
  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $teacher, $subject, $message);

//  $eventdata = new stdClass();
//  $eventdata->modulename        = 'moodle';
//  $eventdata->component         = 'course';
//  $eventdata->name              = 'flatfile_enrolment';
//  $eventdata->userfrom          = $teacher;
//  $eventdata->userto            = $user;
//  $eventdata->subject           = $subject;
//  $eventdata->fullmessage       = $message;
//  $eventdata->fullmessageformat = FORMAT_PLAIN;
//  $eventdata->fullmessagehtml   = '';
//  $eventdata->smallmessage      = '';
//  message_send($eventdata);
}


function get_peoples_teacher($course) {
  global $DB;

  $context = get_context_instance(CONTEXT_COURSE, $course->id);

  $role = $DB->get_record('role', array('name' => 'Module Leader'));

  if ($teachers = get_role_users($role->id, $context)) {
    foreach ($teachers as $teacher) {
      $teacheruserid = $teacher->id;
    }
  }

  if (isset($teacheruserid)) {
    $teacher = $DB->get_record('user', array('id' => $teacheruserid));
  }
  else {
    $teacher = get_admin();
  }
  return $teacher;
}
?>
