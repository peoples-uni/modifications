<?php

// peoples_tutor_cv.php

// Disable moodle specific debug messages and any errors in output.
define('NO_DEBUG_DISPLAY', true);

require_once('../config.php');
require_once('../lib/filelib.php');

require_capability('moodle/site:viewparticipants', context_system::instance());

$relativepath = get_file_argument();
$forcedownload = optional_param('forcedownload', 0, PARAM_BOOL);
$preview = optional_param('preview', null, PARAM_ALPHANUM);

// relative path must start with '/'
if (!$relativepath) {
  print_error('invalidargorconf');
} else if ($relativepath[0] != '/') {
  print_error('pathdoesnotstartslash');
}

// extract relative path components
$args = explode('/', ltrim($relativepath, '/'));

if (count($args) < 3) { // always at least context, component and filearea
  print_error('invalidarguments');
}

$contextid = (int)array_shift($args);
$component = clean_param(array_shift($args), PARAM_COMPONENT);
$filearea  = clean_param(array_shift($args), PARAM_AREA);

$fs = get_file_storage();

$filename = array_pop($args);
$filepath = $args ? '/'.implode('/', $args).'/' : '/';
error_log("filepath:$filepath, filename:$filename");
if (!$file = $fs->get_file($contextid, 'peoples_record_tutor', 'tutor', 0, $filepath, $filename) or $file->is_directory()) {
  send_file_not_found();
}

// finally send the file
send_stored_file($file, null, 0, false, array('preview' => $preview));

send_file_not_found();
