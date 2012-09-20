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
  reenrolment BIGINT(10) unsigned NOT NULL DEFAULT 0,
  state BIGINT(10) unsigned NOT NULL,
  state_1 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  state_2 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  state_3 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  state_4 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  ready BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
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
  applymmumph BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
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
  sponsoringorganisation text NOT NULL DEFAULT '',
  scholarship TEXT NOT NULL DEFAULT '',
  whynotcomplete TEXT NOT NULL DEFAULT '',
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

ALTER TABLE mdl_peoplesapplication ADD sponsoringorganisation text NOT NULL DEFAULT '' AFTER reasons;
ALTER TABLE mdl_peoplesapplication ADD ready BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state_4;

ALTER TABLE mdl_peoplesapplication ADD applymmumph BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER coursename4;
ALTER TABLE mdl_peoplesapplication ADD scholarship TEXT NOT NULL DEFAULT '' AFTER sponsoringorganisation;
ALTER TABLE mdl_peoplesapplication ADD whynotcomplete TEXT NOT NULL DEFAULT '' AFTER scholarship;
ALTER TABLE mdl_peoplesapplication ADD reenrolment BIGINT(10) unsigned NOT NULL DEFAULT 0 AFTER nid;
))

CREATE TABLE mdl_peoplesmph (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  sid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
  mphstatus BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  note text default '' NOT NULL,
CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplesmph_uid_ix ON mdl_peoplesmph (userid);
CREATE INDEX mdl_peoplesmph_sid_ix ON mdl_peoplesmph (sid);

"sid" so can use before userid assigned.
(userid will be set when it is known.)

CREATE TABLE mdl_peoplespaymentnote (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  sid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
  paymentstatus BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  note text default '' NOT NULL,
CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplespaymentnote_uid_ix ON mdl_peoplespaymentnote (userid);
CREATE INDEX mdl_peoplespaymentnote_sid_ix ON mdl_peoplespaymentnote (sid);

"sid" so can use before userid assigned.
(userid will be set when it is known.)
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

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/applications.php'); // Defined here to avoid notices on errors etc

if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/applications.php?'
    . 'chosensemester=' . urlencode(dontstripslashes($_POST['chosensemester']))
    . '&chosenstatus=' . urlencode($_POST['chosenstatus'])
    . '&chosenstartyear=' . $_POST['chosenstartyear']
    . '&chosenstartmonth=' . $_POST['chosenstartmonth']
    . '&chosenstartday=' . $_POST['chosenstartday']
    . '&chosenendyear=' . $_POST['chosenendyear']
    . '&chosenendmonth=' . $_POST['chosenendmonth']
    . '&chosenendday=' . $_POST['chosenendday']
    . '&chosensearch=' . urlencode(dontstripslashes($_POST['chosensearch']))
    . '&chosenmodule=' . urlencode(dontstripslashes($_POST['chosenmodule']))
    . '&chosenpay=' . urlencode($_POST['chosenpay'])
    . '&chosenreenrol=' . urlencode($_POST['chosenreenrol'])
    . '&chosenmmu=' . urlencode($_POST['chosenmmu'])
    . '&acceptedmmu=' . urlencode($_POST['acceptedmmu'])
    . '&chosenscholarship=' . urlencode($_POST['chosenscholarship'])
    . (empty($_POST['displayscholarship']) ? '&displayscholarship=0' : '&displayscholarship=1')
    . (empty($_POST['displayextra']) ? '&displayextra=0' : '&displayextra=1')
    . (empty($_POST['displayforexcel']) ? '&displayforexcel=0' : '&displayforexcel=1')
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
//$PAGE->set_pagelayout('base');     // Most backwards compatible layout without the blocks - this is the layout used by default
//$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information
//$PAGE->set_pagelayout('course');
//$PAGE->set_pagetype('course-view-' . 1);
//$PAGE->set_other_editing_capability('moodle/course:manageactivities');


require_login();

// Access to applications.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Student Applications');
$PAGE->set_heading('Student Applications');
if (empty($_REQUEST['displayforexcel'])) echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


if (empty($_REQUEST['displayforexcel'])) echo "<h1>Student Applications</h1>";

if (!empty($_REQUEST['chosensemester'])) $chosensemester = dontstripslashes($_REQUEST['chosensemester']);
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
if (!empty($_REQUEST['chosensearch'])) $chosensearch = dontstripslashes($_REQUEST['chosensearch']);
else $chosensearch = '';
if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = dontstripslashes($_REQUEST['chosenmodule']);
else $chosenmodule = '';
if (!empty($_REQUEST['chosenpay'])) $chosenpay = $_REQUEST['chosenpay'];
if (!empty($_REQUEST['chosenreenrol'])) $chosenreenrol = $_REQUEST['chosenreenrol'];
if (!empty($_REQUEST['chosenmmu'])) $chosenmmu = $_REQUEST['chosenmmu'];
if (!empty($_REQUEST['acceptedmmu'])) $acceptedmmu = $_REQUEST['acceptedmmu'];
if (!empty($_REQUEST['chosenscholarship'])) $chosenscholarship = $_REQUEST['chosenscholarship'];
if (!empty($_REQUEST['displayscholarship'])) $displayscholarship = true;
else $displayscholarship = false;
if (!empty($_REQUEST['displayextra'])) $displayextra = true;
else $displayextra = false;
if (!empty($_REQUEST['displayforexcel'])) $displayforexcel = true;
else $displayforexcel = false;

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
  if (!isset($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

$liststatus[] = 'All';
if (!isset($chosenstatus)) $chosenstatus = 'All';
$liststatus[] = 'Not fully Approved';
$liststatus[] = 'Not fully Enrolled';
$liststatus[] = 'Part or Fully Approved';
$liststatus[] = 'Part or Fully Enrolled';

$listchosenpay[] = 'Any';
if (!isset($chosenpay)) $chosenpay = 'Any';
$listchosenpay[] = 'No Indication Given';
$listchosenpay[] = 'Not Confirmed (all)';
$listchosenpay[] = 'Barclays not confirmed';
$listchosenpay[] = 'Ecobank not confirmed';
$listchosenpay[] = 'Diamond not confirmed';
$listchosenpay[] = 'MoneyGram not confirmed';
$listchosenpay[] = 'Western Union not confirmed';
$listchosenpay[] = 'Indian Confederation not confirmed';
$listchosenpay[] = 'Posted Travellers Cheques not confirmed';
$listchosenpay[] = 'Posted Cash not confirmed';
$listchosenpay[] = 'Promised End Semester';
$listchosenpay[] = 'Waiver';
$listchosenpay[] = 'RBS Confirmed';
$listchosenpay[] = 'Barclays Confirmed';
$listchosenpay[] = 'Ecobank Confirmed';
$listchosenpay[] = 'Diamond Confirmed';
$listchosenpay[] = 'MoneyGram Confirmed';
$listchosenpay[] = 'Western Union Confirmed';
$listchosenpay[] = 'Indian Confederation Confirmed';
$listchosenpay[] = 'Posted Travellers Cheques Confirmed';
$listchosenpay[] = 'Posted Cash Confirmed';

$listchosenreenrol[] = 'Any';
if (!isset($chosenreenrol)) $chosenreenrol = 'Any';
$listchosenreenrol[] = 'Re-enrolment';
$listchosenreenrol[] = 'New student';

$listchosenmmu[] = 'Any';
if (!isset($chosenmmu)) $chosenmmu = 'Any';
$listchosenmmu[] = 'Yes';
$listchosenmmu[] = 'No';

$listacceptedmmu[] = 'Any';
if (!isset($acceptedmmu)) $acceptedmmu = 'Any';
$listacceptedmmu[] = 'Yes';
$listacceptedmmu[] = 'No';
for ($year = 11; $year <= 16; $year++) {
  $listacceptedmmu[] = "Accepted {$year}a";
  $listacceptedmmu[] = "Accepted {$year}b";

  $stamp_range["Accepted {$year}a"]['start'] = gmmktime( 0, 0, 0,  1,  1, 2000 + $year);
  $stamp_range["Accepted {$year}a"]['end']   = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['start'] = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['end']   = gmmktime(24, 0, 0, 12, 31, 2000 + $year);
}

$listchosenscholarship[] = 'Any';
if (!isset($chosenscholarship)) $chosenscholarship = 'Any';
$listchosenscholarship[] = 'Yes';
$listchosenscholarship[] = 'No';

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

if (!$displayforexcel) {
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
    <td>Module Name Contains</td>
    <td>Payment Method</td>
    <td>Re&#8209;enrolment?</td>
    <td>Applied MMU?</td>
    <td>Accepted MMU?</td>
    <td>Applied Scholarship?</td>
    <td>Show Scholarship Relevant Columns</td>
    <td>Show Extra Details</td>
    <td>Display Student History for Copying and Pasting to Excel</td>
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
    <td><input type="text" size="15" name="chosensearch" value="<?php echo htmlspecialchars($chosensearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <td><input type="text" size="15" name="chosenmodule" value="<?php echo htmlspecialchars($chosenmodule, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <?php
    displayoptions('chosenpay', $listchosenpay, $chosenpay);
    displayoptions('chosenreenrol', $listchosenreenrol, $chosenreenrol);
    displayoptions('chosenmmu', $listchosenmmu, $chosenmmu);
    displayoptions('acceptedmmu', $listacceptedmmu, $acceptedmmu);
    displayoptions('chosenscholarship', $listchosenscholarship, $chosenscholarship);
    ?>
    <td><input type="checkbox" name="displayscholarship" <?php if ($displayscholarship) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="displayextra" <?php if ($displayextra) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="displayforexcel" <?php if ($displayforexcel) echo ' CHECKED'; ?>></td>
  </tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/applications.php">Reset Filters</a>
</form>
<br />
<?php
}


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


// Retrieve all relevent rows
//$applications = get_records_sql('SELECT a.sid AS appsid, a.* FROM mdl_peoplesapplication AS a WHERE hidden=0 ORDER BY datesubmitted DESC');
$applications = $DB->get_records_sql('
  SELECT DISTINCT a.sid AS appsid, a.*, n.id IS NOT NULL AS notepresent, m.id IS NOT NULL AS mph, m.datesubmitted AS mphdatestamp, p.id IS NOT NULL AS paymentnote
  FROM mdl_peoplesapplication a
  LEFT JOIN mdl_peoplesstudentnotes n ON (a.sid=n.sid AND n.sid!=0) OR (a.userid=n.userid AND n.userid!=0)
  LEFT JOIN mdl_peoplesmph          m ON (a.sid=m.sid AND m.sid!=0) OR (a.userid=m.userid AND m.userid!=0)
  LEFT JOIN mdl_peoplespaymentnote  p ON (a.sid=p.sid AND p.sid!=0) OR (a.userid=p.userid AND p.userid!=0)
  WHERE hidden=0 ORDER BY a.datesubmitted DESC');
if (empty($applications)) {
  $applications = array();
}


$emaildups = 0;
foreach ($applications as $sid => $application) {
  $state = (int)$application->state;
  if ($state === 1) $state = 011;

  if (
    $application->datesubmitted < $starttime ||
    $application->datesubmitted > $endtime ||
    (($chosensemester !== 'All') && ($application->semester !== $chosensemester)) ||
    (($chosenstatus  === 'Not fully Approved')       && ($state === 011 || $state === 033)) ||
    (($chosenstatus  === 'Not fully Enrolled')     && ($state === 033)) ||
    (($chosenstatus  === 'Part or Fully Approved')   && (!($state === 011 || $state === 012 || $state === 021 || $state === 023 || $state === 032 || $state === 013 || $state === 031 || $state === 033))) ||
    (($chosenstatus  === 'Part or Fully Enrolled') && (!($state === 023 || $state === 032 || $state === 013 || $state === 031 || $state === 033)))
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

  if (!empty($chosenmodule) &&
    stripos($application->coursename1, $chosenmodule) === false &&
    stripos($application->coursename2, $chosenmodule) === false) {

    unset($applications[$sid]);
    continue;
  }

  if (!empty($chosenpay) && $chosenpay !== 'Any') {
    if ($chosenpay === 'No Indication Given' && $application->paymentmechanism != 0) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Not Confirmed (all)' && ($application->paymentmechanism == 1 || $application->paymentmechanism >= 100)) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Barclays not confirmed' && $application->paymentmechanism != 2) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Diamond not confirmed' && $application->paymentmechanism != 3) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Ecobank not confirmed' && $application->paymentmechanism != 10) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Western Union not confirmed' && $application->paymentmechanism != 4) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Indian Confederation not confirmed' && $application->paymentmechanism != 5) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Travellers Cheques not confirmed' && $application->paymentmechanism != 7) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Cash not confirmed' && $application->paymentmechanism != 8) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'MoneyGram not confirmed' && $application->paymentmechanism != 9) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Promised End Semester' && $application->paymentmechanism != 6) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Waiver' && $application->paymentmechanism != 100) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'RBS Confirmed' && $application->paymentmechanism != 1) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Barclays Confirmed' && $application->paymentmechanism != 102) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Diamond Confirmed' && $application->paymentmechanism != 103) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Ecobank Confirmed' && $application->paymentmechanism != 110) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Western Union Confirmed' && $application->paymentmechanism != 104) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Indian Confederation Confirmed' && $application->paymentmechanism != 105) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Travellers Cheques Confirmed' && $application->paymentmechanism != 107) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Cash Confirmed' && $application->paymentmechanism != 108) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenpay === 'MoneyGram Confirmed' && $application->paymentmechanism != 109) {
      unset($applications[$sid]);
      continue;
    }
  }

  if (!empty($chosenreenrol) && $chosenreenrol !== 'Any') {
    if ($chosenreenrol === 'Re-enrolment' && !$application->reenrolment) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenreenrol === 'New student' && $application->reenrolment) {
      unset($applications[$sid]);
      continue;
    }
  }

  if (!empty($chosenmmu) && $chosenmmu !== 'Any') {
    if ($chosenmmu === 'No' && $application->applymmumph >= 2) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenmmu === 'Yes' && $application->applymmumph < 2) {
      unset($applications[$sid]);
      continue;
    }
  }

  if (!empty($acceptedmmu) && $acceptedmmu !== 'Any') {
    if ($acceptedmmu === 'No' && $application->mph) {
      unset($applications[$sid]);
      continue;
    }
    if ($acceptedmmu === 'Yes' && !$application->mph) {
      unset($applications[$sid]);
      continue;
    }
    if ($acceptedmmu !== 'No' && $acceptedmmu !== 'Yes') {
      if (!$application->mph || $application->mphdatestamp < $stamp_range[$acceptedmmu]['start'] || $application->mphdatestamp >= $stamp_range[$acceptedmmu]['end']) {
        unset($applications[$sid]);
        continue;
      }
    }
  }

  $x = strtolower(trim($application->scholarship));
  $scholarshipempty = empty($x) || ($x ==  'none') || ($x ==  'n/a') || ($x ==  'none.');
  if (!empty($chosenscholarship) && $chosenscholarship !== 'Any') {
    if ($chosenscholarship === 'No' && !$scholarshipempty) {
      unset($applications[$sid]);
      continue;
    }
    if ($chosenscholarship === 'Yes' && $scholarshipempty) {
      unset($applications[$sid]);
      continue;
    }
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
  sendemails($applications, strip_tags(dontstripslashes($_POST['emailsubject'])), strip_tags(dontstripslashes($_POST['emailbody'])), dontstripslashes($_POST['reg']), $_POST['notforuptodatepayments']);
}


$table = new html_table();

if (!$displayextra && !$displayscholarship && !$displayforexcel) {
  $table->head = array(
    'Submitted',
    'sid',
    'Approved?',
    'Payment up to date?',
    'Enrolled?',
    '',
    'Family name',
    'Given name',
    'Email address',
    'Semester',
    'First module',
    'Second module',
    'DOB dd/mm/yyyy',
    'Gender',
    'City/Town',
    'Country',
    '',
    ''
  );
}
elseif ($displayscholarship) {
  $table->head = array(
    'sid',
    '',
    'Family name',
    'Given name',
    'Country',
    'Scholarship',
    'Reasons for wanting to enrol (1st Application)',
    'Current employment (1st Application)',
    'Current employment details (1st Application)',
    'Qualification (1st Application)',
    'Postgraduate Qualification (1st Application)',
    'Education Details (1st Application)',
  );
  $table->align = array('left', 'left', 'left', 'left', 'left', 'left', 'left', 'left', 'left', 'left', 'left', 'left');
}
elseif ($displayforexcel) {
  $table->head = array(
    'Family name',
    'Given name',
    'Country',
    'MMU?',
    'Current employment',
    'Current employment details',
    'Qualification',
    'Postgraduate Qualification',
    'Education Details',
    'Reasons for wanting to enrol',
    'Sponsoring organisation',
    'Scholarship',
    'Why Not Completed Previous Semester',
  );
}
else {
  $table->head = array(
    'Submitted',
    'sid',
    'Approved?',
    'Payment up to date?',
    'Enrolled?',
    'Family name',
    'Given name',
    'Email address',
    'Semester',
    'First module',
    'Second module',
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
    'Sponsoring organisation',
    'Scholarship',
    'Why Not Completed Previous Semester',
    'Desired Moodle Username',
    'Moodle UserID',
    '',
    ''
  );
}

//$table->align = array ("left", "left", "left", "left", "left", "center", "center", "center");
//$table->width = "95%";

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
Sponsoring organisation
sponsoringorganisation
Applying for MMU MPH
applymmumph
Scholarship
scholarship
Why Not Completed Previous Semester
whynotcomplete
Method of payment
31
Payment Identification
32
Desired Moodle Username
21
*/

$n = 0;
$napproved = 0;
$nenrolled = 0;

$modules = array();
foreach ($applications as $sid => $application) {
  $state = (int)$application->state;
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
  // state 1 (approved) ..> state 3 (enrolled) OR state 2 (defered)
  // state 3 (enrolled) ..> state 2 (defered)
  // If any state changes from 0, all must change from 0!
  // If Module 2 is empty, its state should change along with Module 1's

  // Allowed States:
  // 00 0
  // 22 18
  // 12 10
  // 21 17
  // 11 9
  // 23 19
  // 32 26
  // 13 11
  // 31 25
  // 33 27
  // If there are any 3's, Moodle UserID must be set

  $state1 = $state & 07;
  $state2 = $state & 070;

  $application->userid = (int)$application->userid;

  if (!$displayforexcel) {
    $rowdata = array();
    //echo '<tr>';
    //echo '<td>' . gmdate('d/m/Y H:i', $application->datesubmitted) . '</td>';
    if (!$displayscholarship) $rowdata[] = gmdate('d/m/Y H:i', $application->datesubmitted);
    //echo '<td>' . $sid . '</td>';
    $rowdata[] = $sid;

    if ($state === 0) $z = '<span style="color:red">No</span>';
    elseif ($state === 022) $z = '<span style="color:blue">Denied or Deferred</span>';
    elseif ($state1===02 || $state2===020) $z = '<span style="color:blue">Some</span>';
    else $z = '<span style="color:green">Yes</span>';
    $applymmumphtext = array(0 => '', 1 => '', 2 => '<br />(Apply MMU MPH)', 3 => '<br />(Say already MMU MPH)');
    $z .= $applymmumphtext[$application->applymmumph];
    if (!$displayscholarship) $rowdata[] = $z;

    if (empty($application->paymentmechanism)) $mechanism = '';
    elseif ($application->paymentmechanism == 1) $mechanism = ' RBS Confirmed';
    elseif ($application->paymentmechanism == 2) $mechanism = ' Barclays';
    elseif ($application->paymentmechanism == 3) $mechanism = ' Diamond';
    elseif ($application->paymentmechanism ==10) $mechanism = ' Ecobank';
    elseif ($application->paymentmechanism == 4) $mechanism = ' Western Union';
    elseif ($application->paymentmechanism == 5) $mechanism = ' Indian Confederation';
    elseif ($application->paymentmechanism == 6) $mechanism = ' Promised End Semester';
    elseif ($application->paymentmechanism == 7) $mechanism = ' Posted Travellers Cheques';
    elseif ($application->paymentmechanism == 8) $mechanism = ' Posted Cash';
    elseif ($application->paymentmechanism == 9) $mechanism = ' MoneyGram';
    elseif ($application->paymentmechanism == 100) $mechanism = ' Waiver';
    elseif ($application->paymentmechanism == 102) $mechanism = ' Barclays Confirmed';
    elseif ($application->paymentmechanism == 103) $mechanism = ' Diamond Confirmed';
    elseif ($application->paymentmechanism == 110) $mechanism = ' Ecobank Confirmed';
    elseif ($application->paymentmechanism == 104) $mechanism = ' Western Union Confirmed';
    elseif ($application->paymentmechanism == 105) $mechanism = ' Indian Confederation Confirmed';
    elseif ($application->paymentmechanism == 107) $mechanism = ' Posted Travellers Cheques Confirmed';
    elseif ($application->paymentmechanism == 108) $mechanism = ' Posted Cash Confirmed';
    elseif ($application->paymentmechanism == 109) $mechanism = ' MoneyGram Confirmed';
    else  $mechanism = '';

    //if ($application->costpaid < .01) $z = '<span style="color:red">No' . $mechanism . '</span>';
    //elseif (abs($application->costowed - $application->costpaid) < .01) $z = '<span style="color:green">Yes' . $mechanism . '</span>';
    //else $z = '<span style="color:blue">' . "Paid $application->costpaid out of $application->costowed" . $mechanism . '</span>';
    if (!empty($application->userid)) {
      $not_confirmed_text = '';
      if (is_not_confirmed($application->userid)) $not_confirmed_text = ' (not confirmed)';
      $amount = amount_to_pay($application->userid);
      if ($amount >= .01) $z = '<span style="color:red">No: &pound;' . $amount . ' Owed now' . $not_confirmed_text . $mechanism . '</span>';
      elseif (abs($amount) < .01) $z = '<span style="color:green">Yes' . $not_confirmed_text . $mechanism . '</span>';
      else $z = '<span style="color:blue">' . "Overpaid: &pound;$amount" . $not_confirmed_text . $mechanism . '</span>'; // Will never be Overpaid here because of function used
    }
    else {
      $z = $mechanism;
    }
    if ($application->paymentnote) $z .= '<br />(Payment Note Present)';
    if (!$displayscholarship) $rowdata[] = $z;

    if (!($state1===03 || $state2===030)) $z = '<span style="color:red">No</span>';
    elseif ($state === 033) $z = '<span style="color:green">Yes</span>';
    else $z = '<span style="color:blue">Some</span>';

    if ($application->ready && $application->nid != 80) $z .= '<br />(Ready)';
    if ($application->notepresent) $z .= '<br />(Note Present)';
    if ($application->mph) $z .= '<br />(MMU MPH)';
    if (!$displayscholarship) $rowdata[] = $z;

    if (!$displayextra || $displayscholarship) {
      $z  = '<form method="post" action="' .  $CFG->wwwroot . '/course/app.php" target="_blank">';

      $z .= '<input type="hidden" name="state" value="' . $state . '" />';
      $z .= '<input type="hidden" name="29" value="' . htmlspecialchars($application->userid, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="1" value="' . htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="2" value="' . htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="11" value="' . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="16" value="' . htmlspecialchars($application->semester, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="18" value="' . htmlspecialchars($application->coursename1, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="19" value="' . htmlspecialchars($application->coursename2, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="dobday" value="' . $application->dobday . '" />';
      $z .= '<input type="hidden" name="dobmonth" value="' . $application->dobmonth . '" />';
      $z .= '<input type="hidden" name="dobyear" value="' . $application->dobyear . '" />';
      $z .= '<input type="hidden" name="12" value="' . htmlspecialchars($application->gender, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="14" value="' . htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="13" value="' . htmlspecialchars($application->country, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="34" value="' . htmlspecialchars($application->qualification, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="35" value="' . htmlspecialchars($application->higherqualification, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="36" value="' . htmlspecialchars($application->employment, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="31" value="' . htmlspecialchars($application->methodofpayment, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="21" value="' . htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<span style="display: none;">';
      $z .= '<textarea name="3" rows="10" cols="100" wrap="hard">'  . $application->applicationaddress . '</textarea>';
      $z .= '<textarea name="7" rows="10" cols="100" wrap="hard">'  . $application->currentjob         . '</textarea>';
      $z .= '<textarea name="8" rows="10" cols="100" wrap="hard">'  . $application->education          . '</textarea>';
      $z .= '<textarea name="10" rows="10" cols="100" wrap="hard">' . $application->reasons            . '</textarea>';
      $z .= '<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard">' . $application->sponsoringorganisation . '</textarea>';
      $z .= '<textarea name="scholarship" rows="10" cols="100" wrap="hard">' . $application->scholarship . '</textarea>';
      $z .= '<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard">' . $application->whynotcomplete . '</textarea>';
      $z .= '<textarea name="32" rows="10" cols="100" wrap="hard">' . htmlspecialchars($application->paymentidentification, ENT_COMPAT, 'UTF-8') . '</textarea>';
      $z .= '</span>';
      $z .= '<input type="hidden" name="applymmumph" value="' . $application->applymmumph . '" />';
      $z .= '<input type="hidden" name="sid" value="' . $sid . '" />';
      $z .= '<input type="hidden" name="nid" value="' . $application->nid . '" />';
      $z .= '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
      $z .= '<input type="hidden" name="markapp" value="1" />';
      $z .= '<input type="submit" name="approveapplication" value="Details" />';

      $z .= '</form>';
      if ($application->reenrolment) $z .= 'Re&#8209;enrolment';
      $rowdata[] = $z;
    }

    $rowdata[] = htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8');

    $rowdata[] = htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8');

    if ($emailcounts[$application->email] === 1) {
      $z = htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
    }
    else {
      $z = '<span style="color:navy">**</span>' . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
    }
    if (!$displayscholarship) $rowdata[] = $z;

    if (!$displayscholarship) $rowdata[] = htmlspecialchars($application->semester, ENT_COMPAT, 'UTF-8');

    if ($state1 === 02) {
      $z = '<span style="color:red">';
    }
    elseif ($state1 === 01) {
      $z = '<span style="color:#FF8C00">';
    }
    elseif ($state1 === 03) {
      $z = '<span style="color:green">';
    }
    else {
      $z = '<span>';
    }
    if (!$displayscholarship) $rowdata[] = $z . htmlspecialchars($application->coursename1, ENT_COMPAT, 'UTF-8') . '</span>';

    if ($state2 === 020) {
      $z = '<span style="color:red">';
    }
    elseif ($state2 === 010) {
      $z = '<span style="color:#FF8C00">';
    }
    elseif ($state2 === 030) {
      $z = '<span style="color:green">';
    }
    else {
      $z = '<span>';
    }
    if (!$displayscholarship) $rowdata[] = $z . htmlspecialchars($application->coursename2, ENT_COMPAT, 'UTF-8') . '</span>';

    if (!$displayscholarship) $rowdata[] = $application->dobday . '/' . $application->dobmonth . '/' . $application->dobyear;

    if (!$displayscholarship) $rowdata[] = $application->gender;

    if (!$displayscholarship) $rowdata[] = htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8');

    if (empty($countryname[$application->country])) $z = '';
    else $z = $countryname[$application->country];
    $rowdata[] = $z;

    if ($displayscholarship) {
      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->scholarship));

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->reasons));

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
    }
    elseif ($displayextra) {
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

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->sponsoringorganisation));

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->scholarship));

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->whynotcomplete));

      $rowdata[] = htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8');

      if (empty($application->userid)) $z = '';
      else $z = $application->userid;
      $rowdata[] = $z;
    }

    if (empty($application->userid)) $z = '';
    else $z = '<a href="' . $CFG->wwwroot . '/course/student.php?id=' . $application->userid . '" target="_blank">Student Grades</a>';
    if (!$displayscholarship) $rowdata[] = $z;

    if (empty($application->userid)) $z = '';
    else $z = '<a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $application->userid . '" target="_blank">Student Submissions</a>';
    if (!$displayscholarship) $rowdata[] = $z;


    if (empty($modules[$application->coursename1])) {
      $modules[$application->coursename1] = 1;
    }
    else {
      $modules[$application->coursename1]++;
    }
    if (!empty($application->coursename2)) {
      if (empty($modules[$application->coursename2])) {
        $modules[$application->coursename2] = 1;
      }
      else {
        $modules[$application->coursename2]++;
      }
    }

    $n++;

    if ($state1===01 || $state1===03 || $state2===010 || $state2===030) {
      $napproved++;

      // Is Module 1 Approved/Enrolled
      if ($state1===01 || $state1===03) {
        if (empty($moduleapprovals[$application->coursename1])) {
          $moduleapprovals[$application->coursename1] = 1;
        }
        else {
          $moduleapprovals[$application->coursename1]++;
        }
      }

      // Is Module 2 Approved/Enrolled
      if ($state2===010 || $state2===030) {
        if (!empty($application->coursename2)) {
          if (empty($moduleapprovals[$application->coursename2])) {
            $moduleapprovals[$application->coursename2] = 1;
          }
          else {
            $moduleapprovals[$application->coursename2]++;
          }
        }
      }

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

      $listofemails[]  = htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
    }
    if ($state1===03 || $state2===030) {
      $nenrolled++;

      // Is Module 1 Enrolled
      if ($state1 === 03) {
        if (empty($moduleregistrations[$application->coursename1])) {
          $moduleregistrations[$application->coursename1] = 1;
        }
        else {
          $moduleregistrations[$application->coursename1]++;
        }
      }

      // Is Module 2 Enrolled
      if ($state2 === 030) {
        if (!empty($application->coursename2)) {
          if (empty($moduleregistrations[$application->coursename2])) {
            $moduleregistrations[$application->coursename2] = 1;
          }
          else {
            $moduleregistrations[$application->coursename2]++;
          }
        }
      }
    }
    $table->data[] = $rowdata;
  }
  else {
    $rowdata = array();

    $rowdata[] = htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8');

    $rowdata[] = htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8');

    if (empty($countryname[$application->country])) $z = '';
    else $z = $countryname[$application->country];
    $rowdata[] = $z;

    if ($application->mph) $z = 'Yes';
    else $z = '';
    $rowdata[] = $z;

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

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->sponsoringorganisation));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->scholarship));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->whynotcomplete));

    $table->data[] = $rowdata;
  }
}
echo html_writer::table($table);

if ($displayforexcel) die();

echo '<br />Total Applications: ' . $n;
echo '<br />Total Approved (or part Approved): ' . $napproved;
echo '<br />Total Enrolled (or part Enrolled): ' . $nenrolled;
echo '<br /><br />(Duplicated e-mails: ' . $emaildups . ',  see <span style="color:navy">**</span>)';
echo '<br/><br/>';

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";
echo "<td>Module</td>";
echo "<td>Number of Applications</td>";
echo "<td>Number Approved</td>";
echo "<td>Number Enrolled</td>";
echo "</tr>";

ksort($modules);

$n = 0;

foreach ($modules as $product => $number) {
  echo "<tr>";
  echo "<td>" . $product . "</td>";
  echo "<td>" . $number . "</td>";
  if (empty($moduleapprovals[$product])) { echo "<td>0</td>";} else {   echo "<td>" . $moduleapprovals[$product] . "</td>";}
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
NOTE, to send an e-mail only to approved and enrolled students for the current semester who have not indicated that they have paid
or have otherwise been marked as paid or have a waiver... BEFORE SENDING THE E_MAIL,
set the filters at the top of this page as follows...<br />
Status: "Part or Fully Approved"<br />
Payment Method: "No Indication Given"<br />
<br />
Also look at list of e-mails sent to verify they went! (No subject and they will not go!)<br /><br />
<form id="emailsendform" method="post" action="<?php
  if (!empty($_REQUEST['chosensemester'])) {
    echo $CFG->wwwroot . '/course/applications.php?'
      . 'chosensemester=' . urlencode(dontstripslashes($_REQUEST['chosensemester']))
      . '&chosenstatus=' . urlencode($_REQUEST['chosenstatus'])
      . '&chosenstartyear=' . $_REQUEST['chosenstartyear']
      . '&chosenstartmonth=' . $_REQUEST['chosenstartmonth']
      . '&chosenstartday=' . $_REQUEST['chosenstartday']
      . '&chosenendyear=' . $_REQUEST['chosenendyear']
      . '&chosenendmonth=' . $_REQUEST['chosenendmonth']
      . '&chosenendday=' . $_REQUEST['chosenendday']
      . '&chosensearch=' . urlencode(dontstripslashes($_REQUEST['chosensearch']))
      . '&chosenmodule=' . urlencode(dontstripslashes($_REQUEST['chosenmodule']))
      . '&chosenpay=' . urlencode($_REQUEST['chosenpay'])
      . '&chosenreenrol=' . urlencode($_REQUEST['chosenreenrol'])
      . '&chosenmmu=' . urlencode($_REQUEST['chosenmmu'])
      . '&acceptedmmu=' . urlencode($_REQUEST['acceptedmmu'])
      . '&chosenscholarship=' . urlencode($_REQUEST['chosenscholarship'])
      . (empty($_REQUEST['displayscholarship']) ? '&displayscholarship=0' : '&displayscholarship=1')
      . (empty($_REQUEST['displayextra']) ? '&displayextra=0' : '&displayextra=1')
      . (empty($_REQUEST['displayforexcel']) ? '&displayforexcel=0' : '&displayforexcel=1')
      ;
  }
  else {
    echo $CFG->wwwroot . '/course/applications.php';
  }
?>">
Subject:&nbsp;<input type="text" size="75" name="emailsubject" /><br />
<textarea name="emailbody" rows="15" cols="75" wrap="hard">
<?php echo $peoples_batch_reminder_email; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markemailsend" value="1" />
<input type="submit" name="emailsend" value="Send e-mail to All" />
<br />Regular expression for included e-mails (defaults to all, so do not change!):&nbsp;<input type="text" size="20" name="reg" value="/^[a-zA-Z0-9_.-]/" />
<br />Check this if you want e-mails NOT to be sent to any student who is up to date in payments (balance adjusted for instalments <= 0):&nbsp;<input type="checkbox" name="notforuptodatepayments" />
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


function sendemails($applications, $emailsubject, $emailbody, $reg, $notforuptodatepayments) {

  echo '<br />';
  $i = 1;
  foreach ($applications as $sid => $application) {

    $email = trim($application->email);

    if (!preg_match($reg, $email)) {
      echo "&nbsp;&nbsp;&nbsp;&nbsp;($email skipped because of regular expression.)<br />";
      continue;
    }

    $emailbodytemp = str_replace('GIVEN_NAME_HERE', trim($application->firstname), $emailbody);
    $emailbodytemp = str_replace('SID_HERE', $sid, $emailbodytemp);

    if (!empty($application->userid)) $amount = amount_to_pay($application->userid);
    else $amount = 0;
    $emailbodytemp = str_replace('AMOUNT_TO_PAY_HERE', $amount, $emailbodytemp);

    $emailbodytemp = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $emailbodytemp); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                                       // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

    if (empty($notforuptodatepayments) || $amount >= .01) {
      if (sendapprovedmail($email, $emailsubject, $emailbodytemp)) {
        echo "($i) $email successfully sent.<br />";
      }
      else {
        echo "FAILURE TO SEND $email !!!<br />";
      }
      $i++;
    }
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
  $supportuser->email = 'payments@peoples-uni.org';
  $supportuser->firstname = 'Peoples-uni Payments';
  $supportuser->lastname = '';
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  $user->email = 'applicationresponses@peoples-uni.org';

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}


function dontaddslashes($x) {
  return $x;
}


function dontstripslashes($x) {
  return $x;
}


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


function is_not_confirmed($userid) {
  global $DB;

  $balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} AND not_confirmed=1");
  if (!empty($balances)) return TRUE;
  return FALSE;
}
?>
