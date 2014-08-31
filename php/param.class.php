<?php  
 Class Param {

 	public function getJson(){
 		$path = "config/param.json";
 		if (file_exists($path)) {
 			$array = json_decode(file_get_contents($path));
			return $array;
 		}
 	}

 	public function setPageTitle(){
 		if ($this->getJson()){
 			@$title = $this->getJson()->{'header'}->{'pagename'};
 		}
 		if ((isset($title)) && ($title !=""))
 			echo '<title>'.$title.'</title>';
 		else
 			echo '<title>Galerie photo</title>';
 	}

 	public function setContentTitle(){
 		if ($this->getJson()){
 			@$content = $this->getJson()->{'content'}->{'title'};
 		}
 		if ((isset($content)) && ($content !=""))
 			echo '<h1>'.$content.'</h1>';
 		else
 			echo '<h1>Galeries</h1>';
 	}

 	public function setFooter(){
 		if ($this->getJson()){
 			@$contact = $this->getJson()->{'footer'}->{'contact'};
 		}
 		if ((isset($contact)) && ($contact !=""))
 			echo '<a href="mailto:'.$contact.'" >Contact</a>';
 	}


 }


?>