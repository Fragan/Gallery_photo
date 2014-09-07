<?php  

Class Comment extends Connexion{

		public function __construct(){
			$this->_connexion = parent::__construct();
		}


		public function getPicture($gallery, $pics){
			$sql = $this->_connexion->prepare("SELECT link, name, info, nbcomment FROM pictures WHERE gallery = :gallery AND id = :pics");
			$sql-> bindParam('pics', $pics, PDO::PARAM_INT);
			$sql-> bindParam('gallery', $gallery, PDO::PARAM_INT);
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			if (empty($rows)) {
				header("location: ./");
			}
			foreach ($rows as $key => $value) {	
				echo '<img draggable="false" class="img-responsive img_center" src="'.$value['link'].'" alt="responsive">';
				echo '<div class="col-md-12 text-right"><h3>'.$value['name'].'</h3>';
				echo '<h5>'.$value['info'].'</h5></div>';
				echo '<span class="commentaire">Commentaire(s) : '.$value['nbcomment'].'</span><div class="col-md-12 sep"></div>';
			}
		}

		public function setComment($gallery, $pics, $author, $comment){
			$comment = htmlspecialchars($comment, ENT_QUOTES);
			$author = htmlspecialchars($author, ENT_QUOTES);
			$comment = nl2br($comment);
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			    $ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    $ip = $_SERVER['REMOTE_ADDR'];
			}
			$sql = $this->_connexion->prepare("INSERT INTO comments (gallery, pics, author, comment, ip) values(:gallery, :pics, :author, :comment, :ip)");
			$sql-> bindParam('gallery', $gallery, PDO::PARAM_INT);
			$sql-> bindParam('pics', $pics, PDO::PARAM_INT);
			$sql-> bindParam('author', $author, PDO::PARAM_STR);		
			$sql-> bindParam('comment', $comment, PDO::PARAM_STR);			
			$sql-> bindParam('ip', $ip, PDO::PARAM_STR);			
			$sql-> execute();
			$this->updateNbcomment($gallery, $pics);

			echo '<script type="text/javascript">window.location.href="../comment.php?gallery='.$gallery.'&pics='.$pics.'";</script>';
		}

		public function getComments($gallery, $pics){
			$sql = $this->_connexion->prepare("SELECT * FROM comments WHERE gallery = :gallery AND pics = :pics ORDER BY id");
			$sql-> bindParam('pics', $pics, PDO::PARAM_INT);
			$sql-> bindParam('gallery', $gallery, PDO::PARAM_INT);
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			if (!empty($rows)) {
				foreach ($rows as $value) {
					echo '<div class="col-md-12 comment-info">';
					echo '<strong>'.$value['author'].'</strong>';
					$this->formatDate($value['date']);
					echo '</div>';
					echo '<div class="col-md-12 comment-content">';
					echo $value['comment'];
					echo '</div><div class="col-md-12 sep"></div>';
				}
			}
		}

		public function updateNbcomment($gallery, $pics){
			$sql = $this->_connexion->prepare("SELECT nbcomment FROM pictures WHERE gallery = :gallery AND id = :id");
			$sql-> bindParam('id', $pics, PDO::PARAM_INT);
			$sql-> bindParam('gallery', $gallery, PDO::PARAM_INT);
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			$newNbcommment = $rows[0]['nbcomment']+1;
			$sql2 = $this->_connexion->prepare("UPDATE pictures SET nbcomment = :nbcomment WHERE gallery = :gallery AND id = :id");
			$sql2-> bindParam('id', $pics, PDO::PARAM_INT);
			$sql2-> bindParam('gallery', $gallery, PDO::PARAM_INT);
			$sql2-> bindParam('nbcomment', $newNbcommment, PDO::PARAM_INT);
			$sql2-> execute();
		}

		public function formatDate($date){
			$tempdatetime = explode(" ", $date);
			$tempdate = explode("-", $tempdatetime[0]);
			$date = $tempdate[2].'/'.$tempdate[1].'/'.$tempdate[0];

			$temptime = explode(":", $tempdatetime[1]);
			$time = $temptime[0].'h'.$temptime[1];
			echo ", le ".$date." à ".$time;
		}
}


?>

