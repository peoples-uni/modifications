<?php  // $Id: test.php,v 1.1 2008/08/02 17:18:32 alanbarrett Exp $

require("../config.php");
require_once($CFG->dirroot .'/course/lib.php');

require_login();

require_capability('moodle/site:config', context_system::instance());

?><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

$id = 24;
$teacher = get_teacher($id);
echo "For ID $id Teacher email is: $teacher->email <br />";
$id = 25;
$teacher = get_teacher($id);
echo "For ID $id Teacher email is: $teacher->email <br />";
$id = 29;
$teacher = get_teacher($id);
echo "For ID $id Teacher email is: $teacher->email <br />";
$id = 26;
$teacher = get_teacher($id);
echo "For ID $id Teacher email is: $teacher->email <br />";
$id = 27;
$teacher = get_teacher($id);
echo "For ID $id Teacher email is: $teacher->email <br />";
$id = 28;
$teacher = get_teacher($id);
echo "For ID $id Teacher email is: $teacher->email <br />";

?>
</body>
</html>
