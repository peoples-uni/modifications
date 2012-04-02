<?php

require("../config.php");
//require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/course_report.php');

$PAGE->set_pagelayout('embedded');

require_login();

if ($USER->id != 337) { // Debs Thompson
  // Access is given by the "Manager" role which has moodle/site:viewparticipants
  // (administrator also has moodle/site:viewparticipants)
  require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));
}

$PAGE->set_title('Survey Results');
$PAGE->set_heading('Survey Results');
echo $OUTPUT->header();

echo "<h1>Survey Results</h1>";

$surveys = $DB->get_records_sql('
  SELECT s.*, u.lastname, u.firstname
  FROM mdl_peoples_survey s
  LEFT JOIN mdl_user u ON s.userid=u.id
  WHERE s.hidden=0
  ORDER BY s.datesubmitted DESC');
if (empty($surveys)) {
  $surveys = array();
}

$table = new html_table();

$table->head = array(
  'Submitted',
  'Name',
  'Organisations that deliver public health training...',
  'Organisation -1',
  'Organisation -2',
  'Benefits',
  'Organisations that fund public health training...',
  'Organisation -1',
  'Organisation -2',
  'Organisations that deliver health promotion/health care...',
  'Organisation -1',
  'Organisation -2',
  'Benefits',
);

$n = 0;
foreach ($surveys as $sid => $survey) {
  $rowdata = array();
  $rowdata[] = gmdate('d/m/Y H:i', $survey->datesubmitted);
  $rowdata[] = $survey->lastname . ', ' . $survey->firstname;

  $text = '';
  $text = add_link($text, $survey->deliver_university, 'University');
  $text = add_link($text, $survey->deliver_local_ngo, 'Local NGO');
  $text = add_link($text, $survey->deliver_national_ngo, 'National NGO');
  $text = add_link($text, $survey->deliver_international_ngo, 'International NGO');
  $text = add_link($text, $survey->deliver_professional_bodies, 'Professional Body');
  $text = add_link($text, $survey->deliver_other, 'Other');
  $rowdata[] = $text;

  $rowdata[] = showbody($survey->deliver_body_1, $survey->country_deliver_body_1, $survey->interested_deliver_body_1, $survey->informed_deliver_body_1, $survey->best_way_deliver_body_1);

  $rowdata[] = showbody($survey->deliver_body_2, $survey->country_deliver_body_2, $survey->interested_deliver_body_2, $survey->informed_deliver_body_2, $survey->best_way_deliver_body_2);

  $text = '';
  $text = add_benefit($text, $survey->deliver_diversify, "Training delivery routes");
  $text = add_benefit($text, $survey->deliver_research, "International research");
  $text = add_benefit($text, $survey->deliver_trainers, "Accredited training for trainers");
  $text = add_benefit($text, $survey->deliver_materials, "Training materials");
  $text = add_benefit($text, $survey->deliver_network, "Professional network");
  $text = add_benefit($text, $survey->deliver_students, "Attract students");
  $text = add_benefit($text, $survey->deliver_tutors, "Attract tutors");
  $text = add_benefit($text, $survey->deliver_pastoral, "Pastoral support");
  $text = add_benefit($text, $survey->deliver_other_benefit, "Other");
  $rowdata[] = $text;

  $text = '';
  $text = add_link($text, $survey->fund_national_governments, 'National government');
  $text = add_link($text, $survey->fund_local_governments, 'Local government');
  $text = add_link($text, $survey->fund_local_ngo, 'Local NGO');
  $text = add_link($text, $survey->fund_national_ngo, 'National NGO');
  $text = add_link($text, $survey->fund_international_ngo, 'International NGO');
  $rowdata[] = $text;

  $rowdata[] = showbody($survey->fund_body_1, $survey->country_fund_body_1, $survey->interested_fund_body_1, $survey->informed_fund_body_1, $survey->best_way_fund_body_1);

  $rowdata[] = showbody($survey->fund_body_2, $survey->country_fund_body_2, $survey->interested_fund_body_2, $survey->informed_fund_body_2, $survey->best_way_fund_body_2);

  $text = '';
  $text = add_link($text, $survey->care_national_governments, 'National governments');
  $text = add_link($text, $survey->care_local_governments, 'Local governments');
  $text = add_link($text, $survey->care_local_ngo, 'Local NGO');
  $text = add_link($text, $survey->care_national_ngo, 'National NGO');
  $text = add_link($text, $survey->care_international_ngo, 'International NGO');
  $rowdata[] = $text;

  $rowdata[] = showbody($survey->care_body_1, $survey->country_care_body_1, $survey->interested_care_body_1, $survey->informed_care_body_1, $survey->best_way_care_body_1);

  $rowdata[] = showbody($survey->care_body_2, $survey->country_care_body_2, $survey->interested_care_body_2, $survey->informed_care_body_2, $survey->best_way_care_body_2);

  $text = '';
  $text = add_benefit($text, $survey->care_practice, "Support students to putinto practice");
  $text = add_benefit($text, $survey->care_routes, "Training delivery routes");
  $text = add_benefit($text, $survey->care_materials, "Training materials");
  $text = add_benefit($text, $survey->care_cost, "Low cost training");
  $text = add_benefit($text, $survey->care_other, "Other");
  $rowdata[] = $text;

  $table->data[] = $rowdata;
  $n++;
}
echo html_writer::table($table);

echo '<br />Total Surveys: ' . $n;

echo $OUTPUT->footer();


function add_link($text, $link, $statement) {
  if (!empty($link)) {
    if (!empty($text)) $text .= ', ';
    $text .= $statement;
    if ($link == 'Former Link') $text .= '(former)';
  }
  return $text;
}


function add_benefit($text, $link, $statement) {
  if (!empty($link)) {
    if (!empty($text)) $text .= ', ';
    $text .= $statement;
  }
  return $text;
}


function showbody($body, $country, $interested, $informed, $best_way) {
$countryname[  ''] = 'Select...';
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

  $text = "$body($countryname[$country])";
$text .= '##' .$country. '##';
  if (!empty($country)) $text .= "($countryname[$country])";
  if ($interested == 'Yes') $text .= ', Interested';
  if ($informed == 'Yes') $text .= ', Informed';
  if (!empty($best_way)) $text .= ", $best_way";
  return $text;
}
?>
