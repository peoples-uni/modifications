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
    $data = $this->_customdata['data'];
    $customdata = $this->_customdata['customdata'];
    $id = $customdata['id'];
    $is_admin = $customdata['is_admin'];
    if (empty($id) && !empty($customdata['userid'])) {
      $peoples_tutor_registration = new stdClass();
      $peoples_tutor_registration->userid = $customdata['userid'];
    }
    else {
      $peoples_tutor_registration = $DB->get_record('peoples_tutor_registration', array('id' => $id));
      if (empty($peoples_tutor_registration)) {
        echo '<h1>peoples_tutor_registration matching id does not exist!</h1>';
        die();
      }
    }

    if (!empty($peoples_tutor_registration->userid)) {
      $userrecord = $DB->get_record('user', array('id' => $peoples_tutor_registration->userid));
      if (!empty($userrecord)) {
        $peoples_tutor_registration->lastname = $userrecord->lastname;
        $peoples_tutor_registration->firstname = $userrecord->firstname;
        $registered = 'Registered in Moodle';
      }
    }
    if (empty($userrecord)) {
      $registered = 'Not yet registered in Moodle';
    }


    $mform->addElement('header', 'top', 'Instructions');
    $mform->setExpanded('top');

    $mform->addElement('static', 'instuctions', '',
"
<p>Edit Volunteer Registration for $peoples_tutor_registration->lastname, $peoples_tutor_registration->firstname (<strong>$registered</strong>).<br /></p>
");


    $mform->addElement('header', 'personaldetails', 'Personal details');
    $mform->setExpanded('personaldetails');

    $mform->addElement('textarea', 'reasons', 'Reasons for wanting to volunteer for Peoples-uni', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    if (!empty($id)) $mform->setDefault('reasons', $peoples_tutor_registration->reasons);
    $mform->addRule('reasons', 'Reasons for wanting to volunteer for Peoples-uni is required', 'required', null, 'client');
    $mform->addElement('static', 'explainreasons', '&nbsp;', 'Please tell us your reasons for wanting to volunteer for Peoples-uni in up to 150 words.<br />');


    $mform->addElement('header', 'educationdetails', 'Education and Employment details');
    $mform->setExpanded('educationdetails');

    $mform->addElement('textarea', 'education', 'Relevant qualifications (academic and professional)', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    if (!empty($id)) $mform->setDefault('education', $peoples_tutor_registration->education);
    $mform->addRule('education', 'Relevant qualifications (academic and professional) is required', 'required', null, 'client');
    $mform->addElement('static', 'explaineducation', '&nbsp;', 'Add details about any of your Relevant qualifications (academic and professional).<br />
If you have a degree please indicate name of degree, awarding institution and also the language of instruction.<br />
If you have a postgraduate qualification, please indicate name of qualification, awarding institution and also the language of instruction.<br />');

    $mform->addElement('textarea', 'tutoringexperience', 'Educational/tutoring experience', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    if (!empty($id)) $mform->setDefault('tutoringexperience', $peoples_tutor_registration->tutoringexperience);
    $mform->addElement('static', 'explaintutoringexperience', '&nbsp;', 'Please briefly tell us about any educational/tutoring experience you may have.<br />');

    $mform->addElement('textarea', 'currentjob', 'Current employer', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    if (!empty($id)) $mform->setDefault('currentjob', $peoples_tutor_registration->currentjob);
    $mform->addRule('currentjob', 'Current employer is required', 'required', null, 'client');
    $mform->addElement('static', 'explaincurrentjob', '&nbsp;', 'Add name of your current employer.<br />');

    $mform->addElement('textarea', 'currentrole', 'Current role', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    if (!empty($id)) $mform->setDefault('currentrole', $peoples_tutor_registration->currentrole);
    $mform->addRule('currentrole', 'Current role is required', 'required', null, 'client');
    $mform->addElement('static', 'explaincurrentrole', '&nbsp;', 'Add details about your current role.<br />');

    $mform->addElement('textarea', 'otherinformation', 'Other information', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    if (!empty($id)) $mform->setDefault('otherinformation', $peoples_tutor_registration->otherinformation);
    $mform->addElement('static', 'explainotherinformation', '&nbsp;', 'Any other information you want us to know about you.<br />');


    $mform->addElement('header', 'howfounddetails', 'How did you hear about Peoples-uni?');
    $mform->setExpanded('howfounddetails');

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
    if (!empty($id)) $mform->setDefault('howfoundpeoples', $peoples_tutor_registration->howfoundpeoples);
    $mform->addRule('howfoundpeoples', 'How did you hear about Peoples-uni is required', 'required', null, 'client');
    $mform->addElement('static', 'explainhowfoundpeoples', '&nbsp;', 'Select the option that best describes how you heard about Peoples-uni.<br />');

    $mform->addElement('text', 'howfoundorganisationname', 'Name of the organisation or person from whom you heard about Peoples-uni', 'maxlength="100" size="50"');
    $mform->setType('howfoundorganisationname', PARAM_TEXT);
    if (!empty($id)) $mform->setDefault('howfoundorganisationname', $peoples_tutor_registration->howfoundorganisationname);
    $mform->addElement('static', 'explainhowfoundorganisationname', '&nbsp;', 'Please enter the name of the organisation, person or website from whom you heard about Peoples-uni.<br />');


    $mform->addElement('header', 'databypeoplesuni', 'Data entered by Peoples-uni');
    $mform->setExpanded('databypeoplesuni');

    if ($is_admin) {
      $volunteertypename['10'] = 'Tutor';
      $volunteertypename['20'] = 'Local supervisor';
      $volunteertypename['30'] = 'Academic supervisor';
      $volunteertypename['40'] = 'Marker';
      $volunteertypename['50'] = 'SSO';
      $volunteertypename['60'] = 'IT';
      $volunteertypename['70'] = 'Admin';
      $select = $mform->addElement('select', 'volunteertype', 'Type of Volunteer', $volunteertypename);
      $select->setMultiple(true);
      if (!empty($id) && !empty($peoples_tutor_registration->volunteertype)) {
        $arrayvalues = explode(',', $peoples_tutor_registration->volunteertype);
        $mform->setDefault('volunteertype', $arrayvalues);
      }
      $mform->addElement('static', 'explainvolunteertype', '&nbsp;', 'Select possible types of volunteer <b>(Ctrl Click for multiple options)</b>.<br />');

      $mform->addElement('textarea', 'modulesofinterest', 'Modules of interest', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
      if (!empty($id)) $mform->setDefault('modulesofinterest', $peoples_tutor_registration->modulesofinterest);
      $mform->addElement('static', 'explainmodulesofinterest', '&nbsp;', 'Please enter the names of modules that are of interest to this volunteer.<br />');

      $mform->addElement('textarea', 'notes', 'Notes about volunteer', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
      if (!empty($id)) $mform->setDefault('notes', $peoples_tutor_registration->notes);
      $mform->addElement('static', 'explainnotes', '&nbsp;', 'Please add/update any notes you wish to make here.<br />');
    }

    if (!empty($userrecord)) {
      $options = $this->_customdata['options'];

      $mform->addElement('filemanager', 'files_filemanager', get_string('files'), NULL, $options);
    }

    if ($is_admin && empty($userrecord)) {
      $mform->addElement('static', 'spacingxxx0', '&nbsp;', '&nbsp;<br />');
      $mform->addElement('checkbox', 'register_in_moodle', 'Check to register volunteer in Moodle');
    }

    if (has_capability('moodle/site:viewparticipants', context_system::instance()) && !empty($id) && !empty($peoples_tutor_registration->userid)) {
      $user_info_datas = $DB->get_records_sql("
        SELECT *
        FROM mdl_user_info_data
        WHERE
          fieldid IN (3,4,5,6,7,8,9,10) AND
          userid IN (SELECT userid FROM mdl_enrolment WHERE enrolled!=0) AND
          userid NOT IN (SELECT userid FROM mdl_profile_cleared) AND
          userid=" . $peoples_tutor_registration->userid);
      $found = FALSE;
      if (!empty($user_info_datas)) {
        foreach ($user_info_datas as $user_info_data) {
          if (!empty($user_info_data->data)) {
            $found = TRUE;
          }
        }
      }
      if ($found) {
        $mform->addElement('static', 'spacingxxx1a', '&nbsp;', '&nbsp;<br />');
        $mform->addElement('checkbox', 'clear_sensitive_profile_items', 'Check to clear sensitive profile items (this volunteer was previously a student)');
        $mform->setDefault('clear_sensitive_profile_items', 1);
        $mform->addElement('static', 'spacingxxx2a', '&nbsp;', '&nbsp;<br />');
      }
    }

    if (has_capability('moodle/site:viewparticipants', context_system::instance()) && !empty($id)) {
      $mform->addElement('static', 'spacingxxx1', '&nbsp;', '&nbsp;<br />');
      $mform->addElement('checkbox', 'hide_tutor_form', 'Check to hide this form from all future processing');
      $mform->addElement('static', 'spacingxxx2', '&nbsp;', '&nbsp;<br />');
    }


    $this->add_action_buttons(TRUE, get_string('savechanges'));

    $this->set_data($data);
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    return $errors;
  }
}
