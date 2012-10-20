<?php  // $Id: registrations.php,v 1.1 2012/12/18 12:24:32 alanbarrett Exp $
/**
*
* List all Registration applications
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

$PAGE->set_url('/course/registrations.php'); // Defined here to avoid notices on errors etc

if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/registrations.php?'
    . '&chosenstatus=' . urlencode($_POST['chosenstatus'])
    . '&chosenstartyear=' . $_POST['chosenstartyear']
    . '&chosenstartmonth=' . $_POST['chosenstartmonth']
    . '&chosenstartday=' . $_POST['chosenstartday']
    . '&chosenendyear=' . $_POST['chosenendyear']
    . '&chosenendmonth=' . $_POST['chosenendmonth']
    . '&chosenendday=' . $_POST['chosenendday']
    . '&chosensearch=' . urlencode($_POST['chosensearch'])
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


$PAGE->set_pagelayout('embedded');   // Needs as much space as possible


require_login();

// Access to registrations.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Student Registrations');
$PAGE->set_heading('Student Registrations');
echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


echo "<h1>Student Registrations</h1>";

if (!empty($_REQUEST['chosenstatus'])) $chosenstatus = $_REQUEST['chosenstatus'];
if (!empty($_REQUEST['chosenstartyear']) && !empty($_REQUEST['chosenstartmonth']) && !empty($_REQUEST['chosenstartday'])) {
  $chosenstartyear = (int)$_REQUEST['chosenstartyear'];
  $chosenstartmonth = (int)$_REQUEST['chosenstartmonth'];
  $chosenstartday = (int)$_REQUEST['chosenstartday'];
  $starttime = gmmktime(0, 0, 0, $chosenstartmonth, $chosenstartday, $chosenstartyear);
}
else {
  $starttime = 0;
}
if (!empty($_REQUEST['chosenendyear']) && !empty($_REQUEST['chosenendmonth']) && !empty($_REQUEST['chosenendday'])) {
  $chosenendyear = (int)$_REQUEST['chosenendyear'];
  $chosenendmonth = (int)$_REQUEST['chosenendmonth'];
  $chosenendday = (int)$_REQUEST['chosenendday'];
  $endtime = gmmktime(24, 0, 0, $chosenendmonth, $chosenendday, $chosenendyear);
}
else {
  $endtime = 1.0E+20;
}
if (!empty($_REQUEST['chosensearch'])) $chosensearch = $_REQUEST['chosensearch'];
else $chosensearch = '';
if (!empty($_REQUEST['displayextra'])) $displayextra = true;
else $displayextra = false;

$liststatus[] = 'All';
if (!isset($chosenstatus)) $chosenstatus = 'All';
$liststatus[] = 'Not Registered';
$liststatus[] = 'Registered';

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
<form method="post" action="<?php echo $CFG->wwwroot . '/course/registrations.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Status</td>
    <td>Start Year</td>
    <td>Start Month</td>
    <td>Start Day</td>
    <td>End Year</td>
    <td>End Month</td>
    <td>End Day</td>
    <td>Name or e-mail Contains</td>
    <td>Show Extra Details</td>
  </tr>
  <tr>
    <?php
    displayoptions('chosenstatus', $liststatus, $chosenstatus);
    displayoptions('chosenstartyear', $liststartyear, $chosenstartyear);
    displayoptions('chosenstartmonth', $liststartmonth, $chosenstartmonth);
    displayoptions('chosenstartday', $liststartday, $chosenstartday);
    displayoptions('chosenendyear', $listendyear, $chosenendyear);
    displayoptions('chosenendmonth', $listendmonth, $chosenendmonth);
    displayoptions('chosenendday', $listendday, $chosenendday);
    ?>
    <td><input type="text" size="40" name="chosensearch" value="<?php echo htmlspecialchars($chosensearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <td><input type="checkbox" name="displayextra" <?php if ($displayextra) echo ' CHECKED'; ?>></td>
  </tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/registrations.php">Reset Filters</a>
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


$applications = $DB->get_records_sql('
  SELECT a.*
  FROM mdl_peoplesregistration a
  WHERE hidden=0 ORDER BY a.datesubmitted DESC');
if (empty($applications)) {
  $applications = array();
}

$email_already_in_moodle = $DB->get_records_sql('
  SELECT a.id
  FROM mdl_peoplesregistration a
  LEFT JOIN mdl_user u ON a.email=u.email
  WHERE a.state=0 AND a.hidden=0 AND u.id IS NOT NULL');
if (empty($email_already_in_moodle)) {
  $email_already_in_moodle = array();
}

$emaildups = 0;
foreach ($applications as $sid => $application) {
  $state = (int)$application->state;

  if (
    $application->datesubmitted < $starttime ||
    $application->datesubmitted > $endtime ||
    (($chosenstatus  === 'Not Registered') && ($state !== 0)) ||
    (($chosenstatus  === 'Registered')     && ($state === 0))
    ) {

    unset($applications[$sid]);
    continue;
  }

  if (!empty($chosensearch) &&
    stripos($application->lastname, $chosensearch) === false &&
    stripos($application->firstname, $chosensearch) === false &&
    stripos($application->email, $chosensearch) === false) {

    unset($applications[$sid]);
    continue;
  }

  if ($application->hidden) {
    unset($applications[$sid]);
    continue;
  }

  if (empty($emailcounts[$application->email])) $emailcounts[$application->email] = 1;
  else {
    $emailcounts[$application->email]++;
    $emaildups++;
  }
}


if ($sendemails) {
  if (empty($_POST['reg'])) $_POST['reg'] = '/^[a-zA-Z0-9_.-]/';
  sendemails($applications, strip_tags($_POST['emailsubject']), strip_tags($_POST['emailbody']), $_POST['reg']);
}


$table = new html_table();

if (!$displayextra) {
  $table->head = array(
    'Submitted',
    'Registered?',
    '',
    'Family name',
    'Given name',
    'Email address',
    'DOB dd/mm/yyyy',
    'Gender',
    'City/Town',
    'Country',
  );
}
else {
  $table->head = array(
    'Submitted',
    'Registered?',
    'Family name',
    'Given name',
    'Email address',
    'DOB dd/mm/yyyy',
    'Gender',
    'City/Town',
    'Country',
    'Address',
    'Current employment',
    'Current employment details',
    'Qualification',
    'Postgraduate Qualification',
    'Education Details',
    'Reasons for wanting to enrol',
    'What do you want to learn?',
    'Why do you want to learn?',
    'What are the reasons you want to do an e-learning course?',
    'How will you use your new knowledge and skills to improve population health?',
    'Sponsoring organisation',
    'How heard about Peoples-uni',
    'Name of the organisation or person from whom you heard about Peoples-uni',
    'Desired Moodle Username',
    'Moodle UserID'
  );
}

$n = 0;
$nregistered = 0;

$modules = array();
foreach ($applications as $sid => $application) {
  $state = (int)$application->state;

  $application->userid = (int)$application->userid;

  $rowdata = array();
  $rowdata[] = gmdate('d/m/Y H:i', $application->datesubmitted);

  if ($state === 0) $z = '<span style="color:red">No</span>';
  else $z = '<span style="color:green">Yes</span>';
  $rowdata[] = $z;

  if (!$displayextra) {
    $z  = '<form method="post" action="' .  $CFG->wwwroot . '/course/reg.php" target="_blank">';

    $z .= '<input type="hidden" name="id" value="' . $application->id . '" />';
    $z .= '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
    $z .= '<input type="hidden" name="markapp" value="1" />';
    $z .= '<input type="submit" name="approveapplication" value="Details" />';

    $z .= '</form>';
    $rowdata[] = $z;
  }

  $rowdata[] = htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8');

  $rowdata[] = htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8');

  if (!empty($email_already_in_moodle[$sid])) $inmoodle = '<span style="color:red">**</span>';
  else  $inmoodle = '';
  if ($emailcounts[$application->email] === 1) {
    $z = $inmoodle . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
  }
  else {
    $z = '<span style="color:navy">**</span>' . $inmoodle . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
  }
  $rowdata[] = $z;

  $rowdata[] = $application->dobday . '/' . $application->dobmonth . '/' . $application->dobyear;

  $rowdata[] = $application->gender;

  $rowdata[] = htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8');

  if (empty($countryname[$application->country])) $z = '';
  else $z = $countryname[$application->country];
  $rowdata[] = $z;

  if ($displayextra) {
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->applicationaddress));

    if (empty($employmentname[$application->employment])) $z = '';
    else $z = $employmentname[$application->employment];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->currentjob));

    if (empty($qualificationname[$application->qualification])) $z = '';
    else $z = $qualificationname[$application->qualification];
    $rowdata[] = $z;

    if (empty($higherqualificationname[$application->higherqualification])) $z = '';
    else $z = $higherqualificationname[$application->higherqualification];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->education));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->reasons));

    $z = '';
    $arrayvalues = explode(',', $application->whatlearn);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $whatlearnname[$v] . '<br />';
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $application->whylearn);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $whylearnname[$v] . '<br />';
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $application->whyelearning);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $whyelearningname[$v] . '<br />';
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $application->howuselearning);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $howuselearningname[$v] . '<br />';
    }
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->sponsoringorganisation));

    if (empty($howfoundpeoplesname[$application->howfoundpeoples])) $z = '';
    else $z = $howfoundpeoplesname[$application->howfoundpeoples];
    $rowdata[] = $z;

    $rowdata[] = $application->howfoundorganisationname;

    $rowdata[] = htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8');

    if (empty($application->userid)) $z = '';
    else $z = $application->userid;
    $rowdata[] = $z;
  }


  $n++;

  if ($state !== 0) {
    $nregistered++;

    if (empty($gender[$application->gender])) {
      $gender[$application->gender] = 1;
    }
    else {
      $gender[$application->gender]++;
    }

    if (empty($application->dobyear)) $range = '';
    elseif ($application->dobyear >= 1990) $range = '1990+';
    elseif ($application->dobyear >= 1980) $range = '1980-1989';
    elseif ($application->dobyear >= 1970) $range = '1970-1979';
    elseif ($application->dobyear >= 1960) $range = '1960-1969';
    elseif ($application->dobyear >= 1950) $range = '1950-1959';
    else $range = '1900-1950';
    if (empty($age[$range])) {
      $age[$range] = 1;
    }
    else {
      $age[$range]++;
    }

    if (empty($country[$countryname[$application->country]])) {
      $country[$countryname[$application->country]] = 1;
    }
    else {
      $country[$countryname[$application->country]]++;
    }

    if (empty($howfoundpeoples[$howfoundpeoplesname[$application->howfoundpeoples]])) {
      $howfoundpeoples[$howfoundpeoplesname[$application->howfoundpeoples]] = 1;
    }
    else {
      $howfoundpeoples[$howfoundpeoplesname[$application->howfoundpeoples]]++;
    }

    $listofemails[]  = htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
  }

  $table->data[] = $rowdata;
}
echo html_writer::table($table);

echo '<br />Total Applications: ' . $n;
echo '<br />Total Registered: ' . $nregistered;
echo '<br /><br />(Duplicated e-mails: ' . $emaildups . ',  see <span style="color:navy">**</span>)';
echo '<br /><br />(If a Moodle user already has this e-mail then it will be marked with <span style="color:red">**</span>.<br />
In that case the student is probably already in Moodle and should not be registered.)';
echo '<br/><br/>';


natcasesort($listofemails);
echo 'e-mails of Registered Students...<br />' . implode(', ', array_unique($listofemails)) . '<br /><br />';

echo 'Statistics for Registered Students...<br />';
displaystat($gender, 'Gender');
displaystat($age, 'Year of Birth');
displaystat($country, 'Country');
displaystat($howfoundpeoples, 'How heard about Peoples-uni');


$peoples_batch_registration_email = get_config(NULL, 'peoples_batch_registration_email');

$peoples_batch_registration_email = htmlspecialchars($peoples_batch_registration_email, ENT_COMPAT, 'UTF-8');
?>
<br />To send an e-mail to all the students in the main spreadsheet above...
enter BOTH a subject and optionally edit the e-mail text below and click "Send e-mail to All".<br />
<br />
NOTE, to send an e-mail only to registered students... BEFORE SENDING THE E_MAIL,
set the filters at the top of this page as follows...<br />
Status: "Registered"<br />
Start Year: As desired<br />
Start Month: As desired<br />
<br />
Also look at list of e-mails sent to verify they went! (No subject and they will not go!)<br /><br />
<form id="emailsendform" method="post" action="<?php
  if (!empty($_REQUEST['chosenstatus'])) {
    echo $CFG->wwwroot . '/course/registrations.php?'
      . '&chosenstatus=' . urlencode($_REQUEST['chosenstatus'])
      . '&chosenstartyear=' . $_REQUEST['chosenstartyear']
      . '&chosenstartmonth=' . $_REQUEST['chosenstartmonth']
      . '&chosenstartday=' . $_REQUEST['chosenstartday']
      . '&chosenendyear=' . $_REQUEST['chosenendyear']
      . '&chosenendmonth=' . $_REQUEST['chosenendmonth']
      . '&chosenendday=' . $_REQUEST['chosenendday']
      . '&chosensearch=' . urlencode($_REQUEST['chosensearch'])
      . (empty($_REQUEST['displayextra']) ? '&displayextra=0' : '&displayextra=1');
  }
  else {
    echo $CFG->wwwroot . '/course/registrations.php';
  }
?>">
Subject:&nbsp;<input type="text" size="75" name="emailsubject" /><br />
<textarea name="emailbody" rows="15" cols="75" wrap="hard">
<?php echo $peoples_batch_registration_email; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markemailsend" value="1" />
<input type="submit" name="emailsend" value="Send e-mail to All" />
<br />Regular expression for included e-mails (defaults to all, so do not change!):&nbsp;<input type="text" size="20" name="reg" value="/^[a-zA-Z0-9_.-]/" />
</form>
<br /><br />
<?php


echo '<br /><br />';

//echo html_writer::end_tag('div');

echo $OUTPUT->footer();


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


function sendemails($applications, $emailsubject, $emailbody, $reg) {

  echo '<br />';
  $i = 1;
  foreach ($applications as $sid => $application) {

    $email = trim($application->email);

    if (!preg_match($reg, $email)) {
      echo "&nbsp;&nbsp;&nbsp;&nbsp;($email skipped because of regular expression.)<br />";
      continue;
    }

    $emailbodytemp = str_replace('GIVEN_NAME_HERE', trim($application->firstname), $emailbody);

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
  $user = new stdClass();
  $user->id = 999999999;
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->email = 'apply@peoples-uni.org';
  $supportuser->firstname = 'Peoples-Uni Support';
  $supportuser->lastname = '';
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  $user->email = 'applicationresponses@peoples-uni.org';

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}
?>
