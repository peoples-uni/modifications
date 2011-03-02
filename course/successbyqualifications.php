<?php  // $Id: successbyqualifications.php, v 1.1 2009/06/22 18:08:00 alanbarrett Exp $
/**
*
* Report on Student Grades versus Qualifications and Employment
*
*/

$countryname['AF'] = 'Afghanistan';
$countryname['AX'] = 'Åland Islands';
$countryname['AL'] = 'Albania';
$countryname['DZ'] = 'Algeria';
$countryname['AS'] = 'American Samoa';
$countryname['AD'] = 'Andorra';
$countryname['AO'] = 'Angola';
$countryname['AI'] = 'Anguilla';
$countryname['AQ'] = 'Antarctica';
$countryname['AG'] = 'Antigua And Barbuda';
$countryname['AR'] = 'Argentina';
$countryname['AM'] = 'Armenia';
$countryname['AW'] = 'Aruba';
$countryname['AU'] = 'Australia';
$countryname['AT'] = 'Austria';
$countryname['AZ'] = 'Azerbaijan';
$countryname['BS'] = 'Bahamas';
$countryname['BH'] = 'Bahrain';
$countryname['BD'] = 'Bangladesh';
$countryname['BB'] = 'Barbados';
$countryname['BY'] = 'Belarus';
$countryname['BE'] = 'Belgium';
$countryname['BZ'] = 'Belize';
$countryname['BJ'] = 'Benin';
$countryname['BM'] = 'Bermuda';
$countryname['BT'] = 'Bhutan';
$countryname['BO'] = 'Bolivia';
$countryname['BA'] = 'Bosnia And Herzegovina';
$countryname['BW'] = 'Botswana';
$countryname['BV'] = 'Bouvet Island';
$countryname['BR'] = 'Brazil';
$countryname['IO'] = 'British Indian Ocean Territory';
$countryname['BN'] = 'Brunei Darussalam';
$countryname['BG'] = 'Bulgaria';
$countryname['BF'] = 'Burkina Faso';
$countryname['BI'] = 'Burundi';
$countryname['KH'] = 'Cambodia';
$countryname['CM'] = 'Cameroon';
$countryname['CA'] = 'Canada';
$countryname['CV'] = 'Cape Verde';
$countryname['KY'] = 'Cayman Islands';
$countryname['CF'] = 'Central African Republic';
$countryname['TD'] = 'Chad';
$countryname['CL'] = 'Chile';
$countryname['CN'] = 'China';
$countryname['CX'] = 'Christmas Island';
$countryname['CC'] = 'Cocos (Keeling) Islands';
$countryname['CO'] = 'Colombia';
$countryname['KM'] = 'Comoros';
$countryname['CG'] = 'Congo';
$countryname['CD'] = 'Congo, The Democratic Republic Of The';
$countryname['CK'] = 'Cook Islands';
$countryname['CR'] = 'Costa Rica';
$countryname['CI'] = 'Côte D\'Ivoire';
$countryname['HR'] = 'Croatia';
$countryname['CU'] = 'Cuba';
$countryname['CY'] = 'Cyprus';
$countryname['CZ'] = 'Czech Republic';
$countryname['DK'] = 'Denmark';
$countryname['DJ'] = 'Djibouti';
$countryname['DM'] = 'Dominica';
$countryname['DO'] = 'Dominican Republic';
$countryname['EC'] = 'Ecuador';
$countryname['EG'] = 'Egypt';
$countryname['SV'] = 'El Salvador';
$countryname['GQ'] = 'Equatorial Guinea';
$countryname['ER'] = 'Eritrea';
$countryname['EE'] = 'Estonia';
$countryname['ET'] = 'Ethiopia';
$countryname['FK'] = 'Falkland Islands (Malvinas)';
$countryname['FO'] = 'Faroe Islands';
$countryname['FJ'] = 'Fiji';
$countryname['FI'] = 'Finland';
$countryname['FR'] = 'France';
$countryname['GF'] = 'French Guiana';
$countryname['PF'] = 'French Polynesia';
$countryname['TF'] = 'French Southern Territories';
$countryname['GA'] = 'Gabon';
$countryname['GM'] = 'Gambia';
$countryname['GE'] = 'Georgia';
$countryname['DE'] = 'Germany';
$countryname['GH'] = 'Ghana';
$countryname['GI'] = 'Gibraltar';
$countryname['GR'] = 'Greece';
$countryname['GL'] = 'Greenland';
$countryname['GD'] = 'Grenada';
$countryname['GP'] = 'Guadeloupe';
$countryname['GU'] = 'Guam';
$countryname['GT'] = 'Guatemala';
$countryname['GG'] = 'Guernsey';
$countryname['GN'] = 'Guinea';
$countryname['GW'] = 'Guinea-Bissau';
$countryname['GY'] = 'Guyana';
$countryname['HT'] = 'Haiti';
$countryname['HM'] = 'Heard Island And Mcdonald Islands';
$countryname['VA'] = 'Holy See (Vatican City State)';
$countryname['HN'] = 'Honduras';
$countryname['HK'] = 'Hong Kong';
$countryname['HU'] = 'Hungary';
$countryname['IS'] = 'Iceland';
$countryname['IN'] = 'India';
$countryname['ID'] = 'Indonesia';
$countryname['IR'] = 'Iran, Islamic Republic Of';
$countryname['IQ'] = 'Iraq';
$countryname['IE'] = 'Ireland';
$countryname['IM'] = 'Isle Of Man';
$countryname['IL'] = 'Israel';
$countryname['IT'] = 'Italy';
$countryname['JM'] = 'Jamaica';
$countryname['JP'] = 'Japan';
$countryname['JE'] = 'Jersey';
$countryname['JO'] = 'Jordan';
$countryname['KZ'] = 'Kazakhstan';
$countryname['KE'] = 'Kenya';
$countryname['KI'] = 'Kiribati';
$countryname['KP'] = 'Korea, Democratic People\'s Republic Of';
$countryname['KR'] = 'Korea, Republic Of';
$countryname['KW'] = 'Kuwait';
$countryname['KG'] = 'Kyrgyzstan';
$countryname['LA'] = 'Lao People\'s Democratic Republic';
$countryname['LV'] = 'Latvia';
$countryname['LB'] = 'Lebanon';
$countryname['LS'] = 'Lesotho';
$countryname['LR'] = 'Liberia';
$countryname['LY'] = 'Libyan Arab Jamahiriya';
$countryname['LI'] = 'Liechtenstein';
$countryname['LT'] = 'Lithuania';
$countryname['LU'] = 'Luxembourg';
$countryname['MO'] = 'Macao';
$countryname['MK'] = 'Macedonia, The Former Yugoslav Republic Of';
$countryname['MG'] = 'Madagascar';
$countryname['MW'] = 'Malawi';
$countryname['MY'] = 'Malaysia';
$countryname['MV'] = 'Maldives';
$countryname['ML'] = 'Mali';
$countryname['MT'] = 'Malta';
$countryname['MH'] = 'Marshall Islands';
$countryname['MQ'] = 'Martinique';
$countryname['MR'] = 'Mauritania';
$countryname['MU'] = 'Mauritius';
$countryname['YT'] = 'Mayotte';
$countryname['MX'] = 'Mexico';
$countryname['FM'] = 'Micronesia, Federated States Of';
$countryname['MD'] = 'Moldova, Republic Of';
$countryname['MC'] = 'Monaco';
$countryname['MN'] = 'Mongolia';
$countryname['ME'] = 'Montenegro';
$countryname['MS'] = 'Montserrat';
$countryname['MA'] = 'Morocco';
$countryname['MZ'] = 'Mozambique';
$countryname['MM'] = 'Myanmar';
$countryname['NA'] = 'Namibia';
$countryname['NR'] = 'Nauru';
$countryname['NP'] = 'Nepal';
$countryname['NL'] = 'Netherlands';
$countryname['AN'] = 'Netherlands Antilles';
$countryname['NC'] = 'New Caledonia';
$countryname['NZ'] = 'New Zealand';
$countryname['NI'] = 'Nicaragua';
$countryname['NE'] = 'Niger';
$countryname['NG'] = 'Nigeria';
$countryname['NU'] = 'Niue';
$countryname['NF'] = 'Norfolk Island';
$countryname['MP'] = 'Northern Mariana Islands';
$countryname['NO'] = 'Norway';
$countryname['OM'] = 'Oman';
$countryname['PK'] = 'Pakistan';
$countryname['PW'] = 'Palau';
$countryname['PS'] = 'Palestinian Territory, Occupied';
$countryname['PA'] = 'Panama';
$countryname['PG'] = 'Papua New Guinea';
$countryname['PY'] = 'Paraguay';
$countryname['PE'] = 'Peru';
$countryname['PH'] = 'Philippines';
$countryname['PN'] = 'Pitcairn';
$countryname['PL'] = 'Poland';
$countryname['PT'] = 'Portugal';
$countryname['PR'] = 'Puerto Rico';
$countryname['QA'] = 'Qatar';
$countryname['RE'] = 'Réunion';
$countryname['RO'] = 'Romania';
$countryname['RU'] = 'Russian Federation';
$countryname['RW'] = 'Rwanda';
$countryname['BL'] = 'Saint Barthélemy';
$countryname['SH'] = 'Saint Helena';
$countryname['KN'] = 'Saint Kitts And Nevis';
$countryname['LC'] = 'Saint Lucia';
$countryname['MF'] = 'Saint Martin';
$countryname['PM'] = 'Saint Pierre And Miquelon';
$countryname['VC'] = 'Saint Vincent And The Grenadines';
$countryname['WS'] = 'Samoa';
$countryname['SM'] = 'San Marino';
$countryname['ST'] = 'Sao Tome And Principe';
$countryname['SA'] = 'Saudi Arabia';
$countryname['SN'] = 'Senegal';
$countryname['RS'] = 'Serbia';
$countryname['SC'] = 'Seychelles';
$countryname['SL'] = 'Sierra Leone';
$countryname['SG'] = 'Singapore';
$countryname['SK'] = 'Slovakia';
$countryname['SI'] = 'Slovenia';
$countryname['SB'] = 'Solomon Islands';
$countryname['SO'] = 'Somalia';
$countryname['ZA'] = 'South Africa';
$countryname['GS'] = 'South Georgia And The South Sandwich Islands';
$countryname['ES'] = 'Spain';
$countryname['LK'] = 'Sri Lanka';
$countryname['SD'] = 'Sudan';
$countryname['SR'] = 'Suriname';
$countryname['SJ'] = 'Svalbard And Jan Mayen';
$countryname['SZ'] = 'Swaziland';
$countryname['SE'] = 'Sweden';
$countryname['CH'] = 'Switzerland';
$countryname['SY'] = 'Syrian Arab Republic';
$countryname['TW'] = 'Taiwan, Province Of China';
$countryname['TJ'] = 'Tajikistan';
$countryname['TZ'] = 'Tanzania, United Republic Of';
$countryname['TH'] = 'Thailand';
$countryname['TL'] = 'Timor-Leste';
$countryname['TG'] = 'Togo';
$countryname['TK'] = 'Tokelau';
$countryname['TO'] = 'Tonga';
$countryname['TT'] = 'Trinidad And Tobago';
$countryname['TN'] = 'Tunisia';
$countryname['TR'] = 'Turkey';
$countryname['TM'] = 'Turkmenistan';
$countryname['TC'] = 'Turks And Caicos Islands';
$countryname['TV'] = 'Tuvalu';
$countryname['UG'] = 'Uganda';
$countryname['UA'] = 'Ukraine';
$countryname['AE'] = 'United Arab Emirates';
$countryname['GB'] = 'United Kingdom';
$countryname['US'] = 'United States';
$countryname['UM'] = 'United States Minor Outlying Islands';
$countryname['UY'] = 'Uruguay';
$countryname['UZ'] = 'Uzbekistan';
$countryname['VU'] = 'Vanuatu';
$countryname['VE'] = 'Venezuela';
$countryname['VN'] = 'Viet Nam';
$countryname['VG'] = 'Virgin Islands, British';
$countryname['VI'] = 'Virgin Islands, U.S.';
$countryname['WF'] = 'Wallis And Futuna';
$countryname['EH'] = 'Western Sahara';
$countryname['YE'] = 'Yemen';
$countryname['ZM'] = 'Zambia';
$countryname['ZW'] = 'Zimbabwe';

$qualificationname[ '0'] = '';
$qualificationname[ '1'] = 'None';
$qualificationname['10'] = 'Degree (not health related)';
$qualificationname['20'] = 'Health qualification (non-degree)';
$qualificationname['30'] = 'Health qualification (degree, but not medical doctor)';
$qualificationname['40'] = 'Medical degree';

$higherqualificationname[ '0'] = '';
$higherqualificationname[ '1'] = 'None';
$higherqualificationname['10'] = 'Certificate';
$higherqualificationname['20'] = 'Diploma';
$higherqualificationname['30'] = 'Masters';
$higherqualificationname['40'] = 'Ph.D.';
$higherqualificationname['50'] = 'Other';

$employmentname[ '0'] = '';
$employmentname[ '1'] = 'None';
$employmentname['10'] = 'Student';
$employmentname['20'] = 'Non-health';
$employmentname['30'] = 'Clinical (not specifically public health)';
$employmentname['40'] = 'Public health';
$employmentname['50'] = 'Other health related';
$employmentname['60'] = 'Academic occupation (e.g. lecturer)';


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');


if (!empty($_POST['markfilter'])) {
	redirect($CFG->wwwroot . '/course/successbyqualifications.php?'
		. 'id=' . $_POST['id']
		. '&chosenstatus=' . urlencode(stripslashes($_POST['chosenstatus']))
		. '&chosensemester=' . urlencode(stripslashes($_POST['chosensemester']))
		. (empty($_POST['sortbyaccess']) ? '&sortbyaccess=0' : '&sortbyaccess=1')
		);
}


require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = isteacherinanycourse();
if (!$isteacher) {echo '<h1>You must be a teacher to do this!</h1>'; die();}

print_header('Report on Grades versus Qualifications');


$courseid = optional_param('id', 0, PARAM_INT);
if ($courseid) {
	$courserecord = get_record('course', 'id', $courseid);
	if (empty($courserecord)) {
		echo '<h1>Course does not exist!</h1>';
		die();
	}
	$courseidsql1 = "AND e.courseid=$courseid";
	$courseidsql2 = "AND i.courseid=$courseid";
	echo '<h1>Report on Student Grades versus Qualifications and Employment for course' . htmlspecialchars($courserecord->fullname, ENT_COMPAT, 'UTF-8') . '</h1>';
}
else {
	$courseidsql1 = '';
	$courseidsql2 = '';
	echo '<h1>Report on Student Grades versus Qualifications and Employment</h1>';
}


$chosenstatus = stripslashes(optional_param('chosenstatus', 'All', PARAM_NOTAGS));

$liststatus[] = 'All';
if (!isset($chosenstatus)) $chosenstatus = 'All';
$liststatus[] = 'Passed';
$liststatus[] = 'Failed';
$liststatus[] = 'Did not Pass';
$liststatus[] = 'No Course Grade';
$liststatus[] = 'Un-Enrolled';
$liststatus[] = 'Not informed of Grade and Not Marked to be NOT Graded';
$liststatus[] = 'Will NOT be Graded, because they did Not Complete';
$liststatus[] = 'Will NOT be Graded, but will get a Certificate of Participation';
$liststatus[] = 'Will NOT be Graded, because they did Not Pay';

$statussql = '';
$gradesql = '';
if     ($chosenstatus === 'Passed')          $gradesql = 'WHERE IFNULL(y.finalgrade, 2.0)<=1.99999';
elseif ($chosenstatus === 'Failed')          $gradesql = 'WHERE IFNULL(y.finalgrade, 1.0)>1.99999';
elseif ($chosenstatus === 'Did not Pass')    $gradesql = 'WHERE IFNULL(y.finalgrade, 2.0)>1.99999';
elseif ($chosenstatus === 'No Course Grade') $gradesql = 'WHERE ISNULL(y.finalgrade)';
elseif ($chosenstatus === 'Un-Enrolled')                                        $statussql = 'AND e.enrolled=0';
elseif ($chosenstatus === 'Not informed of Grade and Not Marked to be NOT Graded') $statussql = 'AND e.notified=0';
elseif ($chosenstatus === 'Will NOT be Graded, because they did Not Complete') $statussql = 'AND e.notified=2';
elseif ($chosenstatus === 'Will NOT be Graded, but will get a Certificate of Participation') $statussql = 'AND e.notified=3';
elseif ($chosenstatus === 'Will NOT be Graded, because they did Not Pay') $statussql = 'AND e.notified=4';


$chosensemester = stripslashes(optional_param('chosensemester', '', PARAM_NOTAGS));

$semesters = get_records('semesters', '', '', 'id DESC');
foreach ($semesters as $semester) {
	$listsemester[] = $semester->semester;
	if (empty($chosensemester)) $chosensemester = $semester->semester;
}
$listsemester[] = 'All';

if (empty($chosensemester) || ($chosensemester == 'All')) {
	$chosensemester = 'All';
	$semestersql = '';
}
else {
	$semestersql = "AND e.semester='" . addslashes($chosensemester) . "'";
}
if (!empty($_REQUEST['sortbyaccess'])) {
	$sortbyaccess = true;
	$orderby ='x.lastaccess DESC, x.firstname ASC, username ASC, fullname ASC';
}
else {
	$sortbyaccess = false;
	$orderby ='x.lastname ASC, x.firstname ASC, username ASC, fullname ASC';
}


?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/successbyqualifications.php'; ?>">
Display entries using the following filters...
<table border="2" cellpadding="2">
	<tr>
		<td>Course</td>
		<td>Grading Status</td>
		<td>Semester</td>
		<td>Sort by Last Access</td>
	</tr>
	<tr>
		<td>
		<select name="id">
				<option value="0" <?php if (empty($courseid)) echo 'selected="selected"';?>>All</option>
				<?php
				$courses = get_records('course', '', '', 'fullname ASC');
				foreach ($courses as $course) {
					?>
					<option value="<?php echo $course->id; ?>" <?php if ($course->id == $courseid) echo 'selected="selected"';?>><?php echo htmlspecialchars($course->fullname, ENT_COMPAT, 'UTF-8'); ?></option>
					<?php
				}
				?>
		</select>
		</td>
		<?php
		displayoptions('chosenstatus', $liststatus, $chosenstatus);
		displayoptions('chosensemester', $listsemester, $chosensemester);
		?>
		<td><input type="checkbox" name="sortbyaccess" <?php if ($sortbyaccess) echo ' CHECKED'; ?>></td>
	</tr>
</table>
<input type="hidden" name="markfilter" value="1" />
<input type="submit" name="filter" value="Apply Filters" />
<a href="<?php echo $CFG->wwwroot; ?>/course/successbyqualifications.php">Reset Filters</a>
</form>
<br /><br />
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


$prof = get_record('user_info_field', 'shortname', 'dateofbirth');
if (!empty($prof->id)) $dobid = $prof->id;
$prof = get_record('user_info_field', 'shortname', 'gender');
if (!empty($prof->id)) $genderid = $prof->id;


$enrols = get_records_sql("SELECT * FROM
(SELECT e.*, c.fullname, c.idnumber, u.lastname, u.firstname, u.email, u.username, u.lastaccess, u.country, q.qualification, q.higherqualification, q.employment FROM
mdl_enrolment e, mdl_course c, mdl_user u, mdl_applicantqualifications q WHERE e.courseid=c.id AND e.userid=u.id $courseidsql1 $statussql $semestersql AND u.id=q.userid) AS x
LEFT JOIN
(SELECT g.userid AS guserid, g.finalgrade, i.courseid AS icourseid FROM mdl_grade_grades g, mdl_grade_items i WHERE g.itemid=i.id AND i.itemtype='course' $courseidsql2) AS y
ON x.userid=y.guserid AND x.courseid=y.icourseid
$gradesql
ORDER BY $orderby");
// If courseid is not specified this could get very inefficient, in that case I should optimise the JOIN

echo '<b>Data displayed and totalled for students with qualification data only...</b><br />';
echo '<table border="1" BORDERCOLOR="RED">';
echo '<tr>';
echo '<td>Semester</td>';
echo '<td>Module</td>';
echo '<td>Family name</td>';
echo '<td>Given name</td>';
echo '<td>Username</td>';
echo '<td>Last access</td>';
echo '<td>Grade</td>';
echo '<td>Informed?</td>';
echo '<td>Qualification</td>';
echo '<td>Higherqualification</td>';
echo '<td>Employment</td>';
echo '</tr>';


$n = 0;
$lastname = '';
$countnondup = 0;
if (!empty($enrols)) {
	foreach ($enrols as $enrol) {
		echo '<tr>';
		echo '<td>' . htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8') . '</td>';
		echo '<td>' . htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8') . '</td>';
		echo '<td><a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->userid . '" target="_blank">' . htmlspecialchars($enrol->lastname, ENT_COMPAT, 'UTF-8') . '</a></td>';
		echo '<td><a href="' . $CFG->wwwroot . '/user/view.php?id=' . $enrol->userid . '" target="_blank">' . htmlspecialchars($enrol->firstname, ENT_COMPAT, 'UTF-8') . '</a></td>';
		echo '<td>' . htmlspecialchars($enrol->username, ENT_COMPAT, 'UTF-8') . '</td>';
		// echo '<td>' . gmdate('d M Y', $enrol->datefirstenrolled) . '</td>';

		echo '<td>';
		echo ($enrol->lastaccess ? format_time(time() - $enrol->lastaccess) : get_string('never'));
		if ($enrol->enrolled == 0) echo '<br />Was Un-Enrolled on: ' . gmdate('d M Y', $enrol->dateunenrolled);

		$enrs = get_records_sql("SELECT e.datefirstenrolled, e.semester, c.idnumber FROM mdl_enrolment e, mdl_course c WHERE e.userid=$enrol->userid AND e.courseid=c.id AND {$enrol->datefirstenrolled}<e.datefirstenrolled");
		foreach ($enrs as $enr) {
			$founda = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enrol->idnumber, $matchesa);	// Take out course code without Year/Semester part
			$foundb = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enr->idnumber, $matchesb);
			if ($founda && $foundb) {
				if ($matchesa[1] === $matchesb[1]) {
					echo '<br /><span style="color:red">Re-Enrolled in this Module for Semester: ' . htmlspecialchars($enr->semester, ENT_COMPAT, 'UTF-8') . '</span>';
				}
			}
		}
		echo '</td>';
		echo '<td>';
		if (empty($enrol->finalgrade)) echo '';
		elseif ($enrol->finalgrade > 1.99999) echo 'Failed';
		else echo 'Passed';
		echo '</td>';

		echo '<td>';
		if ($enrol->notified == 0) {
		}
		elseif ($enrol->notified == 1) {
			echo 'Yes';
		}
		elseif ($enrol->notified == 2) {
			echo 'No, did Not Complete';
		}
		elseif ($enrol->notified == 3) {
			echo 'Yes, Certificate of Participation';
		}
		elseif ($enrol->notified == 4) {
			echo 'No, did Not Pay';
		}
		echo '</td>';

		echo '<td>' . $qualificationname[$enrol->qualification] . '</td>';
		echo '<td>' . $higherqualificationname[$enrol->higherqualification] . '</td>';
		echo '<td>' . $employmentname[$enrol->employment] . '</td>';
		echo '</tr>';

		if ($enrol->username !== $lastname) {

			if ($genderid) {
				$data = get_record('user_info_data', 'userid', $enrol->userid, 'fieldid', $genderid);
				if (!empty($data->data)) {
					$profgender = $data->data;

					if (empty($gender[$profgender])) {
						$gender[$profgender] = 1;
					}
					else {
						$gender[$profgender]++;
					}
				}
			}

			if ($dobid) {
				$data = get_record('user_info_data', 'userid', $enrol->userid, 'fieldid', $dobid);
				if (!empty($data->data)) {
					$founddob = preg_match('/^[0-9]{1,2} (January|February|March|April|May|June|July|August|September|October|November|December) ([0-9]{4,})$/', $data->data, $matchesdob);	// Take out course code without Year/Semester part
					if ($founddob) {
						$profdob = $matchesdob[2];

						if (empty($profdob)) $range = '';
						elseif ($profdob >= 1990) $range = '1990+';
						elseif ($profdob >= 1980) $range = '1980-1989';
						elseif ($profdob >= 1970) $range = '1970-1979';
						elseif ($profdob >= 1960) $range = '1960-1969';
						elseif ($profdob >= 1950) $range = '1950-1959';
						else $range = '1900-1950';
						if (empty($age[$range])) {
							$age[$range] = 1;
						}
						else {
							$age[$range]++;
						}
					}
				}
			}

			if (empty($country[$countryname[$enrol->country]])) {
				$country[$countryname[$enrol->country]] = 1;
			}
			else {
				$country[$countryname[$enrol->country]]++;
			}

			if (empty($qualification[$qualificationname[$enrol->qualification]])) {
				$qualification[$qualificationname[$enrol->qualification]] = 1;
			}
			else {
				$qualification[$qualificationname[$enrol->qualification]]++;
			}

			if (empty($higherqualification[$higherqualificationname[$enrol->higherqualification]])) {
				$higherqualification[$higherqualificationname[$enrol->higherqualification]] = 1;
			}
			else {
				$higherqualification[$higherqualificationname[$enrol->higherqualification]]++;
			}

			if (empty($employment[$employmentname[$enrol->employment]])) {
				$employment[$employmentname[$enrol->employment]] = 1;
			}
			else {
				$employment[$employmentname[$enrol->employment]]++;
			}

			$countnondup++;
		}
		$lastname = $enrol->username;
		$n++;
	}
}
echo '</table>';
echo '<br/>Number of Enrolments: ' . $n;
echo '<br/>Number of Students: ' . $countnondup;

echo '<br /><br />';


echo 'Statistics for Above Students (ignoring duplicates)...<br />';
displaystat($gender, 'Gender');
displaystat($age, 'Year of Birth');
displaystat($country, 'Country');
displaystat($qualification, 'Qualification');
displaystat($higherqualification, 'Higher Qualification');
displaystat($employment, 'Employment');

echo '<br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
echo '<br /><br />';

print_footer();


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
