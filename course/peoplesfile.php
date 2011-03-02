<?php
// peoplesfile.php 20110209
// Serve up a file to browser

require_once('../config.php');
require_once('../lib/filelib.php');

$relativepath = get_file_argument();
$forcedownload = optional_param('forcedownload', 0, PARAM_BOOL);

if (!$relativepath) {
  print_error('invalidargorconf');
}
elseif (strpos($relativepath, '/moddata/assignmentsubmissionrecord/') === false) {
  print_error('invalidargorconf'); // Only allow for assignmentsubmissionrecord files!
}
elseif ($relativepath[0] != '/') {
  print_error('pathdoesnotstartslash');
}

$args = explode('/', ltrim($relativepath, '/'));

$filename = $args[count($args)-1];

send_file($CFG->dataroot . $relativepath, $filename, 'default', 0, false, true);
?>
