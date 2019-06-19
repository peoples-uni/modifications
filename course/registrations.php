<?php  // $Id: registrations.php,v 1.1 2012/12/18 12:24:32 alanbarrett Exp $
/**
*
* List all Registration applications
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

$PAGE->set_url('/course/registrations.php'); // Defined here to avoid notices on errors etc

if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/registrations.php?'
    . '&chosenstatus=' . urlencode($_POST['chosenstatus'])
    . '&chosenstartyear=' . $_POST['chosenstartyear']
    . '&chosenstartmonth=' . $_POST['chosenstartmonth']
    . '&chosenstartday=' . $_POST['chosenstartday']
    . '&chosenendyear=' . $_POST['chosenendyear']
    . '&chosenendmonth=' . $_POST['chosenendmonth']
    . '&chosenendday=' . $_POST['chosenendday']
    . '&chosensearch=' . urlencode($_POST['chosensearch'])
    . (empty($_POST['displayextra']) ? '&displayextra=0' : '&displayextra=1')
    );
}
elseif (!empty($_POST['markemailsend']) && !empty($_POST['emailsubject']) && !empty($_POST['emailbody'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $sendemails = true;
}
else {
  $sendemails = false;
}


$PAGE->set_pagelayout('embedded');   // Needs as much space as possible


require_login();

// Access to registrations.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Student Registrations');
$PAGE->set_heading('Student Registrations');
echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


echo "<h1>Student Registrations</h1>";

if (!empty($_REQUEST['chosenstatus'])) $chosenstatus = $_REQUEST['chosenstatus'];
if (!empty($_REQUEST['chosenstartyear']) && !empty($_REQUEST['chosenstartmonth']) && !empty($_REQUEST['chosenstartday'])) {
  $chosenstartyear = (int)$_REQUEST['chosenstartyear'];
  $chosenstartmonth = (int)$_REQUEST['chosenstartmonth'];
  $chosenstartday = (int)$_REQUEST['chosenstartday'];
  $starttime = gmmktime(0, 0, 0, $chosenstartmonth, $chosenstartday, $chosenstartyear);
}
else {
  $starttime = 0;
}
if (!empty($_REQUEST['chosenendyear']) && !empty($_REQUEST['chosenendmonth']) && !empty($_REQUEST['chosenendday'])) {
  $chosenendyear = (int)$_REQUEST['chosenendyear'];
  $chosenendmonth = (int)$_REQUEST['chosenendmonth'];
  $chosenendday = (int)$_REQUEST['chosenendday'];
  $endtime = gmmktime(24, 0, 0, $chosenendmonth, $chosenendday, $chosenendyear);
}
else {
  $endtime = 1.0E+20;
}
if (!empty($_REQUEST['chosensearch'])) $chosensearch = $_REQUEST['chosensearch'];
else $chosensearch = '';
if (!empty($_REQUEST['displayextra'])) $displayextra = true;
else $displayextra = false;

$liststatus[] = 'All';
if (!isset($chosenstatus)) $chosenstatus = 'All';
$liststatus[] = 'Not Registered';
$liststatus[] = 'Registered';

for ($i = 2008; $i <= (int)gmdate('Y'); $i++) {
  if (!isset($chosenstartyear)) $chosenstartyear = $i;
  $liststartyear[] = $i;
}

for ($i = 1; $i <= 12; $i++) {
  if (!isset($chosenstartmonth)) $chosenstartmonth = $i;
  $liststartmonth[] = $i;
}

for ($i = 1; $i <= 31; $i++) {
  if (!isset($chosenstartday)) $chosenstartday = $i;
  $liststartday[] = $i;
}

for ($i = (int)gmdate('Y'); $i >= 2008; $i--) {
  if (!isset($chosenendyear)) $chosenendyear = $i;
  $listendyear[] = $i;
}

for ($i = 12; $i >= 1; $i--) {
  if (!isset($chosenendmonth)) $chosenendmonth = $i;
  $listendmonth[] = $i;
}

for ($i = 31; $i >= 1; $i--) {
  if (!isset($chosenendday)) $chosenendday = $i;
  $listendday[] = $i;
}

?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/registrations.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Status</td>
    <td>Start Year</td>
    <td>Start Month</td>
    <td>Start Day</td>
    <td>End Year</td>
    <td>End Month</td>
    <td>End Day</td>
    <td>Name or e-mail Contains</td>
    <td>Show Extra Details</td>
  </tr>
  <tr>
    <?php
    displayoptions('chosenstatus', $liststatus, $chosenstatus);
    displayoptions('chosenstartyear', $liststartyear, $chosenstartyear);
    displayoptions('chosenstartmonth', $liststartmonth, $chosenstartmonth);
    displayoptions('chosenstartday', $liststartday, $chosenstartday);
    displayoptions('chosenendyear', $listendyear, $chosenendyear);
    displayoptions('chosenendmonth', $listendmonth, $chosenendmonth);
    displayoptions('chosenendday', $listendday, $chosenendday);
    ?>
    <td><input type="text" size="40" name="chosensearch" value="<?php echo htmlspecialchars($chosensearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <td><input type="checkbox" name="displayextra" <?php if ($displayextra) echo ' CHECKED'; ?>></td>
  </tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/registrations.php">Reset Filters</a>
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


$applications = $DB->get_records_sql('
  SELECT a.*
  FROM mdl_peoplesregistration a
  WHERE hidden=0 ORDER BY a.datesubmitted DESC');
if (empty($applications)) {
  $applications = array();
}

$email_already_in_moodle = $DB->get_records_sql('
  SELECT DISTINCT a.id
  FROM mdl_peoplesregistration a
  LEFT JOIN mdl_user u ON a.email=u.email
  WHERE a.state=0 AND a.hidden=0 AND u.id IS NOT NULL');
if (empty($email_already_in_moodle)) {
  $email_already_in_moodle = array();
}

$full_names = [];
$full_dobs = [];
foreach ($applications as $application) {
  if ($application->state == 1) { // Was previously registered
    $fullname = strtolower($application->firstname . ' ' . $application->lastname);
    $full_names[$fullname] = $fullname;

    $dob = $application->dobday . '/' . $application->dobmonth . '/' . $application->dobyear;
    $full_dobs[$dob] = $dob;
  }
}

$emaildups = 0;
foreach ($applications as $sid => $application) {
  $state = (int)$application->state;

  if (
    $application->datesubmitted < $starttime ||
    $application->datesubmitted > $endtime ||
    (($chosenstatus  === 'Not Registered') && ($state !== 0)) ||
    (($chosenstatus  === 'Registered')     && ($state === 0))
    ) {

    unset($applications[$sid]);
    continue;
  }

  if (!empty($chosensearch) &&
    stripos($application->lastname, $chosensearch) === false &&
    stripos($application->firstname, $chosensearch) === false &&
    stripos($application->email, $chosensearch) === false) {

    unset($applications[$sid]);
    continue;
  }

  if ($application->hidden) {
    unset($applications[$sid]);
    continue;
  }

  if (empty($emailcounts[$application->email])) $emailcounts[$application->email] = 1;
  else {
    $emailcounts[$application->email]++;
    $emaildups++;
  }
}


if ($sendemails) {
  if (empty($_POST['reg'])) $_POST['reg'] = '/^[a-zA-Z0-9_.-]/';
  sendemails($applications, strip_tags($_POST['emailsubject']), strip_tags($_POST['emailbody']), $_POST['reg']);
}


$table = new html_table();

if (!$displayextra) {
  $table->head = array(
    'Submitted',
    'Registered?',
    '',
    'Family name',
    'Given name',
    'Email address',
    'DOB dd/mm/yyyy',
    'Gender',
    'City/Town',
    'Country',
  );
}
else {
  $table->head = array(
    'Submitted',
    'Registered?',
    'Family name',
    'Given name',
    'Email address',
    'DOB dd/mm/yyyy',
    'Gender',
    'City/Town',
    'Country',
    'Address',
    'Current employment',
    'Current employment details',
    'Qualification',
    'Postgraduate Qualification',
    'Education Details',
    'Reasons for wanting to enrol',
    'What do you want to learn?',
    'Why do you want to learn?',
    'What are the reasons you want to do an e-learning course?',
    'How will you use your new knowledge and skills to improve population health?',
    'Sponsoring organisation',
    'How heard about Peoples-uni',
    'Name of the organisation or person from whom you heard about Peoples-uni',
    'Desired Moodle Username',
    'Moodle UserID'
  );
}

$n = 0;
$nregistered = 0;

$modules = array();
$students_unregistered = array();
foreach ($applications as $sid => $application) {
  $state = (int)$application->state;

  $application->userid = (int)$application->userid;

  $rowdata = array();
  $rowdata[] = gmdate('d/m/Y H:i', $application->datesubmitted);

  $this_unregistered = FALSE;
  if ($state === 0) {
    $z = '<span style="color:red">No</span>';
    $this_unregistered = TRUE;
  }
  else $z = '<span style="color:green">Yes</span>';
  $rowdata[] = $z;

  if (!$displayextra) {
    $z  = '<form method="post" action="' .  $CFG->wwwroot . '/course/reg.php" target="_blank">';

    $z .= '<input type="hidden" name="id" value="' . $application->id . '" />';
    $z .= '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
    $z .= '<input type="hidden" name="markapp" value="1" />';
    $z .= '<input type="submit" name="approveapplication" value="Details" />';

    $z .= '</form>';
    $rowdata[] = $z;
  }

  $prefix = '';
  if ($application->state == 0) {
    if (!empty($full_names[strtolower($application->firstname . ' ' . $application->lastname)])) {
      $prefix = '<span style="color:red">**</span>';
    }
  }
  $rowdata[] = $prefix . htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8');

  $rowdata[] = htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8');

  if (!empty($email_already_in_moodle[$sid])) $inmoodle = '<span style="color:red">**</span>';
  else  {
    $inmoodle = '';
    if ($this_unregistered) $students_unregistered[] = $application->email;
  }
  if ($emailcounts[$application->email] === 1) {
    $z = $inmoodle . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
  }
  else {
    $z = '<span style="color:navy">**</span>' . $inmoodle . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
  }
  $rowdata[] = $z;

  $prefix = '';
  if ($application->state == 0) {
    if (!empty($full_dobs[$application->dobday . '/' . $application->dobmonth . '/' . $application->dobyear])) {
      $prefix = '<span style="color:red">**</span>';
    }
  }
  $rowdata[] = $prefix . $application->dobday . '/' . $application->dobmonth . '/' . $application->dobyear;

  $rowdata[] = $application->gender;

  $rowdata[] = htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8');

  if (empty($countryname[$application->country])) $z = '';
  else $z = $countryname[$application->country];
  $rowdata[] = $z;

  if ($displayextra) {
    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->applicationaddress));

    if (empty($employmentname[$application->employment])) $z = '';
    else $z = $employmentname[$application->employment];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->currentjob));

    if (empty($qualificationname[$application->qualification])) $z = '';
    else $z = $qualificationname[$application->qualification];
    $rowdata[] = $z;

    if (empty($higherqualificationname[$application->higherqualification])) $z = '';
    else $z = $higherqualificationname[$application->higherqualification];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->education));

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->reasons));

    $z = '';
    $arrayvalues = explode(',', $application->whatlearn);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $whatlearnname[$v] . '<br />';
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $application->whylearn);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $whylearnname[$v] . '<br />';
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $application->whyelearning);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $whyelearningname[$v] . '<br />';
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $application->howuselearning);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $howuselearningname[$v] . '<br />';
    }
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->sponsoringorganisation));

    if (empty($howfoundpeoplesname[$application->howfoundpeoples])) $z = '';
    else $z = $howfoundpeoplesname[$application->howfoundpeoples];
    $rowdata[] = $z;

    $rowdata[] = $application->howfoundorganisationname;

    $rowdata[] = htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8');

    if (empty($application->userid)) $z = '';
    else $z = $application->userid;
    $rowdata[] = $z;
  }


  $n++;

  if ($state !== 0) {
    $nregistered++;

    if (empty($gender[$application->gender])) {
      $gender[$application->gender] = 1;
    }
    else {
      $gender[$application->gender]++;
    }

    if (empty($application->dobyear)) $range = '';
    elseif ($application->dobyear >= 1990) $range = '1990+';
    elseif ($application->dobyear >= 1980) $range = '1980-1989';
    elseif ($application->dobyear >= 1970) $range = '1970-1979';
    elseif ($application->dobyear >= 1960) $range = '1960-1969';
    elseif ($application->dobyear >= 1950) $range = '1950-1959';
    else $range = '1900-1950';
    if (empty($age[$range])) {
      $age[$range] = 1;
    }
    else {
      $age[$range]++;
    }

    if (empty($country[$countryname[$application->country]])) {
      $country[$countryname[$application->country]] = 1;
    }
    else {
      $country[$countryname[$application->country]]++;
    }

    if (empty($howfoundpeoples[$howfoundpeoplesname[$application->howfoundpeoples]])) {
      $howfoundpeoples[$howfoundpeoplesname[$application->howfoundpeoples]] = 1;
    }
    else {
      $howfoundpeoples[$howfoundpeoplesname[$application->howfoundpeoples]]++;
    }

    $listofemails[]  = htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
  }

  $table->data[] = $rowdata;
}
echo html_writer::table($table);

echo '<br />Total Applications: ' . $n;
echo '<br />Total Registered: ' . $nregistered;
echo '<br /><br />(Duplicated e-mails: ' . $emaildups . ',  see <span style="color:navy">**</span>)';
echo '<br /><br />(If a Moodle user already has this e-mail then it will be marked with <span style="color:red">**</span>.<br />
In that case the student is probably already in Moodle and should not be registered.)';
echo '<br />(If a Moodle user already has a name or date of birth that seems to match a new registration, then these will also be marked with <span style="color:red">**</span>. But this is less likely to be relevant.)';

echo '<br /><br />Total Not Registered (excluding duplicates or those with existing Moodle user): ' . count(array_unique($students_unregistered));
echo '<br />(This may overestimate the number waiting to be registered because of historical registrations that were bypassed.)';
echo '<br/><br/>';


natcasesort($listofemails);
echo 'e-mails of Registered Students...<br />' . implode(', ', array_unique($listofemails)) . '<br /><br />';

echo 'Statistics for Registered Students...<br />';
displaystat($gender, 'Gender');
displaystat($age, 'Year of Birth');
displaystat($country, 'Country');
displaystat($howfoundpeoples, 'How heard about Peoples-uni');


$peoples_batch_registration_email = get_config(NULL, 'peoples_batch_registration_email');

$peoples_batch_registration_email = htmlspecialchars($peoples_batch_registration_email, ENT_COMPAT, 'UTF-8');
?>
<br />To send an e-mail to all the students in the main spreadsheet above...
enter BOTH a subject and optionally edit the e-mail text below and click "Send e-mail to All".<br />
<br />
NOTE, to send an e-mail only to registered students... BEFORE SENDING THE E_MAIL,
set the filters at the top of this page as follows...<br />
Status: "Registered"<br />
Start Year: As desired<br />
Start Month: As desired<br />
<br />
Also look at list of e-mails sent to verify they went! (No subject and they will not go!)<br /><br />
<form id="emailsendform" method="post" action="<?php
  if (!empty($_REQUEST['chosenstatus'])) {
    echo $CFG->wwwroot . '/course/registrations.php?'
      . '&chosenstatus=' . urlencode($_REQUEST['chosenstatus'])
      . '&chosenstartyear=' . $_REQUEST['chosenstartyear']
      . '&chosenstartmonth=' . $_REQUEST['chosenstartmonth']
      . '&chosenstartday=' . $_REQUEST['chosenstartday']
      . '&chosenendyear=' . $_REQUEST['chosenendyear']
      . '&chosenendmonth=' . $_REQUEST['chosenendmonth']
      . '&chosenendday=' . $_REQUEST['chosenendday']
      . '&chosensearch=' . urlencode($_REQUEST['chosensearch'])
      . (empty($_REQUEST['displayextra']) ? '&displayextra=0' : '&displayextra=1');
  }
  else {
    echo $CFG->wwwroot . '/course/registrations.php';
  }
?>">
Subject:&nbsp;<input type="text" size="75" name="emailsubject" /><br />
<textarea name="emailbody" rows="15" cols="75" wrap="hard" style="width:auto">
<?php echo $peoples_batch_registration_email; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markemailsend" value="1" />
<input type="submit" name="emailsend" value="Send e-mail to All" />
<br />Regular expression for included e-mails (defaults to all, so do not change!):&nbsp;<input type="text" size="20" name="reg" value="/^[a-zA-Z0-9_.-]/" />
</form>
<br /><br />
<?php


echo '<br /><br />';

//echo html_writer::end_tag('div');

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


function sendemails($applications, $emailsubject, $emailbody, $reg) {

  echo '<br />';
  $i = 1;
  foreach ($applications as $sid => $application) {

    $email = trim($application->email);

    if (!preg_match($reg, $email)) {
      echo "&nbsp;&nbsp;&nbsp;&nbsp;($email skipped because of regular expression.)<br />";
      continue;
    }

    $emailbodytemp = str_replace('GIVEN_NAME_HERE', trim($application->firstname), $emailbody);

    $emailbodytemp = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $emailbodytemp); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                                       // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)
    $emailbodytemp = preg_replace('#(https://[^\s]+)[\s]+#', "$1\n\n", $emailbodytemp);

    if (sendapprovedmail($email, $emailsubject, $emailbodytemp)) {
      echo "($i) $email successfully sent.<br />";
    }
    else {
      echo "FAILURE TO SEND $email !!!<br />";
    }
    $i++;
  }
}


function sendapprovedmail($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999; $user->username = 'none';
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->id = 999999998; $supportuser->username = 'none';
  $supportuser->email = 'apply@peoples-uni.org';
  $supportuser->firstname = 'Peoples-Uni Support';
  $supportuser->lastname = '';
  $supportuser->firstnamephonetic = NULL;
  $supportuser->lastnamephonetic = NULL;
  $supportuser->middlename = NULL;
  $supportuser->alternatename = NULL;
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  $user->email = 'applicationresponses@peoples-uni.org';

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}
?>
