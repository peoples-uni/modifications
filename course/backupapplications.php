<?php  // $Id: backupapplications.php,v 1.1 2008/10/31 17:00:00 alanbarrett Exp $

/*
CREATE TABLE mdl_applicationsbackup (
	id BIGINT(10) unsigned NOT NULL auto_increment,
	nid BIGINT(10) unsigned NOT NULL,
	sid BIGINT(10) unsigned NOT NULL,
	submitted BIGINT(10) unsigned NOT NULL,
	state text NOT NULL,
	moodleuserid text NOT NULL,
	familyname text NOT NULL,
	givenname text NOT NULL,
	emailaddress text NOT NULL,
	semester text NOT NULL,
	firstmodule text NOT NULL,
	secondmodule text NOT NULL,
	dobday text NOT NULL,
	dobmonth text NOT NULL,
	dobyear text NOT NULL,
	gender text NOT NULL,
	address text NOT NULL,
	citytown text NOT NULL,
	country text NOT NULL,
	currentjob text NOT NULL,
	previouseducationalexperience text NOT NULL,
	reasonsforwantingtoenrol text NOT NULL,
	methodofpayment text NOT NULL,
	paymentidentification text NOT NULL,
	desiredmoodleusername text NOT NULL,
	CONSTRAINT PRIMARY KEY (id)
);
*/


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

if (!empty($_POST['markfilter'])) {
	redirect($CFG->wwwroot . '/course/backupapplications.php?'
		. 'chosensemester=' . urlencode(stripslashes($_POST['chosensemester']))
		. '&chosenstatus=' . urlencode($_POST['chosenstatus'])
		. '&chosenstartyear=' . $_POST['chosenstartyear']
		. '&chosenstartmonth=' . $_POST['chosenstartmonth']
		. '&chosenstartday=' . $_POST['chosenstartday']
		. '&chosenendyear=' . $_POST['chosenendyear']
		. '&chosenendmonth=' . $_POST['chosenendmonth']
		. '&chosenendday=' . $_POST['chosenendday']
		. (empty($_POST['dobackup']) ? '&dobackup=0' : '&dobackup=1')
		);
}

require_login();

require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

print_header();

$rows = get_recordset_sql('SELECT s.*, sd.cid, sd.no, sd.data FROM d5_webform_submitted_data AS sd LEFT JOIN d5_webform_submissions AS s ON sd.sid=s.sid WHERE s.nid=71 OR s.nid=80 ORDER BY s.submitted DESC', '', '');

while (!empty($rows) && !$rows->EOF) {

	$row = $rows->fields;

	$registrations[$row['sid']]['submitted'] = $row['submitted'];
	$registrations[$row['sid']]['nid'] = $row['nid'];

	if ($row['cid']==='17' && $row['no']==='0' && $row['nid']==='71') {
		$dobmonth[$row['sid']] = $row['data'];
	}
	elseif ($row['cid']==='17' && $row['no']==='1') {
		$dobday[$row['sid']] = $row['data'];
	}
	elseif ($row['cid']==='17' && $row['no']==='2') {
		$dobyear[$row['sid']] = $row['data'];
	}
	else {
		$registrations[$row['sid']][$row['cid']] = $row['data'];
	}

	$rows->MoveNext();
}

if (empty($registrations)) {
	$registrations = array();
}

echo "<h1>Backup Applications</h1>";

if (!empty($_REQUEST['chosensemester'])) $chosensemester = stripslashes($_REQUEST['chosensemester']);
if (!empty($_REQUEST['chosenstatus'])) $chosenstatus = $_REQUEST['chosenstatus'];
if (!empty($_REQUEST['chosenstartyear']) && !empty($_REQUEST['chosenstartmonth']) && !empty($_REQUEST['chosenstartday'])) {
	$chosenstartyear = (int)$_REQUEST['chosenstartyear'];
	$chosenstartmonth = (int)$_REQUEST['chosenstartmonth'];
	$chosenstartday = (int)$_REQUEST['chosenstartday'];
	$starttime = gmmktime(0, 0, 0, $chosenstartmonth, $chosenstartday, $chosenstartyear);
	//echo gmdate('d/m/Y H:i', $starttime) . '<br />';
}
else {
	$starttime = 0;
}
if (!empty($_REQUEST['chosenendyear']) && !empty($_REQUEST['chosenendmonth']) && !empty($_REQUEST['chosenendday'])) {
	$chosenendyear = (int)$_REQUEST['chosenendyear'];
	$chosenendmonth = (int)$_REQUEST['chosenendmonth'];
	$chosenendday = (int)$_REQUEST['chosenendday'];
	$endtime = gmmktime(24, 0, 0, $chosenendmonth, $chosenendday, $chosenendyear);
	//echo gmdate('d/m/Y H:i', $endtime) . '<br />';
}
else {
	$endtime = 1.0E+20;
}
if (!empty($_REQUEST['dobackup'])) $dobackup = true;
else $dobackup = false;

$semesters = get_records('semesters', '', '', 'id DESC');
foreach ($semesters as $semester) {
	$listsemester[] = $semester->semester;
	if (!isset($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

$liststatus[] = 'All';
if (!isset($chosenstatus)) $chosenstatus = 'All';
$liststatus[] = 'Not fully Approved';
$liststatus[] = 'Not fully Registered';

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
<form method="post" action="<?php echo $CFG->wwwroot . '/course/backupapplications.php'; ?>">
Use the following filters...
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
		<td>Actually do the Backup</td>
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
		<td><input type="checkbox" name="dobackup" <?php if ($dobackup && false) echo ' CHECKED'; ?>></td>
	</tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/backupapplications.php">Reset Filters</a>
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


foreach ($registrations as $sid => $registration) {
	if ($registration['nid'] == 80) {
		// Fixup for different numbering in second form (note that e-mail is the same!)
		$registrations[$sid]['30'] = $registration['13'];
		$registrations[$sid]['29'] = $registration['10'];
		$registrations[$sid]['16'] = $registration['2'];
		$registrations[$sid]['18'] = $registration['3'];

		if (empty($registration['4'])) $registrations[$sid]['19'] = '';
		else $registrations[$sid]['19'] = $registration['4'];

		$registrations[$sid]['31'] = $registration['6'];

		if (empty($registration['7'])) $registrations[$sid]['32'] = '';
		else $registrations[$sid]['32'] = $registration['7'];

		$registrations[$sid]['32'] = $registration['7'];
		$registrations[$sid]['21'] = $registration['8'];

		if (empty($registration['14'])) $registrations[$sid]['1'] = '';
		else $registrations[$sid]['1'] = $registration['14'];
		if (empty($registration['15'])) $registrations[$sid]['2'] = '';
		else $registrations[$sid]['2'] = $registration['15'];

		if (empty($registration['16']) || empty($registration['17']) || empty($registration['18'])) {
			$dobmonth[$sid] = '';
			$dobday[$sid] = '';
			$dobyear[$sid] = '';
		}
		else {
			$dobmonth[$sid] = $registration['16'];
			$dobday[$sid] = $registration['17'];
			$dobyear[$sid] = $registration['18'];
		}

		if (empty($registration['19'])) $registrations[$sid]['12'] = '';
		else $registrations[$sid]['12'] = $registration['19'];
		if (empty($registration['20'])) $registrations[$sid]['3'] = '';
		else $registrations[$sid]['3'] = $registration['20'];
		if (empty($registration['21'])) $registrations[$sid]['14'] = '';
		else $registrations[$sid]['14'] = $registration['21'];
		if (empty($registration['22'])) $registrations[$sid]['13'] = '';
		else $registrations[$sid]['13'] = $registration['22'];
		if (empty($registration['23'])) $registrations[$sid]['7'] = '';
		else $registrations[$sid]['7'] = $registration['23'];
		if (empty($registration['24'])) $registrations[$sid]['8'] = '';
		else $registrations[$sid]['8'] = $registration['24'];
		if (empty($registration['25'])) $registrations[$sid]['10'] = '';
		else $registrations[$sid]['10'] = $registration['25'];
	}
}

foreach ($registrations as $sid => $registration) {

	if ($registration['submitted'] < $starttime ||
		$registration['submitted'] > $endtime ||
		(($chosensemester !== 'All') && ($registration['16'] !== $chosensemester))) {

		unset($registrations[$sid]);
		continue;
	}

	// if (substr($registration['31'], 0, 6) === 'HIDDEN') {
	// 	unset($registrations[$sid]);
	//	continue;
	// }
}

$n = 0;
$fail = 0;
foreach ($registrations as $sid => $registration) {

	unset($record);

	$record->nid = $registration['nid'];
	$record->sid = $sid;

	if (isset($registration['submitted'])) $record->submitted = addslashes($registration['submitted']);
	else $record->submitted = 0;
	if (isset($registration['30'])) $record->state = addslashes($registration['30']);
	else $record->state = '';
	if (isset($registration['29'])) $record->moodleuserid = addslashes($registration['29']);
	else $record->moodleuserid = '';
	if (isset($registration['1'])) $record->familyname = addslashes($registration['1']);
	else $record->familyname = '';
	if (isset($registration['2'])) $record->givenname = addslashes($registration['2']);
	else $record->givenname = '';
	if (isset($registration['11'])) $record->emailaddress = addslashes($registration['11']);
	else $record->emailaddress = '';
	if (isset($registration['16'])) $record->semester = addslashes($registration['16']);
	else $record->semester = '';
	if (isset($registration['18'])) $record->firstmodule = addslashes($registration['18']);
	else $record->firstmodule = '';
	if (isset($registration['19'])) $record->secondmodule = addslashes($registration['19']);
	else $record->secondmodule = '';
	if (isset($dobday[$sid])) $record->dobday = addslashes($dobday[$sid]);
	else $record->dobday = '';
	if (isset($dobmonth[$sid])) $record->dobmonth = addslashes($dobmonth[$sid]);
	else $record->dobmonth = '';
	if (isset($dobyear[$sid])) $record->dobyear = addslashes($dobyear[$sid]);
	else $record->dobyear = '';
	if (isset($registration['12'])) $record->gender = addslashes($registration['12']);
	else $record->gender = '';
	if (isset($registration['3'])) $record->address = addslashes($registration['3']);
	else $record->address = '';
	if (isset($registration['14'])) $record->citytown = addslashes($registration['14']);
	else $record->citytown = '';
	if (isset($registration['13'])) $record->country = addslashes($registration['13']);
	else $record->country = '';
	if (isset($registration['7'])) $record->currentjob = addslashes($registration['7']);
	else $record->currentjob = '';
	if (isset($registration['8'])) $record->previouseducationalexperience = addslashes($registration['8']);
	else $record->previouseducationalexperience = '';
	if (isset($registration['10'])) $record->reasonsforwantingtoenrol = addslashes($registration['10']);
	else $record->reasonsforwantingtoenrol = '';
	if (isset($registration['31'])) $record->methodofpayment = addslashes($registration['31']);
	else $record->methodofpayment = '';
	if (isset($registration['32'])) $record->paymentidentification = addslashes($registration['32']);
	else $record->paymentidentification = '';
	if (isset($registration['21'])) $record->desiredmoodleusername = addslashes($registration['21']);
	else $record->desiredmoodleusername = '';

	if ($dobackup) {
		$id = insert_record('applicationsbackup', $record);
		if (empty($id)) {
			echo 'Insert Failed for Record with e-mail address: ' . $registration['11'] . '<br />';
			$fail++;
		}
	}
	else {
		echo "[[[$n]]]" . $registration['nid'] . ', ' . $sid . ', ';
		if (isset($registration['submitted'])) echo htmlspecialchars($registration['submitted'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['30'])) echo htmlspecialchars($registration['30'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['29'])) echo htmlspecialchars($registration['29'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['1'])) echo htmlspecialchars($registration['1'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['2'])) echo htmlspecialchars($registration['2'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['11'])) echo htmlspecialchars($registration['11'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['16'])) echo htmlspecialchars($registration['16'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['18'])) echo htmlspecialchars($registration['18'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['19'])) echo htmlspecialchars($registration['19'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($dobday[$sid])) echo htmlspecialchars($dobday[$sid], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($dobmonth[$sid])) echo htmlspecialchars($dobmonth[$sid], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($dobyear[$sid])) echo htmlspecialchars($dobyear[$sid], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['12'])) echo htmlspecialchars($registration['12'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['3'])) echo htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['14'])) echo htmlspecialchars($registration['14'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['13'])) echo htmlspecialchars($registration['13'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['7'])) echo htmlspecialchars($registration['7'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['8'])) echo htmlspecialchars($registration['8'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['10'])) echo htmlspecialchars($registration['10'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['31'])) echo htmlspecialchars($registration['31'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['32'])) echo htmlspecialchars($registration['32'], ENT_COMPAT, 'UTF-8') . ', ';
		else echo ', ';
		if (isset($registration['21'])) echo htmlspecialchars($registration['21'], ENT_COMPAT, 'UTF-8');
		echo '<br />';
	}

	$n++;
}

if ($dobackup) echo "<h1>Backup Applications Finished ($n Applications Processed, $fail Failures)</h1>";
else echo "<h1>Dry Run (No Actual Backup)... Backup Applications Finished ($n Applications Processed, $fail Failures)</h1>";
echo '<br /><br /><br />';

notice(get_string('continue'), "$CFG->wwwroot/");
?>
