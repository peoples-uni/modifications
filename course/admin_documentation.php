<?php  // $Id: admin_documentation.php,v 1.1 2009/11/07 17:21:00 alanbarrett Exp $
/**
*
* Administration Documentation for Peoples-uni
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_url('/course/admin_documentation.php');
$PAGE->set_pagelayout('standard');


require_login();
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$isteacher = is_peoples_teacher();
if (!$isteacher) {
	echo '<h1>You must be a teacher to do this!</h1>';
	notice('Please Login Below', "$CFG->wwwroot/");
}

$PAGE->set_title('Administration Documentation for Peoples-uni');
$PAGE->set_heading('Administration Documentation for Peoples-uni');
echo $OUTPUT->header();


?>
<h1>Applications, Approving, Payments, Enrolling, Grading and Certificates</h1>

<ul>
<b>
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
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#misc">Misc: Enrolling Tutors in Tutors Corner, Registering Interest in Future Semesters, Making a Donation</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#trackmarking">Collaborative Assignment Marking and Resubmission Tracking</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#tracking">Viewing Student Submissions & Re-Submissions, Grades & Comments, Student Posts and Tutor Posts</a><br />
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
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#statistics">Statistics on Success of Students by Qualifications on Entry</a><br />
</li>
<li>
<a href="http://courses.peoples-uni.org/course/admin_documentation.php#creatingcertificates">Creating Certificates for Peoples-uni Volunteers</a><br /><br />
</b>
</li>
</ul>


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
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> "Check to completely Remove from Forms" should be set for all the old courses from the previous semester and "Update Modules for Application Forms from list above" clicked.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> each new module has to be individually added by selecting the new module from the selection list (making sure it is the correct version of the module for the new semester). This selection is beside the "Add this Module to the list above:" button. When an individual module is selected then click "Add this Module to list above:", repeat this until the full set of modules for the new semester is listed.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> Click "Update Modules for Application Forms from list above".
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> enter a New Semester name like "Starting September 2009" and click "Open Application Forms & Set Current Semester to:". The application forms will be enabled. You can confirm that both of the forms have changed by looking at them (<a href="http://www.peoples-uni.org/forms/peoples-uni-course-application-form" target="_blank">http://www.peoples-uni.org/forms/peoples-uni-course-application-form</a> & <a href="http://www.peoples-uni.org/forms/application-form-returning-students" target="_blank">http://www.peoples-uni.org/forms/application-form-returning-students</a>). You will see the list of modules has changed.
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> select the new Students Corner module that will be used for student enrolments in the comming semester and then click "Make this Module the Students Corner for future enrolments:".
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the default Approval e-mail wording for dates and banking and then click "Set the above text as the New Students Approval e-mail wording (in Application Details/app.php)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

Your application to take the Course Module 'COURSE_MODULE_1_NAME_HERE'
COURSE_MODULE_2_TEXT_HEREhas been approved.
COURSE_MODULE_2_WARNING_TEXT_HERE

You will be sent your account Username and Password in a separate email
along with the address of the web site (URL) you will use to login.
You will also receive a welcome email for each course module giving
the course module URL and the URL for your profile.
We will send you all these details on the first day of the course
orientation week September 20th 2010.

Please see the course timetable at:
http://www.peoples-uni.org/book/course-dates-2010

Please go to 'Are you ready for Peoples-uni?' which you will find at
http://courses.peoples-uni.org/course/category.php?id=30

You will see that we ask you to send us an email to confirm that you
are ready to enrol. This is a requirement before you can enrol.

*** Payment will be required before enrolment on 20th of September.
The fees are £30 sterling if you have been approved for one course
module or £60 sterling if you have been approved for two modules.

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
When you have made the Bank Transfer you must then click on this web site
(URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.

IN NIGERIA in local currency, Naira
Please pay N9,000 for one course module or N18,000 for two into:
BANK NAME: Diamond Bank Plc.
Branch: Wuse II, Abuja
Account name: Datasphir Solutions Limited
Account number: 0412350001544
Please be sure to quote this number SID_HERE as a reference in
addition to giving your name on the lodgement docket.
When you have made the Bank Transfer you must then click on this web site
(URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.

AN ALTERNATIVE WAY, you can use MoneyGram to send money directly.
Please give the receiver's name as:
Professor Rajan Madhok,
People's Open Access Education Initiative,
Manchester UK.

If you do use this method, please let us know through
payments@peoples-uni.org and send us the payment reference number.

We look forward to your participation this semester, and hope that you
enjoy the experience and find it useful.

    Peoples Open Access Education Initiative Administrator.
</pre>
</li>
<li>
Similarly in <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the default RETURNING STUDENTS Approval e-mail wording for dates and banking and then click "Set the above text as the Returning Students Approval e-mail wording (in Application Details/app.php)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

Your application to take the Course Module 'COURSE_MODULE_1_NAME_HERE'
COURSE_MODULE_2_TEXT_HEREhas been approved.
COURSE_MODULE_2_WARNING_TEXT_HERE

You will receive a welcome email for each course module giving
the course module URL and the URL for your profile.
We will send you all these details on the first day of the course
orientation week September 20th 2010.

Please see the course timetable at:
http://www.peoples-uni.org/book/course-dates-2010

*** Payment will be required before enrolment on 20th of September.
The fees are £30 sterling if you have been approved for one course
module or £60 sterling if you have been approved for two modules.

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
When you have made the Bank Transfer you must then click on this web site
(URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.

IN NIGERIA in local currency, Naira
Please pay N9,000 for one course module or N18,000 for two into:
BANK NAME: Diamond Bank Plc.
Branch: Wuse II, Abuja
Account name: Datasphir Solutions Limited
Account number: 0412350001544
Please be sure to quote this number SID_HERE as a reference in
addition to giving your name on the lodgement docket.
When you have made the Bank Transfer you must then click on this web site
(URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.

AN ALTERNATIVE WAY, you can use MoneyGram to send money directly.
Please give the receiver's name as:
Professor Rajan Madhok,
People's Open Access Education Initiative,
Manchester UK.

If you do use this method, please let us know through
payments@peoples-uni.org and send us the payment reference number.

We look forward to your participation this semester, and hope that you
enjoy the experience and find it useful.

    Peoples Open Access Education Initiative Administrator.
</pre>
</li>
<li>
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the default batch reminder e-mail wording for dates and banking and then click "Set above text as Batch Reminder e-mail wording (in applications.php spreadsheet)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

We contacted you earlier indicating that your application to Peoples-uni
for this semester had been approved and giving payment options.

We have so far not received any indication of payment from you. If you have
only recently paid we may not have a record of that yet. However, if you
have not paid, we would like to remind you that
payment will be required before enrolment on 29th of March.

Your fees are £AMOUNT_OWED_HERE sterling.

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
When you have made the Bank Transfer you must then click on this web site (URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.

IN NIGERIA in local currency, Naira
Please pay N9,000 for one course module or N18,000 for two into:
BANK NAME: Diamond Bank Plc.
Branch: Wuse II, Abuja
Account name: Datasphir Solutions Limited
Account number: 0412350001544
Please be sure to quote this number SID_HERE as a reference in
addition to giving your name on the lodgement docket.
When you have made the Bank Transfer you must then click on this web site (URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.

ALTERNATIVE WAYS OF SENDING MONEY, Travellers Cheques or cash...
Buy a Travellers Cheque in Sterling, preferably drawn on a UK bank
(such as Visa, Mastercard or American Express).
Sign at the top and countersign at the bottom.
Make this payable to the Peoples Open Access Education Initiative.
Send it by registered mail to:
Peoples Open Access Education Initiative,
34 Stafford Road,
Ellesmere Park,
Manchester M30 9ED,
UK.
The amount should be 30 pounds for one module or 60 pounds for two modules.
Notify us of the number of the cheques and the number (or tracking code) of
the receipt you will have from the registered mail, by clicking on this
web site (URL):
http://courses.peoples-uni.org/course/paydetails.php?sid=SID_HERE

and fill in the form so we know about your payment.
(or send an e-mail to payments@peoples-uni.org )
Sterling travellers cheques come in either 20 pounds or 50 pounds,
so if you are enroling in only one module, you are better to send cash.
It is possible to send cash for two modules rather than a travellers cheque, but
make sure it is in sterling. Send it via registered mail and tell us as above.
(You might fold a piece of paper around the cash so that people cannot easily
see that cash is being sent!). The equivalent amount if you can only get
US dollars is $50 per module, but we would prefer sterling if possible.


Please e-mail payments@peoples-uni.org if you have a payment query or
experience any problems.

If you are unable to pay now, but would still like to take the course,
please send a message to payments@peoples-uni.org and tell us the reasons.
A limited number of scholarships are available, and it may also be
possible to delay payment until after the course has started.

We look forward to your participation this semester, and hope that you
enjoy the experience and find it useful.

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
In <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> edit the default Reply e-mail wording for when someone expresses an interest in Peoples-uni through the Drupal form that we will re-enable after applications close. Edit it for dates for the next semester after this and then click "Set above text as Reply e-mail wording for Expressions of Interest (in int.php)". Here is a sample of previous wording...
<br /><pre>
Dear GIVEN_NAME_HERE,

Thank you for sending an expression of interest to enrol on the next intake
in the Peoples-uni. The next intake will be in September 2010,
and we will contact you beforehand when we are open for enrolments.
In the meantime, you may want to look through the course module Foundations
of Public Health at http://courses.peoples-uni.org/course/view.php?id=53
which is freely available as an demonstration course module to show you
what a module looks like and to set the scene for you.
You may also want to look in detail through the particular parts of the
web site http://peoples-uni.org under the section 'Potential Students'.
You can also ask any question in the section marked 'Ask a Question'
under the 'Community' heading, and view the Frequently Asked Questions
(FAQ) on the top right hand corner of the site.

We look forward to seeing you on the course soon.

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
Temporarily disable this menu item from the Peoples-Uni front page: "Application Form: Expression of Interest" (<a href="http://www.peoples-uni.org/forms/application-form-expressions-interest-future-courses" target="_blank">http://www.peoples-uni.org/forms/application-form-expressions-interest-future-courses</a>).
</li>
<li>
Temporarily enable these two menu items: "Application form for new students" and "Application form for returning students" (<a href="http://www.peoples-uni.org/forms/peoples-uni-course-application-form" target="_blank">http://www.peoples-uni.org/forms/peoples-uni-course-application-form</a> & <a href="http://www.peoples-uni.org/forms/application-form-returning-students" target="_blank">http://www.peoples-uni.org/forms/application-form-returning-students</a>).
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
Mailshot potential new students (list of e-mails can be obtained from <a href="http://courses.peoples-uni.org/course/interest.php" target="_blank">http://courses.peoples-uni.org/course/interest.php</a>)
</li>
<li>
The Drupal form "Application Form: Expression of Interest" (<a href="http://www.peoples-uni.org/forms/application-form-expressions-interest-future-courses" target="_blank">http://www.peoples-uni.org/forms/application-form-expressions-interest-future-courses</a>) will also need to be edited for dates and also possibly new modules will need to be added.
</li>
<li>
In Grades... Report Settings... User Report... De-select "Show Percentage".  This should not have to be done each semester.
</li>
<li>
For each course make sure that in Grades... Choose an Action... Select Settings/Course, for the User Report set "Show Percentage" to "Hide" or "Default (Hide)". It might be this way already.
</li>
<li>
The Course Total Grade must be set to Pass/fail:<br />
For each course... Select Grades... Select an action: Categories and Items/Full View... Click the edit icon under actions in the pink module header line (above the individual grade or category lines) which brings you to "Edit category". This (should be) the Course Total grade which needs to be set to a scale of "Pass/fail" (you may have to set the Grade type to "Scale" first). The "Category name" and "Item name" will be blank, but that is OK. Note that the aggregation calculation is ignored due to a custom software patch for Peoples-uni... The course total is always set manually (to Passed or Failed).
</li>
<li>
Each course module needs to have the Block "Track Marking" added (on the bottom right hand side). This will allow teachers to access the Marking Spreadsheet see <a href="http://courses.peoples-uni.org/course/admin_documentation.php#trackmarking">Collaborative Assignment Marking and Resubmission Tracking</a>.
</li>
<li>
The following item should now NOT be done as we are in a transition to a process in which the grade will not be set until it has been fully agreed all markers and potentially the external examiner. So the setting "Stop all student e-mail notifications" should now be verified to be off. Here are the previous instructions...<br />
For each course, go into the final assignment for the course, Select "Update this Assignment"... Set "Stop all student e-mail notifications" to "Yes". This will mean that no e-mails for the final assignment will go out to students. The idea is that we do not want students to be notified about the grade of their final assignment and the feedback until this is agreed. Note the final assignment mark will normally be used to (manually) set the overall course total grade of Passed or Failed for the course module.
<br />
There may be various processes around the final grading for a course module, but if a process is followed that wants to avoid students being notified about their final assignment grades, then this setting should be set to "Yes". However there is nothing to stop students looking at their grade if it has been entered, even if they are not notified.
</li>
<li>
Note: At a later stage (when assignments are setup), all the assignments should be configured as the multiple file upload type "Advanced uploading of files". This is so students can have feedback on their submissions uploaded by the teacher as an annotated copy of the student's submitted file using "track changes". Also students will be able to resubmit assignments.
</li>
</ol>

<a name="dealingwithapplications"></a>
<h2>Dealing with Applications</h2>
<ol>
<li>
Go to <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a>. You can see a list of applicants for this semester.
</li>
<li>
It is possible to filter the applications by semester (if you do not just want the current semester), by approval/registration status, by date, by name or email, by payment status and by whether the student is a Re&#8209;enrolment or a New student. When you have selected your desired filters you should then click "Apply Filters". You may also "Reset Filters" to remove them.
</li>
It is also possible to display all the application data for each student in extra columns by clicking "Show Extra Details" and then "Apply Filters".
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
"Approved?", "Paid?", "Registered?", "Details", "Student Grades" and "Student Submissions" will be described later.
</li>
Statistics are displayed at the end of the page.
<li>
E-mails of all the students in the spreadsheet (i.e. after any filters have been applied) are listed at the end of the page so that e-mails can be manually sent to a large group of applicants.
</li>
<li>
It is also possible to programmatically send a reminder or other e-mail to all of the students in the spreadsheet (i.e. after any filters have been applied) by using the form at the end of the page (instuctions for the form are given there).
</li>
<li>
Access to <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a> and the Details for each student given by the System-wide "Manage Applications" or "Administrator" roles. "Manage Applications" is the same as a normal authenticated user with just an additional permission of: moodle/site:viewparticipants.
</li>
<li>
If someone is given the "Manage Applications" role (instead of the "Administrator" role) it may be useful to make them a teacher in any one course (e.g. the Technical Check module) if it is desired to also give them access to "<a href="http://courses.peoples-uni.org/course/admin_documentation.php#studentenrolments">Student Enrolments and Grades</a>". Additionally if that person is needed to view course content, they should be given "Education Officer" role in each desired course.
</li>
</ol>


<a name="thedetailsbutton"></a>
<h2>The "Details" button and the Approval Process.</h2>
<ol>
<li>
First, underneath the details button, sometimes there is an indication "Re-enrolment". This indicates that the person has applied with the form: <a href="http://www.peoples-uni.org/forms/application-form-returning-students" target="_blank">http://www.peoples-uni.org/forms/application-form-returning-students</a>. This form needs to be used by returning student so that they are enrolled using their existing Moodle user account. The application is also easier for the applicant because they have to enter very little information (mainly their existing username and desired modules). If they are a new student they use <a href="http://www.peoples-uni.org/forms/peoples-uni-course-application-form" target="_blank">http://www.peoples-uni.org/forms/peoples-uni-course-application-form</a> to apply and this gathers much more information.
</li>
<li>
When the "Details" button is pressed for an application, additional applicant data is displayed beyond what is in the "spreadsheet" row.
</li>
<li>
"Student Grades" Launches the Peoples-uni transcript of the grades achieved by this student in all the modules they have done. See "Course Grades" (<a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a>) which is described below in "<a href="http://courses.peoples-uni.org/course/admin_documentation.php#studentenrolments">Student Enrolments and Grades</a>".
</li>
<li>
"Student Submissions" Launches a report on all the assignment submissions made by this student. "<a href="http://courses.peoples-uni.org/course/admin_documentation.php#tracking">Viewing Student Submissions & Re-Submissions, Grades & Comments, Student Posts and Tutor Posts</a>" below,
</li>
<li>
"Paid?" indicates whether the student is believed to have paid for this semester or not (They are marked as paid if either they have indicated they have paid or they have been confirmed as having paid or they have been given a waiver).
<br />
If they have over or under paid, the amount paid and the total originally owed is indicated.
</li>
<li>
"Payment Mechanism" can be one of...<br />
'RBS WorldPay Confirmed': They paid online with a credit card (using the link they were sent in their approval e-mail which brings then to http://courses.peoples-uni.org/course/pay.php?sid=XXX (XXX being their SID, the unique application ID number noted in <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a> and "Details").<br />
'Barclays Bank Transfer': They have indicated they have paid by bank transfer to Barclays, but we have not confirmed that.<br />
'Diamond Bank Transfer': They have indicated they have paid by bank transfer to Diamond Bank, but we have not confirmed that.<br />
'MoneyGram': They have indicated they have paid by MoneyGram, but we have not confirmed that.<br />
'Indian Confederation': They have indicated they have paid locally in India, but we have not confirmed that.<br />
'Posted Travellers Cheques': They have indicated they have posted Travellers Cheques, but we have not confirmed that.<br />
'Posted Cash': They have indicated they have posted Cash, but we have not confirmed that.<br />
'Promised End Semester': They have promised to pay by end semester!<br />
'Waiver': We have given them a scholarship.<br />
'Barclays Bank Transfer Confirmed': Payment has been confirmed.<br />
'Diamond Bank Transfer Confirmed': Payment has been confirmed.<br />
'MoneyGram Confirmed': Payment has been confirmed.<br />
'Indian Confederation Confirmed': Payment has been confirmed.<br />
'Posted Travellers Cheques': Payment has been confirmed.<br />
'Posted Cash': Payment has been confirmed.<br />
The student can set 'Barclays Bank Transfer', 'Diamond Bank Transfer' and 'MoneyGram' using the paydetails.php link they will have been sent in their approval e-mail (the link includes the SID unique application ID). The credit card one is set automatically and the rest are set manually by us as described in the next bullet point.
</li>
<li>
"Change Payment Confirmation" is a link (to payconfirm.php with the applicant SID as a parameter) that brings up a page that allows us to update the data in the previous bullet point by setting the "Payment Mechanism" and pressing the "Submit the Payment Status" button. The "Amount Paid" is set to the "Amount Owed" at the same time (unless it is just marked as promised to pay in which case the "Amount Paid" is not changed).<br />This page also allows the "Amount Paid" and the "Amount Owed" to be changed because someone has underpaid or overpaid or previously made a prepayment.<br />
Note, be careful here as the indication of payment mechanism sets "Amount Paid" to the "Amount Owed", which overwrites any "Amount Paid" set here. So the data for "Amount Paid" MUST be entered and the "Submit the New Amount Paid (& Owed)" button pressed after the "Submit the Payment Status" button is pressed to update the "Payment Mechanism". And any time the
</li>
<li>
"Date Paid" is set to the date they paid by credit card or if the student gave us payment details online through paydetails.php. It is not set if we entered the fact that they paid.
</li>
<li>
"Payment Info" is reference data entered by the student when they go to paydetails.php to indicate that they have made a payment by bank transfer. It is not proving very useful. In practice it seems that the only data that apears in our bank statements is the payee's name. Also students do not seems to remember to go to paydetails to notify us they have made a payment, so we have been reduced to just checking bank statements (which we would have to do in any case to confirm all non credit card payments).
</li>
<li>
"Approve Full Application" is a button which allows the full application to be approved (both Modules if the applicant has specified two). The user is sent the e-mail outlined above under <a href="#configuration">"Configuration of Applications Process for a new Semester"</a> which requests payment.<br />
The "Approved?" entry in <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a> and "Details" will indicate "Yes" as opposed to "No", "Some" (if only one application is approved, see below) or "Denied or Deferred" (if the application has been un-approved after being approved.)
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
"e-mail Applicant" allows an e-mail to be sent to the Applicant, the e-mail to be sent can be edited. the e-mail will come from techsupport@peoples-uni.org as does the approval e-mail. Note these e-nails are copied to the e-mail address applicationresponses@peoples-uni.org.
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
"Enrol User in Module ... only" button causes the user to be enrolled in the one module only and not the other. The following e-mail will be sent from the module teacher:<br />
<pre>
Welcome to $a->coursename!

If you have not done so already, you should edit your profile page
so that we can learn more about you:

  $a->profileurl

There is a link to your course at the bottom of the profile or you can click:

  $a->courseurl
</pre>
<br />
They will also get a notification of the current semester's Students Corner in another e-mail.
<br />
The "Registered?" column in <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a> and "Details" will indicate "Some" or "Yes" if the Applicant has been enrolled in all their modules.
</li>
<li>
"Enrol User in Modules ... and ..." button will enrol the user in both modules.
</li>
<li>
"Create User & Enrol in Module ... only" creates a new user (for a new application) and then enrolls the user as above. The following e-mail with be sent from techsupport@peopes-uni.org (in addition to the one above sent on behalf of the module teacher):<br />
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
TECHSUPPORT_EMAIL_HERE
</pre>
</li>
<li>
"Create User & Enrol in Modules ... and ..." button does the same as above for all modules.
</li>
<li>
The "Add This Note to Student Record" button adds a note entered above that button to the student record.<br />
(When there are any notes for a student it will be indicated in the applications.php spreadsheet in the "Registered?" column by the words "(Note Present)".)<br />
All notes for the student (if any are present, either entered here or in "Student Grades"/student.php) will be listed further up the details page.<br />
<br />
The purpose of these notes is to allow a record to be kept of the following sorts of things for a student...<br />
Record that they have sent an e-mail confirming that they went to the "Are you ready for Peoples-uni" module.<br />
Record over or under payments so we can remember this for following semesters etc.<br />
Record that they should be given a waiver because they previously failed a module and are allowed retake it for free.<br />
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
First it may be desirable to mark some modules as full before all the applications are finally closed. To do this go to <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> click "Check to mark Module as Full" for any module that is full and then click "Update Modules for Application Forms from list above". You can confirm that both the forms have changed by looking at them (<a href="http://www.peoples-uni.org/forms/peoples-uni-course-application-form" target="_blank">http://www.peoples-uni.org/forms/peoples-uni-course-application-form</a> & <a href="http://www.peoples-uni.org/forms/application-form-returning-students" target="_blank">http://www.peoples-uni.org/forms/application-form-returning-students</a>). You will see the list of modules has changed, but also that there is extra wording automatically added to explain that the two modules are full.
</li>
<li>
But to fully close applications go to <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> and click "Close Application Forms & Mark All Modules as Full". You can confirm that both the forms have closed by looking at them (<a href="http://www.peoples-uni.org/forms/peoples-uni-course-application-form" target="_blank">http://www.peoples-uni.org/forms/peoples-uni-course-application-form</a> & <a href="http://www.peoples-uni.org/forms/application-form-returning-students" target="_blank">http://www.peoples-uni.org/forms/application-form-returning-students</a>).
</li>
<li>
In the case that you want to reopen applications temporarily for some reason... Just click "Change Current Semester for Applications Forms to:" WITHOUT changing the semester name to the right from its current setting. The application forms for the current semester will be reopened. Then go to <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a> deselect "Check to mark Module as Full" for any module that you wish to reopen and then click "Update Modules for Application Forms from list above". You can confirm that both the forms have changed by looking at them (<a href="http://www.peoples-uni.org/forms/peoples-uni-course-application-form" target="_blank">http://www.peoples-uni.org/forms/peoples-uni-course-application-form</a> & <a href="http://www.peoples-uni.org/forms/application-form-returning-students" target="_blank">http://www.peoples-uni.org/forms/application-form-returning-students</a>). You will see the list of modules has changed.
</li>
<li>
Temporarily enable this menu item from the Peoples-Uni front page: "Application Form: Expression of Interest" (<a href="http://www.peoples-uni.org/forms/application-form-expressions-interest-future-courses" target="_blank">http://www.peoples-uni.org/forms/application-form-expressions-interest-future-courses</a>).
</li>
<li>
Temporarily disable these two menu items: "Application form for new students" and "Application form for returning students" (<a href="http://www.peoples-uni.org/forms/peoples-uni-course-application-form" target="_blank">http://www.peoples-uni.org/forms/peoples-uni-course-application-form</a> & <a href="http://www.peoples-uni.org/forms/application-form-returning-students" target="_blank">http://www.peoples-uni.org/forms/application-form-returning-students</a>).
</li>
<li>
Note: When all students have been registered (enrolled) for a module, then the Marking Spreadsheet will need to be created see... <a href="http://courses.peoples-uni.org/course/admin_documentation.php#trackmarking">Collaborative Assignment Marking and Resubmission Tracking</a>.<br />
This should be done some time before assignment submission and grading starts.
</li>
</ol>


<a name="misc"></a>
<h2>Misc: Enrolling Tutors in Tutors Corner, Registering Interest in Future Semesters, Making a Donation</h2>
<ol>
<li>
<a href="http://courses.peoples-uni.org/course/enroltutorscorner.php" target="_blank">http://courses.peoples-uni.org/course/enroltutorscorner.php</a> Enrolls all current users with roles "Teacher", "Teachers" or "Education Officer" in the "Tutors Corner" and "Guide for online facilitators" modules.<br />
The names or contextid of these two modules should not be changed.
</li>
<li>
The Drupal menus (<a href="http://www.peoples-uni.org/forms/application-form-expressions-interest-future-courses" target="_blank">http://www.peoples-uni.org/forms/application-form-expressions-interest-future-courses</a>) allow an interest to be expressed in future semesters. The results of this can be seen at <a href="http://courses.peoples-uni.org/course/interest.php" target="_blank">http://courses.peoples-uni.org/course/interest.php</a>. There is a button "e-mail" to allow an e-mail to be sent to the person who expressed an interest and/or enter a comment.
If a comment is started with the exact text 'HIDDEN', then that particular entry is suppressed from all future display.
</li>
<li>
The following page is linked from the Drupal menus to allow donations: <a href="http://courses.peoples-uni.org/course/donate.php" target="_blank">http://courses.peoples-uni.org/course/donate.php</a>
</li>
</ol>


<a name="trackmarking"></a>
<h2>Collaborative Assignment Marking and Resubmission Tracking</h2>
<ol>
<li>
A process has been designed which allows teachers of a course module to use a (Google Apps) spreadsheet to collaborate on tracking assignment submissions and their grading (as well as overall module grading).
<li>
It is driven by a small Block "Track Marking" which should have been added to every relevant Module (on the bottom right hand side). The block is only visible to site administrators or to course teacher/teachers (more specifically users who have moodle/grade:edit for the course). It is not visible to students. Also the Block will not be displayed to teacher/teachers if the spreadsheet has not yet been created.
</li>
<li>
When all students have been registered (enrolled) for a module, then the Marking Spreadsheet will need to be created. This should be done some time before assignment submission and grading starts. This can be done by a Moodle Admin using the second link "Re-Create Marking Spreadsheet" in that block. This link, when clicked, brings up a page with a button which allows the Marking Spreadsheet to be created (or recreated). There is a warning popup to make sure you really want to overwrite the spreadsheet (and any marking that is contains, although Alan Barrett should be able to get the spreadsheet back if necessary, through the admin@files.peoples-uni.org Google account!).
</li>
<li>
The spreadsheet that is created is based on a standard spreadsheet and has all the names of the enrolled students in the particular course added to it (so they can be collaboratively marked). The process of creating the spreadsheet is slightly slow.
</li>
<li>
The standard spreadsheet used in each case as a starting point is called Marking.xls which is stored in the Moodle course directory and can be changed through "git" source control.
</li>
<li>
A teacher will just see one link in the Block: "Edit Marking Spreadsheet"... this launches the Marking Spreadsheet which allows immediate editing (and almost immediate automatic saving of any changes including format/layout changes). Layout can be changed as well as content.
</li>
<li>
Two or more editors should be able to edit at the same time and will see the other person's edits as they happen.
</li>
<li>
The editing is anonymous (unless an editor is logged into their own Google account). Users will not be logged into the admin@files.peoples-uni.org Google account which owns the spreadsheet. Any user (including a student!) who has been given the link would be able to edit, so the links should not be given out! Teachers will be able to see the link to the spreadsheet for their own module but not other modules, although they can obviously be given the link if desired. The actual link is quite long and also contains an authorisation key which cannot be figured out unless given away.
</li>
<li>
Note, it is possible get access to any previous revision of the spreadsheet via "File"... "See Revision History". This allows some auditing of changes. This is only possible for logged on Google users (any Google account). It is also possible for an editor to change the permissions on the spreadsheet... this should not be done! Alan Barrett will however be able to recover any hidden spreadsheets in an emergency (through admin@files.peoples-uni.org).
</li>
<li>
Assignment grades agreed in the spreadsheet will need to be manually entered in the Moodle Grade Report along with any text feedback and uploaded files feedback.
</li>
<li>
However the Course Total Grades can (and should be) automatically retrieved from the Marking Spreadsheet and saved into the Moodle Grade Book by a Moodle Admin using the third link "Store Course Total Grades into Moodle" in the "Track Marking" block.  This link, when clicked, brings up a page with a button which allows the Course Total Grades to be Retrieved. There is a warning popup to make sure you really want to Save these grades into Moodle (and overwrite any existing grades for this course in Moodle... e.g. if a grade is not set in the spreadsheet but is set in Moodle, it will overwritten to be No Grade). As normal, a history of all changes (and who did them... in this case who clicked the button) is kept.<br />
While tutors (or admins) are free to edit the module's spreadsheet, the following restrictions must be obeyed...<br />
Students are identified by something like "Firstname Secondname (999) in first column. The (999) part, which is their user ID must not be removed."<br />
The column header "Overall Module Grade: Pass/fail" for the column that contains the Course Total Grades MUST be kept EXACTLY as is (although columns before or after it can be changed, added or removed.<br />
Currently the Course Total Grade must be "Pass", "Fail" or empty which implies No Grade. Any text containing a "P" or "F" in either case will work. But no numeric marks out of 100 can be entered. This can be easily changed when we decide to, but is fixed at Pass/fail for the moment.
</li>
<li>
At a later stage it would be possible to write code to update assignment grades (in addition to the Course Total Grades) from the spreadsheet into Moodle if that makes sense, but we have decided not to do that for now.<br />
Also it would be possible to write code to automatically record in the spreadsheet stuff such as the fact that a student has made a submission (or resubmission), but this is currently a manual process.
</li>
</ol>


<a name="tracking"></a>
<h2>Viewing Student Submissions & Re-Submissions, Grades & Comments, Student Posts and Tutor Posts</h2>
<ol>
<li>
If you go to any of the following links <a href="http://courses.peoples-uni.org/course/applications.php" target="_blank">http://courses.peoples-uni.org/course/applications.php</a>, "Details", <a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> or "Student Grades"/student.php, you will see a link called "Student Submissions" for each student which will allow you to view all submissions that students have made for assignments (including re-submissions) and also all the grades received by the student and all comments by the tutors.
</li>
<li>
Note: "Student Submissions" may now be somewhat less useful as we are transitioning to a process where grades will only be entered when finally agreed so will not change. Also we are changing to a multiple file upload assignment type which will allow multiple files to be stored.
</li>
<li>
The "Student Submissions" link will display (In the first table) a list of all submissions made by the student. Note that the files can always be downloaded to your machine by clicking on them.
</li>
<li>
The "Student Submissions" link will display (in the second table) a list of all grade changes for the student along with all tutors feedback comments made (as they changed) by the tutor.
</li>
<li>
Access to "Student Submissions" is available to any teacher or admin. None of this is visible to students, all they see is their own academic transcript in student.php.
</li>
<li>
There is a parameter you can add to the end of the "Student Submissions" URL "&hidequiz=1", which hides display of quizzes if it becomes too cluttered for a particular student.
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
<a href="http://courses.peoples-uni.org/course/posts.php" target="_blank">http://courses.peoples-uni.org/course/posts.php</a> also includes filters so you can suppress those topics which start with the word "introduction" and limit scope to e.g. one module etc. (as well as the filters mentioned above).
</li>
<li>
Access to posts.php is available to any teacher or admin.
</li>
<li>
To view posts made by Tutors to discussion forums go to: <a href="http://courses.peoples-uni.org/course/tutorposts.php" target="_blank">http://courses.peoples-uni.org/course/tutorposts.php</a>.
</li>
<li>
This lists all posts for each Tutor ("Teacher" or "Teachers", not others), giving Module, Forum Name, Subject and Date of post.<br />
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
Access to tutorposts.php is available to any teacher or admin.
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
Grade for Module (Passed, Failed, not set yet).<br />
Has the student been informed of their grade? (by student.php, see below)<br />
A link to "Student Grades" (student.php) with all the details for the student, from this the teacher can select assignments and grade them, I think this could be very useful as a way of quickly rectifying missing grades.<br />
A link to the "Student Submissions" page<br />
A link to the (student's) Moodle Grade report (gives a subset of the "Student Grades" link, but also gives direct access to Moodle Grade UI)<br />
</li>
<li>
To make use of this page easier there are filters...<br />
Select one Module rather than all<br />
Select by Grading Status:<br />
 - Passed,<br />
 - Failed,<br />
 - Did not Pass (i.e. Failed or not graded)<br />
 - No Course Grade<br />
 - Un-Enrolled<br />
 - Not informed of Grade and Not Marked to be Ignored<br />
 - Will NOT be Graded, because they did Not complete<br />
 - Will NOT be Graded, but will get a certificate of participation<br />
 - Will NOT be Graded, because they did Not Pay.<br />
(The above are mostly set in "Student Grades" (student.php), see below)<br />
Select by Semester (defaults to current Semester, can also view All Semesters if you want)
Sort by Last Access
Show Students Not Logged on for this many Days (if set to a specific number of days, this can be used to select only students who have not logged on for that number of days or more. With those students selected it is possible to send a reminder e-mail to them at the bottom of the "Course Grades" page.)
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
At the bottom of the page, there are two forms to send e-mails to all the above students (those that are selected by the filters). The two sets of default wording are set in <a href="http://courses.peoples-uni.org/course/settings.php" target="_blank">http://courses.peoples-uni.org/course/settings.php</a>.<br />
The first form is typically used to send students a reminder of the their Application ID/SID.<br />
The second is typically used to send students a reminder that they have not logged on to Peoples-uni since the start of the Semester. But to do this correctly (i.e. select the appropriate students to send this e-mail to), it is necessary to set the "Show Students Not Logged on for this many Days" filter at the top of the page to an appropriate number of days before sending the e-mail.
</li>
<li>
"Course Grades" is only available to any teacher or admin. None of this is visible to students; all they see is their own academic transcript in student.php.
</li>
</ol>


<a name="informing"></a>
<h2>Informing Students of Semester Final Grade Results</h2>
<ol>
<li>
From "Course Grades" at <a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> you can select "Student Grades" to see the grades received by a given student for all that student's modules along with feedback from the tutor for all assignments.
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
Note... The "Course Total" grade is normally based on the grade for the final course assignment. The "Course Total" grades for each course should be set by the tutor. This is done in the Moodle grade report for the course... turn editing on and set the course total grades (on far right) to Passed/Failed or No Grade.
</li>
<li>
After that diversion... Back to "Course Grades"/"student Grades"... Go to: <a href="http://courses.peoples-uni.org/course/coursegrades.php" target="_blank">http://courses.peoples-uni.org/course/coursegrades.php</a> and click on "Student Grades" for an individual student.
</li>
<li>
There are a number of buttons for each course module in "Student Grades" which can be pressed (not visible to a student when they see their own version of this page). Not all will be visible at any one time...
</li>
<li>
"Mark Grading Complete and Notify Student: They Failed"... an e-mail is sent to the student with a link to a student version of this same page which shows the final marking and comments. However you obviously need to make sure that the "Overall Module Grade" has been set to the correct value (Passed or Failed) before pressing this button.
</li>
<li>
"Mark Grading Complete and Notify Student: They Passed"... an e-mail is sent to the student with a link to a student version of this same page which shows the final marking and comments. However you obviously need to make sure that the "Overall Module Grade" has been set to the correct value (Passed or Failed) before pressing this button. The student will be able to download an academic transcript PDF file further down this same page for all course modules that they have passed. (Teachers and Admins will also be able to download the student's transcripts also.)
</li>
<li>
"Click to indicate Student will NOT be Graded, because they did Not Complete"... to be used if someone did not complete the semester. This will be shown on the coursegrades.php report (and successbyqualifications.php).
</li>
<li>
"Click to indicate Student will NOT be Graded, because they did Not Pay"... to be used if someone did not finally pay by the end of the semester and we do not wish them to get any certificate for the course... This will be shown on the coursegrades.php report (and successbyqualifications.php).
</li>
<li>
"Click to indicate Student will NOT be Graded, but will get a 'Certificate of Participation'"... to be used if someone is on the CPD stream and you only want to give them a certificate of attendance and not academic transcripts counting towards a certificate/diploma. This will be shown on the coursegrades.php report (and successbyqualifications.php). Additionally, the person will get an e-mail telling them the Certificate of Participation is available. And finally they (or you if you want to for some reason) can download the Certificate of Participation from "Student Grades"/student.php.
</li>
<li>
Additionally if the student has met the criteria for receiving a Certificate (4 modules passed, 2 of each type) or Diploma (8 modules passed) from Peoples-uni. They will be able to download them here.
</li>
<li>
Other options on this page are:<br />
To send another e-mail to the student: "e-mail Student",<br />
Add a note to the student record (see also the <a href="http://courses.peoples-uni.org/course/admin_documentation.php#thedetailsbutton">details button/page</a>), or<br />
Look at "Student Submissions".<br />
Note that the student's most recent approved SID/Application ID/Registration Number is shown near the top of "Student Grades" and a student may be directed here to find their most recent SID.
</li>
</ol>


<a name="progress"></a>
<h2>Student Progress towards Qualifications</h2>
<ol>
<li>
To see how our students are progressing towards Certificates and Diplomas go to <a href="http://courses.peoples-uni.org/course/studentprogress.php" target="_blank">http://courses.peoples-uni.org/course/studentprogress.php</a>.
</li>
<li>
It is ordered with the the student who has passed the most exams at top and shows whether they have qualified for a Diploma, a Certificate or nothing so far.
</li>
<li>
It includes the list of modules they have passed (Course Codes) and the number of "Foundation Sciences" and "Public Health Problems".
</li>
</ol>


<a name="statistics"></a>
<h2>Statistics on Success of Students by Qualifications on Entry</h2>
<ol>
<li>
Analysis of grades versus other characteristics can be found using <a href="http://courses.peoples-uni.org/course/successbyqualifications.php" target="_blank">http://courses.peoples-uni.org/course/successbyqualifications.php</a>
</li>
<li>
There you will see (at the bottom of the page), a breakdown of qualifications and employment. Above this the page lists qualifications and employment per person. Note, only students for which we have this data are displayed and counted (some early application forms did not have this data).
</li>
<li>
To actually see this data for those that either Passed, Failed or who were Not Graded etc. only, you can set the filters to just select students with that type of grade. Obviously you would want to wait for grading to be complete for the semester you are interested in.
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
    SELECT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.name IN ('Teacher', 'Teachers') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>