<?php  // $Id: appaction.php,v 1.1 2008/08/02 17:18:32 alanbarrett Exp $
/**
*
* Handle form submissions from app.php
*
*/

/*
CREATE TABLE mdl_enrolment (
	id BIGINT(10) unsigned NOT NULL auto_increment,
	userid BIGINT(10) unsigned NOT NULL DEFAULT 0,
	courseid BIGINT(10) unsigned NOT NULL DEFAULT 0,
	semester VARCHAR(255) NOT NULL,
	datefirstenrolled BIGINT(10) unsigned NOT NULL DEFAULT 0,
	dateunenrolled BIGINT(10) unsigned NOT NULL DEFAULT 0,
	enrolled TINYINT(2) unsigned NOT NULL DEFAULT 1,			[unsigned was left out]
	notified TINYINT(2) unsigned NOT NULL DEFAULT 0,
	datenotified BIGINT(10) unsigned NOT NULL DEFAULT 0,
	gradenotified BIGINT(10) unsigned,
  percentgrades BIGINT(10) unsigned NOT NULL DEFAULT 0,
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_enrol_uid_ix ON mdl_enrolment (userid);
CREATE INDEX mdl_enrol_cid_ix ON mdl_enrolment (courseid);
CREATE INDEX mdl_enrol_sem_ix ON mdl_enrolment (semester);

(ALTER TABLE mdl_enrolment ADD percentgrades BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER gradenotified;)

CREATE TABLE mdl_applicantqualifications (
	id BIGINT(10) unsigned NOT NULL auto_increment,
	userid BIGINT(10) unsigned NOT NULL DEFAULT 0,
	parentsid BIGINT(10) unsigned NOT NULL DEFAULT 0,	[[Not used]]
	qualification BIGINT(10) unsigned NOT NULL DEFAULT 0,
	higherqualification BIGINT(10) unsigned NOT NULL DEFAULT 0,
	employment BIGINT(10) unsigned NOT NULL DEFAULT 0,
CONSTRAINT  PRIMARY KEY (id)
);
CREATE INDEX mdl_applicantqualifications_uid_ix ON mdl_applicantqualifications (userid);
CREATE INDEX mdl_applicantqualifications_sid_ix ON mdl_applicantqualifications (parentsid);


Custom Profile Fields for Peoples-Uni...
-dateofbirth
Date of birth
(text input, locked, visible to user)

-gender
Gender
(text input, locked, visible to user)

-applicationaddress
Application address
(text area, visible to user)

-currentjob
Current job
(text area, visible to user)

-education
Previous educational experience
(text area, visible to user)

-reasons
Reasons for wanting to enrol
(text area, locked, visible to user)

-sponsoringorganisation [Added 20110717]
Sponsoring organisation
(text area, visible to user)

-qualification      [Added 20080217]
Higher Education Qualification
(text area, locked, visible to user)

-higherqualification	[Added 20080217]
Postgraduate Qualification
(text area, locked, visible to user)

-employment				[Added 20080217]
Current Employment
(text area, locked, visible to user)
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


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/appaction.php'); // Defined here to avoid notices on errors etc

//$PAGE->set_pagelayout('embedded');   // Needs as much space as possible
//$PAGE->set_pagelayout('base');     // Most backwards compatible layout without the blocks - this is the layout used by default
//$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();

//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

?><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

if (!empty($_POST['approvedtext']) && !empty($_POST['markapproveapplication'])) {
	$email = dontstripslashes($_POST['email']);
	$email = strip_tags($email);
	$body = dontstripslashes($_POST['approvedtext']);
	$body = strip_tags($body);
  $body = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $body); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                   // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

	$subject = 'Peoples-Uni Application Approved';

	if (!sendapprovedmail($email, $subject, $body)) {
?>
<br/><br/><br/><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
</body>
</html>
<?php
		die();
	}

	updateapplication($_POST['sid'], 'state', 9, 2);
}
elseif (!empty($_POST['defertext']) && !empty($_POST['markdeferapplication'])) {
	// Not really defer anymore, just send mail (but update status, might need to be 022)
	$email = dontstripslashes($_POST['email']);
	$email = strip_tags($email);
	$body = dontstripslashes($_POST['defertext']);
	$body = strip_tags($body);
  $body = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $body); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                   // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

	$subject = 'Peoples-Uni Application';

	if (!sendapprovedmail($email, $subject, $body)) {
?>
<br/><br/><br/><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
</body>
</html>
<?php
		die();
	}

	updateapplication($_POST['sid'], 'state', $_POST['state']);
}
elseif (!empty($_POST['userid']) && !empty($_POST['markupdateuserid'])) {

	updateapplication($_POST['sid'], 'userid', $_POST['userid']);
}
elseif (!empty($_POST['username']) && !empty($_POST['markupdateusername'])) {
	$_POST['username'] = strip_tags($_POST['username']);
	$_POST['username'] = str_replace("<", '', $_POST['username']);
	$_POST['username'] = str_replace(">", '', $_POST['username']);
	$_POST['username'] = str_replace("/", '', $_POST['username']);
	$_POST['username'] = str_replace("#", '', $_POST['username']);
	$_POST['username'] = trim(core_text::strtolower($_POST['username']));
//	$_POST['username'] = eregi_replace("[^(-\.[:alnum:])]", '', $_POST['username']);

	updateapplication($_POST['sid'], 'username', $_POST['username']);
}
elseif (!empty($_POST['newpaymentmethod']) && !empty($_POST['markdeleteentry'])) {

	updateapplication($_POST['sid'], 'hidden', 1);
}
elseif (!empty($_POST['username']) && (
	!empty($_POST['markcreateuser1']) ||
	!empty($_POST['markcreateuser2']) ||
	!empty($_POST['markcreateuser12']))) {

	$create1 = false;
	$create2 = false;
	if (!empty($_POST['markcreateuser1']) || !empty($_POST['markcreateuser12'])) $create1 = true;
	if (!empty($_POST['markcreateuser2']) || !empty($_POST['markcreateuser12'])) $create2 = true;

	$newstate = $_POST['state'];

	$_POST['username'] = strip_tags($_POST['username']);
	$_POST['username'] = str_replace("<", '', $_POST['username']);
	$_POST['username'] = str_replace(">", '', $_POST['username']);
	$_POST['username'] = str_replace("/", '', $_POST['username']);
	$_POST['username'] = str_replace("#", '', $_POST['username']);
	$_POST['username'] = trim(core_text::strtolower($_POST['username']));
//	$_POST['username'] = eregi_replace("[^(-\.[:alnum:])]", '', $_POST['username']);

	$user->username    = $_POST['username'];
	if (empty($user->username)) {
?>
<br/><br/><br/><strong>Username is BLANK and CANNOT BE CREATED in Moodle!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
</body>
</html>
<?php
		die();
	}

	$user->password     = (string)rand(100000, 999999);

	$user->lastname     = $_POST['lastname'];
	$user->firstname    = $_POST['firstname'];
	$user->email        = $_POST['email'];
	$user->city         = $_POST['city'];
	$user->country      = $_POST['country'];
  $user->lang         = 'en';
  $user->description  = '';
  $user->descriptionformat = 1;
  $user->imagealt     = '';

	$user->confirmed    = 1;
	$user->deleted      = 0;

	$user->timemodified = time();
  $user->timecreated  = time();

	$user->mnethostid   = $CFG->mnet_localhost_id;
	$user->auth         = 'manual';

	require_once($CFG->dirroot.'/user/profile/lib.php');

	$passwordforemail = $user->password;

	$user->password = hash_internal_user_password($user->password);

  $ur = $DB->get_record('user', array('username' => $user->username));
	if (!empty($ur)) {
?>
<br/><br/><br/><strong>For some reason this Moodle Username ALREADY EXISTS and CANNOT BE CREATED!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
</body>
</html>
<?php
		die();
	}

  if (!($user->id = $DB->insert_record('user', $user))) {
?>
<br/><br/><br/><strong>User FAILED to be Registered (BAD insert_record())!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
</body>
</html>
<?php
		die();
	}

  set_user_preference('auth_forcepasswordchange', 0, $user->id); // 1 Would force a change on first login!
  set_user_preference('email_bounce_count',       1, $user->id);
  set_user_preference('email_send_count',         1, $user->id);

	if (!empty($_POST['dobday']) && !empty($_POST['dobmonth']) && !empty($_POST['dobyear'])) {
		$monthnames = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$user->dateofbirth = $_POST['dobday'] . ' ' . $monthnames[$_POST['dobmonth']] . ' ' . $_POST['dobyear'];
	}
	if (!empty($_POST['gender'])) {
		$user->gender = $_POST['gender'];
	}
	if (!empty($_POST['applicationaddress'])) {
		// textarea with hard wrap will send CRLF so we end up with extra CRs, so we should remove \r's for niceness
		$user->applicationaddress = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars(dontstripslashes($_POST['applicationaddress']), ENT_COMPAT, 'UTF-8')));
	}
	if (!empty($_POST['currentjob'])) {
		$user->currentjob = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars(dontstripslashes($_POST['currentjob']), ENT_COMPAT, 'UTF-8')));
	}
	if (!empty($_POST['education'])) {
		$user->education = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars(dontstripslashes($_POST['education']), ENT_COMPAT, 'UTF-8')));
	}
  if (!empty($_POST['reasons'])) {
    $user->reasons = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars(dontstripslashes($_POST['reasons']), ENT_COMPAT, 'UTF-8')));
  }
  if (!empty($_POST['sponsoringorganisation'])) {
    $user->sponsoringorganisation = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars(dontstripslashes($_POST['sponsoringorganisation']), ENT_COMPAT, 'UTF-8')));
  }
	if (!empty($qualificationname[$_POST['qualification']])) {
		$user->qualification = $qualificationname[$_POST['qualification']];
	}
	if (!empty($higherqualificationname[$_POST['higherqualification']])) {
		$user->higherqualification = $higherqualificationname[$_POST['higherqualification']];
	}
	if (!empty($employmentname[$_POST['employment']])) {
		$user->employment = $employmentname[$_POST['employment']];
	}

  $fields = $DB->get_records_sql("SELECT id, shortname FROM mdl_user_info_field WHERE shortname IN ('dateofbirth', 'applicationaddress', 'currentjob', 'education', 'reasons', 'sponsoringorganisation', 'gender', 'qualification', 'higherqualification', 'employment')");
	if (!empty($fields)) {
    foreach ($fields as $field) {
			$data = new stdClass();
			$data->userid  = $user->id;
			$data->fieldid = $field->id;
			if (!empty($user->{$field->shortname})) {
				$data->data = dontaddslashes($user->{$field->shortname});
        $DB->insert_record('user_info_data', $data);
			}
    }
  }

  // Moodle 2 (but above as is)...
  // profile_save_data($user);

	if (!empty($qualificationname[$_POST['qualification']]) &&
		!empty($higherqualificationname[$_POST['higherqualification']]) &&
		!empty($employmentname[$_POST['employment']])) {

		$data = new stdClass();
		$data->userid			         = $user->id;
		$data->parentsid			     = 0;
		$data->qualification		   = $_POST['qualification'];
		$data->higherqualification = $_POST['higherqualification'];
		$data->employment			     = $_POST['employment'];
    $DB->insert_record('applicantqualifications', $data);
	}

  $user = $DB->get_record('user', array('id' => $user->id));

  //execute_sql('UPDATE mdl_peoplesstudentnotes SET userid=' . $user->id . ' WHERE sid=' . $_POST['sid']);
  $notes = $DB->get_records('peoplesstudentnotes', array('sid' => $_POST['sid']));
  if (!empty($notes)) {
    foreach ($notes as $note) {
      $note->userid = $user->id;
      $DB->update_record('peoplesstudentnotes', $note);
    }
  }

  $mphs = $DB->get_records('peoplesmph', array('sid' => $_POST['sid']));
  if (!empty($mphs)) {
    foreach ($mphs as $mph) {
      $mph->userid = $user->id;
      $DB->update_record('peoplesmph', $mph);
    }
  }

  $paymentnotes = $DB->get_records('peoplespaymentnote', array('sid' => $_POST['sid']));
  if (!empty($paymentnotes)) {
    foreach ($paymentnotes as $paymentnote) {
      $paymentnote->userid = $user->id;
      $DB->update_record('peoplespaymentnote', $paymentnote);
    }
  }

  context_user::instance($user->id);

	events_trigger('user_created', $user);

	if (!sendunpw($user, $passwordforemail)) {
?>
<br/><br/><br/><strong>Registered user sucessfully, BUT confirmation e-mail FAILED to send!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php

		updateapplication($_POST['sid'], 'userid', $user->id);

		// Attempt to complete enrollment
		if (empty($_POST['coursename1'])) die();
    $course = $DB->get_record('course', array('fullname' => $_POST['coursename1']));
		if (empty($course)) die();
		if (!enrolincourse($course, $user, $_POST['semester'])) die();

		updateapplication($_POST['sid'], 'state', $newstate);

		if (empty($_POST['coursename2'])) die();
		$course = $DB->get_record('course', array('fullname' => $_POST['coursename2']));
		if (empty($course)) die();
		if (!enrolincourse($course, $user, $_POST['semester'])) die();
		die();
	}

	updateapplication($_POST['sid'], 'userid', $user->id);

	// Enrol student in Students Corner
  //$studentscorner = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_students_corner_id')));
  if (!empty($studentscorner)) {
		enrolincoursesimple($studentscorner, $user);
	}

	if (empty($_POST['coursename1'])) {
?>
<br/><br/><br/><strong>Registered user sucessfully, BUT CAN NOT enrol the user in the first selected course because it is empty!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
		die();
	}

	if ($create1) {
    $course = $DB->get_record('course', array('fullname' => $_POST['coursename1']));
		if (empty($course)) {
?>
<br/><br/><br/><strong>Registered user sucessfully, BUT CAN NOT enrol the user in the first selected course '<?php echo htmlspecialchars(dontstripslashes($_POST['coursename1']), ENT_COMPAT, 'UTF-8'); ?>' because it CAN NOT BE FOUND!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
      die();
    }

		if (!enrolincourse($course, $user, $_POST['semester'])) {
?>
<br/><br/><br/><strong>Registered user sucessfully, BUT CAN NOT ENROL the user in the first selected course '<?php echo htmlspecialchars(dontstripslashes($_POST['coursename1']), ENT_COMPAT, 'UTF-8'); ?>'!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
      die();
		}

    $teacher = get_peoples_teacher($course);

    $a = new stdClass();
    $a->course = $course->fullname;
    $a->user = fullname($user);
    //$teacher->email = 'alanabarrett0@gmail.com';
    email_to_user($teacher, $user, get_string('enrolmentnew', 'enrol', $course->shortname), get_string('enrolmentnewuser', 'enrol', $a));
	}

	updateapplication($_POST['sid'], 'state', $newstate);

	if (empty($_POST['coursename2'])) {
?>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
window.opener.focus();
}
window.close();
</script>
</body>
</html>
<?php
		die();
	}

	if ($create2) {
    $course = $DB->get_record('course', array('fullname' => $_POST['coursename2']));
		if (empty($course)) {
?>
<br/><br/><br/><strong>Registered user sucessfully, BUT CAN NOT enrol the user in the second selected course '<?php echo htmlspecialchars(dontstripslashes($_POST['coursename2']), ENT_COMPAT, 'UTF-8'); ?>' because it CAN NOT BE FOUND!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
			die();
		}

		if (!enrolincourse($course, $user, $_POST['semester'])) {
?>
<br/><br/><br/><strong>Registered user sucessfully, BUT CAN NOT ENROL the user in the second selected course '<?php echo htmlspecialchars(dontstripslashes($_POST['coursename2']), ENT_COMPAT, 'UTF-8'); ?>'!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
			die();
		}

    $teacher = get_peoples_teacher($course);

    $a = new stdClass();
    $a->course = $course->fullname;
    $a->user = fullname($user);
    //$teacher->email = 'alanabarrett0@gmail.com';
    email_to_user($teacher, $user, get_string('enrolmentnew', 'enrol', $course->shortname), get_string('enrolmentnewuser', 'enrol', $a));
	}
}
elseif (!empty($_POST['userid']) && (
	!empty($_POST['markenroluser1']) ||
	!empty($_POST['markenroluser2']) ||
	!empty($_POST['markenroluser12']))) {

	$create1 = false;
	$create2 = false;
	if (!empty($_POST['markenroluser1']) || !empty($_POST['markenroluser12'])) $create1 = true;
	if (!empty($_POST['markenroluser2']) || !empty($_POST['markenroluser12'])) $create2 = true;

	$newstate = $_POST['state'];

  $user = $DB->get_record('user', array('id' => $_POST['userid']));
	if (empty($user)) {
?>
<br/><br/><br/><strong>For some reason this Moodle UserID DOES NOT EXIST!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
</body>
</html>
<?php
		die();
	}

  // Enrol student in Students Corner
  //$studentscorner = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_students_corner_id')));
  if (!empty($studentscorner)) {
    enrolincoursesimple($studentscorner, $user);
    sendstudentscorner($user);
  }

  // Enrol student in Student Support Forums
  //$studentsupportforums = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_student_support_id')));
  if (!empty($studentsupportforums)) {
    enrolincoursesimple($studentsupportforums, $user);
    sendstudentsupportforums($user);
  }

	if (empty($_POST['coursename1'])) {
?>
<br/><br/><br/><strong>CAN NOT enrol the user in the first selected course because it is empty!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
		die();
	}

	if ($create1) {
    $course = $DB->get_record('course', array('fullname' => $_POST['coursename1']));
		if (empty($course)) {
?>
<br/><br/><br/><strong>CAN NOT enrol the user in the first selected course '<?php echo htmlspecialchars(dontstripslashes($_POST['coursename1']), ENT_COMPAT, 'UTF-8'); ?>' because it CAN NOT BE FOUND!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
			die();
		}

		if (!enrolincourse($course, $user, $_POST['semester'])) {
?>
<br/><br/><br/><strong>CAN NOT ENROL the user in the first selected course '<?php echo htmlspecialchars(dontstripslashes($_POST['coursename1']), ENT_COMPAT, 'UTF-8'); ?>'!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
			die();
		}

    $teacher = get_peoples_teacher($course);

    $a = new stdClass();
    $a->course = $course->fullname;
    $a->user = fullname($user);
    //$teacher->email = 'alanabarrett0@gmail.com';
    email_to_user($teacher, $user, get_string('enrolmentnew', 'enrol', $course->shortname), get_string('enrolmentnewuser', 'enrol', $a));
	}

	updateapplication($_POST['sid'], 'state', $newstate);

	if (empty($_POST['coursename2'])) {
?>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
window.opener.focus();
}
window.close();
</script>
</body>
</html>
<?php
		die();
	}

	if ($create2) {
    $course = $DB->get_record('course', array('fullname' => $_POST['coursename2']));
		if (empty($course)) {
?>
<br/><br/><br/><strong>CAN NOT enrol the user in the second selected course '<?php echo htmlspecialchars(dontstripslashes($_POST['coursename2']), ENT_COMPAT, 'UTF-8'); ?>' because it CAN NOT BE FOUND!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
			die();
		}

		if (!enrolincourse($course, $user, $_POST['semester'])) {
?>
<br/><br/><br/><strong>CAN NOT ENROL the user in the second selected course '<?php echo htmlspecialchars(dontstripslashes($_POST['coursename2']), ENT_COMPAT, 'UTF-8'); ?>'!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
}
</script>
</body>
</html>
<?php
			die();
		}

    $teacher = get_peoples_teacher($course);

    $a = new stdClass();
    $a->course = $course->fullname;
    $a->user = fullname($user);
    //$teacher->email = 'alanabarrett0@gmail.com';
    email_to_user($teacher, $user, get_string('enrolmentnew', 'enrol', $course->shortname), get_string('enrolmentnewuser', 'enrol', $a));
	}
}
?>
<script type="text/javascript">
if (!window.opener.closed) {
window.opener.location.reload();
window.opener.focus();
}
window.close();
</script>
</body>
</html>
<?php


/**
 * Send email to specified user with confirmation text and activation link. [Not used as account is now given on registration]
 *
 * @uses $CFG
 * @param user $user A {@link $USER} object
 * @return bool|string Returns "true" if mail was sent OK, "emailstop" if email
 *          was blocked by user and "false" if there was another sort of error.
 */
function sendunpw($user, $passwordforemail) {
  global $DB;
  global $CFG;

  $message = "Hi FULL_NAME_HERE,

A new account has been created at 'SITE_NAME_HERE'.

Your new Username is: USERNAME_HERE
Your New Password is: PASSWORD_HERE

Please go to the following link to login:

LOGIN_LINK_HERE

In most mail programs, this should appear as a blue link
which you can just click on. If that doesn't work,
then cut and paste the address into the address
line at the top of your web browser window.

Be aware that you should use this link to login and
NOT the main Peoples-uni site (which has a completely
different login): http://peoples-uni.org

You should also read the student handbook at:

http://peoples-uni.org/content/student-handbook

You will receive separate e-mails, each with a link to one of
your selected course modules. Please access these and familiarise
yourself with the way the modules are laid out so you are ready
to start the course.
You will also be sent a welcome message when the course actually starts.

Additionally, you have been enrolled in the Students Corner:

http://courses.peoples-uni.org/course/view.php?id=STUDENTS_CORNER_ID_HERE

which is available for student chat.

Your profile is at:
http://courses.peoples-uni.org/user/view.php?id=USER_ID_HERE&course=1

Note that the private information in this is not visible to other students.

If you need help, please contact the site administrator,
TECHSUPPORT_EMAIL_HERE";

  $site = get_site();

  $studentscorner = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_students_corner_id')));

  $message = str_replace('FULL_NAME_HERE',          fullname($user), $message);
  $message = str_replace('SITE_NAME_HERE',          format_string($site->fullname), $message);
  $message = str_replace('USERNAME_HERE',           $user->username, $message);
  $message = str_replace('PASSWORD_HERE',           $passwordforemail, $message);
  $message = str_replace('LOGIN_LINK_HERE',         $CFG->wwwroot . '/login/index.php', $message);
  $message = str_replace('STUDENTS_CORNER_ID_HERE', $studentscorner->id, $message);
  $message = str_replace('USER_ID_HERE',            $user->id, $message);
  $message = str_replace('TECHSUPPORT_EMAIL_HERE',  "\nPeoples-uni Support\napply@peoples-uni.org\n", $message);

  $message = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $message); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                         // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

  //$supportuser = generate_email_supportuser();
  $supportuser = new stdClass();
  $supportuser->id = 999999998; $supportuser->username = 'none';
  $supportuser->email = 'apply@peoples-uni.org';
  $supportuser->firstname = "People's Open Access Education Initiative: Peoples-uni";
  $supportuser->lastname = '';
  $supportuser->firstnamephonetic = NULL;
  $supportuser->lastnamephonetic = NULL;
  $supportuser->middlename = NULL;
  $supportuser->alternatename = NULL;
  $supportuser->maildisplay = true;

  $subject = format_string($site->fullname) . ': Your Account has been Created';

  //$user->email = 'alanabarrett0@gmail.com';
  return email_to_user($user, $supportuser, $subject, $message);
}


function sendstudentscorner($user) { // Not used as this is now done on registration... Now not used at all (call is not reached)
  global $DB;
  global $CFG;

  $message = "Hi FULL_NAME_HERE,

You have been enrolled in the Students Corner for this semester:

http://courses.peoples-uni.org/course/view.php?id=STUDENTS_CORNER_ID_HERE

which is available for student chat.

If you need help, please contact the site administrator,
TECHSUPPORT_EMAIL_HERE";

  $site = get_site();

  $studentscorner = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_students_corner_id')));

  $message = str_replace('FULL_NAME_HERE',          fullname($user), $message);
  $message = str_replace('SITE_NAME_HERE',          format_string($site->fullname), $message);
  $message = str_replace('USERNAME_HERE',           $user->username, $message);
  $message = str_replace('LOGIN_LINK_HERE',         $CFG->wwwroot . '/login/index.php', $message);
  $message = str_replace('STUDENTS_CORNER_ID_HERE', $studentscorner->id, $message);
  $message = str_replace('USER_ID_HERE',            $user->id, $message);
  $message = str_replace('TECHSUPPORT_EMAIL_HERE',  "\nPeoples-uni Support\napply@peoples-uni.org\n", $message);

  $message = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $message); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                         // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

  //$supportuser = generate_email_supportuser();
  $supportuser = new stdClass();
  $supportuser->id = 999999998; $supportuser->username = 'none';
  $supportuser->email = 'apply@peoples-uni.org';
  $supportuser->firstname = "People's Open Access Education Initiative: Peoples-uni";
  $supportuser->lastname = '';
  $supportuser->firstnamephonetic = NULL;
  $supportuser->lastnamephonetic = NULL;
  $supportuser->middlename = NULL;
  $supportuser->alternatename = NULL;
  $supportuser->maildisplay = true;

  $subject = format_string($site->fullname) . ': Students Corner';

  //$user->email = 'alanabarrett0@gmail.com';
  return email_to_user($user, $supportuser, $subject, $message);
}


function sendstudentsupportforums($user) { // Not used as this is now done on registration... Now not used at all (call is not reached)
  global $DB;
  global $CFG;

  $message = "Hi FULL_NAME_HERE,

You have been enrolled in the Student Support Forums module:

http://courses.peoples-uni.org/course/view.php?id=STUDENT_SUPPORT_ID_HERE

This is in addition to the modules which you are going to study and the Students Corner.

Each student will be (or already has been) assigned to a specific discussion forum in the Student Support Forums module.
Discussion will be led by a Student Support Officer.
The Student Support Officer's role is to make contact with students as they enrol, continuing throughout the time they are with Peoples-uni, to provide support.

If you need help, please contact the site administrator,
TECHSUPPORT_EMAIL_HERE";

  $site = get_site();

  $studentsupportforums = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_student_support_id')));

  $message = str_replace('FULL_NAME_HERE',          fullname($user), $message);
  $message = str_replace('SITE_NAME_HERE',          format_string($site->fullname), $message);
  $message = str_replace('USERNAME_HERE',           $user->username, $message);
  $message = str_replace('LOGIN_LINK_HERE',         $CFG->wwwroot . '/login/index.php', $message);
  $message = str_replace('STUDENT_SUPPORT_ID_HERE', $studentsupportforums->id, $message);
  $message = str_replace('USER_ID_HERE',            $user->id, $message);
  $message = str_replace('TECHSUPPORT_EMAIL_HERE',  "\nPeoples-uni Support\napply@peoples-uni.org\n", $message);

  $message = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $message); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                         // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

  //$supportuser = generate_email_supportuser();
  $supportuser = new stdClass();
  $supportuser->id = 999999998; $supportuser->username = 'none';
  $supportuser->email = 'apply@peoples-uni.org';
  $supportuser->firstname = "People's Open Access Education Initiative: Peoples-uni";
  $supportuser->lastname = '';
  $supportuser->firstnamephonetic = NULL;
  $supportuser->lastnamephonetic = NULL;
  $supportuser->middlename = NULL;
  $supportuser->alternatename = NULL;
  $supportuser->maildisplay = true;

  $subject = format_string($site->fullname) . ': Student Support Forums';

  //$user->email = 'alanabarrett0@gmail.com';
  return email_to_user($user, $supportuser, $subject, $message);
}
?>