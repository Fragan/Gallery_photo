<?php  

	Class Gallery extends Connexion{

		public function __construct(){
			$this->_connexion = parent::__construct();
			$dir    = 'photos';
			$gallery = scandir($dir);
			foreach ($gallery as $value) {
				if ($value != '.' && $value !='..') {
					$gallery_list[] = $dir.'/'.$value;				
				}
			}

			if (isset($gallery_list)) {
				$this->check_galleries($gallery_list);
				foreach ($gallery_list as $value) {
					$gallery_content = scandir($value);
					if($this->metadata($gallery_content)){
						$this->newGallery($value);
					}
				}
			}else{
				$gallery_list = array();
				$this->check_galleries($gallery_list);
			}
			
			$this->displayGalleries();
		}


		public function metadata($gallery_content){
			return in_array('metadata.txt', $gallery_content);	
		}

		public function newGallery($file){
			$info = file($file.'/metadata.txt');
			foreach ($info as $value) {
					$lines = preg_split("/\n/", $value, null);
					$lines_utf8[] = utf8_encode($lines[0]);
			}

			$title_line = preg_split("/\|/", $lines_utf8[0], -1, PREG_SPLIT_NO_EMPTY);
			if ($title_line[0] == "title") {
				$title_line = explode("@", $title_line[1]);
				$folder_name = preg_split("/\//", $file);
				$folder_name = $folder_name[1];
				if (isset($title_line[0])) {
					$gallery_title = htmlspecialchars($title_line[0], ENT_QUOTES);
				}else{
					$gallery_title = htmlspecialchars($folder_name, ENT_QUOTES);
				}
				if (isset($title_line[1])) {
					$gallery_subtitle = htmlspecialchars($title_line[1], ENT_QUOTES);
				}else{
					$gallery_subtitle = "";
				}				
			}else{
				$gallery_title = preg_split("/\//", $file);
				$gallery_title = htmlspecialchars($gallery_title[1], ENT_QUOTES);
				$gallery_subtitle = "";
				$folder_name = $gallery_title;
			}
			$sql = $this->_connexion->prepare("INSERT INTO galleries (folder, name, subtitle) values(:folder, :name, :subtitle)");
				$sql-> bindParam('folder', $folder_name, PDO::PARAM_STR);
				$sql-> bindParam('name', $gallery_title, PDO::PARAM_STR);
				$sql-> bindParam('subtitle', $gallery_subtitle, PDO::PARAM_STR);			
				$sql-> execute();

			$sql2 = $this->_connexion->prepare("SELECT id FROM galleries where folder = :folder");
			$sql2-> bindParam('folder', $folder_name, PDO::PARAM_STR);
			$sql2-> execute();
			$rows = $sql2->fetchAll(PDO::FETCH_ASSOC);
			$id = $rows[0]['id'];

			$this->addPictures($file, $lines_utf8, $id);
		}

		public function getPictureMetatdata($lines_utf8){
			$metadata = array();
			foreach ($lines_utf8 as $key => $value) {
				$split = preg_split("/\|/", $value, -1, PREG_SPLIT_NO_EMPTY);
				if ($split[0] != "title") {
					$metadata[$split[0]] = $split[1];
				}
				
			}
			return $metadata;
		}

		public function addPictures($dir, $lines_utf8, $id){
			// get all pics from folder
			$gallery_content = scandir($dir);
			$regex = "/\.(bmp|tiff|png|gif|jpe?g)$/";
			
			foreach ($gallery_content as $value) {
				if (preg_match($regex, $value)) {
					$gallery_pictures[] = $value;
				}
			}

			// if pictures name from folder exist in metadata
			// name and metadata are add to the array
			// if not exist name is add ass metadata
			$metadata = $this->getPictureMetatdata($lines_utf8);
			$pics_to_add = array();
			foreach ($gallery_pictures as $value) {
				if (array_key_exists($value, $metadata)) {
					$pics_to_add[$value] = $metadata[$value];
				}else{
					$pics_to_add[$value] = $value.'::';
				}
			}
			
			// insert in BDD pics name and data
			foreach ($pics_to_add as $key => $value) {
				$link = $dir.'/'.$key;
				$thumb_dir = $dir.'/thumbs';
				$thumb = $thumb_dir.'/'.$key;
				$escape_value = htmlspecialchars($value, ENT_QUOTES);
				$this->createThumbnail($key, $dir.'/', $thumb_dir );
				$split = preg_split("/::/", $escape_value, -1, PREG_SPLIT_NO_EMPTY);
				if(isset($split[0])){
					$pic_title = $split[0];
				}else{
					$pic_title = $key;
				}
				if(isset($split[1])){
					$pic_subtitle = $split[1];
				}else{
					$pic_subtitle = "";
				}
				
				$sql = $this->_connexion->prepare("INSERT INTO pictures (gallery, name, info, link, thumb) values(:gallery, :name, :info, :link, :thumb)");
				$sql-> bindParam('gallery', $id, PDO::PARAM_INT);
				$sql-> bindParam('name', $pic_title, PDO::PARAM_STR);
				$sql-> bindParam('info', $pic_subtitle, PDO::PARAM_STR);		
				$sql-> bindParam('link', $link, PDO::PARAM_STR);		
				$sql-> bindParam('thumb', $thumb, PDO::PARAM_STR);		
				$sql-> execute();

			}

			unlink($dir.'/metadata.txt');


		}


		public function createThumbnail($filename, $path_to_image_directory, $path_to_thumbs_directory ) {
     
		    $final_width_of_image = 300;
		     
		    if(preg_match('/[.](jpg)$/', $filename)) {
		        $im = imagecreatefromjpeg($path_to_image_directory . $filename);
		    } else if (preg_match('/[.](gif)$/', $filename)) {
		        $im = imagecreatefromgif($path_to_image_directory . $filename);
		    } else if (preg_match('/[.](png)$/', $filename)) {
		        $im = imagecreatefrompng($path_to_image_directory . $filename);
		    }
		     
		    $ox = imagesx($im);
		    $oy = imagesy($im);
		     
		    $nx = $final_width_of_image;
		    $ny = floor($oy * ($final_width_of_image / $ox));
		     
		    $nm = imagecreatetruecolor($nx, $ny);
		     
		    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
		     
		    if(!file_exists($path_to_thumbs_directory)) {
		      if(!mkdir($path_to_thumbs_directory)) {
		           die("There was a problem. Please try again!");
		      }
		       }
		 
		    imagejpeg($nm, $path_to_thumbs_directory .'/'. $filename);
		    
		}

		public function check_galleries($gallery_list){
			$sql = $this->_connexion->prepare("SELECT folder FROM galleries");
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows as $key => $value) {
				$folder = 'photos/'.$value['folder'];
				if (!in_array($folder, $gallery_list)) {
					$sql_get_id = $this->_connexion->prepare("SELECT id FROM galleries WHERE folder = :folder");
					$sql_get_id-> bindParam('folder', $value['folder'], PDO::PARAM_STR);
					$sql_get_id-> execute();
					$rows = $sql_get_id->fetchAll(PDO::FETCH_ASSOC);
					$id = $rows[0]['id'];

					$sql_del_com = $this->_connexion->prepare("DELETE FROM comments WHERE gallery = :id");
					$sql_del_com-> bindParam('id', $id, PDO::PARAM_INT);
					$sql_del_com-> execute();

					$sql_del_pic = $this->_connexion->prepare("DELETE FROM pictures WHERE gallery = :id");
					$sql_del_pic-> bindParam('id', $id, PDO::PARAM_INT);
					$sql_del_pic-> execute();

					$sql_del_gal = $this->_connexion->prepare("DELETE FROM galleries WHERE folder = :folder");
					$sql_del_gal-> bindParam('folder', $value['folder'], PDO::PARAM_STR);
					$sql_del_gal-> execute();
				}
			}
		}

		public function displayGalleries(){
			$sql = $this->_connexion->prepare("SELECT galleries.id, galleries.name, pictures.thumb FROM galleries JOIN pictures ON galleries.id = pictures.gallery GROUP BY pictures.gallery ORDER BY galleries.name");
			$sql-> execute();
			$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
			$cpt = 1;
			foreach ($rows as $value) {
				echo '<a href="gallery.php?gal='.$value['id'].'"><div id="grid'.$cpt.'" class="grid" onMouseover="bounce(this.id)"><img id="'.$cpt.'"  src="'.$value['thumb'].'" class="img" alt="Responsive image"><div id="gallery_grid_title'.$cpt.'" class="gallery_grid_title"><p class="galtitle">'.$value['name'].'<p></div></div></a>';
				$cpt++;
			}
			
		}

	}



?>