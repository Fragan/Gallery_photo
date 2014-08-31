<?php 
function upload($file) {
			// Optional: instance name (might be used to adjust the server folders for example)
			$CKEditor = $_GET['CKEditor'] ;

			// Required: Function number as indicated by CKEditor.
			$funcNum = $_GET['CKEditorFuncNum'] ;

			// Optional: To provide localized messages
			$langCode = $_GET['langCode'] ;
	        /**
	         * Charger le fichier
	         */
	      	$url = '' ;

			// Optional message to show to the user (file renamed, invalid file, not authenticated...)
			$message = '';
	        $dir = __DIR__;
			$dir .= "/uploads/";
	        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
	        $maxsize  = 200000;
	        $filename = $file['tmp_name'];
	        $extension =  strtolower(strrchr($file['name'], '.'));
	        $size = $file['size'];

	        if (!file_exists($filename)) {
	            $error = "Image non trouvée";
	        }else{
	        	if(!in_array($extension, $extensions)){
			   	 	$error = "Image non valide";
				}
				if($size > $maxsize){
					$error = "Image trop grande max 200ko";//"Taille max : 100Ko ";
				}
	        }

			if(isset($error)){
				$message = $error;
				echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message')</script>";
			}else{
				 $fichier = uniqid().$extension;
				 $url = 'uploads/'.$fichier;
			     if(move_uploaded_file($filename, $dir.$fichier)){
			     	echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message')</script>";
			     }
			}
	        
	    }

	upload($_FILES['upload']);


?>
