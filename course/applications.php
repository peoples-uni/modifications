<?php  // $Id: applications.php,v 1.1 2008/08/02 17:18:32 alanbarrett Exp $
/**
*
* List all course applications from Drupal
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
  city VARCHAR(120) NOT NULL DEFAULT '',
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
  alternatecoursename VARCHAR(255) NOT NULL DEFAULT '',
  applymmumph BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  applycertpatientsafety BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
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

ALTER TABLE mdl_peoplesapplication ADD alternatecoursename VARCHAR(255) NOT NULL DEFAULT ''  AFTER coursename4;

Will be used to support new Webform...
ALTER TABLE mdl_peoplesapplication ADD dob VARCHAR(20) NOT NULL DEFAULT '' AFTER semester;

ALTER TABLE mdl_peoplesapplication ADD sponsoringorganisation text NOT NULL DEFAULT '' AFTER reasons;
ALTER TABLE mdl_peoplesapplication ADD ready BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER state_4;

ALTER TABLE mdl_peoplesapplication ADD applymmumph BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER coursename4;
ALTER TABLE mdl_peoplesapplication ADD scholarship TEXT NOT NULL DEFAULT '' AFTER sponsoringorganisation;
ALTER TABLE mdl_peoplesapplication ADD whynotcomplete TEXT NOT NULL DEFAULT '' AFTER scholarship;
ALTER TABLE mdl_peoplesapplication ADD reenrolment BIGINT(10) unsigned NOT NULL DEFAULT 0 AFTER nid;

ALTER TABLE mdl_peoplesapplication ADD applycertpatientsafety BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER applymmumph;
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

Original peoplesmph table records get deleted, this one is always maintained (i.e. for note)
CREATE TABLE mdl_peoplesmph2 (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
  datelastunentolled BIGINT(10) UNSIGNED NOT NULL,
  mphstatus BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  graduated BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  suspended BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  semester_graduated VARCHAR(255) NOT NULL DEFAULT '',
  note text default '' NOT NULL,
CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoplesmph2_uid_ix ON mdl_peoplesmph2 (userid);

ALTER TABLE mdl_peoplesmph2 ADD graduated BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER mphstatus;
ALTER TABLE mdl_peoplesmph2 ADD semester_graduated VARCHAR(255) NOT NULL DEFAULT '' AFTER graduated;
ALTER TABLE mdl_peoplesmph2 ADD suspended BIGINT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER graduated;

mphstatus (in both tables)...
0 => Un-enrolled (in peoplesmph2, not used in peoplesmph)
1 => MMU MPH
2 => Peoples MPH
3 => OTHER(to be determined) MPH

graduated...
0 => not graduated
1 => pass
2 => Merit
3 => Distinction

CREATE TABLE mdl_peoples_cert_ps (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL,
  datelastunentolled BIGINT(10) UNSIGNED NOT NULL,
  cert_psstatus BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  note text default '' NOT NULL,
CONSTRAINT PRIMARY KEY (id)
);
CREATE INDEX mdl_peoples_cert_ps_uid_ix ON mdl_peoples_cert_ps (userid);


CREATE TABLE mdl_peoples_income_category (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  datesubmitted BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  income_category BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
CONSTRAINT PRIMARY KEY (id)
);

income_category...
0 => Existing (all existing, pre swapover, students will be set as this); Also if record does not exist!
1 => LMIC (the default, set when they are registered)
2 => HIC (manually set in "Details" from applications.php)

CREATE INDEX mdl_peoples_income_category_uid_ix ON mdl_peoples_income_category (userid);


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

ALTER TABLE mdl_peoplesapplication MODIFY city VARCHAR(120) NOT NULL DEFAULT '';
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

$countryname = get_string_manager()->get_list_of_countries(false);

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/applications.php'); // Defined here to avoid notices on errors etc


require_once($CFG->dirroot .'/course/peoples_filters.php');

$peoples_filters = new peoples_filters();

$peoples_filters->set_page_url("$CFG->wwwroot/course/applications.php");

$semesters = $DB->get_records('semesters', NULL, 'id DESC');
foreach ($semesters as $semester) {
  $listsemester[] = $semester->semester;
  if (!isset($defaultsemester)) $defaultsemester = $semester->semester;
}
$listsemester[] = 'All';
$peoples_chosensemester_filter = new peoples_chosensemester_filter('Semester', 'chosensemester', $listsemester, $defaultsemester);
$peoples_filters->add_filter($peoples_chosensemester_filter);

$liststatus[] = 'All';
$liststatus[] = 'Not fully Approved';
$liststatus[] = 'Not fully Enrolled';
$liststatus[] = 'Part or Fully Approved';
$liststatus[] = 'Part or Fully Enrolled';
$peoples_chosenstatus_filter = new peoples_chosenstatus_filter('Status', 'chosenstatus', $liststatus, 'All');
$peoples_filters->add_filter($peoples_chosenstatus_filter);

$peoples_daterange_filter = new peoples_daterange_filter();
$peoples_filters->add_filter($peoples_daterange_filter);

$peoples_chosensearch_filter = new peoples_chosensearch_filter('Name or e-mail Contains', 'chosensearch');
$peoples_filters->add_filter($peoples_chosensearch_filter);

$peoples_chosenmodule_filter = new peoples_chosenmodule_filter('Module Name Contains', 'chosenmodule');
$peoples_filters->add_filter($peoples_chosenmodule_filter);

$listchosenpaidornot[] = 'Any';
$listchosenpaidornot[] = 'Yes';
$listchosenpaidornot[] = 'No';
$peoples_chosenpaidornot_filter = new peoples_chosenpaidornot_filter('Payment up to date?', 'chosenpaidornot', $listchosenpaidornot, 'Any');
$peoples_filters->add_filter($peoples_chosenpaidornot_filter);

$listchosenpay[] = 'Any';
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
$peoples_chosenpay_filter = new peoples_chosenpay_filter('Payment Method', 'chosenpay', $listchosenpay, 'Any');
$peoples_filters->add_filter($peoples_chosenpay_filter);

$listchosenreenrol[] = 'Any';
$listchosenreenrol[] = 'Re-enrolment';
$listchosenreenrol[] = 'New student';
$peoples_chosenreenrol_filter = new peoples_chosenreenrol_filter('Re&#8209;enrolment?', 'chosenreenrol', $listchosenreenrol, 'Any');
$peoples_filters->add_filter($peoples_chosenreenrol_filter);

$listchosenmmu[] = 'Any';
$listchosenmmu[] = 'Yes';
$listchosenmmu[] = 'No';
$peoples_chosenmmu_filter = new peoples_chosenmmu_filter('Applied MPH?', 'chosenmmu', $listchosenmmu, 'Any');
$peoples_filters->add_filter($peoples_chosenmmu_filter);

$listacceptedmmu[] = 'Any';
$listacceptedmmu[] = 'Yes';
$listacceptedmmu[] = 'No';
for ($year = 11; $year <= 17; $year++) {
  $listacceptedmmu[] = "Accepted {$year}a";
  $listacceptedmmu[] = "Accepted {$year}b";

  $stamp_range["Accepted {$year}a"]['start'] = gmmktime( 0, 0, 0,  1,  1, 2000 + $year);
  $stamp_range["Accepted {$year}a"]['end']   = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['start'] = gmmktime(24, 0, 0,  6, 30, 2000 + $year);
  $stamp_range["Accepted {$year}b"]['end']   = gmmktime(24, 0, 0, 12, 31, 2000 + $year);
}
$peoples_acceptedmmu_filter = new peoples_acceptedmmu_filter('Accepted MPH?', 'acceptedmmu', $listacceptedmmu, 'Any');
$peoples_acceptedmmu_filter->set_stamp_range($stamp_range);
$peoples_filters->add_filter($peoples_acceptedmmu_filter);

$listsuspendedmmu[] = 'Any';
$listsuspendedmmu[] = 'Suspended';
$listsuspendedmmu[] = 'Not Suspended';
$listsuspendedmmu[] = 'Graduated';
$listsuspendedmmu[] = 'Not Graduated';
$listsuspendedmmu[] = 'Not Graduated or Suspended';
$peoples_suspendedmmu_filter = new peoples_suspendedmmu_filter('Suspended MPH?', 'suspendedmmu', $listsuspendedmmu, 'Any');
$peoples_filters->add_filter($peoples_suspendedmmu_filter);

$peoples_notcurrentsemester_filter = new peoples_notcurrentsemester_filter('Not Applied Current Semester', 'notcurrentsemester');
$peoples_filters->add_filter($peoples_notcurrentsemester_filter);

$peoples_notprevioussemester_filter = new peoples_notprevioussemester_filter('Not Applied Previous Semester', 'notprevioussemester');
$peoples_filters->add_filter($peoples_notprevioussemester_filter);

$listchosenscholarship[] = 'Any';
$listchosenscholarship[] = 'Yes';
$listchosenscholarship[] = 'No';
$peoples_chosenscholarship_filter = new peoples_chosenscholarship_filter('Applied Scholarship?', 'chosenscholarship', $listchosenscholarship, 'Any');
$peoples_filters->add_filter($peoples_chosenscholarship_filter);

$listincome_category[] = 'Any';
$listincome_category[] = 'LMIC';
$listincome_category[] = 'HIC';
$listincome_category[] = 'Existing Student';
$peoples_income_category_filter = new peoples_income_category_filter('Income Category', 'income_category', $listincome_category, 'Any');
$peoples_filters->add_filter($peoples_income_category_filter);

$peoples_displayscholarship_filter = new peoples_boolean_filter('Show Scholarship Relevant Columns', 'displayscholarship');
$peoples_filters->add_filter($peoples_displayscholarship_filter);

$peoples_displayextra_filter = new peoples_boolean_filter('Show Extra Details', 'displayextra');
$peoples_filters->add_filter($peoples_displayextra_filter);

$peoples_displayforexcel_filter = new peoples_boolean_filter('Display Student History for Copying and Pasting to Excel', 'displayforexcel');
$peoples_filters->add_filter($peoples_displayforexcel_filter);

$peoples_displaystandardforexcel_filter = new peoples_boolean_filter('Display for Copying and Pasting to Excel', 'displaystandardforexcel');
$peoples_filters->add_filter($peoples_displaystandardforexcel_filter);

$displayscholarship = $peoples_displayscholarship_filter->get_filter_setting();
$displayextra       = $peoples_displayextra_filter->get_filter_setting();
$displayforexcel    = $peoples_displayforexcel_filter->get_filter_setting();
$displaystandardforexcel = $peoples_displaystandardforexcel_filter->get_filter_setting();


if (!empty($_POST['markfilter'])) {
  redirect($CFG->wwwroot . '/course/applications.php?' . $peoples_filters->get_url_parameters());
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

// Access to applications.php is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
//require_capability('moodle/site:config', context_system::instance());
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Student Applications');
$PAGE->set_heading('Student Applications');
echo $OUTPUT->header();

//echo html_writer::start_tag('div', array('class'=>'course-content'));


if (!$displayforexcel && !$displaystandardforexcel) echo "<h1>Student Applications</h1>";


if (!$displayforexcel && !$displaystandardforexcel) $peoples_filters->show_filters();


// Retrieve all relevent rows
//$applications = get_records_sql('SELECT a.sid AS appsid, a.* FROM mdl_peoplesapplication AS a WHERE hidden=0 ORDER BY datesubmitted DESC');
$applications = $DB->get_records_sql('
  SELECT DISTINCT a.sid AS appsid, a.*, n.id IS NOT NULL AS notepresent, m.id IS NOT NULL AS mph, m.mphstatus, m.datesubmitted AS mphdatestamp, IFNULL(ps.cert_psstatus, 0) AS cert_ps, ps.datesubmitted AS cert_psdatestamp, p.id IS NOT NULL AS paymentnote
  FROM mdl_peoplesapplication a
  LEFT JOIN mdl_peoplesstudentnotes n ON (a.sid=n.sid AND n.sid!=0) OR (a.userid=n.userid AND n.userid!=0)
  LEFT JOIN mdl_peoplesmph          m ON (a.sid=m.sid AND m.sid!=0) OR (a.userid=m.userid AND m.userid!=0)
  LEFT JOIN mdl_peoples_cert_ps    ps ON                                a.userid=ps.userid
  LEFT JOIN mdl_peoplespaymentnote  p ON (a.sid=p.sid AND p.sid!=0) OR (a.userid=p.userid AND p.userid!=0)
  WHERE hidden=0 ORDER BY a.datesubmitted DESC');
if (empty($applications)) {
  $applications = array();
}

$dissertations = $DB->get_records_sql('
  SELECT d.userid, GROUP_CONCAT(d.id ORDER BY d.id DESC) AS ids
  FROM mdl_peoplesdissertation d
  GROUP BY d.userid');
if (empty($dissertations)) {
  $dissertations = array();
}

$registrations = $DB->get_records_sql('SELECT DISTINCT r.userid AS userid_index, r.* FROM mdl_peoplesregistration r WHERE r.userid!=0');


$applications = $peoples_filters->filter_entries($applications);


// Look for all User Subscriptions to a 'Student Support Group' Forum in the 'Student Support Forums' Course which are for Students Enrolled in the Course (not Tutors)
$ssoforums = $DB->get_records_sql(
  "SELECT
    fs.userid,
    GROUP_CONCAT(SUBSTRING(f.name, 23) SEPARATOR ', ') AS names
  FROM
    mdl_forum f,
    mdl_forum_subscriptions fs
  WHERE
    f.course=? AND
    f.id=fs.forum AND
    SUBSTRING(f.name, 1, 21)='Student Support Group' AND
    fs.userid IN
      (
        SELECT ue.userid
        FROM mdl_user_enrolments ue
        JOIN mdl_enrol e ON (e.id=ue.enrolid AND e.courseid=?)
      )
   GROUP BY fs.userid",
  array(get_config(NULL, 'peoples_student_support_id'), get_config(NULL, 'peoples_student_support_id'))
);


$emaildups = 0;
foreach ($applications as $sid => $application) {
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
  sendemails($applications, strip_tags(dontstripslashes($_POST['emailsubject'])), strip_tags(dontstripslashes($_POST['emailbody'])), dontstripslashes($_POST['reg']), $_POST['notforuptodatepayments']);
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
    '',
    'SSO forum',
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
    'MPH?',
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
    'SSO forum',
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
    'Alternate module',
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
    '',
    'SSO forum',
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
Applying for MPH
applymmumph
Applying for Certificate in Patient Safety
applycertpatientsafety
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
$listofemails = array();
$gender = array();
$age = array();
$country = array();
$modulepaidup = array();
foreach ($applications as $sid => $application) {
  $state = (int)$application->state;
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

  $application->userid = (int)$application->userid;

  if (empty($registrations[$application->userid])) {
    $registration = NULL;
  }
  else {
    $registration = $registrations[$application->userid];
  }
  if (empty($application->userid) || empty($registration)) {
    $registration = new stdClass();
    $registration->whatlearn = '';
    $registration->whylearn = '';
    $registration->whyelearning = '';
    $registration->howuselearning = '';
    $registration->howfoundorganisationname = '';
    $registration->howfoundpeoples = '';
  }

  if (!$displayforexcel) {
    $rowdata = array();
    //echo '<tr>';
    //echo '<td>' . gmdate('d/m/Y H:i', $application->datesubmitted) . '</td>';
    if (!$displayscholarship) $rowdata[] = gmdate('d/m/Y H:i', $application->datesubmitted);
    //echo '<td>' . $sid . '</td>';
    $rowdata[] = $sid;

    if ($state === 0) $z = '<span style="color:red">No</span>';
    elseif ($state === 022) $z = '<span style="color:blue">Denied or Deferred</span>';
    elseif ($state1===02 || $state2===020) $z = '<span style="color:blue">Some</span>';
    else $z = '<span style="color:green">Yes</span>';
    $applymmumphtext = array(0 => '', 1 => '', 2 => '<br />(Apply MMU MPH)', 3 => '<br />(Say already MMU MPH)');
    $applymmumphtext[2] = '<br />(Apply MMU MPH)';
    $applymmumphtext[3] = '<br />(Say already MMU MPH)';
    $applymmumphtext[4] = '<br />(Apply Peoples-uni MPH)';
    $applymmumphtext[5] = '<br />(Say already Peoples-uni MPH)';
    $applymmumphtext[6] = '<br />(Apply OTHER MPH)';
    $applymmumphtext[7] = '<br />(Say already OTHER MPH)';
    $z .= $applymmumphtext[$application->applymmumph];
    $applycertpatientsafetytext = array(0 => '', 1 => '', 2 => '<br />(Apply Cert PS)', 3 => '<br />(Say already Cert PS)');
    $z .= $applycertpatientsafetytext[$application->applycertpatientsafety];
    if (!empty($dissertations[$application->userid])) {
      $ids = explode(',', $dissertations[$application->userid]->ids);
      foreach ($ids as $id) {
        if (!$displaystandardforexcel) $z .= '<br />(<a href="' . $CFG->wwwroot . '/course/dissertations.php?chosensemester=All&displayforexcel=0#' . $id . '" target="_blank">Dissertation</a>)';
      }
    }
    if ($displaystandardforexcel) $z = str_replace('<br />', ' ', $z);
    if (!$displayscholarship) $rowdata[] = $z;

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
    $amount_owed = 0;
    if (!empty($application->userid)) {
      $not_confirmed_text = '';
      if (is_not_confirmed($application->userid)) $not_confirmed_text = ' (not confirmed)';
      $amount = amount_to_pay($application->userid);
      $amount_owed = $amount;
      if ($amount >= .01) $z = '<span style="color:red">No: &pound;' . $amount . ' Owed now' . $not_confirmed_text . $mechanism . '</span>';
      elseif (abs($amount) < .01) $z = '<span style="color:green">Yes' . $not_confirmed_text . $mechanism . '</span>';
      else $z = '<span style="color:blue">' . "Overpaid: &pound;$amount" . $not_confirmed_text . $mechanism . '</span>'; // Will never be Overpaid here because of function used
    }
    else {
      $z = $mechanism;
    }
    if ($application->paymentnote) $z .= '<br />(Payment Note Present)';
    if ($displaystandardforexcel) $z = str_replace('<br />', ' ', $z);
    if (!$displayscholarship) $rowdata[] = $z;

    if (!($state1===03 || $state2===030)) $z = '<span style="color:red">No</span>';
    elseif ($state === 033) $z = '<span style="color:green">Yes</span>';
    else $z = '<span style="color:blue">Some</span>';

    if ($application->ready && $application->nid != 80) $z .= '<br />(Ready)';
    if ($application->notepresent) $z .= '<br />(Note Present)';
    if ($application->mph && ($application->mphstatus == 1)) $z .= '<br />(MMU MPH)';
    if ($application->mph && ($application->mphstatus == 2)) $z .= '<br />(Peoples MPH)';
    if ($application->mph && ($application->mphstatus == 3)) $z .= '<br />(OTHER MPH)';
    if ($application->cert_ps) $z .= '<br />(Cert PS)';
    if ($displaystandardforexcel) $z = str_replace('<br />', ' ', $z);
    if (!$displayscholarship) $rowdata[] = $z;

    if (!$displayextra || $displayscholarship) {
      $z  = '<form method="post" action="' .  $CFG->wwwroot . '/course/app.php" target="_blank">';

      $z .= '<input type="hidden" name="state" value="' . $state . '" />';
      $z .= '<input type="hidden" name="29" value="' . htmlspecialchars($application->userid, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="1" value="' . htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="2" value="' . htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="11" value="' . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="16" value="' . htmlspecialchars($application->semester, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="18" value="' . htmlspecialchars($application->coursename1, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="19" value="' . htmlspecialchars($application->coursename2, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="alternatecoursename" value="' . htmlspecialchars($application->alternatecoursename, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="dobday" value="' . $application->dobday . '" />';
      $z .= '<input type="hidden" name="dobmonth" value="' . $application->dobmonth . '" />';
      $z .= '<input type="hidden" name="dobyear" value="' . $application->dobyear . '" />';
      $z .= '<input type="hidden" name="12" value="' . htmlspecialchars($application->gender, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="14" value="' . htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="13" value="' . htmlspecialchars($application->country, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="34" value="' . htmlspecialchars($application->qualification, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="35" value="' . htmlspecialchars($application->higherqualification, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="36" value="' . htmlspecialchars($application->employment, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="31" value="' . htmlspecialchars($application->methodofpayment, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<input type="hidden" name="21" value="' . htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8') . '" />';
      $z .= '<span style="display: none;">';
      $z .= '<textarea name="3" rows="10" cols="100" wrap="hard" style="width:auto">'  . $application->applicationaddress . '</textarea>';
      $z .= '<textarea name="7" rows="10" cols="100" wrap="hard" style="width:auto">'  . $application->currentjob         . '</textarea>';
      $z .= '<textarea name="8" rows="10" cols="100" wrap="hard" style="width:auto">'  . $application->education          . '</textarea>';
      $z .= '<textarea name="10" rows="10" cols="100" wrap="hard" style="width:auto">' . $application->reasons            . '</textarea>';
      $z .= '<textarea name="sponsoringorganisation" rows="10" cols="100" wrap="hard" style="width:auto">' . $application->sponsoringorganisation . '</textarea>';
      $z .= '<textarea name="scholarship" rows="10" cols="100" wrap="hard" style="width:auto">' . $application->scholarship . '</textarea>';
      $z .= '<textarea name="whynotcomplete" rows="10" cols="100" wrap="hard" style="width:auto">' . $application->whynotcomplete . '</textarea>';
      $z .= '<textarea name="32" rows="10" cols="100" wrap="hard" style="width:auto">' . htmlspecialchars($application->paymentidentification, ENT_COMPAT, 'UTF-8') . '</textarea>';
      $z .= '</span>';
      $z .= '<input type="hidden" name="applymmumph" value="' . $application->applymmumph . '" />';
      $z .= '<input type="hidden" name="sid" value="' . $sid . '" />';
      $z .= '<input type="hidden" name="nid" value="' . $application->nid . '" />';
      $z .= '<input type="hidden" name="sesskey" value="' . $USER->sesskey . '" />';
      $z .= '<input type="hidden" name="markapp" value="1" />';
      $z .= '<input type="submit" name="approveapplication" value="Details" />';

      $z .= '</form>';
      if ($displaystandardforexcel) $z = '';
      if ($application->reenrolment) $z .= 'Re&#8209;enrolment';
      $rowdata[] = $z;
    }

    $rowdata[] = htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8');

    $rowdata[] = htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8');

    if ($emailcounts[$application->email] === 1) {
      $z = htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
    }
    else {
      $z = '<span style="color:navy">**</span>' . htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
    }
    if (!$displayscholarship) $rowdata[] = $z;

    if (!$displayscholarship) $rowdata[] = htmlspecialchars($application->semester, ENT_COMPAT, 'UTF-8');

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
    if (!$displayscholarship) $rowdata[] = $z . htmlspecialchars($application->coursename1, ENT_COMPAT, 'UTF-8') . '</span>';

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
    if (!$displayscholarship) $rowdata[] = $z . htmlspecialchars($application->coursename2, ENT_COMPAT, 'UTF-8') . '</span>';

    if (!$displayscholarship && $displayextra) $rowdata[] = htmlspecialchars($application->alternatecoursename, ENT_COMPAT, 'UTF-8');

    if (!$displayscholarship) $rowdata[] = $application->dobday . '/' . $application->dobmonth . '/' . $application->dobyear;

    if (!$displayscholarship) $rowdata[] = $application->gender;

    if (!$displayscholarship) $rowdata[] = htmlspecialchars($application->city, ENT_COMPAT, 'UTF-8');

    if (empty($countryname[$application->country])) $z = '';
    else $z = $countryname[$application->country];
    $rowdata[] = $z;

    if ($displayscholarship) {
      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->scholarship));

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->reasons));

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
    }
    elseif ($displayextra) {
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

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->sponsoringorganisation));

      if (empty($howfoundpeoplesname[$registration->howfoundpeoples])) $z = '';
      else $z = $howfoundpeoplesname[$registration->howfoundpeoples];
      $rowdata[] = $z;

      $rowdata[] = $registration->howfoundorganisationname;

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->scholarship));

      $rowdata[] = str_replace("\r", '', str_replace("\n", '<br />', $application->whynotcomplete));

      $rowdata[] = htmlspecialchars($application->username, ENT_COMPAT, 'UTF-8');

      if (empty($application->userid)) $z = '';
      else $z = $application->userid;
      $rowdata[] = $z;
    }

    if (empty($application->userid)) $z = '';
    else $z = '<a href="' . $CFG->wwwroot . '/course/student.php?id=' . $application->userid . '" target="_blank">Student Grades</a>';
    if ($displaystandardforexcel) $z = '';
    if (!$displayscholarship) $rowdata[] = $z;

    if (empty($application->userid)) $z = '';
    else $z = '<a href="' . $CFG->wwwroot . '/course/studentsubmissions.php?id=' . $application->userid . '" target="_blank">Student Submissions</a>';
    if ($displaystandardforexcel) $z = '';
    if (!$displayscholarship) $rowdata[] = $z;

    if (!empty($ssoforums[$application->userid])) {
      $z = $ssoforums[$application->userid]->names;
    }
    else {
      $z = '';
    }
    if (!$displayscholarship) $rowdata[] = $z;

    if (empty($modules[$application->coursename1])) {
      $modules[$application->coursename1] = 1;
    }
    else {
      $modules[$application->coursename1]++;
    }
    if (!empty($application->coursename2)) {
      if (empty($modules[$application->coursename2])) {
        $modules[$application->coursename2] = 1;
      }
      else {
        $modules[$application->coursename2]++;
      }
    }

    $n++;

    if ($state1===01 || $state1===03 || $state2===010 || $state2===030) {
      $napproved++;

      // Is Module 1 Approved/Enrolled
      if ($state1===01 || $state1===03) {
        if (empty($moduleapprovals[$application->coursename1])) {
          $moduleapprovals[$application->coursename1] = 1;
        }
        else {
          $moduleapprovals[$application->coursename1]++;
        }
      }

      // Is Module 2 Approved/Enrolled
      if ($state2===010 || $state2===030) {
        if (!empty($application->coursename2)) {
          if (empty($moduleapprovals[$application->coursename2])) {
            $moduleapprovals[$application->coursename2] = 1;
          }
          else {
            $moduleapprovals[$application->coursename2]++;
          }
        }
      }

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

      $listofemails[]  = htmlspecialchars($application->email, ENT_COMPAT, 'UTF-8');
    }
    if ($state1===03 || $state2===030) {
      $nenrolled++;

      // Is Module 1 Enrolled
      if ($state1 === 03) {
        if (empty($moduleregistrations[$application->coursename1])) {
          $moduleregistrations[$application->coursename1] = 1;
        }
        else {
          $moduleregistrations[$application->coursename1]++;
        }
      }

      // Is Module 2 Enrolled
      if ($state2 === 030) {
        if (!empty($application->coursename2)) {
          if (empty($moduleregistrations[$application->coursename2])) {
            $moduleregistrations[$application->coursename2] = 1;
          }
          else {
            $moduleregistrations[$application->coursename2]++;
          }
        }
      }
    }

    if ($amount_owed < .01) {
      // Count Module 1 Paid up
      if (empty($modulepaidup[$application->coursename1])) {
        $modulepaidup[$application->coursename1] = 1;
      }
      else {
        $modulepaidup[$application->coursename1]++;
      }

      // Count Module 2 Paid up
      if (!empty($application->coursename2)) {
        if (empty($modulepaidup[$application->coursename2])) {
          $modulepaidup[$application->coursename2] = 1;
        }
        else {
          $modulepaidup[$application->coursename2]++;
        }
      }
    }

    $table->data[] = $rowdata;
  }
  else {
    $rowdata = array();

    $rowdata[] = htmlspecialchars($application->lastname, ENT_COMPAT, 'UTF-8');

    $rowdata[] = htmlspecialchars($application->firstname, ENT_COMPAT, 'UTF-8');

    if (empty($countryname[$application->country])) $z = '';
    else $z = $countryname[$application->country];
    $rowdata[] = $z;

    if     ($application->mph && ($application->mphstatus == 1)) $z = 'MMU MPH';
    elseif ($application->mph && ($application->mphstatus == 2)) $z = 'Peoples MPH';
    elseif ($application->mph && ($application->mphstatus == 3)) $z = 'OTHER MPH';
    else $z = '';
    $rowdata[] = $z;

    $rowdata[] = '';

    if (empty($employmentname[$application->employment])) $z = '';
    else $z = $employmentname[$application->employment];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $application->currentjob));

    if (empty($qualificationname[$application->qualification])) $z = '';
    else $z = $qualificationname[$application->qualification];
    $rowdata[] = $z;

    if (empty($higherqualificationname[$application->higherqualification])) $z = '';
    else $z = $higherqualificationname[$application->higherqualification];
    $rowdata[] = $z;

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $application->education));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $application->reasons));

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

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $application->sponsoringorganisation));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $application->scholarship));

    $rowdata[] = str_replace("\r", '', str_replace("\n", ' ', $application->whynotcomplete));

    if (!empty($ssoforums[$application->userid])) {
      $z = $ssoforums[$application->userid]->names;
    }
    else {
      $z = '';
    }
    $rowdata[] = $z;

    $table->data[] = $rowdata;
  }
}
echo html_writer::table($table);

if ($displayforexcel || $displaystandardforexcel) {
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
echo "<td>Number Fully Paid (or New Student)</td>";
echo "</tr>";

ksort($modules);

$n = 0;

foreach ($modules as $product => $number) {
  echo "<tr>";
  echo "<td>" . $product . "</td>";
  echo "<td>" . $number . "</td>";
  if (empty($moduleapprovals[$product])) { echo "<td>0</td>";} else {   echo "<td>" . $moduleapprovals[$product] . "</td>";}
  if (empty($moduleregistrations[$product])) { echo "<td>0</td>";} else { echo "<td>" . $moduleregistrations[$product] . "</td>";}
  if (empty($modulepaidup[$product])) { echo "<td>0</td>";} else { echo "<td>" . $modulepaidup[$product] . "</td>";}
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
    echo $CFG->wwwroot . '/course/applications.php?' . $peoples_filters->get_url_parameters();
  }
  else {
    echo $CFG->wwwroot . '/course/applications.php';
  }
?>">
Subject:&nbsp;<input type="text" size="75" name="emailsubject" /><br />
<textarea name="emailbody" rows="15" cols="75" wrap="hard" style="width:auto">
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


function sendemails($applications, $emailsubject, $emailbody, $reg, $notforuptodatepayments) {

  echo '<br />';
  $i = 1;
  foreach ($applications as $sid => $application) {

    $email = trim($application->email);

    if (!preg_match($reg, $email)) {
      echo "&nbsp;&nbsp;&nbsp;&nbsp;($email skipped because of regular expression.)<br />";
      continue;
    }

    $emailbodytemp = str_replace('GIVEN_NAME_HERE', trim($application->firstname), $emailbody);
    $emailbodytemp = str_replace('SID_HERE', $sid, $emailbodytemp);

    if (!empty($application->userid)) $amount = amount_to_pay($application->userid);
    else $amount = 0;
    $emailbodytemp = str_replace('AMOUNT_TO_PAY_HERE', $amount, $emailbodytemp);

    $emailbodytemp = preg_replace('#(http://[^\s]+)[\s]+#', "$1\n\n", $emailbodytemp); // Make sure every URL is followed by 2 newlines, some mail readers seem to concatenate following stuff to the URL if this is not done
                                                                                       // Maybe they would behave better if Moodle/we used CRLF (but we currently do not)

    if (empty($notforuptodatepayments) || $amount >= .01) {
      if (sendapprovedmail_from_payments($email, $emailsubject, $emailbodytemp)) {
        echo "($i) $email successfully sent.<br />";
      }
      else {
        echo "FAILURE TO SEND $email !!!<br />";
      }
      $i++;
    }
  }
}
?>
