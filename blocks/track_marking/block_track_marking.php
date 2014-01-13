<?php //$Id: block_track_marking.php,v 1.1 2010/10/13 17:29:0 alanbarrett Exp $

// Stored in /blocks/track_marking/

// Allow tutors to view the Google Apps Spreadsheet for Collaborative Assignment Marking and Resubmission Tracking


class block_track_marking extends block_base {

  function init() {
    $this->title = 'Track Marking';
    //$this->version = 2010101738;
  }

  function get_content() {
    global $DB;
    global $CFG, $COURSE;

    if($this->content !== NULL) {
      return $this->content;
    }

    $this->content = new stdClass;

    require_once($CFG->dirroot .'/course/lib.php');

    $this->content->footer = '';

    $admin = has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

    $this->content->text = '';

    // If this is a site admin or Module Leader/Tutors in that course show the block
    if (has_capability('moodle/grade:edit', context_course::instance($COURSE->id)) || $admin) {

      $google_ss = $DB->get_record('peoples_google_ss', array('course_id' => $COURSE->id));
      if (!empty($google_ss->full_link)) {
        $this->content->text = '<a href="' . $google_ss->full_link . '" target="_blank">Edit Marking Spreadsheet</a>';
      }

      if ($admin) {
        if (!empty($this->content->text)) $this->content->text .= '<br />';
        $this->content->text .= '<a href="' . $CFG->wwwroot . '/course/create_marking_ss.php?id=' . $COURSE->id . '" target="_blank">Re-Create Marking Spreadsheet</a>';
        // $this->content->text .= '<br /><a href="' . $CFG->wwwroot . '/course/get_grades_from_marking_ss.php?id=' . $COURSE->id . '" target="_blank">Store Course Total Grades into Moodle</a>';
      }
    }

    return $this->content;
  }

  //function hide_header() {return true;}
}
?>
