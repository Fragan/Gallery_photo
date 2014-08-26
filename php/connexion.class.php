<?php 
	$dir = __DIR__;
	$dir = substr($dir, 0, -3);
	$dir .= "config/sql.ini";
	if(@$ini_array = parse_ini_file($dir)){
		define("CONFIG", $dir);
		foreach ($ini_array as $key => $value) {
			if(strtoupper($key) == "DATABASELOCATION"){
				if(!$value){
					define("DBLOCALISATION", null);
				}else{
					define("DBLOCALISATION", $value);
				}	
			}
			if(strtoupper($key) == "DATABASENAME"){
				if(!$value){
					define("DBNAME", null);
				}else{
					define("DBNAME", $value);
				}	
			}
			if(strtoupper($key) == "DATABASEUSER"){
				if(!$value){

					define("DBUSER", null);
				}else{
					define("DBUSER", $value);
				}	
			}
			if(strtoupper($key) == "DATABASEPASSWORD"){
				if(!$value){

					define("DBPASSWORD", null);
				}else{
					define("DBPASSWORD", $value);
				}	
			}

		}
	}else{
		define("DBLOCALISATION", null);
		define("DBUSER", null);
		define("DBPASSWORD", null);
		define("DBNAME", null);
		define("CONFIG", $dir);
	}
class Connexion{
	private $_connexion;
	public function __construct(){
		try
		{
			
		    @$connexion = new PDO('mysql:host='.DBLOCALISATION.';dbname='.DBNAME.'', DBUSER, DBPASSWORD);
		    $this->_connexion = $connexion;
		}
		catch(Exception $e)
		{
			echo 'Erreur : '.$e->getMessage().'<br />';
			echo 'N° : '.$e->getCode();
			echo '<div class="alert alert-danger"><strong>Warning!</strong> Database is not configured please watch : "'.CONFIG.'"</div>';
			die();
		}
		return $this->_connexion;
	}
}	

?>