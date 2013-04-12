<?php

/**
 * minimalistic edit form
 *
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class peoples_user_files_form extends moodleform {
  function definition() {
    $mform = $this->_form;

    $data    = $this->_customdata['data'];
    $options = $this->_customdata['options'];

    $mform->addElement('filemanager', 'files_filemanager', get_string('files'), NULL, $options);
    $mform->addElement('hidden', 'returnurl', $data->returnurl);
    $mform->setType('returnurl', PARAM_LOCALURL);

    if ($options['is_manager']) {
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
