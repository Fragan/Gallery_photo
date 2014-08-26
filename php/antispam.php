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
		$return_arr["message"] = $ip;
	}else{
		$return_arr["status"] =  "fail";
		$return_arr["message"] = "Vous devez attendre 20s entre chaques messages";
	}
		
      echo json_encode($return_arr);
      exit();
?>