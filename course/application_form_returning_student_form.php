<?php

/**
 * Application form for Peoples-uni for Returning Students (Form Class)
 */

/*
CREATE TABLE mdl_late_applications_allowed (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) unsigned NOT NULL DEFAULT 0,
  approverid BIGINT(10) unsigned NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) unsigned NOT NULL DEFAULT 0,
  deadline BIGINT(10) unsigned NOT NULL DEFAULT 0,
  CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_late_applications_allowed_ix ON mdl_late_applications_allowed (userid);
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
'<p><strong>Please read the information in </strong><a href="http://www.peoples-uni.org/book/essential-information-potential-students">Essential information for potential students (Click Here)</a><strong> before submitting this form, particularly see the information about </strong><a href="http://peoples-uni.org/book/course-fees">Course fees (Click Here)</a></p>
<p><strong>Use this form to apply to do course modules. You must have already been registered in Moodle. You need to enter the user name that you use when logging into Moodle in the form below.</strong></p>
<p><strong>If you have not been registered in Moodle you must apply by </strong><a href="http://courses.peoples-uni.org/course/registration.php">Clicking Here</a><strong> first.</strong></p>
<p>For inquires about course enrolment or payment please send an e-mail to <a href="mailto:apply@peoples-uni.org?subject=Registration or payment query">apply@peoples-uni.org</a></p>
<p><strong>Note:</strong> You must complete the fields marked with a red <span style="color:#ff0000">*</span>.</p>
<p><strong>Note:</strong> You must submit your application on or before ' . gmdate('jS F Y', get_config(NULL, 'peoples_last_application_date')) . '.</p>
<p><strong>You should receive an e-mail with a copy of your application when you submit this form. If you do not, it means that we cannot reach your e-mail address. In that case please send an e-mail to <a href="mailto:apply@peoples-uni.org">apply@peoples-uni.org</a></strong></p>');


    $semester_current = $DB->get_record('semester_current', array('id' => 1));
    $mform->addElement('header', 'modules', "Course Module Selection for Semester $semester_current->semester");

    // Ability to submit form (no matter what) is given by the "Manager" role which has moodle/site:viewparticipants
    // (administrator also has moodle/site:viewparticipants)
    $ismanager = has_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

    if (!$ismanager) {
      $open_modules = $DB->get_records('activemodules', array('modulefull' => 0));
      if (empty($open_modules)) {
        redirect($CFG->wwwroot . '/course/closed.php');
      }
    }

    $activemodules = $DB->get_records('activemodules', NULL, 'fullname ASC');

    $listforselect = array();
    $listforselect[''] = 'Select...';
    $listforunavailable = array();
    foreach ($activemodules as $activemodule) {
      if (!$activemodule->modulefull || $ismanager) {
        $listforselect[$activemodule->course_id] = $activemodule->fullname;
      }
      else {
        $listforunavailable[] = "'" . $activemodule->fullname . "'";
      }
    }
    $count = count($listforunavailable);
    $listforunavailable = implode(", ", $listforunavailable);

    $text = "Please select the first course module you are applying for from the drop down box. Note: you should not apply for 'Masters dissertation' until given permission to do so. Note: you should only apply for 'Patient Safety in Practice' if you are doing the Certificate in Patient Safety and also if you have already completed the module 'Patient Safety' which is required for the Certificate in Patient Safety.";
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
    $mform->addElement('static', 'explain2', '&nbsp;', 'If you want do apply to do two modules in the same semester, select the second course module here. Please realise that both modules will run at the same time and the workload may be heavy, be sure that you do have the time if you elect to take two modules in the same semester.<br /><br />');

    $listforselect = array();
    $listforselect[1] = 'No, continue with Peoples-uni';
    $listforselect[2] = 'Yes';
    $listforselect[3] = 'I am already enrolled in MMU MPH';
    $mform->addElement('select', 'applymmumph', 'Apply for Manchester Metropolitan University Master of Public Health programme', $listforselect);
    $mform->addElement('static', 'explainapplymmumph', '&nbsp;', 'Do you want to apply for enrolment in the Manchester Metropolitan University Master of Public Health programme (please note the fees <a href="http://www.peoples-uni.org/book/course-fees" target="_blank">http://www.peoples-uni.org/book/course-fees</a>)?<br />
Please do not apply if this is your first semester.<br /><br />');

    $listforselect = array();
    $listforselect[1] = 'No';
    $listforselect[2] = 'Yes';
    $listforselect[3] = 'I am already enrolled in the Certificate in Patient Safety';
    $mform->addElement('select', 'applycertpatientsafety', 'Apply for Certificate in Patient Safety', $listforselect);
    $mform->addElement('static', 'explainapplycertpatientsafety', '&nbsp;', 'Do you want to apply for enrolment in the Certificate in Patient Safety (see <a href="http://www.peoples-uni.org/node/281" target="_blank">http://www.peoples-uni.org/node/281</a>)?<br />
For this certificate you will need to complete the Evidence Based Practice, Patient Safety & Patient Safety in Practice modules.<br />');

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


    $mform->addElement('header', 'whynotcompletedetails', 'Previous Semester');

    $mform->addElement('static', 'explainwhynotcomplete', '&nbsp;', 'If you are a returning student and did not complete your previous semester, please explain why this was so.');
    $mform->addElement('textarea', 'whynotcomplete', '&nbsp;', 'wrap="HARD" rows="10" cols="100"');


    $this->add_action_buttons(false, 'Submit Form');
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    if ($data['course_id_1'] === $data['course_id_2']) $errors['course_id_1'] = "You have selected the same module as your first and second choice. Either remove the second selection (by selecting the 'Select...' message at the top of the option list) or change the second module selected.";

    $user_record = $DB->get_record('user', array('username' => $data['username']));
    if (empty($user_record)) {
      $errors['username'] = 'The Peoples Uni Moodle Username you have entered does not match any Moodle Username.';
    }
    else {
      $oldapplication = $DB->get_record('peoplesapplication', array('userid' => $user_record->id), '*', IGNORE_MULTIPLE);
      if (empty($oldapplication)) {
        $oldapplication = $DB->get_record('peoplesregistration', array('userid' => $user_record->id), '*', IGNORE_MULTIPLE);
        if (empty($oldapplication)) $errors['username'] = 'The Peoples Uni Moodle Username you have entered does not match any Moodle Student Username.';
      }
    }

    return $errors;
  }
}
