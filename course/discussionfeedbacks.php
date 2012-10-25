<?php
/**
*
* List all Discussion Feedback Forms
*
*/

/*
CREATE TABLE mdl_peoplesapplication (
  id BIGINT(10) unsigned NOT NULL auto_increment,
  datesubmitted BIGINT(10) unsigned NOT NULL DEFAULT 0,
  sid BIGINT(10) unsigned NOT NULL,
  nid BIGINT(10) unsigned NOT NULL,
  reenrolment BIGINT(10) unsigned NOT NULL DEFAULT 0,
  state BIGINT(10) unsigned NOT NULL,
  state_1 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  state_2 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  state_3 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  state_4 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  ready BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  userid BIGINT(10) unsigned NOT NULL DEFAULT 0,
  username VARCHAR(100) NOT NULL DEFAULT '',
  firstname VARCHAR(100) NOT NULL DEFAULT '',
  lastname VARCHAR(100) NOT NULL DEFAULT '',
  email VARCHAR(100) NOT NULL DEFAULT '',
  city VARCHAR(20) NOT NULL DEFAULT '',
  country VARCHAR(2) NOT NULL DEFAULT '',
  qualification BIGINT(10) unsigned NOT NULL DEFAULT 0,
  higherqualification BIGINT(10) unsigned NOT NULL DEFAULT 0,
  employment BIGINT(10) unsigned NOT NULL DEFAULT 0,
  course_id_1 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  course_id_2 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  course_id_3 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  course_id_4 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  coursename1 VARCHAR(255) NOT NULL DEFAULT '',
  coursename2 VARCHAR(255) NOT NULL DEFAULT '',
  coursename3 VARCHAR(255) NOT NULL DEFAULT '',
  coursename4 VARCHAR(255) NOT NULL DEFAULT '',
  applymmumph BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  semester VARCHAR(255) NOT NULL DEFAULT '',
  dob VARCHAR(20) NOT NULL DEFAULT '',
  dobday VARCHAR(2) NOT NULL DEFAULT '',
  dobmonth VARCHAR(2) NOT NULL DEFAULT '',
  dobyear VARCHAR(4) NOT NULL DEFAULT '',
  gender VARCHAR(6) NOT NULL DEFAULT '',
  applicationaddress text NOT NULL,
  currentjob text NOT NULL,
  education text NOT NULL,
  reasons text NOT NULL,
  sponsoringorganisation text NOT NULL DEFAULT '',
  scholarship TEXT NOT NULL DEFAULT '',
  whynotcomplete TEXT NOT NULL DEFAULT '',
  methodofpayment VARCHAR(255) NOT NULL DEFAULT '',
  paymentidentification VARCHAR(255) NOT NULL DEFAULT '',
  costowed VARCHAR(10) NOT NULL DEFAULT '0',
  costpaid VARCHAR(10) NOT NULL DEFAULT '0',
  paymentmechanism BIGINT(10) unsigned NOT NULL DEFAULT 0,
  currency VARCHAR(3) NOT NULL DEFAULT 'USD',
  datefirstapproved BIGINT(10) unsigned NOT NULL DEFAULT 0,
  datelastapproved BIGINT(10) unsigned NOT NULL DEFAULT 0,
  dateattemptedtopay BIGINT(10) unsigned NOT NULL DEFAULT 0,
  datepaid BIGINT(10) unsigned NOT NULL DEFAULT 0,
  datafromworldpay VARCHAR(255) NOT NULL DEFAULT '',
  hidden TINYINT(2) unsigned NOT NULL DEFAULT 0,
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplesapplication_sid_ix ON mdl_peoplesapplication (sid);
CREATE INDEX mdl_peoplesapplication_uid_ix ON mdl_peoplesapplication (userid);

((ALTER TABLE mdl_peoplesapplication ADD hidden TINYINT(2) unsigned NOT NULL DEFAULT 0;
  ALTER TABLE mdl_peoplesapplication ADD paymentmechanism BIGINT(10) unsigned NOT NULL DEFAULT 0;

For possible future use only...
ALTER TABLE mdl_peoplesapplication ADD state_1 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state;
ALTER TABLE mdl_peoplesapplication ADD state_2 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state_1;
ALTER TABLE mdl_peoplesapplication ADD state_3 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state_2;
ALTER TABLE mdl_peoplesapplication ADD state_4 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state_3;

Will be used to support new Webform...
ALTER TABLE mdl_peoplesapplication ADD course_id_1 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER employment;
ALTER TABLE mdl_peoplesapplication ADD course_id_2 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER course_id_1;

For possible future use only...
ALTER TABLE mdl_peoplesapplication ADD course_id_3 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER course_id_2;
ALTER TABLE mdl_peoplesapplication ADD course_id_4 BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER course_id_3;

For possible future use only...
ALTER TABLE mdl_peoplesapplication ADD coursename3 VARCHAR(255) NOT NULL DEFAULT '' AFTER coursename2;
ALTER TABLE mdl_peoplesapplication ADD coursename4 VARCHAR(255) NOT NULL DEFAULT '' AFTER coursename3;

Will be used to support new Webform...
ALTER TABLE mdl_peoplesapplication ADD dob VARCHAR(20) NOT NULL DEFAULT '' AFTER semester;

ALTER TABLE mdl_peoplesapplication ADD sponsoringorganisation text NOT NULL DEFAULT '' AFTER reasons;
ALTER TABLE mdl_peoplesapplication ADD ready BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state_4;

ALTER TABLE mdl_peoplesapplication ADD applymmumph BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER coursename4;
ALTER TABLE mdl_peoplesapplication ADD scholarship TEXT NOT NULL DEFAULT '' AFTER sponsoringorganisation;
ALTER TABLE mdl_peoplesapplication ADD whynotcomplete TEXT NOT NULL DEFAULT '' AFTER scholarship;
ALTER TABLE mdl_peoplesapplication ADD reenrolment BIGINT(10) unsigned NOT NULL DEFAULT 0 AFTER nid;
))

CREATE TABLE mdl_peoplesmph (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  sid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
  mphstatus BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  note text default '' NOT NULL,
CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplesmph_uid_ix ON mdl_peoplesmph (userid);
CREATE INDEX mdl_peoplesmph_sid_ix ON mdl_peoplesmph (sid);

"sid" so can use before userid assigned.
(userid will be set when it is known.)

References to the original table never checked mphstatus, so I am adding a second one in which mphstatus can be used...
CREATE TABLE mdl_peoplesmph2 (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
  datelastunentolled BIGINT(10) UNSIGNED NOT NULL,
  mphstatus BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  note text default '' NOT NULL,
CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplesmph2_uid_ix ON mdl_peoplesmph (userid);

CREATE TABLE mdl_peoplespaymentnote (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  sid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
  paymentstatus BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  note text default '' NOT NULL,
CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplespaymentnote_uid_ix ON mdl_peoplespaymentnote (userid);
CREATE INDEX mdl_peoplespaymentnote_sid_ix ON mdl_peoplespaymentnote (sid);

"sid" so can use before userid assigned.
(userid will be set when it is known.)
*/


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/discussionfeedbacks.php'); // Defined here to avoid notices on errors etc

if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/discussionfeedbacks.php?'
    . 'chosensemester=' . urlencode(dontstripslashes($_POST['chosensemester']))
    . '&chosenstatus=' . urlencode($_POST['chosenstatus'])
    . '&chosenstartyear=' . $_POST['chosenstartyear']
    . '&chosenstartmonth=' . $_POST['chosenstartmonth']
    . '&chosenstartday=' . $_POST['chosenstartday']
    . '&chosenendyear=' . $_POST['chosenendyear']
    . '&chosenendmonth=' . $_POST['chosenendmonth']
    . '&chosenendday=' . $_POST['chosenendday']
    . '&chosensearch=' . urlencode(dontstripslashes($_POST['chosensearch']))
    . '&chosenmodule=' . urlencode(dontstripslashes($_POST['chosenmodule']))
    . '&chosenpay=' . urlencode($_POST['chosenpay'])
    . '&chosenreenrol=' . urlencode($_POST['chosenreenrol'])
    . '&chosenmmu=' . urlencode($_POST['chosenmmu'])
    . '&acceptedmmu=' . urlencode($_POST['acceptedmmu'])
    . '&chosenscholarship=' . urlencode($_POST['chosenscholarship'])
    . (empty($_POST['displayscholarship']) ? '&displayscholarship=0' : '&displayscholarship=1')
    . (empty($_POST['displayextra']) ? '&displayextra=0' : '&displayextra=1')
    . (empty($_POST['displayforexcel']) ? '&displayforexcel=0' : '&displayforexcel=1')
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
//$PAGE->set_pagelayout('base');     // Most backwards compatible layout without the blocks - this is the layout used by default
//$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information
//$PAGE->set_pagelayout('course');
//$PAGE->set_pagetype('course-view-' . 1);
//$PAGE->set_other_editing_capability('moodle/course:manageactivities');


require_login();

// Access to discussionfeedbacks.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Student Applications');
$PAGE->set_heading('Student Applications');
echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


if (empty($_REQUEST['displayforexcel'])) echo "<h1>Student Applications</h1>";

if (!empty($_REQUEST['chosensemester'])) $chosensemester = dontstripslashes($_REQUEST['chosensemester']);
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
if (!empty($_REQUEST['chosensearch'])) $chosensearch = dontstripslashes($_REQUEST['chosensearch']);
else $chosensearch = '';
if (!empty($_REQUEST['chosenmodule'])) $chosenmodule = dontstripslashes($_REQUEST['chosenmodule']);
else $chosenmodule = '';
if (!empty($_REQUEST['chosenpay'])) $chosenpay = $_REQUEST['chosenpay'];
if (!empty($_REQUEST['chosenreenrol'])) $chosenreenrol = $_REQUEST['chosenreenrol'];
if (!empty($_REQUEST['chosenmmu'])) $chosenmmu = $_REQUEST['chosenmmu'];
if (!empty($_REQUEST['acceptedmmu'])) $acceptedmmu = $_REQUEST['acceptedmmu'];
if (!empty($_REQUEST['chosenscholarship'])) $chosenscholarship = $_REQUEST['chosenscholarship'];
if (!empty($_REQUEST['displayscholarship'])) $displayscholarship = true;
else $displayscholarship = false;
if (!empty($_REQUEST['displayextra'])) $displayextra = true;
else $displayextra = false;
if (!empty($_REQUEST['displayforexcel'])) $displayforexcel = true;
else $displayforexcel = false;

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
  if (!isset($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

$liststatus[] = 'All';
if (!isset($chosenstatus)) $chosenstatus = 'All';
$liststatus[] = 'Not fully Approved';
$liststatus[] = 'Not fully Enrolled';
$liststatus[] = 'Part or Fully Approved';
$liststatus[] = 'Part or Fully Enrolled';

$listchosenpay[] = 'Any';
if (!isset($chosenpay)) $chosenpay = 'Any';
$listchosenpay[] = 'No Indication Given';
$listchosenpay[] = 'Not Confirmed (all)';
$listchosenpay[] = 'Barclays not confirmed';
$listchosenpay[] = 'Ecobank not confirmed';
$listchosenpay[] = 'Diamond not confirmed';
$listchosenpay[] = 'MoneyGram not confirmed';
$listchosenpay[] = 'Western Union not confirmed';
$listchosenpay[] = 'Indian Confederation not confirmed';
$listchosenpay[] = 'Posted Travellers Cheques not confirmed';
$listchosenpay[] = 'Posted Cash not confirmed';
$listchosenpay[] = 'Promised End Semester';
$listchosenpay[] = 'Waiver';
$listchosenpay[] = 'RBS Confirmed';
$listchosenpay[] = 'Barclays Confirmed';
$listchosenpay[] = 'Ecobank Confirmed';
$listchosenpay[] = 'Diamond Confirmed';
$listchosenpay[] = 'MoneyGram Confirmed';
$listchosenpay[] = 'Western Union Confirmed';
$listchosenpay[] = 'Indian Confederation Confirmed';
$listchosenpay[] = 'Posted Travellers Cheques Confirmed';
$listchosenpay[] = 'Posted Cash Confirmed';

$listchosenreenrol[] = 'Any';
if (!isset($chosenreenrol)) $chosenreenrol = 'Any';
$listchosenreenrol[] = 'Re-enrolment';
$listchosenreenrol[] = 'New student';

$listchosenmmu[] = 'Any';
if (!isset($chosenmmu)) $chosenmmu = 'Any';
$listchosenmmu[] = 'Yes';
$listchosenmmu[] = 'No';

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

$listchosenscholarship[] = 'Any';
if (!isset($chosenscholarship)) $chosenscholarship = 'Any';
$listchosenscholarship[] = 'Yes';
$listchosenscholarship[] = 'No';

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

if (!$displayforexcel) {
?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/discussionfeedbacks.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
  <tr>
    <td>Semester</td>
    <td>Status</td>
    <td>Start Year</td>
    <td>Start Month</td>
    <td>Start Day</td>
    <td>End Year</td>
    <td>End Month</td>
    <td>End Day</td>
    <td>Name or e-mail Contains</td>
    <td>Module Name Contains</td>
    <td>Payment Method</td>
    <td>Re&#8209;enrolment?</td>
    <td>Applied MMU?</td>
    <td>Accepted MMU?</td>
    <td>Applied Scholarship?</td>
    <td>Show Scholarship Relevant Columns</td>
    <td>Show Extra Details</td>
    <td>Display Student History for Copying and Pasting to Excel</td>
  </tr>
  <tr>
    <?php
    displayoptions('chosensemester', $listsemester, $chosensemester);
    displayoptions('chosenstatus', $liststatus, $chosenstatus);
    displayoptions('chosenstartyear', $liststartyear, $chosenstartyear);
    displayoptions('chosenstartmonth', $liststartmonth, $chosenstartmonth);
    displayoptions('chosenstartday', $liststartday, $chosenstartday);
    displayoptions('chosenendyear', $listendyear, $chosenendyear);
    displayoptions('chosenendmonth', $listendmonth, $chosenendmonth);
    displayoptions('chosenendday', $listendday, $chosenendday);
    ?>
    <td><input type="text" size="15" name="chosensearch" value="<?php echo htmlspecialchars($chosensearch, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <td><input type="text" size="15" name="chosenmodule" value="<?php echo htmlspecialchars($chosenmodule, ENT_COMPAT, 'UTF-8'); ?>" /></td>
    <?php
    displayoptions('chosenpay', $listchosenpay, $chosenpay);
    displayoptions('chosenreenrol', $listchosenreenrol, $chosenreenrol);
    displayoptions('chosenmmu', $listchosenmmu, $chosenmmu);
    displayoptions('acceptedmmu', $listacceptedmmu, $acceptedmmu);
    displayoptions('chosenscholarship', $listchosenscholarship, $chosenscholarship);
    ?>
    <td><input type="checkbox" name="displayscholarship" <?php if ($displayscholarship) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="displayextra" <?php if ($displayextra) echo ' CHECKED'; ?>></td>
    <td><input type="checkbox" name="displayforexcel" <?php if ($displayforexcel) echo ' CHECKED'; ?>></td>
  </tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/discussionfeedbacks.php">Reset Filters</a>
</form>
<br />
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


// Retrieve all relevent rows
//$discussionfeedbacks = get_records_sql('SELECT a.sid AS appsid, a.* FROM mdl_peoplesapplication AS a WHERE hidden=0 ORDER BY datesubmitted DESC');
$discussionfeedbacks = $DB->get_records_sql('
  SELECT DISTINCT a.sid AS appsid, a.*, n.id IS NOT NULL AS notepresent, m.id IS NOT NULL AS mph, m.datesubmitted AS mphdatestamp, p.id IS NOT NULL AS paymentnote
  FROM mdl_peoplesapplication a
  LEFT JOIN mdl_peoplesstudentnotes n ON (a.sid=n.sid AND n.sid!=0) OR (a.userid=n.userid AND n.userid!=0)
  LEFT JOIN mdl_peoplesmph          m ON (a.sid=m.sid AND m.sid!=0) OR (a.userid=m.userid AND m.userid!=0)
  LEFT JOIN mdl_peoplespaymentnote  p ON (a.sid=p.sid AND p.sid!=0) OR (a.userid=p.userid AND p.userid!=0)
  WHERE hidden=0 ORDER BY a.datesubmitted DESC');
if (empty($discussionfeedbacks)) {
  $discussionfeedbacks = array();
}

$registrations = $DB->get_records_sql('SELECT DISTINCT r.userid AS userid_index, r.* FROM mdl_peoplesregistration r');


$emaildups = 0;
foreach ($discussionfeedbacks as $sid => $discussionfeedback) {
  $state = (int)$discussionfeedback->state;
  if ($state === 1) $state = 011;

  if (
    $discussionfeedback->datesubmitted < $starttime ||
    $discussionfeedback->datesubmitted > $endtime ||
    (($chosensemester !== 'All') && ($discussionfeedback->semester !== $chosensemester)) ||
    (($chosenstatus  === 'Not fully Approved')       && ($state === 011 || $state === 033)) ||
    (($chosenstatus  === 'Not fully Enrolled')     && ($state === 033)) ||
    (($chosenstatus  === 'Part or Fully Approved')   && (!($state === 011 || $state === 012 || $state === 021 || $state === 023 || $state === 032 || $state === 013 || $state === 031 || $state === 033))) ||
    (($chosenstatus  === 'Part or Fully Enrolled') && (!($state === 023 || $state === 032 || $state === 013 || $state === 031 || $state === 033)))
    ) {

    unset($discussionfeedbacks[$sid]);
    continue;
  }

  if (!empty($chosensearch) &&
    stripos($discussionfeedback->lastname, $chosensearch) === false &&
    stripos($discussionfeedback->firstname, $chosensearch) === false &&
    stripos($discussionfeedback->email, $chosensearch) === false) {

    unset($discussionfeedbacks[$sid]);
    continue;
  }

  if (!empty($chosenmodule) &&
    stripos($discussionfeedback->coursename1, $chosenmodule) === false &&
    stripos($discussionfeedback->coursename2, $chosenmodule) === false) {

    unset($discussionfeedbacks[$sid]);
    continue;
  }

  if (!empty($chosenpay) && $chosenpay !== 'Any') {
    if ($chosenpay === 'No Indication Given' && $discussionfeedback->paymentmechanism != 0) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Not Confirmed (all)' && ($discussionfeedback->paymentmechanism == 1 || $discussionfeedback->paymentmechanism >= 100)) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Barclays not confirmed' && $discussionfeedback->paymentmechanism != 2) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Diamond not confirmed' && $discussionfeedback->paymentmechanism != 3) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Ecobank not confirmed' && $discussionfeedback->paymentmechanism != 10) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Western Union not confirmed' && $discussionfeedback->paymentmechanism != 4) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Indian Confederation not confirmed' && $discussionfeedback->paymentmechanism != 5) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Travellers Cheques not confirmed' && $discussionfeedback->paymentmechanism != 7) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Cash not confirmed' && $discussionfeedback->paymentmechanism != 8) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'MoneyGram not confirmed' && $discussionfeedback->paymentmechanism != 9) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Promised End Semester' && $discussionfeedback->paymentmechanism != 6) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Waiver' && $discussionfeedback->paymentmechanism != 100) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'RBS Confirmed' && $discussionfeedback->paymentmechanism != 1) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Barclays Confirmed' && $discussionfeedback->paymentmechanism != 102) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Diamond Confirmed' && $discussionfeedback->paymentmechanism != 103) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Ecobank Confirmed' && $discussionfeedback->paymentmechanism != 110) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Western Union Confirmed' && $discussionfeedback->paymentmechanism != 104) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Indian Confederation Confirmed' && $discussionfeedback->paymentmechanism != 105) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Travellers Cheques Confirmed' && $discussionfeedback->paymentmechanism != 107) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'Posted Cash Confirmed' && $discussionfeedback->paymentmechanism != 108) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenpay === 'MoneyGram Confirmed' && $discussionfeedback->paymentmechanism != 109) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
  }

  if (!empty($chosenreenrol) && $chosenreenrol !== 'Any') {
    if ($chosenreenrol === 'Re-enrolment' && !$discussionfeedback->reenrolment) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenreenrol === 'New student' && $discussionfeedback->reenrolment) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
  }

  if (!empty($chosenmmu) && $chosenmmu !== 'Any') {
    if ($chosenmmu === 'No' && $discussionfeedback->applymmumph >= 2) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenmmu === 'Yes' && $discussionfeedback->applymmumph < 2) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
  }

  if (!empty($acceptedmmu) && $acceptedmmu !== 'Any') {
    if ($acceptedmmu === 'No' && $discussionfeedback->mph) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($acceptedmmu === 'Yes' && !$discussionfeedback->mph) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($acceptedmmu !== 'No' && $acceptedmmu !== 'Yes') {
      if (!$discussionfeedback->mph || $discussionfeedback->mphdatestamp < $stamp_range[$acceptedmmu]['start'] || $discussionfeedback->mphdatestamp >= $stamp_range[$acceptedmmu]['end']) {
        unset($discussionfeedbacks[$sid]);
        continue;
      }
    }
  }

  $x = strtolower(trim($discussionfeedback->scholarship));
  $scholarshipempty = empty($x) || ($x ==  'none') || ($x ==  'n/a') || ($x ==  'none.');
  if (!empty($chosenscholarship) && $chosenscholarship !== 'Any') {
    if ($chosenscholarship === 'No' && !$scholarshipempty) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
    if ($chosenscholarship === 'Yes' && $scholarshipempty) {
      unset($discussionfeedbacks[$sid]);
      continue;
    }
  }

  if ($discussionfeedback->hidden) {
    unset($discussionfeedbacks[$sid]);
    continue;
  }

  if (empty($emailcounts[$discussionfeedback->email])) $emailcounts[$discussionfeedback->email] = 1;
  else {
    $emailcounts[$discussionfeedback->email]++;
    $emaildups++;
  }
}


if ($sendemails) {
  if (empty($_POST['reg'])) $_POST['reg'] = '/^[a-zA-Z0-9_.-]/';
  sendemails($discussionfeedbacks, strip_tags(dontstripslashes($_POST['emailsubject'])), strip_tags(dontstripslashes($_POST['emailbody'])), dontstripslashes($_POST['reg']), $_POST['notforuptodatepayments']);
}


$table = new html_table();

if (!$displayextra && !$displayscholarship && !$displayforexcel) {
  $table->head = array(
    'Submitted',
    'sid',
    'Approved?',
    'Payment up to date?',
    'Enrolled?',
    '',
    'Family name',
    'Given name',
    'Email address',
    'Semester',
    'First module',
    'Second module',
    'DOB dd/mm/yyyy',
    'Gender',
    'City/Town',
    'Country',
    '',
    ''
  );
}
elseif ($displayscholarship) {
  $table->head = array(
    'sid',
    '',
    'Family name',
    'Given name',
    'Country',
    'Scholarship',
    'Reasons for wanting to enrol (1st Application)',
    'Current employment (1st Application)',
    'Current employment details (1st Application)',
    'Qualification (1st Application)',
    'Postgraduate Qualification (1st Application)',
    'Education Details (1st Application)',
  );
  $table->align = array('left', 'left', 'left', 'left', 'left', 'left', 'left', 'left', 'left', 'left', 'left', 'left');
}
elseif ($displayforexcel) {
  $table->head = array(
    'Family name',
    'Given name',
    'Country',
    'MMU?',
    'Tutor Comments',
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
    'Scholarship',
    'Why Not Completed Previous Semester',
  );
}
else {
  $table->head = array(
    'Submitted',
    'sid',
    'Approved?',
    'Payment up to date?',
    'Enrolled?',
    'Family name',
    'Given name',
    'Email address',
    'Semester',
    'First module',
    'Second module',
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
    'Scholarship',
    'Why Not Completed Previous Semester',
    'Desired Moodle Username',
    'Moodle UserID',
    '',
    ''
  );
}

//$table->align = array ("left", "left", "left", "left", "left", "center", "center", "center");
//$table->width = "95%";

/*
state
30
moodleuserid
29
Family name
1
Given name
2
Email address
11
Semester
16
First module
18
Second module
19
DOB
***
Gender
12
Address
3
City/Town
14
Country
13
Current employment
36
Current employment details
7
qualification
34
higherqualification
35
Previous educational experience
8
Reasons for wanting to enrol
10
Sponsoring organisation
sponsoringorganisation
Applying for MMU MPH
applymmumph
Scholarship
scholarship
Why Not Completed Previous Semester
whynotcomplete
Method of payment
31
Payment Identification
32
Desired Moodle Username
21
*/

$n = 0;
$napproved = 0;
$nenrolled = 0;

$modules = array();
foreach ($discussionfeedbacks as $sid => $discussionfeedback) {
  $state = (int)$discussionfeedback->state;
  // Legacy fixups...
  if ($state === 2) {
    $state = 022;
  }
  if ($state === 1) {
    $state = 011;
  }
  // Allowed transitions for Module 1 state (00X0) or Module 2 state (0X00):
  // state 0 (not processed) ..> state 2 (defered) OR state 1 (approved)
  // state 2 (defered) ..> state 1 (approved)
  // state 1 (approved) ..> state 3 (enrolled) OR state 2 (defered)
  // state 3 (enrolled) ..> state 2 (defered)
  // If any state changes from 0, all must change from 0!
  // If Module 2 is empty, its state should change along with Module 1's

  // Allowed States:
  // 00 0
  // 22 18
  // 12 10
  // 21 17
  // 11 9
  // 23 19
  // 32 26
  // 13 11
  // 31 25
  // 33 27
  // If there are any 3's, Moodle UserID must be set

  $state1 = $state & 07;
  $state2 = $state & 070;

  $discussionfeedback->userid = (int)$discussionfeedback->userid;

  $registration = $registrations[$discussionfeedback->userid];
  if (empty($discussionfeedback->userid) || empty($registration)) {
    $registration->whatlearn = '';
    $registration->whylearn = '';
    $registration->whyelearning = '';
    $registration->howuselearning = '';
    $registration->howfoundorganisationname = '';
  }

  if (!$displayforexcel) {
    $rowdata = array();
    //echo '<tr>';
    //echo '<td>' . gmdate('d/m/Y H:i', $discussionfeedback->datesubmitted) . '</td>';
    if (!$displayscholarship) $rowdata[] = gmdate('d/m/Y H:i', $discussionfeedback->datesubmitted);
    //echo '<td>' . $sid . '</td>';
    $rowdata[] = $sid;

    if ($state === 0) $z = '<span style="color:red">No</span>';
    elseif ($state === 022) $z = '<span style="color:blue">Denied or Deferred</span>';
    elseif ($state1===02 || $state2===020) $z = '<span style="color:blue">Some</span>';
    else $z = '<span style="color:green">Yes</span>';
    $applymmumphtext = array(0 => '', 1 => '', 2 => '<br />(Apply MMU MPH)', 3 => '<br />(Say already MMU MPH)');
    $z .= $applymmumphtext[$discussionfeedback->applymmumph];
    if (!$displayscholarship) $rowdata[] = $z;

    if (empty($discussionfeedback->paymentmechanism)) $mechanism = '';
    elseif ($discussionfeedback->paymentmechanism == 1) $mechanism = ' RBS Confirmed';
    elseif ($discussionfeedback->paymentmechanism == 2) $mechanism = ' Barclays';
    elseif ($discussionfeedback->paymentmechanism == 3) $mechanism = ' Diamond';
    elseif ($discussionfeedback->paymentmechanism ==10) $mechanism = ' Ecobank';
    elseif ($discussionfeedback->paymentmechanism == 4) $mechanism = ' Western Union';
    elseif ($discussionfeedback->paymentmechanism == 5) $mechanism = ' Indian Confederation';
    elseif ($discussionfeedback->paymentmechanism == 6) $mechanism = ' Promised End Semester';
    elseif ($discussionfeedback->paymentmechanism == 7) $mechanism = ' Posted Travellers Cheques';
    elseif ($discussionfeedback->paymentmechanism == 8) $mechanism = ' Posted Cash';
    elseif ($discussionfeedback->paymentmechanism == 9) $mechanism = ' MoneyGram';
    elseif ($discussionfeedback->paymentmechanism == 100) $mechanism = ' Waiver';
    elseif ($discussionfeedback->paymentmechanism == 102) $mechanism = ' Barclays Confirmed';
    elseif ($discussionfeedback->paymentmechanism == 103) $mechanism = ' Diamond Confirmed';
    elseif ($discussionfeedback->paymentmechanism == 110) $mechanism = ' Ecobank Confirmed';
    elseif ($discussionfeedback->paymentmechanism == 104) $mechanism = ' Western Union Confirmed';
    elseif ($discussionfeedback->paymentmechanism == 105) $mechanism = ' Indian Confederation Confirmed';
    elseif ($discussionfeedback->paymentmechanism == 107) $mechanism = ' Posted Travellers Cheques Confirmed';
    elseif ($discussionfeedback->paymentmechanism == 108) $mechanism = ' Posted Cash Confirmed';
    elseif ($discussionfeedback->paymentmechanism == 109) $mechanism = ' MoneyGram Confirmed';
    else  $mechanism = '';

    //if ($discussionfeedback->costpaid < .01) $z = '<span style="color:red">No' . $mechanism . '</span>';
    //elseif (abs($discussionfeedback->costowed - $discussionfeedback->costpaid) < .01) $z = '<span style="color:green">Yes' . $mechanism . '</span>';
    //else $z = '<span style="color:blue">' . "Paid $discussionfeedback->costpaid out of $discussionfeedback->costowed" . $mechanism . '</span>';
    if (!empty($discussionfeedback->userid)) {
      $not_confirmed_text = '';
      if (is_not_confirmed($discussionfeedback->userid)) $not_confirmed_text = ' (not confirmed)';
      $amount = amount_to_pay($discussionfeedback->userid);
      if ($amount >= .01) $z = '<span style="color:red">No: &pound;' . $amount . ' Owed now' . $not_confirmed_text . $mechanism . '</span>';
      elseif (abs($amount) < .01) $z = '<span style="color:green">Yes' . $not_confirmed_text . $mechanism . '</span>';
      else $z = '<span style="color:blue">' . "Overpaid: &pound;$amount" . $not_confirmed_text . $mechanism . '</span>'; // Will never be Overpaid here because of function used
    }
    else {
      $z = $mechanism;
    }
    if ($discussionfeedback->paymentnote) $z .= '<br />(Payment Note Present)';
    if (!$displayscholarship) $rowdata[] = $z;

    if (!($state1===03 || $state2===030)) $z = '<span style="color:red">No</span>';
    elseif ($state === 033) $z = '<span style="color:green">Yes</span>';
    else $z = '<span style="color:blue">Some</span>';

    if ($discussionfeedback->ready && $discussionfeedback->nid != 80) $z .= '<br />(Ready)';
    if ($discussionfeedback->notepresent) $z .= '<br />(Note Present)';
    if ($discussionfeedback->mph) $z .= '<br />(MMU MPH)';
    if (!$displayscholarship) $rowdata[] = $z;

    if (!$displayextra || $displayscholarship) {
      $z  = '<form method="post" action="' .  $CFG->wwwroot . '/course/app.php" target="_blank">';

      $z .= '<input type="hidden" name="state" value="' . $state . '" />';
      $z .= '<input type="hidden" name="29" value="' . htmlspecialchars($discussionfeedback->userid, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="1" value="' . htmlspecialchars($discussionfeedback->lastname, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="2" value="' . htmlspecialchars($discussionfeedback->firstname, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="11" value="' . htmlspecialchars($discussionfeedback->email, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="16" value="' . htmlspecialchars($discussionfeedback->semester, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="18" value="' . htmlspecialchars($discussionfeedback->coursename1, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="19" value="' . htmlspecialchars($discussionfeedback->coursename2, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="dobday" value="' . $discussionfeedback->dobday . '" />';
      $z .= '<input type="hidden" name="dobmonth" value="' . $discussionfeedback->dobmonth . '" />';
      $z .= '<input type="hidden" name="dobyear" value="' . $discussionfeedback->dobyear . '" />';
      $z .= '<input type="hidden" name="12" value="' . htmlspecialchars($discussionfeedback->gender, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="14" value="' . htmlspecialchars($discussionfeedback->city, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="13" value="' . htmlspecialchars($discussionfeedback->country, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="34" value="' . htmlspecialchars($discussionfeedback->qualification, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="35" value="' . htmlspecialchars($discussionfeedback->higherqualification, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="36" value="' . htmlspecialchars($discussionfeedback->employment, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="31" value="' . htmlspecialchars($discussionfeedback->methodofpayment, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="21" value="' . htmlspecialchars($discussionfeedback->username, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<span style="display: none;">';
      $z .= '<textarea name="3" rows="10" cols="100" wrap="hard">'  . $discussionfeedback->applicationaddress . '</textarea>';
      $z .= '<textarea name="7" rows="10" cols="100" wrap="hard">'  . $discussionfeedback->currentjob         . '</textarea>';
      $z .= '<textarea name="8" rows="10" cols="100" wrap="hard">'  . $discussionfeedback->education          . '</textarea>';
      $z .= '<textarea name="10" rows="10" cols="100" wrap="hard">' . $discussionfeedback->reasons            . '</textarea>';
      $z .= '<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard">' . $discussionfeedback->sponsoringorganisation . '</textarea>';
      $z .= '<textarea name="scholarship" rows="10" cols="100" wrap="hard">' . $discussionfeedback->scholarship . '</textarea>';
      $z .= '<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard">' . $discussionfeedback->whynotcomplete . '</textarea>';
      $z .= '<textarea name="32" rows="10" cols="100" wrap="hard">' . htmlspecialchars($discussionfeedback->paymentidentification, ENT_COMPAT, 'UTF-8') . '</textarea>';
      $z .= '</span>';
      $z .= '<input type="hidden" name="applymmumph" value="' . $discussionfeedback->applymmumph . '" />';
      $z .= '<input type="hidden" name="sid" value="' . $sid . '" />';
      $z .= '<input type="hidden" name="nid" value="' . $discussionfeedback->nid . '" />';
      $z .= '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
      $z .= '<input type="hidden" name="markapp" value="1" />';
      $z .= '<input type="submit" name="approveapplication" value="Details" />';

      $z .= '</form>';
      if ($discussionfeedback->reenrolment) $z .= 'Re&#8209;enrolment';
      $rowdata[] = $z;
    }

    $rowdata[] = htmlspecialchars($discussionfeedback->lastname, ENT_COMPAT, 'UTF-8');

    $rowdata[] = htmlspecialchars($discussionfeedback->firstname, ENT_COMPAT, 'UTF-8');

    if ($emailcounts[$discussionfeedback->email] === 1) {
      $z = htmlspecialchars($discussionfeedback->email, ENT_COMPAT, 'UTF-8');
    }
    else {
      $z = '<span style="color:navy">**</span>' . htmlspecialchars($discussionfeedback->email, ENT_COMPAT, 'UTF-8');
    }
    if (!$displayscholarship) $rowdata[] = $z;

    if (!$displayscholarship) $rowdata[] = htmlspecialchars($discussionfeedback->semester, ENT_COMPAT, 'UTF-8');

    if ($state1 === 02) {
      $z = '<span style="color:red">';
    }
    elseif ($state1 === 01) {
      $z = '<span style="color:#FF8C00">';
    }
    elseif ($state1 === 03) {
      $z = '<span style="color:green">';
    }
    else {
      $z = '<span>';
    }
    if (!$displayscholarship) $rowdata[] = $z . htmlspecialchars($discussionfeedback->coursename1, ENT_COMPAT, 'UTF-8') . '</span>';

    if ($state2 === 020) {
      $z = '<span style="color:red">';
    }
    elseif ($state2 === 010) {
      $z = '<span style="color:#FF8C00">';
    }
    elseif ($state2 === 030) {
      $z = '<span style="color:green">';
    }
    else {
      $z = '<span>';
    }
    if (!$displayscholarship) $rowdata[] = $z . htmlspecialchars($discussionfeedback->coursename2, ENT_COMPAT, 'UTF-8') . '</span>';

    if (!$displayscholarship) $rowdata[] = $discussionfeedback->dobday . '/' . $discussionfeedback->dobmonth . '/' . $discussionfeedback->dobyear;

    if (!$displayscholarship) $rowdata[] = $discussionfeedback->gender;

    if (!$displayscholarship) $rowdata[] = htmlspecialchars($discussionfeedback->city, ENT_COMPAT, 'UTF-8');

    if (empty($countryname[$discussionfeedback->country])) $z = '';
    else $z = $countryname[$discussionfeedback->country];
    $rowdata[] = $z;

    if ($displayscholarship) {
      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->scholarship));

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->reasons));

      if (empty($employmentname[$discussionfeedback->employment])) $z = '';
      else $z = $employmentname[$discussionfeedback->employment];
      $rowdata[] = $z;

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->currentjob));

      if (empty($qualificationname[$discussionfeedback->qualification])) $z = '';
      else $z = $qualificationname[$discussionfeedback->qualification];
      $rowdata[] = $z;

      if (empty($higherqualificationname[$discussionfeedback->higherqualification])) $z = '';
      else $z = $higherqualificationname[$discussionfeedback->higherqualification];
      $rowdata[] = $z;

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->education));
    }
    elseif ($displayextra) {
      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->applicationaddress));

      if (empty($employmentname[$discussionfeedback->employment])) $z = '';
      else $z = $employmentname[$discussionfeedback->employment];
      $rowdata[] = $z;

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->currentjob));

      if (empty($qualificationname[$discussionfeedback->qualification])) $z = '';
      else $z = $qualificationname[$discussionfeedback->qualification];
      $rowdata[] = $z;

      if (empty($higherqualificationname[$discussionfeedback->higherqualification])) $z = '';
      else $z = $higherqualificationname[$discussionfeedback->higherqualification];
      $rowdata[] = $z;

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->education));

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->reasons));

      $z = '';
      $arrayvalues = explode(',', $registration->whatlearn);
      foreach ($arrayvalues as $v) {
       if (!empty($v)) $z .= $whatlearnname[$v] . '<br />';
      }
      $rowdata[] = $z;

      $z = '';
      $arrayvalues = explode(',', $registration->whylearn);
      foreach ($arrayvalues as $v) {
       if (!empty($v)) $z .= $whylearnname[$v] . '<br />';
      }
      $rowdata[] = $z;

      $z = '';
      $arrayvalues = explode(',', $registration->whyelearning);
      foreach ($arrayvalues as $v) {
       if (!empty($v)) $z .= $whyelearningname[$v] . '<br />';
      }
      $rowdata[] = $z;

      $z = '';
      $arrayvalues = explode(',', $registration->howuselearning);
      foreach ($arrayvalues as $v) {
       if (!empty($v)) $z .= $howuselearningname[$v] . '<br />';
      }
      $rowdata[] = $z;

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->sponsoringorganisation));

      if (empty($howfoundpeoplesname[$registration->howfoundpeoples])) $z = '';
      else $z = $howfoundpeoplesname[$registration->howfoundpeoples];
      $rowdata[] = $z;

      $rowdata[] = $registration->howfoundorganisationname;

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->scholarship));

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $discussionfeedback->whynotcomplete));

      $rowdata[] = htmlspecialchars($discussionfeedback->username, ENT_COMPAT, 'UTF-8');

      if (empty($discussionfeedback->userid)) $z = '';
      else $z = $discussionfeedback->userid;
      $rowdata[] = $z;
    }

    if (empty($discussionfeedback->userid)) $z = '';
    else $z = '<a href="' . $CFG->wwwroot . '/course/student.php?id=' . $discussionfeedback->userid . '" target="_blank">Student Grades</a>';
    if (!$displayscholarship) $rowdata[] = $z;

    if (empty($discussionfeedback->userid)) $z = '';
    else $z = '<a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $discussionfeedback->userid . '" target="_blank">Student Submissions</a>';
    if (!$displayscholarship) $rowdata[] = $z;


    if (empty($modules[$discussionfeedback->coursename1])) {
      $modules[$discussionfeedback->coursename1] = 1;
    }
    else {
      $modules[$discussionfeedback->coursename1]++;
    }
    if (!empty($discussionfeedback->coursename2)) {
      if (empty($modules[$discussionfeedback->coursename2])) {
        $modules[$discussionfeedback->coursename2] = 1;
      }
      else {
        $modules[$discussionfeedback->coursename2]++;
      }
    }

    $n++;

    if ($state1===01 || $state1===03 || $state2===010 || $state2===030) {
      $napproved++;

      // Is Module 1 Approved/Enrolled
      if ($state1===01 || $state1===03) {
        if (empty($moduleapprovals[$discussionfeedback->coursename1])) {
          $moduleapprovals[$discussionfeedback->coursename1] = 1;
        }
        else {
          $moduleapprovals[$discussionfeedback->coursename1]++;
        }
      }

      // Is Module 2 Approved/Enrolled
      if ($state2===010 || $state2===030) {
        if (!empty($discussionfeedback->coursename2)) {
          if (empty($moduleapprovals[$discussionfeedback->coursename2])) {
            $moduleapprovals[$discussionfeedback->coursename2] = 1;
          }
          else {
            $moduleapprovals[$discussionfeedback->coursename2]++;
          }
        }
      }

      if (empty($gender[$discussionfeedback->gender])) {
        $gender[$discussionfeedback->gender] = 1;
      }
      else {
        $gender[$discussionfeedback->gender]++;
      }

      if (empty($discussionfeedback->dobyear)) $range = '';
      elseif ($discussionfeedback->dobyear >= 1990) $range = '1990+';
      elseif ($discussionfeedback->dobyear >= 1980) $range = '1980-1989';
      elseif ($discussionfeedback->dobyear >= 1970) $range = '1970-1979';
      elseif ($discussionfeedback->dobyear >= 1960) $range = '1960-1969';
      elseif ($discussionfeedback->dobyear >= 1950) $range = '1950-1959';
      else $range = '1900-1950';
      if (empty($age[$range])) {
        $age[$range] = 1;
      }
      else {
        $age[$range]++;
      }

      if (empty($country[$countryname[$discussionfeedback->country]])) {
        $country[$countryname[$discussionfeedback->country]] = 1;
      }
      else {
        $country[$countryname[$discussionfeedback->country]]++;
      }

      $listofemails[]  = htmlspecialchars($discussionfeedback->email, ENT_COMPAT, 'UTF-8');
    }
    if ($state1===03 || $state2===030) {
      $nenrolled++;

      // Is Module 1 Enrolled
      if ($state1 === 03) {
        if (empty($moduleregistrations[$discussionfeedback->coursename1])) {
          $moduleregistrations[$discussionfeedback->coursename1] = 1;
        }
        else {
          $moduleregistrations[$discussionfeedback->coursename1]++;
        }
      }

      // Is Module 2 Enrolled
      if ($state2 === 030) {
        if (!empty($discussionfeedback->coursename2)) {
          if (empty($moduleregistrations[$discussionfeedback->coursename2])) {
            $moduleregistrations[$discussionfeedback->coursename2] = 1;
          }
          else {
            $moduleregistrations[$discussionfeedback->coursename2]++;
          }
        }
      }
    }
    $table->data[] = $rowdata;
  }
  else {
    $rowdata = array();

    $rowdata[] = htmlspecialchars($discussionfeedback->lastname, ENT_COMPAT, 'UTF-8');

    $rowdata[] = htmlspecialchars($discussionfeedback->firstname, ENT_COMPAT, 'UTF-8');

    if (empty($countryname[$discussionfeedback->country])) $z = '';
    else $z = $countryname[$discussionfeedback->country];
    $rowdata[] = $z;

    if ($discussionfeedback->mph) $z = 'Yes';
    else $z = '';
    $rowdata[] = $z;

    $rowdata[] = '';

    if (empty($employmentname[$discussionfeedback->employment])) $z = '';
    else $z = $employmentname[$discussionfeedback->employment];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $discussionfeedback->currentjob));

    if (empty($qualificationname[$discussionfeedback->qualification])) $z = '';
    else $z = $qualificationname[$discussionfeedback->qualification];
    $rowdata[] = $z;

    if (empty($higherqualificationname[$discussionfeedback->higherqualification])) $z = '';
    else $z = $higherqualificationname[$discussionfeedback->higherqualification];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $discussionfeedback->education));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $discussionfeedback->reasons));

    $z = '';
    $arrayvalues = explode(',', $registration->whatlearn);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $whatlearnname[$v] . ', ';
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $registration->whylearn);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $whylearnname[$v] . ', ';
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $registration->whyelearning);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $whyelearningname[$v] . ', ';
    }
    $rowdata[] = $z;

    $z = '';
    $arrayvalues = explode(',', $registration->howuselearning);
    foreach ($arrayvalues as $v) {
     if (!empty($v)) $z .= $howuselearningname[$v] . ', ';
    }
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $discussionfeedback->sponsoringorganisation));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $discussionfeedback->scholarship));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $discussionfeedback->whynotcomplete));

    $table->data[] = $rowdata;
  }
}
echo html_writer::table($table);

if ($displayforexcel) {
  echo $OUTPUT->footer();
  die();
}

echo '<br />Total Applications: ' . $n;
echo '<br />Total Approved (or part Approved): ' . $napproved;
echo '<br />Total Enrolled (or part Enrolled): ' . $nenrolled;
echo '<br /><br />(Duplicated e-mails: ' . $emaildups . ',  see <span style="color:navy">**</span>)';
echo '<br/><br/>';

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";
echo "<td>Module</td>";
echo "<td>Number of Applications</td>";
echo "<td>Number Approved</td>";
echo "<td>Number Enrolled</td>";
echo "</tr>";

ksort($modules);

$n = 0;

foreach ($modules as $product => $number) {
  echo "<tr>";
  echo "<td>" . $product . "</td>";
  echo "<td>" . $number . "</td>";
  if (empty($moduleapprovals[$product])) { echo "<td>0</td>";} else {   echo "<td>" . $moduleapprovals[$product] . "</td>";}
  if (empty($moduleregistrations[$product])) { echo "<td>0</td>";} else { echo "<td>" . $moduleregistrations[$product] . "</td>";}
    echo "</tr>";

  $n++;
}
echo '</table>';
echo '<br/>Number of Modules: ' . $n . '<br /><br />';

natcasesort($listofemails);
echo 'e-mails of Approved Students...<br />' . implode(', ', array_unique($listofemails)) . '<br /><br />';

echo 'Statistics for Approved Students...<br />';
displaystat($gender,'Gender');
displaystat($age,'Year of Birth');
displaystat($country,'Country');


$peoples_batch_reminder_email = get_config(NULL, 'peoples_batch_reminder_email');

$peoples_batch_reminder_email = htmlspecialchars($peoples_batch_reminder_email, ENT_COMPAT, 'UTF-8');
?>
<br />To send an e-mail to all the students in the main spreadsheet above...
enter BOTH a subject and optionally edit the e-mail text below and click "Send e-mail to All".<br />
<br />
NOTE, to send an e-mail only to approved and enrolled students for the current semester who have not indicated that they have paid
or have otherwise been marked as paid or have a waiver... BEFORE SENDING THE E_MAIL,
set the filters at the top of this page as follows...<br />
Status: "Part or Fully Approved"<br />
Payment Method: "No Indication Given"<br />
<br />
Also look at list of e-mails sent to verify they went! (No subject and they will not go!)<br /><br />
<form id="emailsendform" method="post" action="<?php
  if (!empty($_REQUEST['chosensemester'])) {
    echo $CFG->wwwroot . '/course/discussionfeedbacks.php?'
      . 'chosensemester=' . urlencode(dontstripslashes($_REQUEST['chosensemester']))
      . '&chosenstatus=' . urlencode($_REQUEST['chosenstatus'])
      . '&chosenstartyear=' . $_REQUEST['chosenstartyear']
      . '&chosenstartmonth=' . $_REQUEST['chosenstartmonth']
      . '&chosenstartday=' . $_REQUEST['chosenstartday']
      . '&chosenendyear=' . $_REQUEST['chosenendyear']
      . '&chosenendmonth=' . $_REQUEST['chosenendmonth']
      . '&chosenendday=' . $_REQUEST['chosenendday']
      . '&chosensearch=' . urlencode(dontstripslashes($_REQUEST['chosensearch']))
      . '&chosenmodule=' . urlencode(dontstripslashes($_REQUEST['chosenmodule']))
      . '&chosenpay=' . urlencode($_REQUEST['chosenpay'])
      . '&chosenreenrol=' . urlencode($_REQUEST['chosenreenrol'])
      . '&chosenmmu=' . urlencode($_REQUEST['chosenmmu'])
      . '&acceptedmmu=' . urlencode($_REQUEST['acceptedmmu'])
      . '&chosenscholarship=' . urlencode($_REQUEST['chosenscholarship'])
      . (empty($_REQUEST['displayscholarship']) ? '&displayscholarship=0' : '&displayscholarship=1')
      . (empty($_REQUEST['displayextra']) ? '&displayextra=0' : '&displayextra=1')
      . (empty($_REQUEST['displayforexcel']) ? '&displayforexcel=0' : '&displayforexcel=1')
      ;
  }
  else {
    echo $CFG->wwwroot . '/course/discussionfeedbacks.php';
  }
?>">
Subject:&nbsp;<input type="text" size="75" name="emailsubject" /><br />
<textarea name="emailbody" rows="15" cols="75" wrap="hard">
<?php echo $peoples_batch_reminder_email; ?>
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markemailsend" value="1" />
<input type="submit" name="emailsend" value="Send e-mail to All" />
<br />Regular expression for included e-mails (defaults to all, so do not change!):&nbsp;<input type="text" size="20" name="reg" value="/^[a-zA-Z0-9_.-]/" />
<br />Check this if you want e-mails NOT to be sent to any student who is up to date in payments (balance adjusted for instalments <= 0):&nbsp;<input type="checkbox" name="notforuptodatepayments" />
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


function sendemails($discussionfeedbacks, $emailsubject, $emailbody, $reg, $notforuptodatepayments) {

  echo '<br />';
  $i = 1;
  foreach ($discussionfeedbacks as $sid => $discussionfeedback) {

    $email = trim($discussionfeedback->email);

    if (!preg_match($reg, $email)) {
      echo "&nbsp;&nbsp;&nbsp;&nbsp;($email skipped because of regular expression.)<br />";
      continue;
    }

    $emailbodytemp = str_replace('GIVEN_NAME_HERE', trim($discussionfeedback->firstname), $emailbody);
    $emailbodytemp = str_replace('SID_HERE', $sid, $emailbodytemp);

    if (!empty($discussionfeedback->userid)) $amount = amount_to_pay($discussionfeedback->userid);
    else $amount = 0;
    $emailbodytemp = str_replace('AMOUNT_TO_PAY_HERE', $amount, $emailbodytemp);

    $emailbodytemp = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $emailbodytemp); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                                       // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

    if (empty($notforuptodatepayments) || $amount >= .01) {
      if (sendapprovedmail($email, $emailsubject, $emailbodytemp)) {
        echo "($i) $email successfully sent.<br />";
      }
      else {
        echo "FAILURE TO SEND $email !!!<br />";
      }
      $i++;
    }
  }
}


function sendapprovedmail($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999;
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->email = 'payments@peoples-uni.org';
  $supportuser->firstname = 'Peoples-uni Payments';
  $supportuser->lastname = '';
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  $user->email = 'applicationresponses@peoples-uni.org';

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}
?>