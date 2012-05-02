<?php

/**
 * Survey form for Peoples-uni (Form Class)
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class survey_form extends moodleform {

  function definition() {
    global $DB, $CFG;

$countryname[  ''] = 'Select...';
$countryname['R0'] = 'Worldwide';
$countryname['R1'] = 'Africa';
$countryname['R2'] = 'Americas';
$countryname['R3'] = 'Asia';
$countryname['R4'] = 'Europe';
$countryname['R5'] = 'Oceania';
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

$array_interested_choices = array(
  '' => 'Select...',
  'Yes, they are already a partner' => 'Yes, they are already a partner',
  'Yes, they are not a partner yet' => 'Yes, they are not a partner yet',
  'Not Yet' => 'Not Yet',
  "Don't Know" => "Don't Know",
  'No' => 'No',
);

$array_informed_choices = array(
  '' => 'Select...',
  'Yes' => 'Yes',
  'Not Yet' => 'Not Yet',
  'No' => 'No',
);

$inform_method[''] = 'Select...';
$inform_method['e-mail'] = 'e-mail';
$inform_method['Face to face discussion with staff'] = 'Face to face discussion with staff';
$inform_method['Letter'] = 'Letter';
$inform_method['Conference presentation'] = 'Conference presentation';
$inform_method['Social media (eg facebook/twitter)'] = 'Social media (eg facebook/twitter)';
$inform_method['Other'] = 'Other';


    $mform    = $this->_form;


    $mform->addElement('header', 'top', 'Instructions');

    $mform->addElement('static', 'instuctions', '',
"<p><strong>One of the strengths of Peoples-uni is the international networks we have.  Every year peoples-uni continues to grow and take new directions because of the diverse range of people involved.  As a community of tutors and students we have connections across most countries in the world, and across many work settings and different professions.  To enable peoples-uni to develop we want to make sure we take advantage of existing and potential partnerships.  By filling out this form it will help us to learn more about our current networks, and identify opportunities to grow our community of students and tutors.  We'd really appreciate if you can take 10 minutes to fill out this brief questionnaire.  The questions below ask you to comment on the organisations you have a current/former link with, and to think about what benefits those organisations will get by partnering with peoples-uni.  We'll send you this annually so you can update it with any new questions.  Thanks for your time.</strong></p>
<br />
<p>We will not contact anybody based on your responses without permission from you.</p>
<p>We may analyse data to help us improve the course and some of this information might be published in academic journals to help others. No person will be individually identifiable in any publication.</p>
<p><strong>If you have more information or ideas that cannot fit into the format below, please send an e-mail to <a href=\"mailto:debsjkay@gmail.com?subject=Survey\">debsjkay@gmail.com</a></strong></p>
");

    //--------------
    $mform->addElement('header', 'deliver', 'What personal or professional links do you have with organisations that deliver public health training?');

    $mform->addElement('static', 'explain_deliver_university', '&nbsp;', '<br />1.1 Do you have a link with Universities that deliver public health training?');
    $mform->addElement('select', 'deliver_university', 'University', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_deliver_local_ngo', '&nbsp;', '<br />1.2 Do you have a link with Local NGOs that deliver public health training?');
    $mform->addElement('select', 'deliver_local_ngo', 'Local NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_deliver_national_ngo', '&nbsp;', '<br />1.3 Do you have a link with National NGOs that deliver public health training?');
    $mform->addElement('select', 'deliver_national_ngo', 'National NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_deliver_international_ngo', '&nbsp;', '<br />1.4 Do you have a link with International NGOs that deliver public health training?');
    $mform->addElement('select', 'deliver_international_ngo', 'International NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_deliver_professional_bodies', '&nbsp;', '<br />1.5 Do you have a link with Professional Bodies that deliver public health training?');
    $mform->addElement('select', 'deliver_professional_bodies', 'Professional Body', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_deliver_other', '&nbsp;', '<br />1.6 Do you have a link with Other Bodies that deliver public health training?');
    $mform->addElement('select', 'deliver_other', 'Other', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_deliver_body_1', '&nbsp;', '<br />1.7a Enter the name of the main organisation indicated above.');
    $mform->addElement('textarea', 'deliver_body_1', 'Name of Main Organisation Indicated Above', 'wrap="HARD" rows="2" cols="50"');

    $mform->addElement('static', 'explain_country_deliver_body_1', '&nbsp;', '<br />1.8a Select the Country or Region in which this organisation does its work.');
    $mform->addElement('select', 'country_deliver_body_1', 'Country of this Organisation', $countryname);

    $mform->addElement('static', 'explain_interested_deliver_body_1', '&nbsp;', '<br />1.9a Do you think this organisation would be interested in developing a partnership with Peoples-uni?');
    $mform->addElement('select', 'interested_deliver_body_1', 'Interested', $array_interested_choices);

    $mform->addElement('static', 'explain_informed_deliver_body_1', '&nbsp;', '<br />1.10a Is this organisation already linked with Peoples-uni?');
    $mform->addElement('select', 'informed_deliver_body_1', 'Linked', $array_informed_choices);

    $mform->addElement('static', 'explain_best_way_deliver_body_1', '&nbsp;', '<br />1.11a What is the best way of informing this organisation/the members about Peoples-uni?');
    $mform->addElement('select', 'best_way_deliver_body_1', 'Best way of Informing', $inform_method);

    $mform->addElement('static', 'explain_deliver_body_2', '&nbsp;', '<br />1.7b Enter the names of the other organisations indicated above.');
    $mform->addElement('textarea', 'deliver_body_2', 'Names of Other Organisations Indicated Above', 'wrap="HARD" rows="2" cols="50"');

    $mform->addElement('static', 'explain_country_deliver_body_2', '&nbsp;', '<br />1.8b Select the Country or Region in which this organisation does its work.');
    $mform->addElement('select', 'country_deliver_body_2', 'Country of this Organisation', $countryname);

    $mform->addElement('static', 'explain_interested_deliver_body_2', '&nbsp;', '<br />1.9b Do you think this organisation would be interested in developing a partnership with Peoples-uni?');
    $mform->addElement('select', 'interested_deliver_body_2', 'Interested', $array_interested_choices);

    $mform->addElement('static', 'explain_informed_deliver_body_2', '&nbsp;', '<br />1.10b Is this organisation already linked with Peoples-uni?');
    $mform->addElement('select', 'informed_deliver_body_2', 'Linked', $array_informed_choices);

    $mform->addElement('static', 'explain_best_way_deliver_body_2', '&nbsp;', '<br />1.11b What is the best way of informing this organisation/the members about Peoples-uni?');
    $mform->addElement('select', 'best_way_deliver_body_2', 'Best way of Informing', $inform_method);

    $mform->addElement('static', 'explain_deliver_partnership', '&nbsp;', '<br /><br />What do you think would be the main advantage to these organisation(s) of developing a partnership with Peoples-uni?...');

    $mform->addElement('checkbox', 'deliver_diversify', "1.12 Diversify the organisation's range of training delivery routes");
    $mform->addElement('checkbox', 'deliver_research', "1.13 Provide opportunities for international research");
    $mform->addElement('checkbox', 'deliver_trainers', "1.14 Provide high quality, accredited training opportunities for trainers");
    $mform->addElement('checkbox', 'deliver_materials', "1.15 Provide access to high standard training materials");
    $mform->addElement('checkbox', 'deliver_network', "1.16 Provide access to international professional network (via web platform)");
    $mform->addElement('checkbox', 'deliver_students', "1.17 Attract students to Peoples-uni");
    $mform->addElement('checkbox', 'deliver_tutors', "1.18 Attract tutors to Peoples-uni");
    $mform->addElement('checkbox', 'deliver_pastoral', "1.19 Provide pastoral support");
    $mform->addElement('checkbox', 'deliver_other_benefit', "1.20 Other");

    //--------------
    $mform->addElement('header', 'fund', 'What personal or professional links do you have with organisations that fund public health training?');

    $mform->addElement('static', 'explain_fund_national_governments', '&nbsp;', '<br />2.1 Do you have a link with National Governments that fund public health training?');
    $mform->addElement('select', 'fund_national_governments', 'National Governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_fund_local_governments', '&nbsp;', '<br />2.2 Do you have a link with Local Governments that fund public health training?');
    $mform->addElement('select', 'fund_local_governments', 'Local Governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_fund_local_ngo', '&nbsp;', '<br />2.3 Do you have a link with Local NGOs that fund public health training?');
    $mform->addElement('select', 'fund_local_ngo', 'Local NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_fund_national_ngo', '&nbsp;', '<br />2.4 Do you have a link with National NGOs that fund public health training?');
    $mform->addElement('select', 'fund_national_ngo', 'National NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_fund_international_ngo', '&nbsp;', '<br />2.5 Do you have a link with International NGOs that fund public health training?');
    $mform->addElement('select', 'fund_international_ngo', 'International NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_fund_body_1', '&nbsp;', '<br />2.6a Enter the name of the main organisation indicated above.');
    $mform->addElement('textarea', 'fund_body_1', 'Name of Main Organisation Indicated Above', 'wrap="HARD" rows="2" cols="50"');

    $mform->addElement('static', 'explain_country_fund_body_1', '&nbsp;', '<br />2.7a Select the Country or Region in which this organisation does its work.');
    $mform->addElement('select', 'country_fund_body_1', 'Country of this Organisation', $countryname);

    $mform->addElement('static', 'explain_interested_fund_body_1', '&nbsp;', '<br />2.8a Do you think this organisation would be interested in developing a partnership with Peoples-uni?');
    $mform->addElement('select', 'interested_fund_body_1', 'Interested', $array_interested_choices);

    $mform->addElement('static', 'explain_informed_fund_body_1', '&nbsp;', '<br />2.9a Is this organisation already linked with Peoples-uni?');
    $mform->addElement('select', 'informed_fund_body_1', 'Linked', $array_informed_choices);

    $mform->addElement('static', 'explain_best_way_fund_body_1', '&nbsp;', '<br />2.10a What is the best way of informing this organisation/the members about Peoples-uni?');
    $mform->addElement('select', 'best_way_fund_body_1', 'Best way of Informing', $inform_method);

    $mform->addElement('static', 'explain_fund_body_2', '&nbsp;', '<br />2.6b Enter the names of the other organisations indicated above.');
    $mform->addElement('textarea', 'fund_body_2', 'Names of Other Organisations Indicated Above', 'wrap="HARD" rows="2" cols="50"');

    $mform->addElement('static', 'explain_country_fund_body_2', '&nbsp;', '<br />2.7b Select the Country or Region in which this organisation does its work.');
    $mform->addElement('select', 'country_fund_body_2', 'Country of this Organisation', $countryname);

    $mform->addElement('static', 'explain_interested_fund_body_2', '&nbsp;', '<br />2.8b Do you think this organisation would be interested in developing a partnership with Peoples-uni?');
    $mform->addElement('select', 'interested_fund_body_2', 'Interested', $array_interested_choices);

    $mform->addElement('static', 'explain_informed_fund_body_2', '&nbsp;', '<br />2.9b Is this organisation already linked with Peoples-uni?');
    $mform->addElement('select', 'informed_fund_body_2', 'Linked', $array_informed_choices);

    $mform->addElement('static', 'explain_best_way_fund_body_2', '&nbsp;', '<br />2.10b What is the best way of informing this organisation/the members about Peoples-uni?');
    $mform->addElement('select', 'best_way_fund_body_2', 'Best way of Informing', $inform_method);

    //--------------
    $mform->addElement('header', 'care', 'What personal or professional links do you have with organisations that deliver health promotion/health care/ other public health policy/service?');

    $mform->addElement('static', 'explain_care_national_governments', '&nbsp;', '<br />3.1 Do you have a link with National Governments that deliver health promotion/health care/ other public health policy/service?');
    $mform->addElement('select', 'care_national_governments', 'National Governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_care_local_governments', '&nbsp;', '<br />3.2 Do you have a link with Local Governments that deliver health promotion/health care/ other public health policy/service?');
    $mform->addElement('select', 'care_local_governments', 'Local Governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_care_local_ngo', '&nbsp;', '<br />3.3 Do you have a link with Local NGOs that deliver health promotion/health care/ other public health policy/service?');
    $mform->addElement('select', 'care_local_ngo', 'Local NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_care_national_ngo', '&nbsp;', '<br />3.4 Do you have a link with National NGOs that deliver health promotion/health care/ other public health policy/service?');
    $mform->addElement('select', 'care_national_ngo', 'National NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_care_international_ngo', '&nbsp;', '<br />3.5 Do you have a link with International NGOs that deliver health promotion/health care/ other public health policy/service?');
    $mform->addElement('select', 'care_international_ngo', 'International NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));

    $mform->addElement('static', 'explain_care_body_1', '&nbsp;', '<br />3.6a Enter the name of the main organisation indicated above.');
    $mform->addElement('textarea', 'care_body_1', 'Name of Main Organisation Indicated Above', 'wrap="HARD" rows="2" cols="50"');

    $mform->addElement('static', 'explain_country_care_body_1', '&nbsp;', '<br />3.7a Select the Country or Region in which this organisation does its work.');
    $mform->addElement('select', 'country_care_body_1', 'Country of this Organisation', $countryname);

    $mform->addElement('static', 'explain_interested_care_body_1', '&nbsp;', '<br />3.8a Do you think this organisation would be interested in developing a partnership with Peoples-uni?');
    $mform->addElement('select', 'interested_care_body_1', 'Interested', $array_interested_choices);

    $mform->addElement('static', 'explain_informed_care_body_1', '&nbsp;', '<br />3.9a Is this organisation already linked with Peoples-uni?');
    $mform->addElement('select', 'informed_care_body_1', 'Linked', $array_informed_choices);

    $mform->addElement('static', 'explain_best_way_care_body_1', '&nbsp;', '<br />3.10a What is the best way of informing this organisation/the members about Peoples-uni?');
    $mform->addElement('select', 'best_way_care_body_1', 'Best way of Informing', $inform_method);

    $mform->addElement('static', 'explain_care_body_2', '&nbsp;', '<br />3.6b Enter the names of the other organisations indicated above.');
    $mform->addElement('textarea', 'care_body_2', 'Names of Other Organisations Indicated Above', 'wrap="HARD" rows="2" cols="50"');

    $mform->addElement('static', 'explain_country_care_body_2', '&nbsp;', '<br />3.7b Select the Country or Region in which this organisation does its work.');
    $mform->addElement('select', 'country_care_body_2', 'Country of this Organisation', $countryname);

    $mform->addElement('static', 'explain_interested_care_body_2', '&nbsp;', '<br />3.8b Do you think this organisation would be interested in developing a partnership with Peoples-uni?');
    $mform->addElement('select', 'interested_care_body_2', 'Interested', $array_interested_choices);

    $mform->addElement('static', 'explain_informed_care_body_2', '&nbsp;', '<br />3.9b Is this organisation already linked with Peoples-uni?');
    $mform->addElement('select', 'informed_care_body_2', 'Linked', $array_informed_choices);

    $mform->addElement('static', 'explain_best_way_care_body_2', '&nbsp;', '<br />3.10b What is the best way of informing this organisation/the members about Peoples-uni?');
    $mform->addElement('select', 'best_way_care_body_2', 'Best way of Informing', $inform_method);

    $mform->addElement('static', 'explain_care_partnership', '&nbsp;', '<br /><br />What do you think would be the main advantage to these organisation(s) of developing a partnership with Peoples-uni?...');

    $mform->addElement('checkbox', 'care_practice', "3.11 Support students to put what they learnt into practice");
    $mform->addElement('checkbox', 'care_routes', "3.12 Diversify their range of training delivery routes");
    $mform->addElement('checkbox', 'care_materials', "3.13 Provide access to high standard training materials");
    $mform->addElement('checkbox', 'care_cost', "3.14 provide low cost training");
    $mform->addElement('checkbox', 'care_other', "3.15 Other");


    $this->add_action_buttons(false, 'Submit Form');

    //$this->set_data($data);
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    return $errors;
  }
}
