<?php  // $Id: interest.php,v 1.1 2008/10/24 10:52:00 alanbarrett Exp $
/**
*
* List all Expressions of Interest in Peoples-Uni from Drupal
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

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/interest_old.php'); // Defined here to avoid notices on errors etc


if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/interest_old.php?'
    . 'chosenstartyear=' . $_POST['chosenstartyear']
    . '&chosenstartmonth=' . $_POST['chosenstartmonth']
    . '&chosenstartday=' . $_POST['chosenstartday']
    . '&chosenendyear=' . $_POST['chosenendyear']
    . '&chosenendmonth=' . $_POST['chosenendmonth']
    . '&chosenendday=' . $_POST['chosenendday']
    . '&chosensearch=' . urlencode(dontstripslashes($_POST['chosensearch']))
    );
}


$PAGE->set_pagelayout('embedded');

require_login();

//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Expressions of Interest');
$PAGE->set_heading('Expressions of Interest');
echo $OUTPUT->header();


$rows = $DB->get_recordset_sql('SELECT s.*, sd.cid, sd.no, sd.data FROM d5_webform_submitted_data AS sd LEFT JOIN d5_webform_submissions AS s ON sd.sid=s.sid WHERE s.nid=104 ORDER BY s.submitted DESC');

foreach ($rows as $row) {

  $registrations[$row->sid]['submitted'] = $row->submitted;
  $registrations[$row->sid][$row->cid] = $row->data;
}
$rows->close();

if (empty($registrations)) {
  $registrations = array();
}


echo '<h1>Expressions of Interest</h1>';

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
if (!empty($_REQUEST['chosensearch'])) $chosensearch = dontstripslashes($_REQUEST['chosensearch']);
else $chosensearch = '';

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
<form method="post" action="<?php echo $CFG->wwwroot . '/course/interest_old.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Start Year</td>
    <td>Start Month</td>
    <td>Start Day</td>
    <td>End Year</td>
    <td>End Month</td>
    <td>End Day</td>
    <td>Name or e-mail Contains</td>
  </tr>
  <tr>
    <?php
    displayoptions('chosenstartyear', $liststartyear, $chosenstartyear);
    displayoptions('chosenstartmonth', $liststartmonth, $chosenstartmonth);
    displayoptions('chosenstartday', $liststartday, $chosenstartday);
    displayoptions('chosenendyear', $listendyear, $chosenendyear);
    displayoptions('chosenendmonth', $listendmonth, $chosenendmonth);
    displayoptions('chosenendday', $listendday, $chosenendday);
    ?>
    <td><input type="text" size="40" name="chosensearch" value="<?php echo htmlspecialchars($chosensearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
  </tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/interest_old.php">Reset Filters</a>
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


$emaildups = 0;
foreach ($registrations as $sid => $registration) {
  if (empty($registration['3'])) $registration['3'] = '';
  $registration['3'] = strip_tags($registration['3']);

  if (empty($registration['9'])) $registration['9'] = '';
  if (substr($registration['9'], 0, 6) === 'HIDDEN') {
    unset($registrations[$sid]);
    continue;
  }

  if ($registration['submitted'] < $starttime ||
    $registration['submitted'] > $endtime) {

    unset($registrations[$sid]);
    continue;
  }

  if (empty($registration['6'])) $registration['6'] = '';
  if (empty($registration['7'])) $registration['7'] = '';

  if (!empty($chosensearch) &&
  stripos($registration['3'], $chosensearch) === false &&
    stripos($registration['6'], $chosensearch) === false &&
    stripos($registration['7'], $chosensearch) === false) {

    unset($registrations[$sid]);
    continue;
  }

  if (empty($emailcounts[$registration['3']])) {
    $emailcounts[$registration['3']] = 1;
    $listofemails[]  = htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8');
  }
  else {
    $emailcounts[$registration['3']]++;
    $emaildups++;
  }
}

$table = new html_table();

$table->head = array(
  'Submitted',
  '',
  'Family name',
  'Given name',
  'Email address',
  'First module',
  'Second module',
  'Suggestions',
  'Country',
  'e-mail sent?',
  'Comment'
);

$n = 0;

$modules = array();
foreach ($registrations as $sid => $registration) {

// Family name:		6
// Given name:		7
// Email address:	3
// First module:	1
// Second module:	2
// suggestions:		11
// Country:			8
// state:			10
// comment:			9

  if (empty($registration['1'])) $registration['1'] = '';
  if (empty($registration['2'])) $registration['2'] = '';
  if (empty($registration['3'])) $registration['3'] = '';
  if (empty($registration['6'])) $registration['6'] = '';
  if (empty($registration['7'])) $registration['7'] = '';
  if (empty($registration['8'])) $registration['8'] = '';
  if (empty($registration['9'])) $registration['9'] = '';
  if (empty($registration['10'])) $registration['10'] = '0';

  $registration['3'] = strip_tags($registration['3']);
  $registration['6'] = strip_tags($registration['6']);
  $registration['7'] = strip_tags($registration['7']);
  $registration['9'] = strip_tags($registration['9']);

  $registration['6'] = mb_substr($registration['6'], 0, 100, 'UTF-8');
  $registration['7'] = mb_substr($registration['7'], 0, 100, 'UTF-8');

  $rowdata = array();

  $rowdata[] = gmdate('d/m/Y H:i', $registration['submitted']);

  $z  = '<form method="post" action="' . $CFG->wwwroot . '/course/int_old.php" target="_blank">';
  $z .= '<input type="hidden" name="familyname" value="' . htmlspecialchars($registration['6'], ENT_COMPAT, 'UTF-8') . '" />';
  $z .= '<input type="hidden" name="givenname"  value="' . htmlspecialchars($registration['7'], ENT_COMPAT, 'UTF-8') . '" />';
  $z .= '<input type="hidden" name="email"      value="' . htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8') . '" />';
  $z .= '<span style="display: none;">';
  $z .= '<textarea name="comment" rows="10" cols="100" wrap="hard">' . htmlspecialchars($registration['9'], ENT_COMPAT, 'UTF-8') . '</textarea>';
  $z .= '</span>';
  $z .= '<input type="hidden" name="state"      value="' . $registration['10'] . '" />';
  $z .= '<input type="hidden" name="sid"        value="' . $sid                . '" />';
  $z .= '<input type="hidden" name="sesskey"    value="' . $USER->sesskey      . '" />';
  $z .= '<input type="hidden" name="markapp" value="1" />';
  $z .= '<input type="submit" name="approveapplication" value="e-mail" />';
  $z .= '</form>';
  $rowdata[] = $z;

  $rowdata[] = htmlspecialchars($registration['6'], ENT_COMPAT, 'UTF-8');

  $rowdata[] = htmlspecialchars($registration['7'], ENT_COMPAT, 'UTF-8');

  if ($emailcounts[$registration['3']] === 1) {
    $rowdata[] = htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8');
  }
	else {
    $rowdata[] = '<span style="color:navy">**</span>' . htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8');
	}

  $rowdata[] = htmlspecialchars($registration['1'], ENT_COMPAT, 'UTF-8');

  $rowdata[] = htmlspecialchars($registration['2'], ENT_COMPAT, 'UTF-8');

  $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['11'], ENT_COMPAT, 'UTF-8')));

  if (empty($countryname[$registration['8']])) $rowdata[] = '';
  else $rowdata[] = $countryname[$registration['8']];

  if (empty($registration['10'])) $rowdata[] = '';
  else $rowdata[] = 'Yes';

  $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['9'], ENT_COMPAT, 'UTF-8')));

  if (empty($modules[$registration['1']])) {
    $modules[$registration['1']] = 1;
  }
  else {
    $modules[$registration['1']]++;
  }
  if (!empty($registration['2'])) {
    if (empty($modules[$registration['2']])) {
      $modules[$registration['2']] = 1;
    }
    else {
      $modules[$registration['2']]++;
    }
  }

  $n++;
  $table->data[] = $rowdata;
}
echo html_writer::table($table);

echo '<br />Total Expressions of Interest: ' . $n;
echo '<br /><br />(Duplicated e-mails: ' . $emaildups . ',  see <span style="color:navy">**</span>)';
echo '<br/><br/>';

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";
echo "<td>Module</td>";
echo "<td>Number of Expressions of Interest</td>";
echo "</tr>";

ksort($modules);

$n = 0;

foreach ($modules as $product => $number) {
  echo "<tr>";
  echo "<td>" . $product . "</td>";
  echo "<td>" . $number . "</td>";
  echo "</tr>";

  $n++;
}
echo '</table>';
echo '<br />Number of Modules: ' . $n . '<br /><br />';

natcasesort($listofemails);
echo 'e-mails of those who have Expressed an Interest...<br />' . implode(', ', array_unique($listofemails));

echo '<br /><br /><br />';

echo $OUTPUT->footer();


function dontstripslashes($x) {
  return $x;
}
?>
