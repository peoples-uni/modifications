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

    $mform    = $this->_form;


    $mform->addElement('header', 'top', 'Instructions');

    $mform->addElement('static', 'instuctions', '',
"<p><strong>One of the strengths of Peoples-uni is the international networks we have.  Every year peoples-uni continues to grow and take new directions because of the diverse range of people involved.  As a community of tutors and students we have connections across most countries in the world, and across many work settings and different professions.  To enable peoples-uni to develop we want to make sure we take advantage of existing and potential partnerships.  By filling out this form it will help us to learn more about our current networks, and identify opportunities to grow our community of students and tutors.  We'd really appreciate if you can take 10 minutes to fill out this brief questionnaire.  The questions below ask you to comment on the organisations you have a current/former link with, and to think about what benefits those organisations will get by partnering with peoples-uni.  We'll send you this annually so you can update it with any new questions.  Thanks for your time.</strong></p>
<br />
<p>We will not contact anybody based on your responses without permission from you.</p>
<p>We may analyse data to help us improve the course and some of this information might be published in academic journals to help others. No person will be individually identifiable in any publication.</p>
");

    //--------------
    $mform->addElement('header', 'deliver', 'What personal or professional links do you have with organisations that deliver public health training?');

    $mform->addElement('select', 'deliver_university', 'University', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_deliver_university', '&nbsp;', 'Do you have a link with Universities that deliver public health training?.<br />');

    $mform->addElement('select', 'deliver_local_ngo', 'Local NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_deliver_local_ngo', '&nbsp;', 'Do you have a link with Local NGOs that deliver public health training?.<br />');

    $mform->addElement('select', 'deliver_national_ngo', 'National NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_deliver_national_ngo', '&nbsp;', 'Do you have a link with National NGOs that deliver public health training?.<br />');

    $mform->addElement('select', 'deliver_international_ngo', 'International NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_deliver_international_ngo', '&nbsp;', 'Do you have a link with International NGOs that deliver public health training?.<br />');

    $mform->addElement('select', 'deliver_professional_bodies', 'Professional Body', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_deliver_professional_bodies', '&nbsp;', 'Do you have a link with Professional Bodies that deliver public health training?.<br />');

    $mform->addElement('select', 'deliver_other', 'Other', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_deliver_other', '&nbsp;', 'Do you have a link with Other Bodies that deliver public health training?.<br />');

    $mform->addElement('textarea', 'deliver_body', 'Names of Bodies Indicated Above', 'wrap="HARD" rows="3" cols="50"');
    $mform->addElement('static', 'explain_deliver_body', '&nbsp;', 'Enter the Names of all Bodies Indicated Above.<br />');

    $mform->addElement('static', 'explain_deliver_partnership', '&nbsp;', '<br /><br />What are the main benefits of Peoples-uni developing a partnership with these Bodies?...');

    $mform->addElement('checkbox', 'deliver_diversify', "Diversify the organisation's range of training delivery routes");
    $mform->addElement('checkbox', 'deliver_research', "Provide opportunities for international research");
    $mform->addElement('checkbox', 'deliver_trainers', "Provide high quality, accredited training opportunities for trainers");
    $mform->addElement('checkbox', 'deliver_materials', "Provide access to high standard training materials");
    $mform->addElement('checkbox', 'deliver_network', "Provide access to international professional network (via web platform)");
    $mform->addElement('checkbox', 'deliver_students', "Attract students to Peoples-uni");
    $mform->addElement('checkbox', 'deliver_tutors', "Attract tutors to Peoples-uni");
    $mform->addElement('checkbox', 'deliver_pastoral', "Provide pastoral support");
    $mform->addElement('checkbox', 'deliver_other_benefit', "Other");

    //--------------
    $mform->addElement('header', 'fund', 'What personal or professional links do you have with organisations that fund public health training?');

    $mform->addElement('select', 'fund_national_governments', 'National governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_fund_national_governments', '&nbsp;', 'Do you have a link with National governments that fund public health training?.<br />');

    $mform->addElement('select', 'fund_local_governments', 'Local governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_fund_local_governments', '&nbsp;', 'Do you have a link with Local governments that fund public health training?.<br />');

    $mform->addElement('select', 'fund_local_ngo', 'Local NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_fund_local_ngo', '&nbsp;', 'Do you have a link with Local NGOs that fund public health training?.<br />');

    $mform->addElement('select', 'fund_national_ngo', 'National NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_fund_national_ngo', '&nbsp;', 'Do you have a link with National NGOs that fund public health training?.<br />');

    $mform->addElement('select', 'fund_international_ngo', 'International NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_fund_international_ngo', '&nbsp;', 'Do you have a link with International NGOs that fund public health training?.<br />');

    $mform->addElement('textarea', 'fund_body', 'Names of Bodies Indicated Above', 'wrap="HARD" rows="3" cols="50"');
    $mform->addElement('static', 'explain_fund_body', '&nbsp;', 'Enter the Names of all Bodies Indicated Above.<br />');

    //--------------
    $mform->addElement('header', 'care', 'What personal or professional links do you have with organisations that deliver health promotion/health care?');

    $mform->addElement('select', 'care_national_governments', 'National governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_care_national_governments', '&nbsp;', 'Do you have a link with National governments that deliver health promotion/health care?.<br />');

    $mform->addElement('select', 'care_local_governments', 'Local governments', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_care_local_governments', '&nbsp;', 'Do you have a link with Local governments that deliver health promotion/health care?.<br />');

    $mform->addElement('select', 'care_local_ngo', 'Local NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_care_local_ngo', '&nbsp;', 'Do you have a link with Local NGOs that deliver health promotion/health care?.<br />');

    $mform->addElement('select', 'care_national_ngo', 'National NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_care_national_ngo', '&nbsp;', 'Do you have a link with National NGOs that deliver health promotion/health care?.<br />');

    $mform->addElement('select', 'care_international_ngo', 'International NGO', array('' => 'None', 'Current Link' => 'Current Link', 'Former Link' => 'Former Link'));
    $mform->addElement('static', 'explain_care_international_ngo', '&nbsp;', 'Do you have a link with International NGOs that deliver health promotion/health care?.<br />');

    $mform->addElement('textarea', 'care_body', 'Names of Bodies Indicated Above', 'wrap="HARD" rows="3" cols="50"');
    $mform->addElement('static', 'explain_care_body', '&nbsp;', 'Enter the Names of all Bodies Indicated Above.<br />');

    $mform->addElement('static', 'explain_care_partnership', '&nbsp;', '<br /><br />What are the benefits of peoples-uni developing a partnership with this organisation?...');

    $mform->addElement('checkbox', 'care_practice', "Support students to put what they learnt into practice");
    $mform->addElement('checkbox', 'care_routes', "Diversify their range of training delivery routes");
    $mform->addElement('checkbox', 'care_materials', "Provide access to high standard training materials");
    $mform->addElement('checkbox', 'care_cost', "provide low cost training");
    $mform->addElement('checkbox', 'care_other', "Other");


    $this->add_action_buttons(false, 'Submit Form');

    //$this->set_data($data);
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    return $errors;
  }
}
