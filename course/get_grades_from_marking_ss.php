<?php  // $Id: get_grades_from_marking_ss.php,v 1.1 2010/10/27 12:49:00 alanbarrett Exp $
/**
*
* Retrieve Student Grades from Google Apps Spreadsheet for Collaborative Assignment Marking and Resubmission Tracking
*
*/

require("../config.php");
//require_once($CFG->dirroot .'/course/lib.php');

require_login();

require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

print_header('Retrieve Student Grades from Google Apps Spreadsheet for Collaborative Assignment Marking and Resubmission Tracking');

echo '<h2>Retrieve Student Grades from Google Apps Spreadsheet for Collaborative Assignment Marking and Resubmission Tracking</h2><br /><br />';


if (!empty($_POST['markgetgradesfromss']) && !empty($_POST['course_id'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $id = (int)$_POST['course_id'];
  $course = get_record('course', 'id', $id);
  if (empty($course)) die();

  /**
   * @see Zend_Loader
   */
  require_once 'Zend/Loader.php';

  /**
   * @see Zend_Gdata
   */
  Zend_Loader::loadClass('Zend_Gdata');

  /**
   * @see Zend_Gdata_AuthSub
   */
  Zend_Loader::loadClass('Zend_Gdata_AuthSub');

  /**
   * @see Zend_Gdata_ClientLogin
   */
  Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

  /**
   * @see Zend_Gdata_Docs
   */
  Zend_Loader::loadClass('Zend_Gdata_Docs');

  /**
   * @see Zend_Gdata_Spreadsheets
   */
  Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');


  $google_ss = get_record('peoples_google_ss', 'course_id', $id);
  if (empty($google_ss)) {
        echo "<br /><br /><strong>Error: No marking spreadsheet exists for course.</strong><br /><br />";

        echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
        print_footer();
        die();
  }

  // Example $link: http://spreadsheets.google.com/ccc?key=0Ag3Bj9qWqJ-VdHpmVnNWWVBTTGF3OEE4Z1BzWlN5dUE&hl=en&authkey=CNboh4wB
  $link = $google_ss->full_link;
  $key = substr($link, strpos($link, '?key=') + 5);

  $pos = strpos($key, '&hl=en');
  if ($pos !== false) $key = substr($key, 0, $pos);


  // Get cells in Spreadsheet (sheet will default to 'default')
  try {
    $client = Zend_Gdata_ClientLogin::getHttpClient('admin@files.peoples-uni.org', 'Schull11', Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME);
    $spreadsheets = new Zend_Gdata_Spreadsheets($client);
  } catch (Zend_Gdata_App_AuthException $ae) {
    echo '<br /><br /><strong>Error: Unable to authenticate with files.peoples-uni.org (Spreadsheets).</strong><br /><br />';

    echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }

  $query = new Zend_Gdata_Spreadsheets_CellQuery();
  $query->setSpreadsheetKey($key);
  $feed = $spreadsheets->getCellFeed($query);

  if ($feed instanceOf Zend_Gdata_Spreadsheets_CellFeed) {
    //$rowCount = $feed->getRowCount();
    //$columnCount = $feed->getColumnCount();

    $number = 0;
    $users = array();
    foreach($feed->entries as $entry) {
      // Cells are identified by something like "A1"
      $matched = preg_match('/^([A-Z]+)([0-9]+)$/', $entry->title->text, $matches);
      if (!$matched) {
        echo "<br /><br /><strong>Error: Unable to identify the cell for: {$entry->title->text}.</strong><br /><br />";

        echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
        print_footer();
        die();
      }
      $col = $matches[1];
      $row = $matches[2];
      // echo "$col:$row {$entry->title->text} {$entry->content->text}<br />";

      if ($row == 1) {
        $columns_for_headers[$entry->content->text] = $col;
      }
      elseif ($col === 'A' && $row > 1) {
        // Students are identified by something like "Name(999) in first column (2nd row on)"
        $matched = preg_match('/^.+\(([0-9]+)\)/', $entry->content->text, $matches);
        if (!$matched) {
          echo "<br /><br /><strong>Error: Unable to get the student user ID for cell: {$entry->title->text}.</strong><br /><br />";

          echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
          print_footer();
          die();
        }

        $users[$row] = $matches[1];
        $usertexts[$row] = $entry->content->text;
        $number++;
      }
      else {
        $ss[$row][$col] = $entry->content->text;
      }
    }

    if (empty($columns_for_headers['Overall Module Grade: Pass/fail'])) {
      echo "<br /><br /><strong>Error: Unable to find header for 'Overall Module Grade: Pass/fail'.</strong><br /><br />";

      echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
      print_footer();
      die();
    }
    $col = $columns_for_headers['Overall Module Grade: Pass/fail'];

    $n_grades = 0;
    $grades = array();
    echo '<table>';
    foreach ($users as $row => $user_id) {
      if (!empty($ss[$row][$col])) {
        $grades[$user_id] = $ss[$row][$col];
        echo "<tr><td>{$usertexts[$row]}:&nbsp;</td><td>{$grades[$user_id]}</td></tr>";
        $n_grades++;
      }
      else {
        $grades[$user_id] = NULL;
      }
    }
    echo '</table>';

    $grade_item = get_record('grade_items', 'courseid', $id, 'itemtype', 'course');
    if (empty($grade_item)) {
      echo "<br /><br /><strong>Error: No grade_items entry exists for course.</strong><br /><br />";

      echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
      print_footer();
      die();
    }

    // Test
    //echo "<br />grade_item->id: {$grade_item->id}<br />";
    //$users = array(0 => 150000); // Pretend user for insert
    //$users = array(0 => 150); // David for update
    //$grade_item->id = 55; // Techie check course grade item
    //$grades[150] = NULL;
    //$grades[150] = 'fail';
    //$grades[150] = 'pass';
    //$grades[150] = $grades[863];
    //$grades[150000] = $grades[863];
    // End Test

    $n_added = 0;
    $n_updated = 0;
    foreach ($users as $row => $user_id) {
      $grade = $grades[$user_id];
      $nograde = empty($grade) || (stripos($grade, 'P')===FALSE && stripos($grade, 'F')===FALSE);

      $grade_grade = get_record('grade_grades', 'itemid', $grade_item->id, 'userid', $user_id);

      if (empty($grade_grade) && $nograde) {
        // Do nothing because there is no grade in Moodle and none in the spreadsheet
      }
      elseif (empty($grade_grade)) {
        // Need to Insert a grade in Moodle
        $record = new object();

        if     (stripos($grade, 'P') !== FALSE) $record->finalgrade = 1.0;
        elseif (stripos($grade, 'F') !== FALSE) $record->finalgrade = 2.0;

        $record->itemid       = $grade_item->id;
        $record->userid       = $user_id;
        $record->usermodified = $USER->id;
        $record->overridden   = time();
        $record->timemodified = time();
        insert_record('grade_grades', $record);

        $grade_grade = get_record('grade_grades', 'itemid', $grade_item->id, 'userid', $user_id);

        unset($grade_grade->timecreated);
        $grade_grade->action       = 1;
        $grade_grade->oldid        = $grade_grade->id;
        unset($grade_grade->id);
        $grade_grade->source       = 'gradebook';
        $grade_grade->timemodified = time();
        $grade_grade->userlogged   = $USER->id; // Perpetuate bug!
        insert_record('grade_grades_history', addslashes_recursive($grade_grade));

        $n_added++;
      }
      else {
        // Need to Update a grade in Moodle
        $record = new object();
        $record->id = $grade_grade->id;

        if     ($nograde)                       $record->finalgrade = NULL;
        elseif (stripos($grade, 'P') !== FALSE) $record->finalgrade = 1.0;
        elseif (stripos($grade, 'F') !== FALSE) $record->finalgrade = 2.0;

        if (is_null($grade_grade->finalgrade) && is_null($record->finalgrade)) continue;
        if (isset($grade_grade->finalgrade) && isset($record->finalgrade) && (abs($grade_grade->finalgrade - $record->finalgrade) < 0.00001)) continue;

        $record->usermodified = $USER->id;
        $record->overridden   = time();
        $record->timemodified = time();
        update_record('grade_grades', $record);

        $grade_grade = get_record('grade_grades', 'itemid', $grade_item->id, 'userid', $user_id);

        unset($grade_grade->timecreated);
        $grade_grade->action       = 2;
        $grade_grade->oldid        = $grade_grade->id;
        unset($grade_grade->id);
        $grade_grade->source       = 'gradebook';
        $grade_grade->timemodified = time();
        $grade_grade->userlogged   = $USER->id; // Perpetuate bug!
        insert_record('grade_grades_history', addslashes_recursive($grade_grade));

        $n_updated++;
      }
    }
  }
  else {
    echo '<br /><br /><strong>Error: Zend_Gdata_Spreadsheets_CellFeed not returned.</strong><br /><br />';

    echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }


  echo "<br /><br /><br />$n_grades non-empty Grades Retrieved for $number students.<br /><br />";
  echo "$n_added Grades Added to Moodle.<br />";
  echo "$n_updated Grades Changed in Moodle.<br /><br />";
}
else {
  $id = required_param('id', PARAM_INT);

  $course = get_record('course', 'id', $id);
  if (empty($course)) die();

  echo '<script type="text/JavaScript">function areyousuregetgradesfromss() { var sure = false; sure = confirm("Are you sure you want to Retrieve the Course Total Grades (only) from the Google Apps Spreadsheet for Collaborative Assignment Marking and Resubmission Tracking for: ' . htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8')
    . '. These are taken from the column \"Overall Module Grade: Pass/fail\" and stored in the Moodle Grade Book (and will overwrite any existing grades for this course in Moodle... e.g. if a grade is not set in the spreadsheet but is set in Moodle, it will overwritten to be No Grade)."); return sure;}</script>';
  ?>

  <form method="post" action="<?php echo $CFG->wwwroot . '/course/get_grades_from_marking_ss.php'; ?>" onSubmit="return areyousuregetgradesfromss()">

  <input type="hidden" name="course_id" value="<?php echo $course->id; ?>" />
  <input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
  <input type="hidden" name="markgetgradesfromss" value="1" />

  <input type="submit" name="getgradesfromss" value="Retrieve Grades from Spreadsheet for: '<?php echo htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8'); ?>'" style="width:40em" />
  </form>
  <br />
  <?php
}

echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';

print_footer();
?>
