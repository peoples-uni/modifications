<?php

/**
 * Rating Response Form to allow Students to respond to their Discussion Feedback from the SSOs (Form Class)
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');


class ratingresponse_form extends moodleform {

  function definition() {
    global $DB, $CFG, $USER;

    $mform = $this->_form;

    $mform->addElement('header', 'top', 'Instructions');

    $course = $DB->get_record('course', array('id' => $_SESSION['peoples_course_id_for_student_ratingresponse']));

    $student_ratingresponse = $DB->get_record('student_ratingresponse', array('userid' => $USER->id, 'course_id' => $_SESSION['peoples_course_id_for_student_ratingresponse']));

    if (!empty($student_ratingresponse)) $already_submitted = '<br />(You have already submitted this form, but you may submit again if you wish.)';
    else  $already_submitted = '';

    $mform->addElement('static', 'instuctions', '',
      '<p><strong>Module: ' . htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8')  . $already_submitted. '</strong></p><br />
      <p>This form is used to allow you to reflect on what you need to improve your discussion forum contributions in this module and how you will do that.</p>
      <p>Below this form you can see past ratings on your discussion contributions by Student Support Officers for all modules along with any reflections on these ratings that you have previously submitted.</p>
      <p>Guidelines for discussion forum contributions are in <a href="http://peoples-uni.org/content/discussion-contributions" target="_blank">Student Handbook: Discussion contributions</a></p>
      <p><strong>Note:</strong> The data in this form will not be visible to other students.</p>
      <p><strong>Note:</strong> You must complete all fields marked with a red <span style="color:#ff0000">*</span>.</p>
      <p>When submitted for a specific student, the student will be sent an e-mail (the wording for which is specified in <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a></p>
      <p>The data submitted will also be kept for later analysis in <a href="http://courses.peoples-uni.org/course/ratingresponses.php" target="_blank">http://courses.peoples-uni.org/course/ratingresponses.php</a></p>
      ');

    $mform->addElement('header', 'assessment_header', 'Reflections');

    $mform->addElement('textarea', 'what_skills_need_to_improve',           'What skills do I need to improve? (think about feedback I received from tutor feedback tool and tutor/other student posts)', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    $mform->addRule('what_skills_need_to_improve',                          'What skills do I need to improve is required', 'required', null, 'client');

    $mform->addElement('textarea', 'what_do_to_improve_academic_skills',    'What will I do to improve my academic skills? (and when?)', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    $mform->addRule('what_do_to_improve_academic_skills',                   'What will I do to improve my academic skills is required', 'required', null, 'client');

    $mform->addElement('textarea', 'what_do_differently_when_prepare_post', 'What will I do differently when I prepare a discussion post?', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    $mform->addRule('what_do_differently_when_prepare_post',                'What will I do differently is required', 'required', null, 'client');

    $this->add_action_buttons(false, 'Submit Form');
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    return $errors;
  }
}
?>