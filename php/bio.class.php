<?php  
Class Bio extends Connexion{

		public function __construct(){
			$this->_connexion = parent::__construct();
		}

		public function getBio(){
			$id = 1;
			$sql = $this->_connexion->prepare("SELECT content FROM about WHERE id = :id ");
			$sql-> bindParam('id', $id, PDO::PARAM_STR);
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			if($rows){
				echo $rows[0]['content'];
			}
		}

		public function setBio($content){
			if ($this->isBioexist()) {
				$this->updateBio($content);
			}else{
				$this->insertBio($content);
			}
			header('location: bio.php');
		}

		public function isBioexist(){
			$id = 1;
			$sql = $this->_connexion->prepare("SELECT content FROM about WHERE id = :id ");
			$sql-> bindParam('id', $id, PDO::PARAM_STR);
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			return !empty($rows);		

		}

		public function updateBio($content){
			$id = 1;
			$sql = $this->_connexion->prepare("UPDATE about SET content = :content WHERE id = :id");
			$sql-> bindParam('id', $id, PDO::PARAM_STR);
			$sql-> bindParam('content', $content, PDO::PARAM_STR);
			$sql-> execute();
		}

		public function insertBio($content){
			$id = 1;
			$sql = $this->_connexion->prepare("INSERT INTO about (id, content) VALUES (:id, :content)");
			$sql-> bindParam('id', $id, PDO::PARAM_STR);
			$sql-> bindParam('content', $content, PDO::PARAM_STR);
			$sql-> execute();
		}


}

?>