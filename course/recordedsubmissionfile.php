<?php
// recordedsubmissionfile.php 20130503
// Serve up a peoples_recordedsubmissions Moodle stored_file to browser

require_once('../config.php');
require_once('../lib/filelib.php');

$relativepath = get_file_argument();
$forcedownload = optional_param('forcedownload', 0, PARAM_BOOL);

if (!$relativepath) {
  send_header_404();
  print_error('invalidargorconf');
}
elseif (strpos($relativepath, '/peoples_recordedsubmissions/student/') === false) {
  send_header_404();
  print_error('invalidargorconf'); // Only allow for peoples_recordedsubmissions files!
}
elseif ($relativepath[0] != '/') {
  send_header_404();
  print_error('pathdoesnotstartslash');
}

require_login();
$isteacher = is_peoples_teacher();
$islurker = has_capability('moodle/grade:viewall', get_context_instance(CONTEXT_SYSTEM));
if (!$isteacher && !$islurker) {
  send_header_404();
  print_error('invalidargorconf');
}

$fs = get_file_storage();

$file = $fs->get_file_by_hash(sha1($relativepath));
if (empty($file) || $file->is_directory()) {
  send_header_404();
  print_error('filenotfound');
}

echo '<pre>';
print_r($relativepath);
echo '<br />';
$sha1relativepath = sha1($relativepath);
print_r($sha1relativepath);
echo '<br />';
print_r($file);
echo '</pre>';


//DEBUG
    if (isset($CFG->filedir)) {
        $filedir = $CFG->filedir;
    } else {
        $filedir = $CFG->dataroot.'/filedir';
    }

    if (isset($CFG->trashdir)) {
        $trashdirdir = $CFG->trashdir;
    } else {
        $trashdirdir = $CFG->dataroot.'/trashdir';
    }

    $fs = new file_storage($filedir, $trashdirdir, "$CFG->tempdir/filestorage", $CFG->directorypermissions, $CFG->filepermissions);

    $filesprefix = 'f';
    $filesreferenceprefix = 'r';
        $filefields = array('contenthash', 'pathnamehash', 'contextid', 'component', 'filearea',
            'itemid', 'filepath', 'filename', 'userid', 'filesize', 'mimetype', 'status', 'source',
            'author', 'license', 'timecreated', 'timemodified', 'sortorder', 'referencefileid');

        $referencefields = array('repositoryid' => 'repositoryid',
            'reference' => 'reference',
            'lastsync' => 'referencelastsync',
            'lifetime' => 'referencelifetime');

        $fields = array();
        $fields[] = $filesprefix.'.id AS id';
        foreach ($filefields as $field) {
            $fields[] = "{$filesprefix}.{$field}";
        }

        foreach ($referencefields as $field => $alias) {
            $fields[] = "{$filesreferenceprefix}.{$field} AS {$alias}";
        }

        $fieldsinselect = implode(', ', $fields);


        $sql = "SELECT $fieldsinselect
                  FROM mdl_files f
             LEFT JOIN mdl_files_reference r
                       ON f.referencefileid = r.id
                 WHERE f.pathnamehash = '$sha1relativepath'";
        if ($filerecord = $DB->get_record_sql($sql)) {
            $storedfile = new stored_file($fs, $filerecord, $filedir);
        } else {
            $storedfile = false;
        }

echo '<pre>';
print_r($sql);
echo '<br />';
print_r($filerecord);
echo '<br />';
print_r($storedfile);
echo '</pre>';



send_stored_file($file, 86400, 0, true);


function is_peoples_teacher() {
  global $USER;
  global $DB;

  /* All Teacher, Teachers...
  SELECT u.lastname, r.name, c.fullname
  FROM mdl_user u, mdl_role_assignments ra, mdl_role r, mdl_context con, mdl_course c
  WHERE
  u.id=ra.userid AND
  ra.roleid=r.id AND
  ra.contextid=con.id AND
  r.name IN ('Teacher', 'Teachers') AND
  con.contextlevel=50 AND
  con.instanceid=c.id ORDER BY c.fullname, r.name;
  */

  $teachers = $DB->get_records_sql("
    SELECT ra.userid FROM mdl_role_assignments ra, mdl_role r, mdl_context con
    WHERE
      ra.userid=? AND
      ra.roleid=r.id AND
      ra.contextid=con.id AND
      r.shortname IN ('tutor', 'tutors') AND
      con.contextlevel=50",
    array($USER->id));

  if (!empty($teachers)) return true;

  if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) return true;
  else return false;
}
?>
