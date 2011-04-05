<?php

/**
 * Application form for Peoples-uni for New Students (Form Class)
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class application_form_new_student_form extends moodleform {

  function definition() {
    global $DB, $CFG;

$countryname[  ''] = '';
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
//foreach($countryname as $name) $countrynameint[] = $name;
//$countrynameint = $countryname;

    $mform    = $this->_form;

    $mform->addElement('hidden', 'returnto', null);
    $mform->setType('returnto', PARAM_ALPHANUM);
    $mform->setConstant('returnto', $returnto);


    $mform->addElement('header', 'top', 'Instructions');

    $mform->addElement('static', 'instuctions', '',
'<p>Please read the information in <a href="http://www.peoples-uni.org/book/essential-information-potential-students">Essential information for potential students</a> before submitting this form, particularly see the information about <a href="http://peoples-uni.org/book/course-fees">Course fees</a></p>
<p><strong>Use this form for your <u>first</u> application to do one or two training course modules in the semester in which you wish to start.<br /><br /></strong></p>
<p>For inquires about registration or payment please send an email to  <a href="mailto:apply@peoples-uni.org?subject=Registration or payment query">apply@peoples-uni.org</a>.</p>
<p><strong>Note:</strong> You must complete the fields marked with a red <span style="color:#ff0000">*</span>.</p>
<p><strong>You should receive an e-mail with a copy of your application when you submit this form. If you do not, it means that we cannot reach your e-mail address. In that case please send a mail to <a href="mailto:techsupport@peoples-uni.org">techsupport@peoples-uni.org</a>.</strong></p>');


    $semester_current = $DB->get_record('semester_current', array('id' => 1));
    $mform->addElement('header', 'modules', "Course Module Selection for Semester $semester_current->semester");

    $open_modules = $DB->get_records('activemodules', array('modulefull' => 0));
    if (empty($open_modules)) {
      redirect($CFG->wwwroot . '/course/interest_form.php');
    }

    $activemodules = $DB->get_records('activemodules', NULL, 'fullname ASC');

    $listforselect = array();
    $listforselect[''] = '';
    $listforunavailable = array();
    foreach ($activemodules as $activemodule) {
      if (!$activemodule->modulefull) {
        $listforselect[$activemodule->course_id] = $activemodule->fullname;
      }
      else {
        $listforunavailable[] = "'" . $activemodule->fullname . "'";
      }
    }
    $count = count($listforunavailable);
    $listforunavailable = implode(", ", $listforunavailable);

    $text = 'Please select the first course module you are applying for from the drop down box.';
    if ($count > 1) {
      $text .= ' Note: ' . $listforunavailable . ' are not available for this semester because they are full.';
    }
    elseif ($count == 1) {
      $text .= ' Note: ' . $listforunavailable . ' is not available for this semester because it is full.';
    }

    $mform->addElement('select', 'course_id_1', 'First module', $listforselect);
    $mform->addRule('course_id_1', 'First Module is required', 'required', null, 'client');
    $mform->addElement('static', 'explain1', '&nbsp;', $text . '<br />');

    $mform->addElement('select', 'course_id_2', 'Second module', $listforselect);
    $mform->addElement('static', 'explain2', '&nbsp;', 'If you want do apply to do two modules in the same semester, select the second course module here. Please realise that both modules will run at the same time and the workload may be heavy, be sure that you do have the time if you elect to take two modules in the same semester.<br />');


    $mform->addElement('header', 'personaldetails', 'Personal details');

    $mform->addElement('text', 'lastname', 'Family name', 'maxlength="100" size="50"');
    $mform->addRule('lastname', 'Family name is required', 'required', null, 'client');
    $mform->setType('lastname', PARAM_MULTILANG);
    $mform->addElement('static', 'explainlastname', '&nbsp;', 'Your Family name or Surname.<br />');

    $mform->addElement('text', 'firstname', 'Given name', 'maxlength="100" size="50"');
//    $mform->addRule('firstname', 'Given name is required', 'required', null, 'client');
    $mform->setType('firstname', PARAM_MULTILANG);
    $mform->addElement('static', 'explainfirstname', '&nbsp;', 'Your first or given name(s).<br />');

    $mform->addElement('text', 'email', 'Email address', 'maxlength="100" size="50"');
//    $mform->addRule('email', 'Email is required', 'required', null, 'client');
    $mform->addRule('email', 'Email must be a valid e-mail address', 'email');
    $mform->setType('email', PARAM_NOTAGS);
    $mform->addElement('static', 'explainemail', '&nbsp;', 'Your email Address. We will send you a copy of your application to this email address.<br />');

    $mform->addElement('text', 'email2', 'Email verification', 'maxlength="100" size="50"');
//    $mform->addRule('email2', 'Email verification is required', 'required', null, 'client');
//    $mform->addRule('email2', 'Email must be a valid e-mail address', 'email');
    $mform->setType('email2', PARAM_NOTAGS);
    $mform->addElement('static', 'explainemail2', '&nbsp;', 'Must match first e-mail.<br />');

    $mform->addElement('date_selector', 'dob', 'Date of Birth', array('startyear' => 1930, 'stopyear' => 2000));
    //$mform->addRule('dob', 'Date of Birth is required', 'required', null, 'client');

    $genderarray = array();
    $genderarray[] = &MoodleQuickForm::createElement('radio', 'gendermf', '', 'Male', 'male');
    $genderarray[] = &MoodleQuickForm::createElement('radio', 'gendermf', '', 'Female', 'female');
    $mform->addGroup($genderarray, 'gender', 'Gender', array(' '), false);
    //$mform->addRule('gender', 'Gender is required', 'required', null, 'client');
    $mform->addElement('static', 'explaingender', '&nbsp;', 'Select your gender: Male or Female.<br />');

    $mform->addElement('textarea', 'applicationaddress', 'Address', 'wrap="HARD" rows="7" cols="50"');
//    $mform->addRule('applicationaddress', 'Address is required', 'required', null, 'client');

    $mform->addElement('static', 'explainapplicationaddress', '&nbsp;', 'Your full postal address.<br />');

    $mform->addElement('text', 'city', 'City/Town', 'maxlength="20" size="50"');
//    $mform->addRule('city', 'City/Town is required', 'required', null, 'client');
    $mform->setType('city', PARAM_MULTILANG);
    $mform->addElement('static', 'explaincity', '&nbsp;', 'Your City or Town for display in Moodle.<br />');

    $mform->addElement('select', 'country', 'Country', $countryname);
    $mform->addRule('country', 'Country is required', 'required', null, 'client');
    $mform->addElement('static', 'explaincountry', '&nbsp;', 'Your country of residence. Select from list.<br />');

    $mform->addElement('textarea', 'reasons', 'Reasons for wanting to enrol', 'wrap="HARD" rows="10" cols="100"');
//    $mform->addRule('reasons', 'Reasons for wanting to enrol is required', 'required', null, 'client');
    $mform->addElement('static', 'explainreasons', '&nbsp;', 'Please tell us your reasons for wanting to enrol in this course in up to 150 words.<br />');

    $mform->addElement('text', 'username', 'Preferred Username', 'maxlength="100" size="50"');
//    $mform->addRule('username', 'Preferred Username is required', 'required', null, 'client');
    $mform->setType('username', PARAM_MULTILANG);
    $mform->addElement('static', 'explainusername', '&nbsp;', 'Please enter your desired Username for logging in to our education site, for example your first name.<br />');


    $mform->addElement('header', 'educationdetails', 'Education and Employment details');

    $qualificationname[  ''] = '';
    $qualificationname[ '1'] = 'None';
    $qualificationname['10'] = 'Degree (not health related)';
    $qualificationname['20'] = 'Health qualification (non-degree)';
    $qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
    $qualificationname['40'] = 'Medical degree';
    $mform->addElement('select', 'qualification', 'Higher Education Qualification', $qualificationname);
    $mform->addRule('qualification', 'Higher Education Qualification is required', 'required', null, 'client');
    $mform->addElement('static', 'explainqualification', '&nbsp;', 'Select the option that best describes your Higher Education Qualification.<br />');

    $higherqualificationname[  ''] = '';
    $higherqualificationname[ '1'] = 'None';
    $higherqualificationname['10'] = 'Certificate';
    $higherqualificationname['20'] = 'Diploma';
    $higherqualificationname['30'] = 'Masters';
    $higherqualificationname['40'] = 'Ph.D.';
    $higherqualificationname['50'] = 'Other';
    $mform->addElement('select', 'higherqualification', 'Postgraduate Qualification', $higherqualificationname);
//    $mform->addRule('higherqualification', 'Postgraduate Qualification is required', 'required', null, 'client');
    $mform->addElement('static', 'explainhigherqualification', '&nbsp;', 'Select the option that best describes your Postgraduate Qualification.<br />');

    $mform->addElement('textarea', 'education', 'Other relevant qualifications or educational experience', 'wrap="HARD" rows="10" cols="100"');
    $mform->addElement('static', 'explaineducation', '&nbsp;', 'You can add any details about any of your relevant qualifications or educational experience.<br />');

    $employmentname[  ''] = '';
    $employmentname[ '1'] = 'None';
    $employmentname['10'] = 'Student';
    $employmentname['20'] = 'Non-health';
    $employmentname['30'] = 'Clinical (not specifically public health)';
    $employmentname['40'] = 'Public health';
    $employmentname['50'] = 'Other health related';
    $employmentname['60'] = 'Academic occupation (e.g. lecturer)';
    $mform->addElement('select', 'employment', 'Current Employment', $employmentname);
//    $mform->addRule('employment', 'Current Employment is required', 'required', null, 'client');
    $mform->addElement('static', 'explainemployment', '&nbsp;', 'Select the option that best describes your Current Employment.<br />');

    $mform->addElement('textarea', 'currentjob', 'Current Employment Details', 'wrap="HARD" rows="10" cols="100"');
    $mform->addElement('static', 'explaincurrentjob', '&nbsp;', 'You can add any details about your current employment.<br />');

    $this->add_action_buttons();

    //$this->set_data($data);
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    if ($data['course_id_1'] === $data['course_id_2']) $errors['course_id_1']         = 'You have selected the same module as your first and second choice. Either remove the second selection (by selecting the `select..???` message at the top of the option list) or change the second module selected';
    if ($data['email'] !== $data['email2'])            $errors['email']               = 'Email address does not match Email verification, they must be the same';

//    if (empty($data['course_id_1']))                   $errors['course_id_1']         = 'First module is required'. $data['course_id_1'] . 'SERVER';
//    if (empty($data['country']))                       $errors['country']             = 'Country is required';
    if (empty($data['dob']))                           $errors['dob']                 = 'Date of Birth is required';
    if (empty($data['gender']))                        $errors['gender']              = 'Gender is required';
//    if (empty($data['qualification']))                 $errors['qualification']       = 'Higher Education Qualification is required';
//    if (empty($data['higherqualification']))           $errors['higherqualification'] = 'Postgraduate Qualification is required';
//    if (empty($data['employment']))                    $errors['employment']          = 'Current Employment is required';

    return $errors;
  }
}
