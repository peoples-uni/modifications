<?php

/**
 * Tutor Registration form for Peoples-uni for New Tutors (Form Class)
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class tutor_registration_form extends moodleform {

  function definition() {
    global $DB, $CFG;

    $select_array = array('' => 'Select...');
    $countryname = get_string_manager()->get_list_of_countries(false);
    $countryname = array_merge($select_array, $countryname);

    $mform    = $this->_form;


    $mform->addElement('header', 'top', 'Instructions');

    $mform->addElement('static', 'instuctions', '',
'
<p>This form is for you to volunteer for Peoples-uni.<br /></p>
<p>Many thanks for offering to volunteer for Peoples-uni. This form is to help us with record keeping. Once you have submitted this form and we have read it, you will receive e-mails with further information.<br /></p>
<p><strong>Note:</strong> Only use this from if you are new to Peoples-uni and therefore do not have a Moodle account. If you have a courses.peoples-uni.org account, <a href="' . $CFG->wwwroot . '/course/tutor_registration_existing.php">please Click Here to volunteer.</a></p>
<p>For inquiries about volunteering please send an email to <a href="mailto:contact@peoples-uni.org?subject=Volunteering query">contact@peoples-uni.org</a>.</p>
<p><strong>Note:</strong> You must complete the fields marked with a red <span style="color:#ff0000">*</span>.</p>
<p><strong>You should receive an e-mail with a copy of your application soon after you submit this form. If you do not, it means that we cannot reach your e-mail address. In that case please send an e-mail to <a href="mailto:apply@peoples-uni.org">apply@peoples-uni.org</a>.</strong></p>
');


    $mform->addElement('header', 'personaldetails', 'Personal details');

    $mform->addElement('text', 'lastname', 'Family name', 'maxlength="100" size="50"');
    $mform->addRule('lastname', 'Family name is required', 'required', null, 'client');
    $mform->setType('lastname', PARAM_NOTAGS);
    $mform->addElement('static', 'explainlastname', '&nbsp;', 'Your Family name or Surname.<br />');

    $mform->addElement('text', 'firstname', 'Given name', 'maxlength="100" size="50"');
    $mform->addRule('firstname', 'Given name is required', 'required', null, 'client');
    $mform->setType('firstname', PARAM_NOTAGS);
    $mform->addElement('static', 'explainfirstname', '&nbsp;', 'Your first or given name(s).<br />');

    $mform->addElement('select', 'gender', 'Gender', array('' => 'Select...', 'Female' => 'Female', 'Male' => 'Male'));
    $mform->addRule('gender', 'Gender is required', 'required', null, 'client');
    $mform->addElement('static', 'explaingender', '&nbsp;', 'Select your gender: Male or Female.<br />');

    $mform->addElement('text', 'email', 'Email address', 'maxlength="100" size="50"');
    $mform->addRule('email', 'Email is required', 'required', null, 'client');
    $mform->addRule('email', 'Email must be a valid e-mail address', 'email');
    $mform->setType('email', PARAM_EMAIL);
    $mform->addElement('static', 'explainemail', '&nbsp;', 'Your email Address. We will send you a copy of your application to this email address.<br />');

    $mform->addElement('text', 'email2', 'Email verification', 'maxlength="100" size="50"');
    $mform->addRule('email2', 'Email verification is required', 'required', null, 'client');
    $mform->addRule('email2', 'Email must be a valid e-mail address', 'email');
    $mform->setType('email2', PARAM_EMAIL);
    $mform->addElement('static', 'explainemail2', '&nbsp;', 'Must match first e-mail.<br />');

    $mform->addElement('text', 'city', 'City/Town', 'maxlength="120" size="50"');
    $mform->addRule('city', 'City/Town is required', 'required', null, 'client');
    $mform->setType('city', PARAM_TEXT);
    $mform->addElement('static', 'explaincity', '&nbsp;', 'Your City or Town for display in Moodle.<br />');

    $mform->addElement('select', 'country', 'Country', $countryname);
    $mform->addRule('country', 'Country is required', 'required', null, 'client');
    $mform->addElement('static', 'explaincountry', '&nbsp;', 'Your country of residence. Select from list.<br />');

    $mform->addElement('text', 'username', 'Preferred Username', 'maxlength="100" size="50"');
    $mform->addRule('username', 'Preferred Username is required', 'required', null, 'client');
    $mform->setType('username', PARAM_USERNAME);
    $mform->addElement('static', 'explainusername', '&nbsp;', 'Please enter your desired Username for logging in to our education site, for example your first name.<br />');

    $mform->addElement('textarea', 'reasons', 'Reasons for wanting to volunteer for Peoples-uni', 'wrap="HARD" rows="10" cols="100"');
    $mform->addRule('reasons', 'Reasons for wanting to volunteer for Peoples-uni is required', 'required', null, 'client');
    $mform->addElement('static', 'explainreasons', '&nbsp;', 'Please tell us your reasons for wanting to volunteer for Peoples-uni in up to 150 words.<br />');


    $mform->addElement('header', 'educationdetails', 'Education and Employment details');

    $mform->addElement('textarea', 'education', 'Relevant qualifications (academic and professional)', 'wrap="HARD" rows="10" cols="100"');
    $mform->addRule('education', 'Relevant qualifications (academic and professional) is required', 'required', null, 'client');
    $mform->addElement('static', 'explaineducation', '&nbsp;', 'Add details about any of your Relevant qualifications (academic and professional).<br />
If you have a degree please indicate name of degree, awarding institution and also the language of instruction.<br />
If you have a postgraduate qualification, please indicate name of qualification, awarding institution and also the language of instruction.<br />');

    $mform->addElement('textarea', 'tutoringexperience', 'Educational/tutoring experience', 'wrap="HARD" rows="10" cols="100"');
    $mform->addElement('static', 'explaintutoringexperience', '&nbsp;', 'Please briefly tell us about any educational/tutoring experience you may have.<br />');

    $mform->addElement('textarea', 'currentjob', 'Current employer', 'wrap="HARD" rows="10" cols="100"');
    $mform->addRule('currentjob', 'Current employer is required', 'required', null, 'client');
    $mform->addElement('static', 'explaincurrentjob', '&nbsp;', 'Add name of your current employer.<br />');

    $mform->addElement('textarea', 'currentrole', 'Current role', 'wrap="HARD" rows="10" cols="100"');
    $mform->addRule('currentrole', 'Current role is required', 'required', null, 'client');
    $mform->addElement('static', 'explaincurrentrole', '&nbsp;', 'Add details about your current role.<br />');

    $mform->addElement('textarea', 'otherinformation', 'Other information', 'wrap="HARD" rows="10" cols="100"');
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
    $mform->addRule('howfoundpeoples', 'How did you hear about Peoples-uni is required', 'required', null, 'client');
    $mform->addElement('static', 'explainhowfoundpeoples', '&nbsp;', 'Select the option that best describes how you heard about Peoples-uni.<br />');

    $mform->addElement('text', 'howfoundorganisationname', 'Name of the organisation or person from whom you heard about Peoples-uni', 'maxlength="100" size="50"');
    $mform->setType('howfoundorganisationname', PARAM_TEXT);
    $mform->addElement('static', 'explainhowfoundorganisationname', '&nbsp;', 'Please enter the name of the organisation, person or website from whom you heard about Peoples-uni.<br />');


    $this->add_action_buttons(false, 'Submit Form');

    //$this->set_data($data);
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    if ($data['email'] !== $data['email2']) $errors['email'] = 'Email address does not match Email verification, they must be the same.';

    return $errors;
  }
}
