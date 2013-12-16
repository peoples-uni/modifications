<?php

/**
 * Tutor Registration Edit form for Peoples-uni Tutors (Form Class)
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class tutor_registration_edit_form extends moodleform {

  function definition() {
    global $DB, $CFG;

    $mform = $this->_form;
    $customdata = $this->_customdata['customdata'];
    $userid = $customdata['userid'];(**)use to load default data or instead pass tutor application id???


    $mform->addElement('header', 'top', 'Instructions');

    $mform->addElement('static', 'instuctions', '',
'
<p>Edit Volunteer Registration.<br /></p>
');


    $mform->addElement('header', 'personaldetails', 'Personal details');

    $mform->addElement('textarea', 'reasons', 'Reasons for wanting to volunteer for Peoples-uni', 'wrap="HARD" rows="10" cols="100"');
$mform->setDefault('email', 'Please enter email');(**)
    $mform->addRule('reasons', 'Reasons for wanting to volunteer for Peoples-uni is required', 'required', null, 'client');
    $mform->addElement('static', 'explainreasons', '&nbsp;', 'Please tell us your reasons for wanting to volunteer for Peoples-uni in up to 150 words.<br />');


    $mform->addElement('header', 'educationdetails', 'Education and Employment details');

    $mform->addElement('textarea', 'education', 'Relevant qualifications (academic and professional)', 'wrap="HARD" rows="10" cols="100"');
$mform->setDefault('email', 'Please enter email');(**)
    $mform->addRule('education', 'Relevant qualifications (academic and professional) is required', 'required', null, 'client');
    $mform->addElement('static', 'explaineducation', '&nbsp;', 'Add details about any of your Relevant qualifications (academic and professional).<br />
If you have a degree please indicate name of degree, awarding institution and also the language of instruction.<br />
If you have a postgraduate qualification, please indicate name of qualification, awarding institution and also the language of instruction.<br />');

    $mform->addElement('textarea', 'tutoringexperience', 'Educational/tutoring experience', 'wrap="HARD" rows="10" cols="100"');
$mform->setDefault('email', 'Please enter email');(**)
    $mform->addElement('static', 'explaintutoringexperience', '&nbsp;', 'Please briefly tell us about any educational/tutoring experience you may have.<br />');

    $mform->addElement('textarea', 'currentjob', 'Current employer', 'wrap="HARD" rows="10" cols="100"');
$mform->setDefault('email', 'Please enter email');(**)
    $mform->addRule('currentjob', 'Current employer is required', 'required', null, 'client');
    $mform->addElement('static', 'explaincurrentjob', '&nbsp;', 'Add name of your current employer.<br />');

    $mform->addElement('textarea', 'currentrole', 'Current role', 'wrap="HARD" rows="10" cols="100"');
$mform->setDefault('email', 'Please enter email');(**)
    $mform->addRule('currentrole', 'Current role is required', 'required', null, 'client');
    $mform->addElement('static', 'explaincurrentrole', '&nbsp;', 'Add details about your current role.<br />');

    $mform->addElement('textarea', 'otherinformation', 'Other information', 'wrap="HARD" rows="10" cols="100"');
$mform->setDefault('email', 'Please enter email');(**)
    $mform->addElement('static', 'explainotherinformation', '&nbsp;', 'Any other information you want us to know about you.<br />');


    $mform->addElement('header', 'howfounddetails', 'How did you hear about Peoples-uni?');

    $howfoundpeoplesname[  ''] = 'Select...';
    $howfoundpeoplesname['10'] = 'Informed by another Peoples-uni student or tutor';
    $howfoundpeoplesname['20'] = 'Informed by someone else';
    $howfoundpeoplesname['30'] = 'Facebook';
    $howfoundpeoplesname['40'] = 'Internet advertisement';
    $howfoundpeoplesname['50'] = 'Link from another website or discussion forum';
    $howfoundpeoplesname['60'] = 'I used a search engine to look for courses, volunteering opportunities or other';
    $howfoundpeoplesname['70'] = 'Referral from Partnership Institution';
    $howfoundpeoplesname['80'] = 'Read or heard about from news article, journal or advertisement';
    $mform->addElement('select', 'howfoundpeoples', 'How did you hear about Peoples-uni?', $howfoundpeoplesname);
$mform->setDefault('email', 'Please enter email');(**)
    $mform->addRule('howfoundpeoples', 'How did you hear about Peoples-uni is required', 'required', null, 'client');
    $mform->addElement('static', 'explainhowfoundpeoples', '&nbsp;', 'Select the option that best describes how you heard about Peoples-uni.<br />');

    $mform->addElement('text', 'howfoundorganisationname', 'Name of the organisation or person from whom you heard about Peoples-uni', 'maxlength="100" size="50"');
    $mform->setType('howfoundorganisationname', PARAM_MULTILANG);
$mform->setDefault('email', 'Please enter email');(**)
    $mform->addElement('static', 'explainhowfoundorganisationname', '&nbsp;', 'Please enter the name of the organisation, person or website from whom you heard about Peoples-uni.<br />');


    $this->add_action_buttons(false, 'Submit Form');

    //$this->set_data($data);
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    return $errors;
  }
}
