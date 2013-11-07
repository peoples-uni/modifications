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
<p>Welcome to your Dissertation!</p>
<p>The Dissertation module is a two semester commitment which will allow you to deepen your understanding of research methodology. During the Dissertation you will be working on two large assignments:<br />
(1) a systematic literature review and<br />
(2) a project proposal with presentation and a reflective essay about your learning experience.<br />
We will be asking you to identify an important health issue relevant to your population and your two assignments will then be focussed on this health issue that you would like to investigate.</p>
<p>During your Dissertation you will be working with a local advisor as well as an academic tutor. It is your responsibility to find your local advisor, but your academic tutor will be identified through Peoples-uni. We would like to match your research interest with that of your academic tutor and we are therefore asking you to give us a broad idea (such as, maternal health, HIV/AIDS, chronic disease in developing countries) of the health issue that you want to study further. Of course, the more specific the better!</p>
</strong>
<p><strong>You should receive an e-mail with a copy of your Dissertation health issue when you submit this form. If you do not, it means that we cannot reach your e-mail address. In that case please send an e-mail to <a href="mailto:apply@peoples-uni.org">apply@peoples-uni.org</a></strong></p>');

    $mform->addElement('header', 'dissertationdetails', 'Dissertation');

    $mform->addElement('static', 'explaindissertation', '&nbsp;', 'Describe the health issue you want to study in your dissertation (up to 150 words)<br />');
    $mform->addElement('textarea', 'dissertation', 'Health issue you want to study in your dissertation', 'wrap="HARD" rows="10" cols="100"');
    $mform->addRule('dissertation', 'Dissertation Health Issue is required', 'required', null, 'client');

    $this->add_action_buttons(false, 'Submit Form');
  }


  function validation($data, $files) {

    $errors = parent::validation($data, $files);

    return $errors;
  }
}
