<?php 
	require_once('connexion.class.php');
	require_once('antispam.class.php');
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	    $ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
	    $ip = $_SERVER['REMOTE_ADDR'];
	}
	$spamm = new Antispam();
	if($spamm->antiSpam($ip)){
		$return_arr["status"] = "success";
	}else{
		$return_arr["status"] =  "fail";
	}
		
      echo json_encode($return_arr);
      exit();
?>