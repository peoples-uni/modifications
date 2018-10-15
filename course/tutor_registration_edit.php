<?php

/**
 * Tutor Registration Edit form for Peoples-uni Tutors
 */

require_once('../config.php');
require_once('tutor_registration_edit_form.php');

$id = optional_param('id', 0, PARAM_INT);
$userid = optional_param('userid', 0, PARAM_INT);
$md5 = optional_param('md5', '', PARAM_ALPHANUM);

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');
$pageparams = array('id' => $id, 'userid' => $userid);
if (!empty($md5)) $pageparams['md5'] = $md5;
$PAGE->set_url('/course/tutor_registration_edit.php', $pageparams);


require_login();
// (Might possibly be Guest)
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $USER->id));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$fullname = fullname($userrecord);
if (empty($fullname) || trim($fullname) == 'Guest User') {
  $SESSION->wantsurl = "$CFG->wwwroot/course/tutor_registration_edit.php";
  notice('<br /><br /><b>You have not logged in. Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}


if (has_capability('moodle/site:viewparticipants', context_system::instance())) {
  $is_admin = TRUE;
}
elseif ($md5) {
  $idoruserid = $id;
  if (empty($idoruserid)) $idoruserid = $userid;
  if (md5("{$USER->id}jaybf6laHU{$idoruserid}") === $md5) $is_admin = TRUE;
  else $is_admin = FALSE;
}
else {
  $is_admin = FALSE;
}

if (($id || $userid) && $is_admin) {
  $passed_id = TRUE;
}
else {
  $id = 0;
  $userid = 0;
  $passed_id = FALSE;
  $peoples_tutor_registration = $DB->get_record('peoples_tutor_registration', array('userid' => $USER->id));
  if (!empty($peoples_tutor_registration)) $id = $peoples_tutor_registration->id;
}

if ($id) {
  $peoples_tutor_registration = $DB->get_record('peoples_tutor_registration', array('id' => $id));
}

if (($id == 0) && $userid) {
  // We will be doing an insert not an update if the form is submitted
}
elseif (empty($peoples_tutor_registration)) {
  if ($passed_id) {
    echo '<h1>peoples_tutor_registration matching id does not exist!</h1>';
  }
  else {
    echo "<h1>You do not have an entry in the 'peoples_tutor_registration' table!</h1>";
  }
  die();
}


$data = new stdClass();

$options = array('subdirs' => 1, 'maxbytes' => 0, 'maxfiles' => -1, 'accepted_types' => '*', 'areamaxbytes' => -1);

if (!empty($peoples_tutor_registration) && !empty($peoples_tutor_registration->userid)) {
  $context = context_user::instance($peoples_tutor_registration->userid);

  //function file_prepare_standard_filemanager($data, $field[in form will expect "{$field}_filemanager"], array $options, $context=null, $component=null, $filearea=null, $itemid=null) {...}
  file_prepare_standard_filemanager($data, 'files', $options, $context, 'peoples_record_tutor', 'tutor', 0);
}


$failure = FALSE;
$editform = new tutor_registration_edit_form($PAGE->url, array('data' => $data, 'customdata' => array('id' => $id, 'userid' => $userid, 'is_admin' => $is_admin), 'options' => $options));
if ($editform->is_cancelled()) {
  redirect(new moodle_url($CFG->wwwroot . '/course/tutor_registrations.php'));
}
elseif ($data = $editform->get_data()) {

  if ($id) {
    $peoples_tutor_registration = $DB->get_record('peoples_tutor_registration', array('id' => $id));
  }
  elseif ($userid) {
    // We are doing an insert not an update
    $peoples_tutor_registration = $DB->get_record('peoples_tutor_registration', array('userid' => $userid));
    $userrecord = $DB->get_record('user', array('id' => $userid));
    if (empty($userrecord) || !empty($peoples_tutor_registration)) {
      echo '<h1>peoples_tutor_registration for userid already exists but this should be an insert!</h1>';
      die();
    }

    $peoples_tutor_registration = new stdClass();
    $peoples_tutor_registration->datesubmitted = time();
    $peoples_tutor_registration->state = 1;
    $peoples_tutor_registration->userid = $userid;
    $peoples_tutor_registration->username = 'user1';
    $peoples_tutor_registration->lastname = $userrecord->lastname;
    $peoples_tutor_registration->firstname = $userrecord->firstname;
    $peoples_tutor_registration->gender = '';
    $peoples_tutor_registration->email = $userrecord->email;
    $peoples_tutor_registration->city = $userrecord->city;
    $peoples_tutor_registration->country = $userrecord->country;
    $peoples_tutor_registration->datefirstapproved = $userrecord->timecreated;
    $peoples_tutor_registration->datelastapproved = $userrecord->timecreated;
    $peoples_tutor_registration->hidden = 0;

    $peoples_tutor_registration->volunteertype = ''; // Ensure set to default...
    $peoples_tutor_registration->modulesofinterest = '';
    $peoples_tutor_registration->notes = '';
  }
  else {
    echo '<h1>peoples_tutor_registration id and userid are both zero!</h1>';
    die();
  }
  if (empty($peoples_tutor_registration)) {
    echo '<h1>peoples_tutor_registration matching id does not exist after form submission!</h1>';
    die();
  }

  $dataitem = $data->reasons;
  if (empty($dataitem)) $dataitem = '';
  $peoples_tutor_registration->reasons = $dataitem;

  $dataitem = $data->education;
  if (empty($dataitem)) $dataitem = '';
  $peoples_tutor_registration->education = $dataitem;

  $dataitem = $data->tutoringexperience;
  if (empty($dataitem)) $dataitem = '';
  $peoples_tutor_registration->tutoringexperience = $dataitem;

  $dataitem = $data->currentjob;
  if (empty($dataitem)) $dataitem = '';
  $peoples_tutor_registration->currentjob = $dataitem;

  $dataitem = $data->currentrole;
  if (empty($dataitem)) $dataitem = '';
  $peoples_tutor_registration->currentrole = $dataitem;

  $dataitem = $data->otherinformation;
  if (empty($dataitem)) $dataitem = '';
  $peoples_tutor_registration->otherinformation = $dataitem;

  $dataitem = $data->howfoundpeoples;
  if (empty($dataitem)) $dataitem = '0';
  $dataitem = strip_tags($dataitem);
  $peoples_tutor_registration->howfoundpeoples = $dataitem;

  $dataitem = $data->howfoundorganisationname;
  if (empty($dataitem)) $dataitem = '';
  $peoples_tutor_registration->howfoundorganisationname = $dataitem;

  if ($is_admin) {
    $dataitem = $data->volunteertype;
    $arraystring = '';
    foreach ($dataitem as $datax) {
      $datax = (int)$datax;
      $arraystring .= $datax . ',';
    }
    if (!empty($arraystring)) $arraystring = substr($arraystring, 0, strlen($arraystring) - 1);
    $peoples_tutor_registration->volunteertype = $arraystring;

    $dataitem = $data->modulesofinterest;
    if (empty($dataitem)) $dataitem = '';
    $peoples_tutor_registration->modulesofinterest = $dataitem;

    $dataitem = $data->notes;
    if (empty($dataitem)) $dataitem = '';
    $peoples_tutor_registration->notes = $dataitem;
  }


  if (!empty($data->register_in_moodle) && !empty($peoples_tutor_registration->username)) {
    $username = $peoples_tutor_registration->username;
    $suffix = '';
    while ($userrecord = $DB->get_record('user', array('username' => $username . $suffix))) {
      if (empty($suffix)) {
        $username = mb_substr($username, 0, 98, 'UTF-8');
        $suffix = 1;
      }
      else {
        $suffix++;
      }

      if ($suffix >= 100) {
        $failure = TRUE;
        break;
      }
    }
  }

  if (!empty($data->register_in_moodle) && !empty($peoples_tutor_registration->username) && !$failure) {

    $peoples_tutor_registration->username = $username . $suffix;

    $user = new stdClass();
    $user->username     = $peoples_tutor_registration->username;
    $user->password     = (string)rand(100000, 999999);
    $user->lastname     = $peoples_tutor_registration->lastname;
    $user->firstname    = $peoples_tutor_registration->firstname;
    $user->email        = $peoples_tutor_registration->email;
    $user->city         = $peoples_tutor_registration->city;
    $user->country      = $peoples_tutor_registration->country;
    $user->lang         = 'en';
    $user->description  = '';
    $user->descriptionformat = 1;
    $user->imagealt     = '';

    $user->confirmed    = 1;
    $user->deleted      = 0;

    $user->timemodified = time();
    $user->timecreated  = $user->timemodified;

    $user->mnethostid   = $CFG->mnet_localhost_id;
    $user->auth         = 'manual';

    require_once($CFG->dirroot.'/user/profile/lib.php');

    $passwordforemail = $user->password;

    $user->password = hash_internal_user_password($user->password);

    if (!($user->id = $DB->insert_record('user', $user))) {
      echo '<h1>For some reason this Moodle User CANNOT BE CREATED!</h1>';
      die();
    }
    $peoples_tutor_registration->userid = $user->id;

    set_user_preference('auth_forcepasswordchange', 0, $user->id); // 1 Would force a change on first login!
    set_user_preference('email_bounce_count',       1, $user->id);
    set_user_preference('email_send_count',         1, $user->id);

    $user = $DB->get_record('user', array('id' => $user->id));

    context_user::instance($user->id);

    // events_trigger('user_created', $user);
    \core\event\user_created::create_from_userid($user->id)->trigger();

    sendunpw($user, $passwordforemail);

    $peoples_tutor_registration->state = 1;

    $peoples_tutor_registration->datefirstapproved = time();
    $peoples_tutor_registration->datelastapproved = $peoples_tutor_registration->datefirstapproved;
  }

  if (!empty($data->clear_sensitive_profile_items) && !empty($peoples_tutor_registration->userid)) {
    error_log('Clearing Sensitive Profile Items for User: ' . $peoples_tutor_registration->userid);
    $user_info_datas = $DB->get_records_sql("SELECT * FROM mdl_user_info_data WHERE fieldid IN (3,4,5,6,7,8,9,10) AND userid=" . $peoples_tutor_registration->userid);
    if (!empty($user_info_datas)) {
      foreach ($user_info_datas as $user_info_data) {
        $user_info_data->data = '';
        $DB->update_record('user_info_data', $user_info_data);
      }
    }
    /* Only allow profile to be cleared once because a Tutor might want to enter data for cleared fields
    CREATE TABLE mdl_profile_cleared (
      id BIGINT(10) UNSIGNED NOT NULL auto_increment,
      userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
    CONSTRAINT PRIMARY KEY (id)
    );
    */
    $profile_cleared = new stdClass();
    $profile_cleared->userid = $peoples_tutor_registration->userid;
    $DB->insert_record('profile_cleared', $profile_cleared);
  }

  if (!empty($data->hide_tutor_form)) {
    $peoples_tutor_registration->hidden = 1;
  }

  if (!empty($id)) {
    $DB->update_record('peoples_tutor_registration', $peoples_tutor_registration);
  }
  else {
    $DB->insert_record('peoples_tutor_registration', $peoples_tutor_registration);
  }


  if (!empty($data->files_filemanager) && !empty($context)) {
    $data = file_postupdate_standard_filemanager($data, 'files', $options, $context, 'peoples_record_tutor', 'tutor', 0);
  }


  redirect(new moodle_url($CFG->wwwroot . '/course/tutor_registrations.php'));
}


// Print the form

$PAGE->set_title("People's Open Access Education Initiative Tutor Registration Edit Form");
$PAGE->set_heading('Peoples-uni Tutor Registration Edit Form');

echo $OUTPUT->header();

if ($failure) {
  echo '<h1>Requested username could not be used or simply modified, so no Moodle account was created!</h1>';
}


$editform->display();

echo $OUTPUT->footer();


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
different login): https://peoples-uni.org

Your profile is at:
https://courses.peoples-uni.org/user/view.php?id=USER_ID_HERE&course=1
You are welcome to personalize this, so students
and colleagues can learn more about you.

You will soon receive information about next steps.

If you need help, please contact the site administrator,
TECHSUPPORT_EMAIL_HERE";

  $site = get_site();

  //$studentscorner = $DB->get_record('course', array('id' => get_config(NULL, 'peoples_students_corner_id')));

  $message = str_replace('FULL_NAME_HERE',          fullname($user), $message);
  $message = str_replace('SITE_NAME_HERE',          format_string($site->fullname), $message);
  $message = str_replace('USERNAME_HERE',           $user->username, $message);
  $message = str_replace('PASSWORD_HERE',           $passwordforemail, $message);
  $message = str_replace('LOGIN_LINK_HERE',         $CFG->wwwroot . '/login/index.php', $message);
  //$message = str_replace('STUDENTS_CORNER_ID_HERE', $studentscorner->id, $message);
  $message = str_replace('USER_ID_HERE',            $user->id, $message);
  //$message = str_replace('TECHSUPPORT_EMAIL_HERE',  "\nPeoples-uni Support\ntechsupport@helpdesk.peoples-uni.org\n", $message);
  $message = str_replace('TECHSUPPORT_EMAIL_HERE',  "\nPeoples-uni Support\nvolunteer@peoples-uni.org\n", $message);

  $message = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $message); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                         // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)
  $message = preg_replace('#(https://[^\s]+)[\s]+#', "$1\n\n", $message);

  //$supportuser = generate_email_supportuser();
  $supportuser = new stdClass();
  //$supportuser->email = 'techsupport@helpdesk.peoples-uni.org';
  $supportuser->id = 999999998; $supportuser->username = 'none';
  $supportuser->email = 'volunteer@peoples-uni.org';
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
