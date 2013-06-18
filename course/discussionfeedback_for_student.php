<?php
/**
*
* Write discussion feedback for an individual Student
*
*/

$assessmentname['10'] = 'Yes';
$assessmentname['20'] = 'No';
$assessmentname['30'] = 'Could be improved';

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/discussionfeedback_for_student.php');
$PAGE->set_pagelayout('embedded');

require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
if (!$isteacher) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/discussionfeedback_for_student.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please Click "Continue" below, and then log in with your username and password above!</b><br /><br /><br />', "$CFG->wwwroot/");
}


$userid_for_student = optional_param('userid', 0, PARAM_INT);
if (empty($userid_for_student)) {echo '<h1>userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid_for_student));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

echo '<h1>Write Discussion Feedback for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</h1>';
$PAGE->set_title('Write Discussion Feedback for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
$PAGE->set_heading('Write Discussion Feedback for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));

echo $OUTPUT->header();

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
	if (!isset($chosensemester)) $chosensemester = $semester->semester;
}


// Copy from posts.php
$enrols = $DB->get_records_sql(
"SELECT fp.id AS postid, fd.id AS discid, e.semester, u.id as userid, u.lastname, u.firstname, u.email, c.fullname, f.name AS forumname, fp.subject, m.id IS NOT NULL AS mph, m.datesubmitted AS mphdatestamp
FROM (mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp)
LEFT JOIN mdl_peoplesmph m ON e.userid=m.userid
WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id AND e.userid=?
ORDER BY e.semester, u.lastname ASC, u.firstname ASC, fullname ASC, forumname ASC, fp.subject ASC",
array($userid_for_student)
);


// (more or less) Duplicate the query but now for ratings (separate query used to reduce re-testing)
$ratings = $DB->get_records_sql(
"SELECT
  r.id as ratingid, r.rating, r.scaleid,
  fp.id AS postid, fd.id AS discid, e.semester, u.id as userid, u.lastname, u.firstname, c.fullname, f.name AS forumname, fp.subject
FROM (mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp)
LEFT JOIN mdl_rating r ON fp.id=r.itemid
WHERE
  e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id AND
  r.component='mod_forum' AND r.ratingarea='post' AND
  r.scaleid IN({$CFG->scale_to_use_for_triple_rating}, {$CFG->scale_to_use_for_triple_rating_2}, {$CFG->scale_to_use_for_triple_rating_3}) AND
  e.userid=?",
array($userid_for_student)
);


// From discussionfeedbacks.php
$discussionfeedbacks = $DB->get_records_sql('
  SELECT DISTINCT d.*, u.lastname, u.firstname, c.fullname, e.semester
  FROM mdl_discussionfeedback d
  INNER JOIN mdl_user u ON d.userid=u.id
  INNER JOIN mdl_course c ON d.course_id=c.id
  INNER JOIN mdl_enrolment e ON d.userid=e.userid AND d.course_id=e.courseid
  WHERE e.userid=?
  ORDER BY e.semester, c.fullname, u.lastname, u.firstname',
array($userid_for_student)
);
if (empty($discussionfeedbacks)) {
  $discussionfeedbacks = array();
}


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

// criticalapproach for Post
$actual_criticalapproach = array();
$actual_count_criticalapproach = array();
$actual_user_criticalapproach = array();
if (!empty($ratings)) {
  foreach ($ratings as $rating) {
    if ($rating->scaleid == $CFG->scale_to_use_for_triple_rating_2) {
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

// referencing for Post
$actual_referencing = array();
$actual_count_referencing = array();
$actual_user_referencing = array();
if (!empty($ratings)) {
  foreach ($ratings as $rating) {
    if ($rating->scaleid == $CFG->scale_to_use_for_triple_rating_3) {
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


$table = new html_table();
$table->head = array(
  'Semester',
  'Module',
  'Discussion Forum Topic',
  'Subject',
  'Referred to resources:',
  'Critical approach:',
  'Referencing:'
  );

$n = 0;
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {

    $actual_referredtoresourcesnotrated = false;
    $actual_referredtoresourcesno = false;
    $actual_referredtoresourcessome = false;
    $actual_referredtoresourcesyes = false;
    if (empty($actual_referredtoresources[$enrol->postid])) $actual_referredtoresourcesnotrated = true;
    elseif ($actual_referredtoresources[$enrol->postid] < 1.01) $actual_referredtoresourcesno = true;
    elseif ($actual_referredtoresources[$enrol->postid] <=2.99) $actual_referredtoresourcessome = true;
    else $actual_referredtoresourcesyes = true;

    $actual_criticalapproachnotrated = false;
    $actual_criticalapproachno = false;
    $actual_criticalapproachsome = false;
    $actual_criticalapproachyes = false;
    if (empty($actual_criticalapproach[$enrol->postid])) $actual_criticalapproachnotrated = true;
    elseif ($actual_criticalapproach[$enrol->postid] < 1.01) $actual_criticalapproachno = true;
    elseif ($actual_criticalapproach[$enrol->postid] <=2.99) $actual_criticalapproachsome = true;
    else $actual_criticalapproachyes = true;

    $actual_referencingnotrated = false;
    $actual_referencingnone = false;
    $actual_referencingwrongformat = false;
    $actual_referencinggood = false;
    if (empty($actual_referencing[$enrol->postid])) $actual_referencingnotrated = true;
    elseif ($actual_referencing[$enrol->postid] < 1.01) $actual_referencingnone = true;
    elseif ($actual_referencing[$enrol->postid] <=2.99) $actual_referencingwrongformat = true;
    else $actual_referencinggood = true;

    $rowdata = array();
    $rowdata[] = htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8');
    $rowdata[] = htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8');
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

		$n++;
    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);
echo '<br/>Number of Forum Postings: ' . $n;
echo '<br /><br />';


$table = new html_table();

$table->head = array(
  'Semester',
  'Module',
  'Referred to resources in the topics',
  'Included critical approach to information',
  'Provided references in an appropriate format',
  'Free text',
  );

$n = 0;
foreach ($discussionfeedbacks as $discussionfeedback) {
  $rowdata = array();

  $rowdata[] = htmlspecialchars($discussionfeedback->semester, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($discussionfeedback->fullname, ENT_COMPAT, 'UTF-8');
  $rowdata[] =  $assessmentname[$discussionfeedback->refered_to_resources];
  $rowdata[] =  $assessmentname[$discussionfeedback->critical_approach];
  $rowdata[] =  $assessmentname[$discussionfeedback->provided_references];
  $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->assessment_text));

  $table->data[] = $rowdata;
  $n++;
}
echo html_writer::table($table);


echo '<br /><br /><br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

echo $OUTPUT->footer();


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
?>
