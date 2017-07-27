<?php session_start();
	if(isset($_SESSION['nom'])) { }
	else {
			header('Location: login.php');
	}

	include 'class/PdoFonction.php';
	$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Atout Protect - Commandes</title>
		<meta charset="UTF-8">
		<meta name="format-detection" content="telephone=no">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="assets/img/logo.png">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome core CSS -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/jquery-ui.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

		<script>
			$(document).ready(function () {
				$("#moncompte").css({cursor: "pointer"})
					.on('click', function () {
							 $(this).find('ul').toggle();
					});
			});
	</script>

	<script>
	$(document).ready(function () {
		var url = window.location.pathname,
				urlRegExp = new RegExp(url.replace(/\/$/,'') + "$");

			$(document).ready(function () {
				$("#menu li a").hover(function () {
							if(urlRegExp.test(this.href.replace(/\/$/,''))) {
							}
							else {
								$(this).find('i').toggle();
							}
				});
			});
	});
	</script>

	<script>
		$(document).ready(function () {
			$(function(){
				var url = window.location.pathname,
						urlRegExp = new RegExp(url.replace(/\/$/,'') + "$");

						$("#menu_ul a").each(function() {
								if(urlRegExp.test(this.href.replace(/\/$/,''))) {
									 $(this).css("color","#FFFFFF");
									 $(this).find('i').css("color","#FFFFFF");
									 $(this).find('i').toggle();
								}
						});
			});
		});
	</script>

	<script src="assets/js/jquery.simplePagination.js"></script>
	<script>
		$(document).ready(function() {
			$("#list_commandes").simplePagination({
				// the number of rows to show per page
				perPage: 10,
				// CSS classes to custom the pagination
				containerClass: '',
				previousButtonClass: 'btn btn-secondary btn-custom-pagination',
				nextButtonClass: 'btn btn-secondary btn-custom-pagination',
				// text for next and prev buttons
				previousButtonText: 'Précédent',
				nextButtonText: 'Suivant',
				// initial page
				currentPage: 1
			});
		});
	</script>
	</head>

	<body>

		<!-- Static navbar -->
    <div class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php" id='grostitre' name='grostitre'><img src="assets/img/logo2.png" title="Atout Protect">&nbsp;&nbsp;ATOUT PROTECT</a><br/>
          <?php if(isset($_SESSION['nom'])) { ?>
						<br /><br /><br /><br />
            <div id="moncompte">
              <font color="#D8D6D6">&nbsp;&nbsp;Bienvenue <?php echo $_SESSION['nom']; ?>&nbsp;<?php echo $_SESSION['prenom']; ?></font>&nbsp;&nbsp;<img src="assets/img/submenu.png"></img>
								<ul style="display:none;">
									<li id="compte" style='color:white'>
										<a href="account.php" style='color:white' onmouseover="this.style.color='#CCCCCC'" onmouseout="this.style.background='';this.style.color='white';"><i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;Mon Compte</a>
									</li>
									<li id="commandes" style='color:white'>
										<a href="orders.php" style='color:white' onmouseover="this.style.color='#CCCCCC'" onmouseout="this.style.background='';this.style.color='white';"><i class="fa fa-files-o" aria-hidden="true"></i>&nbsp;Mes Commandes</a>
									</li>
									<?php if($_SESSION['droit'] == 1 || $_SESSION['droit'] == 2) { ?>
										<li id="admin" style='color:white'>
	                    <a href="admin.php" style='color:white' onmouseover="this.style.color='#CCCCCC'" onmouseout="this.style.background='';this.style.color='white';"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;Administration</a>
	                  </li>
									<?php } ?>
									<li id="disconnect" style='color:white'>
										<a href="modules/session_destroyer.php" style='color:white' onmouseover="this.style.color='#CCCCCC'" onmouseout="this.style.background='';this.style.color='white';"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Me déconnecter</a>
									</li>
								</ul>
            </div>
          <?php }
          else { ?>
          <?php } ?>
        </div>
        <div class="navbar-collapse collapse" id="menu" name="menu">
          <ul class="nav navbar-nav navbar-right" id="menu_ul" name="menu_ul">
						<li><a href="index.php" id="accueil" name="accueil" ><i class="fa fa-home fa-lg" style="color:white;" ></i>&nbsp;&nbsp;Accueil</a></li>
						<li><a href="basket.php" id="panier" name="panier" ><i class="fa fa-shopping-cart fa-lg" style="color:white;" ></i>&nbsp;&nbsp;Panier
							<?php if(isset($_SESSION['panier'])) {
								if(isset($_SESSION['panier']['logiciel'])) {
									if(sizeof($_SESSION['panier']['logiciel']) > 0) { ?>
										<span class="badge"><?php echo count($_SESSION['panier']['logiciel']); ?></span>
									<?php }
								}
								else { ?>
									<span class="badge">0</span>
								<?php }
							} else { ?>
								<span class="badge">0</span>
							<?php }?>
						</a></li>
            <li><a href="about.php" id="apropos" name="apropos" ><i class="fa fa-info fa-lg" style="color:white;" ></i>&nbsp;&nbsp;A propos</a></li>
            <li><a href="contact.php" id="contact" name="contact" ><i class="fa fa-envelope fa-lg" style="color:white;" ></i>&nbsp;&nbsp;Contact</a></li>
            <?php if(isset($_SESSION['nom'])) { ?>
            <?php }
            else { ?>
                <li><a href="login.php" id="login" name="login"><i class="fa fa-user fa-lg" style="color:white;" ></i>&nbsp;Se connecter</a></li>
            <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

		<div class="container pt">
				<div class="col-lg-6 col-lg-offset-3 centered">
					<h3>COMMANDES :</h3>
					<hr>
				</div>
		</div>

	<?php $req = $maPdoFonction->CommandePerso($_SESSION['nom']);
			if($req->rowCount() >= 1) { ?>

				<div class="alert alert-warning" style="margin-left:2%;margin-right:2%;text-align:center;">
					<strong> Voici l'ensemble de vos commandes. </strong>
				</div>

				<table class="table table-bordered table-responsive table-striped" style="margin-left:5%;width:91%;" id="list_commandes" name="list_commandes">
					<thead>
						<tr style="background-color:#2f2f2f;text-align:center;color:white;">
								<th>
									N° Commande
								</th>
								<th>
									Date
								</th>
								<th>
									Montant total
								</th>
								<th>
									Type de paiement
								</th>
								<th>
									Facture
								</th>
						</tr>
					</thead>
				<?php while($donnees = $req->fetch()) { ?>
					<tr>
									<td name='numcommande' id='numcommande' style="text-align:center;"><?php echo $donnees["numTransaction"]; ?></td>
									<td name='datecommande' id='datecommande' ><?php echo date("d/m/Y", strtotime($donnees["date"])); ?></td>
									<td name='montanttotalcommande' id='montanttotalcommande' ><?php echo $donnees["montant"]; ?> €</td>
									<td name='typepaeiementcommande' id='typepaeiementcommande' >
										<?php if($donnees["typedepaiement_id"] == 1) {
											echo "PayPal";
										}
										else if($donnees["typedepaiement_id"] == 2) {
											echo "AlloPass";
										}?>
									</td>
									<td>
										<?php $link = "http://localhost/atoutprotect/factures/".$_SESSION['nom']."/Facture_ATOUTSA_".$donnees["numTransaction"].".pdf"; ?>
										<a href="<?php echo $link ?>" target="_blank"/>Facture-<?php echo $donnees["numTransaction"]; ?>.pdf</a>
									</td>
							</tr>
				<?php } ?>
				</table>
<?php }
	else { ?>
		<div class="alert alert-info center-block" style="width:40%;text-align:center">
			<i class="fa fa-info-circle"></i>&nbsp;
			  Vous n'avez fait aucune commande.
		</div><br/>

		<div class="container">
			<div class="row" style="width:100%;">
				<div class="panel panel-default">
				  <div class="panel-heading" style="font-family:'Arial Black', Gadget, sans-serif;font-size:16px">Procédure d'achat sur notre site WEB</div>
				  <div class="panel-body" style="margin-left:10px;">
						<div class="col-md-3">
							<div class="item">
									<span class="notify-badge">1</span>
							</div>
							<div class="thumbnail" style="height: 100%;">
								<img src="assets/img/cart.png" alt="" width="180px" height="180px">
								<div class="caption">
									<h4 class="pull-right"></h4>
									<h4><a href="#"></a></h4>
									<p style="text-align:justify">Ajouter des produits à votre <a target="_blank" href="http://localhost/atoutprotect/basket.php">panier</a>.</p>
								</div>
								<div class="ratings">
									<p class="pull-right"></p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="item">
									<span class="notify-badge">2</span>
							</div>
								<div class="thumbnail" style="height: 100%;">
									<img src="assets/img/login.png" alt="" width="180px" height="180px">
									<div class="caption">
										<h4 class="pull-right"></h4>
										<h4><a href="#"></a></h4>
										<p style="text-align:justify">Se connecter <a target="_blank" href="http://localhost/atoutprotect/login.php">connecter</a> au site WEB. Vous pouvez également créer un compte.</p>
									</div>
									<div class="ratings">
										<p class="pull-right"></p>
									</div>
								</div>
							</div>
						<div class="col-md-3">
							<div class="item">
									<span class="notify-badge">3</span>
							</div>
							<div class="thumbnail" style="height: 100%;">
								<img src="assets/img/paypal_htb.png" alt="" width="180px" height="180px">
								<div class="caption">
									<h4 class="pull-right"></h4>
									<h4><a href="#"></a></h4>
									<p style="text-align:justify">Effectuer le paiement de votre <a target="_blank" href="http://localhost/atoutprotect/basket.php">panier</a>.</p>
								</div>
								<div class="ratings">
									<p class="pull-right"></p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="item">
									<span class="notify-badge">4</span>
							</div>
							<div class="thumbnail" style="height: 100%;">
								<img src="assets/img/mailing.png" alt="" width="180px" height="180px">
								<div class="caption">
									<h4 class="pull-right"></h4>
									<h4><a href="#"></a></h4>
									<p style="text-align:justify">Envoi de vos licences à l'adresse email de votre compte.</p>
								</div>
								<div class="ratings">
									<p class="pull-right"></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br /><br /><br />
	<?php } ?>

<br />

    <!-- +++++ Footer Section +++++ -->
  	<div id="footer">
  		<div class="container">
  			<div class="row_footer">
  				<div class="col-lg-4">
  					<h4><i class="fa fa-terminal fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;EDISOFT</h4>
  					<p>Rue BETEILLE,<br/>
              12 000 RODEZ (FRANCE)
  					</p>
  				</div><!-- /col-lg-4 -->

  				<div class="col-lg-4">
  					<h4><i class="fa fa-building-o fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;ATOUT S.A.</h4>
            <p>52 Rue de Limayrac,<br/>
  						05 61 36 08 08, <br/>
  						31 000 TOULOUSE (FRANCE)
  					</p>
  				</div><!-- /col-lg-4 -->

  				<div class="col-lg-4">
  					<h4>Développé par EDISOFT.</h4>
  				</div><!-- /col-lg-4 -->
					<div id="map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1444.8149786738888!2d1.4703662!3d43.5934235!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12aebcf724a7f7c5%3A0x6ce447ca66299696!2s52+Rue+de+Limayrac%2C+31500+Toulouse!5e0!3m2!1sen!2sfr!4v1487415612053" width="380" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
  			</div>

  		</div>
  	</div>


      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="assets/js/bootstrap.min.js"></script>
	</body>
</html>
