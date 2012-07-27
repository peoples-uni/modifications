<?php  // $Id: temp_set_balance.php,v 1.1 2012/07/27 17:37:00 alanbarrett Exp $
/**
*
* Temporary Script to Update Accumulating Balance based on individual Balance items
*
*/


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/course/temp_set_balance.php');
$PAGE->set_pagelayout('standard');

require_login();
require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM));

$PAGE->set_title('Set Balances');
$PAGE->set_heading('Set Balances');
echo $OUTPUT->header();

echo $OUTPUT->box_start('generalbox boxaligncenter');

echo '<div align="center">';
echo '<p><img alt="Peoples-uni" src="tapestry_logo.jpg" /></p>';

echo "<p><b>";
echo "<br />";

$userids = $DB->get_records_sql('
  SELECT DISTINCT userid
  FROM mdl_peoples_student_balance
  ORDER BY userid');
foreach ($userids as $useridrow) {
  $userid = $useridrow->userid;

  $balances = $DB->get_records_sql("
    SELECT *
    FROM mdl_peoples_student_balance
    WHERE userid=$userid
    ORDER BY date");
  $total = 0;
  $count = 0;
  foreach ($balances as $balance) {
    $total += $balance->amount_delta;
    $balance->balance = $total;
    $DB->update_record('peoples_student_balance', $balance);
    $count++;
  }
  echo "<br />Total for userid: $userid ($count records) is: $total";
}

echo "</b></p>";
echo '</div>';

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
?>
