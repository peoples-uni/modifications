<?php  // $Id: list_of_mph_graduates.php,v 1.1 2013/07/22 16:16:00 alanbarrett Exp $
/**
*
* List of MPH Graduates
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$countryname = get_string_manager()->get_list_of_countries(false);

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/list_of_mph_graduates.php');

$PAGE->set_pagelayout('embedded');

require_login();

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
$islurker = has_capability('moodle/grade:viewall', context_system::instance());
if (!$isteacher && !$islurker) {
	echo '<h1>You must be a tutor to do this!</h1>';
	notice('Please Login Below', "$CFG->wwwroot/");
}

echo '<h1>MPH Graduates</h1>';
$PAGE->set_title('MPH Graduates');
$PAGE->set_heading('MPH Graduates');

echo $OUTPUT->header();


$prof = $DB->get_record('user_info_field', array('shortname' => 'dateofbirth'));
if (!empty($prof->id)) $dobid = $prof->id;
$prof = $DB->get_record('user_info_field', array('shortname' => 'gender'));
if (!empty($prof->id)) $genderid = $prof->id;


$enrols = $DB->get_records_sql("
SELECT m.id, m.semester_graduated, m.mphstatus, m.graduated, u.id as userid, u.lastname, u.firstname, u.email, u.country
FROM mdl_peoplesmph2 m, mdl_user u
WHERE m.userid=u.id AND m.graduated!=0
ORDER BY STR_TO_DATE(SUBSTRING(m.semester_graduated, 10), '%M %Y') ASC, u.lastname ASC, u.firstname ASC
");

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


$table = new html_table();
$table->head = array(
  'Semester Graduated',
  'Family name',
  'Given name',
  'Certifying Institution',
  'Type of pass',
  'Country',
  'Became Tutor or SSO?',
  );

$n = 0;
$listofemails = array();
$gender = array();
$age = array();
$country = array();
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {
    $rowdata = array();
    $rowdata[] = htmlspecialchars($enrol->semester_graduated, ENT_COMPAT, 'UTF-8');
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->userid . '" target="_blank">' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</a>';
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->userid . '" target="_blank">' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</a>';
    $certifying = array(0 => '', 1 => 'MMU MPH', 2 => 'Peoples MPH', 3 => 'OTHER MPH');
    $rowdata[] = $certifying[$enrol->mphstatus];
    $type_of_pass = array(0 => '', 1 => '', 2 => 'Merit', 3 => 'Distinction');
    $rowdata[] = $type_of_pass[$enrol->graduated];
    $rowdata[] = htmlspecialchars($countryname[$enrol->country], ENT_COMPAT, 'UTF-8');
    if (empty($tutors_by_id[$enrol->userid])) {
      $rowdata[] = '';
    }
    else {
      $rowdata[] = htmlspecialchars($tutors_by_id[$enrol->userid]->new_roles, ENT_COMPAT, 'UTF-8');
    }

    $listofemails[]  = htmlspecialchars($enrol->email, ENT_COMPAT, 'UTF-8');

    if ($genderid) {
      $data = $DB->get_record('user_info_data', array('userid' => $enrol->userid, 'fieldid' => $genderid));
      if (!empty($data->data)) {
        $profgender = $data->data;

        if (empty($gender[$profgender])) {
          $gender[$profgender] = 1;
        }
        else {
          $gender[$profgender]++;
        }
      }
    }

    if ($dobid) {
      $data = $DB->get_record('user_info_data', array('userid' => $enrol->userid, 'fieldid' => $dobid));
      if (!empty($data->data)) {
        $founddob = preg_match('/^[0-9]{1,2} (January|February|March|April|May|June|July|August|September|October|November|December) ([0-9]{4,})$/', $data->data, $matchesdob); // Take out course code without Year/Semester part
        if ($founddob) {
          $profdob = $matchesdob[2];
         if (empty($profdob)) $range = '';
          elseif ($profdob >= 1990) $range = '1990+';
          elseif ($profdob >= 1980) $range = '1980-1989';
          elseif ($profdob >= 1970) $range = '1970-1979';
          elseif ($profdob >= 1960) $range = '1960-1969';
          elseif ($profdob >= 1950) $range = '1950-1959';
          else $range = '1900-1950';
          if (empty($age[$range])) {
            $age[$range] = 1;
          }
          else {
            $age[$range]++;
          }
        }
      }
    }

    if (empty($country[$countryname[$enrol->country]])) {
      $country[$countryname[$enrol->country]] = 1;
    }
    else {
      $country[$countryname[$enrol->country]]++;
    }

		$n++;
    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);

echo '<br/>Number: ' . $n;

echo '<br /><br /><br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

natcasesort($listofemails);
echo 'e-mails of Above Students...<br />' . implode(', ', array_unique($listofemails)) . '<br /><br />';

echo 'Statistics for Above Students...<br />';
displaystat($gender,'Gender');
displaystat($age,'Year of Birth');
displaystat($country,'Country');

echo '<br /><br /><br /><br />';


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


function is_peoples_teacher() {
  global $USER;
  global $DB;

  /* All Teacher, Teachers...
  SELECT u.lastname, r.name, c.fullname
  FROM mdl_user u, mdl_role_assignments ra, mdl_role r, mdl_context con, mdl_course c
  WHERE
  u.id=ra.userid AND
  ra.roleid=r.id AND
  ra.contextid=con.id AND
  r.name IN ('Teacher', 'Teachers') AND
  con.contextlevel=50 AND
  con.instanceid=c.id ORDER BY c.fullname, r.name;
  */

  $teachers = $DB->get_records_sql("
    SELECT DISTINCT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', context_system::instance())) return true;
  else return false;
}
?>
