<?php  // $Id: coursegrades.php,v 1.1 2008/11/26 17:30:00 alanbarrett Exp $
/**
*
* List a users enrolments and grades etc. for all students in course
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

$countryname = get_string_manager()->get_list_of_countries(false);

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/coursegrades.php');


if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/coursegrades.php?'
    . 'id=' . $_POST['id']
    . '&chosenstatus=' . urlencode(dontstripslashes($_POST['chosenstatus']))
    . '&chosensemester=' . urlencode(dontstripslashes($_POST['chosensemester']))
    . '&chosenssf=' . urlencode(dontstripslashes($_POST['chosenssf']))
    . (empty($_POST['sortbyaccess']) ? '&sortbyaccess=0' : '&sortbyaccess=1')
    . '&showmissingfordays=' . urlencode(dontstripslashes($_POST['showmissingfordays']))
    . (empty($_POST['showpaymentstatus']) ? '&showpaymentstatus=0' : '&showpaymentstatus=1')
    . (empty($_POST['showmmumphonly']) ? '&showmmumphonly=0' : '&showmmumphonly=1')
    );
}
elseif (!empty($_POST['markemailsend']) && !empty($_POST['emailsubject']) && !empty($_POST['emailbody'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $sendemails = true;
}
elseif (!empty($_POST['markemailsendmissing']) && !empty($_POST['emailsubject']) && !empty($_POST['emailbody'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $sendemails = true;
}
else {
  $sendemails = false;
}


$PAGE->set_pagelayout('embedded');

require_login();

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
$islurker = has_capability('moodle/grade:viewall', context_system::instance());
if (!$isteacher && !$islurker) {
	echo '<h1>You must be a tutor to do this!</h1>';
	notice('Please Login Below', "$CFG->wwwroot/");
}

$courseid = optional_param('id', 0, PARAM_INT);
if ($courseid) {
  $courserecord = $DB->get_record('course', array('id' => $courseid));
	if (empty($courserecord)) {
		echo '<h1>Course does not exist!</h1>';
		die();
	}
	$courseidsql1 = "AND e.courseid=$courseid";
	$courseidsql2 = "AND i.courseid=$courseid";
  echo '<h1>Student Enrolments and Grades for course ' . htmlspecialchars($courserecord->fullname, ENT_COMPAT, 'UTF-8') . '</h1>';
  $PAGE->set_title('Student Enrolments and Grades for course ' . htmlspecialchars($courserecord->fullname, ENT_COMPAT, 'UTF-8'));
  $PAGE->set_heading('Student Enrolments and Grades for course ' . htmlspecialchars($courserecord->fullname, ENT_COMPAT, 'UTF-8'));
}
else {
	$courseidsql1 = '';
	$courseidsql2 = '';
  echo '<h1>Student Enrolments and Grades</h1>';
  $PAGE->set_title('Student Enrolments and Grades');
  $PAGE->set_heading('Student Enrolments and Grades');
}

echo $OUTPUT->header();


$chosenstatus = dontstripslashes(optional_param('chosenstatus', 'All', PARAM_NOTAGS));

$liststatus[] = 'All';
if (!isset($chosenstatus)) $chosenstatus = 'All';
$liststatus[] = 'Passed 45+';
$liststatus[] = 'Passed 50+';
$liststatus[] = 'Failed';
$liststatus[] = 'Did not Pass';
$liststatus[] = 'No Course Grade';
$liststatus[] = 'Un-Enrolled';
$liststatus[] = 'Not informed of Grade and Not Marked to be NOT Graded';
$liststatus[] = 'Will NOT be Graded, because they did Not Complete';
$liststatus[] = 'Will NOT be Graded, because of Exceptional Factors';
$liststatus[] = 'Will NOT be Graded, but will get a Certificate of Participation';
$liststatus[] = 'Will NOT be Graded, because they did Not Pay';

$statussql = '';
$gradesql = '';
if     ($chosenstatus === 'Passed 45+')  $gradesql = 'WHERE ((x.percentgrades=0 AND IFNULL(y.finalgrade, 2.0)<=1.99999) OR (x.percentgrades=1 AND IFNULL(y.finalgrade,   0.0) >44.99999))';
elseif ($chosenstatus === 'Passed 50+')  $gradesql = 'WHERE ((x.percentgrades=0 AND IFNULL(y.finalgrade, 2.0)<=1.99999) OR (x.percentgrades=1 AND IFNULL(y.finalgrade,   0.0) >49.99999))';
elseif ($chosenstatus === 'Failed')      $gradesql = 'WHERE ((x.percentgrades=0 AND IFNULL(y.finalgrade, 1.0) >1.99999) OR (x.percentgrades=1 AND IFNULL(y.finalgrade, 100.0)<=44.99999))';
elseif ($chosenstatus === 'Did not Pass')$gradesql = 'WHERE ((x.percentgrades=0 AND IFNULL(y.finalgrade, 2.0) >1.99999) OR (x.percentgrades=1 AND IFNULL(y.finalgrade,   0.0)<=44.99999))';
elseif ($chosenstatus === 'No Course Grade') $gradesql = 'WHERE ISNULL(y.finalgrade)';
elseif ($chosenstatus === 'Un-Enrolled')                                        $statussql = 'AND e.enrolled=0';
elseif ($chosenstatus === 'Not informed of Grade and Not Marked to be NOT Graded') $statussql = 'AND e.notified=0';
elseif ($chosenstatus === 'Will NOT be Graded, because they did Not Complete') $statussql = 'AND e.notified=2';
elseif ($chosenstatus === 'Will NOT be Graded, because of Exceptional Factors') $statussql = 'AND e.notified=5';
elseif ($chosenstatus === 'Will NOT be Graded, but will get a Certificate of Participation') $statussql = 'AND e.notified=3';
elseif ($chosenstatus === 'Will NOT be Graded, because they did Not Pay') $statussql = 'AND e.notified=4';


$chosensemester = dontstripslashes(optional_param('chosensemester', '', PARAM_NOTAGS));

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
	$listsemester[] = $semester->semester;
	if (empty($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

if (empty($chosensemester) || ($chosensemester == 'All')) {
	$chosensemester = 'All';
  $semestersql = 'AND e.semester!=?';
}
else {
  $semestersql = 'AND e.semester=?';
}

$chosenssf = dontstripslashes(optional_param('chosenssf', '', PARAM_NOTAGS));

$studentsupportforumsnames = $DB->get_records('forum', array('course' => get_config(NULL, 'peoples_student_support_id')));
if (empty($chosenssf)) $chosenssf = 'All';
$listssf[] = 'All';
foreach ($studentsupportforumsnames as $studentsupportforumsname) {
  $pos = stripos($studentsupportforumsname->name, 'Student Support Group');
  if ($pos === 0) {
    $listssf[] = htmlspecialchars($studentsupportforumsname->name, ENT_COMPAT, 'UTF-8');
  }
}
natsort($listssf);

if (empty($chosenssf) || ($chosenssf == 'All')) {
  $chosenssf = 'All';
  $ssfsql = '';
}
else {
  $chosenforumid = $DB->get_record('forum', array('name' => $chosenssf, 'course' => get_config(NULL, 'peoples_student_support_id')));

  // Look for all User Subscriptions to a Forum in the 'Student Support Forums' Course which are for Students Enrolled in the Course (not Tutors)
  $recordforselecteduserids = $DB->get_record_sql(
    "SELECT
      GROUP_CONCAT(u.id SEPARATOR ', ') AS userids
    FROM
      mdl_forum_subscriptions fs,
      mdl_user u
    WHERE
      forum=? AND
      fs.userid=u.id AND
      u.id IN
        (
          SELECT ue.userid
          FROM mdl_user_enrolments ue
          JOIN mdl_enrol e ON (e.id=ue.enrolid AND e.courseid=?)
        )",
    array($chosenforumid->id, get_config(NULL, 'peoples_student_support_id'))
  );

  if (!empty($recordforselecteduserids->userids)) {
    $ssfsql = "AND e.userid IN($recordforselecteduserids->userids)";
  }
  else {
    $ssfsql = "AND e.userid IN(-1)";
  }
}

if (!empty($_REQUEST['sortbyaccess'])) {
	$sortbyaccess = true;
	$orderby ='x.lastaccess DESC, x.firstname ASC, username ASC, fullname ASC';
}
else {
	$sortbyaccess = false;
	$orderby ='x.lastname ASC, x.firstname ASC, username ASC, fullname ASC';
}


$showmissingfordays = dontstripslashes(optional_param('showmissingfordays', 'All', PARAM_NOTAGS));

$listshowmissingfordays[] = 'All';
if (!isset($showmissingfordays)) $showmissingfordays = 'All';
$listshowmissingfordays[] = '3';
$listshowmissingfordays[] = '7';
$listshowmissingfordays[] = '10';
$listshowmissingfordays[] = '14';
$listshowmissingfordays[] = '21';
$listshowmissingfordays[] = '28';
$listshowmissingfordays[] = '60';
$listshowmissingfordays[] = '90';
$listshowmissingfordays[] = '180';
$listshowmissingfordays[] = '365';

if (empty($showmissingfordays) || ($showmissingfordays == 'All')) {
  $showmissingfordays = 'All';
  $showmissingfordayssql = '';
}
else {
  $showmissingfordayssql = 'AND ((u.lastaccess=0) OR (((' . time() . ' - u.lastaccess)/86400) >  ' . ((int)$showmissingfordays) . '))';
}

if (!empty($_REQUEST['showpaymentstatus'])) {
  $showpaymentstatus = true;
}
else {
  $showpaymentstatus = false;
}

if (!empty($_REQUEST['showmmumphonly'])) {
  $showmmumphonly = true;
}
else {
  $showmmumphonly = false;
}

?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/coursegrades.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Course</td>
    <td>Grading Status</td>
    <td>Semester</td>
    <td>Sort by Last Access</td>
    <td>Show Students Not Logged on for this many Days</td>
    <td>Show "Payment up to date?" Status</td>
    <td>Show MPH Only</td>
    <td>Students from this SSF only</td>
  </tr>
  <tr>
    <td>
		<select name="id">
				<option value="0" <?php if (empty($courseid)) echo 'selected="selected"';?>>All</option>
				<?php
        $courses = $DB->get_records('course', NULL, 'fullname ASC');
				foreach ($courses as $course) {
					?>
					<option value="<?php echo $course->id; ?>" <?php if ($course->id == $courseid) echo 'selected="selected"';?>><?php echo htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8'); ?></option>
					<?php
				}
				?>
		</select>
		</td>
		<?php
		displayoptions('chosenstatus', $liststatus, $chosenstatus);
		displayoptions('chosensemester', $listsemester, $chosensemester);
		?>
		<td><input type="checkbox" name="sortbyaccess" <?php if ($sortbyaccess) echo ' CHECKED'; ?>></td>
    <?php
    displayoptions('showmissingfordays', $listshowmissingfordays, $showmissingfordays);
    ?>
    <td><input type="checkbox" name="showpaymentstatus" <?php if ($showpaymentstatus) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="showmmumphonly" <?php if ($showmmumphonly) echo ' CHECKED'; ?>></td>
    <?php
    displayoptions('chosenssf', $listssf, $chosenssf);
    ?>
	</tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/coursegrades.php">Reset Filters</a>
</form>
<br /><br />
<?php


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


$prof = $DB->get_record('user_info_field', array('shortname' => 'dateofbirth'));
if (!empty($prof->id)) $dobid = $prof->id;
$prof = $DB->get_record('user_info_field', array('shortname' => 'gender'));
if (!empty($prof->id)) $genderid = $prof->id;


$enrols = $DB->get_records_sql("SELECT * FROM
(SELECT e.*, c.fullname, c.idnumber, u.lastname, u.firstname, u.email, u.username, u.lastaccess, u.country FROM mdl_enrolment e, mdl_course c, mdl_user u WHERE e.courseid=c.id AND e.userid=u.id $courseidsql1 $statussql $semestersql $showmissingfordayssql $ssfsql) AS x
LEFT JOIN
(SELECT g.userid AS guserid, g.finalgrade, i.courseid AS icourseid FROM mdl_grade_grades g, mdl_grade_items i WHERE g.itemid=i.id AND i.itemtype='course' $courseidsql2) AS y
ON x.userid=y.guserid AND x.courseid=y.icourseid
$gradesql
ORDER BY $orderby",
array($chosensemester));
// If courseid is not specified this could get very inefficient, in that case I should optimise the JOIN

$peoples_cert_pss = $DB->get_records_sql('SELECT ps.userid AS userid_index, ps.* FROM mdl_peoples_cert_ps ps');


if ($sendemails) {
	if (empty($_POST['reg'])) $_POST['reg'] = '/^[a-zA-Z0-9_.-]/';
	sendemails($enrols, strip_tags(dontstripslashes($_POST['emailsubject'])), strip_tags(dontstripslashes($_POST['emailbody'])), dontstripslashes($_POST['reg']));
}


$table = new html_table();
$table->head = array(
  'Semester',
  'Module',
  'Family name',
  'Given name',
  'Username',
  'Last access',
  'Grade',
  'Informed?',
  '',
  '',
  ''
  );
if ($showpaymentstatus) $table->head[] = 'Payment up to date?';

$n = 0;
$lastname = '';
$countnondup = 0;
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {

    $inmph = '';
    $graduated_text = '';
    $mph2s = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph2 WHERE userid={$enrol->userid} AND mphstatus!=0 ORDER BY datesubmitted DESC");
    if (!empty($mph2s)) {
      foreach ($mph2s as $mph2) { // There is only ever one, but I am leaving code the same
        if ($mph2->mphstatus == 1) $inmph = '<br />(MMU MPH)';
        if ($mph2->mphstatus == 2) $inmph = '<br />(Peoples-uni MPH)';
        if ($mph2->mphstatus == 3) $inmph = '<br />(EUCLID MPH)';

        if ($mph2->suspended) $inmph .= '(Suspended)';

        if     ($mph2->graduated == 1) $graduated_text = '<br />(graduated MPH)';
        elseif ($mph2->graduated == 2) $graduated_text = '<br />(graduated MPH Merit)';
        elseif ($mph2->graduated == 3) $graduated_text = '<br />(graduated MPH Distinction)';
      }
    }

    if (empty($inmph) && $showmmumphonly) continue;

    if (!empty($peoples_cert_pss[$enrol->userid]) && $peoples_cert_pss[$enrol->userid]->cert_psstatus) $incert_ps = '<br />(Cert PS)';
    else $incert_ps = '';

    $rowdata = array();
    $rowdata[] = htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->userid . '" target="_blank">' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</a>';
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->userid . '" target="_blank">' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</a>';
    $rowdata[] = htmlspecialchars($enrol->username, ENT_COMPAT, 'UTF-8');

		$z = ($enrol->lastaccess ? format_time(time() - $enrol->lastaccess) : get_string('never'));
		if ($enrol->enrolled == 0) $z .= '<br />Was Un-Enrolled on: ' . gmdate('d M Y', $enrol->dateunenrolled);

    $enrs = $DB->get_records_sql("SELECT e.id, e.datefirstenrolled, e.semester, c.idnumber FROM mdl_enrolment e, mdl_course c
      WHERE e.userid=? AND e.courseid=c.id AND ?<e.datefirstenrolled", array($enrol->userid, $enrol->datefirstenrolled));
		foreach ($enrs as $enr) {
			$founda = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enrol->idnumber, $matchesa);	// Take out course code without Year/Semester part
			$foundb = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enr->idnumber, $matchesb);
			if ($founda && $foundb) {
				if ($matchesa[1] === $matchesb[1]) {
					$z .= '<br /><span style="color:red">Re-Enrolled in this Module for Semester: ' . htmlspecialchars($enr->semester, ENT_COMPAT, 'UTF-8') . '</span>';
				}
			}
		}
    $rowdata[] = $z;

    if     (empty($enrol->finalgrade)) $rowdata[] = ''; // MySQL Decimal '0.00000' is not empty which is good
    elseif (($enrol->percentgrades == 0) AND ($enrol->finalgrade > 1.99999)) $rowdata[] = 'Failed';
    elseif ($enrol->percentgrades == 0)     $rowdata[] = 'Passed';
    elseif ($enrol->finalgrade <= 44.99999) $rowdata[] = 'Failed ('     . ((int)($enrol->finalgrade + 0.00001)) . '%)';
    elseif ($enrol->finalgrade  > 49.99999) $rowdata[] = 'Passed 50+ (' . ((int)($enrol->finalgrade + 0.00001)) . '%)';
    else                                    $rowdata[] = 'Passed 45+ (' . ((int)($enrol->finalgrade + 0.00001)) . '%)';

		if ($enrol->notified == 0) {
      $rowdata[] = '';
		}
		elseif ($enrol->notified == 1) {
      $rowdata[] = 'Yes';
		}
    elseif ($enrol->notified == 2) {
      $rowdata[] = 'No, did Not Complete';
    }
    elseif ($enrol->notified == 5) {
      $rowdata[] = 'No, Exceptional Factors';
    }
		elseif ($enrol->notified == 3) {
      $rowdata[] = 'Yes, Certificate of Participation';
		}
		elseif ($enrol->notified == 4) {
      $rowdata[] = 'No, did Not Pay';
		}

    $rowdata[] = '<a href="' . $CFG->wwwroot . '/course/student.php?id=' . $enrol->userid . '" target="_blank">Student Grades</a>' . $inmph . $graduated_text . $incert_ps;
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $enrol->userid . '" target="_blank">Student Submissions</a>';
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/grade/report/user/index.php?id=' . $enrol->courseid . '&userid=' . $enrol->userid . '" target="_blank">Moodle Grade report</a>';

    if ($showpaymentstatus) {
      $z = '';
      $application = $DB->get_record_sql("SELECT * FROM mdl_peoplesapplication
        WHERE (state=19 OR state=26 OR state=11 OR state=25 OR state=27) AND userid=? AND semester=?
        ORDER BY datesubmitted DESC", array($enrol->userid, $enrol->semester), IGNORE_MULTIPLE);
      if (!empty($application)) {
        if (empty($application->paymentmechanism)) $mechanism = '';
        elseif ($application->paymentmechanism == 1) $mechanism = ' RBS Confirmed';
        elseif ($application->paymentmechanism == 2) $mechanism = ' Barclays';
        elseif ($application->paymentmechanism == 3) $mechanism = ' Diamond';
        elseif ($application->paymentmechanism ==10) $mechanism = ' Ecobank';
        elseif ($application->paymentmechanism == 4) $mechanism = ' Western Union';
        elseif ($application->paymentmechanism == 5) $mechanism = ' Indian Confederation';
        elseif ($application->paymentmechanism == 6) $mechanism = ' Promised End Semester';
        elseif ($application->paymentmechanism == 7) $mechanism = ' Posted Travellers Cheques';
        elseif ($application->paymentmechanism == 8) $mechanism = ' Posted Cash';
        elseif ($application->paymentmechanism == 9) $mechanism = ' MoneyGram';
        elseif ($application->paymentmechanism == 100) $mechanism = ' Waiver';
        elseif ($application->paymentmechanism == 102) $mechanism = ' Barclays Confirmed';
        elseif ($application->paymentmechanism == 103) $mechanism = ' Diamond Confirmed';
        elseif ($application->paymentmechanism == 110) $mechanism = ' Ecobank Confirmed';
        elseif ($application->paymentmechanism == 104) $mechanism = ' Western Union Confirmed';
        elseif ($application->paymentmechanism == 105) $mechanism = ' Indian Confederation Confirmed';
        elseif ($application->paymentmechanism == 107) $mechanism = ' Posted Travellers Cheques Confirmed';
        elseif ($application->paymentmechanism == 108) $mechanism = ' Posted Cash Confirmed';
        elseif ($application->paymentmechanism == 109) $mechanism = ' MoneyGram Confirmed';
        else  $mechanism = '';

        //if ($application->costpaid < .01) $z = '<span style="color:red">No' . $mechanism . '</span>';
        //elseif (abs($application->costowed - $application->costpaid) < .01) $z = '<span style="color:green">Yes' . $mechanism . '</span>';
        //else $z = '<span style="color:blue">' . "Paid $application->costpaid out of $application->costowed" . $mechanism . '</span>';
        if (!empty($application->userid)) {
          $not_confirmed_text = '';
          if (is_not_confirmed($application->userid)) $not_confirmed_text = ' (not confirmed)';
          $amount = number_format(amount_to_pay($application->userid), 0);
          if ($amount >= .01) $z = '<span style="color:red">No: &pound;' . $amount . ' Owed now' . $not_confirmed_text . $mechanism . '</span>';
          elseif (abs($amount) < .01) $z = '<span style="color:green">Yes' . $not_confirmed_text . $mechanism . '</span>';
          else $z = '<span style="color:blue">' . "Overpaid: &pound;$amount" . $not_confirmed_text . $mechanism . '</span>'; // Will never be Overpaid here because of function used
        }
        else {
          $z = $mechanism;
        }
        if (!empty($application->paymentnote)) $z .= '<br />(Payment Note Present)'; // Not enabled at present
      }
      $rowdata[] = $z;
    }

		$listofemails[]  = htmlspecialchars($enrol->email, ENT_COMPAT, 'UTF-8');

		if ($enrol->username !== $lastname) {

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
					$founddob = preg_match('/^[0-9]{1,2} (January|February|March|April|May|June|July|August|September|October|November|December) ([0-9]{4,})$/', $data->data, $matchesdob);	// Take out course code without Year/Semester part
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
			$countnondup++;
		}
		$lastname = $enrol->username;
		$n++;
    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);

echo '<br/>Number of Enrolments: ' . $n;
echo '<br/>Number of Students: ' . $countnondup;

echo '<br /><br /><br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

natcasesort($listofemails);
echo 'e-mails of Above Students...<br />' . implode(', ', array_unique($listofemails)) . '<br /><br />';

echo 'Statistics for Above Students (ignoring duplicates)...<br />';
displaystat($gender,'Gender');
displaystat($age,'Year of Birth');
displaystat($country,'Country');

echo '<br />';
echo '<a href="' . $CFG->wwwroot . '/course/successbyqualifications.php" target="_blank">Success by Qualifications Report</a>';
echo '<br />';
echo '<a href="' . $CFG->wwwroot . '/course/discussionfeedbacks.php" target="_blank">Click here to see Discussion Feedback to Students</a>';
echo '<br />';
echo '<a href="' . $CFG->wwwroot . '/course/list_of_mph_graduates.php" target="_blank">Click here to see a List of MPH Graduates</a>';
echo '<br />';
echo '<a href="' . $CFG->wwwroot . '/course/EUCLID.php" target="_blank">Click here to see a List of Graduates who may be eligible for EUCLID MPH</a>';


echo '<br /><br /><br /><br />';


if ($isteacher) {
$peoples_batch_email_to_enrolled = get_config(NULL, 'peoples_batch_email_to_enrolled');

$peoples_batch_email_to_enrolled = htmlspecialchars($peoples_batch_email_to_enrolled, ENT_COMPAT, 'UTF-8');
?>
To send an e-mail to all the above students enter BOTH a subject and e-mail text below and click "Send e-mail to All".<br />
Look at list of e-mails sent to verify they went!<br />
<form id="emailsendform" method="post" action="<?php
  echo $CFG->wwwroot . '/course/coursegrades.php?'
    . 'id=' . $courseid
    . '&chosenstatus=' . urlencode($chosenstatus)
    . '&chosensemester=' . urlencode($chosensemester)
    . '&chosenssf=' . urlencode($chosenssf)
    . (empty($sortbyaccess) ? '&sortbyaccess=0' : '&sortbyaccess=1')
    . '&showmissingfordays=' . urlencode($showmissingfordays)
    . (empty($showpaymentstatus) ? '&showpaymentstatus=0' : '&showpaymentstatus=1')
    . (empty($showmmumphonly) ? '&showmmumphonly=0' : '&showmmumphonly=1')
    ;
?>">
Subject:&nbsp;<input type="text" size="75" name="emailsubject" /><br />
<textarea name="emailbody" rows="31" cols="75" wrap="hard" style="width:auto">
<?php echo $peoples_batch_email_to_enrolled; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markemailsend" value="1" />
<input type="submit" name="emailsend" value="Send e-mail to All" />
<br />Regular expression for included e-mails (defaults to all):&nbsp;<input type="text" size="20" name="reg" value="/^[a-zA-Z0-9_.-]/" />
</form>
<br /><br />
<?php
}


if ($isteacher) {
$peoples_batch_email_to_enrolled_missing = get_config(NULL, 'peoples_batch_email_to_enrolled_missing');

$peoples_batch_email_to_enrolled_missing = htmlspecialchars($peoples_batch_email_to_enrolled_missing, ENT_COMPAT, 'UTF-8');
?>
To send an e-mail to all the above students enter BOTH a subject and e-mail text below and click "Send e-mail to All".<br />
Look at list of e-mails sent to verify they went!<br />
<form id="emailsendmissingform" method="post" action="<?php
  echo $CFG->wwwroot . '/course/coursegrades.php?'
    . 'id=' . $courseid
    . '&chosenstatus=' . urlencode($chosenstatus)
    . '&chosensemester=' . urlencode($chosensemester)
    . '&chosenssf=' . urlencode($chosenssf)
    . (empty($sortbyaccess) ? '&sortbyaccess=0' : '&sortbyaccess=1')
    . '&showmissingfordays=' . urlencode($showmissingfordays)
    . (empty($showpaymentstatus) ? '&showpaymentstatus=0' : '&showpaymentstatus=1')
    . (empty($showmmumphonly) ? '&showmmumphonly=0' : '&showmmumphonly=1')
    ;
?>">
Subject:&nbsp;<input type="text" size="75" name="emailsubject" /><br />
<textarea name="emailbody" rows="31" cols="75" wrap="hard" style="width:auto">
<?php echo $peoples_batch_email_to_enrolled_missing; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markemailsendmissing" value="1" />
<input type="submit" name="emailsendmissing" value="Send e-mail to All" />
<br />Regular expression for included e-mails (defaults to all):&nbsp;<input type="text" size="20" name="reg" value="/^[a-zA-Z0-9_.-]/" />
</form>
<br /><br />
<?php
}


echo $OUTPUT->footer();


function sendemails($enrols, $emailsubject, $emailbody, $reg) {
  global $DB;

  echo '<br />';
  $senttouserid = array();
  $i = 1;
  foreach ($enrols as $enrol) {
    $email = $enrol->email;

    if (!preg_match($reg, $email)) {
      echo "&nbsp;&nbsp;&nbsp;&nbsp;($email skipped because of regular expression.)<br />";
      continue;
    }

    if (!in_array($enrol->userid, $senttouserid)) {
      $senttouserid[] = $enrol->userid;

      $application = $DB->get_record_sql("SELECT sid FROM mdl_peoplesapplication
        WHERE (state=19 OR state=26 OR state=11 OR state=25 OR state=27) AND userid=? AND semester=?", array($enrol->userid, $enrol->semester));
      if (!empty($application)) {
        $emailbodytemp = str_replace('GIVEN_NAME_HERE', $enrol->firstname, $emailbody);
        $emailbodytemp = str_replace('SID_HERE', $application->sid, $emailbodytemp);

        $emailbodytemp = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $emailbodytemp); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                                           // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)
        $emailbodytemp = preg_replace('#(https://[^\s]+)[\s]+#', "$1\n\n", $emailbodytemp);

        if (sendapprovedmail_from_payments($email, $emailsubject, $emailbodytemp)) {
          echo "($i) $email successfully sent.<br />";
        }
        else {
          echo "FAILURE TO SEND $email !!!<br />";
        }
        $i++;
      }
    }
  }
}
?>
