<?php  // $Id: regaction.php,v 1.1 2011/12/28 08:01:00 alanbarrett Exp $
/**
*
* Handle form submissions from reg.php
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


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/mod/forum/lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/regaction.php'); // Defined here to avoid notices on errors etc

require_login();

require_capability('moodle/site:viewparticipants', context_system::instance());

if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

?><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php


$application = $DB->get_record('peoplesregistration', array('id' => $_POST['sid']));
if (empty($application)) {
?>
<br/><br/><br/><strong>Bad Registration Record Passed!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
</body>
</html>
<?php
}

if (!empty($_POST['defertext']) && !empty($_POST['markdeferapplication'])) {
  $email = $application->email;
  $body = $_POST['defertext'];
  $body = strip_tags($body);
  $body = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $body); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                   // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

  $subject = 'Peoples-Uni Registration';

  if (!sendapprovedmail($email, $subject, $body)) {
?>
<br/><br/><br/><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
</body>
</html>
<?php
    die();
  }
}
elseif (!empty($_POST['username']) && !empty($_POST['markupdateusername'])) {
  $_POST['username'] = strip_tags($_POST['username']);
  $_POST['username'] = str_replace("<", '', $_POST['username']);
  $_POST['username'] = str_replace(">", '', $_POST['username']);
  $_POST['username'] = str_replace("/", '', $_POST['username']);
  $_POST['username'] = str_replace("#", '', $_POST['username']);
  $_POST['username'] = trim(core_text::strtolower($_POST['username']));

  updateapplication($_POST['sid'], 'username', $_POST['username']);
}
elseif (!empty($_POST['markdeleteentry'])) {

  updateapplication($_POST['sid'], 'hidden', 1);
}
elseif (!empty($_POST['markallowlateapplication']) && !empty($application->userid)) {
  $days_offset = (int)$_POST['days_offset'];
  $deadline = gmmktime(27, 0, 0); // 3:00am early tomorrow morning (GMT)
  $deadline += (60*60*24) * $days_offset; // Add correct number of days

  $late_applications_allowed = $DB->get_record('late_applications_allowed', array('userid' => $application->userid));
  if (!empty($late_applications_allowed)) {
    $late_applications_allowed->approverid = $USER->id;
    $late_applications_allowed->datesubmitted = time();
    $late_applications_allowed->deadline = $deadline;
    $DB->update_record('late_applications_allowed', $late_applications_allowed);
  }
  else {
    $late_applications_allowed = new object();
    $late_applications_allowed->userid = $application->userid;
    $late_applications_allowed->approverid = $USER->id;
    $late_applications_allowed->datesubmitted = time();
    $late_applications_allowed->deadline = $deadline;
    $DB->insert_record('late_applications_allowed', $late_applications_allowed);
  }
}
elseif (!empty($_POST['approvedtext']) && !empty($_POST['markapproveapplication'])) {
  $email = $application->email;
  $body = $_POST['approvedtext'];
  $body = strip_tags($body);
  $body = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $body); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                   // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

  $subject = 'Peoples-Uni Registration Approved';

  if (!sendapprovedmail($email, $subject, $body)) {
?>
<br/><br/><br/><strong>For some reason the E-MAIL COULD NOT BE SENT!</strong>
<br/><br/><br/><strong><a href="javascript:window.close();">Close Window</a></strong>
</body>
</html>
<?php
    die();
  }

  $user = new stdClass();
  $user->username = $application->username;
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

  $user->lastname     = $application->lastname;
  $user->firstname    = $application->firstname;
  $user->email        = $application->email;
  $user->city         = $application->city;
  $user->country      = $application->country;
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

  $monthnames = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
  $user->dateofbirth = $application->dobday . ' ' . $monthnames[$application->dobmonth] . ' ' . $application->dobyear;

  $user->gender = $application->gender;

  // textarea with hard wrap will send CRLF so we end up with extra CRs, so we should remove \r's for niceness
  $user->applicationaddress = str_replace("\r", '', str_replace("\n", '<br />', $application->applicationaddress));

  if (!empty($application->currentjob)) {
    $user->currentjob = str_replace("\r", '', str_replace("\n", '<br />', $application->currentjob));
  }

  $user->education = str_replace("\r", '', str_replace("\n", '<br />', $application->education));

  $user->reasons = str_replace("\r", '', str_replace("\n", '<br />', $application->reasons));

  if (!empty($application->sponsoringorganisation)) {
    $user->sponsoringorganisation = str_replace("\r", '', str_replace("\n", '<br />', $application->sponsoringorganisation));
  }

  if (!empty($qualificationname[$application->qualification])) {
    $user->qualification = $qualificationname[$application->qualification];
  }

  if (!empty($higherqualificationname[$application->higherqualification])) {
    $user->higherqualification = $higherqualificationname[$application->higherqualification];
  }

  if (!empty($employmentname[$application->employment])) {
    $user->employment = $employmentname[$application->employment];
  }

  $fields = $DB->get_records_sql("SELECT id, shortname FROM mdl_user_info_field WHERE shortname IN ('dateofbirth', 'applicationaddress', 'currentjob', 'education', 'reasons', 'sponsoringorganisation', 'gender', 'qualification', 'higherqualification', 'employment')");
  if (!empty($fields)) {
    foreach ($fields as $field) {
      $data = new object();
      $data->userid  = $user->id;
      $data->fieldid = $field->id;
      if (!empty($user->{$field->shortname})) {
        $data->data = ($user->{$field->shortname});
        $DB->insert_record('user_info_data', $data);
      }
    }
  }

  if (!empty($qualificationname[$application->qualification]) &&
    !empty($higherqualificationname[$application->higherqualification]) &&
    !empty($employmentname[$application->employment])) {

    $data = new object();
    $data->userid              = $user->id;
    $data->parentsid           = 0;
    $data->qualification       = $application->qualification;
    $data->higherqualification = $application->higherqualification;
    $data->employment          = $application->employment;
    $DB->insert_record('applicantqualifications', $data);
  }

  $user = $DB->get_record('user', array('id' => $user->id));

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
    updateapplication($_POST['sid'], 'state', 1);

    die();
  }

  updateapplication($_POST['sid'], 'userid', $user->id);

  // Enrol student in Foundations of Public Health
  // ... This is now Academic skills course
  $fph = $DB->get_record('course', array('id' => get_config(NULL, 'foundations_public_health_id')));
  $fph_id = 0;
  if (!empty($fph)) {
    enrolincoursesimple($fph, $user);
    $fph_id = $fph->id;
  }

  // Enrol student in Students Corner
  $sc = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_students_corner_id')));
  $sc_id = 0;
  if (!empty($sc) && ($sc->id != $fph_id)) {
    enrolincoursesimple($sc, $user);
    $sc_id = $sc->id;
  }

//  // Enrol student in Student Support Forums
//  $ssf = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_student_support_id')));
//  if (!empty($ssf) && ($ssf->id != $fph_id) && ($ssf->id != $sc_id)) {
//    enrolincoursesimple($ssf, $user);
//  }

  // This is now in Academic skills course and is Forced Subscribe
  // forum_subscribe($user->id, get_config(NULL, 'peoples_student_support_forum_id'));

//  // Keep a note of the specified Forum in case they accidentally unsubscribe or subscribe to more than one (see reset_studentscorner_subscriptions.php)
//  $forum_subscriptions_specified = new stdClass();
//  $forum_subscriptions_specified->userid = $user->id;
//  $forum_subscriptions_specified->forum = get_config(NULL, 'peoples_student_support_forum_id');
//  if (!empty($forum_subscriptions_specified->forum) && !$DB->record_exists('forum_subscriptions_specified', array('userid' => $forum_subscriptions_specified->userid, 'forum' => $forum_subscriptions_specified->forum))) {
//    $DB->insert_record('forum_subscriptions_specified', $forum_subscriptions_specified);
//  }

  $peoples_income_category = $DB->get_record('peoples_income_category', array('userid' => $user->id));
  if (empty($peoples_income_category)) {
    $peoples_income_category = new object();
    $peoples_income_category->userid = $user->id;
    $peoples_income_category->datesubmitted = time();
    $peoples_income_category->income_category = 1; // Default LMIC
    $DB->insert_record('peoples_income_category', $peoples_income_category);
  }

  updateapplication($_POST['sid'], 'state', 1);
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


function sendapprovedmail($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999;
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  //$supportuser = generate_email_supportuser();
  $supportuser = new stdClass();
  $supportuser->email = 'apply@peoples-uni.org';
  $supportuser->firstname = "People's Open Access Education Initiative: Peoples-uni";
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


/**
 * Send email to specified user with confirmation text and activation link.
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


function sendstudentscorner($user) {
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


function enrolincoursesimple($course, $user) {
  global $DB;

  $timestart = time();
  // remove time part from the timestamp and keep only the date part
  $timestart = make_timestamp(date('Y', $timestart), date('m', $timestart), date('d', $timestart), 0, 0, 0);

  $roles = get_archetype_roles('student');
  $role = reset($roles);

  enrol_try_internal_enrol($course->id, $user->id, $role->id, $timestart, 0);

  // emailwelcome($course, $user);

  $message = '';
  if (!empty($user->firstname))  $message .= $user->firstname;
  if (!empty($user->lastname)) $message .= ' ' . $user->lastname;
  if (!empty($role->name)) $message .= ' as ' . $role->name;
  if (!empty($course->fullname)) $message .= ' in ' . $course->fullname;
  add_to_log($course->id, 'course', 'enrol', '../enrol/users.php?id=' . $course->id, $message, 0, $user->id);
}


function updateapplication($id, $field, $value) {
  global $DB;

  $application = new object();
  $application->id = $id;
  $application->{$field} = $value;

  $DB->update_record('peoplesregistration', $application);
}
?>