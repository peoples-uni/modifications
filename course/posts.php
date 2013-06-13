<?php  // $Id: posts.php,v 1.1 2008/12/15 22:33:00 alanbarrett Exp $
/**
*
* Lists Forum Posts
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
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

if (!empty($_REQUEST['maximumposts'])) $maximumposts = (int)dontstripslashes($_REQUEST['maximumposts']);
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
  $listssf[] = htmlspecialchars($studentsupportforumsname->name, ENT_COMPAT, 'UTF-8');
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
$listaveragereferencing[] = 'No';
$listaveragereferencing[] = 'Mixed';
$listaveragereferencing[] = 'Yes';


?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/posts.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
	<tr>
		<td>Semester</td>
		<td>Module</td>
    <td>Students from this SSF only</td>
    <td>User Name Contains</td>
    <td>Accepted MMU?</td>
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
  $chosenforumid = $DB->get_record('forum', array('name' => $chosenssf));

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
          SELECT userid from mdl_user_enrolments where enrolid=?
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
  r.scaleid IN({$CFG->scale_to_use_for_triple_rating}, {$CFG->scale_to_use_for_triple_rating_2}, {$CFG->scale_to_use_for_triple_rating_3})",
array($chosensemester, $chosenmodule)
);

// referredtoresources for Post
$actual_referredtoresources = array();
$actual_count_referredtoresources = array();
$actual_user_referredtoresources = array();
if (!empty($ratings)) {
  foreach ($ratings as $rating) {
    if ($rating->scaleid == $CFG->scale_to_use_for_triple_rating) {
      if (empty($actual_referredtoresources[$rating->postid])) {
        $actual_referredtoresources[$rating->postid] = 0.0 + $rating->rating;
        $actual_count_referredtoresources[$rating->postid] = 1.0;
        $actual_user_referredtoresources[$rating->postid] = $rating->userid;
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

// criticalapproach for Post
$actual_criticalapproach = array();
$actual_count_criticalapproach = array();
$actual_user_criticalapproach = array();
if (!empty($ratings)) {
  foreach ($ratings as $rating) {
    if ($rating->scaleid == $CFG->scale_to_use_for_triple_rating) {
      if (empty($actual_criticalapproach[$rating->postid])) {
        $actual_criticalapproach[$rating->postid] = 0.0 + $rating->rating;
        $actual_count_criticalapproach[$rating->postid] = 1.0;
        $actual_user_criticalapproach[$rating->postid] = $rating->userid;
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

// referencing for Post
$actual_referencing = array();
$actual_count_referencing = array();
$actual_user_referencing = array();
if (!empty($ratings)) {
  foreach ($ratings as $rating) {
    if ($rating->scaleid == $CFG->scale_to_use_for_triple_rating) {
      if (empty($actual_referencing[$rating->postid])) {
        $actual_referencing[$rating->postid] = 0.0 + $rating->rating;
        $actual_count_referencing[$rating->postid] = 1.0;
        $actual_user_referencing[$rating->postid] = $rating->userid;
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
  ''
  );

$usercount = array();
$usercount_key_list = array();
$usercountid = array();
$usermodulecount = array();
$usermodulecount_key_list = array();
$topiccount = array();
$topiccount_key_list = array();
$user_actual_averagereferredtoresources = array();
$user_actual_averagecriticalapproach = array();
$user_actual_averagereferencing = array();
$listofemails = array();
$n = 0;
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {

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
    $actual_referencingno = false;
    $actual_referencingsome = false;
    $actual_referencingyes = false;
    if (empty($actual_referencing[$enrol->postid])) $actual_referencingnotrated = true;
    elseif ($actual_referencing[$enrol->postid] < 1.01) $actual_referencingno = true;
    elseif ($actual_referencing[$enrol->postid] <=2.99) $actual_referencingsome = true;
    else $actual_referencingyes = true;
    $include_post =
      ($referencingnotrated && $actual_referencingnotrated) ||
      ($referencingno && $actual_referencingno) ||
      ($referencingsome && $actual_referencingsome) ||
      ($referencingyes && $actual_referencingyes);
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
      (($averagereferencing == 'No') && ($actual_averagereferencing[$enrol->userid] < 1.01)) ||
      (($averagereferencing == 'Mixed') && (($actual_averagereferencing[$enrol->userid] >=1.01) && ($actual_averagereferencing[$enrol->userid] <=2.99))) ||
      (($averagereferencing == 'Yes') && ($actual_averagereferencing[$enrol->userid] > 2.99));
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
    if ($actual_referencingno) $rowdata[] = 'None';
    if ($actual_referencingsome) $rowdata[] = 'Wrong format';
    if ($actual_referencingyes) $rowdata[] = 'Good';

    $rowdata[] = '<a href="' . $CFG->wwwroot . '/course/discussionfeedback_for_student.php?userid=' . $enrol->userid . '" target="_blank">Write discussion feedback for student</a>';


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
    $usercount_key_list[$enrol->userid] = $name;
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
    elseif ($actual_averagereferencing[$enrol->userid] < 1.01) $user_actual_averagereferencing[$name] = 'No';
    elseif ($actual_averagereferencing[$enrol->userid] <=2.99) $user_actual_averagereferencing[$name] = 'Mixed';
    else $user_actual_averagereferencing[$name] = 'Yes';

		$name = htmlspecialchars(strtolower(trim($enrol->lastname . ', ' . $enrol->firstname . ', ' . $enrol->fullname)), ENT_COMPAT, 'UTF-8');
    $usermodulecount_key_list[$enrol->userid] = $name;
		if (empty($usermodulecount[$name])) {
			$usermodulecount[$name] = 1;
		}
		else {
			$usermodulecount[$name]++;
		}

		$name = htmlspecialchars(strtolower(trim($enrol->fullname . ', ' . $enrol->forumname)), ENT_COMPAT, 'UTF-8');
    $topiccount_key_list[$enrol->userid] = $name;
		if (empty($topiccount[$name])) {
			$topiccount[$name] = 1;
		}
		else {
			$topiccount[$name]++;
		}

		$n++;
    $rowdata[] = $enrol->userid; // Will be removed below
    $table->data[] = $rowdata;

    $listofemails[]  = htmlspecialchars($enrol->email, ENT_COMPAT, 'UTF-8');
	}

  // Remove table rows for which the Student has (in total) <= $maximumposts matching the filter
  $useridkey = count($rowdata) - 1;
  foreach ($table->data as $key => $row) {
    $userid_for_row = $table->data[$key][$useridkey];

    unset($table->data[$key][$useridkey]); // userid Remove from the table so it does not add an unwanted column

    if ($usercountid[$userid_for_row] > $maximumposts) unset($table->data[$key]);
  }

  foreach ($usercountid as $userid => $row) { // Now remove from stats
    if ($usercountid[$userid] > $maximumposts) {
      unset($usercount[$usercount_key_list[$userid]]);
      unset($usermodulecount[$usermodulecount_key_list[$userid]]);
      unset($topiccount[$topiccount_key_list[$userid]]);
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

	foreach ($coursewithstudentforumstats['students'] as $studententry) {
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


$usermodulecountnonzero = count($usermodulecount);
$usercountnonzero = count($usercount);

if (!empty($enrols)) {

  // We want to display Student/Module combinations that have Zero Posts (in the summary statistics)
  $all_usermodules = $DB->get_records_sql(
    "SELECT DISTINCT u.id as userid, u.lastname, u.firstname, c.fullname
    FROM (mdl_enrolment e, mdl_user u, mdl_course c)
    WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id $semestersql $modulesql $ssfsql
    ORDER BY u.lastname ASC, u.firstname ASC, fullname ASC",
    array($chosensemester, $chosenmodule)
  );
  if (!empty($all_usermodules)) {
    foreach ($all_usermodules as $all_usermodule) {
      $name = htmlspecialchars(strtolower(trim($all_usermodule->lastname . ', ' . $all_usermodule->firstname . ', ' . $all_usermodule->fullname)), ENT_COMPAT, 'UTF-8');
      if (empty($usermodulecount[$name])) $usermodulecount[$name] = 0;
    }
  }

  // We want to display Students that have Zero Posts (in the summary statistics)
  $all_users = $DB->get_records_sql(
    "SELECT DISTINCT u.id as userid, u.lastname, u.firstname
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

displaystat($topiccount, 'Student Posts by Forum Topic');
echo 'Number of Forum Topics with Posts: ' . count($topiccount);
echo '<br /><br />';

displaystat($user_actual_averagereferredtoresources, "Average 'Referred to resources' for Student");
echo '<br /><br />';

displaystat($user_actual_averagecriticalapproach, "Average 'Critical approach' for Student");
echo '<br /><br />';

displaystat($user_actual_averagereferencing, "Average 'Referencing' for Student");
echo '<br /><br />';

natcasesort($listofemails);
echo 'e-mails of Selected Students...<br />' . implode(', ', array_unique($listofemails));


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

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}


function dontstripslashes($x) {
  return $x;
}
?>
