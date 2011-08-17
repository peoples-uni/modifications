<?php

/**
 * Application form for Peoples-uni for Returning Students (Form Class)
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class application_form_returning_student_form extends moodleform {

  function definition() {
    global $DB, $CFG;

    $mform    = $this->_form;

    $mform->addElement('header', 'top', 'Instructions');

    $mform->addElement('static', 'instuctions', '',
'<p>Please read the information in <a href="http://www.peoples-uni.org/book/essential-information-potential-students">Essential information for potential students</a> before submitting this form, particularly see the information about <a href="http://peoples-uni.org/book/course-fees">Course fees</a></p>
<p><strong>Use this form to apply to do additional course modules after your initial enrolment.<br /><br /></strong></p>
<p><strong>Note: You will need to use the user name that you use when logging into Moodle to access your current course modules. Enter this user name in the form below.<br /></strong></p>
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
    $listforselect[''] = 'Select...';
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

    $text = 'Please select the first course module you are applying for from the drop down box (you should not apply for Masters Dissertation until given permission to do so).';
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

    $listforselect = array();
    $listforselect[1] = 'No, continue with Peoples-uni';
    $listforselect[2] = 'Yes';
    $listforselect[3] = 'I am already enrolled in MMU MPH';
    $mform->addElement('select', 'applymmumph', 'Apply for Manchester Metropolitan University Master of Public Health programme', $listforselect);
    $mform->addElement('static', 'explainapplymmumph', '&nbsp;', 'Do you want to apply for enrolment in the Manchester Metropolitan University Master of Public Health programme (please note the fees <a href="http://www.peoples-uni.org/book/course-fees" target="_blank">http://www.peoples-uni.org/book/course-fees</a>)?<br />');


    $mform->addElement('header', 'personaldetails', 'Your Existing Moodle User Name');

    $mform->addElement('text', 'username', 'Moodle Username', 'maxlength="100" size="50"');
    $mform->addRule('username', 'Moodle Username is required', 'required', null, 'client');
    $mform->setType('username', PARAM_MULTILANG);
    $mform->addElement('static', 'explainusername', '&nbsp;', 'The user name you use to login to your course modules.<br />');


    $mform->addElement('header', 'scholorshipdetails', 'Scholarship');

    $mform->addElement('static', 'explainscholarship', '&nbsp;', 'If you cannot afford the fees, we may be able to assist in approved cases. If you would like to request a reduction or waiver of the fees, please state here:<br />
1. What is your current income<br />
2. What is the reason you are unable to pay the fees<br />
3. Whether you are able to pay a portion of the fees and if so how much<br />
4. How you plan to use the skills/qualifications you will gain from Peoples-uni or Manchester Metropolitan University for the health of the population (up to 150 words)<br />');
    $mform->addElement('textarea', 'scholarship', '&nbsp;', 'wrap="HARD" rows="10" cols="100"');

    $this->add_action_buttons();
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    if ($data['course_id_1'] === $data['course_id_2']) $errors['course_id_1'] = "You have selected the same module as your first and second choice. Either remove the second selection (by selecting the 'Select...' message at the top of the option list) or change the second module selected.";

    $user_record = $DB->get_record('user', array('username' => $data['username']));
    if (empty($user_record)) $errors['username'] = 'The Peoples Uni Moodle Username you have entered does not match any Moodle Username.';

    return $errors;
  }
}
