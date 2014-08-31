<?php  
Class Antispam extends Connexion{

		public function __construct(){
			$this->_connexion = parent::__construct();
		}

		public function antiSpam($ip){
			$sql = $this->_connexion->prepare("SELECT MAX(date) AS lastpost FROM comments WHERE ip = :ip");
			$sql-> bindParam('ip', $ip, PDO::PARAM_STR);
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

			$timeFirst  = strtotime($rows[0]['lastpost']);
			$date = date("Y-m-d H:i:s");	
			$timeSecond = strtotime($date);
			$interval = $timeSecond - $timeFirst;

			if ($interval>20){
				return True;
			}
		}


}


?>

