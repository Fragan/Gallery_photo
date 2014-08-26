<?php 
ob_start(); 
session_name('IDSESSION');
session_start();
if ((!isset($_SESSION['log'])) || (empty($_SESSION['log']))){
  $session = false;
}else{
  $session = true;
  if(isset($_SESSION['display'])) {
    $displaydiv = $_SESSION['display'];
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <link href="../style/favicon.ico" rel="icon">
    <meta author="Padow">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration</title>

    <!-- Bootstrap -->
    <link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/gallery/css/blueimp-gallery.css">
    
  </head>
  <body ondragstart="return false;" ondrop="return false;">
    <div class="body">
  	<?php 
      require_once('../php/connexion.class.php');     
  		require_once('php/admin.class.php'); 		
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
          <a class="navbar-brand" href="../"><span class="glyphicon glyphicon-th"></span> Galeries</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="../bio.php"><span class="glyphicon glyphicon-leaf"></span> A propos</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
	  	<div id="container" class="container">
  	  	<h1>admin</h1>
        <?php 
          $admin = new Admin();
          $admin->display($session);
          if(isset($_POST['login'])){
            $admin->login($_POST['pseudo'], $_POST['password']);
          }
        ?>
       
        <?php 
          if (isset($_POST['modifier'])) {
            $admin->updatePics($_POST['titre'], $_POST['soustitre'], $_POST['id']);
          }
          if (isset($_POST['galmodifier'])) {
            $_SESSION['gallery'] = htmlspecialchars($_POST['galtitre'], ENT_QUOTES);
            $admin->updateGals($_POST['galtitre'], $_POST['galsoustitre'], $_POST['galid']);
          }
        ?>
  	  	</div>



     
      
      

	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="../js/jquery.min.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="../style/bootstrap/js/bootstrap.min.js"></script>   
      <script type="text/javascript" src="../js/jquery-ui/jquery-ui.js"></script>
      <script src="../style/gallery/js/blueimp-gallery.js"></script>
      <script src="../js/index.js"></script>
      <script type="text/javascript">
        $( window ).resize(function() {
          displayScroll();
        });
      </script>
      <?php 
        if(isset($displaydiv)){
          echo '<script type="text/javascript">'.$displaydiv.'</script>';
        }
      ?>
      <script src="../js/bootstrapfileinput.js"></script>
      
  </div>
  <div class="scroll">
    <button onclick="scrollingTop()" class="btn btn-default btn-sm scrtop"><span class="glyphicon glyphicon-chevron-up"></span> Top</button>
  </div>
  <div class="footer">
    <div class="container">
      <div class="col-md-12 padd">
        <div class="col-md-8">
	       <a href="https://github.com/Padow/Gallery_photo" target="_blank">Github</a>
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