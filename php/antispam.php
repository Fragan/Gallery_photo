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
	$return_arr["status"] = ($spamm->antispam($ip))?"success":"fail";	
    echo json_encode($return_arr);
    exit();
?>