<?php

/**
 * Dissertation Topic Form (Form Class)
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

class dissertation_form extends moodleform {

  function definition() {
    $mform = $this->_form;

    $mform->addElement('header', 'top', 'Instructions');

    $mform->addElement('static', 'instuctions', '',
'<strong>
<p>The Dissertation module is a two semester commitment which will allow you to deepen your understanding of research methodology.</p>
<p>Please read the detailed information about the dissertation now, before you start, (see <a href="https://www.peoples-uni.org/content/dissertation-module-requirements" target="_blank">https://www.peoples-uni.org/content/dissertation-module-requirements</a>) and satisfy yourself that you have understood what is required during this period and that you can take on this commitment. As you will see, you will need to work systematically with a very clear timetable for submitting assignments.</p>
<p>We will be asking you to identify an important health issue relevant to your population and your two assignments will then be focussed on this health issue that you would like to investigate.</p>
<p>During your Dissertation you will be working with a local adviser as well as an academic tutor. It is your responsibility to find your local adviser, but your academic tutor will be identified through Peoples-uni. We would like to match your research interest with that of your academic tutor and we are therefore asking you to give us a broad idea (such as, maternal health, HIV/AIDS, chronic disease in developing countries) of the health problem issue that you want to study further. Please fill the form below.</p>
</strong>
<p><strong>You should receive an e-mail with a copy of your Dissertation health issue when you submit this form. If you do not, it means that we cannot reach your e-mail address. In that case please send an e-mail to <a href="mailto:apply@peoples-uni.org">apply@peoples-uni.org</a></strong></p>');

    $mform->addElement('header', 'dissertationdetails', 'Dissertation');

    $mform->addElement('static', 'explaindissertation', '&nbsp;', 'Describe the health issue you want to study in your dissertation (up to 150 words)<br />');
    $mform->addElement('textarea', 'dissertation', 'Health issue you want to study in your dissertation', 'wrap="HARD" rows="10" cols="100" style="width:auto"');
    $mform->addRule('dissertation', 'Dissertation Health Issue is required', 'required', null, 'client');

    $this->add_action_buttons(false, 'Submit Form');
  }


  function validation($data, $files) {

    $errors = parent::validation($data, $files);

    return $errors;
  }
}
