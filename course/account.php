<?php  // $Id: account.php,v 1.1 2009/09/14 12:00:00 alanbarrett Exp $
/**
*
* Show account details for a Student
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/course/account.php');
$PAGE->set_pagelayout('standard');

require_login();
// (Might possibly be Guest)

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userid = $USER->id;
if (empty($userid)) {echo '<h1>$userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$fullname = fullname($userrecord);

if (empty($fullname) || trim($fullname) == 'Guest User') {
  $SESSION->wantsurl = "$CFG->wwwroot/course/account.php";
  notice('<br /><br /><b>You have not logged in. Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}

$PAGE->set_title('Peoples-uni Student Account');
$PAGE->set_heading('Peoples-uni Student Account');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');

echo '<div align="center">';
echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';

echo "<p><b>";

echo '<br /><br />' . $fullname . '<br />';

$inmmumph = FALSE;
$mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE userid=$userid ORDER BY datesubmitted DESC LIMIT 1");
if (!empty($mphs)) {
  foreach ($mphs as $mph) {
    $inmmumph = TRUE;
    echo '<br />You were Enrolled in MPH on ' . gmdate('d/m/Y H:i', $mph->datesubmitted) . '<br />';
  }
}

echo "</b></p>";

$balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} ORDER BY date");
if (!empty($balances)) {
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
  echo '<br />No Transactions';
}

$payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));
if (!empty($payment_schedule)) {
  echo '<br /><br /><br />';
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
}


$worldpay_receipts = $DB->get_records_sql("
  SELECT
    b.id,
    b.userid,
    a.sid,
    b.amount_delta,
    b.currency,
    b.date,
    a.state,
    a.coursename1,
    a.coursename2,
    a.semester
  FROM       mdl_peoples_student_balance b
  INNER JOIN mdl_peoplesapplication a ON b.userid=a.userid AND a.datepaid<=b.date AND b.date<a.datepaid+10
  WHERE
    b.userid=? AND
    b.detail LIKE 'WorldPay %'",
  array($userid));

$peoples_fee_receipts = $DB->get_records('peoples_fee_receipt', array('userid' => $userid), 'date ASC');

foreach ($worldpay_receipts as $worldpay_receipt) {
  $found = FALSE;
  foreach ($peoples_fee_receipts as $peoples_fee_receipt) {
    if ($worldpay_receipt->date == $peoples_fee_receipt->date) {
      $found = TRUE;
    }
  }
  if (!$found) {

    if (empty($worldpay_receipt->coursename2)) {
      $modulespurchasedlong = "Peoples-uni module '$worldpay_receipt->coursename1' for semester '$worldpay_receipt->semester'";
    }
    else {
      $state = (int)$worldpay_receipt->state;
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
        $modulespurchasedlong = "Peoples-uni module '$worldpay_receipt->coursename1' for semester '$worldpay_receipt->semester'";
      }
      elseif ($module_2_approved && !$module_1_approved) {
        $modulespurchasedlong = "Peoples-uni module '$worldpay_receipt->coursename2' for semester '$worldpay_receipt->semester'";
      }
      else {
        $modulespurchasedlong = "Peoples-uni modules '$worldpay_receipt->coursename1' and '$worldpay_receipt->coursename2' for semester '$worldpay_receipt->semester'";
      }
    }

    $peoples_fee_receipt = new stdClass();
    $peoples_fee_receipt->userid       = $worldpay_receipt->userid;
    $peoples_fee_receipt->sid          = $worldpay_receipt->sid;
    $peoples_fee_receipt->date         = $worldpay_receipt->date;
    $peoples_fee_receipt->amount       = -$worldpay_receipt->amount_delta;
    $peoples_fee_receipt->currency     = $worldpay_receipt->currency;
    $peoples_fee_receipt->firstname    = $userrecord->firstname;
    $peoples_fee_receipt->lastname     = $userrecord->lastname;
    $peoples_fee_receipt->name_payee   = '';
    $peoples_fee_receipt->modules      = $modulespurchasedlong;
    $peoples_fee_receipt->receipt_flag = 0;
    $DB->insert_record('peoples_fee_receipt', $peoples_fee_receipt);
  }
}

$peoples_fee_receipts = $DB->get_records('peoples_fee_receipt', array('userid' => $userid), 'date ASC');

if (!empty($peoples_fee_receipts)) {
  echo '<br /><br />';
  echo '<b>Download a Receipt by right clicking on one of the links below...</b><br />';
  echo '(When your Receipt appears, you can print it by clicking the Adobe Acrobat print icon on the top left)<br /><br />';

  foreach ($peoples_fee_receipts as $peoples_fee_receipt) {
    $cur = ($peoples_fee_receipt->currency == 'GBP') ? 'UK Pounds' : $peoples_fee_receipt->currency;
    $wording = gmdate('d/m/Y', $peoples_fee_receipt->date) . ":&nbsp;&nbsp;{$peoples_fee_receipt->amount} $cur for " . htmlspecialchars($peoples_fee_receipt->modules, ENT_COMPAT, 'UTF-8');
    echo '<a href="' . $CFG->wwwroot . '/course/fee_receipt.php?id=' . $peoples_fee_receipt->id . '" target="_blank">' . $wording . '</a><br />';
  }
}

echo '<br /><br />';
echo '</div>';

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
?>
