<?php  // $Id: payconfirm.php,v 1.1 2009/09/14 12:00:00 alanbarrett Exp $
/**
*
* Update details of a payment by a user
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/payconfirm.php');
$PAGE->set_pagelayout('standard');

require_login();
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Peoples-uni Payment Details');
$PAGE->set_heading('Peoples-uni Payment Details');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');


$sid = (int)$_REQUEST['sid'];
$application = $DB->get_record('peoplesapplication', array('sid' => $sid));
if (empty($application)) {
	notice('Error: The parameter passed does not correspond to a valid application to Peoples-uni!', "$CFG->wwwroot");
}

$name = htmlspecialchars($application->firstname . ' ' . $application->lastname, ENT_COMPAT, 'UTF-8');

$modulespurchased = "Application number $sid for semester '$application->semester'";
$modulespurchased = htmlspecialchars($modulespurchased, ENT_COMPAT, 'UTF-8');
if (empty($application->coursename2)) {
	$modulespurchasedlong = "Peoples-uni module '$application->coursename1' for semester '$application->semester'";
}
else {
  $state = (int)$application->state;
  // Legacy fixups...
  if ($state === 2) {
    $state = 022;
  }
  if ($state === 1) {
    $state = 011;
  }

  $state1 = $state & 07;
  $state2 = $state & 070;

  $module_1_approved = ($state1 ===  01) || ($state1 ===  03);
  $module_2_approved = ($state2 === 010) || ($state2 === 030);

  if     ($module_1_approved && !$module_2_approved) {
    $modulespurchasedlong = "Peoples-uni module '$application->coursename1' for semester '$application->semester'";
  }
  elseif ($module_2_approved && !$module_1_approved) {
    $modulespurchasedlong = "Peoples-uni module '$application->coursename2' for semester '$application->semester'";
  }
  else {
    $modulespurchasedlong = "Peoples-uni modules '$application->coursename1' and '$application->coursename2' for semester '$application->semester'";
  }
}
$modulespurchasedlong = htmlspecialchars($modulespurchasedlong, ENT_COMPAT, 'UTF-8');

$amount = $application->costowed;
$currency = $application->currency;


if (!empty($_POST['markpayconfirm'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $updated = new object();
  $updated->id = $application->id;

  if (empty($_POST['paymentmechanism'])) notice('You must select the method you used for payment. Press Continue and re-select.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");

  $updated->paymentmechanism = (int)$_POST['paymentmechanism'];
  if ($updated->paymentmechanism != 6) {
		$updated->costpaid = $application->costowed;
	}

  $DB->update_record('peoplesapplication', $updated);

  if ($updated->paymentmechanism > 100) { // If Confirmed...

    $message  = "Dear $application->firstname\n\n";
    $message .= "Your payment of $updated->costpaid Pounds for Application $sid\n";
    $message .= "has been confirmed received.\n\n";
    $message .= "Semester: $application->semester\n\n";
    $message .= "Peoples Open Access Education Initiative Administrator.\n";

    sendapprovedmail($application->email, "Peoples-uni Payment Confirmed for: $application->lastname, $application->firstname; Application: $sid", $message);

    notice('Success! Data saved (and e-mail sent to Student)!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
  }
  else {
    notice('Success! Data saved!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
  }
}
elseif (!empty($_POST['marksetowed'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $updated = new object();
  $updated->id = $application->id;

  if (!isset($_POST['costpaid']) || !is_numeric($_POST['costpaid'])) {
    notice('Amount Paid must be a number. Press Continue and re-select.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
  }
  if (!isset($_POST['costowed']) || !is_numeric($_POST['costowed'])) {
		notice('Amount Owed must be a number. Press Continue and re-select.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
  }

	$updated->costpaid = $_POST['costpaid'];
	$updated->costowed = $_POST['costowed'];

  $DB->update_record('peoplesapplication', $updated);

  notice('Success! Data saved!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
}
elseif (!empty($_POST['note']) && !empty($_POST['markpaymentnote'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $newpaymentnote = new object();
  $newpaymentnote->userid        = $application->userid;
  $newpaymentnote->sid           = $_POST['sid'];
  $newpaymentnote->datesubmitted = time();
  $newpaymentnote->paymentstatus = 0;

  // textarea with hard wrap will send CRLF so we end up with extra CRs, so we should remove \r's for niceness
  $newpaymentnote->note = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_POST['note'], ENT_COMPAT, 'UTF-8')));
  $DB->insert_record('peoplespaymentnote', $newpaymentnote);

  notice('Success! Data saved!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
}

echo '<div align="center">';
echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';

echo "<p><br /><br /><b>$name<br />$modulespurchasedlong<br />Amount Owed:&nbsp;&nbsp;&nbsp;$amount $currency<br />Amount Paid:&nbsp;&nbsp;&nbsp;{$application->costpaid} $currency</b></p>";

echo '<br /><p>Update the payment confirmation status and then click "Submit the Payment Status".<br />(Note: Amount Paid will be set equal to Amount Owed,<br /> except when "Promised to Pay by End of Semester" is selected.)</p>';

?>
<form id="payconfirmform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">

<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

Select the new payment status: <select name="paymentmechanism">
<option value="0">Select one...</option>
<option value="2">Barclays Bank Transfer</option>
<option value="10">Ecobank Nigeria PLC. Transfer</option>
<option value="3">Diamond Bank Plc. Transfer</option>
<option value="9">MoneyGram Payment</option>
<option value="4">Western Union Payment</option>
<option value="5">Indian Confederation for Healthcare Accreditation for those taking Patient Safety module from India</option>
<option value="7">Posted Travellers Cheques</option>
<option value="8">Posted Cash</option>
<option value="6">Promised to Pay by End of Semester</option>
<option value="100">Waiver</option>
<option value="102">Confirmed: Barclays Bank Transfer</option>
<option value="110">Confirmed: Ecobank Transfer</option>
<option value="103">Confirmed: Diamond Bank Transfer</option>
<option value="109">Confirmed: MoneyGram</option>
<option value="104">Confirmed: Western Union</option>
<option value="105">Confirmed: Indian Confederation</option>
<option value="107">Confirmed: Posted Travellers Cheques</option>
<option value="108">Confirmed: Posted Cash</option>
</select><br /><br />

<input type="hidden" name="markpayconfirm" value="1" />
<input type="submit" name="payconfirm" value="Submit the Payment Status" />
</form>

<br /><br /><br />
<p>If the person did not pay the full amount (or even overpaid) set the Amount Paid here and then click "Submit the New Amount Paid".<br />
(You can also set the Amount Owed if that has to be changed for some special reason.)</p>

<form id="setowedform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">

<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

Amount Paid: <input type="text" size="60" name="costpaid" value="<?php echo $application->costpaid ?>" /><br />
Amount Owed: <input type="text" size="60" name="costowed" value="<?php echo $application->costowed ?>" /><br />
<br />

<input type="hidden" name="marksetowed" value="1" />
<input type="submit" name="setowed" value="Submit the New Amount Paid (& Owed)" />
</form>

<br /><br /><br />
<?php
$paymentnotes = $DB->get_records_sql("SELECT * FROM mdl_peoplespaymentnote WHERE (sid=$sid AND sid!=0) OR (userid={$application->userid} AND userid!=0) ORDER BY datesubmitted DESC");
if (!empty($paymentnotes)) {
  echo "<table border=\"1\" BORDERCOLOR=\"RED\">";
  echo '<tr><td colspan="2">Payment Notes (can add more below)...</td></tr>';

  foreach ($paymentnotes as $paymentnote) {
    echo '<tr><td>';
    echo gmdate('d/m/Y H:i', $paymentnote->datesubmitted);
    echo '</td><td>';
    echo $paymentnote->note;
    echo '</td></tr>';
  }

  echo '</table>';
}
?>

<form id="paymentnoteform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">

<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<textarea name="note" rows="5" cols="100" wrap="hard"></textarea><br />

<input type="hidden" name="markpaymentnote" value="1" />
<input type="submit" name="paymentnote" value="Add this Payment Note to this Student (will be seen on this page in future semesters)" />
</form>


<?php
$applications = $DB->get_records_sql("
  SELECT DISTINCT a.sid AS appsid, a.*
  FROM mdl_peoplesapplication a
  WHERE a.userid={$application->userid} AND a.userid!=0 AND sid!=$sid AND hidden=0
  ORDER BY a.datesubmitted DESC");
if (!empty($applications)) {

  echo '<br /><br /><br />Other Applications...<br />';

  $table = new html_table();
  $table->head = array(
    'Semester',
    'sid',
    'Paid?',
    'Registered?',
    'Amount Owed',
    'Amount Paid'
  );

  foreach ($applications as $sid => $app) {
    $state = (int)$app->state;
    if ($state === 2) {
      $state = 022;
    }
    if ($state === 1) {
      $state = 011;
    }
    $state1 = $state & 07;
    $state2 = $state & 070;

    $rowdata = array();
    $rowdata[] = htmlspecialchars($app->semester, ENT_COMPAT, 'UTF-8');
    $rowdata[] = $sid;

    if (empty($app->paymentmechanism)) $mechanism = '';
    elseif ($app->paymentmechanism == 1) $mechanism = ' RBS Confirmed';
    elseif ($app->paymentmechanism == 2) $mechanism = ' Barclays';
    elseif ($app->paymentmechanism == 3) $mechanism = ' Diamond';
    elseif ($app->paymentmechanism ==10) $mechanism = ' Ecobank';
    elseif ($app->paymentmechanism == 4) $mechanism = ' Western Union';
    elseif ($app->paymentmechanism == 5) $mechanism = ' Indian Confederation';
    elseif ($app->paymentmechanism == 6) $mechanism = ' Promised End Semester';
    elseif ($app->paymentmechanism == 7) $mechanism = ' Posted Travellers Cheques';
    elseif ($app->paymentmechanism == 8) $mechanism = ' Posted Cash';
    elseif ($app->paymentmechanism == 9) $mechanism = ' MoneyGram';
    elseif ($app->paymentmechanism == 100) $mechanism = ' Waiver';
    elseif ($app->paymentmechanism == 102) $mechanism = ' Barclays Confirmed';
    elseif ($app->paymentmechanism == 103) $mechanism = ' Diamond Confirmed';
    elseif ($app->paymentmechanism == 110) $mechanism = ' Ecobank Confirmed';
    elseif ($app->paymentmechanism == 104) $mechanism = ' Western Union Confirmed';
    elseif ($app->paymentmechanism == 105) $mechanism = ' Indian Confederation Confirmed';
    elseif ($app->paymentmechanism == 107) $mechanism = ' Posted Travellers Cheques Confirmed';
    elseif ($app->paymentmechanism == 108) $mechanism = ' Posted Cash Confirmed';
    elseif ($app->paymentmechanism == 109) $mechanism = ' MoneyGram Confirmed';
    else  $mechanism = '';
    if ($app->costpaid < .01) $z = '<span style="color:red">No' . $mechanism . '</span>';
    elseif (abs($app->costowed - $app->costpaid) < .01) $z = '<span style="color:green">Yes' . $mechanism . '</span>';
    else $z = '<span style="color:blue">' . "Paid $app->costpaid out of $app->costowed" . $mechanism . '</span>';
    $rowdata[] = $z;

    if (!($state1===03 || $state2===030)) $z = '<span style="color:red">No</span>';
    elseif ($state === 033) $z = '<span style="color:green">Yes</span>';
    else $z = '<span style="color:blue">Some</span>';
    $rowdata[] = $z;

    $rowdata[] = $app->costowed;
    $rowdata[] = $app->costpaid;

    $table->data[] = $rowdata;
  }
  echo html_writer::table($table);
}
?>


<br /><br />
</div>

<?php

echo $OUTPUT->box_end();
echo $OUTPUT->footer();


function sendapprovedmail($email, $subject, $message) {
  global $CFG;

  // Dummy User
  $user = new stdClass();
  $user->id = 999999999;
  $user->email = $email;
  $user->maildisplay = true;
  $user->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->email = 'payments@peoples-uni.org';
  $supportuser->firstname = 'Peoples-uni Payments';
  $supportuser->lastname = '';
  $supportuser->maildisplay = true;

  //$user->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($user, $supportuser, $subject, $message);

  $user->email = 'applicationresponses@peoples-uni.org';

  //$user->email = 'alanabarrett0@gmail.com';
  email_to_user($user, $supportuser, $email . ' Sent: ' . $subject, $message);

  return $ret;
}
?>
