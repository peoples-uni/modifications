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

    $select_array = array('' => 'Select...', 'R0' => 'Worldwide', 'R1' => 'Africa', 'R2' => 'Americas', 'R3' => 'Asia', 'R4' => 'Europe', 'R5' => 'Oceania');
    $countryname = get_string_manager()->get_list_of_countries(false);
    $countryname = array_merge($select_array, $countryname);

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
