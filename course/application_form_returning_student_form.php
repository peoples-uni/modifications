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
    global $DB, $CFG, $USER;

    $mform    = $this->_form;

    $mform->addElement('header', 'top', 'Instructions');
    $mform->setExpanded('top');

    $mform->addElement('static', 'instuctions', '',
'<p><strong>Please read the information in </strong><a href="https://www.peoples-uni.org/content/who-should-apply" target="_blank">Who should apply (Click Here)</a><strong> before submitting this form,<br />
particularly see the information about </strong><a href="https://peoples-uni.org/content/course-fees-payment-options" target="_blank">Course fees (Click Here)</a></p>
<p><strong>Use this form to apply to study any of our Masters-level modules. To apply, you must have already been registered in Moodle (our online platform).<br />
If you have not been registered in Moodle you must apply by </strong><a href="http://courses.peoples-uni.org/course/registration.php">Clicking Here</a><strong> first.</strong></p>
<p><strong>You need to enter the user name that you use when logging into Moodle in the form below.</strong></p>
<p>For inquires about course enrolment or payment please send an e-mail to <a href="mailto:apply@peoples-uni.org?subject=Registration or payment query">apply@peoples-uni.org</a></p>
<p><strong>Note:</strong> You must complete the fields marked with a red <span style="color:#ff0000">*</span>.</p>
<p><strong>Note:</strong> You must submit your application on or before ' . gmdate('jS F Y', get_config(NULL, 'peoples_last_application_date')) . '.</p>
<p><strong>You should receive an e-mail with a copy of your application when you submit this form. If you do not, it means that we cannot reach your e-mail address. In that case please send an e-mail to <a href="mailto:apply@peoples-uni.org">apply@peoples-uni.org</a></strong></p>');

    $customdata = $this->_customdata['customdata'];
    $semester  = $customdata['semester'];
    $mform->addElement('hidden', 'semester', $semester);
    $mform->setType('semester', PARAM_NOTAGS);

    if (empty($semester)) {
      $semester_current = $DB->get_record('semester_current', array('id' => 1));
    }
    else {
      $semester_current = new stdClass();
      $semester_current->semester = $semester;
    }

    $mform->addElement('header', 'modules', "Course Module Selection for Semester $semester_current->semester");
    $mform->setExpanded('modules');

    // Ability to submit form (no matter what) is given by the "Manager" role which has moodle/site:viewparticipants
    // (administrator also has moodle/site:viewparticipants)
    $ismanager = has_capability('moodle/site:viewparticipants', context_system::instance());

    // Allow specified Students who have been given a later than normal deadline to apply late
    $late_application = FALSE;
    if (!empty($USER->id)) {
      $late_applications_allowed = $DB->get_record('late_applications_allowed', array('userid' => $USER->id));
      if (!empty($late_applications_allowed)) {
        $deadline = $late_applications_allowed->deadline;
        if (time() < $deadline) {
          $late_application = TRUE;
        }
      }
    }

    if (!($ismanager || $late_application)) {
      $open_modules = $DB->get_records('activemodules', array('modulefull' => 0));
      if (empty($open_modules)) {
        redirect($CFG->wwwroot . '/course/closed.php');
      }
    }

    if (empty($semester)) {
      $activemodules = $DB->get_records('activemodules', NULL, 'fullname ASC');
    }
    else {
      $activemodules = $DB->get_records_sql("
        SELECT DISTINCT
          c.id AS course_id,
          c.fullname,
          0 AS modulefull
        FROM mdl_enrolment e
        JOIN mdl_course c ON e.courseid=c.id
        WHERE e.semester=?
        ORDER BY c.fullname ASC",
        array($semester));
    }

    $listforselect = array();
    $listforselect[''] = 'Select...';
    $listforunavailable = array();
    foreach ($activemodules as $activemodule) {
      if (!$activemodule->modulefull || ($ismanager || $late_application)) {
        $listforselect[$activemodule->course_id] = $activemodule->fullname;
      }
      else {
        $listforunavailable[] = "'" . $activemodule->fullname . "'";
      }
    }
    $count = count($listforunavailable);
    $listforunavailable = implode(", ", $listforunavailable);

    $_SESSION['peoples_filling_in_application_form'] = time();
    $text = "Please select the first course module you are applying for from the drop down box.
    <br /><strong>Note:</strong> The 'Masters dissertation' is restricted to those who have passed eight prior modules.
    <br /><strong>Note:</strong> If you are applying for the 'Masters dissertation' module, you have to submit this form as well as a separate form indicating the provisional topic for your dissertation. Please <strong><a href=\"" . $CFG->wwwroot . "/course/dissertation.php\" target=\"_blank\">Click Here for the Dissertation Topic Form</a></strong> to do this.
    <br />Please make sure you submit both forms as otherwise your application cannot be approved.";
    if ($count > 1) {
      //$text .= ' Note: ' . $listforunavailable . ' are not available for this semester because they are full.';
      $text .= '<br /><strong>Note:</strong> ' . $listforunavailable . ' are not available for this semester because they are full.';
    }
    elseif ($count == 1) {
      //$text .= ' Note: ' . $listforunavailable . ' is not available for this semester because it is full.';
      $text .= '<br /><strong>Note:</strong> ' . $listforunavailable . ' is not available for this semester because it is full.';
    }

    $mform->addElement('select', 'course_id_1', 'First module', $listforselect);
    $mform->addRule('course_id_1', 'First Module is required', 'required', null, 'client');
    $mform->addElement('static', 'explain1', '&nbsp;', $text . '<br />');

    $mform->addElement('select', 'course_id_2', 'Second module', $listforselect);
    $mform->addElement('static', 'explain2', '&nbsp;', 'If you want do apply to study two modules in the same semester, select the second course module here. Please realise that both modules will run at the same time and the workload may be heavy, be sure that you do have the time if you elect to take two modules in the same semester.<br /><br />');

    $mform->addElement('select', 'course_id_alternate', 'Alternate module', $listforselect);
    $mform->addElement('static', 'explain3', '&nbsp;', 'Occasionally, a module you selected above may be full or not currently offered; for this case, please indicate which module is your preferred alternate choice.<br /><br />');

    $listforselect = array();
    $listforselect[1] = 'No, continue with Peoples-uni';
    $listforselect[2] = 'Yes, I am also enrolling with Enterprises University of Pretoria';
    $mform->addElement('select', 'applyceatup', 'Are you also enrolling with Enterprises University of Pretoria?', $listforselect);
    $mform->addElement('static', 'explainapplyceatup', '&nbsp;', 'If you intend enrolling with the University of Pretoria (or already have), please indicate here<br /><br />');
[[
Do you want to apply for the Masters-level programme with Peoples-uni or EUCLID?
NOTE: To apply for either of these programmes, you have to have passed two modules and not failed any after resubmissions.  The curriculum is the same.
NOTE: Peoples-uni programme fee is 500 Sterling in total (sum of all module fees).  The EUCLID MPH costs an additional 750 Sterling for students eligible by start of semester 18b (more thereafter).

Answer options:
Peoples-uni Masters-level programme.
EUCLID MPH programme.
I intend to enrol on one of the Masters programmes in future.
I don’t intend to complete a full Masters programme.
]]

    $listforselect = array();
    //$listforselect[1] = 'No, continue with Peoples-uni';
    //$listforselect[3] = 'I am already enrolled in MMU MPH';
    //$listforselect[4] = 'Yes, apply for Peoples-uni MPH';
    //$listforselect[5] = 'I am already enrolled in Peoples-uni MPH';
// Judith suggested...
//    $listforselect[4] = 'Yes, apply for Peoples-uni MPH';
//    $listforselect[1] = 'No, continue with Peoples-uni';
// I changed to...
    $listforselect[1] = 'No, continue with Peoples-uni';
    $listforselect[4] = 'Yes, apply for Peoples-uni MPH';
    $listforselect[5] = 'I am already enrolled in Peoples-uni MPH';
    $listforselect[3] = 'I am already enrolled in MMU MPH';
    //$listforselect[2] = 'Yes, apply for MMU MPH';
    //$listforselect[6] = 'Yes, apply for OTHER MPH';
    //$listforselect[7] = 'I am already enrolled in OTHER MPH';
    //20170717 removed: $mform->addElement('select', 'applymmumph', 'Apply for Peoples-uni Master of Public Health programme', $listforselect);
    //$mform->addElement('static', 'explainapplymmumph', '&nbsp;', 'Do you want to apply for enrolment in the Master of Public Health programme (please note the fees <a href="http://www.peoples-uni.org/book/course-fees" target="_blank">http://www.peoples-uni.org/book/course-fees</a>)?<br />
//Please do not apply if this is your first semester.<br /><br />');
    //20170717 removed: $mform->addElement('static', 'explainapplymmumph', '&nbsp;', 'If you have already passed two modules at Masters level (50%), and would like to study for a Master of Public Health (MPH) or Diploma with Peoples-uni, please indicate that you want to apply for the MPH programme. If you have previously applied for the Peoples-uni MPH programme, please do so again, to make sure we know your intentions. For more information on the criteria and rules applying to the MPH programme, please follow this link <a href="http://www.peoples-uni.org/node/232" target="_blank">http://www.peoples-uni.org/node/232</a><br /><br />');

    $listforselect = array();
    $listforselect[1] = 'Yes, I intend to submit the final assignment for each module';
    $listforselect[2] = 'No, but I would like to earn a Certificate of Participation';
    $listforselect[3] = 'No, I will study module materials without participating in discussions';
    $mform->addElement('select', 'take_final_assignment', 'Do you intend to submit the Final Assignment for each module?', $listforselect);
    $mform->setDefault('take_final_assignment', 1);
    $mform->addElement('static', 'explaintake_final_assignment', '&nbsp;', 'Choose an option that most closely describes your intentions.');

//    $listforselect = array();
//    $listforselect[1] = 'No';
//    $listforselect[2] = 'Yes';
//    $listforselect[3] = 'I am already enrolled in the Certificate in Patient Safety';
//    $mform->addElement('select', 'applycertpatientsafety', 'Apply for Certificate in Patient Safety', $listforselect);
//    $mform->addElement('static', 'explainapplycertpatientsafety', '&nbsp;', 'Do you want to apply for enrolment in the Certificate in Patient Safety (see <a href="http://www.peoples-uni.org/node/281" target="_blank">http://www.peoples-uni.org/node/281</a>)?<br />
//For this certificate you will need to complete the Evidence Based Practice, Patient Safety & Patient Safety in Practice modules.<br />');

    $mform->addElement('header', 'personaldetails', 'Your Existing Moodle User Name');
    $mform->setExpanded('personaldetails');

    $mform->addElement('text', 'username', 'Moodle Username', 'maxlength="100" size="50"');
    $mform->addRule('username', 'Moodle Username is required', 'required', null, 'client');
    $mform->setType('username', PARAM_MULTILANG);
    $mform->addElement('static', 'explainusername', '&nbsp;', 'The user name you use to login to your course modules.<br />');


    $mform->addElement('header', 'scholorshipdetails', 'Scholarship');
    $mform->setExpanded('scholorshipdetails');

//RAJAN/DICK Judith wants edit...
    $mform->addElement('static', 'explainscholarship', '&nbsp;', 'If you cannot afford the fees, we may be able to assist in approved cases. If you would like to apply for a reduction or waiver of the <a href="https://peoples-uni.org/content/course-fees-payment-options" target="_blank">fees (click here)</a>, please provide details on:<br />
1. What is your current employment AND monthly gross income<br />
2. What is the reason you are unable to pay the fees<br />
3. Whether you are able to pay a portion of the fees and if so how much<br />
4. How you plan to use the skills/qualifications you will gain from Peoples-uni for the health of the population (up to 150 words)<br />
5. Please note that late applications for scholarships cannot be considered after ' . gmdate('jS F Y', get_config(NULL, 'peoples_last_application_date'))');
    $mform->addElement('textarea', 'scholarship', '&nbsp;', 'wrap="HARD" rows="10" cols="100" style="width:auto"');


    $mform->addElement('header', 'whynotcompletedetails', 'Previous Semester');
    $mform->setExpanded('whynotcompletedetails');

    $mform->addElement('static', 'explainwhynotcomplete', '&nbsp;', 'If you are a returning student and did not complete your previous semester, please explain why this was so.');
    $mform->addElement('textarea', 'whynotcomplete', '&nbsp;', 'wrap="HARD" rows="10" cols="100" style="width:auto"');


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
