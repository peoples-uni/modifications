<?php  // $Id: account.php,v 1.1 2009/09/14 12:00:00 alanbarrett Exp $
/**
*
* Show account details for a Student
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/account.php');
$PAGE->set_pagelayout('standard');

require_login();
// (Might possibly be Guest?)

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$userid = $USER->id;
if (empty($userid)) {echo '<h1>$userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$PAGE->set_title('Peoples-uni Student Account');
$PAGE->set_heading('Peoples-uni Student Account');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');

echo '<div align="center">';
echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';

echo "<p><b>";
echo '<br /><br />' . fullname($userrecord) . '<br />';

$inmmumph = FALSE;
$mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE userid=$userid ORDER BY datesubmitted DESC LIMIT 1");
if (!empty($mphs)) {
  foreach ($mphs as $mph) {
    $inmmumph = TRUE;
    echo '<br />You were Enrolled in MMU MPH on ' . gmdate('d/m/Y H:i', $mph->datesubmitted) . '<br />';
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
    'Balance &pound;s (+ve means the Student Owes Peoples-uni)',
  );

  foreach ($balances as $balance) {
    $rowdata = array();
    $rowdata[] = gmdate('d/m/Y H:i', $balance->date);
    $rowdata[] = htmlspecialchars($balance->detail, ENT_COMPAT, 'UTF-8');
    $rowdata[] = number_format($balance->amount_delta, 2);
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

echo '<br /><br />';
echo '</div>';

echo $OUTPUT->box_end();
echo $OUTPUT->footer();


function get_balance($userid) {
  global $DB;

  $balances = $DB->get_records_sql("SELECT * FROM mdl_peoples_student_balance WHERE userid={$userid} ORDER BY date DESC, id DESC LIMIT 1");
  $amount = 0;
  if (!empty($balances)) {
    foreach ($balances as $balance) {
      $amount = $balance->balance;
    }
  }

  return $amount;
}


function amount_to_pay($userid) {
  global $DB;

  $amount = get_balance($userid);

  $inmmumph = FALSE;
  $mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE userid={$userid} AND userid!=0 LIMIT 1");
  if (!empty($mphs)) {
    foreach ($mphs as $mph) {
      $inmmumph = TRUE;
    }
  }

  $payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));

  if ($inmmumph) {
    // MPH: Take Outstanding Balance and adjust for instalments if necessary
    if (!empty($payment_schedule)) {
      $now = time();
      if     ($now < $payment_schedule->expect_amount_2_date) $amount -= ($payment_schedule->amount_2 + $payment_schedule->amount_3 + $payment_schedule->amount_4);
      elseif ($now < $payment_schedule->expect_amount_3_date) $amount -= (                              $payment_schedule->amount_3 + $payment_schedule->amount_4);
      elseif ($now < $payment_schedule->expect_amount_4_date) $amount -= (                                                            $payment_schedule->amount_4);
      // else the full balance should be paid (which is normally equal to amount_4, but the balance might have been adjusted or the student still might not be up to date with payments)
    }
  }

  if ($amount < 0) $amount = 0;
  return $amount;
}
?>
