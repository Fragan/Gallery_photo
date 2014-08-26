<?php  
Class Admin extends Connexion{

		public function __construct(){
			$this->_connexion = parent::__construct();
		}

		public function display($session){
			if(!$session){
				if($this->getLogin()){
					echo '
						<div class="col-md-4">
					      <fieldset><legend class="legendh2">Login</legend>
					        <form method="post" role="form">
					          <div class="form-group row">
					            <div class="col-md-12 padd"> 
					               <input type="text" class="form-control"  maxlength="20" placeholder="login" name="pseudo" autofocus required>
					              <div class="padd">
					                <input type="password" name="password" class="form-control" placeholder="Password"  required>
					              </div>
					            </div>
					          </div>
					          <div class="form row">
					            <div class="col-md-12"> 
					              <button name="login" type="submit" class="btn btn-default btn-primary btn-lg btn-block">Login <span class="glyphicon glyphicon-log-in"></span></button>
					            </div>  
					          </div>
					        </form>
					       </fieldset> 
					     </div>
					';
				}else{echo "Login/Password non configuré.";}
			}else{
				echo '<div class="col-md-12">';
				echo '<div class="btn-group">';
				echo '<a href="../setbio.php" class="btn btn-default btn-lg">Bio</a>';
				echo '<button onclick="displayComs();" class="btn btn-lg btn-default "> Commentaires</button>';
				echo '<div class="btn-group">
					    <button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown">
					      Galeries
					      <span class="caret"></span>
					    </button>
					    <ul class="dropdown-menu" role="menu">
					    ';
						$this->getGalleryList();
				 echo'  </ul>
					  </div>';
				echo '</div>';
				echo '</div>';
				echo '<div class="commentaires"></div>';
				echo '<div class="galeries"></div><div class="col-md-12 sep"></div>';
			}

		}

		public function getJson(){
	 		$path = "../config/admin.json";
	 		if (file_exists($path)) {
	 			$array = json_decode(file_get_contents($path));
				return $array;
	 		}else{
	 			return false;
	 		}
			
	 	}

		function getLogin(){
			if ($this->getJson()){
 				$admin['login'] = $this->getJson()->{'admin'}->{'login'};
 				$admin['password'] = $this->getJson()->{'admin'}->{'password'};
 			}
 			if(($admin['login'] != "") && ($admin['password'] != ""))
 				return $admin;
		}

		function login($login, $password){
			$idt = $this->getLogin();
			if(($login == $idt['login']) && ($password == $idt['password'])){
				$_SESSION['log'] = true;
				header("location: ./");
			}else{
				echo '<div class="col-md-12">Erreur de connexion</div>';
			}
		}

		public function getAllComments(){
			$sql = $this->_connexion->prepare("SELECT comments.id, comments.pics, comments.author, comments.date, comments.`comment`, pictures.nbcomment
												FROM comments JOIN pictures on comments.pics = pictures.id ORDER BY comments.id DESC");
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			if (empty($rows)) {
				
			}else{
				foreach ($rows as $value) {
					echo '<div class="col-md-12 sep"></div>';
					echo '<div class="col-md-12 comment-info">';
					echo '<strong>'.$value['author'].'</strong>';
					$this->formatDate($value['date']);
					echo '</div>';
					echo '<div class="col-md-12 comment-content">';
					echo $value['comment'];
					echo '<div class="pull-right"><span onclick="deleteComment(this.id);" id="'.$value['id'].'" pic="'.$value['pics'].'" nbcom="'.$value['nbcomment'].'"  class="glyphicon glyphicon-trash delete-com"></span></div>';
					echo '</div>';
				}
			}
		}

		public function getGalleryList(){
			$sql = $this->_connexion->prepare("SELECT name FROM galleries ORDER BY name");
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows as $value) {
				echo '<li><span class="gallery_list" id="'.$value['name'].'" onclick="displayGals(this.id);">'.$value['name'].'</span></li>';
			}
		}

		public function formatDate($date){
			$tempdatetime = explode(" ", $date);
			$tempdate = explode("-", $tempdatetime[0]);
			$date = $tempdate[2].'/'.$tempdate[1].'/'.$tempdate[0];

			$temptime = explode(":", $tempdatetime[1]);
			$time = $temptime[0].'h'.$temptime[1];
			echo ", le ".$date." à ".$time;
		}

		public function getGalleryInfo($name){
			$sql = $this->_connexion->prepare("SELECT galleries.id AS gallery_id, galleries.name AS gallery_name, galleries.subtitle, pictures.id AS picture_id, pictures.name AS picture_name, pictures.info, pictures.thumb 
												FROM galleries JOIN pictures ON galleries.id = pictures.gallery
												WHERE galleries.name = :name");
			$sql-> bindParam('name', $name, PDO::PARAM_STR);
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);

			echo '<div class="col-md-12">';
				echo '<div id="'.$rows[0]['gallery_id'].'" titre="'.$rows[0]['gallery_name'].'" subtitle="'.$rows[0]['subtitle'].'" class="col-md-12 gallery-info" onclick="displayGalForm(this.id);">';
					echo '<p><h1>'.$rows[0]['gallery_name'].'</h1></p>';
					echo '<p><h3>'.$rows[0]['subtitle'].'</h3></p>';
				echo '</div>';
			$cpt = 0;
			foreach ($rows as $value) {
				if($cpt%2){
					echo '<div onclick="displayPicsForm(this.id);" id="'.$value['picture_id'].'" class="col-md-12 padd-admin paire">';
				}else{
					echo '<div onclick="displayPicsForm(this.id);" id="'.$value['picture_id'].'" class="col-md-12 padd-admin impaire">';
				}	
					echo '<img id="'.$value['picture_name'].'" alt="'.$value['info'].'" class="thumbnails" src="../'.$value['thumb'].'">';
					echo '<p><h4>'.$value['picture_name'].'</h4></p>';
					echo '<p><h5>'.$value['info'].'</h5></p>';
					
				echo '</div>';
				$cpt++;
			}
			echo '</div>';
		}

		public function updatePics($titre, $soustitre, $id){
			$titre = htmlspecialchars($titre, ENT_QUOTES);
			$soustitre = htmlspecialchars($soustitre, ENT_QUOTES);
			$sql = $this->_connexion->prepare("UPDATE pictures SET name = :name, info = :info WHERE id = :id");
			$sql-> bindParam('name', $titre, PDO::PARAM_STR);
			$sql-> bindParam('info', $soustitre, PDO::PARAM_STR);
			$sql-> bindParam('id', $id, PDO::PARAM_INT);
			$sql-> execute();
			echo '<script type="text/javascript">location.href="./";</script>';
		}

		public function updateGals($titre, $soustitre, $id){
			$titre = htmlspecialchars($titre, ENT_QUOTES);
			$soustitre = htmlspecialchars($soustitre, ENT_QUOTES);
			$sql = $this->_connexion->prepare("UPDATE galleries SET name = :name, subtitle = :subtitle WHERE id = :id");
			$sql-> bindParam('name', $titre, PDO::PARAM_STR);
			$sql-> bindParam('subtitle', $soustitre, PDO::PARAM_STR);
			$sql-> bindParam('id', $id, PDO::PARAM_INT);
			$sql-> execute();
			echo '<script type="text/javascript">location.href="./";</script>';
		}

		public function deleteComment($id, $pic, $nbcom){
			// delete comm
			$sql = $this->_connexion->prepare("DELETE FROM comments WHERE id = :id");
			$sql-> bindParam('id', $id, PDO::PARAM_INT);
			$sql-> execute();

			// decrement nbcomments
			$newnbcomment = $nbcom-1;
			$sql2 = $this->_connexion->prepare("UPDATE pictures SET nbcomment = :newnbcomment WHERE id = :id");
			$sql2-> bindParam('id', $pic, PDO::PARAM_INT);
			$sql2-> bindParam('newnbcomment', $newnbcomment, PDO::PARAM_INT);
			$sql2-> execute();

		}

}


?>
