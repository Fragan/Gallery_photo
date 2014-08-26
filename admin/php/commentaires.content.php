<?php  
session_name('IDSESSION');
session_start();
$_SESSION['display'] = "displayComs();";
require_once('../../php/connexion.class.php'); 
require_once('admin.class.php');

$comments = new Admin();
$comments->getAllComments();

?>