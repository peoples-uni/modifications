<?php
/**
*
* Write discussion feedback for an individual Student
*
*/

$assessmentname[  ''] = 'Select...';
$assessmentname['10'] = 'Yes';
$assessmentname['20'] = 'No';
$assessmentname['30'] = 'Could be improved';
$assessmentname['40'] = 'Not applicable';

$assessmentname_display[  ''] = 'Select...';
$assessmentname_display[ '0'] = '';
$assessmentname_display['10'] = 'Yes';
$assessmentname_display['20'] = 'No';
$assessmentname_display['30'] = 'Could be improved';
$assessmentname_display['40'] = 'Not applicable';

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(context_system::instance());
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


if (!empty($_POST['refered_to_resources']) && !empty($_POST['critical_approach']) && !empty($_POST['provided_references']) && !empty($_POST['substantial_contribution'])) {
  $refered_to_resources = (int)$_POST['refered_to_resources'];
  $critical_approach    = (int)$_POST['critical_approach'];
  $provided_references  = (int)$_POST['provided_references'];
  $substantial_contribution  = (int)$_POST['substantial_contribution'];
}
else {
  $refered_to_resources = 0;
  $critical_approach    = 0;
  $provided_references  = 0;
  $substantial_contribution  = 0;
}

if (!empty($_POST['markfeedbackdiscussion']) && !empty($_POST['course_id']) && $refered_to_resources && $critical_approach && $provided_references && $substantial_contribution) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $course_id = (int)$_POST['course_id'];
  $course = $DB->get_record('course', array('id' => $course_id));
  if (empty($course)) {echo '<h1>Bad course, should not happen!</h1>'; die();}

  $discussionfeedback = $DB->get_record('discussionfeedback', array('course_id' => $course_id, 'userid' => $userid_for_student));

  if (empty($discussionfeedback)) {
    $discussionfeedback = new stdClass();

    $doinsert = TRUE;
  }
  else {
    $doinsert = FALSE;
  }

  $discussionfeedback->refered_to_resources = $refered_to_resources;
  $discussionfeedback->critical_approach = $critical_approach;
  $discussionfeedback->provided_references = $provided_references;
  $discussionfeedback->substantial_contribution = $substantial_contribution;

  $assessment_text = $_POST['assessment_text'];
  if (empty($assessment_text)) $assessment_text = '';
  $discussionfeedback->assessment_text = htmlspecialchars($assessment_text, ENT_COMPAT, 'UTF-8');

  $discussionfeedback->course_id = $course_id;
  $discussionfeedback->userid = $userid_for_student;
  $discussionfeedback->user_id_submitted = $USER->id;
  $discussionfeedback->datesubmitted = time();

  if ($doinsert) {
    $DB->insert_record('discussionfeedback', $discussionfeedback);
  }
  else {
    $DB->update_record('discussionfeedback', $discussionfeedback);
  }

  $peoples_discussion_feedback_email = get_config(NULL, 'peoples_discussion_feedback_email');
  $peoples_discussion_feedback_email = str_replace("\r", '', $peoples_discussion_feedback_email);
  $peoples_discussion_feedback_email = str_replace('GIVEN_NAME_HERE', $userrecord->firstname, $peoples_discussion_feedback_email);

  $criteria  = "Referred to resources in the topics: $assessmentname[$refered_to_resources]\n\n";
  $criteria .= "Included critical approach to information: $assessmentname[$critical_approach]\n\n";
  $criteria .= "Provided references in an appropriate format: $assessmentname[$provided_references]\n";
  $criteria .= "Provided a substantial contribution: $assessmentname[$substantial_contribution]\n";
  if (!empty($assessment_text)) $criteria .= "\n" . $assessment_text . "\n";
  $peoples_discussion_feedback_email = str_replace('DISCUSSION_CRITERIA_HERE', $criteria, $peoples_discussion_feedback_email);
  $senders_name_here = fullname($USER);
  $peoples_discussion_feedback_email = str_replace('SENDERS_NAME_HERE', $senders_name_here, $peoples_discussion_feedback_email);

  $peoples_discussion_feedback_email = str_replace('IDHERE', "$course->id", $peoples_discussion_feedback_email);

  $peoples_discussion_feedback_email = strip_tags($peoples_discussion_feedback_email);

  $peoples_discussion_feedback_email = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $peoples_discussion_feedback_email); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                                                                             // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)
  $peoples_discussion_feedback_email = preg_replace('#(https://[^\s]+)[\s]+#', "$1\n\n", $peoples_discussion_feedback_email);

  $student_name = fullname($userrecord);
  sendapprovedmail($userrecord->email, "Peoples-uni Discussion Feedback for $course->fullname ($student_name)", $peoples_discussion_feedback_email);
}


echo '<h1>Write Discussion Feedback for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</h1>';
$PAGE->set_title('Write Discussion Feedback for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
$PAGE->set_heading('Write Discussion Feedback for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));

echo $OUTPUT->header();

$semesters = $DB->get_records_sql("SELECT semester FROM mdl_semesters ORDER BY STR_TO_DATE(SUBSTRING(semester, 10), '%M %Y') DESC");
foreach ($semesters as $semester) {
	if (!isset($chosensemester)) $chosensemester = $semester->semester;
}


// Copy from posts.php
$enrols = $DB->get_records_sql(
"SELECT fp.id AS postid, fd.id AS discid, e.semester, u.id as userid, u.lastname, u.firstname, u.email, c.fullname, f.name AS forumname, fp.subject, m.id IS NOT NULL AS mph, m.datesubmitted AS mphdatestamp
FROM (mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp)
LEFT JOIN mdl_peoplesmph m ON e.userid=m.userid
WHERE e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id AND e.userid=?
ORDER BY STR_TO_DATE(SUBSTRING(e.semester, 10), '%M %Y'), u.lastname ASC, u.firstname ASC, fullname ASC, forumname ASC, fp.subject ASC",
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
  r.scaleid IN({$CFG->scale_to_use_for_triple_rating}, {$CFG->scale_to_use_for_triple_rating_2}, {$CFG->scale_to_use_for_triple_rating_3}, {$CFG->scale_to_use_for_triple_rating_4}) AND
  e.userid=?",
array($userid_for_student)
);


// From discussionfeedbacks.php
$discussionfeedbacks = $DB->get_records_sql("
  SELECT DISTINCT d.*, u.lastname, u.firstname, c.fullname, e.semester
    ,
    r.id IS NOT NULL AS rating_submitted,
    r.what_skills_need_to_improve,
    r.what_do_to_improve_academic_skills,
    r.what_do_differently_when_prepare_post
  FROM mdl_discussionfeedback d
  INNER JOIN mdl_user u ON d.userid=u.id
  INNER JOIN mdl_course c ON d.course_id=c.id
  INNER JOIN mdl_enrolment e ON d.userid=e.userid AND d.course_id=e.courseid
  LEFT JOIN mdl_student_ratingresponse r ON d.userid=r.userid AND d.course_id=r.course_id
  WHERE e.userid=?
  ORDER BY STR_TO_DATE(SUBSTRING(e.semester, 10), '%M %Y'), c.fullname, u.lastname, u.firstname",
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

// substantial for Post
$actual_substantial = array();
$actual_count_substantial = array();
$actual_user_substantial = array();
if (!empty($ratings)) {
  foreach ($ratings as $rating) {
    if ($rating->scaleid == $CFG->scale_to_use_for_triple_rating_4) {
      if (empty($actual_substantial[$rating->postid])) {
        $actual_substantial[$rating->postid] = 0.0 + $rating->rating;
        $actual_count_substantial[$rating->postid] = 1.0;
        $actual_user_substantial[$rating->postid] = $rating->userid;
      }
      else {
        $actual_substantial[$rating->postid] =
          (($actual_substantial[$rating->postid] * $actual_count_substantial[$rating->postid]) + $rating->rating) /
          ($actual_count_substantial[$rating->postid] + 1.0);
        $actual_count_substantial[$rating->postid] += 1.0;
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
  'Referencing:',
  'substantial contribution:',
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

    $actual_substantialnotrated = false;
    $actual_substantialno = false;
    $actual_substantialsome = false;
    $actual_substantialyes = false;
    if (empty($actual_substantial[$enrol->postid])) $actual_substantialnotrated = true;
    elseif ($actual_substantial[$enrol->postid] < 1.01) $actual_substantialno = true;
    elseif ($actual_substantial[$enrol->postid] <=2.99) $actual_substantialsome = true;
    else $actual_substantialyes = true;

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

    if ($actual_substantialnotrated) $rowdata[] = 'Not rated';
    if ($actual_substantialno) $rowdata[] = 'No';
    if ($actual_substantialsome) $rowdata[] = 'Some';
    if ($actual_substantialyes) $rowdata[] = 'Yes';

		$n++;
    $table->data[] = $rowdata;
	}
}
echo html_writer::table($table);
echo '<br/>Number of Forum Postings: ' . $n;
echo '<br /><br /><br /><br />';


$table = new html_table();

$table->head = array(
  'Semester',
  'Module',
  'Referred to resources in the topics',
  'Included critical approach to information',
  'Provided references in an appropriate format',
  'Provided a substantial contribution',
  'Free text',
  'Student reflection: What skills do I need to improve?',
  'Student reflection: What will I do to improve my academic skills? (and when?)',
  'Student reflection: What will I do differently when I prepare a discussion post?',
  );

$n = 0;
foreach ($discussionfeedbacks as $discussionfeedback) {
  $rowdata = array();

  $rowdata[] = htmlspecialchars($discussionfeedback->semester, ENT_COMPAT, 'UTF-8');
  $rowdata[] = htmlspecialchars($discussionfeedback->fullname, ENT_COMPAT, 'UTF-8');
  $rowdata[] =  $assessmentname[$discussionfeedback->refered_to_resources];
  $rowdata[] =  $assessmentname[$discussionfeedback->critical_approach];
  $rowdata[] =  $assessmentname[$discussionfeedback->provided_references];
  $rowdata[] =  $assessmentname_display[$discussionfeedback->substantial_contribution];
  $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->assessment_text));

  if ($discussionfeedback->rating_submitted) {
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->what_skills_need_to_improve));
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->what_do_to_improve_academic_skills));
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->what_do_differently_when_prepare_post));
  }
  else {
    $rowdata[] = '';
    $rowdata[] = '';
    $rowdata[] = '';
  }

  $table->data[] = $rowdata;
  $n++;
}
echo html_writer::table($table);
echo '<br /><br />';


$all_courses = $DB->get_records_sql("
SELECT c.id, c.fullname
FROM mdl_enrolment e, mdl_course c
WHERE e.enrolled!=0 AND e.courseid=c.id AND e.userid=? AND e.semester=?
ORDER BY c.fullname ASC",
array($userid_for_student, $chosensemester)
);
if (!empty($all_courses)) {

  echo '<script type="text/JavaScript">';
  foreach ($all_courses as $all_course) {
?>

function verify<?php echo $all_course->id ?>() {
  var refered_to_resources = document.feedbackdiscussionform<?php echo $all_course->id ?>.refered_to_resources.value;
  if (refered_to_resources == "") {
    alert("You must enter feedback for 'Referred to resources in the topics'");
    document.feedbackdiscussionform<?php echo $all_course->id ?>.refered_to_resources.focus();
    return false;
  }
  var critical_approach = document.feedbackdiscussionform<?php echo $all_course->id ?>.critical_approach.value;
  if (critical_approach == "") {
    alert("You must enter feedback for 'Included critical approach to information'");
    document.feedbackdiscussionform<?php echo $all_course->id ?>.critical_approach.focus();
    return false;
  }
  var provided_references = document.feedbackdiscussionform<?php echo $all_course->id ?>.provided_references.value;
  if (provided_references == "") {
    alert("You must enter feedback for 'Provided references in an appropriate format'");
    document.feedbackdiscussionform<?php echo $all_course->id ?>.provided_references.focus();
    return false;
  var substantial_contribution = document.feedbackdiscussionform<?php echo $all_course->id ?>.substantial_contribution.value;
  if (substantial_contribution == "") {
    alert("You must enter feedback for 'Provided a substantial contribution'");
    document.feedbackdiscussionform<?php echo $all_course->id ?>.substantial_contribution.focus();
    return false;
  }
  return true;
}

<?php
  }
  echo '</script>';

  foreach ($all_courses as $all_course) {
?>
<br />
<form method="post" action="<?php echo $CFG->wwwroot . "/course/discussionfeedback_for_student.php?userid=$userid_for_student"; ?>"  onSubmit="return verify<?php echo $all_course->id ?>()" name="feedbackdiscussionform<?php echo $all_course->id ?>">
Write Discussion Feedback for <?php echo htmlspecialchars($all_course->fullname, ENT_COMPAT, 'UTF-8'); ?> (Student: <?php echo htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'); ?>)...<br /><br />

<table border="2" cellpadding="2">
<tr>
  <td>Referred to resources in the topics:</td>
  <?php displaynumericoptions('refered_to_resources', $assessmentname, 'Select...'); ?>
</tr>
<tr>
  <td>Included critical approach to information:</td>
  <?php displaynumericoptions('critical_approach', $assessmentname, 'Select...'); ?>
</tr>
<tr>
  <td>Provided references in an appropriate format:</td>
  <?php displaynumericoptions('provided_references', $assessmentname, 'Select...'); ?>
</tr>
<tr>
  <td>Provided a substantial contribution:</td>
  <?php displaynumericoptions('substantial_contribution', $assessmentname, 'Select...'); ?>
</tr>
<tr>
  <td>Add any free text you wish to be added to the e-mail after the assessment:</td>
  <td><textarea name="assessment_text" rows="10" cols="100" wrap="hard" style="width:auto"></textarea></td>
</tr>
<tr>
  <td colspan="2">
    <input type="hidden" name="course_id" value="<?php echo $all_course->id ?>" />
    <input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
    <input type="hidden" name="markfeedbackdiscussion" value="1" />
    <input type="submit" name="feedbackdiscussion" value="&nbsp;&nbsp;&nbsp;&nbsp;Submit Discussion Feedback&nbsp;&nbsp;&nbsp;&nbsp;" />
  </td>
</tr>
</table>
</form>
<br />
<?php
  }
}


echo '<br /><br /><br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

echo $OUTPUT->footer();


function displaynumericoptions($name, $options, $selectedvalue) {
  echo '<td><select name="' . $name . '">';
  foreach ($options as $key => $option) {
    if ($option === $selectedvalue) $selected = 'selected="selected"';
    else $selected = '';

    $opt = htmlspecialchars($option, ENT_COMPAT, 'UTF-8');
    echo '<option value="' . $key . '" ' . $selected . '>' . $opt . '</option>';
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

  if (has_capability('moodle/site:config', context_system::instance())) return true;
  else return false;
}


function sendapprovedmail($email, $subject, $message) {
  global $CFG;
  global $USER;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999; $user->username = 'none';
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->id = 999999998; $supportuser->username = 'none';
  $supportuser->email = 'education@helpdesk.peoples-uni.org';
  $supportuser->firstname = "People's Open Access Education Initiative: Peoples-uni";
  $supportuser->lastname = '';
  $supportuser->firstname = $USER->firstname;
  $supportuser->lastname  = $USER->lastname;
  $supportuser->firstnamephonetic = NULL;
  $supportuser->lastnamephonetic = NULL;
  $supportuser->middlename = NULL;
  $supportuser->alternatename = NULL;
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  //$user->email = 'applicationresponses@peoples-uni.org';
  //$user->email = 'alanabarrett0@gmail.com';
  //email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}
?>
