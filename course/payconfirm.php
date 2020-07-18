<?php  // $Id: payconfirm.php,v 1.1 2009/09/14 12:00:00 alanbarrett Exp $
/**
*
* Update details of a payment by a user
*
*/

/*
  CREATE TABLE mdl_peoples_student_balance (
    id BIGINT(10) unsigned NOT NULL auto_increment,
    userid BIGINT(10) unsigned NOT NULL,
    amount_delta VARCHAR(10),
    balance VARCHAR(10),
    currency VARCHAR(3) NOT NULL DEFAULT 'GBP',
    detail text NOT NULL,
    date BIGINT(10) unsigned NOT NULL DEFAULT 0,
    not_confirmed BIGINT(10) unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
  );
  CREATE INDEX mdl_peoples_student_balance_uid_ix ON mdl_peoples_student_balance (userid);

  CREATE TABLE mdl_peoples_payment_schedule (
    id BIGINT(10) unsigned NOT NULL auto_increment,
    userid BIGINT(10) unsigned NOT NULL,
    amount_1 VARCHAR(10),
    amount_2 VARCHAR(10),
    amount_3 VARCHAR(10),
    amount_4 VARCHAR(10),
    currency VARCHAR(3) NOT NULL DEFAULT 'GBP',
    expect_amount_1_date BIGINT(10) unsigned NOT NULL DEFAULT 0,
    expect_amount_2_date BIGINT(10) unsigned NOT NULL DEFAULT 0,
    expect_amount_3_date BIGINT(10) unsigned NOT NULL DEFAULT 0,
    expect_amount_4_date BIGINT(10) unsigned NOT NULL DEFAULT 0,
    due_date_1 BIGINT(10) unsigned NOT NULL DEFAULT 0,
    due_date_2 BIGINT(10) unsigned NOT NULL DEFAULT 0,
    due_date_3 BIGINT(10) unsigned NOT NULL DEFAULT 0,
    due_date_4 BIGINT(10) unsigned NOT NULL DEFAULT 0,
    user_who_modified BIGINT(10) unsigned NOT NULL,
    date_modified BIGINT(10) unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
  );
  CREATE INDEX mdl_peoples_payment_schedule_uid_ix ON mdl_peoples_payment_schedule (userid);

  CREATE TABLE mdl_peoples_instalment_amount (
    id BIGINT(10) unsigned NOT NULL auto_increment,
    userid BIGINT(10)  UNSIGNED NOT NULL,
    date   BIGINT(10)  UNSIGNED NOT NULL DEFAULT 0,
    amount VARCHAR(10) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE  KEY (userid)
  );
*/


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/payconfirm.php');
$PAGE->set_pagelayout('standard');

require_login();
require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Peoples-uni Payment Details');
$PAGE->set_heading('Peoples-uni Payment Details');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');


$sid = (int)$_REQUEST['sid'];
$application = $DB->get_record('peoplesapplication', array('sid' => $sid));
if (empty($application)) {
	notice('Error: The parameter passed does not correspond to a valid application to Peoples-uni!', "$CFG->wwwroot");
}

$userid = $application->userid;

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

$sendemail = FALSE;


if (!empty($_POST['markpayconfirm'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $updated = new stdClass();
  $updated->id = $application->id;

  if (empty($_POST['paymentmechanism'])) notice('You must select the Payment Method. Press Continue and re-select.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");

  $updated->paymentmechanism = (int)$_POST['paymentmechanism'];
  //if ($updated->paymentmechanism != 6) {
  //  $updated->costpaid = $application->costowed;
  //}

  if ($updated->paymentmechanism != 199) {
    $DB->update_record('peoplesapplication', $updated);
  }

  if ($updated->paymentmechanism > 100) { // If Confirmed...

    $message  = "Dear $application->firstname,\n\n";
    $message .= "Here is a statement of your payment transactions...\n\n";

    $balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} ORDER BY date, id");
    $finalbalance = 0;
    if (!empty($balances) && $userid != 0) {
      foreach ($balances as $balance) {
        $finalbalance = $balance->balance;
        if ($balance->not_confirmed) {
          $not_confirmed = ' (not confirmed)';
        }
        else {
          $not_confirmed = '';
        }
        $message .= 'Date: ' . gmdate('d/m/Y H:i', $balance->date) . "\nDetail: " . $balance->detail . "\nAmount (UK Pounds): " . number_format($balance->amount_delta, 2) . $not_confirmed . "\n\n";
      }
    }
    else {
      $message .= "No Transactions\n";
    }

    if ($finalbalance >= 0) {
      $message .= "\nBalance you owe (UK Pounds): " . number_format($finalbalance, 2) . "\n\n";
    }
    else {
      $message .= "\nBalance (Overpaid) (UK Pounds): " . number_format(-$finalbalance, 2) . "\n\n";
    }

    $message .= "Semester: $application->semester\n\n";
    $message .= "Peoples Open Access Education Initiative Administrator.\n";

    sendapprovedmail_from_payments($application->email, "Peoples-uni Payment Confirmed for: $application->lastname, $application->firstname; Application: $sid", $message);

    //notice('Success! Data saved (and e-mail sent to Student)!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
    $sendemail = TRUE;
  }
  else {
    //notice('Success! Data saved!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
  }
}
elseif (!empty($_POST['marksetowed'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  if (!isset($_POST['amount_delta']) || !is_numeric($_POST['amount_delta'])) {
    notice('Payment Amount must be a number. Press Continue and re-enter.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
  }
  if (empty($_POST['detail'])) {
    notice('Detail must be specified. Press Continue and re-enter.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
  }

  $same_payment_should_not_exist = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid=? AND amount_delta=?", array($application->userid, -$_POST['amount_delta']));
  if (!empty($same_payment_should_not_exist)) {
    foreach ($same_payment_should_not_exist as $payment) {
      if ($payment->detail == $_POST['detail']) notice('The same Payment Amount and Detail have already been specified for this student. Specify a different Detail. Press Continue and re-enter.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
    }
  }

  if (!empty($application->userid)) { // $application->userid should NOT be empty, but just in case
    $amount = get_balance($application->userid);

    $peoples_student_balance = new stdClass();
    $peoples_student_balance->userid = $application->userid;
    $peoples_student_balance->amount_delta = -$_POST['amount_delta'];
    $peoples_student_balance->balance = $amount + $peoples_student_balance->amount_delta;
    $peoples_student_balance->balance = round($peoples_student_balance->balance, 2);
    if ($peoples_student_balance->balance == '-0') $peoples_student_balance->balance = 0;
    $peoples_student_balance->currency = 'GBP';
    $peoples_student_balance->detail = $_POST['detail'];
    $peoples_student_balance->date = time();
    if (!empty($_POST['not_confirmed'])) $peoples_student_balance->not_confirmed = 1;
    $DB->insert_record('peoples_student_balance', $peoples_student_balance);
  }

  //notice('Success! Data saved!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
}
elseif (!empty($_POST['markscholarship'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $peoples_decision = $DB->get_record('peoples_decision', array('userid' => $application->userid));
  if (!empty($peoples_decision)) {
    $peoples_decision->decided_scholarship = $_POST['decided_scholarship'];
    $peoples_decision->date_scholarship    = time();
    $DB->update_record('peoples_decision', $peoples_decision);
  } else {
    $peoples_decision = new stdClass();
    $peoples_decision->userid              = $application->userid;
    $peoples_decision->decided_scholarship = $_POST['decided_scholarship'];
    $peoples_decision->date_scholarship    = time();
    $DB->insert_record('peoples_decision', $peoples_decision);
  }
}
elseif (!empty($_POST['note']) && !empty($_POST['markpaymentnote'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $newpaymentnote = new stdClass();
  $newpaymentnote->userid        = $application->userid;
  $newpaymentnote->sid           = $_POST['sid'];
  $newpaymentnote->datesubmitted = time();
  $newpaymentnote->paymentstatus = 0;

  // textarea with hard wrap will send CRLF so we end up with extra CRs, so we should remove \r's for niceness
  $newpaymentnote->note = str_replace("\r", '', str_replace("\n", '<br />', htmlspecialchars($_POST['note'], ENT_COMPAT, 'UTF-8')));
  $DB->insert_record('peoplespaymentnote', $newpaymentnote);

  //notice('Success! Data saved!', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
}
elseif (!empty($_POST['marktransactionconfirmed'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  $balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid}");
  if (!empty($balances) && $userid != 0) {
    foreach ($balances as $balance) {
      $balance->not_confirmed = 0;
      $DB->update_record('peoples_student_balance', $balance);
    }
  }
}
elseif (!empty($_POST['markpayconfirminstalment']) && !empty($_POST['userid'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  if (empty($_POST['amount'])) {
    $DB->delete_records('peoples_instalment_amount', array('userid' => $_POST['userid']));
  }
  elseif (!is_numeric($_POST['amount'])) {
    notice('Instalment Amount must be a number. Press Continue and re-enter.', "$CFG->wwwroot/course/payconfirm.php?sid=$sid");
  } else {
    $DB->delete_records('peoples_instalment_amount', array('userid' => $_POST['userid']));
    $peoples_instalment_amount = new stdClass();
    $peoples_instalment_amount->userid = $_POST['userid'];
    $peoples_instalment_amount->amount = $_POST['amount'];
    $peoples_instalment_amount->date   = time();
    $DB->insert_record('peoples_instalment_amount', $peoples_instalment_amount);
  }
}


echo '<div align="center">';
//echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';

if ($sendemail) echo '<p><b>NOTE: Confirmatory e-mail was sent to Student!</b></p>';

echo "<p><b>";
echo "<br /><br />$name";
echo "<br />$modulespurchasedlong<br />";

if (empty($application->paymentmechanism)) $mechanism = '';
elseif ($application->paymentmechanism == 1) $mechanism = 'RBS Confirmed';
elseif ($application->paymentmechanism == 2) $mechanism = 'Barclays';
elseif ($application->paymentmechanism == 3) $mechanism = 'Diamond';
elseif ($application->paymentmechanism ==10) $mechanism = 'Ecobank';
elseif ($application->paymentmechanism == 4) $mechanism = 'Western Union';
elseif ($application->paymentmechanism == 5) $mechanism = 'Indian Confederation';
elseif ($application->paymentmechanism == 6) $mechanism = 'Promised End Semester';
elseif ($application->paymentmechanism == 7) $mechanism = 'Posted Travellers Cheques';
elseif ($application->paymentmechanism == 8) $mechanism = 'Posted Cash';
elseif ($application->paymentmechanism == 9) $mechanism = 'MoneyGram';
elseif ($application->paymentmechanism == 100) $mechanism = 'Waiver';
elseif ($application->paymentmechanism == 102) $mechanism = 'Barclays Confirmed';
elseif ($application->paymentmechanism == 103) $mechanism = 'Diamond Confirmed';
elseif ($application->paymentmechanism == 110) $mechanism = 'Ecobank Confirmed';
elseif ($application->paymentmechanism == 104) $mechanism = 'Western Union Confirmed';
elseif ($application->paymentmechanism == 105) $mechanism = 'Indian Confederation Confirmed';
elseif ($application->paymentmechanism == 107) $mechanism = 'Posted Travellers Cheques Confirmed';
elseif ($application->paymentmechanism == 108) $mechanism = 'Posted Cash Confirmed';
elseif ($application->paymentmechanism == 109) $mechanism = 'MoneyGram Confirmed';
else  $mechanism = '';
if (!empty($mechanism)) echo "<br />Payment Method for this Application: $mechanism<br />";

$inmmumph = FALSE;
$mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE (sid=$sid AND sid!=0) OR (userid={$application->userid} AND userid!=0) ORDER BY datesubmitted DESC LIMIT 1");
if (!empty($mphs)) {
  foreach ($mphs as $mph) {
    $inmmumph = TRUE;
    echo '<br />Student was Enrolled in MPH on ' . gmdate('d/m/Y H:i', $mph->datesubmitted) . '<br />';
  }
}

$income_category = get_income_category($userid);
$income_category_text = array(0 => 'Existing Student', 1 => 'LMIC', 2 => 'HIC');
echo '<br />Income Category: ' . $income_category_text[$income_category] . '<br />';

echo "</b></p>";

$balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} ORDER BY date, id");
if (!empty($balances) && $userid != 0) {
  $table = new html_table();

  $table->head = array(
    'Date',
    'Detail',
    'Transaction Amount &pound;s',
    '',
    'Balance &pound;s (+ve means the Student Owes Peoples-uni)',
  );

  $table->align = array ('left', 'left', 'right', 'left', 'right');

  foreach ($balances as $balance) {
    $rowdata = array();
    $rowdata[] = gmdate('d/m/Y H:i', $balance->date);
    $rowdata[] = htmlspecialchars($balance->detail, ENT_COMPAT, 'UTF-8');
    $rowdata[] = number_format($balance->amount_delta, 2);
    if ($balance->not_confirmed) {
      $rowdata[] = '(not confirmed)';
    }
    else {
      $rowdata[] = '';
    }
    $rowdata[] = number_format($balance->balance, 2);
    $table->data[] = $rowdata;
  }

  echo html_writer::table($table);
}
else {
    echo '<br />No Transactions for this Student';
}

?>
<br /><br />
<p>To adjust the student balance, enter the Payment Amount & the Detail and then click "Subtract a new Payment Amount from the Student Balance".<br />
(This should be +ve if the student has made a payment or are to be given a full/part Bursary)<br />
(Prefix the Amount with a "-" if it should increase the balance owed by the Student.)</p>

<form id="setowedform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">

<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
Payment Amount:&nbsp;<input type="text" size="60" name="amount_delta" value="" /><br />
Detail:&nbsp;<input type="text" size="60" name="detail" value="" /><br />
Check this only if you want the payment to be "(not confirmed)":&nbsp;<input type="checkbox" name="not_confirmed" /><br />
<br />

<input type="hidden" name="marksetowed" value="1" />
<input type="submit" name="setowed" value="Subtract a new Payment Amount from the Student Balance" />
</form>


<br /><br /><br /><p>To update the payment method (for this application), specify the payment method below and then click "Submit the Payment Method".<br />
(If you set a "Confirmed" status or "Send e-mail...", the student will be e-mailed with their transactions and current Balance,<br />
so be sure to set the correct balance first.)<br />
(clicking "Submit the Payment Method" does not change the confirmed/(not confirmed) status for any transaction, that should be done when an individual transaction is added or "Mark all Transactions in this Student's Account as Confirmed" can be used below.)</p>

<form id="payconfirmform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">

<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

Select the new payment method: <select name="paymentmechanism">
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
<option value="199">Send e-mail without changing Status</option>
</select><br /><br />

<input type="hidden" name="markpayconfirm" value="1" />
<input type="submit" name="payconfirm" value="Submit the Payment Method" />
</form>

<br /><br /><br />
<p>To mark all transactions in this student's account which are "(not confirmed)" as confirmed, click "Mark all Transactions in this Student's Account as Confirmed".</p>
<form id="transactionconfirmedform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="marktransactionconfirmed" value="1" />
<input type="submit" name="transactionconfirmed" value="Mark all Transactions in this Student's Account as Confirmed" />
</form>

<?php
$payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));
if (!empty($payment_schedule) && $userid != 0) {
  echo '<br /><br /><br /><br />';
  $table = new html_table();
  $table->head = array(
    'Last Date for Payment of Instalment 1',
    'Instalment 1 Amount',
    'Last Date for Payment of Instalment 2',
    'Instalment 2 Amount',
    'Last Date for Payment of Instalment 3',
    'Instalment 3 Amount',
    'Last Date for Payment of Instalment 4',
    'Instalment 4 Amount',
  );
  $rowdata = array();
  $rowdata[] = gmdate('d/m/Y', $payment_schedule->due_date_1);
  $rowdata[] = '&pound;' . number_format($payment_schedule->amount_1, 2);
  $rowdata[] = gmdate('d/m/Y', $payment_schedule->due_date_2);
  $rowdata[] = '&pound;' . number_format($payment_schedule->amount_2, 2);
  $rowdata[] = gmdate('d/m/Y', $payment_schedule->due_date_3);
  $rowdata[] = '&pound;' . number_format($payment_schedule->amount_3, 2);
  $rowdata[] = gmdate('d/m/Y', $payment_schedule->due_date_4);
  $rowdata[] = '&pound;' . number_format($payment_schedule->amount_4, 2);
  $table->data[] = $rowdata;
  echo html_writer::table($table);

  echo '<br />(Remaining payment due in current instalment period: &pound;' . number_format(amount_to_pay($userid), 2) . ')';

  $user_who_modified = $DB->get_record('user', array('id' => $payment_schedule->user_who_modified));
  echo '<br />(last modified by ' . fullname($user_who_modified) . ' on ' . gmdate('d/m/Y H:i', $payment_schedule->date_modified) . ')';

  echo '<br /><a href="' . $CFG->wwwroot . '/course/specify_instalments.php?userid=' . $userid . '" target="_blank">Change Instalments for this Student</a>';
}
else {
  if ($userid != 0) {
    //echo '<br /><br /><br /><br /><a href="' . $CFG->wwwroot . '/course/specify_instalments.php?userid=' . $userid . '" target="_blank">Specify Instalments for this Student (normally done by Student themselves)</a>';

    $peoples_instalment_amount = $DB->get_record('peoples_instalment_amount', array('userid' => $userid));
    if (empty($peoples_instalment_amount)) $instalment = '';
    else                                   $instalment = $peoples_instalment_amount->amount
?>
<br /><br /><br />
<form id="payconfirminstalmentform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
Instalment Amount:&nbsp;<input type="text" size="60" name="amount" value="<?php echo $instalment; ?>" /><br />
<input type="hidden" name="markpayconfirminstalment" value="1" />
<input type="submit" name="payconfirminstalment" value="Set Instalment Amount (leave blank for full payment)" />
</form>
<?php
  }
}

echo '<br /><br /><br /><br />';
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
  echo '<br /><br /><br />';
}

$peoples_decision = $DB->get_record('peoples_decision', array('userid' => $userid));
?>

<p>If you know whether the student has been awarded a multi-semester scholarship or been rejected, indicate it here. It would also be advisable to add a Payment Note below.<br />
(If the setting is different from "Not Decided Yet" then future application forms for this student will not have an option to request a scholarship.)</p>

<form id="scholarshipform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">
<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
Scholarship Status: <select name="decided_scholarship">
<option value="0">Not Decided Yet</option>
<option value="1" <?php if (!empty($peoples_decision) && $peoples_decision->decided_scholarship == 1) echo 'selected="selected"'; ?> >Approved</option>
<option value="2" <?php if (!empty($peoples_decision) && $peoples_decision->decided_scholarship == 2) echo 'selected="selected"'; ?> >Rejected</option>
</select><br />

<input type="hidden" name="markscholarship" value="1" />
<input type="submit" name="scholarship" value="Indicate Scholarship Status for this Student" />
</form>
<br /><br /><br />

<form id="paymentnoteform" method="post" action="<?php echo $CFG->wwwroot . '/course/payconfirm.php'; ?>">

<input type="hidden" name="sid" value="<?php echo $sid; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<textarea name="note" rows="5" cols="100" wrap="hard" style="width:auto"></textarea><br />

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
    'Payment Method',
    'Enrolled?',
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
    elseif ($app->paymentmechanism == 1) $mechanism = 'RBS Confirmed';
    elseif ($app->paymentmechanism == 2) $mechanism = 'Barclays';
    elseif ($app->paymentmechanism == 3) $mechanism = 'Diamond';
    elseif ($app->paymentmechanism ==10) $mechanism = 'Ecobank';
    elseif ($app->paymentmechanism == 4) $mechanism = 'Western Union';
    elseif ($app->paymentmechanism == 5) $mechanism = 'Indian Confederation';
    elseif ($app->paymentmechanism == 6) $mechanism = 'Promised End Semester';
    elseif ($app->paymentmechanism == 7) $mechanism = 'Posted Travellers Cheques';
    elseif ($app->paymentmechanism == 8) $mechanism = 'Posted Cash';
    elseif ($app->paymentmechanism == 9) $mechanism = 'MoneyGram';
    elseif ($app->paymentmechanism == 100) $mechanism = 'Waiver';
    elseif ($app->paymentmechanism == 102) $mechanism = 'Barclays Confirmed';
    elseif ($app->paymentmechanism == 103) $mechanism = 'Diamond Confirmed';
    elseif ($app->paymentmechanism == 110) $mechanism = 'Ecobank Confirmed';
    elseif ($app->paymentmechanism == 104) $mechanism = 'Western Union Confirmed';
    elseif ($app->paymentmechanism == 105) $mechanism = 'Indian Confederation Confirmed';
    elseif ($app->paymentmechanism == 107) $mechanism = 'Posted Travellers Cheques Confirmed';
    elseif ($app->paymentmechanism == 108) $mechanism = 'Posted Cash Confirmed';
    elseif ($app->paymentmechanism == 109) $mechanism = 'MoneyGram Confirmed';
    else  $mechanism = '';
    //if ($app->costpaid < .01) $z = '<span style="color:red">No' . $mechanism . '</span>';
    //elseif (abs($app->costowed - $app->costpaid) < .01) $z = '<span style="color:green">Yes' . $mechanism . '</span>';
    //else $z = '<span style="color:blue">' . "Paid $app->costpaid out of $app->costowed" . $mechanism . '</span>';
    //$rowdata[] = $z;
    $rowdata[] = $mechanism;

    if (!($state1===03 || $state2===030)) $z = '<span style="color:red">No</span>';
    elseif ($state === 033) $z = '<span style="color:green">Yes</span>';
    else $z = '<span style="color:blue">Some</span>';
    $rowdata[] = $z;

    //$rowdata[] = $app->costowed;
    //$rowdata[] = $app->costpaid;

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
?>
