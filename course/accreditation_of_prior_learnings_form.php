<?php

/**
 * Accreditation of Prior Learnings Form (Form Class)
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class accreditation_of_prior_learnings_form extends moodleform {

  function definition() {
    global $DB, $CFG;

    $mform = $this->_form;

    $mform->addElement('header', 'top', 'Instructions');

    $mform->addElement('static', 'instuctions', '',
      '<p>This form is used to record Accreditation of Prior Learnings for a Student. These will be used to count towards a Certificate or Diploma for the Student.</p>
      <p><strong>Note:</strong> You must complete the fields marked with a red <span style="color:#ff0000">*</span>.</p>
      ');

    $mform->addElement('header', 'assessment_header', 'Accreditation of Prior Learnings');

    $enrols = $DB->get_records_sql("
      SELECT DISTINCT u.*, CONCAT(u.lastname, ', ', u.firstname) AS lastfirst, a.id IS NOT NULL AS already_submitted, a.prior_foundation, a.prior_problems
      FROM mdl_user u
      LEFT JOIN mdl_peoples_accreditation_of_prior_learning a ON u.id=a.userid
      ORDER BY CONCAT(u.lastname, ', ', u.firstname)");

    $listforstudents = array();
    $listforstudents[''] = 'Select...';
    foreach ($enrols as $student) {
      $listforstudents[$student->id] = $student->lastfirst;
      if ($student->already_submitted) $listforstudents[$student->id] .= " (Prior Foundation: $student->prior_foundation, Problems: $student->prior_problems)";
    }
    $mform->addElement('select', 'student_id', 'Student', $listforstudents);
    $mform->addRule('student_id', 'Student is required', 'required', null, 'client');
    $mform->addElement('static', 'explain_student_id', '&nbsp;', 'Student for which accreditation of prior learnings will be recorded.<br />');

    $assessmentname['0'] = '0';
    $assessmentname['1'] = '1';
    $assessmentname['2'] = '2';
    $assessmentname['3'] = '3';
    $mform->addElement('select', 'prior_foundation', 'Number of Foundation Modules to be Accredited for Prior Learning', $assessmentname);

    $mform->addElement('select', 'prior_problems', 'Number of Problems Modules to be Accredited for Prior Learning', $assessmentname);

    $mform->addElement('textarea', 'note', 'Add any note you wish to record', 'wrap="HARD" rows="10" cols="100" style="width:auto"');

    $this->add_action_buttons(false, 'Submit Form');
  }


  function validation($data, $files) {
    global $DB;

    $errors = parent::validation($data, $files);

    return $errors;
  }
}
?>