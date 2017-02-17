<?php  // $Id: tutor_registrations.php,v 1.1 2014/01/08 12:17:00 alanbarrett Exp $
/**
*
* List Tutor Applications
*
*/

$volunteertypename['10'] = 'Tutor';
$volunteertypename['20'] = 'Local supervisor';
$volunteertypename['30'] = 'Academic supervisor';
$volunteertypename['40'] = 'Marker';
$volunteertypename['50'] = 'SSO';
$volunteertypename['60'] = 'IT';
$volunteertypename['70'] = 'Admin';

$howfoundpeoplesname['10'] = 'Informed by another Peoples-uni student or tutor';
$howfoundpeoplesname['20'] = 'Informed by someone else';
$howfoundpeoplesname['30'] = 'Facebook';
$howfoundpeoplesname['40'] = 'Internet advertisement';
$howfoundpeoplesname['50'] = 'Link from another website or discussion forum';
$howfoundpeoplesname['60'] = 'I used a search engine to look for courses, volunteering opportunities or other';
$howfoundpeoplesname['70'] = 'Referral from Partnership Institution';
$howfoundpeoplesname['80'] = 'Read or heard about from news article, journal or advertisement';


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$countryname = get_string_manager()->get_list_of_countries(false);
$listchosencountry = array_merge(array('Any' => 'Any'), $countryname);
$countryname[''] = ''; // There seem to be some '' countries

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/tutor_registrations.php'); // Defined here to avoid notices on errors etc

if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/tutor_registrations.php?'
    . '&chosenmodule=' . urlencode($_POST['chosenmodule'])
    . '&chosensearch=' . urlencode($_POST['chosensearch'])
    . '&chosenstartyear=' . $_POST['chosenstartyear']
    . '&chosenstartmonth=' . $_POST['chosenstartmonth']
    . '&chosenstartday=' . $_POST['chosenstartday']
    . '&chosenendyear=' . $_POST['chosenendyear']
    . '&chosenendmonth=' . $_POST['chosenendmonth']
    . '&chosenendday=' . $_POST['chosenendday']
    . '&activerecently=' . $_POST['activerecently']
    . '&chosencountry=' . $_POST['chosencountry']
    . (empty($_POST['approved']) ? '&approved=0' : '&approved=1')
    . (empty($_POST['sortbyname']) ? '&sortbyname=0' : '&sortbyname=1')
    . (empty($_POST['sortbydate']) ? '&sortbydate=0' : '&sortbydate=1')
    . (empty($_POST['displayforexcel']) ? '&displayforexcel=0' : '&displayforexcel=1')
    );
}


$PAGE->set_pagelayout('embedded');   // Needs as much space as possible

require_login();
// (Might possibly be Guest)

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $USER->id));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$fullname = fullname($userrecord);
if (empty($fullname) || trim($fullname) == 'Guest User') {
  $SESSION->wantsurl = "$CFG->wwwroot/course/tutor_registrations.php";
  redirect($CFG->wwwroot . '/login/index.php');
}

// Access to tutor_registrations.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', context_system::instance());
$is_admin = has_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Tutor Registrations');
$PAGE->set_heading('Tutor Registrations');
echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


if (empty($_REQUEST['displayforexcel'])) echo "<h1>Tutor Registrations</h1>";


if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = $_REQUEST['chosenmodule'];
else $chosenmodule = '';
if (!empty($_REQUEST['chosensearch'])) $chosensearch = $_REQUEST['chosensearch'];
else $chosensearch = '';
if (!empty($_REQUEST['chosenstartyear']) && !empty($_REQUEST['chosenstartmonth']) && !empty($_REQUEST['chosenstartday'])) {
  $chosenstartyear = (int)$_REQUEST['chosenstartyear'];
  $chosenstartmonth = (int)$_REQUEST['chosenstartmonth'];
  $chosenstartday = (int)$_REQUEST['chosenstartday'];
  $starttime = gmmktime(0, 0, 0, $chosenstartmonth, $chosenstartday, $chosenstartyear);
}
else {
  $starttime = 0;
}
if (!empty($_REQUEST['chosenendyear']) && !empty($_REQUEST['chosenendmonth']) && !empty($_REQUEST['chosenendday'])) {
  $chosenendyear = (int)$_REQUEST['chosenendyear'];
  $chosenendmonth = (int)$_REQUEST['chosenendmonth'];
  $chosenendday = (int)$_REQUEST['chosenendday'];
  $endtime = gmmktime(24, 0, 0, $chosenendmonth, $chosenendday, $chosenendyear);
}
else {
  $endtime = 1.0E+20;
}
if (!empty($_REQUEST['activerecently'])) $activerecently = $_REQUEST['activerecently'];
if (!empty($_REQUEST['chosencountry'])) $chosencountry = $_REQUEST['chosencountry'];
if (!empty($_REQUEST['approved'])) $approved = true;
else $approved = false;
if (!empty($_REQUEST['sortbyname'])) $sortbyname = true;
else $sortbyname = false;
if (!empty($_REQUEST['sortbydate'])) $sortbydate = true;
else $sortbydate = false;
if (!empty($_REQUEST['displayforexcel'])) $displayforexcel = true;
else $displayforexcel = false;

$listactiverecently[] = 'All';
if (!isset($activerecently)) $activerecently = 'All';
$listactiverecently[] = 'Active This or Previous Semester';
$listactiverecently[] = 'Active This Semester';

if (!isset($chosencountry)) $chosencountry = 'Any';

for ($i = 2008; $i <= (int)gmdate('Y'); $i++) {
  if (!isset($chosenstartyear)) $chosenstartyear = $i;
  $liststartyear[] = $i;
}

for ($i = 1; $i <= 12; $i++) {
  if (!isset($chosenstartmonth)) $chosenstartmonth = $i;
  $liststartmonth[] = $i;
}

for ($i = 1; $i <= 31; $i++) {
  if (!isset($chosenstartday)) $chosenstartday = $i;
  $liststartday[] = $i;
}

for ($i = (int)gmdate('Y'); $i >= 2008; $i--) {
  if (!isset($chosenendyear)) $chosenendyear = $i;
  $listendyear[] = $i;
}

for ($i = 12; $i >= 1; $i--) {
  if (!isset($chosenendmonth)) $chosenendmonth = $i;
  $listendmonth[] = $i;
}

for ($i = 31; $i >= 1; $i--) {
  if (!isset($chosenendday)) $chosenendday = $i;
  $listendday[] = $i;
}

if (!$displayforexcel) {
?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/tutor_registrations.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Module Name Contains</td>
    <td>Name or e-mail Contains</td>
    <td>Start Year</td>
    <td>Start Month</td>
    <td>Start Day</td>
    <td>End Year</td>
    <td>End Month</td>
    <td>End Day</td>
    <td>Semesters Active</td>
    <td>Country</td>
    <td>Show Approved only?</td>
    <td>Sort by Name</td>
    <td>Sort by Date</td>
    <td>Display for Copying and Pasting to Excel</td>
  </tr>
  <tr>
    <td><input type="text" size="15" name="chosenmodule" value="<?php echo htmlspecialchars($chosenmodule, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <td><input type="text" size="15" name="chosensearch" value="<?php echo htmlspecialchars($chosensearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <?php
    displayoptions('chosenstartyear', $liststartyear, $chosenstartyear);
    displayoptions('chosenstartmonth', $liststartmonth, $chosenstartmonth);
    displayoptions('chosenstartday', $liststartday, $chosenstartday);
    displayoptions('chosenendyear', $listendyear, $chosenendyear);
    displayoptions('chosenendmonth', $listendmonth, $chosenendmonth);
    displayoptions('chosenendday', $listendday, $chosenendday);
    displayoptions('activerecently', $listactiverecently, $activerecently);
    displayoptions_with_key('chosencountry', $listchosencountry, $chosencountry);
    ?>
    <td><input type="checkbox" name="approved" <?php if ($approved) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="sortbyname" <?php if ($sortbyname) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="sortbydate" <?php if ($sortbydate) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="displayforexcel" <?php if ($displayforexcel) echo ' CHECKED'; ?>></td>
  </tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/tutor_registrations.php">Reset Filters</a>
</form>
<br />
<?php
}


function displayoptions($name, $options, $selectedvalue) {
  echo '<td><select name="' . $name . '">';
  foreach ($options as $option) {
    if ($option === $selectedvalue) $selected = 'selected="selected"';
    else $selected = '';

    $opt = htmlspecialchars($option, ENT_COMPAT, 'UTF-8');
    echo '<option value="' . $opt . '" ' . $selected . '>' . $opt . '</option>';
  }
  echo '</select></td>';
}


function displayoptions_with_key($name, $options, $selectedvalue) {
  echo '<td><select name="' . $name . '">';
  foreach ($options as $key => $option) {
    if ($key === $selectedvalue) $selected = 'selected="selected"';
    else $selected = '';

    $opt = htmlspecialchars($option, ENT_COMPAT, 'UTF-8');
    echo '<option value="' . $key . '" ' . $selected . '>' . $opt . '</option>';
  }
  echo '</select></td>';
}


$peoples_tutor_registrations = $DB->get_records_sql("
  SELECT
    LOWER(CONCAT(IFNULL(u.lastname, a.lastname), ',', IFNULL(u.firstname, a.firstname), '#####', a.id)) AS indexcolumn,
    a.*,
    u.lastname AS ulastname,
    u.firstname AS ufirstname,
    u.email AS uemail,
    u.city AS ucity,
    u.country AS ucountry,
    u.timecreated
  FROM mdl_peoples_tutor_registration a
  LEFT JOIN mdl_user u ON a.userid=u.id
  WHERE hidden=0
  ORDER BY a.state ASC, a.datesubmitted DESC");
if (empty($peoples_tutor_registrations)) {
  $peoples_tutor_registrations = array();
}

$userids = array();
foreach ($peoples_tutor_registrations as $peoples_tutor_registration) {
  if (!empty($peoples_tutor_registration->userid)) $userids[] = $peoples_tutor_registration->userid;

  if (!empty($peoples_tutor_registration->ulastname)) $peoples_tutor_registration->lastname = $peoples_tutor_registration->ulastname;
  if (!empty($peoples_tutor_registration->ufirstname)) $peoples_tutor_registration->firstname = $peoples_tutor_registration->ufirstname;
  if (!empty($peoples_tutor_registration->uemail)) $peoples_tutor_registration->email = $peoples_tutor_registration->uemail;
  if (!empty($peoples_tutor_registration->ucity)) $peoples_tutor_registration->city = $peoples_tutor_registration->ucity;
  if (!empty($peoples_tutor_registration->ucountry)) $peoples_tutor_registration->country = $peoples_tutor_registration->ucountry;
}

$semesters_descending = $DB->get_records('semesters', NULL, 'id DESC');
$semesters_ascending = $DB->get_records('semesters', NULL, 'id ASC');
foreach ($semesters_ascending as $semester) {
  $latest_semester = $semester->semester;
  $latest_semester_id = $semester->id;
}
$nextto_latest_semester = $semesters_ascending[$latest_semester_id - 1]->semester;

$course_to_semester = $DB->get_records_sql('SELECT courseid, MAX(semester) AS semester_value FROM mdl_enrolment GROUP BY courseid'); // In error, the database seems to run a few courses in multiple semesters

$record = $DB->get_record_sql('SELECT GROUP_CONCAT(DISTINCT courseid) AS enrol_course_list FROM mdl_enrolment');
$course_ids = $record->enrol_course_list;

$record = $DB->get_record_sql('SELECT GROUP_CONCAT(course_id) AS current_course_list FROM mdl_activemodules');
if (!empty($record->current_course_list)) {
  $course_ids .= ',' . $record->current_course_list;

  $current_course_list = explode(',', $record->current_course_list);
  foreach($current_course_list as $course_item) {
    $course_to_semester[$course_item] = new stdClass();
    $course_to_semester[$course_item]->semester_value = $latest_semester;
  }
}

$assignments = $DB->get_records_sql("
  SELECT ra.id, ra.userid, r.shortname, c.id as courseid, c.fullname as coursename
    FROM
      mdl_role_assignments ra,
      mdl_role r,
      mdl_context con,
      mdl_course c
    WHERE
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors') AND
      con.contextlevel=50 AND
      con.instanceid=c.id AND
      c.id IN ($course_ids)
    ORDER BY ra.userid");

$extratutors = '';
$tutors_course_list = array();
$tutors_course_list_for_filter = array();
$users_moduleleader_modules_for_filter = array();
foreach ($assignments as $assignment) {
  $userid = $assignment->userid;
  if (!in_array($userid, $userids)) {
    $userids[] = $userid;
    $extratutors .= "$userid,";
  }

  $semester = $course_to_semester[$assignment->courseid]->semester_value;
  $coursename = $assignment->coursename;
  if ($assignment->shortname === 'tutor') {
    $asterisk = '*';
    if ($userid == $USER->id) $users_moduleleader_modules_for_filter[] = $coursename;
  }
  else $asterisk = '';

  if (empty($tutors_course_list_for_filter[$userid])) $tutors_course_list_for_filter[$userid] = '';
  $tutors_course_list_for_filter[$userid] .= "$coursename$asterisk,";

  if (!empty($tutors_course_list[$userid])) {
    if (!empty($tutors_course_list[$userid][$semester])) {
      $tutors_course_list[$userid][$semester][] = "$coursename$asterisk";
    }
    else {
      $tutors_course_list[$userid][$semester] = array("$coursename$asterisk");
    }
  }
  else {
    $tutors_course_list[$userid] = array($semester => array("$coursename$asterisk"));
  }
}

$assignments = $DB->get_records_sql("
  SELECT ra.id, ra.userid, r.shortname
    FROM
      mdl_role_assignments ra,
      mdl_role r
    WHERE
      ra.roleid=r.id AND
      r.shortname IN ('sso')
    ORDER BY ra.userid");

foreach ($assignments as $assignment) {
  $userid = $assignment->userid;
  if (!in_array($userid, $userids)) {
    $userids[] = $userid;
    $extratutors .= "$userid,";
  }
}

if (!empty($extratutors)) {
  $extratutors = substr($extratutors, 0, -1);
  $peoples_extra_tutor_registrations = $DB->get_records_sql("
    SELECT
      LOWER(CONCAT(u.lastname, ',', u.firstname, '#####Z', u.id)) AS indexcolumn,
      0 AS id,
      u.id AS userid,
      1 AS state,
      u.lastname,
      u.firstname,
      u.email,
      u.city,
      u.country,
      u.timecreated,
      '' AS volunteertype,
      '' AS modulesofinterest,
      '' AS notes,
      '' AS reasons,
      '' AS education,
      '' AS tutoringexperience,
      '' AS currentjob,
      '' AS currentrole,
      '' AS otherinformation,
      '' AS howfoundpeoples,
      '' AS howfoundorganisationname,
      0 AS hidden
    FROM mdl_user u
    WHERE u.id IN ($extratutors)
    ORDER BY u.timecreated DESC");
  if (!empty($peoples_extra_tutor_registrations)) $peoples_tutor_registrations = $peoples_tutor_registrations + $peoples_extra_tutor_registrations;
}

if ($sortbyname) ksort($peoples_tutor_registrations);

if ($sortbydate) {
  $peoples_tutor_registrations_new = array();

  foreach ($peoples_tutor_registrations as $index => $peoples_tutor_registration) {
    if (empty($peoples_tutor_registration->timecreated)) {
      $date_index = $peoples_tutor_registration->datesubmitted;
    }
    else {
      $date_index = $peoples_tutor_registration->timecreated;
    }

    $peoples_tutor_registrations_new["$date_index $index"] = $peoples_tutor_registration;
  }
  $peoples_tutor_registrations = $peoples_tutor_registrations_new;

  krsort($peoples_tutor_registrations);
}

$emailcounts = array();
$emaildups = 0;
foreach ($peoples_tutor_registrations as $index => $peoples_tutor_registration) {
  $state = $peoples_tutor_registration->state;

  if (empty($peoples_tutor_registration->timecreated)) $peoples_tutor_registration->timecreated = $peoples_tutor_registration->datesubmitted;

  if (
    $peoples_tutor_registration->timecreated < $starttime ||
    $peoples_tutor_registration->timecreated > $endtime ||
    ($approved && ($state == 0))
    ) {

    unset($peoples_tutor_registrations[$index]);
    continue;
  }

  if (!empty($chosensearch) &&
    stripos($peoples_tutor_registration->lastname, $chosensearch) === false &&
    stripos($peoples_tutor_registration->firstname, $chosensearch) === false &&
    stripos($peoples_tutor_registration->email, $chosensearch) === false) {

    unset($peoples_tutor_registrations[$index]);
    continue;
  }

  if (!empty($chosenmodule) &&
    (
      empty($tutors_course_list_for_filter[$peoples_tutor_registration->userid]) ||
      (stripos($tutors_course_list_for_filter[$peoples_tutor_registration->userid], $chosenmodule) === false))) {

    unset($peoples_tutor_registrations[$index]);
    continue;
  }

  if (!$is_admin) {
    if (empty($users_moduleleader_modules_for_filter)) {
      unset($peoples_tutor_registrations[$index]);
      continue;
    }
    else {
      $can_see_this_user = FALSE;
      foreach ($users_moduleleader_modules_for_filter as $module_for_filter) {
        if (!empty($tutors_course_list_for_filter[$peoples_tutor_registration->userid]) &&
          (stripos($tutors_course_list_for_filter[$peoples_tutor_registration->userid], $module_for_filter) !== false)) $can_see_this_user = TRUE;
      }

      if (!$can_see_this_user) {
        unset($peoples_tutor_registrations[$index]);
        continue;
      }
    }
  }

  if (!empty($activerecently) && $activerecently !== 'Any') {
    if ($activerecently === 'Active This or Previous Semester' && empty($tutors_course_list[$peoples_tutor_registration->userid][$latest_semester]) && empty($tutors_course_list[$peoples_tutor_registration->userid][$nextto_latest_semester])) {
      unset($peoples_tutor_registrations[$index]);
      continue;
    }
    if ($activerecently === 'Active This Semester' && empty($tutors_course_list[$peoples_tutor_registration->userid][$latest_semester])) {
      unset($peoples_tutor_registrations[$index]);
      continue;
    }
  }

  if (!empty($chosencountry) && $chosencountry !== 'Any') {
    if ($peoples_tutor_registration->country !== $chosencountry) {
      unset($peoples_tutor_registrations[$index]);
      continue;
    }
  }

  if ($peoples_tutor_registration->hidden) {
    unset($peoples_tutor_registrations[$index]);
    continue;
  }

  if (empty($emailcounts[$peoples_tutor_registration->email])) $emailcounts[$peoples_tutor_registration->email] = 1;
  else {
    $emailcounts[$peoples_tutor_registration->email]++;
    $emaildups++;
  }
}


$files_for_users = $DB->get_records_sql("
  SELECT
    u.id,
    GROUP_CONCAT(f.filename ORDER BY f.filename SEPARATOR ', ') AS filelist,
    GROUP_CONCAT(f.filename ORDER BY f.filename, f.filepath SEPARATOR '##albrje##') AS safefilelist,
    GROUP_CONCAT(f.filepath ORDER BY f.filename, f.filepath SEPARATOR '##albrje##') AS safefilepath
  FROM
    mdl_files f,
    mdl_context con,
    mdl_user u
  WHERE
    f.component='peoples_record_tutor' AND
    f.filearea='tutor' AND
    f.filesize!=0 AND
    f.contextid=con.id AND
    con.contextlevel=30 AND
    con.instanceid=u.id
  GROUP BY u.id");
if (empty($files_for_users)) {
  $files_for_users = array();
}

$tutors_by_id = $DB->get_records_sql("
SELECT
  ra.userid,
  GROUP_CONCAT(
    CASE
      WHEN r.shortname='tutor'  THEN CONCAT('Module Leader in ', c.fullname)
      WHEN r.shortname='tutors' THEN CONCAT('Tutor in ', c.fullname)
      WHEN r.shortname='sso'    THEN 'SSO'
    END
    ORDER BY c.fullname, r.shortname
    SEPARATOR ', '
  ) AS new_roles
FROM mdl_role_assignments ra
INNER JOIN mdl_role    r   ON ra.roleid=r.id
INNER JOIN mdl_context con ON ra.contextid=con.id
LEFT  JOIN mdl_course  c   ON con.instanceid=c.id
WHERE
  (r.shortname IN ('tutor', 'tutors') AND con.contextlevel=50) OR
  r.shortname IN ('sso')
GROUP by ra.userid;
");

$was_student = $DB->get_records_sql("SELECT DISTINCT userid FROM mdl_enrolment WHERE enrolled!=0");


$table = new html_table();
$first_column_title = 'Non-registered (ordered by submission date) then Registered (with date)';
if ($sortbydate) $first_column_title = 'Date (Non-registered submission date or Registered date)';
$table->head = array(
  $first_column_title,
  'Family name',
  'Given name',
  'Email address',
  'Volunteer type',
  'Modules of interest',
  'Notes',
  'Reasons for volunteering',
  'Qualifications',
  'Educational/tutoring experience',
  'Current employer',
  'Current role',
  'Other information',
  'How heard about',
  'Organisation',
  'City',
  'Country',
  );
foreach ($semesters_descending as $semester) {
  $table->head[] = str_replace('Starting ', '', $semester->semester);
}
$table->head[] = 'Files';
$table->head[] = 'List of Modules Tutored (or SSO)';
$table->head[] = 'Previously a Student?';

//$table->align = array ("left", "left", "left", "left", "left", "center", "center", "center");
//$table->width = "95%";

$n = 0;
$napproved = 0;
$listofemails = array();
$country = array();
foreach ($peoples_tutor_registrations as $index => $peoples_tutor_registration) {
  $state = $peoples_tutor_registration->state;

  $rowdata = array();
  if (!$displayforexcel) {
    $z = gmdate('d/m/Y H:i', $peoples_tutor_registration->timecreated);
    if ($state) $z .= '<br /><span style="color:green">Registered</span>';

    $md5 = '';
    $id = $peoples_tutor_registration->id;
    $userid = $peoples_tutor_registration->userid;
    $idoruserid = $id;
    if (empty($idoruserid)) $idoruserid = $userid;
    if (!$is_admin) $md5 = '&md5=' . md5("{$USER->id}jaybf6laHU{$idoruserid}"); // This user ($USER->id) can see/edit this record ($id or $userid) (not very secure, but good enough)
    if (empty($peoples_tutor_registration->id)) {
      $z .= '<a href="' . $CFG->wwwroot . '/course/tutor_registration_edit.php?id=' . $id . "&userid=$userid" . $md5 . '"><br />Create form</a>';
    }
    else {
      $z .= '<a href="' . $CFG->wwwroot . '/course/tutor_registration_edit.php?id=' . $id . "&userid=$userid" . $md5 . '"><br />Edit form</a>';
    }
    $rowdata[] = $z;

    $rowdata[] = htmlspecialchars($peoples_tutor_registration->lastname, ENT_COMPAT, 'UTF-8');

    $rowdata[] = htmlspecialchars($peoples_tutor_registration->firstname, ENT_COMPAT, 'UTF-8');

    if ($emailcounts[$peoples_tutor_registration->email] === 1) {
      $z = htmlspecialchars($peoples_tutor_registration->email, ENT_COMPAT, 'UTF-8');
    }
    else {
      $z = '<span style="color:navy">**</span>' . htmlspecialchars($peoples_tutor_registration->email, ENT_COMPAT, 'UTF-8');
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $peoples_tutor_registration->volunteertype);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $volunteertypename[$v] . '<br />';
    }
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($peoples_tutor_registration->modulesofinterest, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($peoples_tutor_registration->notes, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($peoples_tutor_registration->reasons, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($peoples_tutor_registration->education, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($peoples_tutor_registration->tutoringexperience, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($peoples_tutor_registration->currentjob, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($peoples_tutor_registration->currentrole, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($peoples_tutor_registration->otherinformation, ENT_COMPAT, 'UTF-8')));

    if (empty($howfoundpeoplesname[$peoples_tutor_registration->howfoundpeoples])) $z = '';
    else $z = $howfoundpeoplesname[$peoples_tutor_registration->howfoundpeoples];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($peoples_tutor_registration->howfoundorganisationname, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = htmlspecialchars($peoples_tutor_registration->city, ENT_COMPAT, 'UTF-8');

    if (empty($countryname[$peoples_tutor_registration->country])) $z = '';
    else $z = $countryname[$peoples_tutor_registration->country];
    $rowdata[] = $z;

    foreach ($semesters_descending as $semester) {
      $z = '';
      if (!empty($tutors_course_list[$peoples_tutor_registration->userid][$semester->semester])) {
        $courses = $tutors_course_list[$peoples_tutor_registration->userid][$semester->semester];
        natcasesort($courses);
        $z = implode(', ', $courses);
      }
      $rowdata[] = $z;
    }

    $n++;

    if ($state) {
      $napproved++;

      if (empty($country[$countryname[$peoples_tutor_registration->country]])) {
        $country[$countryname[$peoples_tutor_registration->country]] = 1;
      }
      else {
        $country[$countryname[$peoples_tutor_registration->country]]++;
      }

      $listofemails[]  = htmlspecialchars($peoples_tutor_registration->email, ENT_COMPAT, 'UTF-8');
    }

    if (!empty($files_for_users[$peoples_tutor_registration->userid])) {
      if (!$is_admin) {
        $rowdata[] = $files_for_users[$peoples_tutor_registration->userid]->filelist;
      }
      else {
        $files     = explode('##albrje##', $files_for_users[$peoples_tutor_registration->userid]->safefilelist);
        $filepaths = explode('##albrje##', $files_for_users[$peoples_tutor_registration->userid]->safefilepath);
        $rowstring = '';
        $first = '';
        $i = 0;
        foreach ($files as $file) {
          $context = context_user::instance($peoples_tutor_registration->userid);
          $url = file_encode_url("$CFG->wwwroot/course/peoples_tutor_cv.php", '/' . $context->id . '/peoples_record_tutor/tutor' . $filepaths[$i] . $file, true);
          $i++;
          $rowstring .= $first . '<a href="' . $url . '">' . htmlspecialchars($file, ENT_COMPAT, 'UTF-8') . '</a>';
          $first = ', ';
        }
        $rowdata[] = $rowstring;
      }
    }
    else {
      $rowdata[] = '';
    }
  }
  else {
    $rowdata[] = gmdate('d/m/Y H:i', $peoples_tutor_registration->timecreated);

    $rowdata[] = htmlspecialchars($peoples_tutor_registration->lastname, ENT_COMPAT, 'UTF-8');

    $rowdata[] = htmlspecialchars($peoples_tutor_registration->firstname, ENT_COMPAT, 'UTF-8');

    $rowdata[] = htmlspecialchars($peoples_tutor_registration->email, ENT_COMPAT, 'UTF-8');

    $z = '';
    $arrayvalues = explode(',', $peoples_tutor_registration->volunteertype);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $volunteertypename[$v] . ' ';
    }
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', htmlspecialchars($peoples_tutor_registration->modulesofinterest, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', htmlspecialchars($peoples_tutor_registration->notes, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', htmlspecialchars($peoples_tutor_registration->reasons, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', htmlspecialchars($peoples_tutor_registration->education, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', htmlspecialchars($peoples_tutor_registration->tutoringexperience, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', htmlspecialchars($peoples_tutor_registration->currentjob, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', htmlspecialchars($peoples_tutor_registration->currentrole, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', htmlspecialchars($peoples_tutor_registration->otherinformation, ENT_COMPAT, 'UTF-8')));

    if (empty($howfoundpeoplesname[$peoples_tutor_registration->howfoundpeoples])) $z = '';
    else $z = $howfoundpeoplesname[$peoples_tutor_registration->howfoundpeoples];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', htmlspecialchars($peoples_tutor_registration->howfoundorganisationname, ENT_COMPAT, 'UTF-8')));

    $rowdata[] = htmlspecialchars($peoples_tutor_registration->city, ENT_COMPAT, 'UTF-8');

    if (empty($countryname[$peoples_tutor_registration->country])) $z = '';
    else $z = $countryname[$peoples_tutor_registration->country];
    $rowdata[] = $z;

    foreach ($semesters_descending as $semester) {
      $z = '';
      if (!empty($tutors_course_list[$peoples_tutor_registration->userid][$semester->semester])) {
        $courses = $tutors_course_list[$peoples_tutor_registration->userid][$semester->semester];
        natcasesort($courses);
        $z = implode(', ', $courses);
      }
      $rowdata[] = $z;
    }

    if (!empty($files_for_users[$peoples_tutor_registration->userid])) {
      $rowdata[] = $files_for_users[$peoples_tutor_registration->userid]->filelist;
    }
    else {
      $rowdata[] = '';
    }
  }

  if (empty($tutors_by_id[$peoples_tutor_registration->userid])) {
    $rowdata[] = '';
  }
  else {
    $rowdata[] = htmlspecialchars($tutors_by_id[$peoples_tutor_registration->userid]->new_roles, ENT_COMPAT, 'UTF-8');
  }

  if (empty($was_student[$peoples_tutor_registration->userid])) {
    $rowdata[] = '';
  }
  else {
    $rowdata[] = 'Yes';
  }

  $table->data[] = $rowdata;
}
echo html_writer::table($table);

if ($displayforexcel) {
  echo $OUTPUT->footer();
  die();
}

echo '<br />Total: ' . $n;
echo '<br />Total Registered: ' . $napproved;
echo '<br /><br />(Duplicated e-mails: ' . $emaildups . ',  see <span style="color:navy">**</span>)';
echo '<br/><br/>';

natcasesort($listofemails);
echo 'e-mails of Approved Tutors...<br />' . implode(', ', array_unique($listofemails)) . '<br /><br />';

echo 'Statistics for Approved Tutors...<br />';
displaystat($country, 'Country');


echo '<br /><br /><br /><br />';

//echo html_writer::end_tag('div');

echo $OUTPUT->footer();


function displaystat($stat, $title) {
  echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
  echo "<tr>";
  echo "<td>$title</td>";
  echo "<td>Number</td>";
  echo "</tr>";

  ksort($stat);

  foreach ($stat as $key => $number) {
    echo "<tr>";
    echo "<td>" . $key . "</td>";
    echo "<td>" . $number . "</td>";
      echo "</tr>";
  }
  echo '</table>';
  echo '<br/>';
}
