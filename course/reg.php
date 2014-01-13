<?php  // $Id: reg.php,v 1.1 2012/12/18 14:30:00 alanbarrett Exp $
/**
*
* List a single Registration application
*
*/

$qualificationname[ '1'] = 'None';
$qualificationname['10'] = 'Degree (not health related)';
$qualificationname['20'] = 'Health qualification (non-degree)';
$qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
$qualificationname['40'] = 'Medical degree';

$higherqualificationname[ '1'] = 'None';
$higherqualificationname['10'] = 'Certificate';
$higherqualificationname['20'] = 'Diploma';
$higherqualificationname['30'] = 'Masters';
$higherqualificationname['40'] = 'Ph.D.';
$higherqualificationname['50'] = 'Other';

$employmentname[ '1'] = 'None';
$employmentname['10'] = 'Student';
$employmentname['20'] = 'Non-health';
$employmentname['30'] = 'Clinical (not specifically public health)';
$employmentname['40'] = 'Public health';
$employmentname['50'] = 'Other health related';
$employmentname['60'] = 'Academic occupation (e.g. lecturer)';

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

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/reg.php'); // Defined here to avoid notices on errors etc

//$PAGE->set_pagelayout('embedded');   // Needs as much space as possible
//$PAGE->set_pagelayout('base');     // Most backwards compatible layout without the blocks - this is the layout used by default
$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();

//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Student Registration Details');
$application = $DB->get_record('peoplesregistration', array('id' => $_REQUEST['id']));
$PAGE->set_heading('Details for '. htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8') . ', ' . htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();

if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');


echo '<script type="text/JavaScript">function areyousuredeleteentry() { var sure = false; sure = confirm("Are you sure you want to Hide this Application Form Entry for ' . htmlspecialchars(($application->firstname), ENT_COMPAT, 'UTF-8') . ' ' . htmlspecialchars(($application->lastname), ENT_COMPAT, 'UTF-8') . ' from All Future Processing?"); return sure;}</script>';


$refreshparent = false;
if (!empty($_POST['markchangeemail']) && !empty($_POST['email'])) {
  $_POST['email'] = trim($_POST['email']);

  updateapplication($_POST['id'], 'email', $_POST['email']);

  $refreshparent = true;
}


if ($refreshparent) {
?>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
<?php
}


$application = $DB->get_record('peoplesregistration', array('id' => $_REQUEST['id']));

$sid = $_REQUEST['id'];
$state = (int)$application->state;

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";
echo "<td>Family name</td>";
echo "<td>" . htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Given name</td>";
echo "<td>" . htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Email address</td>";
echo "<td>" . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>DOB</td>";
echo "<td>" . $application->dobday . "/" . $application->dobmonth . "/" . $application->dobyear . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Gender</td>";
echo "<td>" . $application->gender . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Address</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', $application->applicationaddress)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>City/Town</td>";
echo "<td>" . htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Country</td>";
$countryname = get_string_manager()->get_list_of_countries(false);
if (empty($countryname[$application->country])) echo "<td></td>";
else echo "<td>" . $countryname[$application->country] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Current Employment</td>";
if (empty($employmentname[$application->employment])) echo "<td></td>";
else echo "<td>" . $employmentname[$application->employment] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Current Employment Details</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', $application->currentjob)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Higher Education Qualification</td>";
if (empty($qualificationname[$application->qualification])) echo "<td></td>";
else echo "<td>" . $qualificationname[$application->qualification] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Postgraduate Qualification</td>";
if (empty($higherqualificationname[$application->higherqualification])) echo "<td></td>";
else echo "<td>" . $higherqualificationname[$application->higherqualification] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Other relevant qualifications or educational experience</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', $application->education)) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Reasons for wanting to enrol</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', $application->reasons)) . "</td>";
echo "</tr>";

echo '<tr>';
echo '<td>What do you want to learn?</td>';
$z = '';
$arrayvalues = explode(',', $application->whatlearn);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $whatlearnname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Why do you want to learn?</td>';
$z = '';
$arrayvalues = explode(',', $application->whylearn);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $whylearnname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>What are the reasons you want to do an e-learning course?</td>';
$z = '';
$arrayvalues = explode(',', $application->whyelearning);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $whyelearningname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>How will you use your new knowledge and skills to improve population health?</td>';
$z = '';
$arrayvalues = explode(',', $application->howuselearning);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $howuselearningname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Sponsoring organisation</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', $application->sponsoringorganisation)) . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>How heard about Peoples-uni</td>';
if (empty($howfoundpeoplesname[$application->howfoundpeoples])) echo "<td></td>";
else echo "<td>" . $howfoundpeoplesname[$application->howfoundpeoples] . "</td>";
echo '</tr>';
echo '<tr>';
echo '<td>Name of the organisation or person from whom you heard about Peoples-uni</td>';
echo '<td>' . $application->howfoundorganisationname . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Desired Moodle Username</td>';
echo '<td>' . htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8') . '</td>';
echo '</tr>';
if (!empty($application->userid)) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/student.php?id=' . $application->userid . '" target="_blank">Student Grades</a></td></tr>';
if (!empty($application->userid)) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $application->userid . '" target="_blank">Student Submissions</a></td></tr>';
echo '</table>';

if ($state === 0) {
  $given_name = $application->firstname;

  $peoples_register_email = get_config(NULL, 'peoples_register_email');

  $peoples_register_email = str_replace('GIVEN_NAME_HERE', $given_name, $peoples_register_email);
  $peoples_register_email = str_replace('FPH_ID_HERE', get_config(NULL, 'foundations_public_health_id'), $peoples_register_email);

  $peoples_register_email = htmlspecialchars($peoples_register_email, ENT_COMPAT, 'UTF-8');

?>
<br />To Register this Student and send an e-mail to Student (edit e-mail text if you wish), press "Register Student".
<form id="approveapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/regaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<textarea name="approvedtext" rows="15" cols="75" wrap="hard">
<?php echo $peoples_register_email; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapproveapplication" value="1" />
<input type="submit" name="approveapplication" value="Register Student" />
</form>
<br />

<?php
}
else {
  echo '<span style="color:green">This Student is Registered.</span><br />';
}

?>
<br />To send an e-mail to this Student (EDIT the e-mail text below!), press "e-mail Student".
<form id="deferapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/regaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<textarea name="defertext" rows="10" cols="75" wrap="hard">
Dear <?php echo htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8'); ?>,


     Peoples Open Access Education Initiative Administrator.
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeferapplication" value="1" />
<input type="submit" name="deferapplication" value="e-mail Student" />
</form>
<br />
<?php

if (!empty($application->userid)) {
  $userrecord = $DB->get_record('user', array('id' => ($application->userid)));
}
elseif (!empty($application->username)) {
  $userrecord = $DB->get_record('user', array('username' => ($application->username)));
}
if (!empty($userrecord)) {
  if (empty($application->userid)) {
    echo "<strong>This Student has not been Registered but there is already a Moodle user with the Username: '" . htmlspecialchars($userrecord->username, ENT_COMPAT, 'UTF-8') . "'...</strong>";
  }
  else {
    echo "<strong>Corresponding Registered Moodle Username: '" . htmlspecialchars($userrecord->username, ENT_COMPAT, 'UTF-8') . "'...</strong>";
  }

  echo "<table border=\"1\" BORDERCOLOR=\"RED\">";

  echo "<tr>";
  echo "<td>lastname</td>";
  if (!empty($userrecord->lastname)) { echo "<td>" . $userrecord->lastname . "</td>"; } else { echo "<td></td>"; }
  echo "</tr>";

  echo "<tr>";
  echo "<td>firstname</td>";
  if (!empty($userrecord->firstname)) { echo "<td>" . $userrecord->firstname . "</td>"; } else { echo "<td></td>"; }
  echo "</tr>";

  echo "<tr>";
  echo "<td>email</td>";
  if (!empty($userrecord->email)) { echo "<td>" . $userrecord->email . "</td>"; } else { echo "<td></td>"; }
  echo "</tr>";

  echo "<tr>";
  echo "<td>city</td>";
  if (!empty($userrecord->city)) { echo "<td>" . $userrecord->city . "</td>"; } else { echo "<td></td>"; }
  echo "</tr>";

  echo "<tr>";
  echo "<td>country</td>";
  if (!empty($countryname[$userrecord->country])) { echo "<td>" . $countryname[$userrecord->country] . "</td>"; } else { echo "<td></td>"; }
  echo "</tr>";

  echo "<tr>";
  echo "<td>id</td>";
  if (!empty($userrecord->id)) { echo "<td>" . $userrecord->id . "</td>"; } else { echo "<td></td>"; }
  echo "</tr>";

  echo '</table>';

  echo '<br />';

  $courses = enrol_get_users_courses($userrecord->id);

  if (!empty($courses)) {
    echo "User's courses...";
    echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
    foreach ($courses as $key => $course) {
      echo "<tr>";
      if (!empty($course->fullname)) { echo "<td>" . $course->fullname . "</td>"; } else { echo "<td></td>"; }
      echo "</tr>";
    }
    echo '</table>';
  }
  else {
    echo 'User ' . htmlspecialchars($userrecord->username, ENT_COMPAT, 'UTF-8') . ' is not enrolled in any courses.';
  }
  if (empty($application->userid)) {
?>

<br />Enter a new suggested user name here (maybe add "1" at the end of the existing name) and then press "Update Username" (you will need to come back to this page to register them).
<form id="appusernameform" method="post" action="<?php echo $CFG->wwwroot . '/course/regaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdateusername" value="1" />
<input type="submit" name="updateusername" value="Update Username to:" style="width:40em" />
<input type="text" size="40" name="username" value="<?php echo htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br /><br />
<?php
  }
}
else {
?>
No Moodle user with the Username: '<?php echo htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8'); ?>'<br /><br /><br />
<?php
}

if ($state === 0 && empty($application->userid)) { // Allow applicant e-mail to be changed
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/reg.php'; ?>">
<input type="hidden" name="id" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markchangeemail" value="1" />
<input type="submit" name="changeemail" value="Change Applicant e-mail to:" style="width:40em" />

<input type="text" size="40" name="email" value="<?php echo htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br />
<?php
}

if (!empty($application->userid)) {
?>
<br />
<form method="post" action="<?php echo $CFG->wwwroot . '/course/regaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markallowlateapplication" value="1" />
<input type="submit" name="allowlateapplication" value="Allow this Student to make a Late Course Application (choose how long...)" style="width:40em" />
<select name="days_offset">
<option value="0" >By the end of today</option>
<option value="1" >By the end of tomorrow (1 day)</option>
<option value="2" selected="selected" >By the end of the day after tomorrow (2 days)</option>
<option value="3" >In 3 days</option>
<option value="4" >In 4 days</option>
<option value="5" >In 5 days</option>
<option value="6" >In 6 days</option>
<option value="7" >In 7 days</option>
</select>
<?php
  $late_applications_allowed = $DB->get_record('late_applications_allowed', array('userid' => $application->userid));
  if (!empty($late_applications_allowed)) {
    $deadline = $late_applications_allowed->deadline;
    if (time() < $deadline) {
      echo '<br />(Current Late Course Application Deadline is: ' . gmdate('d/m/Y H:i', $deadline) . ' am GMT)';
    }
  }
?>
</form>
<br /><br />
<?php
}


echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';

?>
<br /><br /><br /><br /><br /><br /><br /><br />
<form id="deleteentryform" method="post" action="<?php echo $CFG->wwwroot . '/course/regaction.php'; ?>" onSubmit="return areyousuredeleteentry()">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeleteentry" value="1" />
<input type="submit" name="deleteentry" value="Hide this Application Form Entry from All Future Processing" style="width:40em" />
</form>
<?php

echo $OUTPUT->footer();


function updateapplication($sid, $field, $value) {
  global $DB;

  $record = $DB->get_record('peoplesregistration', array('id' => $sid));
  $application = new object();
  $application->id = $record->id;
  $application->{$field} = $value;

  $DB->update_record('peoplesregistration', $application);
}
?>
