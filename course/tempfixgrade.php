<?php  // tempfixgrade.php

// Now replaced by preg_replace in student.php

// It also happens when you paste into a discussion forum, and I guess this is a Moodle problem...
// select SUBSTRING(feedback,1,3000) from mdl_grade_grades WHERE id=176;
// Has "&amp;lt;!-- /* Font Definitions */" in DB!
// ((
// http://courses.peoples-uni.org/mod/assignment/submissions.php?id=562
// luma beaty [mailto:lumabeaty@yahoo.co.uk]
// ))
// I looked up Moodle bugs and found reference to our problem...
// http://tracker.moodle.org/browse/MDL-16621
// http://moodle.org/mod/forum/discuss.php?d=107186
// http://moodle.org/mod/forum/discuss.php?d=109597
// It seems to be a Firefox and Word issue. Unfortunately it is not planned to fix this until Moodle 2.0.
// It seems that the Clean HTML feature does not (fully) solve the issue.


require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

require_login();


print_header('tempfixgrade.php');

$grades = get_records_sql('select id, feedback from mdl_grade_grades WHERE id=176;');
foreach ($grades as $key => $grade) {

	echo $grade->feedback;

	$grade->feedback = str_replace('&amp;lt;!--', '<!--', $grade->feedback);
	$grade->feedback = str_replace('--&amp;gt;', '-->', $grade->feedback);

	echo '#################################################################<br />';
	echo $grade->feedback;

	$grade->feedback = addslashes($grade->feedback);

	update_record('grade_grades', $grade);
}

echo '<br /><br /><br />';

notice(get_string('continue'), "$CFG->wwwroot/");
?>
