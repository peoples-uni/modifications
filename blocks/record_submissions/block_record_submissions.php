<?php

// Stored in /blocks/record_submissions/

// This block is used to add an event hook for Student submissions to the 'assign' Module. The block is not intended to be displayed


class block_record_submissions extends block_base {

  function init() {
    $this->title = 'Record Submissions';
    //$this->version = 2010101738;
  }

  function get_content() {

    if($this->content !== NULL) {
      return $this->content;
    }

    $this->content = new stdClass;

    $this->content->footer = '';

    $this->content->text = '';

    return $this->content;
  }

  //function hide_header() {return true;}
}
?>
