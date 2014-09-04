<?php 
ob_start();
require_once('php/param.class.php');
$param = new Param();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
  	<link href="style/favicon.ico" rel="icon">
    <meta author="Padow">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $param->setPageTitle(); ?>

    <!-- Bootstrap -->
    <link href="style/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="style/index.css">

  </head>
  <body ondragstart="return false;" ondrop="return false;">
  	<div class="body">
  	<?php 
  		require_once('php/connexion.class.php');
  		require_once('php/comment.class.php');
  	?>
 <div class="wrap">
  <div class="content">
	  <nav class="navbar navbar-inverse" role="navigation">
	    <div class="container">
	      <!-- Brand and toggle get grouped for better mobile display -->
	      <div class="navbar-header">
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	          <span class="sr-only">Toggle navigation</span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </button>
	        <a class="navbar-brand" href="./"><span class="glyphicon glyphicon-th"></span> Galeries</a>
	      </div>

	      <!-- Collect the nav links, forms, and other content for toggling -->
	      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	        <ul class="nav navbar-nav">
	          <li><a href="bio.php"><span class="glyphicon glyphicon-leaf"></span> A propos</a></li>
	        </ul>
	      </div><!-- /.navbar-collapse -->
	    </div><!-- /.container-fluid -->
	  </nav>
	  	<div class="container">
	  		<a href="#" onclick="window.close();" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-chevron-left"></span> Retourner à la galerie</a>
	  		<div class="sep"></div>
	  		<?php
	  			if (isset($_GET['gallery'])) {
	  				$gallery = $_GET['gallery'];
	  			}
	  			if (isset($_GET['pics'])) {
	  				$pics = $_GET['pics'];
	  			}
	  			if (isset($gallery) && isset($pics)) {
	  				$comment = new Comment();
	  				$comment->getPicture($gallery, $pics);
	  			}else{
	  				header("location: ./");
	  			}
	  			
	  		?>

	  		<div class="col-md-12 sep"></div>
		  	<form method="post" id="commentForm" name="commentForm" action="php/submitform.php">
	          <div class="col-md-12 no-pad">
		        <div class="col-md-12 border no-pad">
		          	<div class="col-md-12 comment-input-name">
			          	<div class="input-group ">
					      <div class="input-group-addon no-radius">Nom</div>
					     	 <input class="form-control no-radius" id="author-input" name="author" type="text" placeholder="Entrez votre nom" required>
					    </div>
			        </div>
		        </div>
	            <textarea id="form_Commentaire" class="textarea" wrap="soft" name="comment" required></textarea>
	          </div>
				<div id="alert-message" class="col-md-12 no-pad"></div>
	          <div class="col-md-3 no-padd">
	            <button onclick="antiSpam();" type="button" name="send" class="btn btn-sm btn-primary btn-block" style="margin-top: 10px;"><span class="glyphicon glyphicon-send"></span> Envoyer</button>
	          </div>
	          <input type="text" name="gallery" value="<?php echo $gallery; ?>" hidden >
	          <input type="text" name="pics" value="<?php echo $pics; ?>" hidden >
	        </form>
			<div class="col-md-12 sep"></div>
			<div class="col-md-12">
				<?php
	      		$comment->getComments($gallery, $pics); 
	    	?>
			</div>
	      	
	    	<div class="col-md-12 sep"></div>
	    	<div class="col-md-12">
	    		<a href="#" onclick="window.close();" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-chevron-left"></span> Retourner à la galerie</a>
	    	</div>
			
	  	</div>
	    
	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="js/jquery.min.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="style/bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/jquery-ui/jquery-ui.js"></script>
      <script src="js/index.js"></script>
  </div>
  <div class="footer">
    <div class="container">
      <div class="col-md-12 padd">
        <div class="col-md-8">
	       <?php $param->setFooter(); ?>
        </div>
        <div class="col-md-4 pull-right">  
          © 2014 <a href="http://steamcommunity.com/id/padow/" target="_blank">Padow</a>. All rights reserved.
        </div>
      </div>
    </div>
  </div>
</div>
</div>
  </body>
</html>
<?php ob_end_flush(); ?>
<span class="del"></span>