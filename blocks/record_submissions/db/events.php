<?php

/*
 * Event Handlers
 */
$handlers = array(

  // 'file' submission triggers this
  'assessable_file_uploaded' => array (
    'handlerfile'     => '/blocks/record_submissions/locallib.php',
    'handlerfunction' => 'file_submission_uploaded',
    'schedule'        => 'instant'
  ),

  // 'onlinetext' submission triggers this
  'assessable_content_uploaded' => array(
    'handlerfile'     => '/blocks/record_submissions/locallib.php',
    'handlerfunction' => 'onlinetext_submission_uploaded',
    'schedule'        => 'instant'
  )
);
