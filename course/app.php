<?php  // $Id: app.php,v 1.1 2008/08/02 17:18:32 alanbarrett Exp $
/**
*
* List a single course application
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
require_once($CFG->dirroot .'/course/peoples_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/app.php'); // Defined here to avoid notices on errors etc

//$PAGE->set_pagelayout('embedded');   // Needs as much space as possible
//$PAGE->set_pagelayout('base');     // Most backwards compatible layout without the blocks - this is the layout used by default
$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();

//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Student Details');
$PAGE->set_heading('Details for '. htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8') . ', ' . htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();

//print_header('Student Details');

if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');


echo '<script type="text/JavaScript">function areyousureunapp1() { var sure = false; sure = confirm("Are you sure you want to Un-Approve and possibly Un-Enrol ' . htmlspecialchars(dontstripslashes($_REQUEST['2']), ENT_COMPAT, 'UTF-8') . ' ' . htmlspecialchars(dontstripslashes($_REQUEST['1']), ENT_COMPAT, 'UTF-8') . ' from ' . htmlspecialchars(dontstripslashes($_REQUEST['18']), ENT_COMPAT, 'UTF-8') . '?"); return sure;}</script>';
echo '<script type="text/JavaScript">function areyousureunapp2() { var sure = false; sure = confirm("Are you sure you want to Un-Approve and possibly Un-Enrol ' . htmlspecialchars(dontstripslashes($_REQUEST['2']), ENT_COMPAT, 'UTF-8') . ' ' . htmlspecialchars(dontstripslashes($_REQUEST['1']), ENT_COMPAT, 'UTF-8') . ' from ' . htmlspecialchars(dontstripslashes($_REQUEST['19']), ENT_COMPAT, 'UTF-8') . '?"); return sure;}</script>';
echo '<script type="text/JavaScript">function areyousuredeleteentry() { var sure = false; sure = confirm("Are you sure you want to Hide this Application Form Entry for ' . htmlspecialchars(dontstripslashes($_REQUEST['2']), ENT_COMPAT, 'UTF-8') . ' ' . htmlspecialchars(dontstripslashes($_REQUEST['1']), ENT_COMPAT, 'UTF-8') . ' from All Future Processing?"); return sure;}</script>';


$activemodules = $DB->get_records('activemodules', NULL, 'fullname ASC');

$modules = array();
foreach ($activemodules as $activemodule) {
	$modules[] = $activemodule->fullname;
}


$refreshparent = false;
if (!empty($_POST['markapp1']) && !empty($_POST['18'])) {

  updateapplication($_POST['sid'], 'state', $_POST['state'], 1, $_POST['18']);

	$refreshparent = true;
}
if (!empty($_POST['markapp2']) && !empty($_POST['19'])) {

  updateapplication($_POST['sid'], 'state', $_POST['state'], 1, $_POST['19']);

	$refreshparent = true;
}
if (!empty($_POST['markunapp1']) && !empty($_POST['18'])) {

  updateapplication($_POST['sid'], 'state', $_POST['state'], -1, $_POST['18']);

	$refreshparent = true;
	if (!empty($_POST['29']) && !empty($_POST['18'])) {
		unenrolstudent($_POST['29'], $_POST['18']);
	}
}
if (!empty($_POST['markunapp2']) && !empty($_POST['19'])) {

  updateapplication($_POST['sid'], 'state', $_POST['state'], -1, $_POST['19']);

	$refreshparent = true;
	if (!empty($_POST['29']) && !empty($_POST['19'])) {
		unenrolstudent($_POST['29'], $_POST['19']);
	}
}
if (!empty($_POST['change1'])) {

	updateapplication($_POST['sid'], 'coursename1', $_REQUEST['18']);

	$refreshparent = true;
}
if (!empty($_POST['change2']) && !empty($_POST['19'])) {

	updateapplication($_POST['sid'], 'coursename2', $_REQUEST['19']);

	$refreshparent = true;
}
if (!empty($_POST['add2newapproved']) && !empty($_POST['19'])) {

  updateapplication($_POST['sid'], 'coursename2', $_REQUEST['19'], 1, $_POST['19']); // 1 => Need to increase payment for new approved module

  $refreshparent = true;
}
if (!empty($_POST['markreadyenrol'])) {

  updateapplication($_POST['sid'], 'ready', 1);

  $refreshparent = true;
}
if (!empty($_POST['markmph']) && !empty($_POST['mphstatus'])) {
  if (!empty($_REQUEST['29'])) $useridforsearch = $_REQUEST['29'];
  else $useridforsearch = 0;
  if (!empty($_REQUEST['sid'])) $sidforsearch = $_REQUEST['sid'];
  else  $sidforsearch = 0;
  $inmph = FALSE;
  $mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE (sid=$sidforsearch AND sid!=0) OR (userid=$useridforsearch AND userid!=0)");
  if (!empty($mphs)) {
    foreach ($mphs as $mph) {
      $inmph = TRUE;
    }
  }
  if (!$inmph) { // Protect against duplicate submission

    $newmph = new stdClass();
    if (!empty($_REQUEST['29']))  $newmph->userid = $_REQUEST['29'];
    if (!empty($_REQUEST['sid'])) $newmph->sid    = $_REQUEST['sid'];

    $newmph->datesubmitted = time();
    $mphstatus = (int)$_POST['mphstatus'];
    $newmph->mphstatus = $mphstatus;
    if     ($mphstatus == 1) $mphuniversity = 'MMU MPH';
    elseif ($mphstatus == 3) $mphuniversity = 'EUCLID MPH';
    elseif ($mphstatus == 4) $mphuniversity = 'FPD MPH';
    else                     $mphuniversity = 'Peoples-uni MPH';
    $newmph->note = '';
    $DB->insert_record('peoplesmph', $newmph);

    if (!empty($newmph->userid)) {

      $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $newmph->userid));
      if (!empty($peoplesmph2)) {
        $peoplesmph2->datesubmitted = $newmph->datesubmitted;
        $peoplesmph2->mphstatus = $newmph->mphstatus;
        $peoplesmph2->note = $peoplesmph2->note . "<br />Enrolled in {$mphuniversity}: " . gmdate('d/m/Y H:i', $newmph->datesubmitted);
        $DB->update_record('peoplesmph2', $peoplesmph2);
      }
      else {
        $peoplesmph2 = new stdClass();
        $peoplesmph2->userid = $newmph->userid;
        $peoplesmph2->datesubmitted = $newmph->datesubmitted;
        $peoplesmph2->datelastunentolled = 0;
        $peoplesmph2->mphstatus = $newmph->mphstatus;
        $peoplesmph2->graduated = 0;
        $peoplesmph2->semester_graduated = '';
        $peoplesmph2->note = "Enrolled in {$mphuniversity}: " . gmdate('d/m/Y H:i', $newmph->datesubmitted);
        $DB->insert_record('peoplesmph2', $peoplesmph2);
      }

      if ($peoplesmph2->mphstatus == 1) { // 1 => MMU MPH
        $amount_to_pay_total = get_balance($newmph->userid);

        $peoples_student_balance = new stdClass();
        $peoples_student_balance->userid = $newmph->userid;
        $peoples_student_balance->amount_delta = 1500;
        $peoples_student_balance->balance = $amount_to_pay_total + $peoples_student_balance->amount_delta;
        $peoples_student_balance->balance = round($peoples_student_balance->balance, 2);
        if ($peoples_student_balance->balance == '-0') $peoples_student_balance->balance = 0;
        $peoples_student_balance->currency = 'GBP';
        $peoples_student_balance->detail = "Initial Full amount for {$mphuniversity}";
        $peoples_student_balance->date = time();
        $DB->insert_record('peoples_student_balance', $peoples_student_balance);
      }

      $user = $DB->get_record('user', array('id' => $peoplesmph2->userid));

      $subject = 'Peoples-uni MPH Programme Application Approved';
      $body = "Dear $user->firstname,

Your application to join the MPH Programme has been approved.
Please ensure you are familiar with the academic award criteria and regulations at this link:
https://www.peoples-uni.org/content/peoples-uni-public-health-masters-level-award-programme-curriculum

We hope you enjoy studying with us and wish you every success.

     Peoples Open Access Education Initiative Administrator.
";
      sendapprovedmail($user->email, $subject, $body);
    }

    $refreshparent = true;
  }
}
if (!empty($_POST['markunenrollmph'])) {
  if (!empty($_REQUEST['29'])) {
    $peoplesmph2userid = $_REQUEST['29'];

    $DB->delete_records('peoplesmph', array('userid' => $peoplesmph2userid));

    $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $peoplesmph2userid));
    if (!empty($peoplesmph2)) {
      $peoplesmph2->datelastunentolled = time();
      $peoplesmph2->mphstatus = 0;

      if (!empty($_REQUEST['note'])) $usernote = ' (' . htmlspecialchars($_REQUEST['note'], ENT_COMPAT, 'UTF-8') . ')';
      else  $usernote = '';
      $peoplesmph2->note = $peoplesmph2->note . '<br />Unenrolled from MPH: ' . gmdate('d/m/Y H:i', $peoplesmph2->datelastunentolled) . $usernote;

      $DB->update_record('peoplesmph2', $peoplesmph2);
    }

    $refreshparent = true;
  }
}
if (!empty($_POST['markunsuspendmph'])) {
  if (!empty($_REQUEST['29'])) {
    $peoplesmph2userid = $_REQUEST['29'];

    $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $peoplesmph2userid));
    if (!empty($peoplesmph2)) {
      $peoplesmph2->suspended = 0;

      if (!empty($_REQUEST['note'])) $usernote = ' (' . htmlspecialchars($_REQUEST['note'], ENT_COMPAT, 'UTF-8') . ')';
      else  $usernote = '';
      $peoplesmph2->note = $peoplesmph2->note . '<br />Unsuspended from MPH: ' . gmdate('d/m/Y H:i', time()) . $usernote;

      $DB->update_record('peoplesmph2', $peoplesmph2);
    }

    //$refreshparent = true;
  }
}
if (!empty($_POST['marksuspendmph'])) {
  if (!empty($_REQUEST['29'])) {
    $peoplesmph2userid = $_REQUEST['29'];

    $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $peoplesmph2userid));
    if (!empty($peoplesmph2)) {
      $peoplesmph2->suspended = 1;

      if (!empty($_REQUEST['note'])) $usernote = ' (' . htmlspecialchars($_REQUEST['note'], ENT_COMPAT, 'UTF-8') . ')';
      else  $usernote = '';
      $peoplesmph2->note = $peoplesmph2->note . '<br />Suspended from MPH: ' . gmdate('d/m/Y H:i', time()) . $usernote;

      $DB->update_record('peoplesmph2', $peoplesmph2);
    }

    //$refreshparent = true;
  }
}
if (!empty($_POST['mark_ceatup']) && !empty($_REQUEST['29'])) {

  $peoples_ceatup = $DB->get_record('peoples_ceatup', array('userid' => $_REQUEST['29']));
  if (!empty($peoples_ceatup)) {
    $peoples_ceatup->datesubmitted = time();
    $peoples_ceatup->ceatup_status = 1;
    $peoples_ceatup->note = $peoples_ceatup->note . '<br />Enrolled in Enterprises University of Pretoria: ' . gmdate('d/m/Y H:i', $peoples_ceatup->datesubmitted);
    $DB->update_record('peoples_ceatup', $peoples_ceatup);
  }
  else {
    $peoples_ceatup = new stdClass();
    $peoples_ceatup->userid = $_REQUEST['29'];
    $peoples_ceatup->datesubmitted = time();
    $peoples_ceatup->datelastunentolled = 0;
    $peoples_ceatup->ceatup_status = 1;
    $peoples_ceatup->note = 'Enrolled in Enterprises University of Pretoria: ' . gmdate('d/m/Y H:i', $peoples_ceatup->datesubmitted);
    $DB->insert_record('peoples_ceatup', $peoples_ceatup);
  }

  $refreshparent = true;
}
if (!empty($_POST['markunenroll_ceatup']) && !empty($_REQUEST['29'])) {

  $peoples_ceatup = $DB->get_record('peoples_ceatup', array('userid' => $_REQUEST['29']));
  if (!empty($peoples_ceatup)) {
    $peoples_ceatup->datelastunentolled = time();
    $peoples_ceatup->ceatup_status = 0;

    if (!empty($_REQUEST['note'])) $usernote = ' (' . htmlspecialchars($_REQUEST['note'], ENT_COMPAT, 'UTF-8') . ')';
    else  $usernote = '';
    $peoples_ceatup->note = $peoples_ceatup->note . '<br />Unenrolled from Enterprises University of Pretoria: ' . gmdate('d/m/Y H:i', $peoples_ceatup->datelastunentolled) . $usernote;

    $DB->update_record('peoples_ceatup', $peoples_ceatup);
  }

  $refreshparent = true;
}
if (!empty($_POST['markcert_ps']) && !empty($_REQUEST['29'])) {

  $peoples_cert_ps = $DB->get_record('peoples_cert_ps', array('userid' => $_REQUEST['29']));
  if (!empty($peoples_cert_ps)) {
    $peoples_cert_ps->datesubmitted = time();
    $peoples_cert_ps->cert_psstatus = 1;
    $peoples_cert_ps->note = $peoples_cert_ps->note . '<br />Enrolled in Certificate in Patient Safety: ' . gmdate('d/m/Y H:i', $peoples_cert_ps->datesubmitted);
    $DB->update_record('peoples_cert_ps', $peoples_cert_ps);
  }
  else {
    $peoples_cert_ps = new stdClass();
    $peoples_cert_ps->userid = $_REQUEST['29'];
    $peoples_cert_ps->datesubmitted = time();
    $peoples_cert_ps->datelastunentolled = 0;
    $peoples_cert_ps->cert_psstatus = 1;
    $peoples_cert_ps->note = 'Enrolled in Certificate in Patient Safety: ' . gmdate('d/m/Y H:i', $peoples_cert_ps->datesubmitted);
    $DB->insert_record('peoples_cert_ps', $peoples_cert_ps);
  }

  $refreshparent = true;
}
if (!empty($_POST['markunenrollcert_ps']) && !empty($_REQUEST['29'])) {

  $peoples_cert_ps = $DB->get_record('peoples_cert_ps', array('userid' => $_REQUEST['29']));
  if (!empty($peoples_cert_ps)) {
    $peoples_cert_ps->datelastunentolled = time();
    $peoples_cert_ps->cert_psstatus = 0;

    if (!empty($_REQUEST['note'])) $usernote = ' (' . htmlspecialchars($_REQUEST['note'], ENT_COMPAT, 'UTF-8') . ')';
    else  $usernote = '';
    $peoples_cert_ps->note = $peoples_cert_ps->note . '<br />Unenrolled from Certificate in Patient Safety: ' . gmdate('d/m/Y H:i', $peoples_cert_ps->datelastunentolled) . $usernote;

    $DB->update_record('peoples_cert_ps', $peoples_cert_ps);
  }

  $refreshparent = true;
}
if (!empty($_POST['markincomecat'])) {
  $userid = $_REQUEST['29'];

  $peoples_income_category = $DB->get_record('peoples_income_category', array('userid' => $userid));
  if (!empty($peoples_income_category)) {
    $peoples_income_category->datesubmitted = time();
    $peoples_income_category->income_category = $_POST['income_category'];
    $DB->update_record('peoples_income_category', $peoples_income_category);
  }
  else {
    $peoples_income_category = new stdClass();
    $peoples_income_category->userid = $userid;
    $peoples_income_category->datesubmitted = time();
    $peoples_income_category->income_category = $_POST['income_category'];
    $DB->insert_record('peoples_income_category', $peoples_income_category);
  }
}
if (!empty($_POST['note']) && !empty($_POST['markaddnote'])) {
  $newnote = new stdClass();
  if (!empty($_REQUEST['29']))  $newnote->userid = $_REQUEST['29'];
  if (!empty($_REQUEST['sid'])) $newnote->sid    = $_REQUEST['sid'];

  $newnote->datesubmitted = time();

  // textarea with hard wrap will send CRLF so we end up with extra CRs, so we should remove \r's for niceness
  $newnote->note = dontaddslashes(str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars(dontstripslashes($_POST['note']), ENT_COMPAT, 'UTF-8'))));
  $DB->insert_record('peoplesstudentnotes', $newnote);

  $refreshparent = true;
}
if (!empty($_POST['markchangeemail']) && !empty($_POST['11'])) {
  $_REQUEST['11'] = trim($_REQUEST['11']);

  updateapplication($_POST['sid'], 'email', $_REQUEST['11']);

  $refreshparent = true;
}
if (!empty($_POST['markaddnewmodule']) && !empty($_POST['newmodulename']) && !empty($_POST['29'])) {

  $user = $DB->get_record('user', array('id' => $_REQUEST['29']));

  $course = $DB->get_record('course', array('fullname' => $_POST['newmodulename']));

  enrolincourse($course, $user, $_REQUEST['16']);

  $teacher = get_peoples_teacher($course);

  $a = new stdClass();
  $a->course = $course->fullname;
  $a->user = fullname($user);
  //$teacher->email = 'alanabarrett0@gmail.com';
  email_to_user($teacher, $user, get_string('enrolmentnew', 'enrol', $course->shortname), get_string('enrolmentnewuser', 'enrol', $a));

  updateapplication($_POST['sid'], 'dummyfieldname', 'dummyfieldvalue', 1, $_POST['newmodulename']);
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


$sid = $_REQUEST['sid'];

$application = $DB->get_record('peoplesapplication', array('sid' => $_REQUEST['sid']));

$not_confirmed_text = '';

if (!empty($application->userid)) {
  $amount_to_pay_total = get_balance($application->userid);
  $payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $application->userid));
  $amount_to_pay_this_semester = amount_to_pay($application->userid);
  if (is_not_confirmed($application->userid)) $not_confirmed_text = ' (not confirmed)';
}
else {
  $amount_to_pay_total = 0;
  $amount_to_pay_this_semester = 0;
}


$state = (int)$_REQUEST['state'];
if ($state === 0) {
	$state = 022;
}
$state1 = $state & 07;
$state2 = $state & 070;

$_REQUEST['1'] = dontstripslashes($_REQUEST['1']);
$_REQUEST['2'] = dontstripslashes($_REQUEST['2']);
$_REQUEST['11'] = dontstripslashes($_REQUEST['11']);
$_REQUEST['16'] = dontstripslashes($_REQUEST['16']);
$_REQUEST['18'] = dontstripslashes($_REQUEST['18']);
$_REQUEST['19'] = dontstripslashes($_REQUEST['19']);
$_REQUEST['12'] = dontstripslashes($_REQUEST['12']);
$_REQUEST['3'] = dontstripslashes($_REQUEST['3']);
$_REQUEST['14'] = dontstripslashes($_REQUEST['14']);
$_REQUEST['13'] = dontstripslashes($_REQUEST['13']);
$_REQUEST['34'] = dontstripslashes($_REQUEST['34']);
$_REQUEST['35'] = dontstripslashes($_REQUEST['35']);
$_REQUEST['36'] = dontstripslashes($_REQUEST['36']);
$_REQUEST['7'] = dontstripslashes($_REQUEST['7']);
$_REQUEST['8'] = dontstripslashes($_REQUEST['8']);
$_REQUEST['10'] = dontstripslashes($_REQUEST['10']);
$_REQUEST['31'] = dontstripslashes($_REQUEST['31']);
$_REQUEST['32'] = dontstripslashes($_REQUEST['32']);
$_REQUEST['21'] = dontstripslashes($_REQUEST['21']);

$_REQUEST['1'] = strip_tags($_REQUEST['1']);
$_REQUEST['2'] = strip_tags($_REQUEST['2']);
$_REQUEST['11'] = strip_tags($_REQUEST['11']);
$_REQUEST['14'] = strip_tags($_REQUEST['14']);
$_REQUEST['13'] = strip_tags($_REQUEST['13']);
$_REQUEST['34'] = strip_tags($_REQUEST['34']);
$_REQUEST['35'] = strip_tags($_REQUEST['35']);
$_REQUEST['36'] = strip_tags($_REQUEST['36']);
$_REQUEST['21'] = strip_tags($_REQUEST['21']);


//echo "<h1>Details for ".htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8').", ".htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8')."</h1>";

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";

echo "<tr>";
echo "<td>Family name</td>";
echo "<td>" . htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Given name</td>";
echo "<td>" . htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Email address</td>";
echo "<td>" . htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Semester</td>";
echo "<td>" . htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>First module</td>";
echo '<td>';
if ($state1 === 02) {
	echo '<span style="color:red">';
}
elseif ($state1 === 01) {
	echo '<span style="color:#FF8C00">';
}
elseif ($state1 === 03) {
	echo '<span style="color:green">';
}
else {
	echo '<span>';
}
echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8') . '</span></td>';
echo "</tr>";

echo "<tr>";
echo "<td>Second module</td>";
echo '<td>';
if ($state2 === 020) {
	echo '<span style="color:red">';
}
elseif ($state2 === 010) {
	echo '<span style="color:#FF8C00">';
}
elseif ($state2 === 030) {
	echo '<span style="color:green">';
}
else {
	echo '<span>';
}
echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8') . '</span></td>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Alternate module</td>";
echo '<td>';
echo htmlspecialchars($_REQUEST['alternatecoursename'], ENT_COMPAT, 'UTF-8') . '</td>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>DOB</td>";
echo "<td>" . $_REQUEST['dobday'] . "/" . $_REQUEST['dobmonth'] . "/" . $_REQUEST['dobyear'] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Gender</td>";
echo "<td>" . $_REQUEST['12'] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Address</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>City/Town</td>";
echo "<td>" . htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Country</td>";
$countryname = get_string_manager()->get_list_of_countries(false);
if (empty($countryname[$_REQUEST['13']])) echo "<td></td>";
else echo "<td>" . $countryname[$_REQUEST['13']] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Current Employment</td>";
if (empty($employmentname[$_REQUEST['36']])) echo "<td></td>";
else echo "<td>" . $employmentname[$_REQUEST['36']] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Current Employment Details</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Higher Education Qualification</td>";
if (empty($qualificationname[$_REQUEST['34']])) echo "<td></td>";
else echo "<td>" . $qualificationname[$_REQUEST['34']] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Postgraduate Qualification</td>";
if (empty($higherqualificationname[$_REQUEST['35']])) echo "<td></td>";
else echo "<td>" . $higherqualificationname[$_REQUEST['35']] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Other relevant qualifications or educational experience</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Reasons for wanting to enrol</td>";
echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'))) . "</td>";
echo "</tr>";

$registration = $DB->get_record('peoplesregistration', array('userid' => $application->userid), '*', IGNORE_MULTIPLE);
if (empty($registration)) {
  $registration = new stdClass();
  $registration->whatlearn = '';
  $registration->whylearn = '';
  $registration->whyelearning = '';
  $registration->howuselearning = '';
  $registration->howfoundorganisationname = '';
  $registration->howfoundpeoples = '';
}
echo '<tr>';
echo '<td>What do you want to learn?</td>';
$z = '';
$arrayvalues = explode(',', $registration->whatlearn);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $whatlearnname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Why do you want to learn?</td>';
$z = '';
$arrayvalues = explode(',', $registration->whylearn);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $whylearnname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>What are the reasons you want to do an e-learning course?</td>';
$z = '';
$arrayvalues = explode(',', $registration->whyelearning);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $whyelearningname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>How will you use your new knowledge and skills to improve population health?</td>';
$z = '';
$arrayvalues = explode(',', $registration->howuselearning);
foreach ($arrayvalues as $v) {
 if (!empty($v)) $z .= $howuselearningname[$v] . '<br />';
}
echo '<td>' . $z . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Sponsoring organisation</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'))) . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>How heard about Peoples-uni</td>';
if (empty($howfoundpeoplesname[$registration->howfoundpeoples])) echo "<td></td>";
else echo "<td>" . $howfoundpeoplesname[$registration->howfoundpeoples] . "</td>";
echo '</tr>';
echo '<tr>';
echo '<td>Name of the organisation or person from whom you heard about Peoples-uni</td>';
echo '<td>' . $registration->howfoundorganisationname . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Scholarship</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'))) . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Why Not Completed Previous Semester</td>';
echo '<td>' . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'))) . '</td>';
echo '</tr>';

//echo "<tr>";
//echo "<td>Method of payment</td>";
//echo "<td>" . $_REQUEST['31'] . "</td>";
//echo "</tr>";
//echo "<tr>";
//echo "<td>Payment Identification</td>";
//echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'))) . "</td>";
//echo "</tr>";

echo '<tr>';
echo '<td>Desired Moodle Username</td>';
echo '<td>' . htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8') . '</td>';
echo '</tr>';

//if (!empty($_REQUEST['29'])) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/student_completion.php?course=' . get_config(NULL, 'foundations_public_health_id') . '&userid=' . $_REQUEST['29'] . '" target="_blank">Student Foundations Public Health Completion</a></td></tr>';
if (!empty($_REQUEST['29'])) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/student.php?id=' . $_REQUEST['29'] . '" target="_blank">Student Grades</a></td></tr>';
if (!empty($_REQUEST['29'])) echo '<tr><td></td><td><a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $_REQUEST['29'] . '" target="_blank">Student Submissions</a></td></tr>';

echo '<tr>';
echo '<td>sid</td>';
echo '<td>' . $_REQUEST['sid'] . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Income Category (<span style="color:red">ensure correct before approving applications, can be changed below</span>)</td>';
if (!empty($_REQUEST['29'])) $userid = $_REQUEST['29'];
else $userid = 0;
$income_category = get_income_category($userid);
$income_category_text = array(0 => 'Existing Student', 1 => 'LMIC', 2 => 'HIC');
echo '<td>' . $income_category_text[$income_category] . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Payment up to date? (amount owed includes modules already approved for this semester or any MPH instalments due this semester)</td>';
echo '<td>';
if ($amount_to_pay_this_semester >= .01) echo '<span style="color:red">No: &pound;' . $amount_to_pay_this_semester . ' Owed now' . $not_confirmed_text . '</span>';
elseif (abs($amount_to_pay_this_semester) < .01) echo '<span style="color:green">Yes' . $not_confirmed_text . '</span>';
else echo '<span style="color:blue">' . "Overpaid: &pound;$amount_to_pay_this_semester" . $not_confirmed_text . '</span>'; // Will never be Overpaid here because of function used
echo '<br /><a href="' . $CFG->wwwroot . '/course/payconfirm.php?sid=' . $_REQUEST['sid'] . '" target="_blank">Update Payment Amounts, Method, Confirmed Status or Scholarship</a>';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Total Payment Owed (might be more because of future instalments)</td>';
$neg_amount_to_pay_total = -$amount_to_pay_total;
if ($amount_to_pay_total >= .01) $x = '<span style="color:red">&pound;' . $amount_to_pay_total . '</span>';
elseif (abs($amount_to_pay_total) < .01) $x = '<span style="color:green">Nothing</span>';
else $x = '<span style="color:blue">' . "Overpaid: &pound;$neg_amount_to_pay_total" . '</span>';
$balances = $DB->get_records_sql("
  SELECT
    b.userid
  FROM mdl_peoples_student_balance b
  WHERE
    b.detail LIKE '%scholarship%' OR
    b.detail LIKE '%bursa%' OR
    b.detail LIKE '%busar%' OR
    b.detail LIKE '%bursr%'
  GROUP BY b.userid");
if (empty($balances)) {
  $balances = array();
}
if (!empty($balances[$application->userid])) {
  $x .= '<br />(Previously given a Bursary)';
}
if (!empty($application->userid)) $peoples_decision = $DB->get_record('peoples_decision', array('userid' => $application->userid));
if (!empty($peoples_decision)) {
  if ($peoples_decision->decided_scholarship == 1) $x .= '<br />(Multi-Semester Bursary Approved)';
  if ($peoples_decision->decided_scholarship == 2) $x .= '<br />(Multi-Semester Bursary Rejected)';
}
echo '<td>' . $x;
echo '<br /><a href="' . $CFG->wwwroot . '/course/payconfirm.php?sid=' . $_REQUEST['sid'] . '" target="_blank">Update Payment Amounts, Method, Confirmed Status or Scholarship</a>';
echo '</td>';
echo '</tr>';

if (empty($application->paymentmechanism)) $mechanism = '';
elseif ($application->paymentmechanism == 1) $mechanism = 'RBS WorldPay Confirmed';
elseif ($application->paymentmechanism == 2) $mechanism = 'Barclays Bank Transfer';
elseif ($application->paymentmechanism == 3) $mechanism = 'Diamond Bank Transfer';
elseif ($application->paymentmechanism == 10) $mechanism = 'Ecobank Transfer';
elseif ($application->paymentmechanism == 4) $mechanism = 'Western Union';
elseif ($application->paymentmechanism == 5) $mechanism = 'Indian Confederation';
elseif ($application->paymentmechanism == 6) $mechanism = 'Promised End Semester';
elseif ($application->paymentmechanism == 7) $mechanism = 'Posted Travellers Cheques';
elseif ($application->paymentmechanism == 8) $mechanism = 'Posted Cash';
elseif ($application->paymentmechanism == 9) $mechanism = 'MoneyGram';
elseif ($application->paymentmechanism == 100) $mechanism = 'Waiver';
elseif ($application->paymentmechanism == 102) $mechanism = 'Barclays Bank Transfer Confirmed';
elseif ($application->paymentmechanism == 103) $mechanism = 'Diamond Bank Transfer Confirmed';
elseif ($application->paymentmechanism == 110) $mechanism = 'Ecobank Transfer Confirmed';
elseif ($application->paymentmechanism == 104) $mechanism = 'Western Union Confirmed';
elseif ($application->paymentmechanism == 105) $mechanism = 'Indian Confederation Confirmed';
elseif ($application->paymentmechanism == 107) $mechanism = 'Posted Travellers Cheques Confirmed';
elseif ($application->paymentmechanism == 108) $mechanism = 'Posted Cash Confirmed';
elseif ($application->paymentmechanism == 109) $mechanism = 'MoneyGram Confirmed';
else  $mechanism = '';

$pnote = '';
$paymentnotes = $DB->get_records_sql("SELECT * FROM mdl_peoplespaymentnote WHERE (sid=$sid AND sid!=0) OR (userid={$application->userid} AND userid!=0) ORDER BY datesubmitted DESC");
if (!empty($paymentnotes)) {
  $pnote .= '<br />(Payment Note Present)';
}

echo '<tr>';
echo '<td>Payment Method</td>';
echo '<td>' . $mechanism;
echo '<br /><a href="' . $CFG->wwwroot . '/course/payconfirm.php?sid=' . $_REQUEST['sid'] . '" target="_blank">Update Payment Amounts, Method, Confirmed Status or Scholarship</a>';
echo $pnote;
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Date Paid</td>';
if (empty($application->datepaid)) echo '<td></td>';
else echo '<td>' . gmdate('d/m/Y H:i', $application->datepaid) . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Payment Info</td>';
echo '<td>' . htmlspecialchars($application->datafromworldpay, ENT_COMPAT, 'UTF-8') . '</td>';
echo '</tr>';

if ($application->nid != 80) {
  echo '<tr>';
  echo '<td>Confirmed Ready to Enrol?<br />(Can set below)</td>';
  echo '<td>' . ($application->ready ? 'Yes' : 'No') . '</td>';
  echo '</tr>';
}

$notes = $DB->get_records_sql("SELECT * FROM mdl_peoplesstudentnotes WHERE (sid=$sid AND sid!=0) OR (userid={$application->userid} AND userid!=0) ORDER BY datesubmitted DESC");
if (!empty($notes)) {
  echo '<tr><td colspan="2">Notes (can add more below)...</td></tr>';

  foreach ($notes as $note) {
    echo '<tr><td>';
    echo gmdate('d/m/Y H:i', $note->datesubmitted);
    echo '</td><td>';
    echo $note->note;
    echo '</td></tr>';
  }
}

$applyceatuptext = array(0 => '', 1 => '');
$applyceatuptext[2] = 'Says enrolling with Enterprises University of Pretoria';
$applyceatuptext = $applyceatuptext[$application->applyceatup];

if (!empty($application->userid)) $peoples_ceatup = $DB->get_record('peoples_ceatup', array('userid' => $application->userid));
else $peoples_ceatup = NULL;

if (!empty($applyceatuptext) || !empty($peoples_ceatup->note)) {
  echo '<tr><td colspan="2">Enterprises University of Pretoria Status...</td></tr>';

  if (!empty($applyceatuptext)) echo '<tr><td></td><td>' . $applyceatuptext . '</td></tr>';

  if (!empty($peoples_ceatup->note)) echo '<tr><td></td><td>' . $peoples_ceatup->note . '</td></tr>';
}

$applymmumphtext = array('0' => '', '1' => '', '2' => 'Wants to Apply for MMU MPH', '3' => 'Says Already in MMU MPH');
$applymmumphtext['2'] = 'Wants to Apply for MMU MPH';
$applymmumphtext['3'] = 'Says already in MMU MPH';
$applymmumphtext['4'] = 'Wants to Apply for Peoples-uni MPH';
$applymmumphtext['5'] = 'Says already in Peoples-uni MPH';
$applymmumphtext['6'] = 'Wants to Apply for EUCLID MPH';
$applymmumphtext['7'] = 'Says already in EUCLID MPH';
$applymmumphtext['8'] = 'Says will enrol in MPH in future';
$applymmumphtext['9'] = 'Says will not enrol in MPH in future';
$applymmumphtext['10'] = 'Says already enrolled in FPD Pretoria MPH';
$applymmumphtext = $applymmumphtext[$_REQUEST['applymmumph']];

if (!empty($application->userid)) $peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $application->userid));
else $peoplesmph2 = NULL;

$mphstatus = get_mph_status($application->userid);
if (!empty($mphstatus) || !empty($applymmumphtext) || !empty($peoplesmph2->note)) {
  echo '<tr><td colspan="2">MPH Status...</td></tr>';

  if (!empty($applymmumphtext)) echo '<tr><td></td><td>' . $applymmumphtext . '</td></tr>';

  if (!empty($peoplesmph2->note)) echo '<tr><td></td><td>' . $peoplesmph2->note . '</td></tr>';
}

$take_final_assignmenttext = array('0' => '');
$take_final_assignmenttext['1'] = 'Intends to submit the final assignment for each module';
$take_final_assignmenttext['2'] = 'Would like to earn a Certificate of Participation';
$take_final_assignmenttext['3'] = 'Will study module materials without participating in discussions';
$take_final_assignmenttext = $take_final_assignmenttext[$_REQUEST['take_final_assignment']];

if (!empty($take_final_assignmenttext)) {
  echo '<tr>';
  echo '<td>Submit the Final Assignment for each module?</td>';
  echo "<td>$take_final_assignmenttext</td>";
  echo '</tr>';
}

$applycertpatientsafetytext = array('0' => '', '1' => '', '2' => 'Wants to Apply for Certificate in Patient Safety', '3' => 'Says Already in Certificate in Patient Safety');
$applycertpatientsafetytext = $applycertpatientsafetytext[$application->applycertpatientsafety];

if (!empty($application->userid)) $peoples_cert_ps = $DB->get_record('peoples_cert_ps', array('userid' => $application->userid));
else $peoples_cert_ps = NULL;

if (!empty($applycertpatientsafetytext) || !empty($peoples_cert_ps->note)) {
  echo '<tr><td colspan="2">Certificate in Patient Safety Status...</td></tr>';

  if (!empty($applycertpatientsafetytext)) echo '<tr><td></td><td>' . $applycertpatientsafetytext . '</td></tr>';

  if (!empty($peoples_cert_ps->note)) echo '<tr><td></td><td>' . $peoples_cert_ps->note . '</td></tr>';
}

if (!empty($application->userid)) {
  $dissertations = $DB->get_records_sql("
    SELECT d.*
    FROM mdl_peoplesdissertation d
    WHERE d.userid=$application->userid
    ORDER BY d.id DESC");
  if (!empty($dissertations)) {
    echo '<tr><td colspan="2">Student Dissertation Proposals...</td></tr>';
    foreach ($dissertations as $dissertation) {
      echo '<tr>';
      echo '<td>' . gmdate('d/m/Y H:i', $dissertation->datesubmitted) . '(<a href="' . $CFG->wwwroot . '/course/dissertations.php?chosensemester=All&displayforexcel=0#' . $dissertation->id . '" target="_blank">' . $dissertation->semester . '</a>)</td>';
      echo '<td><a href="' . $CFG->wwwroot . '/course/dissertations.php?chosensemester=All&displayforexcel=0#' . $dissertation->id . '" target="_blank">' . str_replace("\r", '', str_replace("\n", '<br />', $dissertation->dissertation)) . '</a></td>';
      echo '</tr>';
    }
  }
}

echo '</table>';

if ($state === 022) {
  $given_name = $_REQUEST['2'];
  $course1    = $_REQUEST['18'];
  $course2    = $_REQUEST['19'];

  if (!empty($application->userid)) $amount_to_pay_this_semester_adjusted = amount_to_pay_adjusted($application, $payment_schedule);
  else $amount_to_pay_this_semester_adjusted = 0;

  $instalments_allowed = instalments_allowed($application->userid);
  if (TRUE || !$instalments_allowed) $peoples_approval_email = get_config(NULL, 'peoples_approval_old_students_email');
  else $peoples_approval_email = get_config(NULL, 'peoples_approval_email'); // MPH Students

  $peoples_approval_email = str_replace('GIVEN_NAME_HERE',           $given_name, $peoples_approval_email);
  $peoples_approval_email = str_replace('COURSE_MODULE_1_NAME_HERE', $course1, $peoples_approval_email);
  $peoples_approval_email = str_replace('SID_HERE',                  $sid, $peoples_approval_email);
  $peoples_approval_email = str_replace('AMOUNT_TO_PAY_HERE',        $amount_to_pay_this_semester_adjusted, $peoples_approval_email);
  if (!empty($course2)) {
    $peoples_approval_email = str_replace('COURSE_MODULE_2_TEXT_HERE', "and the Course Module '" . $course2 . "' ", $peoples_approval_email);
    $peoples_approval_email = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', "Please note that you have applied to take two modules, these run at the
same time and will involve a heavy workload - please be sure you do have the time for this.", $peoples_approval_email);
  }
  else {
    $peoples_approval_email = str_replace('COURSE_MODULE_2_TEXT_HERE',         '', $peoples_approval_email);
    $peoples_approval_email = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', '', $peoples_approval_email);
  }
  if ($instalments_allowed && empty($payment_schedule)) {
    $peoples_approval_email = str_replace('NOTE_ON_INSTALMENTS_HERE', "If you wish to pay by instalments, you may select your preferences at https://courses.peoples-uni.org/course/specify_instalments.php (you will need to log in).", $peoples_approval_email);
  }
  else {
    $peoples_approval_email = str_replace('NOTE_ON_INSTALMENTS_HERE', "", $peoples_approval_email);
  }

  $peoples_approval_email = htmlspecialchars($peoples_approval_email, ENT_COMPAT, 'UTF-8');

  if (TRUE || !$instalments_allowed) $peoples_approval_email_bursary = get_config(NULL, 'peoples_approval_old_students_bursary_email');
  else $peoples_approval_email_bursary = get_config(NULL, 'peoples_approval_bursary_email'); // MPH Students

  $peoples_approval_email_bursary = str_replace('GIVEN_NAME_HERE',           $given_name, $peoples_approval_email_bursary);
  $peoples_approval_email_bursary = str_replace('COURSE_MODULE_1_NAME_HERE', $course1, $peoples_approval_email_bursary);
  $peoples_approval_email_bursary = str_replace('SID_HERE',                  $sid, $peoples_approval_email_bursary);
  if (!empty($course2)) {
    $peoples_approval_email_bursary = str_replace('COURSE_MODULE_2_TEXT_HERE', "and the Course Module '" . $course2 . "' ", $peoples_approval_email_bursary);
    $peoples_approval_email_bursary = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', "Please note that you have applied to take two modules, these run at the
same time and will involve a heavy workload - please be sure you do have the time for this.", $peoples_approval_email_bursary);
  }
  else {
    $peoples_approval_email_bursary = str_replace('COURSE_MODULE_2_TEXT_HERE',         '', $peoples_approval_email_bursary);
    $peoples_approval_email_bursary = str_replace('COURSE_MODULE_2_WARNING_TEXT_HERE', '', $peoples_approval_email_bursary);
  }

  $peoples_approval_email_bursary = htmlspecialchars($peoples_approval_email_bursary, ENT_COMPAT, 'UTF-8');

?>
<br />To approve this application and send an e-mail to applicant (edit e-mail text if you wish), press "Approve Full Application".
<br /><i><b>NOTE: Any student that is doing MPH or Enterprises University of Pretoria must, if not already so recorded,<br />
be recorded as MPH by clicking "Record that the Student has been enrolled in the MPH" BEFORE APPROVAL<br />
or as Enterprises University of Pretoria by clicking "Record that the Student has been enrolled in Enterprises University of Pretoria" BEFORE APPROVAL<br />
(to pick up correct wording for e-mail).</b></i>
<br /><i><b>NOTE: Please check the Amount Owed by the student (in e-mail below) looks OK before sending.<br />
To fix any issues <a href="<?php echo $CFG->wwwroot . '/course/payconfirm.php?sid=' . $application->sid; ?>" target="_blank">click here to Update Payment Amounts, Method, Confirmed Status or Scholarship</a></b></i>
<form id="approveapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<textarea name="approvedtext" rows="15" cols="75" wrap="hard" style="width:auto">
<?php echo $peoples_approval_email; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapproveapplication" value="1" />
<input type="submit" name="approveapplication" value="Approve Full Application" />
</form>
<br />

<br />To approve this application WITH BURSARY TEXT and send an e-mail to applicant (edit e-mail text if you wish), press "Approve Full Application BURSARY".
<form id="approveapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<textarea name="approvedtext" rows="15" cols="75" wrap="hard" style="width:auto">
<?php echo $peoples_approval_email_bursary; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapproveapplication" value="1" />
<input type="submit" name="approveapplication" value="Approve Full Application BURSARY" />
</form>
<br />
<?php
}
else {
	echo '<span style="color:green">This application is already (part) approved.</span><br />';
}

if ($state1 === 02) {
	if (empty($_REQUEST['19'])) {
		$newstate = 011;
	}
	else {
		$newstate = 01 | $state2;
	}
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapp1" value="1" />
<input type="submit" name="approveapplication1" value="Approve Module '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />(No e-mail sent!)
</form>
<br />
<?php
}

if (($state2===020) && !empty($_REQUEST['19'])) {
	if (empty($_REQUEST['19'])) {
		$newstate = 011;
	}
	else {
		$newstate = $state1 | 010;
	}
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markapp2" value="1" />
<input type="submit" name="approveapplication2" value="Approve Module '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />(No e-mail sent!)
</form>
<br />
<?php
}

if ($state1===01 || $state1===03) {
	if (empty($_REQUEST['19'])) {
		$newstate = 022;
	}
	else {
		$newstate = 02 | $state2;
	}
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>" onSubmit="return areyousureunapp1()">

<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markunapp1" value="1" />
<input type="submit" name="unapproveapplication1" value="Un-Approve Module: '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>'" style="width:40em" />(No e-mail sent!)
</form>
<br />
<?php
}

if (($state2===010 || $state2===030) && !empty($_REQUEST['19'])) {
	if (empty($_REQUEST['19'])) {
		$newstate = 022;
	}
	else {
		$newstate = $state1 | 020;
	}
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>" onSubmit="return areyousureunapp2()">

<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markunapp2" value="1" />
<input type="submit" name="unapproveapplication2" value="Un-Approve Module: '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>'" style="width:40em" />(No e-mail sent!)
</form>
<br />
<?php
}

if ($state1===02 || $state1===01) {
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="change1" value="1" />
<input type="submit" name="changename1" value="Change Module 1 Name from: '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' to:" style="width:40em" />
<select name="18">
<?php
foreach ($modules as $key => $modulename) {
	if ($modulename !== $_REQUEST['19']) {
		if ($modulename === $_REQUEST['18']) {
			$selected = ' selected="selected"';
		}
		else {
			$selected = '';
		}
		$modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
	}
}
?>
</select>
</form>
<br />
<?php
}

if (($state2===020 || $state2===010) && !empty($_REQUEST['19'])) { // Allow module 2 to be changed for unapproved or approved (but not enrolled) applications
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="change2" value="1" />
<input type="submit" name="changename2" value="Change Module 2 Name from: '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>' to:" style="width:40em" />

<select name="19">
<?php
foreach ($modules as $key => $modulename) {
	if ($modulename !== $_REQUEST['18']) {
		if ($modulename === $_REQUEST['19']) {
			$selected = ' selected="selected"';
		}
		else {
			$selected = '';
		}
		$modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
	}
}
?>
</select>
</form>
<br />
<?php
}
elseif ($state2 === 020 && empty($_REQUEST['19'])) { // Allow module 2 to be set for unapproved applications
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="change2" value="1" />
<input type="submit" name="changename2" value="Set Module 2 Name to:" style="width:40em" />

<select name="19">
<?php
foreach ($modules as $key => $modulename) {
  if ($modulename !== $_REQUEST['18']) {
    if ($modulename === $_REQUEST['19']) {
      $selected = ' selected="selected"';
    }
    else {
      $selected = '';
    }
    $modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
  }
}
?>
</select>
</form>
<br />
<?php
}
elseif ($state2 === 010 && empty($_REQUEST['19'])) { // Allow module 2 to be set for approved (but not enrolled) applications
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="add2newapproved" value="1" />
<input type="submit" name="changename2" value="Set Module 2 Name to (and mark as Approved):" style="width:40em" />

<select name="19">
<?php
foreach ($modules as $key => $modulename) {
  if ($modulename !== $_REQUEST['18']) {
    if ($modulename === $_REQUEST['19']) {
      $selected = ' selected="selected"';
    }
    else {
      $selected = '';
    }
    $modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
  }
}
?>
</select>
</form>
<br />
<?php
}
elseif ($state2 === 030 && empty($_REQUEST['19'])) {
  echo '<br />The student did not specify a second module. If you need to do that for them, you must first unapprove their first module, then specify a second module and then you may approve both.<br /><br />';
}

?>
<br />To send an e-mail to this applicant (EDIT the e-mail text below!), press "e-mail Applicant".
<form id="deferapplicationform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<textarea name="defertext" rows="10" cols="75" wrap="hard" style="width:auto">
Dear <?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>,

You have applied to take the Course Module '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>'
<?php if (!empty($_REQUEST['19'])) echo "and the Course Module '" . htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8') . "'"; ?>.

     Peoples Open Access Education Initiative Administrator.
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeferapplication" value="1" />
<input type="submit" name="deferapplication" value="e-mail Applicant" />
</form>
<br />
<?php

if (!empty($_REQUEST['29'])) {
  $userrecord = $DB->get_record('user', array('id' => dontaddslashes($_REQUEST['29'])));
}
elseif (!empty($_REQUEST['21'])) {
	if ($_REQUEST['nid'] === '80') echo 'ERROR, THIS SHOULD NOT HAPPEN, TALK TO ALAN<br /><br />';

  $userrecord = $DB->get_record('user', array('username' => dontaddslashes($_REQUEST['21'])));
}
if (!empty($userrecord)) {
	if (empty($_REQUEST['29'])) {
		echo "<strong>This applicant has not been Registered but there is already a Moodle user with the Username: '" . htmlspecialchars($userrecord->username, ENT_COMPAT, 'UTF-8') . "'...</strong>";
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
//	$assigments = get_records('role_assignments', 'userid', $userrecord->id);
//
//	echo '<br />';
//
//	foreach ($assigments as $key => $assigment) {
//		echo "id: $assigment->id,";
//		echo "roleid: $assigment->roleid,";
//		echo "contextid: $assigment->contextid,";
//		echo "enrol: $assigment->enrol<br />";
//	}
	if (empty($_REQUEST['29'])) {
    if (FALSE) {
?>
<br />If this user has been registered manually using Moodle Admin features, press "Update UserID" to mark that they have been registered. <strong>BE CAREFULL THAT THIS REALLY IS THE SAME PERSON!</strong>
<form id="appuseridform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="userid" value="<?php echo $userrecord->id ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdateuserid" value="1" />
<input type="submit" name="updateuserid" value="Update UserID" style="width:40em" />
</form>
<?php
    }
?>

<br />Enter a new suggested user name here (maybe add "1" at the end of the existing name) and then press "Update Username" (you will need to come back to this page to register them).
<form id="appusernameform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdateusername" value="1" />
<input type="submit" name="updateusername" value="Update Username to:" style="width:40em" />
<input type="text" size="40" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br />
<?php
	}
	else {
		// We have a Moodle UserID

		if ($state1 === 01) {
			if (empty($_REQUEST['19'])) {
				$newstate = 033;
			}
			else {
				$newstate = $state2 | 03;
			}
?>
<form id="appenroluserform1" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="userid" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo htmlspecialchars($_REQUEST['alternatecoursename'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markenroluser1" value="1" />
<input type="submit" name="enroluser1" value="Enrol User in Module '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />
</form>
<br />
<?php
		}
		if ($state2===010 && !empty($_REQUEST['19'])) {
			if (empty($_REQUEST['19'])) {
				$newstate = 033;
			}
			else {
				$newstate = $state1 | 030;
			}
?>
<form id="appenroluserform2" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="userid" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo htmlspecialchars($_REQUEST['alternatecoursename'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markenroluser2" value="1" />
<input type="submit" name="enroluser2" value="Enrol User in Module '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />
</form>
<br />
<?php
		}
		if ($state1===01 && $state2===010 && !empty($_REQUEST['19'])) {
			$newstate = 033;
?>
<form id="appenroluserform12" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="userid" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo htmlspecialchars($_REQUEST['alternatecoursename'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markenroluser12" value="1" />
<input type="submit" name="enroluser12" value="Enrol User in Modules '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' and '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>'" />
</form>
<br />
<?php
		}
	}
}
else {
	if ($_REQUEST['nid'] === '80') echo 'ERROR, THIS SHOULD NOT HAPPEN, TALK TO ALAN<br /><br />';
?>
No Moodle user with the Username: '<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>'...<br />
<?php
	if ($state1 === 01) {
		if (empty($_REQUEST['19'])) {
			$newstate = 033;
		}
		else {
			$newstate = $state2 | 03;
		}
?>
<form id="appcreateuserform1" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo htmlspecialchars($_REQUEST['alternatecoursename'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markcreateuser1" value="1" />
<input type="submit" name="createuser1" value="Create User & Enrol in Module '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />
</form>
<br />
<?php
	}
	if ($state2===010 && !empty($_REQUEST['19'])) {
		if (empty($_REQUEST['19'])) {
			$newstate = 033;
		}
		else {
			$newstate = $state1 | 030;
		}
?>
<form id="appcreateuserform2" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo htmlspecialchars($_REQUEST['alternatecoursename'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markcreateuser2" value="1" />
<input type="submit" name="createuser2" value="Create User & Enrol in Module '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>' only" style="width:40em" />
</form>
<br />
<?php
	}

	if ($state1===01 && $state2===010 && !empty($_REQUEST['19'])) {
		$newstate = 033;
?>
<form id="appcreateuserform12" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="state" value="<?php echo $newstate; ?>" />
<input type="hidden" name="username" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="email" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="city" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="country" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="qualification" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="higherqualification" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="employment" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename1" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="coursename2" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo htmlspecialchars($_REQUEST['alternatecoursename'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="semester" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="gender" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="applicationaddress" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="currentjob" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="education" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="reasons" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey; ?>" />
<input type="hidden" name="markcreateuser12" value="1" />
<input type="submit" name="createuser12" value="Create User & Enrol in Modules '<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>' and '<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>'" />
</form>
<br />
<?php
	}
}

if (!$application->ready && $application->nid != 80) {
?>
<br />To mark a student as having confirmed that they are ready to enrol, press "Confirm...".<br />
<form id="readyenrolform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markreadyenrol" value="1" />
<input type="submit" name="readyenrol" value="Confirm Student is Ready to Enrol" />
</form>
<br />
<?php
}

if (empty($mphstatus)) {
?>
<br />To record that the student has been enrolled in the Masters in Public Health (MPH), select programme & press "Record...".<br />
<form id="mphform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markmph" value="1" />
MPH&nbsp;programme:&nbsp;
<select name="mphstatus">
<option value="3" selected="selected">EUCLID MPH</option>
<option value="4"                    >FPD MPH</option>
<option value="2"                    >Peoples-uni MPH</option>
<option value="1"                    >MMU MPH</option>
</select>
<br />
<input type="submit" name="mph" value="Record that the Student has been enrolled in the MPH" />
</form>
<br />
<?php
}
elseif (!empty($_REQUEST['29'])) {
?>
<br />To Unenrol the student from the Masters in Public Health (MPH), press "Unenrol...".<br />
(This does not affect any course modules or payments.)<br />
<form id="unenrollmphform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markunenrollmph" value="1" />
Reason for Unenrolment (visible to Staff & Students):&nbsp;<input type="text" size="45" name="note" /><br />
<input type="submit" name="unenrollmph" value="Unenrol the student from the Masters in Public Health (MPH)" />
</form>
<br />
<?php
  $mphsuspended = get_mph_suspended($application->userid);
  if ($mphsuspended) {
?>
<br />To Unsuspend the student from the Masters in Public Health (MPH), press "Unsuspend...".<br />
(This does not affect any course modules or payments.)<br />
<form id="unsuspendmphform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markunsuspendmph" value="1" />
Reason for Unsuspension (visible to Staff & Students):&nbsp;<input type="text" size="45" name="note" /><br />
<input type="submit" name="unsuspendmph" value="Unsuspend student from the Masters in Public Health (MPH)" />
</form>
<br />
<?php
  }
  else {
?>
<br />To Suspend the student from the Masters in Public Health (MPH), press "Suspend...".<br />
(This does not affect any course modules or payments.)<br />
<form id="suspendmphform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="marksuspendmph" value="1" />
Reason for Suspension (visible to Staff & Students):&nbsp;<input type="text" size="45" name="note" /><br />
<input type="submit" name="suspendmph" value="Suspend student from the Masters in Public Health (MPH)" />
</form>
<br />
<?php
  }
}

if (empty($peoples_ceatup->ceatup_status)) {
?>
<br />To record that the student has been enrolled in Enterprises University of Pretoria, press "Record...".<br />
<form id="ceatup_form" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="mark_ceatup" value="1" />
<input type="submit" name="ceatup_name" value="Record that the Student has been enrolled in Enterprises University of Pretoria" />
</form>
<br />
<?php
}
elseif (!empty($_REQUEST['29'])) {
?>
<br />To Unenrol the student from Enterprises University of Pretoria, press "Unenrol...".<br />
(This does not affect any course modules or payments.)<br />
<form id="unenroll_ceatup_form" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markunenroll_ceatup" value="1" />
Reason for Unenrolment (visible to Staff & Student):&nbsp;<input type="text" size="45" name="note" /><br />
<input type="submit" name="unenroll_ceatup" value="Unenrol the student from Enterprises University of Pretoria" />
</form>
<br />
<?php
}

if (empty($peoples_cert_ps->cert_psstatus)) {
?>
<br />To record that the student has been enrolled in the Certificate in Patient Safety, press "Record...".<br />
<form id="cert_psform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markcert_ps" value="1" />
<input type="submit" name="cert_ps" value="Record that the Student has been enrolled in the Certificate in Patient Safety" />
</form>
<br />
<?php
}
elseif (!empty($_REQUEST['29'])) {
?>
<br />To Unenrol the student from the Certificate in Patient Safety, press "Unenrol...".<br />
(This does not affect any course modules or payments.)<br />
<form id="unenrollcert_psform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markunenrollcert_ps" value="1" />
Reason for Unenrolment (visible to Staff & Students):&nbsp;<input type="text" size="45" name="note" /><br />
<input type="submit" name="unenrollcert_ps" value="Unenrol the student from the Certificate in Patient Safety" />
</form>
<br />
<?php
}

if (!empty($_REQUEST['29'])) {
?>
<br />To set the Income Category for the student, select category & press "Set...".<br />
<form id="incomecatform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<input type="hidden" name="markincomecat" value="1" />
Income&nbsp;Category:&nbsp;
<select name="income_category">
<?php
$selected0 = '';
$selected1 = '';
$selected2 = '';
if ($income_category == 0) $selected0 = 'selected="selected"';
if ($income_category == 1) $selected1 = 'selected="selected"';
if ($income_category == 2) $selected2 = 'selected="selected"';
echo '<option value="0" ' . $selected0 . '>Existing Student</option>';
echo '<option value="1" ' . $selected1 . '>LMIC</option>';
echo '<option value="2" ' . $selected2 . '>HIC</option>';
?>
</select>
<br />
<input type="submit" name="incomecat" value="Set the Income Category for the Student" />
</form>
<br />
<?php
}
?>

<br />To add a note to this student's record, add text below and press "Add...".<br />
<form id="addnoteform" method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

<textarea name="note" rows="5" cols="100" wrap="hard" style="width:auto"></textarea>
<input type="hidden" name="markaddnote" value="1" />
<input type="submit" name="addnote" value="Add This Note to Student Record" />
</form>
<br />
<?php

if ($state1 !== 03 && $state2 !== 030 && empty($_REQUEST['29'])) { // Allow applicant e-mail to be changed
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />

<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markchangeemail" value="1" />
<input type="submit" name="changeemail" value="Change Applicant e-mail to:" style="width:40em" />

<input type="text" size="40" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
</form>
<br />
<?php
}

if ($state1 === 03 && $state2 === 030 && !empty($_REQUEST['19'])) { // Add another module (beyond 2)
?>

<form method="post" action="<?php echo $CFG->wwwroot . '/course/app.php'; ?>">

<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="29" value="<?php echo htmlspecialchars($_REQUEST['29'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="1" value="<?php echo htmlspecialchars($_REQUEST['1'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="2" value="<?php echo htmlspecialchars($_REQUEST['2'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="11" value="<?php echo htmlspecialchars($_REQUEST['11'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="16" value="<?php echo htmlspecialchars($_REQUEST['16'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="18" value="<?php echo htmlspecialchars($_REQUEST['18'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="19" value="<?php echo htmlspecialchars($_REQUEST['19'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="alternatecoursename" value="<?php echo $_REQUEST['alternatecoursename']; ?>" />
<input type="hidden" name="dobday" value="<?php echo $_REQUEST['dobday']; ?>" />
<input type="hidden" name="dobmonth" value="<?php echo $_REQUEST['dobmonth']; ?>" />
<input type="hidden" name="dobyear" value="<?php echo $_REQUEST['dobyear']; ?>" />
<input type="hidden" name="12" value="<?php echo htmlspecialchars($_REQUEST['12'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="14" value="<?php echo htmlspecialchars($_REQUEST['14'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="13" value="<?php echo htmlspecialchars($_REQUEST['13'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="34" value="<?php echo htmlspecialchars($_REQUEST['34'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="35" value="<?php echo htmlspecialchars($_REQUEST['35'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="36" value="<?php echo htmlspecialchars($_REQUEST['36'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="31" value="<?php echo htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="21" value="<?php echo htmlspecialchars($_REQUEST['21'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applyceatup" value="<?php echo htmlspecialchars($_REQUEST['applyceatup'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="applymmumph" value="<?php echo htmlspecialchars($_REQUEST['applymmumph'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="take_final_assignment" value="<?php echo htmlspecialchars($_REQUEST['take_final_assignment'], ENT_COMPAT, 'UTF-8'); ?>" />
<span style="display: none;">
<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['3'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['7'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['8'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['10'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['sponsoringorganisation'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['scholarship'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['whynotcomplete'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto"><?php echo htmlspecialchars($_REQUEST['32'], ENT_COMPAT, 'UTF-8'); ?></textarea>
</span>
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markaddnewmodule" value="1" />
<input type="submit" name="addnewmodule" value="Enrol Applicant in an Additional Module (beyond the normal 2):" />

<select name="newmodulename">
<?php
foreach ($modules as $key => $modulename) {
  if ($modulename !== $_REQUEST['18'] && $modulename !== $_REQUEST['19']) {
    $selected = '';
    $modulename = htmlspecialchars($modulename, ENT_COMPAT, 'UTF-8');
?>
<option value="<?php echo $modulename . '"' . $selected; ?> ><?php echo $modulename; ?></option>
<?php
  }
}
?>
</select>
<br />(Payment Balance will be increased accordingly.)
<br />(The module will not be listed at the top of this page or in applications.php where only two modules are shown, but will be seen as a valid course in the "User's courses" above and elsewhere throughout the system.)
</form>
<br />
<?php
}
else {
  echo '<br />In exceptional cases you may want to enrol an applicant in a 3rd (or further) module...';
  echo '<br />You can only do this AFTER they have been fully enrolled in their first and second modules.';
  echo '<br />The module will not be listed at the top of this page or in applications.php where only two modules are shown, but will be seen as a valid course in the "User\'s courses" above and elsewhere throughout the system.<br /><br />';
}


echo '<br /><strong><a href="javascript:window.close();">Close Window</a></strong>';

?>
<br /><br /><br /><br /><br /><br /><br /><br />
<form id="deleteentryform" method="post" action="<?php echo $CFG->wwwroot . '/course/appaction.php'; ?>" onSubmit="return areyousuredeleteentry()">
<input type="hidden" name="sid" value="<?php echo $_REQUEST['sid']; ?>" />
<input type="hidden" name="nid" value="<?php echo $_REQUEST['nid']; ?>" />
<input type="hidden" name="newpaymentmethod" value="<?php echo 'HIDDEN' . htmlspecialchars($_REQUEST['31'], ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markdeleteentry" value="1" />
<input type="submit" name="deleteentry" value="Hide this Application Form Entry from All Future Processing" style="width:40em" />
</form>
<?php

//print_footer();
echo $OUTPUT->footer();
?>
