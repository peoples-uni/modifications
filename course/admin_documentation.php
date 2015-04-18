<?php  // $Id: admin_documentation.php,v 1.1 2009/11/07 17:21:00 alanbarrett Exp $
/**
*
* Administration Documentation for Peoples-uni
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/admin_documentation.php');
$PAGE->set_pagelayout('standard');


require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
$islurker = has_capability('moodle/course:view', context_system::instance());
if (!$isteacher && !$islurker) {
  $SESSION->wantsurl = "$CFG->wwwroot/course/admin_documentation.php";
  notice('<br /><br /><b>You must be a Tutor to do this! Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}

$PAGE->set_title('Administration Documentation for Peoples-uni');
$PAGE->set_heading('Administration Documentation for Peoples-uni');
echo $OUTPUT->header();


?>
<h1>Applications, Approving, Payments, Enrolling, Grading and Certificates</h1>

<ul>
<b>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#configurationreg">Configuration of Registrations Process</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#dealingwithregistrations">Dealing with Registrations</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#theregdetailsbutton">The "Details" button and the Registration Process</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#configuration">Configuration of Applications Process for a new Semester</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#dealingwithapplications">Dealing with Applications</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#thedetailsbutton">The "Details" button and the Approval Process</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#closing">Closing Applications for a Semester</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#tutorregistration">Registering Tutors in Moodle</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#misc">Misc: Enrolling Tutors in Tutors Corner, Giving Tutors the Sitewide Moodle Role "View Full User Profiles", Making a Donation</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#tracksubmissions">Tracking Student Assignment Submissions</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#trackmarking">Collaborative Assignment Marking and Resubmission Tracking</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#tracking">Viewing Student Submissions & Re-Submissions, Grades & Comments, Student Posts, Tutor Posts and Student Support Forum Posts</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#studentenrolments">Student Enrolments and Grades</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#informing">Informing Students of Semester Final Grade Results</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#progress">Student Progress towards Qualifications</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#education_committee_report">Education Committee Report</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#statistics">Statistics on Success of Students by Qualifications on Entry</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#creatingcertificates">Creating Certificates for Peoples-uni Volunteers</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#studentaccount">Page to allow a Student to see their Payment Account</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#specifyinstalments">Specify Instalment Payment Schedule</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#sendingdiscussion">Sending Discussion Feedback to Students</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#cleanstudentcornersubscriptions">Cleaning out old Discussion Forum Subscriptions in Students Corner</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#resetstudentcornersubscriptions">Determining if Student Support Forum Subscriptions in Students Corner have changed and Changing Back</a><br /><br />
</li>
</b>
</ul>


<a name="configurationreg"></a>
<h2>Configuration of Registrations Process</h2>
<ol>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> enter the Last Allowed Date for Applications (which is displayed on application forms but also as an approximate guideline on registration forms) and click "Set Last Allowed Date (display only, not enforced) for Applications to:".
<br />This setting needs to be kept up to date. When applications are closed for a semester, it needs to be set to refer to the next semester.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> select the Foundations of Public Health demonstration module that will be used for student registrations and then click "Make this Module the Foundations of Public Health Module for new Student Registrants:" (no need to do this if it has not changed).
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> select the Students Corner module that will be used for student registrations and then click "Make this Module the Students Corner for new Student Registrants:" (no need to do this if it has not changed).
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> select the Student Support Forums module that will be used for student registrations and then click "Make this Module the Student Support Forums Module for new Student Registrants:" (no need to do this if it has not changed).
</li>
<li>
The above three settings will, from 2014a on, normally point to the same module, this is not a problem.
</li>
<li>
Note that the names of forums used for Student Support by the Student Support Officers must all start with text exactly the same as this "Student Support Group" (can be followed by anything else desired). This is because this text is used to limit the forums selectable in various filters.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> select the Student Support Forum that will be used for student registrations and then click "Make this Forum the Student Support Forum for new Student Registrants:"
<br />Normally 50 students are assigned to each Student Support Forum. When a forum is full, a new one will need to be manually created and an SSO assigned. This setting then needs to be changed so that newly registered students will be assigned to this new forum as part of the automatic process of registering new students.
<br />The current practice is wait for 50 students to be waiting to be registered before registering all 50 at once. To help with this, a count of those students not registered (disregarding duplicate e-mails and e-mails already in Moodle) is displayed in <a href="http://courses.peoples-uni.org/course/registrations.php" target="_blank">http://courses.peoples-uni.org/course/registrations.php</a>.
<br />This may overestimate the number waiting because of historical registrations what were bypassed.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the Auto Acknowledgement e-mail wording for the Registration Form and then click "Set the above text as the Auto Acknowledgement e-mail wording for the Registration Form (form also echoed)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

Welcome to Peoples-uni. At a later date you will be invited to take
part in our 'Preparing to Study' course.

We have found in the past that those students who fully understand
what they are letting themselves in for, do much better in the
courses than some who are new to our e-learning platform.

'Preparing to Study' involves refreshing your academic skills
by taking part in online discussions with your student support group.
Student support groups begin in July/August and January/February.
You will be sent an email with the exact starting date 2 weeks in
advance, and a separate email with your username and password.

In preparation for this you can do the following:

1. Read the Are you Ready materials on the website and check that
you are prepared to study:
http://www.peoples-uni.org/content/are-you-ready-peoples-uni

2. Think about your study plan and when you will study -
You will need to make sure you can log on and read the discussions a
minimum of once per week, but to get the best out of the forums we
expect you to read and respond to others forum posts every few days.

3. *Read the student handbook*:
http://www.peoples-uni.org/content/student-handbook

4. You may want to complete our open access Foundations in Public
Health module (not obligatory) - you can access this online at:
http://courses.peoples-uni.org/course/view.php?id=308

There are lots of resources for you to read, which will help you
learn key public health terms. This module is self directed learning
and there are no tutor led discussions.

The course enrolment window opens twice every year -
March and August, and this is when you select the module(s) you
wish to enrol in for the current semester.
You will be reminded when the course enrolment window is open.

If you have technical problems please email apply@peoples-uni.org
for assistance.

Peoples Open Access Education Initiative Administrator.

Check out our Peoples-uni Facebook
www.facebook.com/peoples-uni
, twitter (@Peoplesuni) and LinkedIn pages
https://www.linkedin.com/company/people%27s-open-access-initiative
to follow our students and tutors learning journeys.
</pre>
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the default Registration e-mail wording and then click "Set the above text as the Register Student e-mail wording (in Registration Details/reg.php)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

Welcome to Peoples-uni. You have been enrolled in pre-registration
system for Peoples-uni courses.

We have found in the past that those students who fully understand
what they are letting themselves in for, do much better in the
courses than some who are new to our e-learning platform.

Since there are more people interested in taking our courses than we
have places available, we have developed this pre-registration system
which is a requirement for enrollment in Peoples-uni courses.
To take part in the pre-registration process you will be sent a separate
email with your username and password -
once you have these, you need to do these 4 things:

1. Show your commitment to studying, help develop a learning plan and
practice your academic skills *by taking part in discussions in your
student support group.*  You will be sent an introductory email to the
student support forum within 2 weeks of receiving this email.  The
discussions will take place on-line, for approximately 4-6 weeks.
You will need to make sure you can log on and read the discussions at
a minimum once per week, but to get the best out of the forums we
expect you to read and respond to others forum posts every few days.
This will help you to prepare yourself for  studying at masters level, by
considering your IT skills, your time  commitments, and your academic
skills (eg searching the internet, referencing journals etc)
Your student support forum, of which the introductory email will
explain more, is here:
http://courses.peoples-uni.org/mod/forum/view.php?f=FORUM_HERE

2.*Read the student handbook*:
http://www.peoples-uni.org/content/student-handbook
As you read you will learn how to do the following tasks:

*Upload a picture of yourself
*Create your own profile - Your profile will give other students and
tutors a brief summary of your interests, your background and your
work.
*Read other student/tutor bios

3. Look at the study resources on Students corner. You may also want
to look at the student2student discussion forums where students can
chat and share experiences:
http://courses.peoples-uni.org/course/view.php?id=SC_ID_HERE

4. You may want to complete our open access Foundations in Public
Health module (not obligatory) - you can access this online at
http://courses.peoples-uni.org/course/view.php?id=308
There are lots of resources for you to read, which will help you learn
key public health terms. This module is self directed learning and there
are no tutor led discussions.

Note:
Successfully completing the pre-registration requirements is a
pre-requisite to course enrollment. The course enrollment window
opens twice every year - March and August, and this is when you
select the course(s) you wish to enroll in for the current semester.
You will be reminded when the course enrollment window is open.

If you have technical problems please email apply@peoples-uni.org for
assistance.

Peoples Open Access Education Initiative Administrator.
</pre>
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the default batch reminder e-mail wording and then click "Set above text as Batch Reminder e-mail wording (in registrations.php spreadsheet)". Here is an (unfinished) sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

Thank you for registering with peoples-uni...

We look forward to seeing you on the course soon.

     Peoples Open Access Education Initiative Administrator
</pre>
</li>
<li>
Note there are two Drupal menu items which now are left permanently enabled and are used for new Registrations and for Course Applications respectively: "Registration form for new students" and "Course Application Form" (<a href="http://courses.peoples-uni.org/course/registration.php" target="_blank">http://courses.peoples-uni.org/course/registration.php</a> & <a href="http://courses.peoples-uni.org/course/application_form_student.php" target="_blank">http://courses.peoples-uni.org/course/application_form_student.php</a>).<br />
Note also, that if applications are closed the second of these will indicate this along with approximate dates when Applications will open (from "Last Allowed Date" setting above).
</li>
</ol>


<a name="dealingwithregistrations"></a>
<h2>Dealing with Registrations</h2>
<ol>
<li>
Go to <a href="http://courses.peoples-uni.org/course/registrations.php" target="_blank">http://courses.peoples-uni.org/course/registrations.php</a>. You can see a list of potential and existing registrants.
</li>
<li>
It is possible to filter the registrations by registration status, by date and by name or email. When you have selected your desired filters you should then click "Apply Filters". You may also "Reset Filters" to remove them.
</li>
<li>
It is also possible to display all the registration data for each student in extra columns by clicking "Show Extra Details" and then "Apply Filters".
</li>
<li>
For each student registration application, data about the student is displayed in a row of the "spreadsheet".
</li>
<li>
"Registered?" indicates whether the student has been registered (using the "Details" page) in Moodle.
</li>
<li>
"Details" will be described later.
</li>
<li>
Statistics are displayed at the end of the page.
</li>
<li>
E-mails of all the students in the spreadsheet (i.e. after any filters have been applied) are listed at the end of the page so that e-mails can be manually sent to a large group of applicants.
</li>
<li>
It is also possible to programmatically send a reminder or other e-mail to all of the students in the spreadsheet (i.e. after any filters have been applied) by using the form at the end of the page (instuctions for the form are given there).
</li>
<li>
Access to <a href="http://courses.peoples-uni.org/course/registrations.php" target="_blank">http://courses.peoples-uni.org/course/registrations.php</a> and the Details for each student are given by the System-wide "Manager" or "Administrator" roles. Both have the permission: moodle/site:viewparticipants.
</li>
<li>
At a later stage, when students edit their own profile (e.g. their names, e-mail or address) or when an administrator edits a student profile (e.g. date of birth), the registrations.php data (or for that matter the applications.php data to be described later) will be out of date and will not reflect the updated data in Moodle.<br />
To bring both registrations.php and applications.php up to date with the Moodle student profiles click on/visit <a href="http://courses.peoples-uni.org/course/copy_moodle_student_data_to_registrations_applications.php" target="_blank">http://courses.peoples-uni.org/course/copy_moodle_student_data_to_registrations_applications.php</a><br />
This will copy over all the student profile data from Moodle (but not for any deleted accounts) and give an indication of how many student profiles were processed.
<br />
Access to this function is only available to the "Administrator" role.
</li>
</ol>


<a name="theregdetailsbutton"></a>
<h2>The "Details" button and the Registration Process</h2>
<ol>
<li>
When the "Details" button is pressed for an registration application, additional applicant data is displayed beyond what is in the "spreadsheet" row.
</li>
"Register Student" is a button which allows the registration application to be approved. The user is sent the e-mail outlined above under <a href="#configurationreg">"Configuration of Registrations Process"</a>.<br />
The "Registered?" entry in <a href="http://courses.peoples-uni.org/course/registrations.php" target="_blank">http://courses.peoples-uni.org/course/registrations.php</a> and "Details" will indicate "Yes" as opposed to "No".<br />
The following e-mail will ALSO be sent from techsupport@peoples-uni.org:<br />
<pre>
Hi FULL_NAME_HERE,

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
TECHSUPPORT_EMAIL_HERE
</pre>
</li>
<li>
"e-mail Applicant" allows an e-mail to be sent to the Applicant, the e-mail to be sent can be edited. the e-mail will come from apply@peoples-uni.org as does the registration approval e-mail. Note these e-mails are copied to the e-mail address applicationresponses@peoples-uni.org.
</li>
<li>
"Corresponding Registered Moodle Username:" shows details for the Moodle user matching the application (if this Student has already been registered on this Details page).
</li>
<li>
"Users course's" shows the existing courses for the above user.
</li>
<li>
"Update Username" is a button that allows the Applicant's suggested user name to be changed (because it conflicts with an existing Moodle username).
</li>
<li>
"Change Applicant e-mail to:" allows the applicant's e-mail to be changed. (Will not be displayed if the applicant has already been registered in Moodle.)
</li>
<li>
"Allow this Student to make a Late Course Application (choose how long...)" allows the Student to make a late application for courses. The deadline can be specified. The deadline is always set to 3:00 am GMT early in the morning of the day after the day specified.<br />
It will only be possible to set a late application deadline if the Student is already registered (and therefore has a Moodle account) as they have to login to get the benefit of the late registration (so we know who they are).<br />
In particular they should be told to go to this URL <a href="http://courses.peoples-uni.org/course/apply.php" target="_blank">http://courses.peoples-uni.org/course/apply.php</a> in order to make a late application as this will force them to login first.<br />
The student will be able to apply for any course module that has been specified in settings.php. If they apply for courses that we do not wish them to apply for, we can change them to suitable modules in the applications.php "Details" page.
</li>
<li>
"Close Window" closes this window (note the original registrations.php spreadsheet will still be there).
</li>
<li>
"Hide this Application Form Entry from All Future Processing" button does what it says.
</li>
<li>
Note that the registrations.php spreadsheet is refreshed with any changes that have been made in this details page.
</li>
</ol>


<a name="configuration"></a>
<h2>Configuration of Applications Process for a new Semester</h2>
<ol>
<li>
Existing modules must be left in place with their names and 'Course ID number' UNCHANGED.
</li>
<li>
New Moodle modules must be created with new names different from the old course names (typically with 10a or similar appended to the base name).
</li>
<li>
The 'Course ID number'(Course Code) for the new modules must have the EXACT SAME (including case) base part as the equivalent courses from previous semesters but with the last 3 characters changed to reflect the semester e.g. "PUHECO09b" would change to something like "PUHECO10a". (Note Course ID number is different from the Course 'Short name' which must also be unique.)<br />
If the course is in a different language (such as French) you should add an additional code to the 'Course ID number', [F] for French, [S] for Spanish etc. So examples would be "PUPHC10a[F]" or "PUPHC10a[S]".
</li>
<li>
<a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> lists (the base part of) all valid Peoples-uni agreed Course Codes (Course ID numbers) for "Foundation Sciences" and "Public Health Problems".<br />
If new modules are added for which there was no equivalent for previous semesters then <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> indicates if there is a module without a 'Course ID number'(Course Code) and requests that you fix that.<br />
Or if the 'Course ID number'(Course Code) does not match a Peoples-uni agreed Course Code it indicates that you should either assign a suitable one or allows you to enter a new Peoples-uni agreed Course Code (base part only) in either the "Foundation Sciences" or "Public Health Problems" groupings.<br />
These groupings are used for Diploma awarding purposes.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> "Check to completely Remove from Forms" should be set for all the old courses from the previous semester and "Mark Modules as Full or to be Removed based on Check Boxes Above" clicked.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> enter a New Semester name like "Starting September 2009" and click "Set Current Semester to:".
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> enter the Last Allowed Date for Applications (which is displayed on application forms but also as an approximate guideline on registration forms) and click "Set Last Allowed Date (display only, not enforced) for Applications to:".
<br />This setting needs to be kept up to date. When applications are closed for a semester, it needs to be set to refer to the next semester.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> each new module has to be individually added by selecting the new module from the selection list (making sure it is the correct version of the module for the new semester). This selection is beside the "Add this Module to above Active Module list for Applications:" button. When an individual module is selected then click "Add this Module to above Active Module list for Applications:", repeat this until the full set of modules for the new semester is listed.<br />
NOTE: once any module is added (which is not then immediately marked as full... see <a href="http://courses.peoples-uni.org/course/admin_documentation.php#closing">Closing Applications for a Semester</a>), application forms will be opened for students!
</li>
<li>
You can confirm that the application form has changed by looking at it (<a href="http://courses.peoples-uni.org/course/application_form_student.php" target="_blank">http://courses.peoples-uni.org/course/application_form_student.php</a>). You will see the list of modules has changed.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the wording to be included at the top of the Acknowledgement e-mail sent upon Course Application form Submission by the student. This should have the correct dates. Then click "Set the text to be included at top of Acknowledgement e-mail sent upon Course Application form Submission". Here is a sample of previous wording...
<br /><pre>
Thank you for your application.

If you are a returning student, then please make sure you have paid your course
fees for the previous semester.
There is no guarantee that you will be enrolled if you have outstanding
payments, or if you do not have an agreed payment plan.

We will confirm your enrolment in the module(s) by March 7th.
Orientation week begins on March 16th.
</pre>
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the default Approval e-mail wording for dates and banking and then click "Set the above text as the Students Approval e-mail wording (in Application Details/app.php)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

Your application to take the Course Module
'COURSE_MODULE_1_NAME_HERE'
COURSE_MODULE_2_TEXT_HEREhas been approved.
COURSE_MODULE_2_WARNING_TEXT_HERE

You will receive a welcome email for each course module giving
the course module URL and the URL for your profile.
We will send you all these details on the first day of the course
orientation week September 17th 2012.

Please see the course timetable at:
http://www.peoples-uni.org/book/course-dates

*** Payment will be required unless you have been approved for a bursary.
If you can do this before enrolment on 17th of September, it would be
preferable, otherwise since time is tight you can do this once the
semester has started.

Your fees are £AMOUNT_TO_PAY_HERE sterling for this semester.

There are a number of ways you can pay.

WITH A CREDIT CARD... You can pay via the secure online
payment system RBS WorldPay. Please click on the following URL:
http://courses.peoples-uni.org/course/pay.php?sid=SID_HERE

and follow instructions (Everything happens automatically,
there is no need to tell us about your payment).

BY BANK TRANSFER (UK or Nigeria)...

DIRECT TO THE UK in Pounds Sterling
BANK NAME: Barclays
Branch: Barclays Bank, Manchester City, PO Box 357, 51 Mosley Street,
Manchester UK.
Account name: Peoples Open Access Education Initiative
Account number: 93777308
Sort code: 20-55-34
SWIFT: BARCGB22
IBAN: GB82 BARC 2055 3493 7773 08
Please be sure to quote this number SID_HERE as a reference in
addition to giving your name on the lodgement docket.
When you have made the Bank Transfer you must then click on this
web site (URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.

IN NIGERIA in local currency, Naira
Please pay N9,000 for one course module or N18,000 for two into:
BANK NAME: Ecobank Nigeria PLC.
Branch: Wuse II, Abuja
Account name: Datasphir Solutions Limited
Account number: 0122270018
Please be sure to quote this number SID_HERE as a reference in
addition to giving your name on the lodgement docket.
When you have made the Bank Transfer you must then click on this web site (URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.

Note for others in Africa: Anyone from the country list at
http://ecobank.com/yourcountry.aspx
can pay in their local currency.  Go to your local Ecobank branch and
ask to pay the cost of their module/s in Naira to the Peoples-uni
account in Nigeria.
The banks internal processes takes care of the exchange.

AN ALTERNATIVE WAY, you can use MoneyGram to send money
directly.
Please give the receiver's name as:
Professor Rajan Madhok,
People's Open Access Education Initiative,
Manchester UK.

If you do use this method, please let us know through
payments@peoples-uni.org and send us the payment reference
number, your first and middle name, and surname or family name.
These should be of the sender, if not sent by you.

You can look at your payment account balance and all transactions
at any time when logged in at this URL:
http://courses.peoples-uni.org/course/account.php

NOTE_ON_INSTALMENTS_HERE

We look forward to your participation this semester, and hope that
you enjoy the experience and find it useful.

    Peoples Open Access Education Initiative Administrator.
</pre>
</li>
<li>
Similarly in <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the default Approval e-mail wording (for BURSARY Students) for dates and then click "Set the above text as the Students Approval e-mail wording with BURSARY (in Application Details/app.php)".
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the default batch reminder e-mail wording for dates and banking and then click "Set above text as Batch Reminder e-mail wording (in applications.php spreadsheet)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

We contacted you earlier indicating that your application for this
semester had been approved and giving payment options.

We have so far not received any indication of payment from you.
If you have only recently paid we may not have a record of that yet.
However, if you have not paid, we would like to remind you and ask
you to process the payment - please send a message to
payments@peoples-uni.org and tell us if there is a problem.

Your fees are £AMOUNT_TO_PAY_HERE sterling for this semester.

Here is a reminder of the payment methods.

WITH A CREDIT CARD... You can pay via the secure online
payment system RBS WorldPay. Please click on the following URL:
http://courses.peoples-uni.org/course/pay.php?sid=SID_HERE

and follow instructions (Everything happens automatically,
there is no need to tell us about your payment).

BY BANK TRANSFER (UK or Nigeria)...

DIRECT TO THE UK in Pounds Sterling
BANK NAME: Barclays
Branch: Barclays Bank, Manchester City, PO Box 357, 51 Mosley Street,
Manchester UK.
Account name: Peoples Open Access Education Initiative
Account number: 93777308
Sort code: 20-55-34
SWIFT: BARCGB22
IBAN: GB82 BARC 2055 3493 7773 08
Please be sure to quote this number SID_HERE as a reference in
addition to giving your name on the lodgement docket.
When you have made the Bank Transfer you must then click on this
web site (URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.

IN NIGERIA in local currency, Naira
Please pay N9,000 for one course module or N18,000 for two into:
BANK NAME: Ecobank Nigeria PLC.
Branch: Wuse II, Abuja
Account name: Datasphir Solutions Limited
Account number: 0122270018
Please be sure to quote this number SID_HERE as a reference in
addition to giving your name on the lodgement docket.
When you have made the Bank Transfer you must then click on this
web site (URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.
Note for others in Africa: Anyone from the country list at
http://ecobank.com/yourcountry.aspx
can pay in their local currency.  Go to your local Ecobank branch and
ask to pay the cost of their module/s in Naira to the Peoples-uni
account in Nigeria.
The banks internal processes takes care of the exchange.

AN ALTERNATIVE WAY, you can use MoneyGram to send money
directly.
Please give the receiver's name as:
Professor Rajan Madhok,
People's Open Access Education Initiative,
Manchester UK.

If you do use this method, please let us know through
payments@peoples-uni.org and send us the payment reference
number, your first and middle name, and surname or family name.
These should be of the sender, if not sent by you.

We hope that you are enjoying the course this semester.

    Peoples Open Access Education Initiative Administrator.
</pre>
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> you may want to edit the default batch e-mail to enrolled students wording (although it probably will not need to be changed) and then click "Set above text as wording for Batch e-mail to enrolled students (in coursegrades.php)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

Here is a reminder of you Application ID (called SID).

Your SID is: SID_HERE

This is used both for payment purposes and also to present anonymous data to you.

    Peoples Open Access Education Initiative Administrator.
</pre>
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> you may want to edit the default batch e-mail to enrolled students wording and then click "Set above text as wording for the Batch e-mail to Not Logged on students (in coursegrades.php)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

This is a reminder that you have not logged on to Peoples-uni
since the start of the Semester.

You can login at http://courses.peoples-uni.org/login/index.php

     Peoples Open Access Education Initiative Administrator.</pre>
</li>
<li>
Note there are two Drupal menu items which now are left permanently enabled and are used for new Registrations and for Course Applications respectively: "Registration form for new students" and "Course Application Form" (<a href="http://courses.peoples-uni.org/course/registration.php" target="_blank">http://courses.peoples-uni.org/course/registration.php</a> & <a href="http://courses.peoples-uni.org/course/application_form_student.php" target="_blank">http://courses.peoples-uni.org/course/application_form_student.php</a>).<br />
Note also, that if applications are closed the second of these will indicate this along with approximate dates when Applications will open (from "Last Allowed Date" setting above).
</li>
<li>
One Dummy Student application should be made to test that the Dummy application appears in <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a>.
</li>
<li>
Change wording on module dates etc. in <a href="http://www.peoples-uni.org/" target="_blank">http://www.peoples-uni.org/</a> Drupal pages
</li>
<li>
Mailshot existing students (list of e-mails can be obtained from <a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> for the old semester(s))
</li>
<li>
Mailshot potential new students (lists of e-mails can be obtained from <a href="http://courses.peoples-uni.org/course/registrations.php" target="_blank">http://courses.peoples-uni.org/course/registrations.php</a> and old historical expressions of interest can also be found in <a href="http://courses.peoples-uni.org/course/interest.php" target="_blank">http://courses.peoples-uni.org/course/interest.php</a>)<br />
Note: Remember that any new students registration requests that come in after this point will need to be told that they need to apply promptly if they are to be in time for the new semester.
</li>
<li>
In Grades... Report Settings... User Report... De-select "Show Percentage".  This should not have to be done each semester.
</li>
<li>
For each course make sure that in Grades... Choose an Action... Select Settings/Course, for the User Report set "Show Percentage" to "Hide" or "Default (Hide)". It might be this way already.
</li>
<li>
The Course Total Grade must be set to Percentage:<br />
For each course... Select Grades... Select an action: Categories and Items/Full View... Click the edit icon under actions in the module header line (above the individual grade or category lines) which brings you to "Edit category". This (should be) the Course Total grade which needs to be set to a Grade type of "Value" (no Scale), a Maximum grade of 100.00 and a Minimum grade of 0.00. The "Category name" will be blank, but that is OK. The aggregation calculation can be set as desired.
</li>
<li>
The Course Total calculation (calculator icon on course total line of Categories and Items/Full View) must be set so that the course total is calculated as a sum of the 2 (or 1) assignments as appropriate using the appropriate ID numbers for those assignments.<br />
Note: Course Total used have to be entered manually because of a custom patch to Moodle, but this will now be removed so an automatic calculation is required.
</li>
<li>
Note: At a later stage (when students have been enrolled in their courses and any new tutors assigned), <a href="http://courses.peoples-uni.org/course/give_tutors_viewprofiles.php" target="_blank">http://courses.peoples-uni.org/course/give_tutors_viewprofiles.php</a> should be visited to give all Module Leader/Tutors/Student coordinator the sitewide Moodle Role "View Full User Profiles". See <a href="http://courses.peoples-uni.org/course/admin_documentation.php#misc">Misc: Enrolling Tutors in Tutors Corner, Giving Tutors the Sitewide Moodle Role "View Full User Profiles", Making a Donation</a>.
</li>
<li>
Obsolete: Each course module needs to have the Block "Track Marking" added (on the bottom right hand side). This will allow Tutors to access the Marking Spreadsheet see <a href="http://courses.peoples-uni.org/course/admin_documentation.php#trackmarking">Collaborative Assignment Marking and Resubmission Tracking</a>.
</li>
<li>
Note: At a later stage (when assignments are setup), all the assignments should be configured as the multiple file upload type "Advanced uploading of files". This is so students can have feedback on their submissions uploaded by the Tutor as an annotated copy of the student's submitted file using "track changes". Also students will be able to resubmit assignments.
</li>
</ol>


<a name="dealingwithapplications"></a>
<h2>Dealing with Applications</h2>
<ol>
<li>
Go to <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a>. You can see a list of applicants for this semester.
</li>
<li>
It is possible to filter the applications by semester (if you do not just want the current semester), by approval/registration status, by date, by name or email, by module name, by payment up to date?, by payment method, by whether the student is a Re&#8209;enrolment or a New student, by whether the student has applied for (or says they are already in) MPH, by whether the student has been accepted into MPH (and, if desired, during which period they were accepted), by whether the student has been suspended or graduated from MPH, by whether the student has made any application in the current semester, by whether the student has made any application in the previous semester, by whether the student has applied for a Scholarship and by the Income Category of the Student. When you have selected your desired filters you should then click "Apply Filters". You may also "Reset Filters" to remove them.
</li>
<li>
It is also possible to display only the columns relevant to Scholarships by clicking "Show Scholarship Relevant Columns" and then "Apply Filters".
</li>
<li>
It is also possible to display all the application data for each student in extra columns by clicking "Show Extra Details" and then "Apply Filters".
</li>
<li>
It is also possible to display columns with student history relevant to Tutors in a clean format suitable for Excel by clicking "Display Student History for Copying and Pasting to Excel" and then "Apply Filters".
</li>
<li>
It is also possible to display the standard colums in a clean format suitable for Excel by clicking "Display for Copying and Pasting to Excel" and then "Apply Filters".
</li>
<li>
The "sid" value against each student is a unique identifier which is used to track the application including payments by the student.
</li>
<li>
For each student application, data about the student is displayed in a row of the "spreadsheet".
</li>
<li>
In particular the one or two modules that the student has applied for are displayed. They are colour coded <span style="color:red">red</span> for not approved, <span style="color:#FF8C00">orange</span> for approved but not enrolled and <span style="color:green">green</span> for enrolled.
</li>
<li>
"Approved?", "Payment up to date?", "Enrolled?", "Details", "Student Grades" and "Student Submissions" will be described later.
</li>
<li>
Statistics are displayed at the end of the page.<br />
Note that the first table of statistics has "Module", "Number of Applications", "Number Approved", "Number Enrolled" and "Number Fully Paid (or New Student)" and can be used to track how modules are filling up.<br />
A "New Student" will obviously owe nothing until they are approved so will be included in "Number Fully Paid (or New Student)". After they are approved (assuming they have not paid yet), they will not be included in "Number Fully Paid (or New Student)".
</li>
<li>
E-mails of all the students in the spreadsheet (i.e. after any filters have been applied) are listed at the end of the page so that e-mails can be manually sent to a large group of applicants.
</li>
<li>
It is also possible to programmatically send a reminder or other e-mail to all of the students in the spreadsheet (i.e. after any filters have been applied) by using the form at the end of the page (instuctions for the form are given there). In particular, there is also a way requesting e-mails NOT to be sent to any student who is up to date in payments (balance adjusted for instalments <= 0).
</li>
<li>
Access to <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a> and the Details for each student are given by the System-wide "Manager" or "Administrator" roles. Both have the permission: moodle/site:viewparticipants.
</li>
<li>
If someone is given the "Manager" role (instead of the "Administrator" role) it may be useful to make them a "Tutors" in any one course (e.g. the Technical Check module) if it is desired to also give them access to "<a href="http://courses.peoples-uni.org/course/admin_documentation.php#studentenrolments">Student Enrolments and Grades</a>". Additionally if that person is needed to view course content, they should be given "Student coordinator" role in each desired course.
</li>
</ol>


<a name="thedetailsbutton"></a>
<h2>The "Details" button and the Approval Process</h2>
<ol>
<li>
First, underneath the details button, sometimes there is an indication "Re-enrolment". This indicates that the student was enrolled in a previous semester.
</li>
<li>
Note that the student has applied with the form: <a href="http://courses.peoples-uni.org/course/application_form_student.php" target="_blank">http://courses.peoples-uni.org/course/application_form_student.php</a>. All students use the Moodle account they were given during Registration. They have to enter very little information: their existing Moodle username, desired modules, a possible alternate module (if their desired module is full), Application for MPH (if any), Scholarship request (if any) and why they did not complete the previous semester (if they did not).
</li>
<li>
When the "Details" button is pressed for an application, additional applicant data is displayed beyond what is in the "spreadsheet" row.
</li>
<li>
"Alternate module" Indicates a possible alternate module set by the Student (if their desired module is full).
</li>
<li>
"Student Grades" Launches the Peoples-uni transcript of the grades achieved by this student in all the modules they have done. See "Course Grades" (<a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a>) which is described below in "<a href="http://courses.peoples-uni.org/course/admin_documentation.php#studentenrolments">Student Enrolments and Grades</a>".
</li>
<li>
"Student Submissions" Launches a report on all the assignment submissions made by this student. See "<a href="http://courses.peoples-uni.org/course/admin_documentation.php#tracking">Viewing Student Submissions & Re-Submissions, Grades & Comments, Student Posts, Tutor Posts and Student Support Forum Posts</a>" below.
</li>
<li>
"Payment up to date? (amount owed includes modules already approved for this semester or any MPH instalments due this semester)" indicates the amount still due this semester (i.e. instalments due in subsequent semesters are not included).<br />
If any of the transactions for this student are "(not confirmed)", this will be indicated. This can be used to find students whose payments need to be audited.
</li>
<li>
"Total Payment Owed (might be more because of future instalments)" indicates any payment due from the student (if they are paying by instalments, this indicates the total due, NOT just the amount due this semester). It also indicates overpayment.
</li>
<li>
"Payment Method" can be one of...<br />
'RBS WorldPay Confirmed': They paid online with a credit card (using the link they were sent in their approval e-mail which brings then to http://courses.peoples-uni.org/course/pay.php?sid=XXX (XXX being their SID, the unique application ID number noted in <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a> and "Details").<br />
'Barclays Bank Transfer': They have indicated they have paid by bank transfer to Barclays, but we have not confirmed that.<br />
'Ecobank Transfer': They have indicated they have paid by bank transfer to Ecobank, but we have not confirmed that.<br />
'Diamond Bank Transfer': They have indicated they have paid by bank transfer to Diamond Bank, but we have not confirmed that.<br />
'MoneyGram': They have indicated they have paid by MoneyGram, but we have not confirmed that.<br />
'Indian Confederation': They have indicated they have paid locally in India, but we have not confirmed that.<br />
'Posted Travellers Cheques': They have indicated they have posted Travellers Cheques, but we have not confirmed that.<br />
'Posted Cash': They have indicated they have posted Cash, but we have not confirmed that.<br />
'Promised End Semester': They have promised to pay by end semester!<br />
'Waiver': We have given them a scholarship.<br />
'Barclays Bank Transfer Confirmed': Payment has been confirmed.<br />
'Ecobank Transfer Confirmed': Payment has been confirmed.<br />
'Diamond Bank Transfer Confirmed': Payment has been confirmed.<br />
'MoneyGram Confirmed': Payment has been confirmed.<br />
'Indian Confederation Confirmed': Payment has been confirmed.<br />
'Posted Travellers Cheques': Payment has been confirmed.<br />
'Posted Cash': Payment has been confirmed.<br />
The student can set 'Barclays Bank Transfer', 'Ecobank Transfer' and 'MoneyGram' using the paydetails.php link they will have been sent in their approval e-mail (the link includes the SID unique application ID). The credit card one is set automatically and the rest are set manually by us as described in the next bullet point.
</li>
<li>
"Update Payment Amounts, Method or Confirmed Status" are links (to payconfirm.php with the applicant SID as a parameter) that bring up a page that allows us to update the data in the previous bullet points by:-
<ol>
<li>
Updating the student payment account by adding a new transaction which decreases (or increases) the balance owed. This might be to record that a payment has been made (although WorldPay credit card payments are added as transactions automatically by the software) or a student has been given a bursary. Transactions for the amount owed for modules (&pound;40 per module or other amounts depending on LMIC/HIC status and whether it is an ordinary module or dissertation) are automatically added to the account when a student is approved for modules (see below for in "Set the Income Category for the Student" details).<br />
Any transaction that is added can be marked as "(not confirmed)". All non-credit card transaction added by a student (in paydetails.php) will automatically be "(not confirmed)".
</li>
<li>
Setting the "Payment Method". Note that a confirmatory e-mail is sent to the student with all their payment account transactions when a "Confirmed" status is set.<br />
(Setting the "Payment Method" does not change the "(not confirmed)" status for any transaction, that should be done when an individual transaction is added or "Mark all Transactions in this Student's Account as Confirmed" can be used.)
</li>
<li>
Marking all transactions in a student account which are "(not confirmed)" as confirmed.
</li>
<li>
Add a Payment Note for the Student (which will be seen on payconfirm.php in future semesters for this student and will be noted in applications.php under "Payment up to date?" and also on the "Details" page in "Payment Method" for all future applications by this student).<br />
payconfirm.php also lists the full student payment account, the "Payment Method" for all previous applications for earlier semesters by this student and the student payment schedule for those MPH students that have elected to pay by instalments (there is also a link to Specify Instalments/specify_instalments.php to specify/change this payment schedule using the same page as the student uses... see <a href="http://courses.peoples-uni.org/course/admin_documentation.php#specifyinstalments">Specify Instalment Payment Schedule</a>).
</li>
</ol>
</li>
<li>
"Date Paid" is set to the date they paid by credit card or if the student gave us payment details online through paydetails.php. It is not set if we entered the fact that they paid.
</li>
<li>
"Payment Info" is reference data entered by the student when they go to paydetails.php to indicate that they have made a payment by bank transfer. It is not proving very useful. In practice it seems that the only data that apears in our bank statements is the payee's name. Also students do not seems to remember to go to paydetails to notify us they have made a payment, so we have been reduced to just checking bank statements (which we would have to do in any case to confirm all non credit card payments).
</li>
<li>
"Notes" lists any notes that have been added to the student record in "Details" or student.php. If any note is present they the "(Note Present)" indicator will be displayed under the "Enrolled?" column in applications.php.
</li>
<li>
"MPH Status" indicates whether the student "Wants to Apply for ... MPH" or "Says Already in ... MPH" (this is also displayed on the main applications.php spreadsheet under "Approved?"). It also indicates whether the Student was "Enrolled in MPH" (it is set further down the "Details" page. It is also displayed on the main applications.php spreadsheet under "Enrolled?" as "(... MPH)"). If a Student was "Enrolled in MPH" and then "Unenrolled from MPH" (which is also set further down the "Details" page) this is also indicated here with dates and any reason (but this is not shown on the main applications.php spreadsheet).<br />
If a Student was "Suspended from MPH" or "Unsuspended from MPH" (both of which can be set further down the "Details" page) this is also indicated here with dates and any reason (but this is not shown on the main applications.php spreadsheet).
</li>
<li>
"Certificate in Patient Safety Status" indicates whether the student "Wants to Apply for Certificate in Patient Safety" or "Says Already in Certificate in Patient Safety" (this is also displayed on the main applications.php spreadsheet under "Approved?"). It also indicates whether the Student was "Enrolled in Certificate in Patient Safety" (it is set further down the "Details" page. It is also displayed on the main applications.php spreadsheet under "Enrolled?" as "(Cert PS)"). If a Student was "Enrolled in Certificate in Patient Safety" and then "Unenrolled from Certificate in Patient Safety" (which is also set further down the "Details" page) this is also indicated here with dates and any reason (but this is not shown on the main applications.php spreadsheet).
</li>
<li>
"Student Dissertation Proposals" displays any proposal submitted by the Student (links to these proposals are also displayed on the main applications.php spreadsheet under "Approved?").
These proposals are submitted by the Student by clicking on a link in the Course Application Form (<a href="http://courses.peoples-uni.org/course/application_form_student.php" target="_blank">http://courses.peoples-uni.org/course/application_form_student.php</a>).
There are instructions about what to do there.
They can also be entered at other times by the Student clicking directly on <a href="http://courses.peoples-uni.org/course/dissertation.php" target="_blank">http://courses.peoples-uni.org/course/dissertation.php</a><br />
Access to <a href="http://courses.peoples-uni.org/course/dissertations.php" target="_blank">http://courses.peoples-uni.org/course/dissertations.php</a>, which is where Dissertation Proposals are displayed is available to any Tutor, Lurker or Admin.<br />
When the Student submits the dissertation form, the Semester for that entry is set to the current Semester. Any entry in dissertations.php can have its Semester changed by selecting a different Semester for that entry using the drop down beside the displayed Semester.<br />
There is a filter on dissertations.php for selecting a particular Semester or "All".<br />
There is a filter "Display for Copying and Pasting to Excel" to suppress extraneous information so that copying will work effectively.
</li>
<li>
"Approve Full Application" is a button which allows the full application to be approved (both Modules if the applicant has specified two). The user is sent the e-mail outlined above under <a href="#configuration">"Configuration of Applications Process for a new Semester"</a> which requests payment.<br />
The "Approved?" entry in <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a> and "Details" will indicate "Yes" as opposed to "No", "Some" (if only one application is approved, see below) or "Denied or Deferred" (if the application has been un-approved after being approved.)
</li>
<li>
"Approve Full Application BURSARY" is a button which allows the full application to be approved (both Modules if the applicant has specified two). The user is sent the e-mail specified under <a href="#configuration">"Configuration of Applications Process for a new Semester"</a> which indicates they have a bursary (as well as other information).
</li>
<li>
"Approve Module '...' only:" is a button that allows either one of the modules to be approved and not the other. Note in this case no e-mail is sent. So instructions about how to pay need to be sent manually.
</li>
<li>
"Change Module ... Name from '...' to':" allows one or other of the selected modules to be changed to a different one (probably because the module is full and the applicant has been offered a different choice or changed their mind for some reason.). This option only appears when the user is not enrolled in the module. If no second module has been specified, it is possible to add one.
</li>
<li>
"UnApprove Module:" is a button which allows un-approving a module. Note, also that if the applicant has already been enrolled in the course (see below) they will be un-enrolled from that module.
</li>
<li>
"e-mail Applicant" allows an e-mail to be sent to the Applicant, the e-mail to be sent can be edited. the e-mail will come from apply@peoples-uni.org as does the approval e-mail. Note these e-mails are copied to the e-mail address applicationresponses@peoples-uni.org.
</li>
<li>
"Corresponding Registered Moodle Username:" shows details for the Moodle user matching the application (if this is not a new application or if the user has been created (see below)).
</li>
<li>
"Users course's" shows the existing courses for the above user.
</li>
<li>
"Update Username" is a button that allows the Applicant's suggested user name to be changed (because it conflicts with an existing Moodle username).
</li>
<li>
"Enrol User in Module ... only" button causes the user to be enrolled in the one module only and not the other. The following e-mail will be sent from the Module Leader:<br />
<pre>
Welcome to $a->coursename!

If you have not done so already, you should edit your profile page
so that we can learn more about you:

  $a->profileurl

There is a link to your course at the bottom of the profile or you can click:

  $a->courseurl
</pre>
<br />
The "Enrolled?" column in <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a> and "Details" will indicate "Some" or "Yes" if the Applicant has been enrolled in all their modules.
<br />
Note: This button (and the button in that next bullet point) will restore any Forum Subscriptions in Students Corner what were removed by <a href="http://courses.peoples-uni.org/course/clean_studentscorner_subscriptions.php" target="_blank">http://courses.peoples-uni.org/course/clean_studentscorner_subscriptions.php</a>. See <a href="http://courses.peoples-uni.org/course/admin_documentation.php#cleanstudentcornersubscriptions">Cleaning out old Discussion Forum Subscriptions in Students Corner</a>.
</li>
<li>
"Enrol User in Modules ... and ..." button will enrol the user in both modules.
</li>
<li>
"Record that the Student has been enrolled in the MPH" button does what it says (it is necessary to say whether it is a Peoples-uni or OTHER (university) MPH).
</li>
<li>
"Unenroll a student from the Masters in Public Health (MPH)" button does what it says.
</li>
<li>
"Suspend student from the Masters in Public Health (MPH)" button does what it says (Reasons can be added which are displayed further up the page. This leaves the student as an MPH student but indicates they are not currently active). They are not listed on track_submissions.php when filtering for MPH students.
</li>
<li>
"Unsuspend student from the Masters in Public Health (MPH)" button does what it says (Reasons can be added. This makes the student active again).
</li>
<li>
"Record that the Student has been enrolled in the Certificate in Patient Safety" button does what it says.
</li>
<li>
"Unenroll a student from the Certificate in Patient Safety" button does what it says.
</li>
<li>
"Set the Income Category for the Student" button does what it says. It is necessary to specify whether the student is LMIC (Low/Middle Income country) or HIC (High Income country).<br />
It is also possible to specify that a student is an "Existing Student", but it should not be necessary to use that as all students before the changeover to the new module costings will automatically have this status.<br />
The default is LMIC (assigned automatically when new students are registered), so there will not normally be a reason to set this.<br />
The categories are used to allocate costs for modules according to the following scheme (as of 28th June 2014)...<br />
<ol>
<li>
Existing MMU MPH Students: &pound;0 per module, &pound;1500 for MPH
</li>
<li>
Existing Peoples MPH Students: &pound;40 per module, &pound;100 for the dissertation
</li>
<li>
Existing (non MPH) Students: &pound;40 per module, &pound;100 for the dissertation
</li>
<li>
New LMIC students: &pound;40 per module, &pound;260 for the dissertation
</li>
<li>
New HIC students: &pound;300 per module, &pound;1200 for the dissertation
</li>
</ol>
</li>
<li>
The "Add This Note to Student Record" button adds a note entered above that button to the student record. When there are any notes for a student it will be indicated in the applications.php spreadsheet in the "Enrolled?" column by the words "(Note Present)".<br />
The purpose of these notes is to allow records to be kept of application or grading data related to the student (There are separate Payment Notes to track payment issues and also now a separate "Ready to Enrol" marker.)<br />
All notes for the student (if any are present, either entered here or in "Student Grades"/student.php) will be listed further up the details page.<br />
<br />
When the student is enrolled, the note is marked as applying to that user so subsequent applications for the same student will reference all the notes for that student, not just notes attached to the current application.<br />
</li>
<li>
"Change Applicant e-mail to:" allows the applicant's e-mail to be changed. (Will not be displayed if the applicant has already been registered in Moodle.)
</li>
<li>
"Enrol Applicant in an Additional Module (beyond the normal 2):" allows the applicant to be enrolled in a 3rd or 4th etc. module. This can only be done after the applicant has been enrolled in the normal modules.
</li>
<li>
"Close Window" closes this window (note the original applications.php spreadsheet will still be there).
</li>
<li>
"Hide this Application Form Entry from All Future Processing" button does what it says.
</li>
<li>
Note that the applications.php spreadsheet is refreshed with any changes that have been made in this details page.
</li>
</ol>


<a name="closing"></a>
<h2>Closing Applications for a Semester</h2>
<ol>
<li>
First it may be desirable to mark some modules as full before all the applications are finally closed. To do this go to <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> click "Check to mark Module as Full" for any module that is full and then click "Mark Modules as Full or to be Removed based on Check Boxes Above". You can confirm that the form has changed by looking at it (<a href="http://courses.peoples-uni.org/course/application_form_student.php" target="_blank">http://courses.peoples-uni.org/course/application_form_student.php</a>). You will see the list of modules has changed, but also that there is extra wording automatically added to explain that the two modules are full.
</li>
<li>
But to fully close applications go to <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> and click "Mark All Modules as Full (Applicants will be sent to Registration Form)". You can confirm that the form has closed by looking at it (<a href="http://courses.peoples-uni.org/course/application_form_student.php" target="_blank">http://courses.peoples-uni.org/course/application_form_student.php</a>).
</li>
<li>
In the case that you want to reopen applications temporarily for some reason... Just go to <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> deselect "Check to mark Module as Full" for any module that you wish to reopen and then click "Mark Modules as Full or to be Removed based on Check Boxes Above". You can confirm that the form has changed by looking at it (<a href="http://courses.peoples-uni.org/course/application_form_student.php" target="_blank">http://courses.peoples-uni.org/course/application_form_student.php</a>). You will see the list of modules has changed.
</li>
<li>
Note: Those who have the permission "moodle/site:viewparticipants" (which is the same as gives access to applications.php), can enter an application on behalf of a student (presumably for a "late" student application) even if applications are closed. They are also allowed make an application for modules even if those modules are full.<br />
Also it is possible to allow a student to make a late application (see <a href="http://courses.peoples-uni.org/course/admin_documentation.php#theregdetailsbutton">The "Details" button and the Registration Process</a> above).
</li>
<li>
Note: When all students have been enrolled for a module, then the Marking Spreadsheet will need to be created see... <a href="http://courses.peoples-uni.org/course/admin_documentation.php#trackmarking">Collaborative Assignment Marking and Resubmission Tracking</a>.<br />
This should be done some time before assignment submission and grading starts.
</li>
</ol>


<a name="tutorregistration"></a>
<h2>Registering Tutors in Moodle</h2>
<ol>
<li>
<a href="http://courses.peoples-uni.org/course/tutor_registration.php" target="_blank">http://courses.peoples-uni.org/course/tutor_registration.php</a> is a page the link to which should be given to new volunteers (of any type, but primarily tutor volunteers) to enter data about themselves including their reasons for volunteering and their experience and also data needed to register them in Moodle.
<br />Note: we (Peoples-uni) could also use this form to enter data for a volunteer who has never filled in the form or been registered in Moodle, although it is better for the prospective volunteer to do it.
</li>
<li>
<a href="http://courses.peoples-uni.org/course/tutor_registration_existing.php" target="_blank">http://courses.peoples-uni.org/course/tutor_registration_existing.php</a> is similar to the previous page but is designed to gather a subset of the above information, because they have previously been registered in Moodle but we would still like to have a record of their background etc. They must be logged into Moodle for this form.
</li>
<li>
<a href="http://courses.peoples-uni.org/course/tutor_registrations.php" target="_blank">http://courses.peoples-uni.org/course/tutor_registrations.php</a>
list all forms submitted by volunteers and also all Moodle users who have ever been tutors in one of the Peoples-uni modules even is they have never submitted a form.
</li>
<li>
As well as data entered by the tutor it also displays other data in columns...
<br />Date registered in Moodle (or if not yet registered the date of form submission).
<br />An indication whether they have been registered ("Registered").
<br />And, still in the first column a link to either "Create form" for those tutors who never filled in a from and we wish to do it for them or "Edit form" if we want to update their form (see below).
<br />Names & e-mail.
<br />"Volunteer type" which is a field that we can enter when we "Edit form" to describe the type of volunteer. (Only Managers or Module leaders for that tutor can see or edit this field.)
<br />"Modules of interest" which is a field that we can enter when we "Edit form" to describe the modules that the volunteer is interested in or possibly suitable for. (Only Managers or Module leaders for that tutor can see or edit this field.)
<br />"Notes" which is a field that we can enter when we "Edit form" to write notes on the volunteer. (Only Managers or Module leaders for that tutor can see or edit this field.)
<br />Then there are fields entered by the volunteer (also editable by us).
<br />Then there is one column for every semester showing the modules that the volunteer has been a tutor for ("*" indicating Module leader).
<br />The final column list the names of files that have been uploaded for the volunteer. This is normally expected to contain the volunteers CV. The files can be downloaded directly by Managers (also from "Edit form").
<li>
Various filters are available.
</li>
<li>
e-mails of all selected tutors are displayed in a list towards the bottom of the page.
</li>
<li>
Some statistics are displayed at the bottom of the page.
</li>
<li>
The Manager role gives access, but additionally, Module leaders can also access to view and the edit a form for any tutor in one of the modules for which they are Module leader.
</li>
<li>
The "Create form" or "Edit form" links bring you to a page where you can edit the data for a volunteer. This includes uploading (or viewing) CVs or any other files that might be kept here.
<br />Toward the bottom of the page there is a checkbox "Check to register volunteer in Moodle" which allows us (a Manager) to check and when the form is submitted, the prospective volunteer will be given a Moodle account.
<br />After submission, if the checkbox was checked, the order of the rows in the table may be changed as unregistered users show on top.
<br />The new Moodle user will get an e-mail with their new Moodle username and password and instructions on where to login.
<br />The e-mail also contains the following text about their profile and also indicating that they will get further information, so this should be followed up quickly with guidelines on being a tutor (or whatever other role then may be given in Peoples-uni).
<pre>
Your profile is at:
http://courses.peoples-uni.org/user/view.php?id=USER_ID_HERE&course=1
You are welcome to personalize this, so students
and colleagues can learn more about you.

You will soon receive information about next steps.
</pre>
</li>
<li>
Registration is only a first step, they will not have access to anything, especially they will not have access to any modules... they need to be manually given the appropriate Moodle roles suitable to their new volunteer position.
</li>
<li>
Note: the <a href="http://courses.peoples-uni.org/course/tutor_registration_edit.php" target="_blank">http://courses.peoples-uni.org/course/tutor_registration_edit.php</a> page URL which is linked from the <a href="http://courses.peoples-uni.org/course/tutor_registrations.php" target="_blank">http://courses.peoples-uni.org/course/tutor_registrations.php</a> page can be given directly to any tutor to allow them to view and edit/update their own data including CV(s) if the form has already has been created by the volunteer themselves or by us. They cannot edit "Volunteer type", "Modules of interest" or "Notes" unless they happen to be a Module leader.
</li>
</ol>


<a name="misc"></a>
<h2>Misc: Enrolling Tutors in Tutors Corner, Giving Tutors the Sitewide Moodle Role "View Full User Profiles", Making a Donation</h2>
<ol>
<li>
<a href="http://courses.peoples-uni.org/course/enroltutorscorner.php" target="_blank">http://courses.peoples-uni.org/course/enroltutorscorner.php</a> Enrolls all current users with roles "Module Leader", "Tutors" or "Student coordinator" in the "Tutors Corner" and "Guide for online facilitators" modules.<br />
The names or contextid of these two modules should not be changed.
</li>
<li>
<a href="http://courses.peoples-uni.org/course/give_tutors_viewprofiles.php" target="_blank">http://courses.peoples-uni.org/course/give_tutors_viewprofiles.php</a> can be run at any time to give all Module Leader/Tutors/Student coordinator the sitewide Moodle Role "View Full User Profiles". The script should normally be run every semester after students have been enrolled as it picks up all tutors (etc.) for those courses which have enrolled students (enrolled by our enrolment system for current or previous semesters). It does not apply to tutors in other courses e.g. techie check or test/demo/introductory/student support courses.<br />
This sitewide role "View Full User Profiles" allows users to see the full profiles of other users. When a user is given this role they will be able to see all profiles (not just those for students in their own course) and will even be able to see profiles of other tutors (but we do not use the custom profile fields for tutors, so there is little to see except city/country).
</li>
<li>
The following page was linked from the Drupal menus to allow donations: <a href="http://courses.peoples-uni.org/course/donate.php?code=28595" target="_blank">http://courses.peoples-uni.org/course/donate.php?code=28595</a> but now it is not linked (because of usage for fraudulently testing stolen credit cards) but can be given out on request.
</li>
<li>
This page also allows donations, but has a cleaner layout (without Moodle menus): <a href="http://courses.peoples-uni.org/course/donate_occ.php?code=28595" target="_blank">http://courses.peoples-uni.org/course/donate_occ.php?code=28595</a>. It can be used within a course where misuse is less likely.
</li>
<li>
Both pages send an e-mail to payments@peoples-uni.org with the sum donated. If the donator has allowed us "to keep a record of your details and possibly contact you" (there is a checkbox) we include their details in that e-mail (as well as saving in the database). In this case, if they have provided an e-mail address, we also send a thank you e-mail back to them.
</li>
<li>
Note there is also a checkbox to "Allow Peoples-uni to display your name (but no other details) on our website as a supporter".
</li>
</ol>


<a name="tracksubmissions"></a>
<h2>Tracking Student Assignment Submissions</h2>
<ol>
<li>
<a href="http://courses.peoples-uni.org/course/track_submissions.php" target="_blank">http://courses.peoples-uni.org/course/track_submissions.php</a> allows tracking of student assignment submissions (most recent date and status displayed) against due, cut-off and extension dates. If the cut-off or extension dates have not been entered in the assignment for the student, they are not tested. An indication is also given (in the final column) if there is no submission or if the submission is outside the various dates. Here are the possible indications that can be given...
<br />No Submission
<br />Within Extension
<br />Within Cut-off
<br />Outside Extension!!!
<br />Outside Cut-off!!!
<br />Outside Due Date!!!
<br />(only one of these, starting from the top of the list, is shown.)
<br />Also if the Assignment Grade or Final Grade date is earlier than the Submission date, a warning is given.
<br />(All of the above are in the rightmost column.)
</li>
<li>
If there has been more than one submission then the "Submission History" column contains a list of all submissions (status & date).
</li>
<li>
The "All Recorded Submissions" column has a list of dates of all submissions even those that are "draft" and the dates of which might have been overwritten by Moodle when the status is changed to "submitted" by us or the student. This is clickable to get to more details.
</li>
<li>
The "All Assignment Grades" column has a list of all assignment grades and the dates.
</li>
<li>
The most recent final grade given to the submission is also displayed in the "Final Grade" column (may not be shown if grade is not 'released').
</li>
<li>
And the "MPH" column indicates whether the student is an MPH student (and of what type).
</li>
<li>
Also a list of all grades given to the assignment (grades and re-grades) and the date each grade was given is displayed in the "Grading History" column.
</li>
<li>
The semester is selectable in a filter as well as an optional second semester, module name (part of), MPH status, Status (see next bullet point for explanation), whether it is desired to sort the table with the most recent Grading/Submission activity at the top and whether it is desired to remove all headers and footer info to make it easier to copy the data and paste into a spreadsheet.
</li>
<li>
The Status Filter has the following options...<br />
Any<br />
Not submitted (the assignment has not been submitted)<br />
Submitted<br />
Submitted, [but] No Final Grade [assigned][or Assignment/Final Grade date is earlier than the Submission date]<br />
Submitted, Final Grade <50<br />
Submitted, Final Grade =0<br />
Submitted, Outside Due/Extension [Submitted after Due date (and also after Extension date, if there is one)]<br />
</li>
<li>
Also in <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> it is possible to indicate that certain assignments (normally the first assignment in a course) from inclusion in the table. The setting "Set above comma separated list of assignment IDs to be excluded from track_submissions.php" should contain a comma separated list of all assignments from all semesters that should be excluded. The IDs can be found in the "Assignment (id)" column of track_submissions.php.
</li>
<li>
The Manager role gives access to this page.
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#tracking">Viewing Student Submissions & Re-Submissions, Grades & Comments, Student Posts, Tutor Posts and Student Support Forum Posts</a> describes a way of looking at all submissions and all grades for an individual student.
</li>
<li>
<strong>Additionally</strong>... <a href="http://courses.peoples-uni.org/course/track_quizzes.php" target="_blank">http://courses.peoples-uni.org/course/track_quizzes.php</a> allows tracking of student quiz submissions (most important in Biostatistics) in a similar way to track_submissions.php with the same column names.
</li>
</ol>


<a name="trackmarking"></a>
<h2>Collaborative Assignment Marking and Resubmission Tracking</h2>
<ol>
<li>
<strong>This process is currently not used!</strong>
</li>
<li>
A process has been designed which allows Tutors for a course module to use a (Google Apps) spreadsheet to collaborate on tracking assignment submissions and their grading (as well as overall module grading).
</li>
<li>
It is driven by a small Block "Track Marking" which should have been added to every relevant Module (on the bottom right hand side). The block is only visible to site administrators or to Module Leader/Tutors (more specifically users who have moodle/grade:edit for the course). It is not visible to students. Also the Block will not be displayed to Module Leader/Tutors if the spreadsheet has not yet been created.
</li>
<li>
When all students have been enrolled for a module, then the Marking Spreadsheet will need to be created. This should be done some time before assignment submission and grading starts. This can be done by a Moodle Admin using the second link "Re-Create Marking Spreadsheet" in that block. This link, when clicked, brings up a page with a button which allows the Marking Spreadsheet to be created (or recreated). There is a warning popup to make sure you really want to overwrite the spreadsheet (and any marking that is contains, although Alan Barrett should be able to get the spreadsheet back if necessary, through the admin@files.peoples-uni.org Google account!).
</li>
<li>
The spreadsheet that is created is based on a standard spreadsheet and has all the names of the enrolled students in the particular course added to it (so they can be collaboratively marked). The process of creating the spreadsheet is slightly slow.
</li>
<li>
The standard spreadsheet used in each case as a starting point is called Marking.xls which is stored in the Moodle course directory and can be changed through "git" source control.
</li>
<li>
A Tutor will just see one link in the Block: "Edit Marking Spreadsheet"... this launches the Marking Spreadsheet which allows immediate editing (and almost immediate automatic saving of any changes including format/layout changes). Layout can be changed as well as content.
</li>
<li>
Two or more editors should be able to edit at the same time and will see the other person's edits as they happen.
</li>
<li>
The editing is anonymous (unless an editor is logged into their own Google account). Users will not be logged into the admin@files.peoples-uni.org Google account which owns the spreadsheet. Any user (including a student!) who has been given the link would be able to edit, so the links should not be given out! Tutors will be able to see the link to the spreadsheet for their own module but not other modules, although they can obviously be given the link if desired. The actual link is quite long and also contains an authorisation key which cannot be figured out unless given away.
</li>
<li>
Note, it is possible get access to any previous revision of the spreadsheet via "File"... "See Revision History". This allows some auditing of changes. This is only possible for logged on Google users (any Google account). It is also possible for an editor to change the permissions on the spreadsheet... this should not be done! Alan Barrett will however be able to recover any hidden spreadsheets in an emergency (through admin@files.peoples-uni.org).
</li>
<li>
Assignment grades agreed in the spreadsheet will need to be manually entered in the Moodle Grade Report along with any text feedback and uploaded files feedback.
</li>
<?php
//<li>
//However the Course Total Grades can (and should be) automatically retrieved from the Marking Spreadsheet and saved into the Moodle Grade Book by a Moodle Admin using the third link "Store Course Total Grades into Moodle" in the "Track Marking" block.  This link, when clicked, brings up a page with a button which allows the Course Total Grades to be Retrieved. There is a warning popup to make sure you really want to Save these grades into Moodle (and overwrite any existing grades for this course in Moodle... e.g. if a grade is not set in the spreadsheet but is set in Moodle, it will overwritten to be No Grade). As normal, a history of all changes (and who did them... in this case who clicked the button) is kept.<br />
//While tutors (or admins) are free to edit the module's spreadsheet, the following restrictions must be obeyed...<br />
//Students are identified by something like "Firstname Secondname (999) in first column. The (999) part, which is their user ID must not be removed."<br />
//The column header "Overall Module Grade: Pass/fail" for the column that contains the Course Total Grades MUST be kept EXACTLY as is (although columns before or after it can be changed, added or removed.<br />
//Currently the Course Total Grade must be "Pass", "Fail" or empty which implies No Grade. Any text containing a "P" or "F" in either case will work. But no numeric marks out of 100 can be entered. This can be easily changed when we decide to, but is fixed at Pass/fail for the moment.
//ABOVE CODE NOW DEALS WITH PERCENTAGE 'Overall Module Grade (%)', but is not used
//</li>
//<li>
//At a later stage it would be possible to write code to update assignment grades (in addition to the Course Total Grades) from the spreadsheet into Moodle if that makes sense, but we have decided not to do that for now.<br />
//Also it would be possible to write code to automatically record in the spreadsheet stuff such as the fact that a student has made a submission (or resubmission), but this is currently a manual process.
//</li>
?>
</ol>


<a name="tracking"></a>
<h2>Viewing Student Submissions & Re-Submissions, Grades & Comments, Student Posts, Tutor Posts and Student Support Forum Posts</h2>
<ol>
<li>
If you go to any of the following links <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a>, "Details", <a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> or "Student Grades"/student.php, you will see a link called "Student Submissions" for each student which will allow you to view all submissions that students have made for assignments (including re-submissions) and also all the grades received by the Student and all comments by the Tutors.
</li>
<li>
The "Student Submissions" link will display (In the first table) a list of all submissions made by the student. Note that the files can always be downloaded to your machine by clicking on them.
</li>
<li>
The "Student Submissions" link will display (in the second table) a list of all grade changes for the Student along with all Tutors feedback comments made (as they changed) by the Tutor.
</li>
<li>
Access to "Student Submissions" is available to any Tutor or Admin. None of this is visible to students, all they see is their own academic transcript in student.php.
</li>
<li>
There is a parameter you can add to the end of the "Student Submissions" URL "&hidequiz=1", which hides display of quizzes if it becomes too cluttered for a particular student.
</li>
<li>
....................................................
</li>
<li>
To view posts made by Students to discussion forums go to: <a href="http://courses.peoples-uni.org/course/posts.php" target="_blank">http://courses.peoples-uni.org/course/posts.php</a>.
</li>
<li>
This lists all posts for each enrolled student (not others), giving Module, Forum Name and Subject.
</li>
<li>
You can also click on the subject to see the discussion details.
</li>
<li>
Four additional columns to do with ratings of discussions by Tutors are described in <a href="http://courses.peoples-uni.org/course/admin_documentation.php#sendingdiscussion">Sending Discussion Feedback to Students</a>.<br />
These columns are... 'Referred to resources:', 'Critical approach:', 'Referencing:', 'Write discussion feedback for student...'. Also described there are additional filters associated with these columns and also additional summary tables.
</li>
<li>
After the main body of posts there are tables (one per course) that show, for each Student, the number of posts they have made to each topic. Each is headed by the following text...<br />
"Posts by Student by Forum Topic for: <i>Course Name</i>..."
</li>
<li>
There is also a filter which says "Suppress Names on Posts by Student by Forum Topic Report for each Course (& use SID)"... that causes names not to be displayed for those tables only (& the SID application number to be used to keep the data anonymous). <a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> can be used, if necessary, to send an e-mail to enrolled students to remind them of their SID... Go to the form at the end of that page, enter a subject such as "Here is your Peoples-uni SID", change the draft e-mail text to something like this (the default version of this is set in <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a>)...<br />
<pre>
Dear GIVEN_NAME_HERE,

Here is a reminder of you Application ID (called SID).

Your SID is: SID_HERE

This is used both for payment purposes and also to present anonymous data to you.

    Peoples Open Access Education Initiative Administrator.
</pre>
... and then click "Send e-mail to All".
</li>
<li>
There is yet another filter called "Don't Show Number of Posts" which just shows a "Yes" if there has been a post rather than the number of posts in the "Posts by Student by Forum Topic" Reports.
</li>
<li>
<a href="http://courses.peoples-uni.org/course/posts.php" target="_blank">http://courses.peoples-uni.org/course/posts.php</a> also gives totals by Student after the "Posts by Student by Forum Topic" Reports. It then also gives totals by Student by module and yet again after that there is a summary of contributions per topic at the end of the page.
</li>
<li>
<a href="http://courses.peoples-uni.org/course/posts.php" target="_blank">http://courses.peoples-uni.org/course/posts.php</a> also includes filters so you can suppress those topics which start with the word "introduction" and limit scope to e.g. one module, by the Student Support Group that the Student is subscribed to in the Student Support Forums, by User Name, by whether the student has been accepted into MPH (and, if desired, during which period they were accepted) etc. (as well as the filters mentioned above).
</li>
<li>
At the end of the <a href="http://courses.peoples-uni.org/course/posts.php" target="_blank">http://courses.peoples-uni.org/course/posts.php</a> page there is a list of e-mails for all Students who have a post matching the filters, there is also a list of e-mails for all Students matching the main filters who have no posts (this could be used to send out reminders).
</li>
<li>
Access to posts.php is available to any Tutor, Student coordinator or Admin.<br /><br />
</li>
<li>
....................................................
</li>
<li>
To view posts made by Tutors to discussion forums go to: <a href="http://courses.peoples-uni.org/course/tutorposts.php" target="_blank">http://courses.peoples-uni.org/course/tutorposts.php</a>.
</li>
<li>
This lists all posts for each Tutor ("Module Leader" or "Tutors", not others), giving Module, Forum Name, Subject and Date of post.<br />
Note the posts are sorted by date so it is possible to determine if the appropriate discussions have been started by the Tutors. An e-mail address is listed which, if clicked on, will launch your mailer so you can send an e-mail to the Tutor.
</li>
<li>
You can also click on the subject to see the discussion details.
</li>
<li>
After the main body of posts there are tables (one per course) that show, for each Tutor, the number of posts they have made to each topic. Each is headed by the following text...<br />
"Posts by Tutor by Forum Topic for: <i>Course Name</i>..."
</li>
<li>
<a href="http://courses.peoples-uni.org/course/tutorposts.php" target="_blank">http://courses.peoples-uni.org/course/tutorposts.php</a> also gives totals by Tutor after the "Posts by Tutor by Forum Topic" Reports. It then also gives totals by Tutor by module and yet again after that there is a summary of contributions per topic at the end of the page.
</li>
<li>
<a href="http://courses.peoples-uni.org/course/tutorposts.php" target="_blank">http://courses.peoples-uni.org/course/tutorposts.php</a> also includes filters so you can suppress those topics which start with the word "introduction" and limit scope to e.g. one module etc.
</li>
<li>
Access to tutorposts.php is available to any Tutor or Admin.<br /><br />
</li>
<li>
....................................................
</li>
<li>
To view posts made in the Student Support Forums module go to: <a href="http://courses.peoples-uni.org/course/support_posts.php" target="_blank">http://courses.peoples-uni.org/course/support_posts.php</a>.
</li>
<li>
This lists all posts giving Forum Name and Subject.
</li>
<li>
You can also click on the subject to see the discussion details.
</li>
<li>
After the main body of posts there are tables that show for each contributor, the number of posts they have made to each topic and further summaries.
</li>
<li>
<a href="http://courses.peoples-uni.org/course/support_posts.php" target="_blank">http://courses.peoples-uni.org/course/support_posts.php</a> also includes various filters.
</li>
<li>
Access to support_posts.php is available to any Tutor, Student coordinator or Admin.
</li>
</ol>


<a name="studentenrolments"></a>
<h2>Student Enrolments and Grades</h2>
<ol>
<li>
"Course Grades" at the following URL <a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> shows details about all enrolments (by default for the current semester).
</li>
<li>
For each enrolment it shows the following...<br />
Semester<br />
Module<br />
Family name (with link to Student Profile)<br />
Given name (with link to Student Profile)<br />
Username<br />
Last access, this can be very useful to see if a student is active. Also displayed here is whether the student was un-enrolled and whether the student was re-enrolled in same module for a future semester.<br />
Grade for Module (and category: Passed 45+, Passed 50+, Failed, not set yet).<br />
Has the student been informed of their grade? (by student.php, see below)<br />
A link to "Student Grades" (student.php) with all the details for the student, from this the tutor can select assignments and grade them, I think this could be very useful as a way of quickly rectifying missing grades.<br />
A link to the "Student Submissions" page<br />
A link to the (student's) Moodle Grade report (gives a subset of the "Student Grades" link, but also gives direct access to Moodle Grade UI)<br />
</li>
<li>
To make use of this page easier there are filters...<br />
Select one Module rather than all<br />
Select by Grading Status:<br />
 - Passed 45+,<br />
 - Passed 50+,<br />
 - Failed,<br />
 - Did not Pass (i.e. Failed or not graded)<br />
 - No Course Grade<br />
 - Un-Enrolled<br />
 - Not informed of Grade and Not Marked to be NOT Graded<br />
 - Will NOT be Graded, because they did Not complete<br />
 - Will NOT be Graded, because of Exceptional Factors<br />
 - Will NOT be Graded, but will get a certificate of participation<br />
 - Will NOT be Graded, because they did Not Pay.<br />
(The above are mostly set in "Student Grades" (student.php), see below)<br />
Select by Semester (defaults to current Semester, can also view All Semesters if you want)<br />
Sort by Last Access<br />
Show Students Not Logged on for this many Days (if set to a specific number of days, this can be used to select only students who have not logged on for that number of days or more. With those students selected it is possible to send a reminder e-mail to them at the bottom of the "Course Grades" page.)<br />
Show "Payment up to date?" Status... This is typically used to see if a student has paid before they are notified of grading.<br />
Show MPH Only.<br />
Select by Student Support Group.
<br />
</li>
<li>
You can also get to this page from student.php and indirectly from applications.php and app.php
</li>
<li>
As a little extra it generates a list of the e-mails of all students meeting the filter criteria which can be used for a mailshot.
</li>
<li>
As another extra it generates the same statistics as are generated in applications.php for all students meeting the filter criteria. The statistics generated are:<br />
 - By Gender<br />
 - By Year of Birth<br />
 - By Country
</li>
<li>
After this there are links to the...<br />
<a href="http://courses.peoples-uni.org/course/successbyqualifications.php" target="_blank">Success by Qualifications Report</a><br />
<a href="http://courses.peoples-uni.org/course/discussionfeedbacks.php" target="_blank">Discussion Feedback to Students</a><br />
<a href="http://courses.peoples-uni.org/course/list_of_mph_graduates.php" target="_blank">List of MPH Graduates</a><br />
</li>
<li>
At the bottom of the page, there are two forms to send e-mails to all the above students (those that are selected by the filters). The two sets of default wording are set in <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a>.<br />
The first form is typically used to send students a reminder of the their Application ID/SID.<br />
The second is typically used to send students a reminder that they have not logged on to Peoples-uni since the start of the Semester. But to do this correctly (i.e. select the appropriate students to send this e-mail to), it is necessary to set the "Show Students Not Logged on for this many Days" filter at the top of the page to an appropriate number of days before sending the e-mail.
</li>
<li>
"Course Grades" is fully only available to any Tutor or Admin (a user with the "Lurker" role, actually system wide "moodle/grade:viewall", can view but not perform any actions). None of this is visible to students; all they see is their own academic transcript in student.php.
</li>
</ol>


<a name="informing"></a>
<h2>Informing Students of Semester Final Grade Results</h2>
<ol>
<li>
From "Course Grades" at <a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> you can select "Student Grades" to see the grades received by a given Student for all that Student's modules along with feedback from the Tutor for all assignments.
</li>
<?php
//<li>
//I have repeated some text here that was written above to clarify one setting that affects what happens when the grade for the final assignment in a course it entered in the Moodle Grade Report...<br/>
//<i>For each course, go into the final assignment for the course, Select "Update this Assignment"... Set "Stop all student e-mail notifications" to "Yes". This will mean that no e-mails for the final assignment will go out to students. The idea is that we do not want students to be notified about the grade of their final assignment and the feedback until this is agreed. Note the final assignment mark will normally be used to (manually) set the overall course total grade of Passed or Failed for the course module.
//<br />
//There may be various processes around the final grading for a course module, but if a process is followed that wants to avoid students being notified about their final assignment grades, then this setting should be set to "Yes". However there is nothing to stop students looking at their grade if it has been entered, even if they are not notified.</i>
//</li>
//So...
?>
<li>
Note... The Moodle "Course Total" grade (which is what is displayed and used in "Course Grades"/"Student Grades") is based on the grades for the course assignments. It is calculated automatically by Moodle when the course assignment grades are entered (according to the calculation specified for the specific course as described in <a href="http://courses.peoples-uni.org/course/admin_documentation.php#configuration">Configuration of Applications Process for a new Semester</a>).
<?php
//The "Course Total" grades for each course should be set by the tutor. This is done in the Moodle grade report for the course... turn editing on and set the course total grades (on far right) to Passed/Failed or No Grade.
?>
</li>
<li>
After that diversion... Back to "Course Grades"/"Student Grades"... Go to: <a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> and click on "Student Grades" for an individual student.
</li>
<li>
There are a number of buttons for each course module in "Student Grades" which can be pressed (not visible to a student when they see their own version of this page). Not all will be visible at any one time...
</li>
<li>
"Mark Grading Complete and Notify Student: They Failed (xx%)"... an e-mail is sent to the student with a link to a student version of this same page which shows the final marking and comments. However you obviously need to make sure that the "Course Total"/"Overall Module Grade" has been set to the correct value before pressing this button.
</li>
<li>
"Mark Grading Complete and Notify Student: They Passed Diploma Level (xx%)"... an e-mail is sent to the student with a link to a student version of this same page which shows the final marking and comments. However you obviously need to make sure that the "Course Total"/"Overall Module Grade" has been set to the correct value before pressing this button. The student will be able to download an academic transcript PDF file further down this same page for all course modules that they have passed. (Tutors and Admins will also be able to download the student's transcripts also.)
</li>
<li>
"Mark Grading Complete and Notify Student: They Passed Masters Level (xx%)"... an e-mail is sent to the student with a link to a student version of this same page which shows the final marking and comments. However you obviously need to make sure that the "Course Total"/"Overall Module Grade" has been set to the correct value before pressing this button. The student will be able to download an academic transcript PDF file further down this same page for all course modules that they have passed. (Tutors and Admins will also be able to download the student's transcripts also.)
</li>
<li>
"Click to indicate Student will NOT be Graded, because they did Not Complete"... to be used if someone did not complete the semester. This will be shown on the coursegrades.php report (and successbyqualifications.php).
</li>
<li>
"Click to indicate Student will NOT be Graded, because they did Not Pay"... to be used if someone did not finally pay by the end of the semester and we do not wish them to get any certificate for the course... This will be shown on the coursegrades.php report (and successbyqualifications.php).
</li>
<li>
"Click to indicate Student will NOT be Graded, because of Exceptional Factors"... to be used if someone was excused from taking the module in this semester (note that there is an MMU process for "Exceptional Factors")... This will be shown on the coursegrades.php report (and successbyqualifications.php).
</li>
<li>
"Click to indicate Student will NOT be Graded, but will get a 'Certificate of Participation'"... to be used if someone is on the CPD stream and you only want to give them a certificate of attendance and not academic transcripts counting towards a certificate/diploma. This will be shown on the coursegrades.php report (and successbyqualifications.php). Additionally, the person will get an e-mail telling them the Certificate of Participation is available. And finally they (or you if you want to for some reason) can download the Certificate of Participation from "Student Grades"/student.php.
</li>
<li>
Additionally if the student has met the criteria for receiving a Certificate (3 modules passed 50%+) or Diploma (6 modules passed 50%+, 2 of each type) from Peoples-uni. They will be able to download them here.<br />
Note: one Diploma pass (45%+) will be automatically allowed ("condoned") in place of one Masters pass (50%+).<br />
Note: After 10 elapsed semesters, module passes for subsequent semesters are no longer counted (but see <a href="http://courses.peoples-uni.org/course/admin_documentation.php#progress">Student Progress towards Qualifications</a> for a discussion of how this can be overridden using a link "Review modules contributing to awards and override disallowed modules" just below the certificates).<br />
Note: After 2 module failures (i.e. a maximum of 1 failure is allowed), module passes are no longer counted (but see <a href="http://courses.peoples-uni.org/course/admin_documentation.php#progress">Student Progress towards Qualifications</a> for a discussion of how this can be overridden using a link "Review modules contributing to awards and override disallowed modules" just below the certificates).<br />
Note: that academic transcripts and Diploma (& Certificate) certificates now contain a percent grade for each module. It is possible to suppress the display of percentages for a transcript by adding "&nopercentage=1" to the end of the URL of the transcript.
</li>
<li>
Additionally if the student has any "Peoples-uni Record Files" there will be a link to a page that lists all of these files and will allow the student to download the files.<br />
These files would typically be some type of certificate or transcript that is additional to the Peoples-uni ones. One example is MMU Transcripts. But it could be any file we wish to permanently keep for the student (both for the student to access at any time and also as a permanent record for us).<br />
A Moodle user with the "Manager" role will have a link ("Manage Peoples-uni Record Files for the Student") in this same place in student.php which will bring them to a page similar to that of the student which contains the same files but also allows uploading of new files for the student ("Add...").<br />
It is possible create folders ("Create folder") and navigate to and put files into these folders if desired.<br />
Note that the files can be uploaded from a number of sources, but the most likely usage will be "Upload a file" from the Manager's own computer. An e-mail will be sent to the Student informing them of the new files (this can be edited) if any new files are added or changed. Also note that the files will not be permanently saved into Moodle until "Save changes" is clicked.
</li>
<li>
Other options on this page are:<br />
To send another e-mail to the student: "e-mail Student",<br />
Add a note to the student record (see also the <a href="http://courses.peoples-uni.org/course/admin_documentation.php#thedetailsbutton">details button/page</a>), or<br />
Look at "Student Submissions".<br />
Note that the student's most recent approved SID/Application ID/Registration Number is shown near the top of "Student Grades" and a student may be directed here to find their most recent SID.<br />
To "Mark this Student as Graduated with MPH", set the Semester in which the Student Graduated with MPH, the type of pass and click the button. A list of those Graduated is in <a href="http://courses.peoples-uni.org/course/list_of_mph_graduates.php" target="_blank">http://courses.peoples-uni.org/course/list_of_mph_graduates.php</a> as noted above.
</li>
</ol>


<a name="progress"></a>
<h2>Student Progress towards Qualifications</h2>
<ol>
<li>
To see how our students are progressing towards Certificates and Diplomas go to <a href="http://courses.peoples-uni.org/course/studentprogress.php" target="_blank">http://courses.peoples-uni.org/course/studentprogress.php</a>.<br />
It is ordered with the the student who has passed the most modules at top.
</li>
<li>
It has the following columns...<br />
Family name<br />
Given name<br />
Last access (elapsed time for all modules) [elapsed time is the total number of elapsed semesters that the student studied (or is still studying) with Peoples-uni]<br />
# Passed @Masters (@Diploma) [number of modules passes at Masters (or Diploma) level, but excluding those that should be discounted because of academic rules (maximum of 10 semesters to date, maximum of 1 fail to date, maximum of 3 unfinished modules); a note of any Masters level passes that are actually pre-percentage is made]<br />
Passed [includes the list of modules they have passed (Course Codes)]<br />
# Foundation [the number of "Foundation Sciences" modules passed]<br />
# Problems [the number of "Public Health Problems" modules passed]<br />
Qualification [shows whether they have qualified for a Diploma, a Certificate or nothing so far]<br />
"Student Grades"<br />
"Mark Discounted Modules" [see next bullet point for the link, if there are any that have been discounted, this is noted here]<br />
</li>
<li>
The link "Mark Discounted Modules" or "Review modules contributing to awards and override disallowed modules" (from "Student Grades") brings up a page (allow_modules.php) which contains details of all Modules attempted by the student.<br />
It contains the type of pass or fail or various types of non-grading.<br />
For each module that has been discounted because of academic rules (maximum of 10 semesters to date, maximum of 1 fail to date, maximum of 3 unfinished modules), there is a checkbox that can be checked (or unchecked if desired) to indicate that the module should not be discounted (i.e. will count towards a Diploma etc.). There is a submission button "Mark Modules that Should be Discounted (or not)" that should be clicked when the checkboxes have been set appropriately to update discounted modules.
</li>
</ol>


<a name="education_committee_report"></a>
<h2>Education Committee Report</h2>
<ol>
<li>
A report for the use of the Education Committee is at <a href="http://courses.peoples-uni.org/course/education_committee_report.php" target="_blank">http://courses.peoples-uni.org/course/education_committee_report.php</a>.
</li>
<li>
Access to <a href="http://courses.peoples-uni.org/course/education_committee_report.php" target="_blank">http://courses.peoples-uni.org/course/education_committee_report.php</a> is given by the System-wide "Manager" or "Administrator" roles. Both have the permission: moodle/site:viewparticipants.
</li>
<li>
There are filters at the top of the report which...<br />
Set the Semester for the Report. The report will include students registered in that Semester but includes all the enrolments up to and including that Semester for those students.<br />
Set the Last Exam Board date. This ensures students with resubmissions since that date are included even is the student is not enrolled in the current semester.<br />
There is a filter by the student's MPH status, if it is desired to include/exclude those students.<br />
There is a "Has Diploma?" filter which allows excluding students without six passes of some sort whether notified or not ("Has 6 Passes") or separately without a Diploma ("Has Diploma").<br />
There is a "Dissertation Grade available?" filter which allows excluding students who do not yet have a grade for their dissertation (whether notified or not).
</li>
<li>
It is also possible to display the standard colums in a clean format suitable for Excel by clicking "Display for Copying and Pasting to Excel" and then "Apply Filters".
</li>
<li>
The report has the following columns...<br />
"Student Number" (Moodle user ID)<br />
"Family name"<br />
"Given name"<br />
One column for each module. In this column, the semester that the student took the module is indicated (possibly more that one) along with the grade. Additionally, the following notes may be included: "Unenrolled", "Not Notified"(not confirmed), "Not Graded, Not Complete", "Participation/CPD", "Not Graded, Did Not Pay" or "Not Graded, Exceptional Factors". If there is no grade and no other indication is given, then just the semester is indicated.<br />
A spare column<br />
The "MPH Status changes" column contains MPH status and changes of status along with dates.<br />
The "Notes" column contains Semester in which the student started and all student notes with dates. It also contains, if the "Has Diploma?" filter is used, an indication that the student has a Diploma<br />
"Recommendations" column is empty for use by the committee.
</li>
<li>
Note when exported to Excel, the notes will not be explicitly on separate lines as Excel Cut and Paste does not like line breaks. A semicolon indicates each line.
</li>
</ol>


<a name="statistics"></a>
<h2>Statistics on Success of Students by Qualifications on Entry</h2>
<ol>
<li>
Analysis of grades versus other characteristics (e.g. qualifications on entry, number of postings and initial goals) can be found using <a href="http://courses.peoples-uni.org/course/successbyqualifications.php" target="_blank">http://courses.peoples-uni.org/course/successbyqualifications.php</a>
</li>
<li>
There you will see (at the bottom of the page), a breakdown of qualifications and employment. Above this the page lists qualifications and employment per person. Note, only students for which we have this data are displayed and counted (some early application forms did not have this data).
</li>
<li>
To actually see this data for those that either Passed 50+, Passed 45+, Failed or who were Not Graded etc. only, you can set the filters to just select students with that type of grade. Obviously you would want to wait for grading to be complete for the semester you are interested in.
</li>
<li>
There are also filters that limit scope to e.g. one module, by whether the student has been accepted into MPH (and, if desired, during which period they were accepted) etc.
</li>
</ol>


<a name="creatingcertificates"></a>
<h2>Creating Certificates for Peoples-uni Volunteers</h2>
<ol>
<li>
Go to <a href="http://courses.peoples-uni.org/course/listcertificates.php" target="_blank">http://courses.peoples-uni.org/course/listcertificates.php</a> and you will see a list of volunteer certificates sorted by first name of the person that was given the certificate.
</li>
<li>
You can edit an existing certificate by pressing "Edit".
</li>
<li>
At the bottom you can click "Create New Certificate" to create a new certificate.
</li>
<li>
Enter a name in the name field.
</li>
<li>
Change the other text as you wish.
</li>
<li>
Optionally select the checkbox to indicate this should use WikiTox signatures and images.
</li>
<li>
Press Create New Certificate... you will be brought to an updated version of the page where you can edit the certificate.
</li>
<li>
There is a link for preview of the certificate at the top of the page.
When you close the certificate (or before), you will see the original page and you can change the wording if you were not happy with it and then press "Update Certificate".
</li>
<li>
However if you want to continue on and use more or less the same certificate (just changing the name say) for someone else, then edit the name and click "Create New Certificate". In each case remember to cut and paste the link for the Certificate Recipient (see next bullet point) before going on to create a new one.
</li>
<li>
The EXACT link that should be sent to recipients for them to retrieve the certificate is detailed near the bottom of the page. You can send that link to any person you wish to see and print the certificate. (There is currently nothing to stop anyone seeing anyone else's certificate.)
</li>
<li>
You can also list all certificates with the "List All Certificates" link.
</li>
</ol>


<a name="studentaccount"></a>
<h2>Page to allow a Student to see their Payment Account</h2>
<ol>
<li>
<a href="http://courses.peoples-uni.org/course/account.php">http://courses.peoples-uni.org/course/account.php</a> allows a student to see their account, it is no direct use to staff (see "Update Payment Amounts, Method or Confirmed Status"/payconfirm.php in <a href="http://courses.peoples-uni.org/course/admin_documentation.php#thedetailsbutton">The "Details" button and the Approval Process</a> for a staff view on these data).
</li>
<li>
It shows:-
<br />Whether they are enrolled in MPH.
<br />All their payment account transactions.
<br />Their instalment payment schedule, if any.
</li>
</ol>


<a name="specifyinstalments"></a>
<h2>Specify Instalment Payment Schedule</h2>
<ol>
<li>
This is used for the student to specify an instalment payment schedule for themselves. It can also be used (via a link in payconfirm.php) by staff to specify or change an instalment payment schedule. The student is only allowed do this once, after that it can only be changed by staff. The student should be/will be notified of the page to use for this in their approval e-mail.
</li>
<li>
There can be any number up to four instalments starting from the current semester. There can be no gaps (a semester with a zero instalment between non-zero instalments). Any instalment must be at least 25% of the total owed.
</li>
<li>
The total owed will be taken from student's payment account balance, so that will need to be correct.
</li>
<li>
The page indicates that the deadline for payment is either 1st of April or October, although we do not enforce that (we continue to take payments after that.).
</li>
<li>
Elsewhere in the software when payment is being asked for, the amount being asked for will be increased to include a new instalment for the upcoming semester whenever January 1st or July 1st is reached. So if a student is very late in paying the instalment due on, say Oct 1st, and they go to pay in the following January, they will be asked for the instalment due on October 1st AND any instalment due on April 1st following.
</li>
<li>
It will be possible to see on the page who has specified the instalment schedule (student or staff member).
</li>
</ol>


<a name="sendingdiscussion"></a>
<h2>Sending Discussion Feedback to Students</h2>
<ol>
<li>
Student coordinators need to send feedback (in an e-mail) to a student in a module on whether they have meet the criteria on contribution to discussions specified in the <a href="http://peoples-uni.org/content/discussion-contributions" target="_blank">Student Handbook: Discussion contributions</a><br />
They should now do that using <a href="http://courses.peoples-uni.org/course/posts.php" target="_blank">http://courses.peoples-uni.org/course/posts.php</a><br />
<br />
</li>
<li>
But for this to happen successfully, each Discussion Forum that needs feedback should be configured by Technical Support to have the appropriate rating scales.<br />
In Forum Settings for all the relevant forums, in the "Ratings" Section...<br />
The "Aggregate type" should be set to "Average of ratings" and <br />
the "Scale" should be set to "Scale: Referred to resources"<br />
This specific scale must be used as it is the one that triggers the two other necessary scales to be silently added also ("Critical approach" and "Referencing")<br />
This particular scale should be used only in Forums (not in other places that scales can be used).<br />
<br />
</li>
<li>
Tutors are expected to use these three scales to rate relevant Student Posts (not all will need to be rated). More than one Tutor can rate the same Post and they will be averaged, but is expected that normally only one Tutor will rate each post.<br />
The Ratings that the Tutors will be able to select are for each of the 3 Scales...<br />
For Scale "Referred to resources":-<br />
Referred to resources: No<br />
Referred to resources: Some<br />
Referred to resources: Yes<br />
<br />
For Scale "Critical approach":-<br />
Critical approach: No<br />
Critical approach: Some<br />
Critical approach: Yes<br />
<br />
For Scale "Referencing":-<br />
Referencing: None<br />
Referencing: Wrong format<br />
Referencing: Good<br />
<br />
Students will only see ratings for their own posts, not the ratings for other Student's Posts.<br />
Ratings will appear in a Student's Grade Book.<br />
There is also a link "Notes" on the right hand side of the ratings which gives Tutors a quick link to the Moodle Notes for a Student.<br />
<br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/posts.php" target="_blank">http://courses.peoples-uni.org/course/posts.php</a> has 3 new columns with the (averaged if more than one Tutor rated) value of each of the 3 ratings for each Student Post (or "Not rated").<br />
<br />
</li>
There is a fourth new column "Write discussion feedback for student..." which is colour coded to indicate if the student has been sent Discussion Feedback for the Module containing the Discussion Post. It is coloured Green/Yellow/Red, if feedback has been sent.<br />
Green indicates the Feedback was completely "Good" (for that course).<br />
Red indicates the Feedback was completely "Bad" (for that course).<br />
Yellow indicates the Feedback was mixed.<br />
<br />
When this column entry is clicked for a Post, a page is brought up which allows Feedback to be recorded and sent (by e-mail) to a Student for Discussion contributions to any of the (individual) Courses that the Student is taking this Semester.<br />
There are 3 criteria (that match the 3 ratings) that must be selected as "Yes", "No" or "Could be improved"<br />
As well as the criteria, there is an optional free form field which, if present, will be added to the e-mail after the criteria feedback.<br />
Note: It is possible to re-submit and e-mail again and overwrite the recorded submission.<br />
<br />
The data (criteria and free form text along with Student reflection on this feedback if provided) are stored for later analysis and can be accessed again from <a href="http://courses.peoples-uni.org/course/posts.php" target="_blank">http://courses.peoples-uni.org/course/posts.php</a> (via "Write discussion feedback" link). A spreadsheet with feedback/reflection data for all Students is displayed in the "old" Discussion Feedback page at <a href="http://courses.peoples-uni.org/course/discussionfeedbacks.php" target="_blank">http://courses.peoples-uni.org/course/discussionfeedbacks.php</a> where a list of e-mails of Students sent feedback can also be seen.<br />
<br />
The wording for the e-mail is specified in <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a><br />
The e-mail text should give a link to a form which will allow Students to submit reflections on their discussion contributions. This link is
http://courses.peoples-uni.org/course/ratingresponse.php?course_id=IDHERE<br />
There should be appropriate instructions about filling out the form.<br />
The form contains the following fields...<br />
What skills do I need to improve? (think about feedback I received in the e-mail on my contributions and from tutor/other student posts)<br />
What will I do to improve my academic skills? (and when?)<br />
What will I do differently when I prepare a discussion post?<br />
Here is an example of an e-mail that is sent out (including wording from settings.php, the criteria feedback, free form text placed after the criteria feedback and the rest of the settings.php text):-
<pre>
Dear Alan,

This is to provide feedback to you about your contributions to the
discussion forums in each of the Topics in the module.
As you will know from the section in the Student Handbook
http://peoples-uni.org/content/discussion-contributions

contributions to the discussion forums should “show reflection
and critical thought, and understanding of relevant literature.
You should include reference to your own experience,
to the resources in the module, and give a reference to a
published paper or web site”. This is not only to help with your
learning, but also “help prepare for the assignment –
the unit assignment requires you to answer questions relating to the
information presented as relevant to the learning objectives,
as well as to take a critical approach to the information and to
support your answer with references”.
*Please note: as in the assignments, it is important that you
acknowledge any items you use in the discussions which are taken
from the work of others. If you copy and paste from another source,
you must acknowledge the source and reference it*.
*It is always better to use your own words anyway!*

I have had a look at your discussion contributions, and here are my
comments on whether you meet the following Criteria...

Referred to resources in the topics: Yes

Included critical approach to information: No

Provided references in an appropriate format: Could be improved

anything


Please reflect on this feedback and then fill in this form
with your reflections (you will need to login to Moodle):
http://courses.peoples-uni.org/course/ratingresponse.php?course_id=326

There are some helpful resources on how to carry out referencing in
the Student Handbook and also in the Student Corner - such as the
tutorial from Monash University:
http://www.lib.monash.edu.au/tutorials/citing/index.html

We usually recommend using the Harvard system of referencing, and
here is the link to a tutorial on this from Nottingham University -
Referencing your work with Harvard:
http://equella.nottingham.ac.uk/uon/items/9ba73656-1729-2453-d9eb-6fd932a12753/1/ViewIMS.jsp

(Note you might have to refresh that page to get it to display properly)
However, the Vancouver style is also frequently used in the medical
scientific literature. There is information on critical thinking in
the Student Corner "How can I develop my Critical Thinking skills?":
http://courses.peoples-uni.org/mod/page/view.php?id=11321

We will be sending information on the number of posts you have made
to the discussions in comparison with others on your module at a
later stage.

The discussion forums do remain open, even after the end of the time
period for each Topic, so you can post something to them late if you
have been away.

Please note that contributions to the Student Corner do not count
for credit – the Student Corner is for discussions amongst the
students on common problems and interests (there have been some
very interesting issues discussed so far so please keep this up if you
find it useful, but do not forget to keep to the spirit of the
Peoples-uni in the need for evidence rather than just opinion!).

Best wishes.

    Alan Barrett
</pre>
<br />
At the top of the Feedback page all existing Postings with Ratings and existing Feedback (with Student reflection on this feedback if provided) is displayed in tables to assist in determining the Student's progress.<br />
<br />
</li>
<li>
As indicated in the same e-mail above, there is a link e.g. http://courses.peoples-uni.org/course/ratingresponse.php?course_id=326 which is sent out to students to allow them to submit reflections on the discussion feedback that they have been given. At the bottom of this page the student will be able to see all discussion feedback they have been given (one per Module) along with their reflections on this feedback (if any). This link can be sent out without a course_id parameter i.e.<br />
<a href="http://courses.peoples-uni.org/course/ratingresponse.php">http://courses.peoples-uni.org/course/ratingresponse.php</a><br />
This page will not have the form, but it will have all the discussion feedback with reflections (if any). Any missing reflections will have a link "Click here to add your reflections", which if clicked will bring the student to the form to add their reflections.<br />
<br />
</li>
<li>
There are a number of filters in posts.php added to allow searching for Students with issues or otherwise. This can obviously be combined with the existing filters such as by Student Support Group. Students can also be looked at over multiple Semesters. Filters are...<br />
<br />
Student has less that a number of posts matching the filter<br />
<br />
Ratings for Post, Referred to resources: Not rated (checkbox)<br />
Ratings for Post, Referred to resources: No (checkbox)<br />
Ratings for Post, Referred to resources: Some (checkbox)<br />
Ratings for Post, Referred to resources: Yes (checkbox)<br />
Ratings for Post, Critical approach: Not rated (checkbox)<br />
Ratings for Post, Critical approach: No (checkbox)<br />
Ratings for Post, Critical approach: Some (checkbox)<br />
Ratings for Post, Critical approach: Yes (checkbox)<br />
Ratings for Post, Referencing: Not rated (checkbox)<br />
Ratings for Post, Referencing: None (checkbox)<br />
Ratings for Post, Referencing: Wrong format (checkbox)<br />
Ratings for Post, Referencing: Good (checkbox)<br />
<br />
Average Rating of Rated Posts, Referred to resources: ("Any", "No", "Mixed", "Yes")<br />
Average Rating of Rated Posts, Critical approach: ("Any", "No", "Mixed", "Yes")<br />
Average Rating of Rated Posts, Referencing: ("Any", "None", "Mixed", "Good")<br />
<br />
</li>
<li>
There are new summary tables in posts.php...<br />
Summary 'Referred to resources' for Student<br />
Summary 'Critical approach' for Student<br />
Summary 'Referencing' for Student<br />
Summary 'Referred to resources' for Student per Module<br />
Summary 'Critical approach' for Student per Module<br />
Summary 'Referencing' for Student per Module<br />
<br />
</li>
<li>
And to allow sending general messages to filtered groups of Students there is a listing close to the end of the page of all Student e-mails matching the selected filters.
</li>
</ol>


<a name="sendingdiscussionold"></a>
<h2>Sending Discussion Feedback to Students (old method which still works, but has been superceded by one above)</h2>
<ol>
<li>
<a href="http://courses.peoples-uni.org/course/discussionfeedback.php" target="_blank">http://courses.peoples-uni.org/course/discussionfeedback.php</a> is a form used by Student coordinators to send feedback (in an e-mail) to a student in a module on whether they have meet the criteria on contribution to discussions specified in the <a href="http://peoples-uni.org/content/discussion-contributions" target="_blank">Student Handbook: Discussion contributions</a>
</li>
<li>
The Student coordinator will need to specify the module (submit the form) and then select individual students (submitting the form again for each student) to give feedback. As well as the criteria, there is an optional free form field which, if present, will be added to the e-mail after the criteria.
</li>
<li>
It is indicated in the form whether the form has already been submitted for each student, but it is possible to re-submit and e-mail again and overwrite the recorded submission.
</li>
<li>
There is a link close to the top of the form to allow resetting the module when/if is desired to move to a new module for feedback to students in that module.
</li>
<li>
The data (criteria and free form text) are stored for later analysis and displayed in <a href="http://courses.peoples-uni.org/course/discussionfeedbacks.php" target="_blank">http://courses.peoples-uni.org/course/discussionfeedbacks.php</a>
<br />A list of e-mails of Students sent feedback can also be seen here.
</li>
<li>
Filters can be used to limit what is displayed on that page.
</li>
<li>
There is also a link back to the <a href="http://courses.peoples-uni.org/course/discussionfeedback.php" target="_blank">http://courses.peoples-uni.org/course/discussionfeedback.php</a> form on that page.
</li>
<li>
<a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> also contains a link to that page.
</li>
<li>
The wording for the e-mail is specified in <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a>
</li>
<li>
The part about Student Posts in <a href="http://courses.peoples-uni.org/course/admin_documentation.php#tracking">Viewing Student Submissions & Re-Submissions, Grades & Comments, Student Posts, Tutor Posts and Student Support Forum Posts</a> will be useful to see what students have posted.
</li>
</ol>


<a name="cleanstudentcornersubscriptions"></a>
<h2>Cleaning out old Discussion Forum Subscriptions in Students Corner</h2>
<ol>
<li>
<a href="http://courses.peoples-uni.org/course/clean_studentscorner_subscriptions.php" target="_blank">http://courses.peoples-uni.org/course/clean_studentscorner_subscriptions.php</a> is a page used to Clean out old Discussion Forum Subscriptions in Students Corner.
<br />It is possible to visit the page without causing any changes as long as the form is not submitted.
</li>
<li>
Access to <a href="http://courses.peoples-uni.org/course/clean_studentscorner_subscriptions.php" target="_blank">http://courses.peoples-uni.org/course/clean_studentscorner_subscriptions.php</a> and the Details for each student are given by the System-wide "Manager" or "Administrator" roles. Both have the permission: moodle/site:viewparticipants.
</li>
<li>
When the page is brought up a table will be displayed "Student Subscriptions that will be Removed (and remembered for later)..." showing those forum subscriptions in Students Corner that will be removed if the form is submitted.
</li>
<li>
The table shows all those subscriptions to forums in Students Corner which<br />
a) are not "forced subscription" and<br />
b) the subscriber does not have any role other than Student (we do not want to remove Tutors or Viewer etc.) and<br />
c) the subscriber is not enrolled in current Semester and<br />
d) the subscriber has not accessed Moodle within the last two months.<br />
</li>
<li>
When the button "Remove old Discussion Forum Subscriptions in Students Corner" is clicked these subscriptions are removed (in order to cut down on unwanted e-mail that annoys currently inactive students).
</li>
<li>
However a record is kept of the subscriptions and if the student is enrolled in any module in the future, the subscriptions are reinstated.
</li>
<li>
Digest subscriptions are not removed by this page as there seems to be little or no use except by tutors (and as of testing time one student who's digest subscriptions would not be removed because he was currently active).
</li>
</ol>


<a name="resetstudentcornersubscriptions"></a>
<h2>Determining if Student Support Forum Subscriptions in Students Corner have changed and Changing Back</h2>
<ol>
<li>
<a href="http://courses.peoples-uni.org/course/reset_studentscorner_subscriptions.php" target="_blank">http://courses.peoples-uni.org/course/reset_studentscorner_subscriptions.php</a> is a page used to Determine if Student Support Forum Subscriptions in Students Corner have changed and change back those that need to be.
<br />It is possible to visit the page without causing any changes as long as the form is not submitted.
</li>
<li>
Access to <a href="http://courses.peoples-uni.org/course/reset_studentscorner_subscriptions.php" target="_blank">http://courses.peoples-uni.org/course/reset_studentscorner_subscriptions.php</a> is given by the System-wide "Manager" or "Administrator" roles. Both have the permission: moodle/site:viewparticipants.
</li>
<li>
A table is displayed. For each Student (not Tutor or Viewer etc.) who has Student Support Forum Subscriptions (or should have) and the actual subscriptions do not match the expected subscription, a line in the table is displayed.
</li>
<li>
Each line contains...<br />
The Student's name<br />
A column with a list of "Original Forum Subscriptions" and a checkbox which should be checked if these are still valid and the actual subscriptions should be Changed back to these original subscriptions.<br />
Another column with "Changed Forum Subscriptions" and a checkbox which should be checked if these new changed subscriptions are now valid (the Student needed to change Support Group) and the "Original Forum Subscriptions" should be changed to match these new changed subscriptions.
</li>
<li>
Note that the "Original Forum Subscriptions" are recorded when a student is initially registered (there will only be one initially).
</li>
<li>
Note there can be multiple subscriptions in each column and some of the subscriptions in the second column could be recorded subscriptions as described in <a href="http://courses.peoples-uni.org/course/admin_documentation.php#cleanstudentcornersubscriptions">Cleaning out old Discussion Forum Subscriptions in Students Corner</a>.
</li>
<li>
When the button "Change Back Subscriptions (or keep them) based on checkboxes above" is clicked the desired changes are made based on the checkboxes (if any) selected.
</li>
</ol>


<?php
echo $OUTPUT->footer();


function is_peoples_teacher() {
  global $USER;
  global $DB;

  /* All Teacher, Teachers...
  SELECT u.lastname, r.name, c.fullname
  FROM mdl_user u, mdl_role_assignments ra, mdl_role r, mdl_context con, mdl_course c
  WHERE
  u.id=ra.userid AND
  ra.roleid=r.id AND
  ra.contextid=con.id AND
  r.name IN ('Teacher', 'Teachers') AND
  con.contextlevel=50 AND
  con.instanceid=c.id ORDER BY c.fullname, r.name;
  */

  $teachers = $DB->get_records_sql("
    SELECT DISTINCT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors', 'edu_officer', 'edu_officer_old') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', context_system::instance())) return true;
  else return false;
}
?>