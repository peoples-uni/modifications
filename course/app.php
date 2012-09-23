<?php  // $Id: app.php,v 1.1 2008/08/02 17:18:32 alanbarrett Exp $
/**
*
* List a single course application from Drupal
*
*/

define('MODULE_COST', 30);


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

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/app.php'); // Defined here to avoid notices on errors etc

//$PAGE->set_pagelayout('embedded');   // Needs as much space as possible
//$PAGE->set_pagelayout('base');     // Most backwards compatible layout without the blocks - this is the layout used by default
$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();

//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Student Details');
$PAGE->set_heading('Details for '. htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8') . ', ' . htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();

//print_header('Student Details');

if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');


echo '<script type="text/JavaScript">function areyousureunapp1() { var sure = false; sure = confirm("Are you sure you want to Un-Approve and possibly Un-Enrol ' . htmlspecialchars(dontstripslashes($_REQUEST['2']), ENT_COMPAT, 'UTF-8') . ' ' . htmlspecialchars(dontstripslashes($_REQUEST['1']), ENT_COMPAT, 'UTF-8') . ' from ' . htmlspecialchars(dontstripslashes($_REQUEST['18']), ENT_COMPAT, 'UTF-8') . '?"); return sure;}</script>';
echo '<script type="text/JavaScript">function areyousureunapp2() { var sure = false; sure = confirm("Are you sure you want to Un-Approve and possibly Un-Enrol ' . htmlspecialchars(dontstripslashes($_REQUEST['2']), ENT_COMPAT, 'UTF-8') . ' ' . htmlspecialchars(dontstripslashes($_REQUEST['1']), ENT_COMPAT, 'UTF-8') . ' from ' . htmlspecialchars(dontstripslashes($_REQUEST['19']), ENT_COMPAT, 'UTF-8') . '?"); return sure;}</script>';
echo '<script type="text/JavaScript">function areyousuredeleteentry() { var sure = false; sure = confirm("Are you sure you want to Hide this Application Form Entry for ' . htmlspecialchars(dontstripslashes($_REQUEST['2']), ENT_COMPAT, 'UTF-8') . ' ' . htmlspecialchars(dontstripslashes($_REQUEST['1']), ENT_COMPAT, 'UTF-8') . ' from All Future Processing?"); return sure;}</script>';


$activemodules = $DB->get_records('activemodules', NULL, 'fullname ASC');

$modules = array();
foreach ($activemodules as $activemodule) {
	$modules[] = $activemodule->fullname;
}


$refreshparent = false;
if (!empty($_POST['markapp1'])) {

	updateapplication($_POST['sid'], 'state', $_POST['state'], 1);

	$refreshparent = true;
}
if (!empty($_POST['markapp2'])) {

	updateapplication($_POST['sid'], 'state', $_POST['state'], 1);

	$refreshparent = true;
}
if (!empty($_POST['markunapp1'])) {

	updateapplication($_POST['sid'], 'state', $_POST['state'], -1);

	$refreshparent = true;
	if (!empty($_POST['29']) && !empty($_POST['18'])) {
		unenrolstudent($_POST['29'], $_POST['18']);
	}
}
if (!empty($_POST['markunapp2'])) {

	updateapplication($_POST['sid'], 'state', $_POST['state'], -1);

	$refreshparent = true;
	if (!empty($_POST['29']) && !empty($_POST['19'])) {
		unenrolstudent($_POST['29'], $_POST['19']);
	}
}
if (!empty($_POST['change1'])) {

	updateapplication($_POST['sid'], 'coursename1', $_REQUEST['18']);

	$refreshparent = true;
}
if (!empty($_POST['change2'])) {

	updateapplication($_POST['sid'], 'coursename2', $_REQUEST['19']);

	$refreshparent = true;
}
if (!empty($_POST['add2newapproved'])) {

  updateapplication($_POST['sid'], 'coursename2', $_REQUEST['19'], 1); // 1 => Need to increase payment for new approved module

  $refreshparent = true;
}
if (!empty($_POST['markreadyenrol'])) {

  updateapplication($_POST['sid'], 'ready', 1);

  $refreshparent = true;
}
if (!empty($_POST['markmph'])) {
  if (!empty($_REQUEST['29'])) $useridforsearch = $_REQUEST['29'];
  else $useridforsearch = 0;
  if (!empty($_REQUEST['sid'])) $sidforsearch = $_REQUEST['sid'];
  else  $sidforsearch = 0;
  $inmmumph = FALSE;
  $mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE (sid=$sidforsearch AND sid!=0) OR (userid=$useridforsearch AND userid!=0)");
  if (!empty($mphs)) {
    foreach ($mphs as $mph) {
      $inmmumph = TRUE;
    }
  }
  if (!$inmmumph) { // Protect against duplicate submission

    $newmph = new object();
    if (!empty($_REQUEST['29']))  $newmph->userid = $_REQUEST['29'];
    if (!empty($_REQUEST['sid'])) $newmph->sid    = $_REQUEST['sid'];

    $newmph->datesubmitted = time();
    $newmph->mphstatus = 1;
    $newmph->note = '';
    $DB->insert_record('peoplesmph', $newmph);

    if (!empty($newmph->userid)) {

      $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $newmph->userid));
      if (!empty($peoplesmph2)) {
        $peoplesmph2->datesubmitted = $newmph->datesubmitted;
        $peoplesmph2->mphstatus = $newmph->mphstatus;
        $peoplesmph2->note = $peoplesmph2->note . '<br />Enrolled in MPH: ' . gmdate('d/m/Y H:i', $newmph->datesubmitted);
        $DB->update_record('peoplesmph2', $peoplesmph2);
      }
      else {
        $peoplesmph2 = new object();
        $peoplesmph2->userid = $newmph->userid;
        $peoplesmph2->datesubmitted = $newmph->datesubmitted;
        $peoplesmph2->datelastunentolled = 0;
        $peoplesmph2->mphstatus = $newmph->mphstatus;
        $peoplesmph2->note = 'Enrolled in MPH: ' . gmdate('d/m/Y H:i', $newmph->datesubmitted);
        $DB->insert_record('peoplesmph2', $peoplesmph2);
      }

      $amount_to_pay_total = get_balance($newmph->userid);

      $peoples_student_balance = new object();
      $peoples_student_balance->userid = $newmph->userid;
      $peoples_student_balance->amount_delta = 1500;
      $peoples_student_balance->balance = $amount_to_pay_total + $peoples_student_balance->amount_delta;
      $peoples_student_balance->currency = 'GBP';
      $peoples_student_balance->detail = 'Initial Full amount for MMU MPH';
      $peoples_student_balance->date = time();
      $DB->insert_record('peoples_student_balance', $peoples_student_balance);
    }

    $refreshparent = true;
  }
}
if (!empty($_POST['markunenrollmph'])) {
  if (!empty($_REQUEST['29'])) {
    $peoplesmph2userid = $_REQUEST['29'];

    $DB->delete_records('peoplesmph', array('userid' => $peoplesmph2userid))

    $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $peoplesmph2userid));
    if (!empty($peoplesmph2)) {
      $peoplesmph2->datelastunentolled = time();
      $peoplesmph2->mphstatus = 0;
      $peoplesmph2->note = $peoplesmph2->note . '<br />Unenrolled from MPH: ' . gmdate('d/m/Y H:i', $peoplesmph2->datelastunentolled);
      $DB->update_record('peoplesmph2', $peoplesmph2);
    }

    $refreshparent = true;
  }
}
if (!empty($_POST['note']) && !empty($_POST['markaddnote'])) {
  $newnote = new object();
  if (!empty($_REQUEST['29']))  $newnote->userid = $_REQUEST['29'];
  if (!empty($_REQUEST['sid'])) $newnote->sid    = $_REQUEST['sid'];

  $newnote->datesubmitted = time();

  // textarea with hard wrap will send CRLF so we end up with extra CRs, so we should remove \r's for niceness
  $newnote->note = dontaddslashes(str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars(dontstripslashes($_POST['note']), ENT_COMPAT, 'UTF-8'))));
  $DB->insert_record('peoplesstudentnotes', $newnote);

  $refreshparent = true;
}
if (!empty($_POST['markchangeemail']) && !empty($_POST['11'])) {
  $_REQUEST['11'] = trim($_REQUEST['11']);

  updateapplication($_POST['sid'], 'email', $_REQUEST['11']);

  $refreshparent = true;
}
if (!empty($_POST['markaddnewmodule']) && !empty($_POST['newmodulename']) && !empty($_POST['29'])) {

  $user = $DB->get_record('user', array('id' => $_REQUEST['29']));

  $course = $DB->get_record('course', array('fullname' => $_POST['newmodulename']));

  enrolincourse($course, $user, $_REQUEST['16']);

  $teacher = get_peoples_teacher($course);

  $a->course = $course->fullname;
  $a->user = fullname($user);
  //$teacher->email = 'alanabarrett0@gmail.com';
  email_to_user($teacher, $user, get_string('enrolmentnew', 'enrol', $course->shortname), get_string('enrolmentnewuser', 'enrol', $a));

  updateapplication($_POST['sid'], 'dummyfieldname', 'dummyfieldvalue', 1);
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


$sid = $_REQUEST['sid'];

$application = $DB->get_record('peoplesapplication', array('sid' => $_REQUEST['sid']));

$inmmumph = FALSE;
$mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE (sid=$sid AND sid!=0) OR (userid={$application->userid} AND userid!=0) ORDER BY datesubmitted DESC");
if (!empty($mphs)) {
  foreach ($mphs as $mph) {
    $inmmumph = TRUE;
  }
}

$not_confirmed_text = '';

if (!empty($application->userid)) {
  $amount_to_pay_total = get_balance($application->userid);
  $payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $application->userid));
  $amount_to_pay_this_semester = amount_to_pay($application->userid);
  if (is_not_confirmed($application->userid)) $not_confirmed_text = ' (not confirmed)';
}
else {
  $amount_to_pay_total = 0;
  $amount_to_pay_this_semester = 0;
}


$state = (int)$_REQUEST['state'];
if ($state === 0) {
	$state = 022;
}
$state1 = $state & 07;
$state2 = $state & 070;

$_REQUEST['1'] = dontstripslashes($_REQUEST['1']);
$_REQUEST['2'] = dontstripslashes($_REQUEST['2']);
$_REQUEST['11'] = dontstripslashes($_REQUEST['11']);
$_REQUEST['16'] = dontstripslashes($_REQUEST['16']);
$_REQUEST['18'] = dontstripslashes($_REQUEST['18']);
$_REQUEST['19'] = dontstripslashes($_REQUEST['19']);
$_REQUEST['12'] = dontstripslashes($_REQUEST['12']);
$_REQUEST['3'] = dontstripslashes($_REQUEST['3']);
$_REQUEST['14'] = dontstripslashes($_REQUEST['14']);
$_REQUEST['13'] = dontstripslashes($_REQUEST['13']);
$_REQUEST['34'] = dontstripslashes($_REQUEST['34']);
$_REQUEST['35'] = dontstripslashes($_REQUEST['35']);
$_REQUEST['36'] = dontstripslashes($_REQUEST['36']);
$_REQUEST['7'] = dontstripslashes($_REQUEST['7']);
$_REQUEST['8'] = dontstripslashes($_REQUEST['8']);
$_REQUEST['10'] = dontstripslashes($_REQUEST['10']);
$_REQUEST['31'] = dontstripslashes($_REQUEST['31']);
$_REQUEST['32'] = dontstripslashes($_REQUEST['32']);
$_REQUEST['21'] = dontstripslashes($_REQUEST['21']);

$_REQUEST['1'] = strip_tags($_REQUEST['1']);
$_REQUEST['2'] = strip_tags($_REQUEST['2']);
$_REQUEST['11'] = strip_tags($_REQUEST['11']);
$_REQUEST['14'] = strip_tags($_REQUEST['14']);
$_REQUEST['13'] = strip_tags($_REQUEST['13']);
$_REQUEST['34'] = strip_tags($_REQUEST['34']);
$_REQUEST['35'] = strip_tags($_REQUEST['35']);
$_REQUEST['36'] = strip_tags($_REQUEST['36']);
$_REQUEST['21'] = strip_tags($_REQUEST['21']);


//echo "<h1>Details for ".htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8').", ".htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8')."</h1>";

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";

echo "<tr>";
echo "<td>Family name</td>";
echo "<td>" . htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Given name</td>";
echo "<td>" . htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Email address</td>";
echo "<td>" . htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Semester</td>";
echo "<td>" . htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>First module</td>";
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
echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8') . '</span></td>';
echo "</tr>";

echo "<tr>";
echo "<td>Second module</td>";
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
echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8') . '</span></td>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>DOB</td>";
echo "<td>" . $_REQUEST['dobday'] . "/" . $_REQUEST['dobmonth'] . "/" . $_REQUEST['dobyear'] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Gender</td>";
echo "<td>" . $_REQUEST['12'] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Address</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>City/Town</td>";
echo "<td>" . htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Country</td>";
if (empty($countryname[$_REQUEST['13']])) echo "<td></td>";
else echo "<td>" . $countryname[$_REQUEST['13']] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Current Employment</td>";
if (empty($employmentname[$_REQUEST['36']])) echo "<td></td>";
else echo "<td>" . $employmentname[$_REQUEST['36']] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Current Employment Details</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Higher Education Qualification</td>";
if (empty($qualificationname[$_REQUEST['34']])) echo "<td></td>";
else echo "<td>" . $qualificationname[$_REQUEST['34']] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Postgraduate Qualification</td>";
if (empty($higherqualificationname[$_REQUEST['35']])) echo "<td></td>";
else echo "<td>" . $higherqualificationname[$_REQUEST['35']] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Other relevant qualifications or educational experience</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Reasons for wanting to enrol</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";

echo '<tr>';
echo '<td>Sponsoring organisation</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'))) . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Scholarship</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'))) . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Why Not Completed Previous Semester</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'))) . '</td>';
echo '</tr>';

//echo "<tr>";
//echo "<td>Method of payment</td>";
//echo "<td>" . $_REQUEST['31'] . "</td>";
//echo "</tr>";
//echo "<tr>";
//echo "<td>Payment Identification</td>";
//echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'))) . "</td>";
//echo "</tr>";

echo '<tr>';
echo '<td>Desired Moodle Username</td>';
echo '<td>' . htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8') . '</td>';
echo '</tr>';

if (!empty($_REQUEST['29'])) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/student_completion.php?course=' . get_config(NULL, 'foundations_public_health_id') . '&userid=' . $_REQUEST['29'] . '" target="_blank">Student Foundations Public Health Completion</a></td></tr>';
if (!empty($_REQUEST['29'])) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/student.php?id=' . $_REQUEST['29'] . '" target="_blank">Student Grades</a></td></tr>';
if (!empty($_REQUEST['29'])) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $_REQUEST['29'] . '" target="_blank">Student Submissions</a></td></tr>';

echo '<tr>';
echo '<td>sid</td>';
echo '<td>' . $_REQUEST['sid'] . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Payment up to date? (amount owed includes modules already approved for this semester or any MPH instalments due this semester)</td>';
echo '<td>';
if ($amount_to_pay_this_semester >= .01) echo '<span style="color:red">No: &pound;' . $amount_to_pay_this_semester . ' Owed now' . $not_confirmed_text . '</span>';
elseif (abs($amount_to_pay_this_semester) < .01) echo '<span style="color:green">Yes' . $not_confirmed_text . '</span>';
else echo '<span style="color:blue">' . "Overpaid: &pound;$amount_to_pay_this_semester" . $not_confirmed_text . '</span>'; // Will never be Overpaid here because of function used
echo '<br /><a href="' . $CFG->wwwroot . '/course/payconfirm.php?sid=' . $_REQUEST['sid'] . '" target="_blank">Update Payment Amounts, Method or Confirmed Status</a>';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Total Payment Owed (might be more because of future instalments)</td>';
$neg_amount_to_pay_total = -$amount_to_pay_total;
if ($amount_to_pay_total >= .01) $x = '<span style="color:red">&pound;' . $amount_to_pay_total . '</span>';
elseif (abs($amount_to_pay_total) < .01) $x = '<span style="color:green">Nothing</span>';
else $x = '<span style="color:blue">' . "Overpaid: &pound;$neg_amount_to_pay_total" . '</span>';
echo '<td>' . $x;
echo '<br /><a href="' . $CFG->wwwroot . '/course/payconfirm.php?sid=' . $_REQUEST['sid'] . '" target="_blank">Update Payment Amounts, Method or Confirmed Status</a>';
echo '</td>';
echo '</tr>';

if (empty($application->paymentmechanism)) $mechanism = '';
elseif ($application->paymentmechanism == 1) $mechanism = 'RBS WorldPay Confirmed';
elseif ($application->paymentmechanism == 2) $mechanism = 'Barclays Bank Transfer';
elseif ($application->paymentmechanism == 3) $mechanism = 'Diamond Bank Transfer';
elseif ($application->paymentmechanism == 10) $mechanism = 'Ecobank Transfer';
elseif ($application->paymentmechanism == 4) $mechanism = 'Western Union';
elseif ($application->paymentmechanism == 5) $mechanism = 'Indian Confederation';
elseif ($application->paymentmechanism == 6) $mechanism = 'Promised End Semester';
elseif ($application->paymentmechanism == 7) $mechanism = 'Posted Travellers Cheques';
elseif ($application->paymentmechanism == 8) $mechanism = 'Posted Cash';
elseif ($application->paymentmechanism == 9) $mechanism = 'MoneyGram';
elseif ($application->paymentmechanism == 100) $mechanism = 'Waiver';
elseif ($application->paymentmechanism == 102) $mechanism = 'Barclays Bank Transfer Confirmed';
elseif ($application->paymentmechanism == 103) $mechanism = 'Diamond Bank Transfer Confirmed';
elseif ($application->paymentmechanism == 110) $mechanism = 'Ecobank Transfer Confirmed';
elseif ($application->paymentmechanism == 104) $mechanism = 'Western Union Confirmed';
elseif ($application->paymentmechanism == 105) $mechanism = 'Indian Confederation Confirmed';
elseif ($application->paymentmechanism == 107) $mechanism = 'Posted Travellers Cheques Confirmed';
elseif ($application->paymentmechanism == 108) $mechanism = 'Posted Cash Confirmed';
elseif ($application->paymentmechanism == 109) $mechanism = 'MoneyGram Confirmed';
else  $mechanism = '';

$pnote = '';
$paymentnotes = $DB->get_records_sql("SELECT * FROM mdl_peoplespaymentnote WHERE (sid=$sid AND sid!=0) OR (userid={$application->userid} AND userid!=0) ORDER BY datesubmitted DESC");
if (!empty($paymentnotes)) {
  $pnote = '<br />(Payment Note Present)';
}

echo '<tr>';
echo '<td>Payment Method</td>';
echo '<td>' . $mechanism;
echo '<br /><a href="' . $CFG->wwwroot . '/course/payconfirm.php?sid=' . $_REQUEST['sid'] . '" target="_blank">Update Payment Amounts, Method or Confirmed Status</a>';
echo $pnote;
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Date Paid</td>';
if (empty($application->datepaid)) echo '<td></td>';
else echo '<td>' . gmdate('d/m/Y H:i', $application->datepaid) . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Payment Info</td>';
echo '<td>' . htmlspecialchars($application->datafromworldpay, ENT_COMPAT, 'UTF-8') . '</td>';
echo '</tr>';

if ($application->nid != 80) {
  echo '<tr>';
  echo '<td>Confirmed Ready to Enrol?<br />(Can set below)</td>';
  echo '<td>' . ($application->ready ? 'Yes' : 'No') . '</td>';
  echo '</tr>';
}

$notes = $DB->get_records_sql("SELECT * FROM mdl_peoplesstudentnotes WHERE (sid=$sid AND sid!=0) OR (userid={$application->userid} AND userid!=0) ORDER BY datesubmitted DESC");
if (!empty($notes)) {
  echo '<tr><td colspan="2">Notes (can add more below)...</td></tr>';

  foreach ($notes as $note) {
    echo '<tr><td>';
    echo gmdate('d/m/Y H:i', $note->datesubmitted);
    echo '</td><td>';
    echo $note->note;
    echo '</td></tr>';
  }
}

$applymmumphtext = array('0' => '', '1' => '', '2' => 'Wants to Apply for MMU MPH', '3' => 'Says Already in MMU MPH');
$applymmumphtext = $applymmumphtext[$_REQUEST['applymmumph']];

if (!empty($mphs) || !empty($applymmumphtext)) {
  echo '<tr><td colspan="2">MMU MPH Status...</td></tr>';

  if (!empty($applymmumphtext)) echo '<tr><td></td><td>' . $applymmumphtext . '</td></tr>';

  foreach ($mphs as $mph) {
    echo '<tr><td>';
    echo gmdate('d/m/Y H:i', $mph->datesubmitted);
    echo '</td><td>';
    echo 'Student was Enrolled in MMU MPH';
    echo '</td></tr>';
  }
}

echo '</table>';

if ($state === 022) {
  $given_name = $_REQUEST['2'];
  $course1    = $_REQUEST['18'];
  $course2    = $_REQUEST['19'];

  if (!empty($application->userid)) $amount_to_pay_this_semester_adjusted = amount_to_pay_adjusted($application, $inmmumph, $payment_schedule);
  else $amount_to_pay_this_semester_adjusted = 0;

  if (TRUE || !$inmmumph) $peoples_approval_email = get_config(NULL, 'peoples_approval_old_students_email');
  else $peoples_approval_email = get_config(NULL, 'peoples_approval_email'); // MPH Students

  $peoples_approval_email = str_replace('GIVEN_NAME_HERE',           $given_name, $peoples_approval_email);
  $peoples_approval_email = str_replace('COURSE_MODULE_1_NAME_HERE', $course1, $peoples_approval_email);
  $peoples_approval_email = str_replace('SID_HERE',                  $sid, $peoples_approval_email);
  $peoples_approval_email = str_replace('AMOUNT_TO_PAY_HERE',        $amount_to_pay_this_semester_adjusted, $peoples_approval_email);
  if (!empty($course2)) {
    $peoples_approval_email = str_replace('COURSE_MODULE_2_TEXT_HERE', "and the Course Module '" . $course2 . "' ", $peoples_approval_email);
    $peoples_approval_email = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', "Please note that you have applied to take two modules, these run at the
same time and will involve a heavy workload - please be sure you do have the time for this.", $peoples_approval_email);
  }
  else {
    $peoples_approval_email = str_replace('COURSE_MODULE_2_TEXT_HERE',         '', $peoples_approval_email);
    $peoples_approval_email = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', '', $peoples_approval_email);
  }
  if ($inmmumph && empty($payment_schedule)) {
    $peoples_approval_email = str_replace('NOTE_ON_INSTALMENTS_HERE', "If you wish to pay by instalments, you may select your preferences at http://courses.peoples-uni.org/course/specify_instalments.php (you will need to log in).", $peoples_approval_email);
  }
  else {
    $peoples_approval_email = str_replace('NOTE_ON_INSTALMENTS_HERE', "", $peoples_approval_email);
  }

  $peoples_approval_email = htmlspecialchars($peoples_approval_email, ENT_COMPAT, 'UTF-8');

  if (TRUE || !$inmmumph) $peoples_approval_email_bursary = get_config(NULL, 'peoples_approval_old_students_bursary_email');
  else $peoples_approval_email_bursary = get_config(NULL, 'peoples_approval_bursary_email'); // MPH Students

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
<br /><i><b>NOTE: Any student that is doing MPH must, if not already so recorded,<br />
be recorded as MPH by clicking "Record that the Student has been enrolled in the MMU MPH" BEFORE APPROVAL<br />
(to pick up correct wording for e-mail).</b></i>
<br /><i><b>NOTE: Please check the Amount Owed by the student (in e-mail below) looks OK before sending.<br />
To fix any issues <a href="<?php echo $CFG->wwwroot . '/course/payconfirm.php?sid=' . $application->sid; ?>" target="_blank">click here to Update Payment Amounts, Method or Confirmed Status</a></b></i>
<form id="approveapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
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
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
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
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapp1" value="1" />
<input type="submit" name="approveapplication1" value="Approve Module '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />(No e-mail sent!)
</form>
<br />
<?php
}

if (($state2===020) && !empty($_REQUEST['19'])) {
	if (empty($_REQUEST['19'])) {
		$newstate = 011;
	}
	else {
		$newstate = $state1 | 010;
	}
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapp2" value="1" />
<input type="submit" name="approveapplication2" value="Approve Module '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />(No e-mail sent!)
</form>
<br />
<?php
}

if ($state1===01 || $state1===03) {
	if (empty($_REQUEST['19'])) {
		$newstate = 022;
	}
	else {
		$newstate = 02 | $state2;
	}
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>" onSubmit="return areyousureunapp1()">

<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markunapp1" value="1" />
<input type="submit" name="unapproveapplication1" value="Un-Approve Module: '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>'" style="width:40em" />(No e-mail sent!)
</form>
<br />
<?php
}

if (($state2===010 || $state2===030) && !empty($_REQUEST['19'])) {
	if (empty($_REQUEST['19'])) {
		$newstate = 022;
	}
	else {
		$newstate = $state1 | 020;
	}
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>" onSubmit="return areyousureunapp2()">

<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markunapp2" value="1" />
<input type="submit" name="unapproveapplication2" value="Un-Approve Module: '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>'" style="width:40em" />(No e-mail sent!)
</form>
<br />
<?php
}

if ($state1===02 || $state1===01) {
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="change1" value="1" />
<input type="submit" name="changename1" value="Change Module 1 Name from: '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' to:" style="width:40em" />
<select name="18">
<?php
foreach ($modules as $key => $modulename) {
	if ($modulename !== $_REQUEST['19']) {
		if ($modulename === $_REQUEST['18']) {
			$selected = ' selected="selected"';
		}
		else {
			$selected = '';
		}
		$modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
	}
}
?>
</select>
</form>
<br />
<?php
}

if (($state2===020 || $state2===010) && !empty($_REQUEST['19'])) { // Allow module 2 to be changed for unapproved or approved (but not enrolled) applications
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="change2" value="1" />
<input type="submit" name="changename2" value="Change Module 2 Name from: '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>' to:" style="width:40em" />

<select name="19">
<?php
foreach ($modules as $key => $modulename) {
	if ($modulename !== $_REQUEST['18']) {
		if ($modulename === $_REQUEST['19']) {
			$selected = ' selected="selected"';
		}
		else {
			$selected = '';
		}
		$modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
	}
}
?>
</select>
</form>
<br />
<?php
}
elseif ($state2 === 020 && empty($_REQUEST['19'])) { // Allow module 2 to be set for unapproved applications
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="change2" value="1" />
<input type="submit" name="changename2" value="Set Module 2 Name to:" style="width:40em" />

<select name="19">
<?php
foreach ($modules as $key => $modulename) {
  if ($modulename !== $_REQUEST['18']) {
    if ($modulename === $_REQUEST['19']) {
      $selected = ' selected="selected"';
    }
    else {
      $selected = '';
    }
    $modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
  }
}
?>
</select>
</form>
<br />
<?php
}
elseif ($state2 === 010 && empty($_REQUEST['19'])) { // Allow module 2 to be set for approved (but not enrolled) applications
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="add2newapproved" value="1" />
<input type="submit" name="changename2" value="Set Module 2 Name to (and mark as Approved):" style="width:40em" />

<select name="19">
<?php
foreach ($modules as $key => $modulename) {
  if ($modulename !== $_REQUEST['18']) {
    if ($modulename === $_REQUEST['19']) {
      $selected = ' selected="selected"';
    }
    else {
      $selected = '';
    }
    $modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
  }
}
?>
</select>
</form>
<br />
<?php
}

?>
<br />To send an e-mail to this applicant (EDIT the e-mail text below!), press "e-mail Applicant".
<form id="deferapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<textarea name="defertext" rows="10" cols="75" wrap="hard">
Dear <?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>,

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

if (!empty($_REQUEST['29'])) {
  $userrecord = $DB->get_record('user', array('id' => dontaddslashes($_REQUEST['29'])));
}
elseif (!empty($_REQUEST['21'])) {
	if ($_REQUEST['nid'] === '80') echo 'ERROR, THIS SHOULD NOT HAPPEN, TALK TO ALAN<br /><br />';

  $userrecord = $DB->get_record('user', array('username' => dontaddslashes($_REQUEST['21'])));
}
if (!empty($userrecord)) {
	if (empty($_REQUEST['29'])) {
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
	if (empty($_REQUEST['29'])) {
    if (FALSE) {
?>
<br />If this user has been registered manually using Moodle Admin features, press "Update UserID" to mark that they have been registered. <strong>BE CAREFULL THAT THIS REALLY IS THE SAME PERSON!</strong>
<form id="appuseridform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="userid" value="<?php echo $userrecord->id ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdateuserid" value="1" />
<input type="submit" name="updateuserid" value="Update UserID" style="width:40em" />
</form>
<?php
    }
?>

<br />Enter a new suggested user name here (maybe add "1" at the end of the existing name) and then press "Update Username" (you will need to come back to this page to register them).
<form id="appusernameform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdateusername" value="1" />
<input type="submit" name="updateusername" value="Update Username to:" style="width:40em" />
<input type="text" size="40" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
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
?>
<form id="appenroluserform1" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="userid" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markenroluser1" value="1" />
<input type="submit" name="enroluser1" value="Enrol User in Module '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />
</form>
<br />
<?php
		}
		if ($state2===010 && !empty($_REQUEST['19'])) {
			if (empty($_REQUEST['19'])) {
				$newstate = 033;
			}
			else {
				$newstate = $state1 | 030;
			}
?>
<form id="appenroluserform2" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="userid" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markenroluser2" value="1" />
<input type="submit" name="enroluser2" value="Enrol User in Module '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />
</form>
<br />
<?php
		}
		if ($state1===01 && $state2===010 && !empty($_REQUEST['19'])) {
			$newstate = 033;
?>
<form id="appenroluserform12" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="userid" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markenroluser12" value="1" />
<input type="submit" name="enroluser12" value="Enrol User in Modules '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' and '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>'" />
</form>
<br />
<?php
		}
	}
}
else {
	if ($_REQUEST['nid'] === '80') echo 'ERROR, THIS SHOULD NOT HAPPEN, TALK TO ALAN<br /><br />';
?>
No Moodle user with the Username: '<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>'...<br />
<?php
	if ($state1 === 01) {
		if (empty($_REQUEST['19'])) {
			$newstate = 033;
		}
		else {
			$newstate = $state2 | 03;
		}
?>
<form id="appcreateuserform1" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markcreateuser1" value="1" />
<input type="submit" name="createuser1" value="Create User & Enrol in Module '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />
</form>
<br />
<?php
	}
	if ($state2===010 && !empty($_REQUEST['19'])) {
		if (empty($_REQUEST['19'])) {
			$newstate = 033;
		}
		else {
			$newstate = $state1 | 030;
		}
?>
<form id="appcreateuserform2" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markcreateuser2" value="1" />
<input type="submit" name="createuser2" value="Create User & Enrol in Module '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />
</form>
<br />
<?php
	}

	if ($state1===01 && $state2===010 && !empty($_REQUEST['19'])) {
		$newstate = 033;
?>
<form id="appcreateuserform12" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markcreateuser12" value="1" />
<input type="submit" name="createuser12" value="Create User & Enrol in Modules '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' and '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>'" />
</form>
<br />
<?php
	}
}

if (!$application->ready && $application->nid != 80) {
?>
<br />To mark a student as having confirmed that they are ready to enrol, press "Confirm...".<br />
<form id="readyenrolform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markreadyenrol" value="1" />
<input type="submit" name="readyenrol" value="Confirm Student is Ready to Enrol" />
</form>
<br />
<?php
}

if (empty($mphs)) {
?>
<br />To record that the student has been enrolled in the MMU Masters in Public Health (MMU MPH), press "Record...".<br />
<form id="mphform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markmph" value="1" />
<input type="submit" name="mph" value="Record that the Student has been enrolled in the MMU MPH" />
</form>
<br />
<?php
}
elseif (!empty($_REQUEST['29'])) {
?>
<br />To Unenroll a student from the MMU Masters in Public Health (MMU MPH), press "Unenroll...".<br />
(This does not affect any course modules or payments.)<br />
<form id="unenrollmphform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markunenrollmph" value="1" />
<input type="submit" name="unenrollmph" value="Unenroll a student from the MMU Masters in Public Health (MMU MPH)" />
</form>
<br />
<?php
}

?>
<br />To add a note to this student's record, add text below and press "Add...".<br />
<form id="addnoteform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<textarea name="note" rows="5" cols="100" wrap="hard"></textarea>
<input type="hidden" name="markaddnote" value="1" />
<input type="submit" name="addnote" value="Add This Note to Student Record" />
</form>
<br />
<?php

if ($state1 !== 030 && $state2 !== 030 && empty($_REQUEST['29'])) { // Allow applicant e-mail to be changed
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markchangeemail" value="1" />
<input type="submit" name="changeemail" value="Change Applicant e-mail to:" style="width:40em" />

<input type="text" size="40" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br />
<?php
}

if ($state1 === 030 || $state2 === 030) { // Add another module (beyond 2)
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markaddnewmodule" value="1" />
<input type="submit" name="addnewmodule" value="Enrol Applicant in an Additional Module (beyond the normal 2):" />

<select name="newmodulename">
<?php
foreach ($modules as $key => $modulename) {
  if ($modulename !== $_REQUEST['18'] && $modulename !== $_REQUEST['19']) {
    $selected = '';
    $modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
  }
}
?>
</select>
<br />(Payment Balance will be increased accordingly.)
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


function amount_to_pay_adjusted($application, $inmmumph, $payment_schedule) {

  $amount = get_balance($application->userid);

  if (!$inmmumph) { // NON MPH: Take Outstanding Balance and adjust for new modules
    if (empty($application->coursename2)) $deltamodules = 1;
    else $deltamodules = 2;
    $amount += $deltamodules * MODULE_COST;
  }
  else { // MPH: Take Outstanding Balance and adjust for instalments if necessary
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


function is_not_confirmed($userid) {
  global $DB;

  $balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} AND not_confirmed=1");
  if (!empty($balances)) return TRUE;
  return FALSE;
}


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
        $enrolment->semester = dontaddslashes($enrolment->semester);
        $enrolment->dateunenrolled = time();
        $enrolment->enrolled = 0;
        $DB->update_record('enrolment', $enrolment);
      }

      $message = '';
      $user = $DB->get_record('user', array('id' => $userid));
      if (!empty($user->firstname))  $message .= $user->firstname;
      if (!empty($user->lastname))   $message .= ' ' . $user->lastname;
      $message .= ' as Student in ' . dontstripslashes($modulename);
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

  if ($deltamodules != 0) {
    $inmmumph = FALSE;
    $mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE userid={$record->userid} AND userid!=0 LIMIT 1");
    if (!empty($mphs)) {
      foreach ($mphs as $mph) {
        $inmmumph = TRUE;
      }
    }
    if (!$inmmumph && !empty($record->userid)) { // $record->userid should NOT be empty, but just in case
      // Update Balance only if this is not an MPH student as MPH students pay an all inclusive fee which is previously set.

      $amount = get_balance($record->userid);

      $peoples_student_balance = new object();
      $peoples_student_balance->userid = $record->userid;
      $peoples_student_balance->amount_delta = $deltamodules * MODULE_COST;
      $peoples_student_balance->balance = $amount + $peoples_student_balance->amount_delta;
      $peoples_student_balance->currency = 'GBP';
      if (!empty($record->coursename2)) {
        $course2 = " & '{$record->coursename2}'";
      }
      else {
        $course2 = '';
      }
      $peoples_student_balance->detail = "Adjustment for modules '$record->coursename1'{$course2} for Semester $record->semester";
      $peoples_student_balance->date = time();
      $DB->insert_record('peoples_student_balance', $peoples_student_balance);
    }
  }
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
      $enrolment->semester = dontaddslashes($enrolment->semester);
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


function dontaddslashes($x) {
  return $x;
}


function dontstripslashes($x) {
  return $x;
}
?>
