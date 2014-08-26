<?php 
	require_once('../../php/connexion.class.php'); 
	require_once('admin.class.php');

		$id = $_GET['key'];
		$pic = $_GET['pic'];
		$nbcom = $_GET['nbcom'];


		$comments = new Admin();
		$comments->deleteComment($id, $pic, $nbcom);
?>