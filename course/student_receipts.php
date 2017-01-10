<?php  // student_receipts.php 20151109
/**
*
* List a Student's Receipts
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/course/peoples_lib.php');

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/student_receipts.php'); // Defined here to avoid notices on errors etc
$PAGE->set_pagelayout('standard'); // Standard layout with blocks, this is recommended for most pages with general information

require_login();
// Might possibly be Guest... Anyway Guest user will not have any enrolment
if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

$islurker = has_capability('moodle/grade:viewall', context_system::instance());

$userid = optional_param('id', 0, PARAM_INT);
if (empty($userid) || !$islurker) $userid = $USER->id;
if (empty($userid)) {echo '<h1>$userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$fullname = fullname($userrecord);
if (empty($fullname) || trim($fullname) == 'Guest User') {
  $SESSION->wantsurl = "$CFG->wwwroot/course/student_receipts.php";
  notice('<br /><br /><b>You have not logged in. Please log in with your username and password above!</b><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');
}

$PAGE->set_title('Receipts for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
$PAGE->set_heading('Receipts for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8'));
echo $OUTPUT->header();

echo '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $userid . '" target="_blank">User Profile for ' . htmlspecialchars($userrecord->firstname . ' ' . $userrecord->lastname, ENT_COMPAT, 'UTF-8') . '</a>, e-mail: ' . $userrecord->email;
echo ', Last access: ' . ($userrecord->lastaccess ? format_time(time() - $userrecord->lastaccess) : get_string('never'));
echo '<br /><br />';

echo '<b>Download a Receipt by right clicking on one of the links below...</b><br />';
echo '(When your Receipt appears, you can print it by clicking the Adobe Acrobat print icon on the top left)<br /><br />';

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

if (empty($peoples_fee_receipts)) {
  Echo 'No Receipts<br />';
}
else {
  foreach ($peoples_fee_receipts as $peoples_fee_receipt) {
    $cur = ($peoples_fee_receipt->currency == 'GBP') ? 'UK Pounds' : $peoples_fee_receipt->currency;
    $wording = gmdate('d/m/Y', $peoples_fee_receipt->date) . ":&nbsp;&nbsp;{$peoples_fee_receipt->amount} $cur for " . htmlspecialchars($peoples_fee_receipt->modules, ENT_COMPAT, 'UTF-8');
    echo '<a href="' . $CFG->wwwroot . '/course/fee_receipt.php?id=' . $peoples_fee_receipt->id . '" target="_blank">' . $wording . '</a><br />';
  }
}

echo '<br /><br /><br />';
echo '<strong><a href="javascript:window.close();">Close Window</a></strong>';

echo $OUTPUT->footer();
?>
