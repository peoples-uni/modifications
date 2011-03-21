<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class application_form_new_student_form extends moodleform {
  protected $course;
  protected $context;

  function definition() {
    global $DB;

    $mform    = $this->_form;

    $editoroptions = $this->_customdata['editoroptions'];
    $returnto = $this->_customdata['returnto'];

    echo '<h2>Instructions</h2>
<p>Please read the information in <a href="http://www.peoples-uni.org/book/essential-information-potential-students">Essential information for potential students</a> before submitting this form, particularly see the information about <a href="http://peoples-uni.org/book/course-fees">Course fees</a> </p>
<p><strong>Use this form for your <u>first</u> application to do one or two training course modules in the semester in which you wish to start. <br /><br />
        </strong></p>
<p>For inquires about registration or payment please send an email to  <a href="mailto:apply@peoples-uni.org?subject=Registration or payment query">apply@peoples-uni.org</a>.</p>
<p><strong>Note:</strong> You must complete the fields marked with a red <span style="color:#ff0000">*</span>.</p>
<p><strong>You should receive an e-mail with a copy of your application when you submit this form. If you do not, it means that we cannot reach your e-mail address. In that case please send a mail to <a href="mailto:techsupport@peoples-uni.org">techsupport@peoples-uni.org</a>.</strong></p>';


    $mform->addElement('header', 'general', 'Course Module Selection');

    $mform->addElement('hidden', 'returnto', null);
    $mform->setType('returnto', PARAM_ALPHANUM);
    $mform->setConstant('returnto', $returnto);

    echo 'Semester';

    $modules[9] = 'biostat';
    $mform->addElement('select', 'module1', 'First module', $modules);
//    $mform->addHelpButton('module1', "Please select the first course module you are applying for from the drop down box. Note: 'Biostatistics 11a', 'Communicable Disease 11a', 'Disaster Management and Emergency Planning 11a', 'Evaluation of Interventions 11a', 'Evidence Based Practice 11a', 'HIV/AIDS 11a', 'Health Economics 11a', 'Introduction to Epidemiology 11a', 'Maternal Mortality 11a', 'Patient Safety 11a', 'Preventing Child Mortality 11a', 'Public Health Ethics 11a', 'Public Health Nutrition 11a' are not available for this semester because they are full.");
    //$mform->setDefault('module1', 9);

    $mform->addElement('select', 'module2', 'Second module', $modules);
//    $mform->addHelpButton('module2', 'If you want do apply to do two modules in the same semester, select the second course module here. Please realise that both modules will run at the same time and the workload may be heavy, be sure that you do have the time if you elect to take two modules in the same semester.');
    //$mform->setDefault('module2', 9);

/*
    $mform->addElement('header', 'general', 'Personal details');



>>>Text
        $mform->addElement('text','fullname', get_string('fullnamecourse'),'maxlength="254" size="50"');
        $mform->addHelpButton('fullname', 'fullnamecourse');
        $mform->addRule('fullname', get_string('missingfullname'), 'required', null, 'client');
        $mform->setType('fullname', PARAM_MULTILANG);
        if (false) {
            $mform->hardFreeze('fullname');
            $mform->setConstant('fullname', $course->fullname);
        }

>>>Textarea
        $mform->addElement('editor','summary_editor', get_string('coursesummary'), null, $editoroptions);
        $mform->addHelpButton('summary_editor', 'coursesummary');
        $mform->setType('summary_editor', PARAM_RAW);
        if (false) {
            $mform->hardFreeze('summary_editor');
        }

>>>Date
        $mform->addElement('date_selector', 'startdate', get_string('startdate'));
        $mform->addHelpButton('startdate', 'startdate');
        $mform->setDefault('startdate', time() + 3600 * 24);

>>>YES/NO
        $mform->addElement('selectyesno', 'showgrades', get_string('showgrades'));
        $mform->addHelpButton('showgrades', 'showgrades');
        $mform->setDefault('showgrades', $courseconfig->showgrades);

>>>Header
        $mform->addElement('header','', get_string('groups', 'group'));


...
>>>Make an elemnet constant
            $mform->hardFreeze('visible');
            $mform->setConstant('visible', $course->visible);

>>>checkbox
            $mform->addElement('checkbox', 'completionstartonenrol', get_string('completionstartonenrol', 'completion'));
            $mform->setDefault('completionstartonenrol', $courseconfig->completionstartonenrol);
            $mform->disabledIf('completionstartonenrol', 'enablecompletion', 'eq', 0);
*/
//--------------------------------------------------------------------------------
        $this->add_action_buttons();
//--------------------------------------------------------------------------------
$course = new stdClass();
        $this->set_data($course);
    }

    function definition_after_data() {
        global $DB;

        $mform = $this->_form;

        // add available groupings
        if ($courseid = $mform->getElementValue('id') and $mform->elementExists('defaultgroupingid')) {
            $options = array();
            if ($groupings = $DB->get_records('groupings', array('courseid'=>$courseid))) {
                foreach ($groupings as $grouping) {
                    $options[$grouping->id] = format_string($grouping->name);
                }
            }
            $gr_el =& $mform->getElement('defaultgroupingid');
            $gr_el->load($options);
        }
    }


/// perform some extra moodle validation
    function validation($data, $files) {
        global $DB;

        $errors = parent::validation($data, $files);
        if ($foundcourses = $DB->get_records('course', array('shortname'=>$data['shortname']))) {
            if (!empty($data['id'])) {
                unset($foundcourses[$data['id']]);
            }
            if (!empty($foundcourses)) {
                foreach ($foundcourses as $foundcourse) {
                    $foundcoursenames[] = $foundcourse->fullname;
                }
                $foundcoursenamestring = implode(',', $foundcoursenames);
                $errors['shortname']= get_string('shortnametaken', '', $foundcoursenamestring);
            }
        }

        $errors = array_merge($errors, enrol_course_edit_validation($data, $this->context));

        return $errors;
    }
}

