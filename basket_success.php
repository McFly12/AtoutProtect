<?php
	include_once("gestionpanier.php");
  require("class/PayPal.php");
	require 'PHPMailer/PHPMailerAutoload.php';

$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
   if(!in_array($action,array('ajouter', 'suppression', 'refresh')))
   $erreur=true;

   //récuperation des variables en POST ou GET
   $nom = (isset($_POST['nom_logiciel'])? $_POST['nom_logiciel']:  (isset($_GET['nom_logiciel'])? $_GET['nom_logiciel']:null ));
   $quantite = (isset($_POST['quantite_logiciel'])? $_POST['quantite_logiciel']:  (isset($_GET['quantite_logiciel'])? $_GET['quantite_logiciel']:null ));
   $prix = (isset($_POST['prix_logiciel'])? $_POST['prix_logiciel']:  (isset($_GET['prix_logiciel'])? $_GET['prix_logiciel']:null ));
	 $type = (isset($_POST['type_logiciel'])? $_POST['type_logiciel']:  (isset($_GET['type_logiciel'])? $_GET['type_logiciel']:null ));
	 $abonnement = (isset($_POST['type_abonnement'])? $_POST['type_abonnement']:  (isset($_GET['type_abonnement'])? $_GET['type_abonnement']:null ));

   //Suppression des espaces verticaux
   $nom = preg_replace('#\v#', '',$nom);
   //On verifie que $p soit un float
   // $prix = floatval($prix);

   //On traite $q qui peut etre un entier simple ou un tableau d'entier

   if (is_array($quantite)) {
      $QteArticle = array();
      $i=0;
      foreach ($quantite as $contenu){
         $QteArticle[$i++] = intval($contenu);
      }
   }
   else {
		 // $q = intval($q);
	 }

}

if (!$erreur){
   switch($action){
      Case "ajouter":
         ajouterArticle($nom,$quantite,$prix,$type,$abonnement);
         break;

      Case "suppression":
         supprimerArticle($nom);
         break;

      Case "refresh" :
         for ($i = 0 ; $i < count($QteArticle) ; $i++)
         {
            modif_qte($_SESSION['panier']['logiciel'][$i],round($QteArticle[$i]));
         }
         break;

      default:
         break;
   }
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Atout Protect - Panier</title>
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

		<?php  include 'class/PdoFonction.php';
					 $maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
					 error_reporting(E_ALL);
					 ini_set('error_reporting', E_ALL);
		?>

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

	<script>
		$(document).ready(function () {
			$( "#ModifierItemBasket" ).click(function() {
				var quantite_logiciel = $(this).closest('tr').find('td:eq(3)').text();

				$(this).closest('tr').find('td:eq(3)').html(' <input type="number" name="nouv_quantite" min="0" value='+quantite_logiciel+'> ');

				var val = $(this).closest('tr').find('td:eq(3)').find('input').val();
				$(this).closest('tr').find('td:eq(3)').find('input').val(val);

				if( $(this).closest('tr').find('td:eq(5)').find('button.btn-success').length == 0 ) {
					$(this).closest('tr').find('td:eq(5)').append(' <br /><br /><button type="button" class="btn btn-success" style="height:30px;font-size:15px;padding:0;" id="button_save_baket" onclick="SaveFullBasket(this.id)"> <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Enregistrer</button> ');
				}
				else
				{
					$(this).closest('tr').find('td:eq(5)').find('button.btn-success').remove();
					$(this).closest('tr').find('td:eq(5)').append('<button type="button" class="btn btn-success" style="height:30px;font-size:15px;padding:0;" name="button_save_baket" id="button_save_baket" onclick="SaveFullBasket(this.id)"> <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Enregistrer</button> ');
				}

			});
		});
	</script>

	<script>
		function SaveFullBasket(button_id) {
			var button = document.getElementById(button_id);

			var nom_logiciel = $(button).closest('tr').find('td:eq(0)').text();
			var type_logiciel = $(button).closest('tr').find('td:eq(1)').text();
			var abo_logiciel = $(button).closest('tr').find('td:eq(2)').text();
			var quantite_logiciel = $(button).closest('tr').find('td:eq(3)').find('input').val();

			$(button).closest('tr').find('td:eq(3)').html(quantite_logiciel);

				$.ajax({
					url: "modules/SaveModifFullBasket.php",
					data: {'nom': nom_logiciel ,'type': type_logiciel ,'abo': abo_logiciel ,'quantite': quantite_logiciel},
					success: function(){
						// similar behavior as an HTTP redirect
						window.location.replace("http://localhost/atoutprotect/basket.php?SaveFullBasketOK");
		    	}
			});

			$(button).remove();
		}
	</script>

	<script>
		$(document).ready(function () {
			$( ".deleteItemBasket" ).click(function() {

				var nom_logiciel = $(this).closest('tr').find('td:eq(0)').text();
				var type_logiciel = $(this).closest('tr').find('td:eq(1)').text();
				var abo_logiciel = $(this).closest('tr').find('td:eq(2)').text();
				var quantite_logiciel = $(this).closest('tr').find('td:eq(3)').text();
				var th = $(this);
				$(this).closest('tr').remove();

					$.ajax({
						url: "modules/SaveSupprimerFullBasket.php",
						data: {'nom': nom_logiciel ,'type': type_logiciel ,'abo': abo_logiciel ,'quantite': quantite_logiciel},
						success: function(){
							// similar behavior as an HTTP redirect
							window.location.replace("http://localhost/atoutprotect/basket.php?SaveFullBasketOK");
						}
					});
			});
		});
	</script>

		<script>
			function InputCodePromo() {
				$('#CodePromoModalInput').modal();
			}
		</script>

		<script>
			function ApplyPromo() {
				var code = document.getElementById('codepromo_input').value;

				var pourcentage_reduc = "";

				$.ajax({
					type: "GET",
					data: {'code': code},
					url: 'modules/VerifCodePromo.php',
					dataType: 'json',
					success: function(json) {
						var len = json.length;
							if(len > 0) {
								$.each(json, function(value, key) {
										pourcentage_reduc = key.pourcentage_reduc;
										$.ajax({
											type: "GET",
											data: {'pourcentage_reduc': pourcentage_reduc},
											url: 'modules/UpdateRemise.php',
											success: function() {
												$('#CodePromoModalInput').modal('toggle');
												location.reload();
											}
										});
								});
							}
						}
					});

			}
		</script>

	</head>

	<body>

		<div class="modal fade" id="CodePromoModalInput" tabindex="-1" role="dialog" aria-labelledby="CodePromoModalInput" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		            <h4 class="modal-title" id="myModalLabel">Votre code promotion</h4>
		            </div>
		            <div class="modal-body">
		                <input id="codepromo_input" type="text" class="form-control" maxlength="10" name="codepromo_input" placeholder="Code promotion" required />
		            </div>
		            <div class="modal-footer">
									<button type="button" class="btn btn-primary" style="width:100px;height:35px;" onclick="ApplyPromo();">Appliquer</button>
		              <button type="button" class="btn btn-default" data-dismiss="modal" style="width:100px;height:35px;">Annuler</button>
		        </div>
		    </div>
		  </div>
		</div>

		<!-- Static navbar -->
		<!-- MENU -->
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

<br />

<?php if(!isset($_GET['PayPalOk'])) { ?>
	<div class="alert alert-warning" style="margin-left:2%;margin-right:2%;text-align:center;">
  	<strong> Attention ! Si vous vous déconnectez de votre compte, votre panier sera perdu. </strong>
	</div><br />
<?php }
else if(isset($_GET['PayPalOk'])) {
} ?>

<!-- Static navbar -->
<!-- ONGLETS -->
<div class="container" style="width:100%">
    <ul class="nav nav-tabs">
        <li class="nav" style="width:25%" id="lienTabA" name="lienTabA">
					<a href="#A" data-toggle="tab">
					<i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
						&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Panier</font>
					</a>
				</li>
        <li class="nav" style="width:25%" onmouseover="style='cursor:not-allowed;width:25%'" onmouseover="style='cursor:default;width:25%'">
					<a>
						<span class="glyphicon glyphicon-user" style="font-size:inherit;color:#555555"></span>
							&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Inscription / Connexion</font>
					</a>
				</li>

				<?php if(!isset($_SESSION['nom'])) { ?>
	        <li class="nav" style="width:25%" onmouseover="style='cursor:not-allowed;width:25%'" onmouseover="style='cursor:default;width:25%'">
						<a>
							<i class="fa fa-credit-card" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
								&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Paiement</font>
						</a>
					</li>
					<li class="nav" style="width:25%" onmouseover="style='cursor:not-allowed;width:25%'" onmouseover="style='cursor:default;width:25%'">
						<a>
							<i class="fa fa-check" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
								&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Validation</font>
						</a>
					</li>
				<?php }
				 	else {
						if(isset($_GET['PayPalOk'])) { ?>
						<li class="nav" style="width:25%" onmouseover="style='cursor:not-allowed;width:25%'" onmouseover="style='cursor:default;width:25%'">
							<a>
								<i class="fa fa-credit-card" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
									&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Paiement</font>
							</a>
						</li>
						<?php }
						else { ?>
							<li class="nav" style="width:25%" onmouseover="style='cursor:pointer;width:25%'" onmouseover="style='cursor:default;width:25%'">
								<a href="#C" data-toggle="tab" id="lienTabC">
									<i class="fa fa-credit-card" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
										&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Paiement</font>
								</a>
							</li>
						<?php } ?>
						<?php if(isset($_GET['PayPalOk'])) { ?>
										<li class="nav active" style="width:25%" onmouseover="style='cursor:not-allowed;width:25%'" onmouseover="style='cursor:default;width:25%'" id="lienTabD" name="lienTabD">
											<a href="#D" data-toggle="tab">
												<i class="fa fa-check" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
													&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Validation</font>
											</a>
										</li>
									<?php }
						 else { ?>
							 <li class="nav active" style="width:25%" onmouseover="style='cursor:not-allowed;width:25%'" onmouseover="style='cursor:default;width:25%'" id="lienTabD" name="lienTabD">
 								<a href="#D" data-toggle="tab">
 									<i class="fa fa-check" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
 										&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Validation</font>
 								</a>
 							</li>
					<?php }
					} ?>

    </ul>

    <!-- Tab panes -->
		<!-- Content de chaque onglet -->
    <div class="tab-content">
	     <div class="tab-pane fade" id="A" name="A">
				 <br/> <br/>
					<div class="alert alert-info" style="width:50%;text-align:center;float: none;margin: 0 auto;">
				  	<strong> <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Votre panier est vide. </strong>
					</div>
			</div>

	     <div class="tab-pane fade" id="B" name="B"><br />
			</div>

			<div class="tab-pane fade" id="C" name="C">
			</div>

			<div class="tab-pane fade in active" id="D" name="D"><br />


				<br/><div class="alert alert-success" style="margin-left:2%;margin-right:2%;text-align:center;">
					<span><i class="fa fa-check" aria-hidden="true" style="float:left;font-size:50px;margin-top:20px;"></i></span>
					<h3><span style="color:#aab2bc;"></span>Votre paiement PayPal a été validé.</h3>
					<p>Votre numéro de transaction est : <b><?php echo $_GET['token']; ?></b>. Le montant de celle-ci est de <b><?php echo number_format($_SESSION['totalTVA'], 2, ',', ' ') ?> €.</b></p>
					<br /><p>Les clefs de licences commandées ainsi que la facture, vous seront envoyés à l'adresse email suivante : <b><?php echo $_SESSION['email']; ?></b></p><br />
				</div>

			</div>
	  </div>

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
