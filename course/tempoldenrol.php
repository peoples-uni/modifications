<?php  // $Id: tempoldenrol.php,v 1.1 2008/11/17 18:02:32 alanbarrett Exp $

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

require_login();

require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

print_header();

//$data = get_record('user_info_data', id, 248);
//echo var_dump($data) . '<br />';
//echo 'XX' . htmlspecialchars($data->data, ENT_COMPAT, 'UTF-8') . 'XX<br />';
//$d = $data->data;
//for ($i=0; $i<strlen($d); $i++) {
//	echo ord(substr($d, $i)) . substr($d, $i, 1) . '<br />';
//}
//echo '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@<br />';
//$rows = get_recordset_sql('SELECT * FROM d5_webform_submitted_data WHERE sid=347 AND cid=3;', '', '');
//while (!empty($rows) && !$rows->EOF) {
//	$row = $rows->fields;
//	$d = $row['data'];
//	for ($i=0; $i<strlen($d); $i++) {
//		echo ord(substr($d, $i)) . substr($d, $i, 1) . '<br />';
//	}
//	$rows->MoveNext();
//}

// INCLUDE die() TO ENSURE NOT USED BY ACCIDENT
echo 'die(), for safety!';
die();


$rows = get_recordset_sql('SELECT s.*, sd.cid, sd.no, sd.data FROM d5_webform_submitted_data AS sd LEFT JOIN d5_webform_submissions AS s ON sd.sid=s.sid WHERE s.nid=71 OR s.nid=80 ORDER BY s.submitted DESC', '', '');

while (!empty($rows) && !$rows->EOF) {

	$row = $rows->fields;
	// echo var_dump($row) . '<br />';

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


echo "<h1>TEMP CREATE ENROL & PROFILE</h1>";


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
	if (empty($registration['30'])) $state = 0;
	else $state = (int)$registration['30'];
	if ($state === 1) $state = 011;

//	// Temp just for registered people that have not enrolments...
//	$state1 = $state & 07;
//	$state2 = $state & 070;
//	if ($state1 === 03 || $state2 === 030) {
//		unset($registrations[$sid]);
//		continue;
//	}

//	// Temp to ensure I have right e-mails
//	if ($registration['11'] === 'sanchez3008@yahoo.com' ||
//		$registration['11'] === 'muyuni@yahoo.com' ||
//		$registration['11'] === 'draishau73@gmail.com' ||
//		$registration['11'] === 'pam.daya@studynook.com' ||
//		$registration['11'] === 'asif.daya@studynook.com') {
//		unset($registrations[$sid]);
//		continue;
//	}

	if (empty($registration['29'])) {
		unset($registrations[$sid]);
		continue;
	}

	if (substr($registration['31'], 0, 6) === 'HIDDEN') {
		unset($registrations[$sid]);
		continue;
	}

//	if ($state !== 033 && $state !== 003 && $state !== 030 && stripos($registration['1'], 'qwerty') === false) {
//		unset($registrations[$sid]);
//		continue;
//	}
}


echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";

echo "<td>Submitted</td>";
echo "<td>Approved?</td>";
echo "<td>Registered?</td>";
echo "<td>Family name</td>";
echo "<td>Given name</td>";
echo "<td>Email address</td>";
echo "<td>Semester</td>";
echo "<td>First module</td>";
echo "<td>Second module</td>";
echo "<td>DOB dd/mm/yyyy</td>";
echo "<td>Gender</td>";
echo "<td>City/Town</td>";
echo "<td>Country</td>";
echo "<td>Method of payment</td>";
echo "<td>Payment Identification</td>";
echo "<td>Address</td>";
echo "<td>Current job</td>";
echo "<td>Previous educational experience</td>";
echo "<td>Reasons for wanting to enrol</td>";
echo "<td>Desired Moodle Username</td>";
echo "<td>Moodle UserID</td>";
echo "</tr>";

$n = 0;
$napproved = 0;
$nregistered = 0;

$modules = array();
foreach ($registrations as $sid => $registration) {
	if (empty($registration['30'])) $registration['30'] = '0';
	$state = (int)$registration['30'];
	// Legacy fixups...
	if ($state === 2) {
		$state = 022;
	}
	if ($state === 1) {
		$state = 011;
	}

	$state1 = $state & 07;
	$state2 = $state & 070;

	if (empty($registration['29'])) $registration['29'] = '0';
	if (empty($registration['1'])) $registration['1'] = '';
	if (empty($registration['2'])) $registration['2'] = '';
	if (empty($registration['11'])) $registration['11'] = '';
	if (empty($registration['16'])) $registration['16'] = '';
	if (empty($registration['18'])) $registration['18'] = '';
	if (empty($registration['19'])) $registration['19'] = '';
	if (empty($dobmonth[$sid])) $dobmonth[$sid] = '';
	if (empty($dobday[$sid])) $dobday[$sid] = '';
	if (empty($dobyear[$sid])) $dobyear[$sid] = '';
	if (empty($registration['12'])) $registration['12'] = '';
	if (empty($registration['3'])) $registration['3'] = '';
	if (empty($registration['14'])) $registration['14'] = '';
	if (empty($registration['13'])) $registration['13'] = '';
	if (empty($registration['7'])) $registration['7'] = '';
	if (empty($registration['8'])) $registration['8'] = '';
	if (empty($registration['10'])) $registration['10'] = '';
	if (empty($registration['31'])) $registration['31'] = '';
	if (empty($registration['32'])) $registration['32'] = '';
	if (empty($registration['21'])) $registration['21'] = '';

	$registration['1'] = strip_tags($registration['1']);
	$registration['2'] = strip_tags($registration['2']);
	$registration['11'] = strip_tags($registration['11']);
	$registration['14'] = strip_tags($registration['14']);
	$registration['13'] = strip_tags($registration['13']);
	$registration['21'] = strip_tags($registration['21']);

	$registration['21'] = str_replace("<", '', $registration['21']);
	$registration['21'] = str_replace(">", '', $registration['21']);
	$registration['21'] = str_replace("/", '', $registration['21']);
	$registration['21'] = str_replace("#", '', $registration['21']);
	$registration['21'] = trim(moodle_strtolower($registration['21']));
	// $registration['21'] = eregi_replace("[^(-\.[:alnum:])]", '', $registration['21']);
	if (empty($registration['21'])) $registration['21'] = 'user1';	// Just in case it becomes empty

	// Moodle limits...
	$registration['1'] = mb_substr($registration['1'], 0, 100, 'UTF-8');
	$registration['2'] = mb_substr($registration['2'], 0, 100, 'UTF-8');
	$registration['11'] = mb_substr($registration['11'], 0, 100, 'UTF-8');
	$registration['14'] = mb_substr($registration['14'], 0, 20, 'UTF-8');
	$registration['21'] = mb_substr($registration['21'], 0, 100, 'UTF-8');

	if (true) {
		echo "<tr>";
		echo "<td>" . gmdate('d/m/Y H:i', $registration['submitted']) . "</td>";

		if ($state === 0) echo '<td><span style="color:red">No</span></td>';
		elseif ($state === 022) echo '<td><span style="color:blue">Denied or Deferred</span></td>';
		elseif ($state1===02 || $state2===020) echo '<td><span style="color:blue">Some</span></td>';
		else echo '<td><span style="color:green">Yes</span></td>';

		if (!($state1===03 || $state2===030)) echo '<td><span style="color:red">No</span></td>';
		elseif ($state === 033) echo '<td><span style="color:green">Yes</span></td>';
		else echo '<td><span style="color:blue">Some</span></td>';

		echo "<td>" . htmlspecialchars($registration['1'], ENT_COMPAT, 'UTF-8') . "</td>";
		echo "<td>" . htmlspecialchars($registration['2'], ENT_COMPAT, 'UTF-8') . "</td>";
		echo "<td>" . htmlspecialchars($registration['11'], ENT_COMPAT, 'UTF-8') . "</td>";
		echo "<td>" . htmlspecialchars($registration['16'], ENT_COMPAT, 'UTF-8') . "</td>";

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
		echo htmlspecialchars($registration['18'], ENT_COMPAT, 'UTF-8') . '</span></td>';

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
		echo htmlspecialchars($registration['19'], ENT_COMPAT, 'UTF-8') . '</span></td>';

		echo "<td>" . $dobday[$sid] . '/' . $dobmonth[$sid] . '/' . $dobyear[$sid] . "</td>";
		echo "<td>" . $registration['12'] . "</td>";
		echo "<td>" . htmlspecialchars($registration['14'], ENT_COMPAT, 'UTF-8') . "</td>";
		if (empty($countryname[$registration['13']])) echo "<td></td>";
		else echo "<td>" . $countryname[$registration['13']] . "</td>";
		echo "<td>" . $registration['31'] . "</td>";
		echo "<td>" . htmlspecialchars($registration['32'], ENT_COMPAT, 'UTF-8') . "</td>";

		echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8'))) . "</td>";
		echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['7'], ENT_COMPAT, 'UTF-8'))) . "</td>";
		echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['8'], ENT_COMPAT, 'UTF-8'))) . "</td>";
		echo "<td>" . str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['10'], ENT_COMPAT, 'UTF-8'))) . "</td>";
		echo "<td>" . htmlspecialchars($registration['21'], ENT_COMPAT, 'UTF-8') . "</td>";
		if (empty($registration['29'])) echo '<td></td>';
		else echo "<td>" . $registration['29'] . "</td>";

		echo "</tr>";

		if (empty($modules[$registration['18']])) {
			$modules[$registration['18']] = 1;
		}
		else {
			$modules[$registration['18']]++;
		}
		if (!empty($registration['19'])) {
			if (empty($modules[$registration['19']])) {
				$modules[$registration['19']] = 1;
			}
			else {
				$modules[$registration['19']]++;
			}
		}

		$n++;

		if ($state1===01 || $state1===03 || $state2===010 || $state2===030) {
			$napproved++;

			// Is Module 1 Approved/Registered
			if ($state1===01 || $state1===03) {
				if (empty($moduleapprovals[$registration['18']])) {
					$moduleapprovals[$registration['18']] = 1;
				}
				else {
					$moduleapprovals[$registration['18']]++;
				}
			}

			// Is Module 2 Approved/Registered
			if ($state2===010 || $state2===030) {
				if (!empty($registration['19'])) {
					if (empty($moduleapprovals[$registration['19']])) {
						$moduleapprovals[$registration['19']] = 1;
					}
					else {
						$moduleapprovals[$registration['19']]++;
					}
				}
			}

			if (empty($gender[$registration['12']])) {
				$gender[$registration['12']] = 1;
			}
			else {
				$gender[$registration['12']]++;
			}

			if (empty($dobyear[$sid])) $range = '';
			elseif ($dobyear[$sid] >= 1990) $range = '1990+';
			elseif ($dobyear[$sid] >= 1980) $range = '1980-1989';
			elseif ($dobyear[$sid] >= 1970) $range = '1970-1979';
			elseif ($dobyear[$sid] >= 1960) $range = '1960-1969';
			elseif ($dobyear[$sid] >= 1950) $range = '1950-1959';
			else $range = '1900-1950';
			if (empty($age[$range])) {
				$age[$range] = 1;
			}
			else {
				$age[$range]++;
			}

			if (empty($country[$countryname[$registration['13']]])) {
				$country[$countryname[$registration['13']]] = 1;
			}
			else {
				$country[$countryname[$registration['13']]]++;
			}

			$listofemails[]  = htmlspecialchars($registration['11'], ENT_COMPAT, 'UTF-8');
		}
		if ($state1===03 || $state2===030) {
			$nregistered++;

			// Is Module 1 Registered
			if ($state1 === 03) {
				if (empty($moduleregistrations[$registration['18']])) {
					$moduleregistrations[$registration['18']] = 1;
				}
				else {
					$moduleregistrations[$registration['18']]++;
				}

				$course = get_record('course', 'fullname', addslashes($registration['18']));
				if (empty($course)) {echo '$course empty!!!'; die();}

				$enrolment = new object();
				$enrolment->userid = $registration['29'];
				$enrolment->courseid = $course->id;
				$enrolment->semester = addslashes($registration['16']);
				$enrolment->datefirstenrolled = time();
				$enrolment->enrolled = 1;

				insert_record('enrolment', $enrolment);
			}

			// Is Module 2 Registered
			if ($state2 === 030) {
				if (!empty($registration['19'])) {
					if (empty($moduleregistrations[$registration['19']])) {
						$moduleregistrations[$registration['19']] = 1;
					}
					else {
						$moduleregistrations[$registration['19']]++;
					}

					$course = get_record('course', 'fullname', addslashes($registration['19']));
					if (empty($course)) {echo '$course 2 empty!!!'; die();}

					$enrolment = new object();
					$enrolment->userid = $registration['29'];
					$enrolment->courseid = $course->id;
					$enrolment->semester = addslashes($registration['16']);
					$enrolment->datefirstenrolled = time();
					$enrolment->enrolled = 1;

					insert_record('enrolment', $enrolment);
				}
			}
		}
		if ($registration['11'] === 'sanchez3008@yahoo.com' ||
			$registration['11'] === 'muyuni@yahoo.com' ||
			$registration['11'] === 'draishau73@gmail.com' ||
			$registration['11'] === 'pam.daya@studynook.com' ||
			$registration['11'] === 'asif.daya@studynook.com') {

			// echo 'enrol/unenrol: ' . $registration['18'] . (empty($registration['19']) ? '' : (', ' . $registration['19']));

			$course = get_record('course', 'fullname', addslashes($registration['18']));
			if (empty($course)) {echo '$course empty un-enrol!!!'; die();}

			$enrolment = new object();
			$enrolment->userid = $registration['29'];
			$enrolment->courseid = $course->id;
			$enrolment->semester = addslashes($registration['16']);
			$enrolment->datefirstenrolled = time();
			$enrolment->dateunenrolled = time();
			$enrolment->enrolled = 0;

			insert_record('enrolment', $enrolment);

			if (!empty($registration['19'])) {
				$course = get_record('course', 'fullname', addslashes($registration['19']));
				if (empty($course)) {echo '$course 2 empty un-enrol!!!'; die();}

				$enrolment = new object();
				$enrolment->userid = $registration['29'];
				$enrolment->courseid = $course->id;
				$enrolment->semester = addslashes($registration['16']);
				$enrolment->datefirstenrolled = time();
				$enrolment->dateunenrolled = time();
				$enrolment->enrolled = 0;

				insert_record('enrolment', $enrolment);
			}
		}
	}

	if (!empty($dobday[$sid]) && !empty($dobmonth[$sid]) && !empty($dobyear[$sid])) {
		$monthnames = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$user->dateofbirth = $dobday[$sid] . ' ' . $monthnames[$dobmonth[$sid]] . ' ' . $dobyear[$sid];
	}
	if (!empty($registration['12'])) {
		$user->gender = $registration['12'];
	}
	if (!empty($registration['3'])) {
		$user->applicationaddress = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['3'], ENT_COMPAT, 'UTF-8')));
	}
	if (!empty($registration['7'])) {
		$user->currentjob = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['7'], ENT_COMPAT, 'UTF-8')));
	}
	if (!empty($registration['8'])) {
		$user->education = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['8'], ENT_COMPAT, 'UTF-8')));
	}
	if (!empty($registration['10'])) {
		$user->reasons = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($registration['10'], ENT_COMPAT, 'UTF-8')));
	}

	$fields = get_records_sql("SELECT id, shortname FROM mdl_user_info_field WHERE shortname IN ('dateofbirth', 'applicationaddress', 'currentjob', 'education', 'reasons', 'gender')");

	if (!empty($fields)) {
        foreach ($fields as $field) {
			$data = new object();
			$data->userid  = $registration['29'];
			$data->fieldid = $field->id;
			if (!empty($user->{$field->shortname})) {
				$data->data = addslashes($user->{$field->shortname});
				insert_record('user_info_data', $data);
			}
        }
    }
}
echo '</table>';
echo '<br />Total Applications: ' . $n;
echo '<br />Total Approved (or part Approved): ' . $napproved;
echo '<br />Total Registered (or part Registered): ' . $nregistered;
echo '<br/><br/>';

echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
echo "<tr>";
echo "<td>Module</td>";
echo "<td>Number of Applications</td>";
echo "<td>Number Approved</td>";
echo "<td>Number Registered</td>";
echo "</tr>";

ksort($modules);

$n = 0;

foreach ($modules as $product => $number) {
	echo "<tr>";
	echo "<td>" . $product . "</td>";
	echo "<td>" . $number . "</td>";
	if (empty($moduleapprovals[$product])) { echo "<td>0</td>";} else { 	echo "<td>" . $moduleapprovals[$product] . "</td>";}
	if (empty($moduleregistrations[$product])) { echo "<td>0</td>";} else { echo "<td>" . $moduleregistrations[$product] . "</td>";}
    echo "</tr>";

	$n++;
}
echo '</table>';
echo '<br/>Number of Modules: ' . $n . '<br /><br />';

notice(get_string('continue'), "$CFG->wwwroot/");


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
?>
