<?php

/**
 * Discussion Feedback Form (Form Class)
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class discussionfeedback_form extends moodleform {

  function definition() {
    global $DB, $CFG;

    $mform = $this->_form;

    $mform->addElement('header', 'top', 'Instructions');

    if (!empty($_SESSION['peoples_course_id_for_discussion_feedback'])) {
      $course = $DB->get_record('course', array('id' => $_SESSION['peoples_course_id_for_discussion_feedback']));

      $course_text = '<p><strong>The Module being assessed is: ' . htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8') . '<br />
        To change to a different one <a href="http://courses.peoples-uni.org/course/discussionfeedback_reset.php">Click Here to allow re-selection</a></p></strong><br /><br /><br />';
    }
    else {
      $course_text = '';
    }

    $mform->addElement('static', 'instuctions', '',
      '<p>This form is used to provide feedback to Students about their contributions to the discussion forums in each of the Topics in a module.</p>
      <p>Guidelines for student contribution are in <a href="http://peoples-uni.org/content/discussion-contributions">Student Handbook: Discussion contributions</a></p>
      <p><strong>Note:</strong> You must complete the fields marked with a red <span style="color:#ff0000">*</span>.</p>
      <p><strong>Note: The first time you use this form for a new module you must select the correct module (be sure to pick the one for the correct semester) and Click Submit in order to get the correct list of Students.</strong></p>
      ' . $course_text . '
      <p>When submitted for a specific student, the student will be sent an e-mail (the wording of which is specified in <a href="http://courses.peoples-uni.org/course/settings.php">http://courses.peoples-uni.org/course/settings.php</a></p>
      <p>The data submitted will also be kept for later analysis in <a href="http://courses.peoples-uni.org/course/discussionfeedbacks.php">http://courses.peoples-uni.org/course/discussionfeedbacks.php</a></p>
      ');


    if (empty($_SESSION['peoples_course_id_for_discussion_feedback'])) {
      $courses = $DB->get_records('course', NULL, 'fullname ASC');
      $listformodules = array();
      $listformodules[''] = 'Select...';
      foreach ($courses as $course) {
        $listformodules[$course->id] = $course->fullname;
      }
      $mform->addElement('select', 'course_id', 'Module', $listformodules);
      //if (!empty($_SESSION['peoples_course_id_for_discussion_feedback'])) $mform->setDefault('course_id', $_SESSION['peoples_course_id_for_discussion_feedback']);
      $mform->addRule('course_id', 'Module is required', 'required', null, 'client');
      $mform->addElement('static', 'explain_module', '&nbsp;', 'Module for which student contributions to discussions will be assessed.<br />');
    }
    else {
      $enrols = $DB->get_records_sql("
        SELECT u.* FROM mdl_user u, mdl_enrolment e WHERE u.id=e.userid AND e.enrolled=1 AND e.courseid=? ORDER BY CONCAT(u.firstname, u.lastname)",
        array($_SESSION['peoples_course_id_for_discussion_feedback']));

      $listforstudents = array();
      $listforstudents[''] = 'Select...';
      foreach ($enrols as $student) {
        $listforstudents[$student->id] = fullname($student);
      }
      $mform->addElement('select', 'student_id', 'Module', $listforstudents);
      $mform->addRule('student_id', 'Student is required', 'required', null, 'client');
      $mform->addElement('static', 'explain_student_id', '&nbsp;', 'Student for which contributions to discussions will be assessed.<br />');


      $mform->addElement('header', 'assessment_header', 'Assessment');

      // Referred to resources in the topics
      $assessmentname[  ''] = 'Select...';
      $assessmentname['10'] = 'Yes';
      $assessmentname['20'] = 'No';
      $assessmentname['30'] = 'Could be improved';
      $mform->addElement('select', 'refered_to_resources', 'Referred to resources in the topics', $assessmentname);
      $mform->addRule('refered_to_resources', 'Referred to resources in the topics is required', 'required', null, 'client');
      $mform->addElement('static', 'explainrefered_to_resources', '&nbsp;', 'Did the student refer to resources in the topics?<br />');

      // Included critical approach to information
      $assessmentname[  ''] = 'Select...';
      $assessmentname['10'] = 'Yes';
      $assessmentname['20'] = 'No';
      $assessmentname['30'] = 'Could be improved';
      $mform->addElement('select', 'critical_approach', 'Included critical approach to information', $assessmentname);
      $mform->addRule('critical_approach', 'Included critical approach to information is required', 'required', null, 'client');
      $mform->addElement('static', 'explaincritical_approach', '&nbsp;', 'Did the student show a critical approach to information?<br />');

      // Provided references in an appropriate format
      $assessmentname[  ''] = 'Select...';
      $assessmentname['10'] = 'Yes';
      $assessmentname['20'] = 'No';
      $assessmentname['30'] = 'Could be improved';
      $mform->addElement('select', 'provided_references', 'Provided references in an appropriate format', $assessmentname);
      $mform->addRule('provided_references', 'Provided references in an appropriate format is required', 'required', null, 'client');
      $mform->addElement('static', 'explainprovided_references', '&nbsp;', 'Did the student provide references in an appropriate format?<br />');

      $mform->addElement('static', 'explainassessment_text', '&nbsp;', 'Add any free text you wish to be added to the assessment<br />');
      $mform->addElement('textarea', 'assessment_text', '&nbsp;', 'wrap="HARD" rows="10" cols="100"');
    }

    $this->add_action_buttons(false, 'Submit Form');
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    return $errors;
  }
}
?>