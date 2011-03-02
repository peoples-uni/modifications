<?php  // $Id: paymentresponse.php,v 1.1 2009/03/03 18:18:00 alanbarrett Exp $
/**
*
* Process Payment Response from WorldPay
*
*/

die();

//http://peoples-uni.org/~bonkhi/test-course1/course/testpaymentresponse.php?xxx=11%2711&transId=11%2711&M_sid=1036

//SELECT * FROM mdl_peoplesapplication WHERE sid=1036;
//UPDATE mdl_peoplesapplication SET costpaid=0,paymentmechanism=6,datafromworldpay='',datepaid=0 WHERE sid=1036;

//http://peoples-uni.org/~bonkhi/test-course1/course/testpaymentresponse.php?amount=99&currency=GBP&name=Alan&email=alanbarrett&address=4Fair&country=IR&M_wikitox=1298929860&transId=12345


$test = true;
$test = false;


require('../config.php');
require_once($CFG->dirroot .'/course/lib.php');

if (empty($_REQUEST['transId'])) {
	error_log('RBS WorldPay transId Empty!');
	email_error_to_payments('RBS WorldPay transId Empty!', $_REQUEST);
	die();
}

if (empty($_REQUEST['M_donate']) && empty($_REQUEST['M_wikitox'])) {
	if (empty($_REQUEST['M_sid'])) {
		error_log('RBS WorldPay M_sid Empty!');
		email_error_to_payments('RBS WorldPay M_sid Empty!', $_REQUEST);
		die();
	}

	$sid = (int)$_REQUEST['M_sid'];
  $application = $DB->get_record('peoplesapplication', array('sid' => $sid));
	if (empty($application)) {
		error_log('RBS WorldPay M_sid DOES NOT MATCH Existing Record! M_sid: ' . $sid);
		email_error_to_payments('RBS WorldPay M_sid DOES NOT MATCH Existing Record!', $_REQUEST);
		die();
	}

	$updated = new object();
	$updated->id = $application->id;
	$updated->paymentmechanism = 1;
	$updated->costpaid = $application->costowed;
	$updated->datafromworldpay = (int)$_REQUEST['transId'];
	$updated->datepaid = time();
  $DB->update_record('peoplesapplication', $updated);
}
elseif (!empty($_REQUEST['M_donate'])) {
	$peoplesdonation = new object();

	if (empty($_REQUEST['amount'])) {
		$peoplesdonation->amount = '0';
	}
	else {
		$peoplesdonation->amount = $_REQUEST['amount'];
	}

	if (empty($_REQUEST['currency'])) {
		$peoplesdonation->currency = '';
	}
	else {
		$peoplesdonation->currency = $_REQUEST['currency'];
	}

	if (empty($_REQUEST['name']) || empty($_REQUEST['M_keep'])) {
		$peoplesdonation->name = '';
	}
	else {
		$peoplesdonation->name = $_REQUEST['name'];
	}

	if (empty($_REQUEST['email']) || empty($_REQUEST['M_keep'])) {
		$peoplesdonation->email = '';
	}
	else {
		$peoplesdonation->email = $_REQUEST['email'];
	}

	if (empty($_REQUEST['address']) || empty($_REQUEST['M_keep'])) {
		$peoplesdonation->address = '';
	}
	else {
		$peoplesdonation->address = $_REQUEST['address'];
	}

	if (empty($_REQUEST['country']) || empty($_REQUEST['M_keep'])) {
		$peoplesdonation->country = '';
	}
	else {
		$peoplesdonation->country = $_REQUEST['country'];
	}

	if (empty($_REQUEST['M_keep'])) {
		$peoplesdonation->M_keep = 0;
	}
	else {
		$peoplesdonation->M_keep = 1;
	}

	$peoplesdonation->M_donate = $_REQUEST['M_donate'];

	if (empty($_REQUEST['M_displaysupporter'])) {
		$peoplesdonation->type = 1;
	}
	else {
		$peoplesdonation->type = 2; // They are willing for their name to be displayed on our site
	}

	$peoplesdonation->datafromworldpay = (int)$_REQUEST['transId'];

  $DB->insert_record('peoplesdonation', $peoplesdonation);
}
elseif (!empty($_REQUEST['M_wikitox'])) {
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

  if (empty($_REQUEST['amount'])) {
    $peoples_wikitox_payment->amount = '0';
  }
  else {
    $peoples_wikitox_payment->amount = $_REQUEST['amount'];
  }

  if (empty($_REQUEST['currency'])) {
    $peoples_wikitox_payment->currency = '';
  }
  else {
    $peoples_wikitox_payment->currency = $_REQUEST['currency'];
  }

  if (empty($_REQUEST['name'])) {
    $peoples_wikitox_payment->name = '';
  }
  else {
    $peoples_wikitox_payment->name = $_REQUEST['name'];
  }

  if (empty($_REQUEST['email'])) {
    $peoples_wikitox_payment->email = '';
  }
  else {
    $peoples_wikitox_payment->email = $_REQUEST['email'];
  }

  if (empty($_REQUEST['address'])) {
    $peoples_wikitox_payment->address = '';
  }
  else {
    $peoples_wikitox_payment->address = $_REQUEST['address'];
  }

  if (empty($_REQUEST['country'])) {
    $peoples_wikitox_payment->country = '';
  }
  else {
    $peoples_wikitox_payment->country = $_REQUEST['country'];
  }

  $peoples_wikitox_payment->M_wikitox = $_REQUEST['M_wikitox'];

  $peoples_wikitox_payment->datafromworldpay = (int)$_REQUEST['transId'];

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
  $ret = email_to_user($payments, $supportuser, 'TEST ONLY' . $subject, $message);

  $payments->email = 'adawson@sactrc.org';
  //$payments->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($payments, $supportuser, 'TEST ONLY' . $subject, $message);

  $payments->email = 'ahdawson@gmail.com';
  $payments->email = 'alanabarrett0@gmail.com';
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

  $payments->email = 'alanabarrett0@gmail.com';
  $ret = email_to_user($payments, $supportuser, $subject, $message);
}


function dontstripslashes($x) {
  return $x;
}
?>