<?php

/**
 * Registration form for Peoples-uni for New Students (Form Class)
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class registration_form extends moodleform {

  function definition() {
    global $DB, $CFG;

    $select_array = array('' => 'Select...');
    $countryname = get_string_manager()->get_list_of_countries(false);
    $countryname = array_merge($select_array, $countryname);

    $mform    = $this->_form;


    $mform->addElement('header', 'top', 'Instructions');

    $mform->addElement('static', 'instuctions', '',
"<strong>There are three steps for enrolment in Peoples-uni courses.<br />
<br />
1. Please complete this Registration Form (below) and you will receive an automatic reply soon after you submit it.<br />
If you do not, it means that we cannot reach your e-mail address.<br />" .
'In that case please send an e-mail to <a href="mailto:apply@peoples-uni.org">apply@peoples-uni.org</a>.<br />' .
"<br />
2. As a new student, you will also be invited to take part in our 'Preparing to Study' course. This takes place online in January/February and July/August.<br />
You will receive detailed information about the course nearer the time.<br />
There is no payment for the Preparing to Study course.<br />
<br />
3. In February/August we will send you an invitation to complete the Application Form to apply for specific modules for the next semester.<br />
Applications will be open for a 3-week window during that time.<br />
Semesters start in mid-March and mid-September.<br />
You will receive confirmation of your module enrolment shortly before then,<br />
when you will also need to pay your course fees.</strong><br />" .

'<p><strong>Please read the information on </strong><a href="http://peoples-uni.org/content/course-fees">Course Fees (Click Here)</a><strong> to make sure that you are prepared.</strong></p>
<p>For inquires about registration please email <a href="mailto:apply@peoples-uni.org?subject=Registration query">apply@peoples-uni.org</a>.</p>
<p><strong>Note:</strong> You must complete the fields marked with a red <span style="color:#ff0000">*</span>.</p>
<p><strong>Note:</strong> We may analyse student data to help us improve the course and some of this information might be published in academic journals to help others. No student will be individually identifiable in any publication.</p>
');
//<p>Note:</strong> The closing date for applications for enrolment in modules for the upcoming semester is " . gmdate('jS F Y', get_config(NULL, 'peoples_last_application_date')) . ' approximately. When enrolments are open you will be informed (this is normally about 2 weeks before that date).</p>


    $mform->addElement('header', 'personaldetails', 'Personal details');

    $mform->addElement('text', 'lastname', 'Family name', 'maxlength="100" size="50"');
    $mform->addRule('lastname', 'Family name is required', 'required', null, 'client');
    $mform->setType('lastname', PARAM_NOTAGS);
    $mform->addElement('static', 'explainlastname', '&nbsp;', 'Your Family name or Surname.<br />');

    $mform->addElement('text', 'firstname', 'Given name', 'maxlength="100" size="50"');
    $mform->addRule('firstname', 'Given name is required', 'required', null, 'client');
    $mform->setType('firstname', PARAM_NOTAGS);
    $mform->addElement('static', 'explainfirstname', '&nbsp;', 'Your first or given name(s).<br />');

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

    $yearname[''] = 'Select...';
    for ($year = 1930; $year <= 2000; $year++) $yearname[$year] = $year;
    $mform->addElement('select', 'dobyear', 'Date of Birth Year', $yearname);
    $mform->addRule('dobyear', 'Date of Birth Year is required', 'required', null, 'client');

    $monthname[''] = 'Select...';
    $monthname[ 1] = 'Jan';
    $monthname[ 2] = 'Feb';
    $monthname[ 3] = 'Mar';
    $monthname[ 4] = 'Apr';
    $monthname[ 5] = 'May';
    $monthname[ 6] = 'Jun';
    $monthname[ 7] = 'Jul';
    $monthname[ 8] = 'Aug';
    $monthname[ 9] = 'Sep';
    $monthname[10] = 'Oct';
    $monthname[11] = 'Nov';
    $monthname[12] = 'Dec';
    $mform->addElement('select', 'dobmonth', 'Date of Birth Month', $monthname);
    $mform->addRule('dobmonth', 'Date of Birth Month is required', 'required', null, 'client');

    $dayname[''] = 'Select...';
    for ($day = 1; $day <= 31; $day++) $dayname[$day] = $day;
    $mform->addElement('select', 'dobday', 'Date of Birth Day', $dayname);
    $mform->addRule('dobday', 'Date of Birth Day is required', 'required', null, 'client');

    $mform->addElement('select', 'gender', 'Gender', array('' => 'Select...', 'Female' => 'Female', 'Male' => 'Male'));
    $mform->addRule('gender', 'Gender is required', 'required', null, 'client');
    $mform->addElement('static', 'explaingender', '&nbsp;', 'Select your gender: Male or Female.<br />');

    $mform->addElement('textarea', 'applicationaddress', 'Address', 'wrap="HARD" rows="7" cols="50" style="width:auto"');
    $mform->addRule('applicationaddress', 'Address is required', 'required', null, 'client');
    $mform->addElement('static', 'explainapplicationaddress', '&nbsp;', 'Your full postal address. This must be a permanent long term address which can be used for postal delivery if/when necessary.<br />');

    $mform->addElement('text', 'city', 'City/Town', 'maxlength="120" size="50"');
    $mform->addRule('city', 'City/Town is required', 'required', null, 'client');
    $mform->setType('city', PARAM_TEXT);
    $mform->addElement('static', 'explaincity', '&nbsp;', 'Your City or Town for display in Moodle.<br />');

    $mform->addElement('select', 'country', 'Country', $countryname);
    $mform->addRule('country', 'Country is required', 'required', null, 'client');
    $mform->addElement('static', 'explaincountry', '&nbsp;', 'Your country of residence. Select from list.<br />');

    $mform->addElement('textarea', 'reasons', 'Reasons for wanting to enrol', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    $mform->addRule('reasons', 'Reasons for wanting to enrol is required', 'required', null, 'client');
    $mform->addElement('static', 'explainreasons', '&nbsp;', 'Please tell us your reasons for wanting to enrol in this course in up to 150 words.<br />');

    $whatlearnname['10'] = 'I want to improve my knowledge of public health';
    $whatlearnname['20'] = 'I want to improve my academic skills (writing structured essays, critically reviewing published literature, referencing etc)';
    $whatlearnname['30'] = 'I want to improve my skills in research';
    $whatlearnname['40'] = 'I am not sure';
    $select = &$mform->addElement('select', 'whatlearn', 'What do you want to learn?', $whatlearnname);
    $select->setMultiple(true);
    $mform->addRule('whatlearn', 'What do you want to learn is required', 'required', null, 'client');
    $mform->addElement('static', 'explainwhatlearn', '&nbsp;', 'Select options that best describe What do you want to learn <b>(Ctrl Click for multiple options)</b>.<br />');

    $whylearnname['10'] = 'I want to apply what I learn to my current/future work';
    $whylearnname['20'] = 'I want to improve my career opportunities and this will help me in future job/course applications';
    $whylearnname['30'] = 'I want to get academic credit';
    $whylearnname['40'] = 'I am not sure';
    $select = &$mform->addElement('select', 'whylearn', 'Why do you want to learn?', $whylearnname);
    $select->setMultiple(true);
    $mform->addRule('whylearn', 'Why do you want to learn is required', 'required', null, 'client');
    $mform->addElement('static', 'explainwhylearn', '&nbsp;', 'Select options that best describe Why do you want to learn <b>(Ctrl Click for multiple options)</b>.<br />');

    $whyelearningname['10'] = 'I want to meet and learn with people from other countries';
    $whyelearningname['20'] = 'I want the opportunity to be flexible about my study time';
    $whyelearningname['30'] = 'I want a public health training that is affordable';
    $whyelearningname['40'] = 'I am not sure';
    $select = &$mform->addElement('select', 'whyelearning', 'What are the reasons you want to do an e-learning course?', $whyelearningname);
    $select->setMultiple(true);
    $mform->addRule('whyelearning', 'What are the reasons you want to do an e-learning course is required', 'required', null, 'client');
    $mform->addElement('static', 'explainwhyelearning', '&nbsp;', 'Select options that best describe What are the main reasons you want to do an e-learning course <b>(Ctrl Click for multiple options)</b>.<br />');

    $howuselearningname['10'] = 'Share knowledge skills with other colleagues';
    $howuselearningname['20'] = 'Start a new project - please give further details with free text in Reasons for wanting to enrol above';
    $howuselearningname['30'] = 'I am not sure';
    $select = &$mform->addElement('select', 'howuselearning', 'How will you use your new knowledge and skills to improve population health?', $howuselearningname);
    $select->setMultiple(true);
    $mform->addRule('howuselearning', 'How will you use your new knowledge and skills to improve population health is required', 'required', null, 'client');
    $mform->addElement('static', 'explainhowuselearning', '&nbsp;', 'Select options that best describe How will you use your new knowledge and skills to improve population health <b>(Ctrl Click for multiple options)</b>.<br />');

    $mform->addElement('textarea', 'sponsoringorganisation', 'Sponsoring organisation', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    $mform->addElement('static', 'explainsponsoringorganisation', '&nbsp;', 'Indicate any organisation that is sponsoring or supporting your application.<br />');

    $mform->addElement('text', 'username', 'Preferred Username', 'maxlength="100" size="50"');
    $mform->addRule('username', 'Preferred Username is required', 'required', null, 'client');
    $mform->setType('username', PARAM_USERNAME);
    $mform->addElement('static', 'explainusername', '&nbsp;', 'Please enter your desired Username for logging in to our education site, for example your first name.<br />');


    $mform->addElement('header', 'educationdetails', 'Education and Employment details');

    $qualificationname[  ''] = 'Select...';
    $qualificationname[ '1'] = 'None';
    $qualificationname['10'] = 'Degree (not health related)';
    $qualificationname['20'] = 'Health qualification (non-degree)';
    $qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
    $qualificationname['40'] = 'Medical degree';
    $mform->addElement('select', 'qualification', 'Higher Education Qualification', $qualificationname);
    $mform->addRule('qualification', 'Higher Education Qualification is required', 'required', null, 'client');
    $mform->addElement('static', 'explainqualification', '&nbsp;', 'Select the option that best describes your Higher Education Qualification.<br />');

    $higherqualificationname[  ''] = 'Select...';
    $higherqualificationname[ '1'] = 'None';
    $higherqualificationname['10'] = 'Certificate';
    $higherqualificationname['20'] = 'Diploma';
    $higherqualificationname['30'] = 'Masters';
    $higherqualificationname['40'] = 'Ph.D.';
    $higherqualificationname['50'] = 'Other';
    $mform->addElement('select', 'higherqualification', 'Postgraduate Qualification', $higherqualificationname);
    $mform->addRule('higherqualification', 'Postgraduate Qualification is required', 'required', null, 'client');
    $mform->addElement('static', 'explainhigherqualification', '&nbsp;', 'Select the option that best describes your Postgraduate Qualification.<br />');

    $mform->addElement('textarea', 'education', 'Relevant qualifications or educational experience', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    $mform->addElement('static', 'explaineducation', '&nbsp;', 'Add details about any of your relevant qualifications or educational experience.<br />
If you have a degree please indicate name of degree, awarding institution and also the language of instruction.<br />
If you have a postgraduate qualification, please indicate name of qualification, awarding institution and also the language of instruction.<br />');

    $employmentname[  ''] = 'Select...';
    $employmentname[ '1'] = 'None';
    $employmentname['10'] = 'Student';
    $employmentname['20'] = 'Non-health';
    $employmentname['30'] = 'Clinical (not specifically public health)';
    $employmentname['40'] = 'Public health';
    $employmentname['50'] = 'Other health related';
    $employmentname['60'] = 'Academic occupation (e.g. lecturer)';
    $mform->addElement('select', 'employment', 'Current Employment', $employmentname);
    $mform->addRule('employment', 'Current Employment is required', 'required', null, 'client');
    $mform->addElement('static', 'explainemployment', '&nbsp;', 'Select the option that best describes your Current Employment.<br />');

    $mform->addElement('textarea', 'currentjob', 'Current Employment Details', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    $mform->addElement('static', 'explaincurrentjob', '&nbsp;', 'You can add any details about your current employment.<br />');


    $mform->addElement('header', 'howfounddetails', 'How did you hear about Peoples-uni?');

    $howfoundpeoplesname[  ''] = 'Select...';
    $howfoundpeoplesname['10'] = 'Informed by another Peoples-uni student';
    $howfoundpeoplesname['20'] = 'Informed by someone else';
    $howfoundpeoplesname['30'] = 'Facebook';
    $howfoundpeoplesname['40'] = 'Internet advertisement';
    $howfoundpeoplesname['50'] = 'Link from another website or discussion forum';
    $howfoundpeoplesname['60'] = 'I used a search engine to look for courses';
    $howfoundpeoplesname['70'] = 'Referral from Partnership Institution';
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
