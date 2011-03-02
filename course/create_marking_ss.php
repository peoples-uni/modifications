<?php  // $Id: create_marking_ss.php,v 1.1 2010/10/12 14:34:32 alanbarrett Exp $
/**
*
* Create Google Apps Spreadsheet for Collaborative Assignment Marking and Resubmission Tracking
*
*/

/*
CREATE TABLE mdl_peoples_google_ss (
  id BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  course_id BIGINT(10) UNSIGNED NOT NULL,
  full_link VARCHAR(255) NOT NULL,
  status BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  description VARCHAR(255) NOT NULL DEFAULT '',
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_peoples_google_ss_course_id_ix ON mdl_peoples_google_ss (course_id);
*/


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

require_login();

require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

print_header('Create Google Apps Spreadsheet for Collaborative Assignment Marking and Resubmission Tracking');

echo '<h2>Create Google Apps Spreadsheet for Collaborative Assignment Marking and Resubmission Tracking</h2><br /><br />';


if (!empty($_POST['markcreatess']) && !empty($_POST['course_id'])) {
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


  // Upload file
  try {
    $client = Zend_Gdata_ClientLogin::getHttpClient('admin@files.peoples-uni.org', 'Schull11', Zend_Gdata_Docs::AUTH_SERVICE_NAME);
    $docs = new Zend_Gdata_Docs($client);
    // Keep as Version 1 (not $docs->setMajorProtocolVersion(3);)
  }
  catch (Zend_Gdata_App_AuthException $e) {
    echo '<br /><br /><strong>Error: Unable to authenticate with files.peoples-uni.org.</strong><br /><br />';

    echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }

  $newDocumentEntry = $docs->uploadFile('Marking.xls', $course->fullname, null, Zend_Gdata_Docs::DOCUMENTS_LIST_FEED_URI);

  foreach ($newDocumentEntry->link as $linkentry) {
    if ($linkentry->getRel() === 'alternate') {
      $link = $linkentry->getHref();
    }
  }

  if (empty($link)) {
    echo '<br /><br /><strong>Error: Link to uploaded file not found!.</strong><br /><br />';

    echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }

  $title = $newDocumentEntry->title;

  // Example $link: http://spreadsheets.google.com/a/files.peoples-uni.org/ccc?key=0Ag3Bj9qWqJ-VdHpmVnNWWVBTTGF3OEE4Z1BzWlN5dUE&hl=en
  $key = substr($link, strpos($link, '?key=') + 5);

  $pos = strpos($key, '&hl=en');
  if ($pos !== false) $key = substr($key, 0, $pos);


  // Set cells in Spreadsheet (sheet will default to 'default')
  try {
    $client = Zend_Gdata_ClientLogin::getHttpClient('admin@files.peoples-uni.org', 'Schull11', Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME);
    $spreadsheets = new Zend_Gdata_Spreadsheets($client);
  } catch (Zend_Gdata_App_AuthException $ae) {
    echo '<br /><br /><strong>Error: Unable to authenticate with files.peoples-uni.org (Spreadsheets).</strong><br /><br />';

    echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }

  $students = get_records_sql("SELECT DISTINCT e.userid, u.lastname, u.firstname FROM mdl_enrolment e, mdl_user u WHERE e.courseid=$id AND e.enrolled!=0 AND e.userid=u.id ORDER BY u.lastname, u.firstname ASC");
  $number = count($students);

  $query = new Zend_Gdata_Spreadsheets_CellQuery();
  $query->setSpreadsheetKey($key);
  $feed = $spreadsheets->getCellFeed($query);

  if ($feed instanceOf Zend_Gdata_Spreadsheets_CellFeed) {
    $rowCount = $feed->getRowCount();
    $columnCount = $feed->getColumnCount();
  }
  else {
    echo '<br /><br /><strong>Error: Zend_Gdata_Spreadsheets_CellFeed not returned.</strong><br /><br />';

    echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }

  if (($number + 1) > $rowCount) {
    resizeWorksheet($spreadsheets, $key, $number + 1, $columnCount);
  }

  $row = 2;
  foreach ($students as $student) {
    $value = $student->lastname . ', ' . $student->firstname . ' (' . $student->userid . ')';

    $entry = $spreadsheets->updateCell($row, 1, $value, $key);
      if (!($entry instanceof Zend_Gdata_Spreadsheets_CellEntry)) {
        echo "<br /><br /><strong>Error: Zend_Gdata_Spreadsheets_CellEntry not returned when setting row: $row, col: $col to .</strong><br /><br />";

        echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
        print_footer();
        die();
      }
    $row++;
  }


  // Publish
  try {
    $client = Zend_Gdata_ClientLogin::getHttpClient('admin@files.peoples-uni.org', 'Schull11', Zend_Gdata_Docs::AUTH_SERVICE_NAME);
    $docs = new Zend_Gdata_Docs($client);
    $docs->setMajorProtocolVersion(3); // Need Version 3 of API for this part
  }
  catch (Zend_Gdata_App_AuthException $e) {
    echo '<br /><br /><strong>Error: Unable to authenticate with files.peoples-uni.org (to set ACL).</strong><br /><br />';

    echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }

  $entryAcl =
    "<entry xmlns=\"http://www.w3.org/2005/Atom\" xmlns:gAcl='http://schemas.google.com/acl/2007'>" .
      "<gAcl:withKey key='[ACL KEY]'><gAcl:role value='writer' /></gAcl:withKey>" .
      "<gAcl:scope type='default' />" .
    "</entry>";

  $requestData = $docs->prepareRequest(
                   'POST',
                   'http://docs.google.com/feeds/default/private/full/spreadsheet%3A' . $key . '/acl',
                    array(),
                    $entryAcl,
                    'application/atom+xml');

  $response = $docs->performHttpRequest(
                $requestData['method'],
                $requestData['url'],
                $requestData['headers'],
                $requestData['data'],
                $requestData['contentType']);

  $atom = $response->getBody();

  $doc = new DOMDocument();
  $doc->loadXML($atom);

  $nodelist = $doc->getElementsByTagName('withKey');

  if (empty($nodelist->length)) {
    echo '<br /><br /><strong>Error: Could not find any "withkey" tags in XML response.</strong><br /><br />';

    echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }

  $authkey = $nodelist->item(0)->attributes->getNamedItem('key')->nodeValue;

  // Example of what is needed: http://spreadsheets.google.com/ccc?key=0Ag3Bj9qWqJ-VdHpmVnNWWVBTTGF3OEE4Z1BzWlN5dUE&hl=en&authkey=CNboh4wB
  $newlink = 'http://spreadsheets.google.com/ccc?key=' . $key . '&hl=en&authkey=' . $authkey;

  $google_ss_existing = get_record('peoples_google_ss', 'course_id', $id);
  if (empty($google_ss_existing)) {
    $google_ss = new object();
    $google_ss->course_id = $id;
    $google_ss->full_link = addslashes($newlink);

    insert_record('peoples_google_ss', $google_ss);
  }
  else {
    $google_ss = new object();
    $google_ss->id = $google_ss_existing->id;
    $google_ss->full_link = addslashes($newlink);

    update_record('peoples_google_ss', $google_ss);
  }


  echo "<br /><br /><br />Spreadsheet Created ($number students): <strong>" . htmlspecialchars($title, ENT_COMPAT, 'UTF-8') . '</strong>';
  echo '<br /><br />The URL, which will be visible to Admins and Teacher/Teachers in the course, is:<br />';
  echo '<strong><a href="' . htmlspecialchars($newlink, ENT_COMPAT, 'UTF-8') . '">' . htmlspecialchars($newlink, ENT_COMPAT, 'UTF-8') . '</a></strong><br /><br />';
}
else {
  $id = required_param('id', PARAM_INT);

  $course = get_record('course', 'id', $id);
  if (empty($course)) die();

  echo '<script type="text/JavaScript">function areyousurecreatess() { var sure = false; sure = confirm("Are you sure you want to Create the Google Apps Spreadsheet for Collaborative Assignment Marking and Resubmission Tracking for: ' . htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8')
    . '. If one already exists it will no longer be viewable without action from Alan Barrett and you will not be able to see existing work in that spreadsheet."); return sure;}</script>';
  ?>

  <form method="post" action="<?php echo $CFG->wwwroot . '/course/create_marking_ss.php'; ?>" onSubmit="return areyousurecreatess()">

  <input type="hidden" name="course_id" value="<?php echo $course->id; ?>" />
  <input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
  <input type="hidden" name="markcreatess" value="1" />

  <input type="submit" name="createss" value="Create Spreadsheet for: '<?php echo htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8'); ?>'" style="width:40em" />
  </form>
  <br />
  <?php
}

echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';

print_footer();


function resizeWorksheet($spreadsheets, $key, $newRowCount, $newColumnCount) {
  $query = new Zend_Gdata_Spreadsheets_DocumentQuery();
  $query->setSpreadsheetKey($key);
  $currentWorksheet = $spreadsheets->getWorksheetEntry($query);
  $currentWorksheet = $currentWorksheet->setRowCount(new Zend_Gdata_Spreadsheets_Extension_RowCount($newRowCount));
  $currentWorksheet = $currentWorksheet->setColumnCount(new Zend_Gdata_Spreadsheets_Extension_ColCount($newColumnCount));
  $currentWorksheet->save();
}
?>
