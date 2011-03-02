<?php  // $Id: paymentresponse.php,v 1.1 2009/03/03 18:18:00 alanbarrett Exp $
/**
*
* Process Payment Response from WorldPay
*
*/


$test = true;
$test = false;


require('../config.php');
require_once($CFG->dirroot .'/course/lib.php');


if (empty($_POST['callbackPW']) || ($_POST['callbackPW'] !== 'ej873j201g')) {
	error_log('RBS WorldPay callbackPW BAD!');
	die();
}

//if (empty($_SERVER['REMOTE_HOST']) || (substr($_SERVER['REMOTE_HOST'], -13) !== '.worldpay.com')) {
//	// Your web server must be configured to create this variable. For example in Apache you'll need HostnameLookups On inside httpd.conf for it to exist. See also gethostbyaddr().
//	error_log('Calling host is not worldpay.com!');
//	die();
//}

if (empty($_POST['transStatus']) || ($_POST['transStatus'] !== 'Y')) {
	error_log('RBS WorldPay transStatus IS NOT Y!');
	email_error_to_payments('RBS WorldPay transStatus IS NOT Y!', $_POST);
	die();
}

if (!$test) {
	if (!empty($_POST['testMode'])) {
		error_log('RBS WorldPay testMode NOT Empty!');
		email_error_to_payments('RBS WorldPay testMode NOT Empty!', $_POST);
		die();
	}
}

if (empty($_POST['transId'])) {
	error_log('RBS WorldPay transId Empty!');
	email_error_to_payments('RBS WorldPay transId Empty!', $_POST);
	die();
}

if (empty($_POST['M_donate']) && empty($_POST['M_wikitox'])) {
	if (empty($_POST['M_sid'])) {
		error_log('RBS WorldPay M_sid Empty!');
		email_error_to_payments('RBS WorldPay M_sid Empty!', $_POST);
		die();
	}

	$sid = (int)$_POST['M_sid'];
  $application = $DB->get_record('peoplesapplication', array('sid' => $sid));
	if (empty($application)) {
		error_log('RBS WorldPay M_sid DOES NOT MATCH Existing Record! M_sid: ' . $sid);
		email_error_to_payments('RBS WorldPay M_sid DOES NOT MATCH Existing Record!', $_POST);
		die();
	}

	if (empty($_POST['M_dateattemptedtopay'])) {
		error_log('RBS WorldPay M_dateattemptedtopay Empty! M_sid: ' . $sid);
		email_error_to_payments('RBS WorldPay M_dateattemptedtopay Empty!', $_POST);
		die();
	}

	if ((int)$application->dateattemptedtopay !== (int)$_POST['M_dateattemptedtopay']) {
    error_log('RBS WorldPay M_dateattemptedtopay does not match. M_sid: ' . $sid . ' M_dateattemptedtopay: ' . $_POST['M_dateattemptedtopay']);
    email_error_to_payments('Ignore this e-mail, it is for reference only: RBS WorldPay M_dateattemptedtopay does not match', $_POST);
// Allow through, two copies of pay.php could have been loaded 20090706...		die();
	}

	$updated = new object();
	$updated->id = $application->id;
	$updated->paymentmechanism = 1;
	$updated->costpaid = $application->costowed;
	$updated->datafromworldpay = (int)$_POST['transId'];
	$updated->datepaid = time();
  $DB->update_record('peoplesapplication', $updated);
}
elseif (!empty($_POST['M_donate'])) {
	$peoplesdonation = new object();

	if (empty($_POST['amount'])) {
		$peoplesdonation->amount = '0';
	}
	else {
		$peoplesdonation->amount = $_POST['amount'];
	}

	if (empty($_POST['currency'])) {
		$peoplesdonation->currency = '';
	}
	else {
		$peoplesdonation->currency = $_POST['currency'];
	}

	if (empty($_POST['name']) || empty($_POST['M_keep'])) {
		$peoplesdonation->name = '';
	}
	else {
		$peoplesdonation->name = $_POST['name'];
	}

	if (empty($_POST['email']) || empty($_POST['M_keep'])) {
		$peoplesdonation->email = '';
	}
	else {
		$peoplesdonation->email = $_POST['email'];
	}

	if (empty($_POST['address']) || empty($_POST['M_keep'])) {
		$peoplesdonation->address = '';
	}
	else {
		$peoplesdonation->address = $_POST['address'];
	}

	if (empty($_POST['country']) || empty($_POST['M_keep'])) {
		$peoplesdonation->country = '';
	}
	else {
		$peoplesdonation->country = $_POST['country'];
	}

	if (empty($_POST['M_keep'])) {
		$peoplesdonation->M_keep = 0;
	}
	else {
		$peoplesdonation->M_keep = 1;
	}

	$peoplesdonation->M_donate = $_POST['M_donate'];

	if (empty($_POST['M_displaysupporter'])) {
		$peoplesdonation->type = 1;
	}
	else {
		$peoplesdonation->type = 2; // They are willing for their name to be displayed on our site
	}

	$peoplesdonation->datafromworldpay = (int)$_POST['transId'];

  $DB->insert_record('peoplesdonation', $peoplesdonation);
}
elseif (!empty($_POST['M_wikitox'])) {
  /*
  CREATE TABLE mdl_peoples_wikitox_payment (
    id BIGINT(10) unsigned NOT NULL auto_increment,
    amount VARCHAR(10),
    currency VARCHAR(3),
    name VARCHAR(255),
    email VARCHAR(100),
    address TEXT,
    country VARCHAR(2),
    M_wikitox BIGINT(10) UNSIGNED,
    datafromworldpay VARCHAR(255),
    CONSTRAINT  PRIMARY KEY (id)
  );
  */

  $peoples_wikitox_payment = new object();

  if (empty($_POST['amount'])) {
    $peoples_wikitox_payment->amount = '0';
  }
  else {
    $peoples_wikitox_payment->amount = $_POST['amount'];
  }

  if (empty($_POST['currency'])) {
    $peoples_wikitox_payment->currency = '';
  }
  else {
    $peoples_wikitox_payment->currency = $_POST['currency'];
  }

  if (empty($_POST['name'])) {
    $peoples_wikitox_payment->name = '';
  }
  else {
    $peoples_wikitox_payment->name = $_POST['name'];
  }

  if (empty($_POST['email'])) {
    $peoples_wikitox_payment->email = '';
  }
  else {
    $peoples_wikitox_payment->email = $_POST['email'];
  }

  if (empty($_POST['address'])) {
    $peoples_wikitox_payment->address = '';
  }
  else {
    $peoples_wikitox_payment->address = $_POST['address'];
  }

  if (empty($_POST['country'])) {
    $peoples_wikitox_payment->country = '';
  }
  else {
    $peoples_wikitox_payment->country = $_POST['country'];
  }

  $peoples_wikitox_payment->M_wikitox = $_POST['M_wikitox'];

  $peoples_wikitox_payment->datafromworldpay = (int)$_POST['transId'];

  $DB->insert_record('peoples_wikitox_payment', $peoples_wikitox_payment);

  // e-mail all relevant people
  $amount   = $peoples_wikitox_payment->amount;
  $currency = $peoples_wikitox_payment->currency;
  $name     = dontstripslashes($peoples_wikitox_payment->name);
  $email    = dontstripslashes($peoples_wikitox_payment->email);
  $address  = dontstripslashes($peoples_wikitox_payment->address);
  $country  = $peoples_wikitox_payment->country;
  $time     = $peoples_wikitox_payment->M_wikitox;
  $transid  = $peoples_wikitox_payment->datafromworldpay;

  $subject = "WikiTox Payment of $amount for $name";
  $message = "WikiTox Payment via RBS WorldPay

Name   : $name
Amount : $amount $currency
e-mail : $email
Address: $address
Country: $country
Date   : " . gmdate('d/m/Y H:i', $time) . "

Transaction ID: $transid

Peoples-uni Payments";

  // Dummy User
  $payments = new stdClass();
  $payments->id = 999999999;
  $payments->maildisplay = true;
  $payments->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->email = 'payments@peoples-uni.org';
  $supportuser->firstname = 'Peoples-uni Payments';
  $supportuser->lastname = '';
  $supportuser->maildisplay = true;

  $payments->email = 'payments@peoples-uni.org';
  //$payments->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($payments, $supportuser, $subject, $message);

  $payments->email = 'adawson@sactrc.org';
  //$payments->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($payments, $supportuser, $subject, $message);

  $payments->email = 'ahdawson@gmail.com';
  //$payments->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($payments, $supportuser, $subject, $message);
}
// Could generate output for user, but we will use default behaviour (probably our uploaded file)


function email_error_to_payments($subject, $post) {
  global $CFG;

  $message = "$subject\n\nPOST from RBS WorldPay Payment Response...\n";

  foreach ($post as $key => $value) {
    if ($key !== 'callbackPW') {
      $value = dontstripslashes($value);
      $message .= "$key => $value\n";
    }
  }

  // Dummy User
  $payments = new stdClass();
  $payments->id = 999999999;
  $payments->email = 'payments@peoples-uni.org';
  $payments->maildisplay = true;
  $payments->mnethostid = $CFG->mnet_localhost_id;

  $supportuser = new stdClass();
  $supportuser->email = 'payments@peoples-uni.org';
  $supportuser->firstname = 'Peoples-uni Payments';
  $supportuser->lastname = '';
  $supportuser->maildisplay = true;

  //$payments->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($payments, $supportuser, $subject, $message);
}


function dontstripslashes($x) {
  return $x;
}
?>