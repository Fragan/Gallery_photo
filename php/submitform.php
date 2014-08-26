<?php 
	require_once('connexion.class.php');
  	require_once('comment.class.php');
  	$comment = new Comment();
	$comment->setComment($_POST['gallery'], $_POST['pics'], $_POST['author'], $_POST['comment']);
?>