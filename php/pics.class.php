<?php  

Class Pictures extends Connexion{

		public function __construct($id){
			$this->_connexion = parent::__construct();
			$this->getThumbnails($id);
		}


		public function getThumbnails($id){
			$sql = $this->_connexion->prepare("SELECT 
												galleries.name AS gallery_name, 
												galleries.subtitle, 
												pictures.id, 
												pictures.gallery,
												pictures.name,
												pictures.info,
												pictures.nbcomment,
												pictures.link,
												pictures.thumb
												FROM pictures JOIN galleries ON galleries.id = pictures.gallery WHERE gallery = :id ORDER BY id");
			$sql-> bindParam('id', $id, PDO::PARAM_STR);
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			echo '<h3>'.$rows[0]['gallery_name'].'</h3>';
			echo '<h5>'.$rows[0]['subtitle'].'</h5>';
			$total = count($rows);
			$cpt = 1;		
			foreach ($rows as $key => $value) {
				$comment = ($value['nbcomment']>1)?$value['nbcomment'].' commentaires':$value['nbcomment'].' commentaire';
				echo '<div class="grid" id="'.$value['link'].'"><a rev="comment.php?gallery='.$value['gallery'].'&pics='.$value['id'].'" target="'.$comment.'" hreflang="'.$cpt.'/'.$total.'" id="img_link" href="'.$value['link'].'" title="'.$value['name'].'" rel="'.$value['info'].'"><img draggable="false" class="img" src="'.$value['thumb'].'" alt="'.$value['info'].'"></a></div>';
				$cpt++;
			}
		}


}


?>