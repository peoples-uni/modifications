<?php  // $Id: tpayres.php TEST paymentresponse.php,v 1.1 2009/03/03 18:18:00 alanbarrett Exp $
/**
*
* Process Payment Response from WorldPay
*
*/

// http://courses.peoples-uni.org/course/tpayres.php?callbackPW=ej873j201g&transStatus=Y&amount=9&currency=GBP&M_keep=1&name=ALANTEST&email=alanabarrett0%40gmail.com&address=ALANTESTADD&country=IE&M_donate=999&M_displaysupporter=1&transId=999

$test = true;
$test = false;


require('../config.php');
require_once($CFG->dirroot .'/course/lib.php');


if (empty($_REQUEST['callbackPW']) || ($_REQUEST['callbackPW'] !== 'ej873j201g')) {
	error_log('callbackPW BAD!');
	die();
}

//if (empty($_SERVER['REMOTE_HOST']) || (substr($_SERVER['REMOTE_HOST'], -13) !== '.worldpay.com')) {
//	// Your web server must be configured to create this variable. For example in Apache you'll need HostnameLookups On inside httpd.conf for it to exist. See also gethostbyaddr().
//	error_log('Calling host is not worldpay.com!');
//	die();
//}

if (empty($_REQUEST['transStatus']) || ($_REQUEST['transStatus'] !== 'Y')) {
	error_log('transStatus IS NOT Y!');
	die();
}

if (!$test) {
	if (!empty($_REQUEST['testMode'])) {
		error_log('testMode NOT Empty!');
		die();
	}
}

if (empty($_REQUEST['transId'])) {
	error_log('transId Empty!');
	die();
}

if (empty($_REQUEST['M_donate'])) {
	if (empty($_REQUEST['M_sid'])) {
		error_log('M_sid Empty!');
		die();
	}

	$sid = (int)$_REQUEST['M_sid'];
	$application = get_record('peoplesapplication', 'sid', $sid);
	if (empty($application)) {
		error_log('M_sid DOES NOT MATCH Existing Record!');
		die();
	}

	if (empty($_REQUEST['M_dateattemptedtopay'])) {
		error_log('M_dateattemptedtopay Empty!');
		die();
	}

	if ((int)$application->dateattemptedtopay !== (int)$_REQUEST['M_dateattemptedtopay']) {
		error_log('M_dateattemptedtopay DOES NOT Match!');
		die();
	}

	$updated = new object();
	$updated->id = $application->id;
	$updated->paymentmechanism = 1;
	$updated->costpaid = $application->costowed;
	$updated->datafromworldpay = (int)$_REQUEST['transId'];
	$updated->datepaid = time();
	update_record('peoplesapplication', $updated);
}
else {
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

	insert_record('peoplesdonation', $peoplesdonation);
}
// Could generate output for user, but we will use default behaviour (probably our uploaded file)
?>
