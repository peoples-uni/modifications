<?php  // list_receipts.php 20151109
/**
*
* List Receipts
*
*/

require("../config.php");

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/list_receipts.php');
$PAGE->set_pagelayout('standard');

require_login();

require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('List Receipts');
$PAGE->set_heading('List Receipts');
echo $OUTPUT->header();


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
    b.detail LIKE 'WorldPay %'");

$peoples_fee_receipts = $DB->get_records('peoples_fee_receipt');

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

    $userrecord = $DB->get_record('user', array('id' => $worldpay_receipt->userid));
    if (empty($userrecord)) { // Just in case someone deleted a record?
      $userrecord = new object();
      $userrecord->firstname = 'missing';
      $userrecord->lastname = 'missing';
    }

    $peoples_fee_receipt = new object();
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


$peoples_fee_receipts = $DB->get_records('peoples_fee_receipt', NULL, 'lastname ASC, firstname ASC, date ASC');

echo '<table border="1" BORDERCOLOR="RED">';

foreach ($peoples_fee_receipts as $peoples_fee_receipt) {
	echo '<tr>';
	echo '<td>';
  echo '<a href="' . $CFG->wwwroot . '/course/display_receipt.php?id=' . $peoples_fee_receipt->id . '" target="_blank">' . $CFG->wwwroot . '/course/display_receipt.php?id=' . $peoples_fee_receipt->id . '</a>';
	echo '</td>';
	echo '<td>';
?>
<form method="post" action="<?php echo $CFG->wwwroot . '/course/create_receipt.php'; ?>" target="_blank">
<input type="hidden" name="id" value="<?php echo $peoples_fee_receipt->id; ?>" />
<input type="hidden" name="userid" value="<?php echo $peoples_fee_receipt->userid; ?>" />
<input type="hidden" name="sid" value="<?php echo $peoples_fee_receipt->sid; ?>" />
<input type="hidden" name="date" value="<?php echo $peoples_fee_receipt->date; ?>" />
<input type="hidden" name="amount" value="<?php echo htmlspecialchars($peoples_fee_receipt->amount, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="currency" value="<?php echo htmlspecialchars($peoples_fee_receipt->currency, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="firstname" value="<?php echo htmlspecialchars($peoples_fee_receipt->firstname, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="lastname" value="<?php echo htmlspecialchars($peoples_fee_receipt->lastname, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="name_payee" value="<?php echo htmlspecialchars($peoples_fee_receipt->name_payee, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="modules" value="<?php echo htmlspecialchars($peoples_fee_receipt->modules, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="receipt_flag" value="<?php echo $peoples_fee_receipt->receipt_flag; ?>" />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdatecertificate" value="1" />
<input type="submit" name="updatecertificate" value="Edit" />
</form>
<?php
	echo '</td>';
  echo '<td>';
  echo htmlspecialchars( $peoples_fee_receipt->lastname . ', ' . $peoples_fee_receipt->firstname, ENT_COMPAT, 'UTF-8');
  echo '</td>';
  echo '<td>';
  echo gmdate('d/m/Y', $peoples_fee_receipt->date);
  echo '</td>';
  echo '<td>';
  echo htmlspecialchars($peoples_fee_receipt->amount . ' ' . (($peoples_fee_receipt->currency == 'GBP') ? 'UK Pounds' : $peoples_fee_receipt->currency), ENT_COMPAT, 'UTF-8');
  echo '</td>';
  echo '<td>';
  echo htmlspecialchars($peoples_fee_receipt->modules, ENT_COMPAT, 'UTF-8');
  echo '</td>';
  echo '<td>';
  echo 'SID:' . $peoples_fee_receipt->sid;
  echo '</td>';
	echo '</tr>';
}

echo '</table>';

?>
<br /><br /><a href="<?php echo $CFG->wwwroot ?>/course/create_receipt.php" target="_blank">Create New Receipt</a>
<?php

echo $OUTPUT->footer();
?>
