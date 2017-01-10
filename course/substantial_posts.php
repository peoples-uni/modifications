<?php  // $Id: substantial_posts.php,v 1.1 2016/08/20 15:23:00 alanbarrett Exp $
/**
*
* Lists Number of Topics with Substantial Posts for each Student in each Module
* 
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/substantial_posts.php');

if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/substantial_posts.php?chosenmodule=' . urlencode($_POST['chosenmodule']));
}

$PAGE->set_pagelayout('embedded');

require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
if (!$isteacher) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/substantial_posts.php?chosenmodule=" . urlencode($_REQUEST['chosenmodule']);
  notice('<br /><br /><b>You must be a Tutor to do this! Please Click "Continue" below, and then log in with your username and password above!</b><br /><br /><br />', "$CFG->wwwroot/");
}


$chosensemester = 'All';
$chosenmodule = $_REQUEST['chosenmodule'];

if (empty($chosenmodule)) {
  echo '<h1>Number of Topics with Substantial Posts for each Student in Module</h1>';
  $PAGE->set_title('Number of Topics with Substantial Posts for each Student in Module');
  $PAGE->set_heading('Number of Topics with Substantial Posts for each Student in Module');
  echo $OUTPUT->header();
?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/substantial_posts.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Module</td>
  </tr>
  <tr>
<?php
  $courses = $DB->get_records_sql(
"SELECT DISTINCT c.id AS courseid, c.fullname
FROM mdl_enrolment e, mdl_course c
WHERE e.courseid=c.id
ORDER BY fullname ASC"
);
  if (!isset($chosenmodule)) $chosenmodule = 'All';
  $listmodule = array();
  foreach ($courses as $course) {
    $listmodule[] = htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8');
  }

  displayoptions('chosenmodule', $listmodule, $chosenmodule);
?>
  </tr>
</table>

<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
</form>
<?php
  echo $OUTPUT->footer();
  die();
}

$course_item = $chosenmodule;

$semestersql = 'AND e.semester!=?';
$modulesql = 'AND c.fullname=?';
$ssfsql = '';


echo '<h1>Number of Topics with Substantial Posts for each Student in Module:<br />' . htmlspecialchars(trim($course_item), ENT_COMPAT, 'UTF-8') . '</h1>';
$PAGE->set_title('Number of Topics with Substantial Posts for each Student in Module');
$PAGE->set_heading('Number of Topics with Substantial Posts for each Student in Module');
echo $OUTPUT->header();


// Number of topics with substantial posts
$number_of_topics_with_substantial_posts_per_user_course = $DB->get_records_sql(
"
SELECT
  LOWER(CONCAT(TRIM(x.lastname), ', ', TRIM(x.firstname), 'XXX8167YYYY', TRIM(x.fullname))) AS unique_id,
  SUM(x.number_of_substantial>0) AS number_of_topics_with_substantial,
  SUM(x.number_of_ratings>0) AS number_of_topics_with_rating,
  x.userid,
  x.courseid,
  x.lastname,
  x.firstname,
  x.email,
  x.fullname
FROM
  (
  SELECT
    u.id AS userid,
    c.id AS courseid,
    f.id AS topicid,
    SUM(IFNULL(r.rating, 0)=2) AS number_of_substantial,
    SUM(IFNULL(r.rating, 0)) AS number_of_ratings,
    u.lastname,
    u.firstname,
    u.email,
    c.fullname
  FROM (mdl_enrolment e, mdl_user u, mdl_course c, mdl_forum f, mdl_forum_discussions fd, mdl_forum_posts fp)
  LEFT JOIN mdl_rating r ON fp.id=r.itemid AND r.scaleid IN({$CFG->scale_to_use_for_triple_rating_4}) AND r.component='mod_forum' AND r.ratingarea='post'
  WHERE
    e.enrolled!=0 AND e.userid=u.id AND e.courseid=c.id AND fp.userid=e.userid AND fp.discussion=fd.id AND fd.forum=f.id AND f.course=c.id AND
    f.name NOT LIKE 'Introductions -%' AND
    f.name NOT LIKE 'Introduction forum:%'
    $semestersql $modulesql $ssfsql
  GROUP BY u.id, c.id, f.id
  ) AS x
GROUP BY x.userid, x.courseid
",
array($chosensemester, $chosenmodule)
);


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
    if (empty($number_of_topics_with_substantial_posts_per_user_course[strtolower(trim($all_user->lastname) . ', ' . trim($all_user->firstname) . 'XXX8167YYYY' . trim($course_item))])) {
      $missing_item = new stdClass();
      $missing_item->lastname = $all_user->lastname;
      $missing_item->firstname = $all_user->firstname;
      $missing_item->fullname = $course_item;
      $missing_item->email = $all_user->email;
      $missing_item->number_of_topics_with_rating = -1; // No posts!
      $missing_item->number_of_topics_with_substantial = 0;
      $number_of_topics_with_substantial_posts_per_user_course[strtolower(trim($all_user->lastname) . ', ' . trim($all_user->firstname) . 'XXX8167YYYY' . trim($course_item))] = $missing_item;
    }
  }
}


if (!empty($number_of_topics_with_substantial_posts_per_user_course)) {
  displaystat_number_of_topics_with_substantial_posts($number_of_topics_with_substantial_posts_per_user_course);
  echo '<br /><br />';
}


function displaystat_number_of_topics_with_substantial_posts($number_of_topics_with_substantial_posts_per_user_course) {
  ksort($number_of_topics_with_substantial_posts_per_user_course);

  echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
  echo "<tr>";
  echo "<td>Family name</td>";
  echo "<td>Given name</td>";
  // echo "<td>Module</td>";
  echo "<td>e-mail</td>";
  echo "<td>Number of topics with substantial posts (ignoring introductions)</td>";
  echo "</tr>";

  $emails_no_posts = array();
  $emails_not_rated = array();
  $emails_less_than_3 = array();
  $emails_greater_than_or_equal_3 = array();

  foreach ($number_of_topics_with_substantial_posts_per_user_course as $number_of_topics_with_substantial_posts_per_user_course_item) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars(trim($number_of_topics_with_substantial_posts_per_user_course_item->lastname), ENT_COMPAT, 'UTF-8') . "</td>";
    echo "<td>" . htmlspecialchars(trim($number_of_topics_with_substantial_posts_per_user_course_item->firstname), ENT_COMPAT, 'UTF-8') . "</td>";
    // echo "<td>" . htmlspecialchars(trim($number_of_topics_with_substantial_posts_per_user_course_item->fullname), ENT_COMPAT, 'UTF-8') . "</td>";
    echo '<td><a href="mailto:' . rawurlencode(trim($number_of_topics_with_substantial_posts_per_user_course_item->email)) . '?subject=Discussions">' . htmlspecialchars(trim($number_of_topics_with_substantial_posts_per_user_course_item->email), ENT_COMPAT, 'UTF-8') . '</a></td>';
    $stat = '';
    if     ($number_of_topics_with_substantial_posts_per_user_course_item->number_of_topics_with_rating == -1) {
      $stat = 'No posts!';
      $emails_no_posts[$number_of_topics_with_substantial_posts_per_user_course_item->email] = $number_of_topics_with_substantial_posts_per_user_course_item->email;
    }
    elseif ($number_of_topics_with_substantial_posts_per_user_course_item->number_of_topics_with_rating == 0) {
      $stat = 'Not rated!';
      $emails_not_rated[$number_of_topics_with_substantial_posts_per_user_course_item->email] = $number_of_topics_with_substantial_posts_per_user_course_item->email;
    }
    elseif ($number_of_topics_with_substantial_posts_per_user_course_item->number_of_topics_with_substantial == 0) {
      $stat = 'No substantial ratings!';
      $emails_less_than_3[$number_of_topics_with_substantial_posts_per_user_course_item->email] = $number_of_topics_with_substantial_posts_per_user_course_item->email;
    }
    elseif ($number_of_topics_with_substantial_posts_per_user_course_item->number_of_topics_with_substantial <  3) {
      $stat = $number_of_topics_with_substantial_posts_per_user_course_item->number_of_topics_with_substantial . ', Less than 3!';
      $emails_less_than_3[$number_of_topics_with_substantial_posts_per_user_course_item->email] = $number_of_topics_with_substantial_posts_per_user_course_item->email;
    }
    else {
      $stat = $number_of_topics_with_substantial_posts_per_user_course_item->number_of_topics_with_substantial;
      $emails_greater_than_or_equal_3[$number_of_topics_with_substantial_posts_per_user_course_item->email] = $number_of_topics_with_substantial_posts_per_user_course_item->email;
    }
    echo "<td>" . $stat . "</td>";
    echo "</tr>";
  }
  echo '</table>';
  echo '<br/>';

  echo '<b>emails of those with no Posts:</b> ' . implode(', ', $emails_no_posts) . '<br />';
  echo '<b>emails of those with no Ratings:</b> ' . implode(', ', $emails_not_rated) . '<br />';
  echo '<b>emails of those with less than 3 Substantial Ratings:</b> ' . implode(', ', $emails_less_than_3) . '<br />';
  echo '<b>emails of those with 3 or more Substantial Ratings:</b> ' . implode(', ', $emails_greater_than_or_equal_3) . '<br />';
}


echo '<br /><br /><br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

echo $OUTPUT->footer();


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
?>
