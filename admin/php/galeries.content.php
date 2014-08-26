<?php  
 	session_name('IDSESSION');
	session_start();
	$_SESSION['display'] = "displayGals();";
	if (isset($_POST['gallery'])) {
		$_SESSION['gallery'] = htmlspecialchars($_POST['gallery'], ENT_QUOTES);
	}
	require_once('../../php/connexion.class.php'); 
	require_once('admin.class.php');

	$gallery = new Admin();
	$gallery->getGalleryInfo($_SESSION['gallery']);
?>
	<div class="form-back">
      <div class="form-fix">
        <div class="form-close"><span onclick="hidePicsForm();" class="glyphicon glyphicon-remove"></span></div>
        <form method="post">
          <div class="form-group row">
            <div class="input-group">
              <span class="input-group-addon">Titre</span>
              <input type="text" class="form-control" value="" name="titre" id="inputtitre" required >
            </div>
            <div class="sep"></div>
            <div class="input-group">
              <span class="input-group-addon">Sous-titre</span>
              <input type="text" class="form-control" value="" name="soustitre" id="inputsoustitre">
            </div>
              <input type="text"  value="" name="id" id="inputid" hidden="hidden" >
            <div class="sep"></div>
            <button class="btn btn-primary" type="submit" name="modifier"><span class="glyphicon glyphicon-ok"></span> Modifier</button>                
          </div>
        </form> 
      </div>
    </div>

    <div class="gal-form-back">
      <div class="form-fix">
        <div class="form-close"><span onclick="hideGalForm();" class="glyphicon glyphicon-remove"></span></div>
        <form method="post">
          <div class="form-group row">
            <div class="input-group">
              <span class="input-group-addon">Titre</span>
              <input type="text" class="form-control" value="" name="galtitre" id="galinputtitre" required >
            </div>
            <div class="sep"></div>
            <div class="input-group">
              <span class="input-group-addon">Sous-titre</span>
              <input type="text" class="form-control" value="" name="galsoustitre" id="galinputsoustitre">
            </div>
              <input type="text"  value="" name="galid" id="galinputid" hidden="hidden">
            <div class="sep"></div>
            <button class="btn btn-primary" type="submit" name="galmodifier"><span class="glyphicon glyphicon-ok"></span> Modifier</button>                
          </div>
        </form> 
      </div>
    </div>

