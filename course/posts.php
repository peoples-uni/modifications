<?php  // $Id: posts.php,v 1.1 2008/12/15 22:33:00 alanbarrett Exp $
/**
*
* Lists Forum Posts
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/posts.php');


if (!empty($_POST['markfilter'])) {
	redirect($CFG->wwwroot . '/course/posts.php?'
		. 'chosensemester=' . urlencode(dontstripslashes($_POST['chosensemester']))
		. '&chosenmodule=' . urlencode(dontstripslashes($_POST['chosenmodule']))
    . '&chosenssf=' . urlencode(dontstripslashes($_POST['chosenssf']))
    . '&chosenusersearch=' . urlencode(dontstripslashes($_POST['chosenusersearch']))

    . '&maximumposts=' . urlencode(dontstripslashes($_POST['maximumposts']))

    . '&acceptedmmu=' . urlencode(dontstripslashes($_POST['acceptedmmu']))

    . '&averagereferredtoresources=' . urlencode(dontstripslashes($_POST['averagereferredtoresources']))
    . '&averagecriticalapproach=' . urlencode(dontstripslashes($_POST['averagecriticalapproach']))
    . '&averagereferencing=' . urlencode(dontstripslashes($_POST['averagereferencing']))

		. (empty($_POST['skipintro']) ? '&skipintro=0' : '&skipintro=1')
		. (empty($_POST['suppressnames']) ? '&suppressnames=0' : '&suppressnames=1')
		. (empty($_POST['showyesonly']) ? '&showyesonly=0' : '&showyesonly=1')

    . (empty($_POST['referredtoresourcesnotrated']) ? '&referredtoresourcesnotrated=0' : '&referredtoresourcesnotrated=1')
    . (empty($_POST['referredtoresourcesno']) ? '&referredtoresourcesno=0' : '&referredtoresourcesno=1')
    . (empty($_POST['referredtoresourcessome']) ? '&referredtoresourcessome=0' : '&referredtoresourcessome=1')
    . (empty($_POST['referredtoresourcesyes']) ? '&referredtoresourcesyes=0' : '&referredtoresourcesyes=1')

    . (empty($_POST['criticalapproachnotrated']) ? '&criticalapproachnotrated=0' : '&criticalapproachnotrated=1')
    . (empty($_POST['criticalapproachno']) ? '&criticalapproachno=0' : '&criticalapproachno=1')
    . (empty($_POST['criticalapproachsome']) ? '&criticalapproachsome=0' : '&criticalapproachsome=1')
    . (empty($_POST['criticalapproachyes']) ? '&criticalapproachyes=0' : '&criticalapproachyes=1')

    . (empty($_POST['referencingnotrated']) ? '&referencingnotrated=0' : '&referencingnotrated=1')
    . (empty($_POST['referencingnone']) ? '&referencingnone=0' : '&referencingnone=1')
    . (empty($_POST['referencingwrongformat']) ? '&referencingwrongformat=0' : '&referencingwrongformat=1')
    . (empty($_POST['referencinggood']) ? '&referencinggood=0' : '&referencinggood=1')
		);
}


$PAGE->set_pagelayout('embedded');

require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
if (!$isteacher) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/posts.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please Click "Continue" below, and then log in with your username and password above!</b><br /><br /><br />', "$CFG->wwwroot/");
}

echo '<h1>Posts for Enrolled Students</h1>';
$PAGE->set_title('Posts for Enrolled Students');
$PAGE->set_heading('Posts for Enrolled Students');
echo $OUTPUT->header();


if (!empty($_REQUEST['chosensemester'])) $chosensemester = dontstripslashes($_REQUEST['chosensemester']);
if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = dontstripslashes($_REQUEST['chosenmodule']);
if (!empty($_REQUEST['chosenssf'])) $chosenssf = dontstripslashes($_REQUEST['chosenssf']);
if (!empty($_REQUEST['chosenusersearch'])) $chosenusersearch = dontstripslashes($_REQUEST['chosenusersearch']);
else $chosenusersearch = '';

if (isset($_REQUEST['maximumposts'])) $maximumposts = (int)dontstripslashes($_REQUEST['maximumposts']);
else $maximumposts = 99999;

if (!empty($_REQUEST['acceptedmmu'])) $acceptedmmu = dontstripslashes($_REQUEST['acceptedmmu']);

if (!empty($_REQUEST['averagereferredtoresources'])) $averagereferredtoresources = dontstripslashes($_REQUEST['averagereferredtoresources']);
if (!empty($_REQUEST['averagecriticalapproach'])) $averagecriticalapproach = dontstripslashes($_REQUEST['averagecriticalapproach']);
if (!empty($_REQUEST['averagereferencing'])) $averagereferencing = dontstripslashes($_REQUEST['averagereferencing']);

if (!empty($_REQUEST['skipintro'])) $skipintro = true;
else $skipintro = false;
if (!empty($_REQUEST['suppressnames'])) $suppressnames = true;
else $suppressnames = false;
if (!empty($_REQUEST['showyesonly'])) $showyesonly = true;
else $showyesonly = false;

if (!empty($_REQUEST['referredtoresourcesnotrated'])) $referredtoresourcesnotrated = true;
else $referredtoresourcesnotrated = false;
if (!empty($_REQUEST['referredtoresourcesno'])) $referredtoresourcesno = true;
else $referredtoresourcesno = false;
if (!empty($_REQUEST['referredtoresourcessome'])) $referredtoresourcessome = true;
else $referredtoresourcessome = false;
if (!empty($_REQUEST['referredtoresourcesyes'])) $referredtoresourcesyes = true;
else $referredtoresourcesyes = false;
if (!empty($_REQUEST['criticalapproachnotrated'])) $criticalapproachnotrated = true;
else $criticalapproachnotrated = false;
if (!empty($_REQUEST['criticalapproachno'])) $criticalapproachno = true;
else $criticalapproachno = false;
if (!empty($_REQUEST['criticalapproachsome'])) $criticalapproachsome = true;
else $criticalapproachsome = false;
if (!empty($_REQUEST['criticalapproachyes'])) $criticalapproachyes = true;
else $criticalapproachyes = false;
if (!empty($_REQUEST['referencingnotrated'])) $referencingnotrated = true;
else $referencingnotrated = false;
if (!empty($_REQUEST['referencingnone'])) $referencingnone = true;
else $referencingnone = false;
if (!empty($_REQUEST['referencingwrongformat'])) $referencingwrongformat = true;
else $referencingwrongformat = false;
if (!empty($_REQUEST['referencinggood'])) $referencinggood = true;
else $referencinggood = false;

// If there are no URL or POST parameters, then default referencing checkboxes to TRUE
if (empty($_REQUEST['chosensemester'])) {
  $referredtoresourcesnotrated = true;
  $referredtoresourcesno = true;
  $referredtoresourcessome = true;
  $referredtoresourcesyes = true;
  $criticalapproachnotrated = true;
  $criticalapproachno = true;
  $criticalapproachsome = true;
  $criticalapproachyes = true;
  $referencingnotrated = true;
  $referencingnone = true;
  $referencingwrongformat = true;
  $referencinggood = true;
}


$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
	$listsemester[] = $semester->semester;
	if (!isset($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

$courses = $DB->get_records_sql(
"SELECT DISTINCT c.id AS courseid, c.fullname
FROM mdl_enrolment e, mdl_course c
WHERE e.courseid=c.id
ORDER BY fullname ASC"
);
if (!isset($chosenmodule)) $chosenmodule = 'All';
$listmodule[] = 'All';
foreach ($courses as $course) {
	$listmodule[] = htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8');
}

$studentsupportforumsnames = $DB->get_records('forum', array('course' => get_config(NULL, 'peoples_student_support_id')));
if (!isset($chosenssf)) $chosenssf = 'All';
$listssf[] = 'All';
foreach ($studentsupportforumsnames as $studentsupportforumsname) {
  $pos = stripos($studentsupportforumsname->name, 'Student Support Group');
  if ($pos === 0) {
    $listssf[] = htmlspecialchars($studentsupportforumsname->name, ENT_COMPAT, 'UTF-8');
  }
}
natsort($listssf);

$listacceptedmmu[] = 'Any';
if (!isset($acceptedmmu)) $acceptedmmu = 'Any';
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

if (!isset($averagereferredtoresources)) $averagereferredtoresources = 'Any';
$listaveragereferredtoresources[] = 'Any';
$listaveragereferredtoresources[] = 'No';
$listaveragereferredtoresources[] = 'Mixed';
$listaveragereferredtoresources[] = 'Yes';

if (!isset($averagecriticalapproach)) $averagecriticalapproach = 'Any';
$listaveragecriticalapproach[] = 'Any';
$listaveragecriticalapproach[] = 'No';
$listaveragecriticalapproach[] = 'Mixed';
$listaveragecriticalapproach[] = 'Yes';

if (!isset($averagereferencing)) $averagereferencing = 'Any';
$listaveragereferencing[] = 'Any';
$listaveragereferencing[] = 'None';
$listaveragereferencing[] = 'Mixed';
$listaveragereferencing[] = 'Good';


?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/posts.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
	<tr>
		<td>Semester</td>
		<td>Module</td>
    <td>Students from this SSF only</td>
    <td>User Name Contains</td>
    <td>Accepted MPH?</td>
		<td>Skip Introduction Topics</td>
		<td>Suppress Names on Posts by Student by Forum Topic Report for each Course (& use SID)</td>
		<td>Don't Show Number of Posts</td>
	</tr>
	<tr>
		<?php
		displayoptions('chosensemester', $listsemester, $chosensemester);
		displayoptions('chosenmodule', $listmodule, $chosenmodule);
    displayoptions('chosenssf', $listssf, $chosenssf);
    ?>
    <td><input type="text" size="15" name="chosenusersearch" value="<?php echo htmlspecialchars($chosenusersearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <?php
    displayoptions('acceptedmmu', $listacceptedmmu, $acceptedmmu);
		?>
		<td><input type="checkbox" name="skipintro" <?php if ($skipintro) echo ' CHECKED'; ?>></td>
		<td><input type="checkbox" name="suppressnames" <?php if ($suppressnames) echo ' CHECKED'; ?>></td>
		<td><input type="checkbox" name="showyesonly" <?php if ($showyesonly) echo ' CHECKED'; ?>></td>
	</tr>
</table>

<table border="2" cellpadding="2">
  <tr>
    <td></td>
    <td colspan="12">Ratings for Post</td>
    <td colspan="3">Average Rating of Rated Posts</td>
  </tr>

  <tr>
    <td></td>
    <td colspan="4">Referred to resources:</td>
    <td colspan="4">Critical approach:</td>
    <td colspan="4">Referencing:</td>
    <td colspan="3"></td>
  </tr>

  <tr>
    <td>Student has &lt;= this number of posts matching the filter</td>

    <td>Not rated</td>
    <td>No</td>
    <td>Some</td>
    <td>Yes</td>
    <td>Not rated</td>
    <td>No</td>
    <td>Some</td>
    <td>Yes</td>
    <td>Not rated</td>
    <td>None</td>
    <td>Wrong format</td>
    <td>Good</td>

    <td>Referred to resources:</td>
    <td>Critical approach:</td>
    <td>Referencing:</td>
  </tr>
  <tr>
    <td><input type="text" size="15" name="maximumposts" value="<?php echo $maximumposts; ?>" /></td>

    <td><input type="checkbox" name="referredtoresourcesnotrated" <?php if ($referredtoresourcesnotrated) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="referredtoresourcesno" <?php if ($referredtoresourcesno) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="referredtoresourcessome" <?php if ($referredtoresourcessome) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="referredtoresourcesyes" <?php if ($referredtoresourcesyes) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="criticalapproachnotrated" <?php if ($criticalapproachnotrated) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="criticalapproachno" <?php if ($criticalapproachno) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="criticalapproachsome" <?php if ($criticalapproachsome) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="criticalapproachyes" <?php if ($criticalapproachyes) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="referencingnotrated" <?php if ($referencingnotrated) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="referencingnone" <?php if ($referencingnone) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="referencingwrongformat" <?php if ($referencingwrongformat) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="referencinggood" <?php if ($referencinggood) echo ' CHECKED'; ?>></td>

    <?php
    displayoptions('averagereferredtoresources', $listaveragereferredtoresources, $averagereferredtoresources);
    displayoptions('averagecriticalapproach', $listaveragecriticalapproach, $averagecriticalapproach);
    displayoptions('averagereferencing', $listaveragereferencing, $averagereferencing);
    ?>
  </tr>
</table>

<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/posts.php">Reset Filters</a>
</form>
<br />
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


if (empty($chosensemester) || ($chosensemester == 'All')) {
  $chosensemester = 'All';
  $semestersql = 'AND e.semester!=?';
}
else {
  $semestersql = 'AND e.semester=?';
}
if (empty($chosenmodule) || ($chosenmodule == 'All')) {
  $chosenmodule = 'All';
  $modulesql = 'AND c.fullname!=?';
}
else {
  $modulesql = 'AND c.fullname=?';
}
if (empty($chosenssf) || ($chosenssf == 'All')) {
  $chosenssf = 'All';
  $ssfsql = '';
}
else {
  $chosenforumid = $DB->get_record('forum', array('name' => $chosenssf, 'course' => get_config(NULL, 'peoples_student_support_id')));

  // Look for all User Subscriptions to a Forum in the 'Student Support Forums' Course which are for Students Enrolled in the Course (not Tutors)
  // 20140515: Much of this is redundant, I think. Why not just use mdl_forum_subscriptions? In any case Admins/Tutors are ruled out by next query?
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


$enrols = $DB->get_records_sql(
"SELECT fp.id AS postid, fd.id AS discid, e.semester, u.id as userid, u.lastname, u.firstname, u.email, c.fullname, f.name AS forumname, fp.subject, m.id IS NOT NULL AS mph, m.datesubmitted AS mphdatestamp
FROM (mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp)
LEFT JOIN mdl_peoplesmph m ON e.userid=m.userid
WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id $semestersql $modulesql $ssfsql
ORDER BY e.semester, u.lastname ASC, u.firstname ASC, fullname ASC, forumname ASC, fp.subject ASC",
array($chosensemester, $chosenmodule)
);


// (more or less) Duplicate the query but now for ratings (separate query used to reduce re-testing)
$ratings = $DB->get_records_sql(
"SELECT
  r.id as ratingid, r.rating, r.scaleid,
  fp.id AS postid, fd.id AS discid, e.semester, u.id as userid, u.lastname, u.firstname, c.fullname, f.name AS forumname, fp.subject
FROM (mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp)
LEFT JOIN mdl_rating r ON fp.id=r.itemid
WHERE
  e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id $semestersql $modulesql $ssfsql AND
  r.component='mod_forum' AND r.ratingarea='post' AND
  r.scaleid IN({$CFG->scale_to_use_for_triple_rating}, {$CFG->scale_to_use_for_triple_rating_2}, {$CFG->scale_to_use_for_triple_rating_3})
ORDER BY fp.created",
array($chosensemester, $chosenmodule)
);


// (more or less) Duplicate the query but now for discussionfeedbacks (separate query used to reduce re-testing)
$discussionfeedbacks = $DB->get_records_sql("
SELECT
  fp.id AS postid, fd.id AS discid, e.semester, u.id as userid, u.lastname, u.firstname, u.email, c.fullname, f.name AS forumname, fp.subject,
  d.refered_to_resources, d.critical_approach, d.provided_references
FROM (mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp)
INNER JOIN mdl_discussionfeedback d ON e.userid=d.userid AND e.courseid=d.course_id
WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id $semestersql $modulesql $ssfsql",
array($chosensemester, $chosenmodule)
);
if (empty($discussionfeedbacks)) {
  $discussionfeedbacks = array();
}


// referredtoresources for Post
$actual_referredtoresources = array();
$actual_count_referredtoresources = array();
$actual_user_referredtoresources = array();
$actual_user_name_referredtoresources = array();
$actual_course_name_referredtoresources = array();
if (!empty($ratings)) {
  foreach ($ratings as $rating) {
    if ($rating->scaleid == $CFG->scale_to_use_for_triple_rating) {
      if (empty($actual_referredtoresources[$rating->postid])) {
        $actual_referredtoresources[$rating->postid] = 0.0 + $rating->rating;
        $actual_count_referredtoresources[$rating->postid] = 1.0;
        $actual_user_referredtoresources[$rating->postid] = $rating->userid;
        $actual_user_name_referredtoresources[$rating->postid] = htmlspecialchars(strtolower(trim($rating->lastname . ', ' . $rating->firstname)), ENT_COMPAT, 'UTF-8');
        $actual_course_name_referredtoresources[$rating->postid] = htmlspecialchars(strtolower(trim($rating->fullname)), ENT_COMPAT, 'UTF-8');
      }
      else {
        $actual_referredtoresources[$rating->postid] =
          (($actual_referredtoresources[$rating->postid] * $actual_count_referredtoresources[$rating->postid]) + $rating->rating) /
          ($actual_count_referredtoresources[$rating->postid] + 1.0);
        $actual_count_referredtoresources[$rating->postid] += 1.0;
      }
    }
  }
}

// Average referredtoresources for Student
$actual_averagereferredtoresources = array();
$actual_count_averagereferredtoresources = array();
if (!empty($actual_referredtoresources)) {
  foreach ($actual_referredtoresources as $postid => $item) {
    $student_to_get_average_for = $actual_user_referredtoresources[$postid];

    if (empty($actual_averagereferredtoresources[$student_to_get_average_for])) {
      $actual_averagereferredtoresources[$student_to_get_average_for] = 0.0 + $item;
      $actual_count_averagereferredtoresources[$student_to_get_average_for] = 1.0;
    }
    else {
      $actual_averagereferredtoresources[$student_to_get_average_for] =
        (($actual_averagereferredtoresources[$student_to_get_average_for] * $actual_count_averagereferredtoresources[$student_to_get_average_for]) + $item) /
        ($actual_count_averagereferredtoresources[$student_to_get_average_for] + 1.0);
      $actual_count_averagereferredtoresources[$student_to_get_average_for] += 1.0;
    }
  }
}

// Average referredtoresources for Student per Course
$actual_averagereferredtoresources_percourse = array();
$actual_count_averagereferredtoresources_percourse = array();
$actual_cumulatedreferredtoresources_percourse = array();
if (!empty($actual_referredtoresources)) {
  foreach ($actual_referredtoresources as $postid => $item) {

    $users_name = $actual_user_name_referredtoresources[$postid];
    $course_name = $actual_course_name_referredtoresources[$postid];
    $users_name_course_name = $users_name . 'XXX8167YYY' . $course_name;

    if (empty($actual_averagereferredtoresources_percourse[$users_name_course_name])) {
      $actual_averagereferredtoresources_percourse[$users_name_course_name] = 0.0 + $item;
      $actual_count_averagereferredtoresources_percourse[$users_name_course_name] = 1.0;
    }
    else {
      $actual_averagereferredtoresources_percourse[$users_name_course_name] =
        (($actual_averagereferredtoresources_percourse[$users_name_course_name] * $actual_count_averagereferredtoresources_percourse[$users_name_course_name]) + $item) /
        ($actual_count_averagereferredtoresources_percourse[$users_name_course_name] + 1.0);
      $actual_count_averagereferredtoresources_percourse[$users_name_course_name] += 1.0;
    }

    if     ($item < 1.01) $item_word = 'No';
    elseif ($item <=2.99) $item_word = 'Mixed';
    else                  $item_word = 'Yes';
    if (empty($actual_cumulatedreferredtoresources_percourse[$users_name_course_name])) {
      $actual_cumulatedreferredtoresources_percourse[$users_name_course_name] = "$item_word";
    }
    else {
      $actual_cumulatedreferredtoresources_percourse[$users_name_course_name] .= ", $item_word";
    }
  }
}

// criticalapproach for Post
$actual_criticalapproach = array();
$actual_count_criticalapproach = array();
$actual_user_criticalapproach = array();
$actual_user_name_criticalapproach = array();
$actual_course_name_criticalapproach = array();
if (!empty($ratings)) {
  foreach ($ratings as $rating) {
    if ($rating->scaleid == $CFG->scale_to_use_for_triple_rating_2) {
      if (empty($actual_criticalapproach[$rating->postid])) {
        $actual_criticalapproach[$rating->postid] = 0.0 + $rating->rating;
        $actual_count_criticalapproach[$rating->postid] = 1.0;
        $actual_user_criticalapproach[$rating->postid] = $rating->userid;
        $actual_user_name_criticalapproach[$rating->postid] = htmlspecialchars(strtolower(trim($rating->lastname . ', ' . $rating->firstname)), ENT_COMPAT, 'UTF-8');
        $actual_course_name_criticalapproach[$rating->postid] = htmlspecialchars(strtolower(trim($rating->fullname)), ENT_COMPAT, 'UTF-8');
      }
      else {
        $actual_criticalapproach[$rating->postid] =
          (($actual_criticalapproach[$rating->postid] * $actual_count_criticalapproach[$rating->postid]) + $rating->rating) /
          ($actual_count_criticalapproach[$rating->postid] + 1.0);
        $actual_count_criticalapproach[$rating->postid] += 1.0;
      }
    }
  }
}

// Average criticalapproach for Student
$actual_averagecriticalapproach = array();
$actual_count_averagecriticalapproach = array();
if (!empty($actual_criticalapproach)) {
  foreach ($actual_criticalapproach as $postid => $item) {
    $student_to_get_average_for = $actual_user_criticalapproach[$postid];

    if (empty($actual_averagecriticalapproach[$student_to_get_average_for])) {
      $actual_averagecriticalapproach[$student_to_get_average_for] = 0.0 + $item;
      $actual_count_averagecriticalapproach[$student_to_get_average_for] = 1.0;
    }
    else {
      $actual_averagecriticalapproach[$student_to_get_average_for] =
        (($actual_averagecriticalapproach[$student_to_get_average_for] * $actual_count_averagecriticalapproach[$student_to_get_average_for]) + $item) /
        ($actual_count_averagecriticalapproach[$student_to_get_average_for] + 1.0);
      $actual_count_averagecriticalapproach[$student_to_get_average_for] += 1.0;
    }
  }
}

// Average criticalapproach for Student per Course
$actual_averagecriticalapproach_percourse = array();
$actual_count_averagecriticalapproach_percourse = array();
$actual_cumulatedcriticalapproach_percourse = array();
if (!empty($actual_criticalapproach)) {
  foreach ($actual_criticalapproach as $postid => $item) {

    $users_name = $actual_user_name_criticalapproach[$postid];
    $course_name = $actual_course_name_criticalapproach[$postid];
    $users_name_course_name = $users_name . 'XXX8167YYY' . $course_name;

    if (empty($actual_averagecriticalapproach_percourse[$users_name_course_name])) {
      $actual_averagecriticalapproach_percourse[$users_name_course_name] = 0.0 + $item;
      $actual_count_averagecriticalapproach_percourse[$users_name_course_name] = 1.0;
    }
    else {
      $actual_averagecriticalapproach_percourse[$users_name_course_name] =
        (($actual_averagecriticalapproach_percourse[$users_name_course_name] * $actual_count_averagecriticalapproach_percourse[$users_name_course_name]) + $item) /
        ($actual_count_averagecriticalapproach_percourse[$users_name_course_name] + 1.0);
      $actual_count_averagecriticalapproach_percourse[$users_name_course_name] += 1.0;
    }

    if     ($item < 1.01) $item_word = 'No';
    elseif ($item <=2.99) $item_word = 'Mixed';
    else                  $item_word = 'Yes';
    if (empty($actual_cumulatedcriticalapproach_percourse[$users_name_course_name])) {
      $actual_cumulatedcriticalapproach_percourse[$users_name_course_name] = "$item_word";
    }
    else {
      $actual_cumulatedcriticalapproach_percourse[$users_name_course_name] .= ", $item_word";
    }
  }
}

// referencing for Post
$actual_referencing = array();
$actual_count_referencing = array();
$actual_user_referencing = array();
$actual_user_name_referencing = array();
$actual_course_name_referencing = array();
if (!empty($ratings)) {
  foreach ($ratings as $rating) {
    if ($rating->scaleid == $CFG->scale_to_use_for_triple_rating_3) {
      if (empty($actual_referencing[$rating->postid])) {
        $actual_referencing[$rating->postid] = 0.0 + $rating->rating;
        $actual_count_referencing[$rating->postid] = 1.0;
        $actual_user_referencing[$rating->postid] = $rating->userid;
        $actual_user_name_referencing[$rating->postid] = htmlspecialchars(strtolower(trim($rating->lastname . ', ' . $rating->firstname)), ENT_COMPAT, 'UTF-8');
        $actual_course_name_referencing[$rating->postid] = htmlspecialchars(strtolower(trim($rating->fullname)), ENT_COMPAT, 'UTF-8');
      }
      else {
        $actual_referencing[$rating->postid] =
          (($actual_referencing[$rating->postid] * $actual_count_referencing[$rating->postid]) + $rating->rating) /
          ($actual_count_referencing[$rating->postid] + 1.0);
        $actual_count_referencing[$rating->postid] += 1.0;
      }
    }
  }
}

// Average referencing for Student
$actual_averagereferencing = array();
$actual_count_averagereferencing = array();
if (!empty($actual_referencing)) {
  foreach ($actual_referencing as $postid => $item) {
    $student_to_get_average_for = $actual_user_referencing[$postid];

    if (empty($actual_averagereferencing[$student_to_get_average_for])) {
      $actual_averagereferencing[$student_to_get_average_for] = 0.0 + $item;
      $actual_count_averagereferencing[$student_to_get_average_for] = 1.0;
    }
    else {
      $actual_averagereferencing[$student_to_get_average_for] =
        (($actual_averagereferencing[$student_to_get_average_for] * $actual_count_averagereferencing[$student_to_get_average_for]) + $item) /
        ($actual_count_averagereferencing[$student_to_get_average_for] + 1.0);
      $actual_count_averagereferencing[$student_to_get_average_for] += 1.0;
    }
  }
}

// Average referencing for Student per Course
$actual_averagereferencing_percourse = array();
$actual_count_averagereferencing_percourse = array();
$actual_cumulatedreferencing_percourse = array();
if (!empty($actual_referencing)) {
  foreach ($actual_referencing as $postid => $item) {

    $users_name = $actual_user_name_referencing[$postid];
    $course_name = $actual_course_name_referencing[$postid];
    $users_name_course_name = $users_name . 'XXX8167YYY' . $course_name;

    if (empty($actual_averagereferencing_percourse[$users_name_course_name])) {
      $actual_averagereferencing_percourse[$users_name_course_name] = 0.0 + $item;
      $actual_count_averagereferencing_percourse[$users_name_course_name] = 1.0;
    }
    else {
      $actual_averagereferencing_percourse[$users_name_course_name] =
        (($actual_averagereferencing_percourse[$users_name_course_name] * $actual_count_averagereferencing_percourse[$users_name_course_name]) + $item) /
        ($actual_count_averagereferencing_percourse[$users_name_course_name] + 1.0);
      $actual_count_averagereferencing_percourse[$users_name_course_name] += 1.0;
    }

    if     ($item < 1.01) $item_word = 'None';
    elseif ($item <=2.99) $item_word = 'Mixed';
    else                  $item_word = 'Good';
    if (empty($actual_cumulatedreferencing_percourse[$users_name_course_name])) {
      $actual_cumulatedreferencing_percourse[$users_name_course_name] = "$item_word";
    }
    else {
      $actual_cumulatedreferencing_percourse[$users_name_course_name] .= ", $item_word";
    }
  }
}


$sidsbyuseridsemester = $DB->get_records_sql('SELECT CONCAT(userid, semester) AS i, sid FROM mdl_peoplesapplication WHERE (((state & 0x38)>>3)=3 OR (state & 0x7)=3)');

$table = new html_table();
$table->head = array(
  'Family name',
  'Given name',
  'Module',
  'Semester',
  'Discussion Forum Topic',
  'Subject',
  'Referred to resources:',
  'Critical approach:',
  'Referencing:',
  'Write discussion feedback for student...'
  );

$usercount = array();
$usercountid = array();
$students_to_ignore = array();
$usermodulecount = array();
$topiccount = array();
$user_actual_averagereferredtoresources = array();
$user_actual_averagecriticalapproach = array();
$user_actual_averagereferencing = array();
$listofemails = array();
$post_matching_main_sql_filters_found = array();
$user_actual_averagereferredtoresources_percourse = array();
$user_actual_averagecriticalapproach_percourse = array();
$user_actual_averagereferencing_percourse = array();
$n = 0;
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {
    $post_matching_main_sql_filters_found[$enrol->userid] = TRUE;

    if (!empty($chosenusersearch) &&
      stripos($enrol->lastname, $chosenusersearch) === false &&
      stripos($enrol->firstname, $chosenusersearch) === false) {
      continue;
    }

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

		if ($skipintro && (substr(strtolower(trim(strip_tags($enrol->forumname))), 0, 12) === 'introduction')) {
				continue;
		}

    $actual_referredtoresourcesnotrated = false;
    $actual_referredtoresourcesno = false;
    $actual_referredtoresourcessome = false;
    $actual_referredtoresourcesyes = false;
    if (empty($actual_referredtoresources[$enrol->postid])) $actual_referredtoresourcesnotrated = true;
    elseif ($actual_referredtoresources[$enrol->postid] < 1.01) $actual_referredtoresourcesno = true;
    elseif ($actual_referredtoresources[$enrol->postid] <=2.99) $actual_referredtoresourcessome = true;
    else $actual_referredtoresourcesyes = true;
    $include_post =
      ($referredtoresourcesnotrated && $actual_referredtoresourcesnotrated) ||
      ($referredtoresourcesno && $actual_referredtoresourcesno) ||
      ($referredtoresourcessome && $actual_referredtoresourcessome) ||
      ($referredtoresourcesyes && $actual_referredtoresourcesyes);
    if (!$include_post) continue;

    $actual_criticalapproachnotrated = false;
    $actual_criticalapproachno = false;
    $actual_criticalapproachsome = false;
    $actual_criticalapproachyes = false;
    if (empty($actual_criticalapproach[$enrol->postid])) $actual_criticalapproachnotrated = true;
    elseif ($actual_criticalapproach[$enrol->postid] < 1.01) $actual_criticalapproachno = true;
    elseif ($actual_criticalapproach[$enrol->postid] <=2.99) $actual_criticalapproachsome = true;
    else $actual_criticalapproachyes = true;
    $include_post =
      ($criticalapproachnotrated && $actual_criticalapproachnotrated) ||
      ($criticalapproachno && $actual_criticalapproachno) ||
      ($criticalapproachsome && $actual_criticalapproachsome) ||
      ($criticalapproachyes && $actual_criticalapproachyes);
    if (!$include_post) continue;

    $actual_referencingnotrated = false;
    $actual_referencingnone = false;
    $actual_referencingwrongformat = false;
    $actual_referencinggood = false;
    if (empty($actual_referencing[$enrol->postid])) $actual_referencingnotrated = true;
    elseif ($actual_referencing[$enrol->postid] < 1.01) $actual_referencingnone = true;
    elseif ($actual_referencing[$enrol->postid] <=2.99) $actual_referencingwrongformat = true;
    else $actual_referencinggood = true;
    $include_post =
      ($referencingnotrated && $actual_referencingnotrated) ||
      ($referencingnone && $actual_referencingnone) ||
      ($referencingwrongformat && $actual_referencingwrongformat) ||
      ($referencinggood && $actual_referencinggood);
    if (!$include_post) continue;

    $include_post =
      (($averagereferredtoresources == 'Any') ) ||
      (($averagereferredtoresources == 'No') && ($actual_averagereferredtoresources[$enrol->userid] < 1.01)) ||
      (($averagereferredtoresources == 'Mixed') && (($actual_averagereferredtoresources[$enrol->userid] >=1.01) && ($actual_averagereferredtoresources[$enrol->userid] <=2.99))) ||
      (($averagereferredtoresources == 'Yes') && ($actual_averagereferredtoresources[$enrol->userid] > 2.99));
    if (!$include_post) continue;

    $include_post =
      (($averagecriticalapproach == 'Any') ) ||
      (($averagecriticalapproach == 'No') && ($actual_averagecriticalapproach[$enrol->userid] < 1.01)) ||
      (($averagecriticalapproach == 'Mixed') && (($actual_averagecriticalapproach[$enrol->userid] >=1.01) && ($actual_averagecriticalapproach[$enrol->userid] <=2.99))) ||
      (($averagecriticalapproach == 'Yes') && ($actual_averagecriticalapproach[$enrol->userid] > 2.99));
    if (!$include_post) continue;

    $include_post =
      (($averagereferencing == 'Any') ) ||
      (($averagereferencing == 'None') && ($actual_averagereferencing[$enrol->userid] < 1.01)) ||
      (($averagereferencing == 'Mixed') && (($actual_averagereferencing[$enrol->userid] >=1.01) && ($actual_averagereferencing[$enrol->userid] <=2.99))) ||
      (($averagereferencing == 'Good') && ($actual_averagereferencing[$enrol->userid] > 2.99));
    if (!$include_post) continue;


    $rowdata = array();
    $rowdata[] = htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8');
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/mod/forum/discuss.php?d=' . $enrol->discid . '#p' . $enrol->postid . '" target="_blank">' . htmlspecialchars($enrol->subject, ENT_COMPAT, 'UTF-8') . '</a>';

    if ($actual_referredtoresourcesnotrated) $rowdata[] = 'Not rated';
    if ($actual_referredtoresourcesno) $rowdata[] = 'No';
    if ($actual_referredtoresourcessome) $rowdata[] = 'Some';
    if ($actual_referredtoresourcesyes) $rowdata[] = 'Yes';

    if ($actual_criticalapproachnotrated) $rowdata[] = 'Not rated';
    if ($actual_criticalapproachno) $rowdata[] = 'No';
    if ($actual_criticalapproachsome) $rowdata[] = 'Some';
    if ($actual_criticalapproachyes) $rowdata[] = 'Yes';

    if ($actual_referencingnotrated) $rowdata[] = 'Not rated';
    if ($actual_referencingnone) $rowdata[] = 'None';
    if ($actual_referencingwrongformat) $rowdata[] = 'Wrong format';
    if ($actual_referencinggood) $rowdata[] = 'Good';

    $spancolour = '<span>';
    if (!empty($discussionfeedbacks[$enrol->postid])) {
      if     ($discussionfeedbacks[$enrol->postid]->refered_to_resources == 10 &&
              $discussionfeedbacks[$enrol->postid]->critical_approach == 10 &&
              $discussionfeedbacks[$enrol->postid]->provided_references == 10) {
        $spancolour = '<span style="color:green">';
      }
      elseif ($discussionfeedbacks[$enrol->postid]->refered_to_resources == 20 &&
              $discussionfeedbacks[$enrol->postid]->critical_approach == 20 &&
              $discussionfeedbacks[$enrol->postid]->provided_references == 20) {
        $spancolour = '<span style="color:red">';
      }
      else {
        $spancolour = '<span style="color:#FF8C00">';
      }
    }
    $rowdata[] = '<a href="' . $CFG->wwwroot . '/course/discussionfeedback_for_student.php?userid=' . $enrol->userid . '" target="_blank">' . $spancolour . 'Write discussion feedback</span></a>';


		$hashforcourse = htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8');
		$courseswithstudentforumstats[$hashforcourse]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;

		$hashforstudent = $enrol->userid;
		if (empty($courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent])) {
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['last'] = '<td>' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['first'] = '<td>' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['course'] = '<td>' . htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['userid'] = $enrol->userid;
			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['semester'] = $enrol->semester;


			$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;
		}
		else {
			if (empty($courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>'])) {
				$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>'] = 1;
			}
			else {
				$courseswithstudentforumstats[$hashforcourse]['students'][$hashforstudent]['forums']['<td>' . htmlspecialchars($enrol->forumname, ENT_COMPAT, 'UTF-8') . '</td>']++;
			}
		}


		$name = htmlspecialchars(strtolower(trim($enrol->lastname . ', ' . $enrol->firstname)), ENT_COMPAT, 'UTF-8');
		if (empty($usercount[$name])) {
			$usercount[$name] = 1;
		}
		else {
			$usercount[$name]++;
		}

    if (empty($usercountid[$enrol->userid])) { // Same as above but indexed by userid for safety
      $usercountid[$enrol->userid] = 1;
    }
    else {
      $usercountid[$enrol->userid]++;
    }

    if (empty($actual_averagereferredtoresources[$enrol->userid])) $user_actual_averagereferredtoresources[$name] =  'Not rated';
    elseif ($actual_averagereferredtoresources[$enrol->userid] < 1.01) $user_actual_averagereferredtoresources[$name] = 'No';
    elseif ($actual_averagereferredtoresources[$enrol->userid] <=2.99) $user_actual_averagereferredtoresources[$name] = 'Mixed';
    else $user_actual_averagereferredtoresources[$name] = 'Yes';

    if (empty($actual_averagecriticalapproach[$enrol->userid])) $user_actual_averagecriticalapproach[$name] =  'Not rated';
    elseif ($actual_averagecriticalapproach[$enrol->userid] < 1.01) $user_actual_averagecriticalapproach[$name] = 'No';
    elseif ($actual_averagecriticalapproach[$enrol->userid] <=2.99) $user_actual_averagecriticalapproach[$name] = 'Mixed';
    else $user_actual_averagecriticalapproach[$name] = 'Yes';

    if (empty($actual_averagereferencing[$enrol->userid])) $user_actual_averagereferencing[$name] =  'Not rated';
    elseif ($actual_averagereferencing[$enrol->userid] < 1.01) $user_actual_averagereferencing[$name] = 'None';
    elseif ($actual_averagereferencing[$enrol->userid] <=2.99) $user_actual_averagereferencing[$name] = 'Mixed';
    else $user_actual_averagereferencing[$name] = 'Good';

		$name = htmlspecialchars(strtolower(trim($enrol->lastname . ', ' . $enrol->firstname . ', ' . $enrol->fullname)), ENT_COMPAT, 'UTF-8');
		if (empty($usermodulecount[$name])) {
			$usermodulecount[$name] = 1;
		}
		else {
			$usermodulecount[$name]++;
		}

		$name = htmlspecialchars(strtolower(trim($enrol->fullname . ', ' . $enrol->forumname)), ENT_COMPAT, 'UTF-8');
		if (empty($topiccount[$name])) {
			$topiccount[$name] = 1;
		}
		else {
			$topiccount[$name]++;
		}

    $users_name = htmlspecialchars(strtolower(trim($enrol->lastname . ', ' . $enrol->firstname)), ENT_COMPAT, 'UTF-8');
    $course_name = htmlspecialchars(strtolower(trim($enrol->fullname)), ENT_COMPAT, 'UTF-8');
    $users_name_course_name = $users_name . 'XXX8167YYY' . $course_name;

    if (empty($actual_averagereferredtoresources_percourse[$users_name_course_name])) $user_actual_averagereferredtoresources_percourse[$users_name_course_name] =  'Not rated';
    elseif ($actual_averagereferredtoresources_percourse[$users_name_course_name] < 1.01) $user_actual_averagereferredtoresources_percourse[$users_name_course_name] = 'No';
    elseif ($actual_averagereferredtoresources_percourse[$users_name_course_name] <=2.99) $user_actual_averagereferredtoresources_percourse[$users_name_course_name] = 'Mixed';
    else $user_actual_averagereferredtoresources_percourse[$users_name_course_name] = 'Yes';

    if (empty($actual_averagecriticalapproach_percourse[$users_name_course_name])) $user_actual_averagecriticalapproach_percourse[$users_name_course_name] =  'Not rated';
    elseif ($actual_averagecriticalapproach_percourse[$users_name_course_name] < 1.01) $user_actual_averagecriticalapproach_percourse[$users_name_course_name] = 'No';
    elseif ($actual_averagecriticalapproach_percourse[$users_name_course_name] <=2.99) $user_actual_averagecriticalapproach_percourse[$users_name_course_name] = 'Mixed';
    else $user_actual_averagecriticalapproach_percourse[$users_name_course_name] = 'Yes';

    if (empty($actual_averagereferencing_percourse[$users_name_course_name])) $user_actual_averagereferencing_percourse[$users_name_course_name] =  'Not rated';
    elseif ($actual_averagereferencing_percourse[$users_name_course_name] < 1.01) $user_actual_averagereferencing_percourse[$users_name_course_name] = 'None';
    elseif ($actual_averagereferencing_percourse[$users_name_course_name] <=2.99) $user_actual_averagereferencing_percourse[$users_name_course_name] = 'Mixed';
    else $user_actual_averagereferencing_percourse[$users_name_course_name] = 'Good';

		$n++;
    $rowdata[] = $enrol->userid; // Will be removed below
    $table->data[] = $rowdata;

    $listofemails[$enrol->userid] = htmlspecialchars($enrol->email, ENT_COMPAT, 'UTF-8');
	}

  // Remove table rows for which the Student has (in total) <= $maximumposts matching the filter
  $useridkey = count($rowdata) - 1;
  foreach ($table->data as $key => $row) {
    $userid_for_row = $table->data[$key][$useridkey];

    unset($table->data[$key][$useridkey]); // userid Remove from the table so it does not add an unwanted column

    if ($usercountid[$userid_for_row] > $maximumposts) {
      $n--;
      unset($table->data[$key]);
      unset($listofemails[$userid_for_row]);
    }
  }

  foreach ($usercountid as $userid => $row) { // Now remove from stats
    if ($usercountid[$userid] > $maximumposts) {
      $students_to_ignore[] = $userid;
    }
  }
}
echo html_writer::table($table);
echo '<br/>Number of Forum Postings: ' . $n;
echo '<br /><br />';


ksort($courseswithstudentforumstats);
foreach ($courseswithstudentforumstats as $coursekey => $coursewithstudentforumstats) {
	echo '<b>Posts by Student by Forum Topic for: ' . $coursekey . '...</b><br />';

	echo '<table border="1" BORDERCOLOR="RED">';
	echo '<tr>';
	if ($suppressnames) echo '<td>SID</td>';
	else echo '<td></td><td></td>';

	ksort($coursewithstudentforumstats['forums']);
	foreach ($coursewithstudentforumstats['forums'] as $forumkey => $anything) {
		echo $forumkey;
	}
	echo '</tr>';

  foreach ($coursewithstudentforumstats['students'] as $userid => $studententry) {
    if (in_array($userid, $students_to_ignore)) continue;

		echo '<tr>';
		if ($suppressnames) echo '<td>' . $sidsbyuseridsemester[$studententry['userid'] . $studententry['semester']]->sid . '</td>';
		else echo $studententry['last'] . $studententry['first'];

		foreach ($coursewithstudentforumstats['forums'] as $forumkey => $anything) {
			if (empty($studententry['forums'][$forumkey])) echo '<td></td>';
			elseif ($showyesonly) echo '<td>Yes</td>';
			else echo '<td>' . $studententry['forums'][$forumkey] . '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	echo '<br /><br />';
}
echo '<br />';


$usermodulecountnonzero = 0;
$usercountnonzero = 0;
$students_with_zero_posts = array();
$listofemails_for_students_with_zero_posts = array();
if (!empty($enrols)) {

  // We want to display Student/Module combinations that have Zero Posts (in the summary statistics)
  $all_usermodules = $DB->get_records_sql(
    "SELECT DISTINCT CONCAT(u.id, 'X', c.id) AS ucindex, u.id AS userid, u.lastname, u.firstname, c.fullname
    FROM (mdl_enrolment e, mdl_user u, mdl_course c)
    WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id $semestersql $modulesql $ssfsql
    ORDER BY u.lastname ASC, u.firstname ASC, fullname ASC",
    array($chosensemester, $chosenmodule)
  );
  if (!empty($all_usermodules)) {
    foreach ($all_usermodules as $all_usermodule) {
      $name = htmlspecialchars(strtolower(trim($all_usermodule->lastname . ', ' . $all_usermodule->firstname . ', ' . $all_usermodule->fullname)), ENT_COMPAT, 'UTF-8');
      if (empty($usermodulecount[$name])) $usermodulecount[$name] = 0;

      if (in_array($all_usermodule->userid, $students_to_ignore)) {
        unset($usermodulecount[$name]);
      }
      elseif ($usermodulecount[$name] != 0) $usermodulecountnonzero++;
    }
  }

  // We want to display Students that have Zero Posts (in the summary statistics)
  $all_users = $DB->get_records_sql(
    "SELECT DISTINCT u.id as userid, u.lastname, u.firstname, u.email
    FROM (mdl_enrolment e, mdl_user u, mdl_course c)
    WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id $semestersql $modulesql $ssfsql
    ORDER BY u.lastname ASC, u.firstname ASC",
    array($chosensemester, $chosenmodule)
  );
  if (!empty($all_users)) {
    foreach ($all_users as $all_user) {
      $name = htmlspecialchars(strtolower(trim($all_user->lastname . ', ' . $all_user->firstname)), ENT_COMPAT, 'UTF-8');
      if (empty($usercount[$name])) {
        $usercount[$name] = 0;

        $user_actual_averagereferredtoresources[$name] =  'No posts';
        $user_actual_averagecriticalapproach[$name] =  'No posts';
        $user_actual_averagereferencing[$name] =  'No posts';

        $user_actual_averagereferredtoresources_percourse[$name . 'XXX8167YYY'] =  'No posts'; // (an empty course)
        $user_actual_averagecriticalapproach_percourse[$name . 'XXX8167YYY'] =  'No posts'; // (an empty course)
        $user_actual_averagereferencing_percourse[$name . 'XXX8167YYY'] =  'No posts'; // (an empty course)
      }

      if (in_array($all_user->userid, $students_to_ignore)) {
        unset($usercount[$name]);
        unset($user_actual_averagereferredtoresources[$name]);
        unset($user_actual_averagecriticalapproach[$name]);
        unset($user_actual_averagereferencing[$name]);

        unset($user_actual_averagereferredtoresources_percourse[$name . 'XXX8167YYY']); // Will only remove "No posts" ones
        unset($user_actual_averagecriticalapproach_percourse[$name . 'XXX8167YYY']); // Will only remove "No posts" ones
        unset($user_actual_averagereferencing_percourse[$name . 'XXX8167YYY']); // Will only remove "No posts" ones
      }
      elseif ($usercount[$name] != 0) $usercountnonzero++;

      if (empty($post_matching_main_sql_filters_found[$all_user->userid])) {
        // Students who have zero posts matching the main filters (Semester, Module, SSF)
        // (But they could have other posts)
        // Also there could be some students with zero posts who should have been filtered out by other filters (e.g. name)

        // currently not used (display e-mails instead)...
        $students_with_zero_posts[$name . 'XYZIDXYZ' . $all_user->userid] = array('lastname' => $all_user->lastname, 'firstname' => $all_user->firstname, 'userid' => $all_user->userid);

        $listofemails_for_students_with_zero_posts[$all_user->userid] = htmlspecialchars($all_user->email, ENT_COMPAT, 'UTF-8');
      }
    }
  }
}

displaystat($usercount, 'Student Posts');
echo 'Number of Students who Posted: ' . $usercountnonzero;
echo '<br /><br />';

displaystat($usermodulecount, 'Student Posts per Module');
echo 'Number of Students who Posted per Module: ' . $usermodulecountnonzero;
echo '<br /><br />';

if ($maximumposts >= 99999) { // Will be wrong if some posts should not be counted
  displaystat($topiccount, 'Student Posts by Forum Topic');
  echo 'Number of Forum Topics with Posts: ' . count($topiccount);
  echo '<br /><br />';
}

displaystat_split_name($user_actual_averagereferredtoresources, "Summary 'Referred to resources' for Student");
echo '<br /><br />';

displaystat_split_name($user_actual_averagecriticalapproach, "Summary 'Critical approach' for Student");
echo '<br /><br />';

displaystat_split_name($user_actual_averagereferencing, "Summary 'Referencing' for Student");
echo '<br /><br />';

displaystat_split_name_and_course_with_cumulated($user_actual_averagereferredtoresources_percourse, "Summary 'Referred to resources' for Student per Module", $actual_cumulatedreferredtoresources_percourse);
echo '<br /><br />';

displaystat_split_name_and_course_with_cumulated($user_actual_averagecriticalapproach_percourse, "Summary 'Critical approach' for Student per Module", $actual_cumulatedcriticalapproach_percourse);
echo '<br /><br />';

displaystat_split_name_and_course_with_cumulated($user_actual_averagereferencing_percourse, "Summary 'Referencing' for Student per Module", $actual_cumulatedreferencing_percourse);
echo '<br /><br />';

natcasesort($listofemails);
echo 'e-mails of Selected Students...<br />' . implode(', ', array_unique($listofemails));
echo '<br /><br />';

if (!empty($listofemails_for_students_with_zero_posts)) {
  natcasesort($listofemails_for_students_with_zero_posts);

  echo 'e-mails of Students who have zero posts matching the main filters (Semester, Module, SSF)...<br />';
  echo '(note: if you have used other filters beyond those main ones,<br />';
  echo 'e-mails that should be hidden because of those additional filters might still be listed)<br />';
  echo implode(', ', array_unique($listofemails_for_students_with_zero_posts));
}


echo '<br /><br /><br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

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


function displaystat_split_name($stat, $title) {
  echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
  echo "<tr>";
  echo "<td>$title</td>";
  echo "<td>(Given name)</td>";
  echo "<td>Rating summary for posts</td>";
  echo "</tr>";

  ksort($stat);

  foreach ($stat as $key => $number) {

    $pos = strpos($key, ', ');
    $key_family = substr($key, 0, $pos);
    $key_given  = substr($key, $pos + 2);

    echo "<tr>";
    echo "<td>" . $key_family . "</td>";
    echo "<td>" . $key_given . "</td>";
    echo "<td>" . $number . "</td>";
    echo "</tr>";
  }
  echo '</table>';
  echo '<br/>';
}


function displaystat_split_name_and_course_with_cumulated($stat, $title, $cumulated) {
  echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
  echo "<tr>";
  echo "<td>$title</td>";
  echo "<td>(Given name)</td>";
  echo "<td>Module</td>";
  echo "<td>Rating sequence for posts in module</td>";
  echo "<td>Rating summary for posts in module</td>";
  echo "</tr>";

  ksort($stat);

  foreach ($stat as $key => $number) {

    $pos = strpos($key, ', ');
    $pos_xxx = strpos($key, 'XXX8167YYY');
    $key_family = substr($key, 0, $pos);
    $key_given  = substr($key, $pos + 2, $pos_xxx - $pos -2);
    $key_module = substr($key, $pos_xxx + 10);

    echo "<tr>";
    echo "<td>" . $key_family . "</td>";
    echo "<td>" . $key_given . "</td>";
    echo "<td>" . $key_module . "</td>";
    if (!empty($cumulated[$key])) {
      $cumulated_value = $cumulated[$key];
    }
    else {
      $cumulated_value = '';
    }
    echo "<td>" . $cumulated_value . "</td>";
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
      r.shortname IN ('tutor', 'tutors', 'edu_officer', 'edu_officer_old') AND
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
