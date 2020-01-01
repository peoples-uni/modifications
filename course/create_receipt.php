<?php  // create_receipt.php 20151109
/**
*
* Create a Receipt
*
*/

/*
CREATE TABLE mdl_peoples_fee_receipt (
  id BIGINT(10) UNSIGNED NOT NULL auto_increment,
  userid BIGINT(10) UNSIGNED NOT NULL,
  sid BIGINT(10) UNSIGNED NOT NULL,
  date BIGINT(10) UNSIGNED NOT NULL,
  amount VARCHAR(255) NOT NULL,
  currency VARCHAR(20) NOT NULL DEFAULT 'GBP',
  firstname VARCHAR(255) NOT NULL,
  lastname VARCHAR(255) NOT NULL,
  name_payee VARCHAR(255) NOT NULL default '',
  modules VARCHAR(2000) NOT NULL,
  receipt_flag BIGINT(10) UNSIGNED NOT NULL DEFAULT 0,
  INDEX (userid),
  CONSTRAINT PRIMARY KEY (id)
);
*/


require("../config.php");

$PAGE->set_context(context_system::instance());

$PAGE->set_url('/course/create_receipt.php');
$PAGE->set_pagelayout('standard');

require_login();

require_capability('moodle/site:viewparticipants', context_system::instance());

$PAGE->set_title('Create Receipt');
$PAGE->set_heading('Create Receipt');
echo $OUTPUT->header();

$userid = 0;
$amount = '';
$currency = 'GBP';
$modules = '';
$name_payee = '';
$sid = 0;

if (!empty($_POST['id']) && !empty($_POST['amount']) && !empty($_POST['markupdatecertificate']) && !empty($_POST['updatecertificate'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $peoples_fee_receipt = new stdClass();
	$_POST['id'] = (int)$_POST['id'];
	if (empty($_POST['id'])) {
    notice('Bad ID!', "$CFG->wwwroot/index.php");
	}
  $peoples_fee_receipt->id         = $_POST['id'];
  $peoples_fee_receipt->sid        = (int)$_POST['sid'];
  $peoples_fee_receipt->amount     = $_POST['amount'];
  $peoples_fee_receipt->currency   = $_POST['currency'];
  $peoples_fee_receipt->name_payee = $_POST['name_payee'];
  $peoples_fee_receipt->modules    = $_POST['modules'];
  $DB->update_record('peoples_fee_receipt', $peoples_fee_receipt);

	$id = $_POST['id'];
}
elseif (!empty($_POST['userid']) && !empty($_POST['amount']) && !empty($_POST['markupdatecertificate']) && !empty($_POST['createcertificate'])) {
	if (!confirm_sesskey()) print_error('confirmsesskeybad', 'error');
  $peoples_fee_receipt = new stdClass();

  $peoples_fee_receipt->userid = $_POST['userid'];
  $userrecord = $DB->get_record('user', array('id' => $peoples_fee_receipt->userid));

  if (empty($_POST['sid'])) $_POST['sid'] = 0;
  $peoples_fee_receipt->sid = (int)$_POST['sid'];

  $peoples_fee_receipt->date = time();

  $peoples_fee_receipt->amount = $_POST['amount'];

  if (empty($_POST['currency'])) $_POST['currency'] = 'GBP';
  $peoples_fee_receipt->currency = $_POST['currency'];

  $peoples_fee_receipt->firstname    = $userrecord->firstname;
  $peoples_fee_receipt->lastname     = $userrecord->lastname;
  $peoples_fee_receipt->name_payee   = $_POST['name_payee'];
  $peoples_fee_receipt->modules      = $_POST['modules'];

  $id = $DB->insert_record('peoples_fee_receipt', $peoples_fee_receipt);
}

if (!empty($id)) {
  $peoples_fee_receipt = $DB->get_record('peoples_fee_receipt', array('id' => $id));
  $userid     = $peoples_fee_receipt->userid;
  $amount     = $peoples_fee_receipt->amount;
  $currency   = $peoples_fee_receipt->currency;
  $modules    = $peoples_fee_receipt->modules;
  $name_payee = $peoples_fee_receipt->name_payee;
  $sid        = $peoples_fee_receipt->sid;

  echo '<a href="' . $CFG->wwwroot . '/course/fee_receipt.php?id=' . $id . '" target="_blank">Click THIS LINK to Preview Receipt</a><br />';
?>
<br />Change the text and then click "Update Receipt"...<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR
<?php
}
else {
	$id = '';
}
?>
<br />Enter something in at least the Student and Amount fields and then click "Create New Receipt"...<br />
<form id="updatecertificateform" method="post" action="<?php echo $CFG->wwwroot . '/course/create_receipt.php'; ?>">
<input type="hidden" name="id" value="<?php echo $id ?>" />

Student:&nbsp;<?php
//$students = $DB->get_records_sql("SELECT DISTINCT e.userid, CONCAT(u.lastname, ', ', u.firstname) AS name FROM mdl_enrolment e, mdl_user u WHERE e.userid=u.id ORDER BY TRIM(u.lastname) ASC, TRIM(u.firstname) ASC, u.id ASC");
$students = $DB->get_records_sql("SELECT DISTINCT u.id AS userid, CONCAT(u.lastname, ', ', u.firstname) AS name FROM mdl_user u ORDER BY TRIM(u.lastname) ASC, TRIM(u.firstname) ASC, u.id ASC");

if (!empty($userid)) $selectedvalue = $students[$userid]->name;
else                 $selectedvalue = '';

$student_userid_to_names = array();
foreach ($students as $student) {
  $student_userid_to_names[$student->userid] = $student->name;
}

displaynumericoptions('userid', $student_userid_to_names, $selectedvalue);
?><br />

Amount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="100" name="amount" value="<?php echo htmlspecialchars($amount, ENT_COMPAT, 'UTF-8'); ?>" style="width:30em" /><br />
Currency:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="100" name="currency" value="<?php echo htmlspecialchars($currency, ENT_COMPAT, 'UTF-8'); ?>" style="width:30em" /><br />
Modules:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="100" name="modules" value="<?php echo htmlspecialchars($modules, ENT_COMPAT, 'UTF-8'); ?>" style="width:30em" /><br />
Name of Payee (if different from Student):&nbsp;<input type="text" size="100" name="name_payee" value="<?php echo htmlspecialchars($name_payee, ENT_COMPAT, 'UTF-8'); ?>" style="width:30em" /><br />
SID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="100" name="sid" value="<?php echo $sid; ?>" style="width:30em" /><br />
<input type="hidden" name="sesskey" value="<?php echo $USER->sesskey ?>" />
<input type="hidden" name="markupdatecertificate" value="1" />

<?php
if (!empty($id)) {
?>
<br /><input type="submit" name="updatecertificate" value="Update Receipt" style="width:40em" />
<?php
}
?>
<br />
<br /><input type="submit" name="createcertificate" value="Create New Receipt" style="width:40em" />
</form>
<br />
<?php

if (!empty($id)) {
  echo 'Send this EXACT link to Receipt Recipient: <a href="' . $CFG->wwwroot . '/course/display_receipt.php?id=' . $id . '" target="_blank">' . $CFG->wwwroot . '/course/display_receipt.php?id=' . $id . '</a><br />';
  echo 'Or ask them to go to: <a href="' . $CFG->wwwroot . '/course/student_receipts.php?id=' . $userid . '" target="_blank">' . $CFG->wwwroot . '/course/student_receipts.php</a><br />';
  echo '(They will also see their receipts at ' . $CFG->wwwroot . '/course/account.php .)<br /><br />'; 
}

?>
<br/><strong><a href="javascript:window.close();">Close Window</a></strong><br />
<br /><a href="<?php echo $CFG->wwwroot ?>/course/list_receipts.php">List All Receipts</a>
<br />
<?php

echo $OUTPUT->footer();


function displaynumericoptions($name, $options, $selectedvalue) {
  echo '<td><select name="' . $name . '">';
  foreach ($options as $key => $option) {
    if ($option === $selectedvalue) $selected = 'selected="selected"';
    else $selected = '';

    $opt = htmlspecialchars($option, ENT_COMPAT, 'UTF-8');
    echo '<option value="' . $key . '" ' . $selected . '>' . $opt . '</option>';
  }
  echo '</select></td>';
}
?>
