<?php

/**
 * minimalistic edit form
 *
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class peoples_user_files_form extends moodleform {
  function definition() {
    global $DB;

    $mform = $this->_form;

    $data    = $this->_customdata['data'];
    $options = $this->_customdata['options'];

    $mform->addElement('filemanager', 'files_filemanager', get_string('files'), NULL, $options);
    $mform->addElement('hidden', 'returnurl', $data->returnurl);
    $mform->setType('returnurl', PARAM_LOCALURL);

    if ($options['is_manager']) {
      $student = $DB->get_record('user', array('id' => $options['student_id']));

      $message =
"Dear GIVEN_NAME_HERE,&XXX\"'?<>

This is to inform you that the following files have been uploaded for you...

LIST_OF_FILES

You can access these by going to the 'My Course' page, and click on the
'Click here to view Grade & Transcripts'
which is located at the top left corner, scroll to the bottom of the page and click on
'Your Peoples-uni Record Files'.

To download a file, click on the file and select 'download' from the drop down menu.

     Peoples Open Access Education Initiative Administrator.";

      $message = str_replace('GIVEN_NAME_HERE', $student->firstname, $message);

      $mform->addElement('static', 'spacing-1', '&nbsp;', '&nbsp;<br />');

      $mform->addElement('textarea', 'emailtosend', 'e-mail to send to Student', 'wrap="HARD" rows="10" cols="75"');
      $mform->setDefault('emailtosend', $message);
      $mform->addElement('static', 'explainemailtosend', '&nbsp;', 'Edit the e-mail as required (e-mail will only be sent if you change the files).<br />');

      $mform->addElement('checkbox', 'dont_send_email', 'Check if you do not want to send an e-mail');

      $this->add_action_buttons(TRUE, get_string('savechanges'));
    }

    $this->set_data($data);
  }


  function validation($data, $files) {

    $errors = array();
    $draftitemid = $data['files_filemanager'];
    //if (file_is_draft_area_limit_reached($draftitemid, $this->_customdata['options']['areamaxbytes'])) {
    //    $errors['files_filemanager'] = get_string('userquotalimit', 'error');
    //}

    return $errors;
  }
}
