<?php  // $Id: successbyqualifications.php, v 1.1 2009/06/22 18:08:00 alanbarrett Exp $
/**
*
* Report on Student Grades versus Qualifications and Employment
*
*/

$qualificationname[ '0'] = '';
$qualificationname[ '1'] = 'None';
$qualificationname['10'] = 'Degree (not health related)';
$qualificationname['20'] = 'Health qualification (non-degree)';
$qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
$qualificationname['40'] = 'Medical degree';

$higherqualificationname[ '0'] = '';
$higherqualificationname[ '1'] = 'None';
$higherqualificationname['10'] = 'Certificate';
$higherqualificationname['20'] = 'Diploma';
$higherqualificationname['30'] = 'Masters';
$higherqualificationname['40'] = 'Ph.D.';
$higherqualificationname['50'] = 'Other';

$employmentname[ '0'] = '';
$employmentname[ '1'] = 'None';
$employmentname['10'] = 'Student';
$employmentname['20'] = 'Non-health';
$employmentname['30'] = 'Clinical (not specifically public health)';
$employmentname['40'] = 'Public health';
$employmentname['50'] = 'Other health related';
$employmentname['60'] = 'Academic occupation (e.g. lecturer)';

$howfoundpeoplesname['']   = '';
$howfoundpeoplesname[ '0'] = '';
$howfoundpeoplesname['10'] = 'Informed by another Peoples-uni student';
$howfoundpeoplesname['20'] = 'Informed by someone else';
$howfoundpeoplesname['30'] = 'Facebook';
$howfoundpeoplesname['40'] = 'Internet advertisement';
$howfoundpeoplesname['50'] = 'Link from another website or discussion forum';
$howfoundpeoplesname['60'] = 'I used a search engine to look for courses';
$howfoundpeoplesname['70'] = 'Referral from Partnership Institution';

$whatlearnname['10'] = 'I want to improve my knowledge of public health';
$whatlearnname['20'] = 'I want to improve my academic skills';
$whatlearnname['30'] = 'I want to improve my skills in research';
$whatlearnname['40'] = 'I am not sure';

$whylearnname['10'] = 'I want to apply what I learn to my current/future work';
$whylearnname['20'] = 'I want to improve my career opportunities';
$whylearnname['30'] = 'I want to get academic credit';
$whylearnname['40'] = 'I am not sure';

$whyelearningname['10'] = 'I want to meet and learn with people from other countries';
$whyelearningname['20'] = 'I want the opportunity to be flexible about my study time';
$whyelearningname['30'] = 'I want a public health training that is affordable';
$whyelearningname['40'] = 'I am not sure';

$howuselearningname['10'] = 'Share knowledge skills with other colleagues';
$howuselearningname['20'] = 'Start a new project';
$howuselearningname['30'] = 'I am not sure';


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$countryname = get_string_manager()->get_list_of_countries(false);

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/successbyqualifications.php');


if (!empty($_POST['markfilter'])) {
	redirect($CFG->wwwroot . '/course/successbyqualifications.php?'
		. 'id=' . $_POST['id']
		. '&chosenstatus=' . urlencode(dontstripslashes($_POST['chosenstatus']))
		. '&chosensemester=' . urlencode(dontstripslashes($_POST['chosensemester']))
    . '&acceptedmmu=' . urlencode(dontstripslashes($_POST['acceptedmmu']))
    . '&becametutor=' . urlencode(dontstripslashes($_POST['becametutor']))
		. (empty($_POST['sortbyaccess']) ? '&sortbyaccess=0' : '&sortbyaccess=1')
    . (empty($_POST['displayforexcel']) ? '&displayforexcel=0' : '&displayforexcel=1')
		);
}


$PAGE->set_pagelayout('embedded');

require_login();

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
if (!$isteacher) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/successbyqualifications.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please Click "Continue" below, and then log in with your username and password above!</b><br /><br /><br />', "$CFG->wwwroot/");
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
  if (empty($_REQUEST['displayforexcel'])) echo '<h1>Report on Student Grades versus Qualifications and Employment for course ' . htmlspecialchars($courserecord->fullname, ENT_COMPAT, 'UTF-8') . '</h1>';
  $PAGE->set_title('Report on Student Grades versus Qualifications and Employment for course ' . htmlspecialchars($courserecord->fullname, ENT_COMPAT, 'UTF-8'));
  $PAGE->set_heading('Report on Student Grades versus Qualifications and Employment for course ' . htmlspecialchars($courserecord->fullname, ENT_COMPAT, 'UTF-8'));
}
else {
	$courseidsql1 = '';
	$courseidsql2 = '';
  if (empty($_REQUEST['displayforexcel'])) echo '<h1>Report on Student Grades versus Qualifications and Employment</h1>';
  $PAGE->set_title('Report on Student Grades versus Qualifications and Employment');
  $PAGE->set_heading('Report on Student Grades versus Qualifications and Employment');
}
echo $OUTPUT->header();


$chosenstatus = dontstripslashes(optional_param('chosenstatus', 'All', PARAM_NOTAGS));

$liststatus[] = 'All';
if (!isset($chosenstatus)) $chosenstatus = 'All';
$liststatus[] = 'Passed 45+';
$liststatus[] = 'Passed 45 to 49.99';
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
elseif ($chosenstatus === 'Passed 45 to 49.99') $gradesql = 'WHERE ((x.percentgrades=0 AND IFNULL(y.finalgrade, 2.0)<=1.99999) OR (x.percentgrades=1 AND IFNULL(y.finalgrade, 0.0) >44.99999 AND IFNULL(y.finalgrade, 100.0) <=49.99999))';
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

$acceptedmmu = dontstripslashes(optional_param('acceptedmmu', '', PARAM_NOTAGS));

$listacceptedmmu[] = 'Any';
if (empty($acceptedmmu)) $acceptedmmu = 'Any';
$listacceptedmmu[] = 'Yes';
$listacceptedmmu[] = 'No';
for ($year = 11; $year <= 16; $year++) {
  $listacceptedmmu[] = "Accepted {$year}a";
  $listacceptedmmu[] = "Accepted {$year}b";

  $stamp_range["Accepted {$year}a"]['start'] = gmmktime( 0, 0, 0,  1,  1, 2000 + $year);
  $stamp_range["Accepted {$year}a"]['end']   = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['start'] = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['end']   = gmmktime(24, 0, 0, 12, 31, 2000 + $year);
}

$becametutor = dontstripslashes(optional_param('becametutor', '', PARAM_NOTAGS));

$listbecametutor[] = 'Any';
if (empty($becametutor)) $becametutor = 'Any';
$listbecametutor[] = 'Yes';
$listbecametutor[] = 'No';

if (!empty($_REQUEST['sortbyaccess'])) {
	$sortbyaccess = true;
	$orderby ='x.lastaccess DESC, x.firstname ASC, username ASC, fullname ASC';
}
else {
	$sortbyaccess = false;
	$orderby ='x.lastname ASC, x.firstname ASC, username ASC, fullname ASC';
}

if (!empty($_REQUEST['displayforexcel'])) {
  $displayforexcel = true;
}
else {
  $displayforexcel = false;
}

// Taken from posts.php so will have good defaults...
if (!empty($_REQUEST['skipintro'])) $skipintro = true;
else $skipintro = false;
if (!empty($_REQUEST['suppressnames'])) $suppressnames = true;
else $suppressnames = false;
if (!empty($_REQUEST['showyesonly'])) $showyesonly = true;
else $showyesonly = false;


if (!$displayforexcel) {
?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/successbyqualifications.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
	<tr>
		<td>Course</td>
		<td>Grading Status</td>
		<td>Semester</td>
    <td>Accepted MPH?</td>
    <td>Became Tutor or SSO?</td>
		<td>Sort by Last Access</td>
    <td>Display main table only for Copying and Pasting to Excel</td>
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
    displayoptions('acceptedmmu', $listacceptedmmu, $acceptedmmu);
    displayoptions('becametutor', $listbecametutor, $becametutor);
		?>
		<td><input type="checkbox" name="sortbyaccess" <?php if ($sortbyaccess) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="displayforexcel" <?php if ($displayforexcel) echo ' CHECKED'; ?>></td>
	</tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/successbyqualifications.php">Reset Filters</a>
</form>
<br /><br />
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


$prof = $DB->get_record('user_info_field', array('shortname' => 'dateofbirth'));
if (!empty($prof->id)) $dobid = $prof->id;
$prof = $DB->get_record('user_info_field', array('shortname' => 'gender'));
if (!empty($prof->id)) $genderid = $prof->id;


$enrols = $DB->get_records_sql("SELECT x.*, y.*, m.id IS NOT NULL AS mph, m.datesubmitted AS mphdatestamp FROM
(SELECT e.*, c.fullname, c.idnumber, u.lastname, u.firstname, u.email, u.username, u.lastaccess, u.country, q.qualification, q.higherqualification, q.employment FROM
mdl_enrolment e, mdl_course c, mdl_user u, mdl_applicantqualifications q WHERE e.courseid=c.id AND e.userid=u.id $courseidsql1 $statussql $semestersql AND u.id=q.userid) AS x
LEFT JOIN
(SELECT g.userid AS guserid, g.finalgrade, i.courseid AS icourseid FROM mdl_grade_grades g, mdl_grade_items i WHERE g.itemid=i.id AND i.itemtype='course' $courseidsql2) AS y
ON x.userid=y.guserid AND x.courseid=y.icourseid
LEFT JOIN mdl_peoplesmph m ON x.userid=m.userid
$gradesql
ORDER BY $orderby",
array($chosensemester));
// If courseid is not specified this could get very inefficient, in that case I should optimise the JOIN


// The following (down to END POSTS Extract) is taken (modified) from posts.php... not all of the data generated is used, but is kept for compatibility
if (!empty($courserecord->fullname)) $chosenmodule = $courserecord->fullname;
if (empty($chosenmodule) || ($chosenmodule == 'All')) {
  $chosenmodule = 'All';
  $modulesql = 'AND c.fullname!=?';
}
else {
  $modulesql = 'AND c.fullname=?';
}


$enrolposts = $DB->get_records_sql(
"SELECT fp.id AS postid, fd.id AS discid, e.semester, u.id as userid, u.lastname, u.firstname, c.fullname, f.name AS forumname, fp.subject, m.id IS NOT NULL AS mph, m.datesubmitted AS mphdatestamp
FROM (mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp)
LEFT JOIN mdl_peoplesmph m ON e.userid=m.userid
WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id $semestersql $modulesql
ORDER BY e.semester, u.lastname ASC, u.firstname ASC, fullname ASC, forumname ASC, fp.subject ASC",
array($chosensemester, $chosenmodule)
);

$sidsbyuseridsemester = $DB->get_records_sql('SELECT CONCAT(userid, semester) AS i, sid FROM mdl_peoplesapplication WHERE (((state & 0x38)>>3)=3 OR (state & 0x7)=3)');

$registrations = $DB->get_records_sql('SELECT DISTINCT r.userid AS userid_index, r.* FROM mdl_peoplesregistration r WHERE r.userid!=0');

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


$usercount = array();
$usercountbyuserid = array();
$usermodulecount = array();
$usermodulecountbuseridbymodule = array();
$topiccount = array();
$nposts = 0;
if (!empty($enrolposts)) {
  foreach ($enrolposts as $enrolpost) {

    if (!empty($acceptedmmu) && $acceptedmmu !== 'Any') {
      if ($acceptedmmu === 'No' && $enrolpost->mph) {
        continue;
      }
      if ($acceptedmmu === 'Yes' && !$enrolpost->mph) {
        continue;
      }
      if ($acceptedmmu !== 'No' && $acceptedmmu !== 'Yes') {
        if (!$enrolpost->mph || $enrolpost->mphdatestamp < $stamp_range[$acceptedmmu]['start'] || $enrolpost->mphdatestamp >= $stamp_range[$acceptedmmu]['end']) {
          continue;
        }
      }
    }

    if (!empty($becametutor) && $becametutor !== 'Any') {
      if ($becametutor === 'No' && !empty($tutors_by_id[$enrolpost->userid])) {
        continue;
      }
      if ($becametutor === 'Yes' && empty($tutors_by_id[$enrolpost->userid])) {
        continue;
      }
    }


    if ($skipintro && (substr(strtolower(trim(strip_tags($enrolpost->forumname))), 0, 12) === 'introduction')) {
        continue;
    }

    $hashforcourse = htmlspecialchars($enrolpost->fullname, ENT_COMPAT, 'UTF-8');
    $courseswithstudentforumstats[$hashforcourse]['forums']['<td>' . htmlspecialchars($enrolpost->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;

    $hashforstudent = $enrolpost->userid;
    if (empty($courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent])) {
      $courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['last'] = '<td>' . htmlspecialchars($enrolpost->lastname, ENT_COMPAT, 'UTF-8') . '</td>';
      $courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['first'] = '<td>' . htmlspecialchars($enrolpost->firstname, ENT_COMPAT, 'UTF-8') . '</td>';
      $courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['course'] = '<td>' . htmlspecialchars($enrolpost->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
      $courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['userid'] = $enrolpost->userid;
      $courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['semester'] = $enrolpost->semester;


      $courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrolpost->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;
    }
    else {
      if (empty($courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrolpost->forumname, ENT_COMPAT, 'UTF-8') . '</td>'])) {
        $courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrolpost->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;
      }
      else {
        $courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrolpost->forumname, ENT_COMPAT, 'UTF-8') . '</td>']++;
      }
    }


    $name = htmlspecialchars(strtolower(trim($enrolpost->lastname . ', ' . $enrolpost->firstname)), ENT_COMPAT, 'UTF-8');
    if (empty($usercount[$name])) {
      $usercount[$name] = 1;
    }
    else {
      $usercount[$name]++;
    }
    if (empty($usercountbyuserid[$enrolpost->userid])) {
      $usercountbyuserid[$enrolpost->userid] = 1;
    }
    else {
      $usercountbyuserid[$enrolpost->userid]++;
    }


    $name = htmlspecialchars(strtolower(trim($enrolpost->lastname . ', ' . $enrolpost->firstname . ', ' . $enrolpost->fullname)), ENT_COMPAT, 'UTF-8');
    if (empty($usermodulecount[$name])) {
      $usermodulecount[$name] = 1;
    }
    else {
      $usermodulecount[$name]++;
    }
    if (empty($usermodulecountbuseridbymodule[$enrolpost->userid][$enrolpost->fullname])) {
      $usermodulecountbuseridbymodule[$enrolpost->userid][$enrolpost->fullname] = 1;
    }
    else {
      $usermodulecountbuseridbymodule[$enrolpost->userid][$enrolpost->fullname]++;
    }


    $name = htmlspecialchars(strtolower(trim($enrolpost->fullname . ', ' . $enrolpost->forumname)), ENT_COMPAT, 'UTF-8');
    if (empty($topiccount[$name])) {
      $topiccount[$name] = 1;
    }
    else {
      $topiccount[$name]++;
    }

    $nposts++;
  }
}
// END POSTS Extract


$bursaries = $DB->get_records_sql("
SELECT
  b.userid,
  -SUM(b.amount_delta) AS total,
  COUNT(*) AS number
FROM mdl_peoples_student_balance b
WHERE
  b.detail LIKE '%scholarship%' OR
  b.detail LIKE '%bursa%' OR
  b.detail LIKE '%busar%' OR
  b.detail LIKE '%bursr%'
GROUP BY b.userid");

$paid_somethings = $DB->get_records_sql("
SELECT
  b.userid,
  -SUM(b.amount_delta) AS total,
  COUNT(*) AS number
FROM mdl_peoples_student_balance b
WHERE
  b.amount_delta < 0 AND (
  b.detail LIKE '%Ecobank%' OR
  b.detail LIKE '%Eco-bank%' OR
  b.detail LIKE '%WorldPay%' OR
  b.detail LIKE '%Barclays%' OR
  b.detail LIKE '%Diamond%' OR
  b.detail LIKE '%Western%' OR
  b.detail LIKE '%MoneyGram%' OR
  b.detail LIKE '%instalment%' OR
  b.detail LIKE '%paid%' OR
  b.detail LIKE '%payment%')
GROUP BY b.userid");

$scholarships = $DB->get_records_sql("
SELECT DISTINCT
  userid
FROM mdl_peoplesapplication
WHERE
  scholarship !='' AND
  scholarship !='I am not seeking scholarship' AND
  scholarship !='none' AND
  scholarship !='n/a' AND
  scholarship !='none.'");


if (!$displayforexcel) echo '<b>Data displayed and totalled for students with qualification data only...</b><br />';
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
  'Qualification',
  'Higherqualification',
  'Employment',
  'How heard about Peoples-uni',
  'Number of Student Posts in this Module',
  'I want to improve my knowledge of public health',
  'I want to improve my academic skills',
  'I want to improve my skills in research',
  'I am not sure(What do you want to learn?)',
  'I want to apply what I learn to my current/future work',
  'I want to improve my career opportunities',
  'I want to get academic credit',
  'I am not sure(Why do you want to learn?)',
  'I want to meet and learn with people from other countries',
  'I want the opportunity to be flexible about my study time',
  'I want a public health training that is affordable',
  'I am not sure(What are the reasons you want to do an e-learning course?)',
  'Share knowledge skills with other colleagues',
  'Start a new project',
  'I am not sure(How will you use your new knowledge and skills to improve population health?)',
  'ID',
  'Became Tutor or SSO?',
  'Total Bursary (Number)',
  'Applied Scholarship?',
  'Total Payments (Number)',
  );

$n = 0;
$lastname = '';
$countnondup = 0;
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {

    if (!empty($acceptedmmu) && $acceptedmmu !== 'Any') {
      if ($acceptedmmu === 'No' && $enrol->mph) {
        continue;
      }
      if ($acceptedmmu === 'Yes' && !$enrol->mph) {
        continue;
      }
      if ($acceptedmmu !== 'No' && $acceptedmmu !== 'Yes') {
        if (!$enrol->mph || $enrol->mphdatestamp < $stamp_range[$acceptedmmu]['start'] || $enrol->mphdatestamp >= $stamp_range[$acceptedmmu]['end']) {
          continue;
        }
      }
    }

    if (!empty($becametutor) && $becametutor !== 'Any') {
      if ($becametutor === 'No' && !empty($tutors_by_id[$enrol->userid])) {
        continue;
      }
      if ($becametutor === 'Yes' && empty($tutors_by_id[$enrol->userid])) {
        continue;
      }
    }

    $rowdata = array();
    $rowdata[] = htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->userid . '" target="_blank">' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</a>';
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->userid . '" target="_blank">' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</a>';
    $rowdata[] = htmlspecialchars($enrol->username, ENT_COMPAT, 'UTF-8');

    $z = ($enrol->lastaccess ? format_time(time() - $enrol->lastaccess) : get_string('never'));
    if ($displayforexcel) {
      $separator = ' ';
    }
    else {
      $separator = '<br />';
    }
    if ($enrol->enrolled == 0) $z .= $separator . 'Was Un-Enrolled on: ' . gmdate('d M Y', $enrol->dateunenrolled);

    $enrs = $DB->get_records_sql("SELECT e.id, e.datefirstenrolled, e.semester, c.idnumber FROM mdl_enrolment e, mdl_course c
      WHERE e.userid=? AND e.courseid=c.id AND ?<e.datefirstenrolled", array($enrol->userid, $enrol->datefirstenrolled));
    foreach ($enrs as $enr) {
      $founda = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enrol->idnumber, $matchesa); // Take out course code without Year/Semester part
      $foundb = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enr->idnumber, $matchesb);
      if ($founda && $foundb) {
        if ($matchesa[1] === $matchesb[1]) {
          $z .= $separator . '<span style="color:red">Re-Enrolled in this Module for Semester: ' . htmlspecialchars($enr->semester, ENT_COMPAT, 'UTF-8') . '</span>';
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

    $rowdata[] = $qualificationname[$enrol->qualification];
    $rowdata[] = $higherqualificationname[$enrol->higherqualification];
    $rowdata[] = $employmentname[$enrol->employment];

    if (!empty($registrations[$enrol->userid])) $registration = $registrations[$enrol->userid];
    if (empty($enrol->userid) || empty($registrations[$enrol->userid]) || empty($registration)) {
      $registration = new stdClass();
      $registration->whatlearn = '';
      $registration->whylearn = '';
      $registration->whyelearning = '';
      $registration->howuselearning = '';
      $registration->howfoundpeoples = '';
      $registration->howfoundorganisationname = '';
    }

    $z = '';
    if (!empty($registration->howfoundpeoples)) $z = $howfoundpeoplesname[$registration->howfoundpeoples];
    $rowdata[] = $z;

    if (!empty($usermodulecountbuseridbymodule[$enrol->userid][$enrol->fullname])) {
      $rowdata[] = $usermodulecountbuseridbymodule[$enrol->userid][$enrol->fullname];
    }
    else {
      $rowdata[] = 0;
    }


    $arrayvalues = explode(',', $registration->whatlearn);
    $z = '';
    if (in_array('10', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('20', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('30', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('40', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $arrayvalues = explode(',', $registration->whylearn);
    $z = '';
    if (in_array('10', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('20', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('30', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('40', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $arrayvalues = explode(',', $registration->whyelearning);
    $z = '';
    if (in_array('10', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('20', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('30', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('40', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $arrayvalues = explode(',', $registration->howuselearning);
    $z = '';
    if (in_array('10', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('20', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $z = '';
    if (in_array('30', $arrayvalues)) $z = 1;
    $rowdata[] = $z;

    $rowdata[] = $enrol->userid;

    if (empty($tutors_by_id[$enrol->userid])) {
      $rowdata[] = '';
    }
    else {
      $rowdata[] = htmlspecialchars($tutors_by_id[$enrol->userid]->new_roles, ENT_COMPAT, 'UTF-8');
    }

    if (empty($bursaries[$enrol->userid])) {
      $rowdata[] = '';
    }
    else {
      $rowdata[] = '&pound;' . $bursaries[$enrol->userid]->total . ' (' . $bursaries[$enrol->userid]->number . ')';
    }

    if (empty($scholarships[$enrol->userid])) {
      $rowdata[] = '';
    }
    else {
      $rowdata[] = 'Yes';
    }

    if (empty($paid_somethings[$enrol->userid])) {
      $rowdata[] = '';
    }
    else {
      $rowdata[] = '&pound;' . $paid_somethings[$enrol->userid]->total . ' (' . $paid_somethings[$enrol->userid]->number . ')';
    }

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

			if (empty($qualification[$qualificationname[$enrol->qualification]])) {
				$qualification[$qualificationname[$enrol->qualification]] = 1;
			}
			else {
				$qualification[$qualificationname[$enrol->qualification]]++;
			}

			if (empty($higherqualification[$higherqualificationname[$enrol->higherqualification]])) {
				$higherqualification[$higherqualificationname[$enrol->higherqualification]] = 1;
			}
			else {
				$higherqualification[$higherqualificationname[$enrol->higherqualification]]++;
			}

			if (empty($employment[$employmentname[$enrol->employment]])) {
				$employment[$employmentname[$enrol->employment]] = 1;
			}
			else {
				$employment[$employmentname[$enrol->employment]]++;
			}

      if (empty($howfoundpeoples[$howfoundpeoplesname[$registration->howfoundpeoples]])) {
        $howfoundpeoples[$howfoundpeoplesname[$registration->howfoundpeoples]] = 1;
      }
      else {
        $howfoundpeoples[$howfoundpeoplesname[$registration->howfoundpeoples]]++;
      }

			$countnondup++;
		}
		$lastname = $enrol->username;
		$n++;
    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);

if ($displayforexcel) {
  echo $OUTPUT->footer();
  die();
}

echo '<br/>Number of Enrolments: ' . $n;
echo '<br/>Number of Students: ' . $countnondup;

echo '<br /><br />';


echo 'Statistics for Above Students (ignoring duplicates)...<br />';
displaystat($gender, 'Gender');
displaystat($age, 'Year of Birth');
displaystat($country, 'Country');
displaystat($qualification, 'Qualification');
displaystat($higherqualification, 'Higher Qualification');
displaystat($employment, 'Employment');
displaystat($howfoundpeoples, 'How heard about Peoples-uni');

echo '<br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

//print_footer();
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


function dontstripslashes($x) {
  return $x;
}
?>
