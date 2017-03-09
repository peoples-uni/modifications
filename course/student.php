<?php  // $Id: student.php,v 1.1 2008/11/20 21:15:00 alanbarrett Exp $
/**
*
* List a user's enrolments and grades etc.
*
*/

/*
CREATE TABLE mdl_peoplesstudentnotes (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  note text NOT NULL,
  sid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplesstudentnotes_uid_ix ON mdl_peoplesstudentnotes (userid);
CREATE INDEX mdl_peoplesstudentnotes_sid_ix ON mdl_peoplesstudentnotes (sid);

20100820 Added "sid" so can add notes (in app.php) before userid assigned.
(userid will be set when it is known.)
*/


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');
require_once($CFG->dirroot .'/course/peoples_awards_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/student.php'); // Defined here to avoid notices on errors etc
$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();
// Might possibly be Guest... Anyway Guest user will not have any enrolment
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
$islurker = has_capability('moodle/grade:viewall', context_system::instance());

$userid = optional_param('id', 0, PARAM_INT);
if (empty($userid) || (!$isteacher && !$islurker)) $userid = $USER->id;
if (empty($userid)) {echo '<h1>$userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$fullname = fullname($userrecord);
if (empty($fullname) || trim($fullname) == 'Guest User') {
  $SESSION->wantsurl = "$CFG->wwwroot/course/student.php";
  notice('<br /><br /><b>You have not logged in. Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}

$PAGE->set_title('Student Enrolments and Grades for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
$PAGE->set_heading('Student Enrolments and Grades for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();

echo '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $userid . '" target="_blank">User Profile for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</a>, e-mail: ' . $userrecord->email;
echo ', Last access: ' . ($userrecord->lastaccess ? format_time(time() - $userrecord->lastaccess) : get_string('never'));


$application = $DB->get_record_sql("SELECT * FROM mdl_peoplesapplication
  WHERE (state=19 OR state=26 OR state=11 OR state=25 OR state=27 OR state=9 OR state=10 OR state=17) AND userid=?
  ORDER BY datesubmitted DESC", array($userid), IGNORE_MULTIPLE);
if (!empty($application)) {
  echo '<br />Most recent Registration Number (SID): ' . $application->sid;

  if (empty($application->paymentmechanism)) $mechanism = '';
  elseif ($application->paymentmechanism == 1) $mechanism = ' RBS Confirmed';
  elseif ($application->paymentmechanism == 2) $mechanism = ' Barclays';
  elseif ($application->paymentmechanism == 3) $mechanism = ' Diamond';
  elseif ($application->paymentmechanism ==10) $mechanism = ' Ecobank';
  elseif ($application->paymentmechanism == 4) $mechanism = ' Western Union';
  elseif ($application->paymentmechanism == 5) $mechanism = ' Indian Confederation';
  elseif ($application->paymentmechanism == 6) $mechanism = ' Promised End Semester';
  elseif ($application->paymentmechanism == 7) $mechanism = ' Posted Travellers Cheques';
  elseif ($application->paymentmechanism == 8) $mechanism = ' Posted Cash';
  elseif ($application->paymentmechanism == 9) $mechanism = ' MoneyGram';
  elseif ($application->paymentmechanism == 100) $mechanism = ' Waiver';
  elseif ($application->paymentmechanism == 102) $mechanism = ' Barclays Confirmed';
  elseif ($application->paymentmechanism == 103) $mechanism = ' Diamond Confirmed';
  elseif ($application->paymentmechanism == 110) $mechanism = ' Ecobank Confirmed';
  elseif ($application->paymentmechanism == 104) $mechanism = ' Western Union Confirmed';
  elseif ($application->paymentmechanism == 105) $mechanism = ' Indian Confederation Confirmed';
  elseif ($application->paymentmechanism == 107) $mechanism = ' Posted Travellers Cheques Confirmed';
  elseif ($application->paymentmechanism == 108) $mechanism = ' Posted Cash Confirmed';
  elseif ($application->paymentmechanism == 109) $mechanism = ' MoneyGram Confirmed';
  else  $mechanism = '';

  //if ($application->costpaid < .01) $z = '<span style="color:red">No' . $mechanism . '</span>';
  //elseif (abs($application->costowed - $application->costpaid) < .01) $z = '<span style="color:green">Yes' . $mechanism . '</span>';
  //else $z = '<span style="color:blue">' . "Paid $application->costpaid out of $application->costowed" . $mechanism . '</span>';
  if (!empty($application->userid)) {
    $not_confirmed_text = '';
    if (is_not_confirmed($application->userid)) $not_confirmed_text = ' (not confirmed)';
    $amount = amount_to_pay($application->userid);
    if ($amount >= .01) $z = '<span style="color:red">No: &pound;' . $amount . ' Owed now' . $not_confirmed_text . $mechanism . '</span>';
    elseif (abs($amount) < .01) $z = '<span style="color:green">Yes' . $not_confirmed_text . $mechanism . '</span>';
    else $z = '<span style="color:blue">' . "Overpaid: &pound;$amount" . $not_confirmed_text . $mechanism . '</span>'; // Will never be Overpaid here because of function used
  }
  else {
    $z = $mechanism;
  }

  $paymentnotes = $DB->get_records_sql("SELECT * FROM mdl_peoplespaymentnote WHERE (sid={$application->sid} AND sid!=0) OR (userid={$application->userid} AND userid!=0) ORDER BY datesubmitted DESC");
  if (!empty($paymentnotes)) {
    $z .= ' (Payment Note Present)';
  }

  echo '<br />Payment up to date?: ' . $z;
}

//$mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE userid=$userid ORDER BY datesubmitted DESC");
//if (!empty($mphs)) {
//  foreach ($mphs as $mph) {
//    echo '<br />Student was Enrolled in MMU MPH (' . gmdate('d/m/Y H:i', $mph->datesubmitted) . ')';
//  }
//}
$peoplesmph2 = $DB->get_record('peoplesmph2', array('userid' => $userid));
if (!empty($peoplesmph2->note)) echo '<br />' . $peoplesmph2->note;

if (!empty($peoplesmph2) && !empty($_POST['semester_graduated']) && !empty($_POST['markgraduated']) && !empty($_POST['graduated']) && $isteacher) {
  $peoplesmph2->graduated = $_POST['graduated'];
  $peoplesmph2->semester_graduated = $_POST['semester_graduated'];
}
if (!empty($peoplesmph2->graduated)) {
  $certifying = array(0 => '', 1 => 'MMU MPH', 2 => 'Peoples MPH', 3 => 'OTHER MPH');
  $type_of_pass = array(0 => '', 1 => '', 2 => '(Merit) ', 3 => '(Distinction) ');
  echo '<br />Graduated with MPH ' . $type_of_pass[$peoplesmph2->graduated] . 'in Semester ' . $peoplesmph2->semester_graduated . ' (Certified by ' . $certifying[$peoplesmph2->mphstatus] . ')';
}

$peoples_cert_ps = $DB->get_record('peoples_cert_ps', array('userid' => $userid));
if (!empty($peoples_cert_ps->cert_psstatus)) echo '<br />' . $peoples_cert_ps->note;

echo '<br /><br /><br />';


if (!empty($_POST['mailtext']) && !empty($_POST['markemailstudent'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
	$email = $userrecord->email;
  $body = dontstripslashes($_POST['mailtext']);
	$body = strip_tags($body);

  $body = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $body); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                   // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

	$subject = 'Peoples-Uni Information';

	if (!sendapprovedmail_from_support($email, $subject, $body)) {
		echo '<br /><br /><br /><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>';
		echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
		print_footer();
		die();
	}
	echo '<div style="color:green" align="center">e-mail sent.</div><br /><br /><br />';
}
elseif (!empty($_POST['courseid']) && !empty($_POST['marknotifiedstudentpass'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
	$email = $userrecord->email;
  $course = $DB->get_record('course', array('id' => $_POST['courseid']));
	$coursename = empty($course->fullname) ? '' : $course->fullname;
	$body = "Dear $userrecord->firstname,

We have now completed the assessment process of your course module '$coursename',
and you can see the final result if you go to... $CFG->wwwroot/course/student.php?id=$userid

I am pleased to tell you that you have passed, and that you can download and
print a PDF academic transcript for the module at that link.

    Peoples Open Access Education Initiative Administrator.";
	$subject = 'Peoples-Uni Grading Complete for: ' . $coursename;

	if (!sendapprovedmail_from_support($email, $subject, $body)) {
		echo '<br /><br /><br /><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>';
		echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
		print_footer();
		die();
	}
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
  if (!empty($enrolment)) {
    $enrolment->semester = dontaddslashes($enrolment->semester);
    $enrolment->notified = 1;
    $enrolment->datenotified = time();
    $enrolment->gradenotified = 1; // Pass (not used at present)
    $DB->update_record('enrolment', $enrolment);
  }
}
elseif (!empty($_POST['courseid']) && !empty($_POST['marknotifiedstudentfail'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
	$email = $userrecord->email;
  $course = $DB->get_record('course', array('id' => $_POST['courseid']));
	$coursename = empty($course->fullname) ? '' : $course->fullname;
	$body = "Dear $userrecord->firstname,

We have now completed the assessment process of your course module '$coursename',
and you can see the final result if you go to... $CFG->wwwroot/course/student.php?id=$userid

I am sorry to tell you that you have not passed. You are welcome to enrol once more to
try to reach a pass grade, and we will be happy to give you any advice that would help.

    Peoples Open Access Education Initiative Administrator.";
	$subject = 'Peoples-Uni Grading Complete for: ' . $coursename;

	if (!sendapprovedmail_from_support($email, $subject, $body)) {
		echo '<br /><br /><br /><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>';
		echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
		print_footer();
		die();
	}
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
	if (!empty($enrolment)) {
		$enrolment->semester = dontaddslashes($enrolment->semester);
		$enrolment->notified = 1;
		$enrolment->datenotified = time();
    $enrolment->gradenotified = 0; // Fail (not used at present)
    $DB->update_record('enrolment', $enrolment);
	}
}
elseif (!empty($_POST['courseid']) && !empty($_POST['marknotifiedstudentpassdiploma'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $email = $userrecord->email;
  $course = $DB->get_record('course', array('id' => $_POST['courseid']));
  $coursename = empty($course->fullname) ? '' : $course->fullname;
  $body = "Dear $userrecord->firstname,

We have now completed the assessment process of your course module '$coursename',
and you can see the final result if you go to... $CFG->wwwroot/course/student.php?id=$userid

I am pleased to tell you that you have passed at diploma level (" . $_POST['finalgrade'] . "%),
and that you can download and print a PDF academic transcript for the module at that link.

    Peoples Open Access Education Initiative Administrator.";
  $subject = 'Peoples-Uni Grading Complete for: ' . $coursename;

  if (!sendapprovedmail_from_support($email, $subject, $body)) {
    echo '<br /><br /><br /><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>';
    echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
  if (!empty($enrolment)) {
    $enrolment->semester = dontaddslashes($enrolment->semester);
    $enrolment->notified = 1;
    $enrolment->datenotified = time();
    $enrolment->gradenotified = $_POST['finalgrade']; // Not used at present
    $DB->update_record('enrolment', $enrolment);
  }
}
elseif (!empty($_POST['courseid']) && !empty($_POST['marknotifiedstudentpassmasters'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $email = $userrecord->email;
  $course = $DB->get_record('course', array('id' => $_POST['courseid']));
  $coursename = empty($course->fullname) ? '' : $course->fullname;
  $body = "Dear $userrecord->firstname,

We have now completed the assessment process of your course module '$coursename',
and you can see the final result if you go to... $CFG->wwwroot/course/student.php?id=$userid

I am pleased to tell you that you have passed at masters level (" . $_POST['finalgrade'] . "%),
and that you can download and print a PDF academic transcript for the module at that link.

    Peoples Open Access Education Initiative Administrator.";
  $subject = 'Peoples-Uni Grading Complete for: ' . $coursename;

  if (!sendapprovedmail_from_support($email, $subject, $body)) {
    echo '<br /><br /><br /><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>';
    echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
  if (!empty($enrolment)) {
    $enrolment->semester = dontaddslashes($enrolment->semester);
    $enrolment->notified = 1;
    $enrolment->datenotified = time();
    $enrolment->gradenotified = $_POST['finalgrade']; // Not used at present
    $DB->update_record('enrolment', $enrolment);
  }
}
elseif (!empty($_POST['courseid']) && !empty($_POST['marknotifiedstudentfaildiploma'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $email = $userrecord->email;
  $course = $DB->get_record('course', array('id' => $_POST['courseid']));
  $coursename = empty($course->fullname) ? '' : $course->fullname;
  $body = "Dear $userrecord->firstname,

We have now completed the assessment process of your course module '$coursename',
and you can see the final result if you go to... $CFG->wwwroot/course/student.php?id=$userid

I am sorry to tell you that you have not passed (" . $_POST['finalgrade'] . "%).
You are welcome to enrol once more to try to reach a pass grade,
and we will be happy to give you any advice that would help.

    Peoples Open Access Education Initiative Administrator.";
  $subject = 'Peoples-Uni Grading Complete for: ' . $coursename;

  if (!sendapprovedmail_from_support($email, $subject, $body)) {
    echo '<br /><br /><br /><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>';
    echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
    print_footer();
    die();
  }
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
  if (!empty($enrolment)) {
    $enrolment->semester = dontaddslashes($enrolment->semester);
    $enrolment->notified = 1;
    $enrolment->datenotified = time();
    $enrolment->gradenotified = $_POST['finalgrade']; // Not used at present
    $DB->update_record('enrolment', $enrolment);
  }
}
elseif (!empty($_POST['courseid']) && !empty($_POST['marknotgradedstudent'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
	if (!empty($enrolment)) {
		$enrolment->semester = dontaddslashes($enrolment->semester);
		$enrolment->notified = 2;
    $DB->update_record('enrolment', $enrolment);
	}
}
elseif (!empty($_POST['courseid']) && !empty($_POST['marknotgradedstudentexceptionalfactors'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
  if (!empty($enrolment)) {
    $enrolment->semester = dontaddslashes($enrolment->semester);
    $enrolment->notified = 5;
    $DB->update_record('enrolment', $enrolment);
  }
}
elseif (!empty($_POST['courseid']) && !empty($_POST['marknotgradedcertificatestudent'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
	$email = $userrecord->email;
  $course = $DB->get_record('course', array('id' => $_POST['courseid']));
	$coursename = empty($course->fullname) ? '' : $course->fullname;
	$body = "Dear $userrecord->firstname,

We have now completed the assessment process of your course module '$coursename'.
You can download and print a PDF Certificate of Participation for the module if you go to:
$CFG->wwwroot/course/student.php?id=$userid

    Peoples Open Access Education Initiative Administrator.";
	$subject = 'Peoples-Uni Assessment Complete for: ' . $coursename;

	if (!sendapprovedmail_from_support($email, $subject, $body)) {
		echo '<br /><br /><br /><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>';
		echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';
		print_footer();
		die();
	}
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
	if (!empty($enrolment)) {
		$enrolment->semester = dontaddslashes($enrolment->semester);
		$enrolment->notified = 3;
		$enrolment->datenotified = time();
    $DB->update_record('enrolment', $enrolment);
	}
}
elseif (!empty($_POST['courseid']) && !empty($_POST['marknotgradednotpaidstudent'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
	if (!empty($enrolment)) {
		$enrolment->semester = dontaddslashes($enrolment->semester);
		$enrolment->notified = 4;
    $DB->update_record('enrolment', $enrolment);
	}
}
elseif (!empty($_POST['courseid']) && !empty($_POST['markunexpectedlycompleted']) && $isteacher) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $enrolment = $DB->get_record('enrolment', array('userid' => $userid, 'courseid' => $_POST['courseid']));
	if (!empty($enrolment)) {
		$enrolment->semester = dontaddslashes($enrolment->semester);
		$enrolment->notified = 0;
    $DB->update_record('enrolment', $enrolment);
	}
}
elseif (!empty($_POST['note']) && !empty($_POST['markaddnote']) && $isteacher) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
	$newnote = new stdClass();
	$newnote->userid = $userid;
	$newnote->datesubmitted = time();

	// textarea with hard wrap will send CRLF so we end up with extra CRs, so we should remove \r's for niceness
	$newnote->note = dontaddslashes(str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars(dontstripslashes($_POST['note']), ENT_COMPAT, 'UTF-8'))));
  $DB->insert_record('peoplesstudentnotes', $newnote);
}
elseif (!empty($peoplesmph2) && !empty($_POST['semester_graduated']) && !empty($_POST['markgraduated']) && !empty($_POST['graduated']) && $isteacher) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $newpeoplesmph2 = new stdClass();
  $newpeoplesmph2->id = $peoplesmph2->id;
  $newpeoplesmph2->graduated = $_POST['graduated'];
  $newpeoplesmph2->semester_graduated = $_POST['semester_graduated'];
  $DB->update_record('peoplesmph2', $newpeoplesmph2);
}


$enrols = $DB->get_records_sql("SELECT * FROM
(SELECT e.*, c.fullname, c.idnumber, c.id AS cid FROM mdl_enrolment e, mdl_course c WHERE e.courseid=c.id AND e.userid=$userid) AS x
LEFT JOIN
(SELECT g.finalgrade, i.courseid AS icourseid FROM mdl_grade_grades g, mdl_grade_items i WHERE g.itemid=i.id AND i.itemtype='course' AND g.userid=$userid) AS y
ON cid=icourseid
ORDER BY datefirstenrolled ASC, fullname ASC");

if (!empty($enrols)) {
	$lastsemester = '';
	foreach ($enrols as $enrol) {
		echo '<br />';
		if ($lastsemester !== $enrol->semester) echo '<h2>Semester: ' . htmlspecialchars($enrol->semester, ENT_COMPAT, 'UTF-8') . '</h2>';
		$lastsemester = $enrol->semester;
		if ($enrol->enrolled == 0) echo 'Was Un-Enrolled on: ' . gmdate('d M Y', $enrol->dateunenrolled) . '<br />';
		foreach ($enrols as $enr) {
			$founda = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enrol->idnumber, $matchesa);	// Take out course code without Year/Semester part
			$foundb = preg_match('/^(.{4,}?)[012]+[0-9]+/', $enr->idnumber, $matchesb);
			if ($founda && $foundb) {
				if (($matchesa[1] === $matchesb[1]) && ($enrol->datefirstenrolled < $enr->datefirstenrolled)) {
					echo '<span style="color:red">Re-Enrolled in this course for Semester: ' . htmlspecialchars($enr->semester, ENT_COMPAT, 'UTF-8') . '</span><br />';
				}
			}
		}

		require_once $CFG->libdir.'/gradelib.php';
		require_once $CFG->dirroot.'/grade/lib.php';
		require_once $CFG->dirroot.'/grade/report/user/lib.php';
		$courseid = $enrol->courseid;
		$context = context_course::instance($courseid);
		$gpr = new grade_plugin_return(array('type'=>'report', 'plugin'=>'user', 'courseid'=>$courseid, 'userid'=>$userid));
		grade_regrade_final_grades($courseid);
		$report = new grade_report_user($courseid, $gpr, $context, $userid);
		$report->showrange = false;
		if ($report->fill_table()) {
			$output = $report->print_table(true);

			$output = preg_replace(array('/&lt;!--.*?--&gt;/', '/&amp;lt;!--.*?--&amp;gt;/'),
			                       array(                  '',                           ''), $output);

			//$output = preg_replace(array('/<table.*?XXXXX>/', '#</table>#'),
			//                       array(            '',           ''), $output);

			//$output = preg_replace(array('/>Category</', '/>Grade item</', '/>Course total</',            ),
			//                       array(    '>Module<',  '>Graded item<', '><b>Overall Module Grade</b><'), $output);

			$output = preg_replace(array('/>Grade item</', '/>Course total</'      ),
			                       array( '>Graded item<', '>Overall Module Grade<'), $output);

			//$output = preg_replace(array('/<span class="courseitem">/'                         ),
			//                       array('<span class="courseitem" style="font-weight: bold;">'), $output);

			//$output = preg_replace(array('#(?s)<tr.*?/mod/quiz/grade.php.*?</tr>#'),
			//                       array(                                       ''), $output);

			$output = preg_replace(array('#<tr>\n<td.*?>.*?/mod/quiz/grade.php.*?</td>\n<td.*?>.*?</td>\n<td.*?>.*?</td>\n</tr>#'),
			                       array(''                                                                                      ), $output);

      $output = preg_replace(array('#<tr>\n<th.*?>.*?/mod/quiz/grade.php.*?</th>\n<td.*?>.*?</td>\n<td.*?>.*?</td>\n</tr>#'),
                             array(''                                                                                      ), $output);

      $output = preg_replace(array('#<tr>\n<th.*?>.*?/mod/forum/view.php.*?</th>\n<td.*?>.*?</td>\n<td.*?>.*?</td>\n</tr>#'),
                             array(''                                                                                      ), $output);

      $output = preg_replace(array('#<tr>\n<th.*?>.*?/mod/checklist/view.php.*?</th>\n<td.*?>.*?</td>\n<td.*?>.*?</td>\n</tr>#'),
                             array(''                                                                                      ), $output);

			$output = preg_replace(array('#<th class="header">Range</th>#'),
			                       array(                               ''), $output);

			//$output = preg_replace(array('/>Passed</'     , '/>Failed</'     ),
			//                       array('><b>Passed</b><', '><b>Failed</b><'), $output);

			echo $output;
		}

		echo '<br />';
		if ($enrol->notified == 0) {
			if ($isteacher) {
				if (!empty($enrol->finalgrade)) {
          if ($enrol->percentgrades == 0) {
            if ($enrol->finalgrade > 1.99999) {
              ?>
              <form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
              <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
              <input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
              <input type="hidden" name="marknotifiedstudentfail" value="1" />
              <input type="submit" name="notifiedstudentfail" value="Mark Grading Complete and Notify Student: They Failed" style="width:40em" />
              </form>
              <?php
            }
            else {
              ?>
              <form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
              <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
              <input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
              <input type="hidden" name="marknotifiedstudentpass" value="1" />
              <input type="submit" name="notifiedstudentpass" value="Mark Grading Complete and Notify Student: They Passed" style="width:40em" />
              </form>
              <?php
            }
          }
          else {
            $finalgrade = (int)($enrol->finalgrade + 0.00001);
            if ($finalgrade < 45) {
              ?>
              <form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
              <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
              <input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
              <input type="hidden" name="finalgrade" value="<?php echo $finalgrade; ?>" />
              <input type="hidden" name="marknotifiedstudentfaildiploma" value="1" />
              <input type="submit" name="notifiedstudentfaildiploma" value="Mark Grading Complete and Notify Student: They Failed (<?php echo $finalgrade; ?>%)" style="width:40em" />
              </form>
              <?php
            }
            elseif ($finalgrade < 50) {
              ?>
              <form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
              <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
              <input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
              <input type="hidden" name="finalgrade" value="<?php echo $finalgrade; ?>" />
              <input type="hidden" name="marknotifiedstudentpassdiploma" value="1" />
              <input type="submit" name="notifiedstudentpassdiploma" value="Mark Grading Complete and Notify Student: They Passed Diploma Level (<?php echo $finalgrade; ?>%)" style="width:40em" />
              </form>
              <?php
            }
            else {
              ?>
              <form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
              <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
              <input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
              <input type="hidden" name="finalgrade" value="<?php echo $finalgrade; ?>" />
              <input type="hidden" name="marknotifiedstudentpassmasters" value="1" />
              <input type="submit" name="notifiedstudentpassmasters" value="Mark Grading Complete and Notify Student: They Passed Masters Level (<?php echo $finalgrade; ?>%)" style="width:40em" />
              </form>
              <?php
            }
          }
          echo '<br />';
				}
				?>
				<form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
				<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
				<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
				<input type="hidden" name="marknotgradedstudent" value="1" />
				<input type="submit" name="notgradedstudent" value="Click to indicate Student will NOT be Graded, because they did Not Complete" style="width:40em" />
				</form><br />
        <form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
        <input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
        <input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
        <input type="hidden" name="marknotgradedstudentexceptionalfactors" value="1" />
        <input type="submit" name="notgradedstudentexceptionalfactors" value="Click to indicate Student will NOT be Graded, because of Exceptional Factors" style="width:40em" />
        </form><br />
				<form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
				<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
				<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
				<input type="hidden" name="marknotgradedcertificatestudent" value="1" />
				<input type="submit" name="notgradedcertificatestudent" value="Click to indicate Student will NOT be Graded, but will get a Certificate of Participation" style="width:40em" />
				</form><br />
				<form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
				<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
				<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
				<input type="hidden" name="marknotgradednotpaidstudent" value="1" />
				<input type="submit" name="notgradednotpaidstudent" value="Click to indicate Student will NOT be Graded, because they did Not Pay" style="width:40em" />
				</form>
				<?php
			}
		}
		elseif ($enrol->notified == 1) {
			echo '<i>Grading for this module is complete.</i>';
		}
		else {
      if ($enrol->notified == 5) {
        echo '<i>This module will not be graded (Exceptional Factors).</i>';
      }
      elseif ($enrol->notified == 3) {
        echo '<i>This module will not be graded (Certificate of Participation).</i>';
      }
      elseif ($enrol->notified == 4) {
        echo '<i>This module will not be graded (Did Not Pay).</i>';
      }
      else {
        echo '<i>This module will not be graded (Did Not Complete).</i>';
      }
			if ($isteacher) {
				?>
				<br />
				<form method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
				<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
				<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
				<input type="hidden" name="markunexpectedlycompleted" value="1" />
				<input type="submit" name="unexpectedlycompleted" value="Click to Re-open Grading for this Student (because they unexpectedly paid or completed)" style="width:40em" />
				</form>
				<?php
			}
		}
		echo '<br /><br />';
	}
}
echo '<br /><br />';


$passed_or_cpd_enrol_ids = array();
$modules = array();
$modules[] = 'Modules completed (Grade):';
$percentages = array();
$percentages[] = '';
$nopercentage = 0;
$lastestdate = 0;
$cumulative_enrolled_ids_to_discount = array();
$pass_type = array();
$foundation_problems = array();
$passes_notified_or_not = 0;
$qualification = get_student_award($userid, $enrols, $passed_or_cpd_enrol_ids, $modules, $percentages, $nopercentage, $lastestdate, $cumulative_enrolled_ids_to_discount, $pass_type, $foundation_problems, $passes_notified_or_not);

$first = TRUE;
foreach ($passed_or_cpd_enrol_ids as $passed_or_cpd_enrol_id) {
  $enrol = $enrols[$passed_or_cpd_enrol_id];
  if ($enrol->notified == 3) {
    if ($first) {
      $first = FALSE;
      echo '<b>Download your Certificate by clicking on the links below...</b><br />';
      echo '(When your certificate appears, you can print it by clicking the Adobe Acrobat print icon on the top left)<br />';
    }
    echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?enrolid=' . $enrol->id . '&cert=participation" target="_blank">Certificate of Participation for: ' . htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8') . '</a><br />';
  }
  else {
    if ($first) {
      $first = FALSE;
      echo '<b>Download your Academic Transcript by clicking on the links below...</b><br />';
      echo '(When your certificate appears, you can print it by clicking the Adobe Acrobat print icon on the top left)<br />';
    }
    echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?enrolid=' . $enrol->id . '&cert=transcript" target="_blank">Academic Transcript for: ' . htmlspecialchars($enrol->fullname, ENT_COMPAT, 'UTF-8') . '</a><br />';
  }
}

$accreditation_of_prior_learnings = $DB->get_records_sql("
  SELECT userid, prior_foundation, prior_problems
  FROM mdl_peoples_accreditation_of_prior_learning
  WHERE userid=:userid", array('userid' => $userid));
if (!empty($accreditation_of_prior_learnings)) {
  if ($accreditation_of_prior_learnings[$userid]->prior_foundation) {
    echo '(Accreditation of Prior Learnings (Foundation): ' . $accreditation_of_prior_learnings[$userid]->prior_foundation . ')<br />';
  }
  if ($accreditation_of_prior_learnings[$userid]->prior_problems) {
    echo '(Accreditation of Prior Learnings (Problems): ' . $accreditation_of_prior_learnings[$userid]->prior_problems . ')<br />';
  }
}

if ($qualification & 1) {
  echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?userid=' . $userid . '&cert=certificate" target="_blank">Your Peoples Open Access Educational Initiative Certificate</a><br />';
  echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?userid=' . $userid . '&cert=certificate&nopercentage=1" target="_blank">(Same Certificate without Percent Grades)</a><br />';
  echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?userid=' . $userid . '&cert=certificate&nomodules=1" target="_blank">(Same Certificate without List of Modules)</a><br />';
}
if ($qualification & 2) {
  echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?userid=' . $userid . '&cert=diploma" target="_blank">Your Peoples Open Access Educational Initiative Diploma</a><br />';
  echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?userid=' . $userid . '&cert=diploma&nopercentage=1" target="_blank">(Same Diploma without Percent Grades)</a><br />';
  echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?userid=' . $userid . '&cert=diploma&nomodules=1" target="_blank">(Same Diploma without List of Modules)</a><br />';
}
if (!empty($peoplesmph2->graduated) && $peoplesmph2->mphstatus == 2) {
  echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?userid=' . $userid . '&cert=mph" target="_blank">Your Peoples Open Access Educational Initiative MPH</a><br />';
  echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?userid=' . $userid . '&cert=mph&yesmodules=1" target="_blank">(Same with List of Modules)</a><br />';
  echo '<a href="' . $CFG->wwwroot . '/course/peoplescertificate.php?userid=' . $userid . '&cert=mph&yesmodules=1&nopercentage=1" target="_blank">(Same with List of Modules but without Percent Grades)</a><br />';
}

if ($isteacher) echo '<a href="' . $CFG->wwwroot . '/course/allow_modules.php?userid=' . $userid . '" target="_blank">Review modules contributing to awards and override disallowed modules</a><br />';


$sql = 'SELECT * FROM {files} f WHERE f.contextid=:contextid AND f.component=:component AND f.filearea=:filearea AND f.filesize!=0';
$context = context_user::instance($userid);
$contextid = $context->id;
$conditions = array('contextid' => $contextid, 'component' => 'peoples_record', 'filearea' => 'student');
$filerecords = $DB->get_records_sql($sql, $conditions);
if (!empty($filerecords)) $text_for_records_present = '(' . count($filerecords) . ' present)';
else $text_for_records_present = '(none currently)';

// Access to applications.php is given by the "Manager" role which has moodle/site:viewparticipants
$is_manager = has_capability('moodle/site:viewparticipants', context_system::instance());

if ($is_manager) {
  echo '<a href="' . $CFG->wwwroot . '/course/peoples_files.php?student_id=' . $userid . '" target="_blank">Manage "Peoples-uni Record Files" for the Student</a> ' . $text_for_records_present . '<br />';
}
elseif (!empty($filerecords)) {
  echo '<a href="' . $CFG->wwwroot . '/course/peoples_files.php?student_id=' . $userid . '" target="_blank">Your "Peoples-uni Record Files"</a><br />';
}


if ($isteacher) {
?>
<br /><br />To send an e-mail to this student (EDIT the e-mail text below!), press "e-mail Student".<br />
<form id="emailstudentform" method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
<textarea name="mailtext" rows="10" cols="75" wrap="hard" style="width:auto">
Dear <?php echo htmlspecialchars($userrecord->firstname, ENT_COMPAT, 'UTF-8'); ?>,

<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>


    Peoples Open Access Education Initiative Administrator.
</textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markemailstudent" value="1" />
<input type="submit" name="emailstudent" value="e-mail Student" />
</form>
<br /><br />
<?php

  $notes = $DB->get_records('peoplesstudentnotes', array('userid' => $userid), 'datesubmitted DESC');
	if (!empty($notes)) {
		echo 'Notes...<br />';
		echo '<table border="1" BORDERCOLOR="RED">';
		foreach ($notes as $note) {
			echo '<tr><td>';
			echo gmdate('d/m/Y H:i', $note->datesubmitted);
			echo '</td><td>';
			echo $note->note;
			echo '</td></tr>';
		}
		echo '</table>';
	}
?>
<br />To add a note to this student's record, add text below and press "Add...".<br />
<form id="addnoteform" method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
<textarea name="note" rows="5" cols="100" wrap="hard" style="width:auto"></textarea>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markaddnote" value="1" />
<input type="submit" name="addnote" value="Add This Note to Student Record" />
</form>
<br /><br />

<?php if (!empty($peoplesmph2)) { ?>
<br />To mark this student as graduated with MPH, select semester (defaults to current) & type of pass below and press "Mark...".<br />
<form id="graduatedform" method="post" action="<?php echo $CFG->wwwroot . '/course/student.php?id=' . $userid; ?>">
<?php
$semesters = $DB->get_records('semesters', NULL, 'id ASC');
$latest_semester = '';
foreach ($semesters as $semester) {
  $latest_semester = $semester->semester;
}
?>
<select name="semester_graduated">
<?php
foreach ($semesters as $semester) {
  if ($semester->semester == $latest_semester) $selected = 'selected="selected"';
  else $selected = '';
  echo '<option value="' . htmlspecialchars($semester->semester, ENT_COMPAT, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($semester->semester, ENT_COMPAT, 'UTF-8') . '</option>';
}
?>
</select>
<select name="graduated">
<option value="1" >Pass</option>
<option value="2" >Merit</option>
<option value="3" >Distinction</option>
</select>
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markgraduated" value="1" />
<input type="submit" name="submitgraduated" value="Mark this Student as Graduated with MPH" />
</form>
<br /><br />
<?php } ?>

<?php

	echo '<a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $userid . '">Student Submissions</a><br />';
	echo '<a href="' . $CFG->wwwroot . '/course/coursegrades.php">(Student Enrolments and Grades for All Students)</a><br />';
}
elseif ($islurker) {
  $notes = $DB->get_records('peoplesstudentnotes', array('userid' => $userid), 'datesubmitted DESC');
  if (!empty($notes)) {
    echo '<br /><br />Notes...<br />';
    echo '<table border="1" BORDERCOLOR="RED">';
    foreach ($notes as $note) {
      echo '<tr><td>';
      echo gmdate('d/m/Y H:i', $note->datesubmitted);
      echo '</td><td>';
      echo $note->note;
      echo '</td></tr>';
    }
    echo '</table>';
  }

  echo '<br /><br />';
  echo '<a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $userid . '">Student Submissions</a><br />';
  echo '<a href="' . $CFG->wwwroot . '/course/coursegrades.php">(Student Enrolments and Grades for All Students)</a><br />';
}


echo '<br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';

echo $OUTPUT->footer();
?>
