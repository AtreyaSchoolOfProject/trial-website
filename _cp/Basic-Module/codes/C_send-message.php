<?php
include("../../require/session.inc.php");
include("../../require/connection.inc.php");
include("../../require/functions.inc.php");
require("../../../PHPPOST/getpost-lib.php");


if (strlen($_POST['message']) != strlen(utf8_decode($_POST['message'])))
{
    $msg_format = 'unicode';
}else{
	$msg_format = 'english';
}

if($_REQUEST['format']===$msg_format){
	die('die');
	$sent_type = $_POST['sent_type'];
	$message = $_POST['message'];
	$profile_type=($_POST['profile_type'])?implode(',',$_POST['profile_type']):'manual';
	$designation=($_POST['designation'])?implode(',',$_POST['designation']):'';
	
	$block=($_POST['block'])?implode(',',$_POST['block']):'';
	$panchayat=($_POST['panchayat'])?implode(',',$_POST['panchayat']):'';
	$village=($_POST['village'])?implode(',',$_POST['village']):'';
	
	$tot_contact=$_POST['countNos'];
	$tot_msgcount=($_POST['countNos']*$_POST['tot_msgcount']);
	
	if($village){
		$location = $village;
		$location_type = 'village';
	}else if($panchayat){
		$location = $panchayat;
		$location_type = 'panchayat';
	}else if($block){
		$location = $block;
		$location_type = 'block';
	}else{
		$location_type = 'NA';$location = 'NA';
	}
	$message_id = strtoupper(uniqid('MSG'));
	
	$mobileNumber=$_REQUEST['allNos'];
	$senderId='BJDGPL';
	$routeId='1';
	//$message="Hello, Good Evening";
	$serverUrl='sms.atreyasoft.com';
	$authKey='5981a59891a3d97ec7d12d1995d21333';
	$smsContentType = $_REQUEST['format'];
	$data = sendsmsPOST($mobileNumber,$senderId,$routeId,$message,$serverUrl,$authKey,$smsContentType);
	
	$response = json_decode($data);
	$api_responseCode = $response->responseCode;
	$api_response = $response->response;
	if($data){
		$query = mysql_query("INSERT INTO `sent_messages`(`message_id`, `api_responseCode`, `api_response`, `sent_type`, `profile_type`, `designation`, `locationtype`, `location`, `message`, `tot_contact`, `msgcount`, `sent_on`, `sent_by`)VALUES('$message_id', '$api_responseCode', '$api_response', '$sent_type', '$profile_type','$designation', '$location_type', '$location', '".urlencode($message)."', '$tot_contact', '$tot_msgcount', TIMESTAMP(NOW()), '".$_SESSION['username']."')")or die('Unable to store message, please contact service provider...!');
			
		if($query){
			$allNos = explode(',',$_POST['allNos']);
			foreach($allNos as $key => $numbers){
				$sent = mysql_query("INSERT INTO `sent_message_details`(`message_id`, `mobile`)VALUES('$message_id','$numbers')"); 
			}
		}
		echo 'Response Code : '.$api_responseCode;
	}
	else echo 'Error : Message sending failed..!'.' Response id : '.$api_response;
}
else
{
	echo 'Warning : Please select '.strtoupper($msg_format).' format for message..!';
	exit;
}
?>

