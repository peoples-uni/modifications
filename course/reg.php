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
$countryname['BQ'] = 'Bonaire, Sint Eustatius and Saba';
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
$countryname['CW'] = 'Curaçao';
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
$countryname['XK'] = 'Kosovo';
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
$countryname['SX'] = 'Sint Maarten (Dutch part)';
$countryname['SK'] = 'Slovakia';
$countryname['SI'] = 'Slovenia';
$countryname['SB'] = 'Solomon Islands';
$countryname['SO'] = 'Somalia';
$countryname['ZA'] = 'South Africa';
$countryname['GS'] = 'South Georgia And The South Sandwich Islands';
$countryname['SS'] = 'South Sudan';
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
$howfoundpeoplesname['70'] = 'Referral from Partnership Institution';

$whatlearnname['10'] = 'I want to improve my knowledge of public health';
$whatlearnname['20'] = 'I want to improve my academic skills';
$whatlearnname['30'] = 'I want to improve my skills in research';
$whatlearnname['40'] = 'I am not sure';

$whylearnname['10'] = 'I want to apply what I learn to my current/future work';
$whylearnname['20'] = 'I want to improve my career opportunities';
$whylearnname['30'] = 'I want to get academic credit';
$whylearnname['40'] = 'I am not sure';

$whyelearningname['10'] = 'I want to meet and learn with people from other countries';
$whyelearningname['20'] = 'I want the opportunity to be flexible about my study time';
$whyelearningname['30'] = 'I want a public health training that is affordable';
$whyelearningname['40'] = 'I am not sure';

$howuselearningname['10'] = 'Share knowledge skills with other colleagues';
$howuselearningname['20'] = 'Start a new project';
$howuselearningname['30'] = 'I am not sure';


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
if (!empty($_POST['markchangeemail']) && !empty($_POST['email'])) {
  $_POST['email'] = trim($_POST['email']);

  updateapplication($_POST['id'], 'email', $_POST['email']);

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


$application = $DB->get_record('peoplesregistration', array('id' => $_REQUEST['id']));

$sid = $_REQUEST['id'];
$state = (int)$application->state;

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
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', $application->applicationaddress)) . "</td>";
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
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', $application->currentjob)) . "</td>";
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
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', $application->education)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Reasons for wanting to enrol</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', $application->reasons)) . "</td>";
echo "</tr>";

echo '<tr>';
echo '<td>What do you want to learn?</td>';
$z = '';
$arrayvalues = explode(',', $application->whatlearn);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $whatlearnname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Why do you want to learn?</td>';
$z = '';
$arrayvalues = explode(',', $application->whylearn);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $whylearnname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>What are the reasons you want to do an e-learning course?</td>';
$z = '';
$arrayvalues = explode(',', $application->whyelearning);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $whyelearningname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>How will you use your new knowledge and skills to improve population health?</td>';
$z = '';
$arrayvalues = explode(',', $application->howuselearning);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $howuselearningname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Sponsoring organisation</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', $application->sponsoringorganisation)) . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>How heard about Peoples-uni</td>';
if (empty($howfoundpeoplesname[$application->howfoundpeoples])) echo "<td></td>";
else echo "<td>" . $howfoundpeoplesname[$application->howfoundpeoples] . "</td>";
echo '</tr>';
echo '<tr>';
echo '<td>Name of the organisation or person from whom you heard about Peoples-uni</td>';
echo '<td>' . $application->howfoundorganisationname . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Desired Moodle Username</td>';
echo '<td>' . htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8') . '</td>';
echo '</tr>';
if (!empty($application->userid)) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/student.php?id=' . $application->userid . '" target="_blank">Student Grades</a></td></tr>';
if (!empty($application->userid)) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $application->userid . '" target="_blank">Student Submissions</a></td></tr>';
echo '</table>';

if ($state === 0) {
  $given_name = $application->firstname;

  $peoples_register_email = get_config(NULL, 'peoples_register_email');

  $peoples_register_email = str_replace('GIVEN_NAME_HERE', $given_name, $peoples_register_email);
  $peoples_register_email = str_replace('FPH_ID_HERE', get_config(NULL, 'foundations_public_health_id'), $peoples_register_email);

  $peoples_register_email = htmlspecialchars($peoples_register_email, ENT_COMPAT, 'UTF-8');

?>
<br />To Register this Student and send an e-mail to Student (edit e-mail text if you wish), press "Register Student".
<form id="approveapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/regaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<textarea name="approvedtext" rows="15" cols="75" wrap="hard">
<?php echo $peoples_register_email; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapproveapplication" value="1" />
<input type="submit" name="approveapplication" value="Register Student" />
</form>
<br />

<?php
}
else {
  echo '<span style="color:green">This Student is Registered.</span><br />';
}

?>
<br />To send an e-mail to this Student (EDIT the e-mail text below!), press "e-mail Student".
<form id="deferapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/regaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<textarea name="defertext" rows="10" cols="75" wrap="hard">
Dear <?php echo htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8'); ?>,


     Peoples Open Access Education Initiative Administrator.
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeferapplication" value="1" />
<input type="submit" name="deferapplication" value="e-mail Student" />
</form>
<br />
<?php

if (!empty($application->userid)) {
  $userrecord = $DB->get_record('user', array('id' => ($application->userid)));
}
elseif (!empty($application->username)) {
  $userrecord = $DB->get_record('user', array('username' => ($application->username)));
}
if (!empty($userrecord)) {
  if (empty($application->userid)) {
    echo "<strong>This Student has not been Registered but there is already a Moodle user with the Username: '" . htmlspecialchars($userrecord->username, ENT_COMPAT, 'UTF-8') . "'...</strong>";
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
  if (empty($application->userid)) {
?>

<br />Enter a new suggested user name here (maybe add "1" at the end of the existing name) and then press "Update Username" (you will need to come back to this page to register them).
<form id="appusernameform" method="post" action="<?php echo $CFG->wwwroot . '/course/regaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdateusername" value="1" />
<input type="submit" name="updateusername" value="Update Username to:" style="width:40em" />
<input type="text" size="40" name="username" value="<?php echo htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br /><br />
<?php
  }
}
else {
?>
No Moodle user with the Username: '<?php echo htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8'); ?>'<br /><br /><br />
<?php
}

if ($state === 0 && empty($application->userid)) { // Allow applicant e-mail to be changed
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/reg.php'; ?>">
<input type="hidden" name="id" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markchangeemail" value="1" />
<input type="submit" name="changeemail" value="Change Applicant e-mail to:" style="width:40em" />

<input type="text" size="40" name="email" value="<?php echo htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br />
<?php
}


echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';

?>
<br /><br /><br /><br /><br /><br /><br /><br />
<form id="deleteentryform" method="post" action="<?php echo $CFG->wwwroot . '/course/regaction.php'; ?>" onSubmit="return areyousuredeleteentry()">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeleteentry" value="1" />
<input type="submit" name="deleteentry" value="Hide this Application Form Entry from All Future Processing" style="width:40em" />
</form>
<?php

echo $OUTPUT->footer();


function updateapplication($sid, $field, $value) {
  global $DB;

  $record = $DB->get_record('peoplesregistration', array('id' => $sid));
  $application = new object();
  $application->id = $record->id;
  $application->{$field} = $value;

  $DB->update_record('peoplesregistration', $application);
}
?>
