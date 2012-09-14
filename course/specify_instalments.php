<?php  // $Id: specify_instalments.php,v 1.1 2012/07/16 15:27:00 alanbarrett Exp $
/**
*
* Specify Instalments for a Student
*
*/

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/specify_instalments.php');
$PAGE->set_pagelayout('standard');


require_login();
// (Might possibly be Guest?)

if (empty($USER->id)) {echo '<h1>Not properly logged in, should not happen!</h1>'; die();}

// Full access is given by the "Manager" role which has moodle/site:viewparticipants
// (administrator also has moodle/site:viewparticipants)
$ismanager = has_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM));

$userid = optional_param('userid', 0, PARAM_INT);
if (empty($userid) || !$ismanager) $userid = $USER->id;
if (empty($userid)) {echo '<h1>$userid empty(), should not happen!</h1>'; die();}

$userrecord = $DB->get_record('user', array('id' => $userid));
if (empty($userrecord)) {
  echo '<h1>User does not exist!</h1>';
  die();
}

$amount_to_pay_total = get_balance($userid);


$PAGE->set_title('Specify Instalments');
$PAGE->set_heading('Specify Instalments');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');


if (!empty($_POST['markspecifyinstalments'])) {
  if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');

  if (!isset($_POST['amount_1']) || !is_numeric($_POST['amount_1'])) notice('Instalment 1 must be a number. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if (!isset($_POST['amount_2']) || !is_numeric($_POST['amount_2'])) notice('Instalment 2 must be a number. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if (!isset($_POST['amount_3']) || !is_numeric($_POST['amount_3'])) notice('Instalment 3 must be a number. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if (!isset($_POST['amount_4']) || !is_numeric($_POST['amount_4'])) notice('Instalment 4 must be a number. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if ($_POST['amount_4'] != 0.0 && $_POST['amount_3'] == 0.0) notice('Instalment 3 must be non-zero if Instalment 4 is non-zero. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if ($_POST['amount_4'] != 0.0 && $_POST['amount_2'] == 0.0) notice('Instalment 2 must be non-zero if Instalment 4 is non-zero. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if ($_POST['amount_3'] != 0.0 && $_POST['amount_2'] == 0.0) notice('Instalment 2 must be non-zero if Instalment 3 is non-zero. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if (                             ($_POST['amount_1']/$amount_to_pay_total) <= 0.24) notice('Instalment 1 must be at least 25% of the amount owed (UK Pounds ' . $amount_to_pay_total . '). Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if ($_POST['amount_2'] != 0.0 && ($_POST['amount_2']/$amount_to_pay_total) <= 0.24) notice('Instalment 2 must be at least 25% of the amount owed (UK Pounds ' . $amount_to_pay_total . '), or it can be zero if there is only 1 instalment. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if ($_POST['amount_3'] != 0.0 && ($_POST['amount_3']/$amount_to_pay_total) <= 0.24) notice('Instalment 3 must be at least 25% of the amount owed (UK Pounds ' . $amount_to_pay_total . '), or it can be zero if there are only 2 instalments. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if ($_POST['amount_4'] != 0.0 && ($_POST['amount_4']/$amount_to_pay_total) <= 0.24) notice('Instalment 4 must be at least 25% of the amount owed (UK Pounds ' . $amount_to_pay_total . '), or it can be zero. Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");
  if (abs($_POST['amount_1'] + $_POST['amount_2'] + $_POST['amount_3'] + $_POST['amount_4'] - $amount_to_pay_total) > .01) notice('Total must add up to amount owed (UK Pounds ' . $amount_to_pay_total . '). Press Continue and re-specify amounts.', "$CFG->wwwroot/course/specify_instalments.php?userid=$userid");

  $peoples_payment_schedule = $DB->get_record('peoples_payment_schedule', array('userid' => $userid));
  if (empty($peoples_payment_schedule)) {
    $peoples_payment_schedule = new object();
    $insert = TRUE;
    $peoples_payment_schedule->userid = $userid;
    $peoples_payment_schedule->currency = 'GBP';
  }
  else {
    $insert = FALSE;
  }
  $peoples_payment_schedule->amount_1 = $_POST['amount_1'];
  $peoples_payment_schedule->amount_2 = $_POST['amount_2'];
  $peoples_payment_schedule->amount_3 = $_POST['amount_3'];
  $peoples_payment_schedule->amount_4 = $_POST['amount_4'];

  $year = (int)gmdate('Y');
  $month = (int)gmdate('n');
  if ($month <= 6) {
    $peoples_payment_schedule->expect_amount_1_date = gmmktime(0, 0, 0,  1, 1, $year);
    $peoples_payment_schedule->due_date_1           = gmmktime(0, 0, 0,  4, 1, $year);
    $peoples_payment_schedule->expect_amount_2_date = gmmktime(0, 0, 0,  7, 1, $year);
    $peoples_payment_schedule->due_date_2           = gmmktime(0, 0, 0, 10, 1, $year);
    $peoples_payment_schedule->expect_amount_3_date = gmmktime(0, 0, 0,  1, 1, $year + 1);
    $peoples_payment_schedule->due_date_3           = gmmktime(0, 0, 0,  4, 1, $year + 1);
    $peoples_payment_schedule->expect_amount_4_date = gmmktime(0, 0, 0,  7, 1, $year + 1);
    $peoples_payment_schedule->due_date_4           = gmmktime(0, 0, 0, 10, 1, $year + 1);
  }
  else {
    $peoples_payment_schedule->expect_amount_1_date = gmmktime(0, 0, 0,  7, 1, $year);
    $peoples_payment_schedule->due_date_1           = gmmktime(0, 0, 0, 10, 1, $year);
    $peoples_payment_schedule->expect_amount_2_date = gmmktime(0, 0, 0,  1, 1, $year + 1);
    $peoples_payment_schedule->due_date_2           = gmmktime(0, 0, 0,  4, 1, $year + 1);
    $peoples_payment_schedule->expect_amount_3_date = gmmktime(0, 0, 0,  7, 1, $year + 1);
    $peoples_payment_schedule->due_date_3           = gmmktime(0, 0, 0, 10, 1, $year + 1);
    $peoples_payment_schedule->expect_amount_4_date = gmmktime(0, 0, 0,  1, 1, $year + 2);
    $peoples_payment_schedule->due_date_4           = gmmktime(0, 0, 0,  4, 1, $year + 2);
  }

  $peoples_payment_schedule->user_who_modified = $USER->id;
  $peoples_payment_schedule->date_modified = time();
  if ($insert) {
    $DB->insert_record('peoples_payment_schedule', $peoples_payment_schedule);
  }
  else {
    $DB->update_record('peoples_payment_schedule', $peoples_payment_schedule);
  }
}


echo '<div align="center">';
//echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';

echo '<p>';

$fullname = fullname($userrecord);
echo '<br /><br /><b>' . $fullname . '</b>';

$inmmumph = FALSE;
$mphs = $DB->get_records_sql("SELECT * FROM mdl_peoplesmph WHERE userid={$userid} AND userid!=0 LIMIT 1");
if (!empty($mphs)) {
  foreach ($mphs as $mph) {
    $inmmumph = TRUE;
  }
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

echo '</p>';

if ($inmmumph && (empty($payment_schedule) || $ismanager)) {
?>
<br /><p>Specify the Payment Schedule and then click "Submit the Instalment Payment Schedule".<br />
You can enter up to four instalments.<br />
Any individual (non zero) instalment must be at least 25% of what is owed (UK Pounds <?php echo $amount_to_pay_total ?>).<br />

<?php
  if (!$ismanager) {
    echo '<b>Note: You can only enter this schedule once!</b><br />';
    echo '<b>Note: All payments must be completed before you start your Masters dissertation,</b><br />';
    echo '<b>please choose instalments accordingly! If this is a problem please e-mail <a href="mailto:payments@peoples-uni.org?subject=Instalment query">payments@peoples-uni.org</a></b><br />';
  }

  $year = (int)gmdate('Y');
  $month = (int)gmdate('n');
  if ($month <= 6) {
    $peoples_payment_schedule->expect_amount_1_date = gmmktime(0, 0, 0,  1, 1, $year);
    $peoples_payment_schedule->due_date_1           = gmmktime(0, 0, 0,  4, 1, $year);
    $peoples_payment_schedule->expect_amount_2_date = gmmktime(0, 0, 0,  7, 1, $year);
    $peoples_payment_schedule->due_date_2           = gmmktime(0, 0, 0, 10, 1, $year);
    $peoples_payment_schedule->expect_amount_3_date = gmmktime(0, 0, 0,  1, 1, $year + 1);
    $peoples_payment_schedule->due_date_3           = gmmktime(0, 0, 0,  4, 1, $year + 1);
    $peoples_payment_schedule->expect_amount_4_date = gmmktime(0, 0, 0,  7, 1, $year + 1);
    $peoples_payment_schedule->due_date_4           = gmmktime(0, 0, 0, 10, 1, $year + 1);
  }
  else {
    $peoples_payment_schedule->expect_amount_1_date = gmmktime(0, 0, 0,  7, 1, $year);
    $peoples_payment_schedule->due_date_1           = gmmktime(0, 0, 0, 10, 1, $year);
    $peoples_payment_schedule->expect_amount_2_date = gmmktime(0, 0, 0,  1, 1, $year + 1);
    $peoples_payment_schedule->due_date_2           = gmmktime(0, 0, 0,  4, 1, $year + 1);
    $peoples_payment_schedule->expect_amount_3_date = gmmktime(0, 0, 0,  7, 1, $year + 1);
    $peoples_payment_schedule->due_date_3           = gmmktime(0, 0, 0, 10, 1, $year + 1);
    $peoples_payment_schedule->expect_amount_4_date = gmmktime(0, 0, 0,  1, 1, $year + 2);
    $peoples_payment_schedule->due_date_4           = gmmktime(0, 0, 0,  4, 1, $year + 2);
  }
?>

<form id="specifyinstalmentsform" method="post" action="<?php echo $CFG->wwwroot . '/course/specify_instalments.php?userid=' . $userid; ?>">

<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />

Instalment (UK Pounds) due on or before <?php echo gmdate('d/m/Y', $peoples_payment_schedule->due_date_1); ?>: <input type="text" size="10" name="amount_1" value="<?php echo $amount_to_pay_total ?>" /><br />
Instalment (UK Pounds) due on or before <?php echo gmdate('d/m/Y', $peoples_payment_schedule->due_date_2); ?>: <input type="text" size="10" name="amount_2" value="0" /><br />
Instalment (UK Pounds) due on or before <?php echo gmdate('d/m/Y', $peoples_payment_schedule->due_date_3); ?>: <input type="text" size="10" name="amount_3" value="0" /><br />
Instalment (UK Pounds) due on or before <?php echo gmdate('d/m/Y', $peoples_payment_schedule->due_date_4); ?>: <input type="text" size="10" name="amount_4" value="0" /><br />

<input type="hidden" name="markspecifyinstalments" value="1" />
<input type="submit" name="specifyinstalments" value="Submit the Instalment Payment Schedule" />
</form>

<?php
}
else {
  if ($ismanager) {
    echo '<b>This Student is not in the MMU MPH!</b><br />';
  }
  else {
    if (!$inmmumph) {
      if (empty($fullname) || trim($fullname) == 'Guest User') {
        notice('You have not logged in. Please press "Continue" and log in with your username and password above!', "$CFG->wwwroot/course/specify_instalments.php");
      }
      else {
        echo '<b>You are not in the MMU MPH so cannot specify instalments!</b><br />';
      }
    }
    else {
      echo '<b>You have already set your payment schedule. If there is a need to change it please e-mail <a href="mailto:payments@peoples-uni.org?subject=Instalment query">payments@peoples-uni.org</a></b><br />';
    }
  }
}

echo '<br /><br /></div>';

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
