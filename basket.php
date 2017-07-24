<?php
	include_once("gestionpanier.php");
  require("class/PayPal.php");
	require('class/PDF.php');
	require 'PHPMailer/PHPMailerAutoload.php';

	ob_start();

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

	<!-- PARAMETRAGE REDIRECTION -->
	<script>
		$(document).ready(function () {

			var url_recup = 	window.location.href;
			var url = new URL(url_recup);
			var c = url.searchParams.get("PayPalOk");

			// INIT : A L'OUVERTURE DE LA PAGE
			if(c == 'OK') {

				// IMPOSSIBLE DE RE-PAYER
				$('#C').attr('disabled', true);
				$('#lienTabC').attr('href', '');

				// SUPPRIMER LE ACTIF SUR LES li
				$('#lienTabA').removeClass( "active" );

				// OUVERTURE DU DIV DE LA VALIDATION DU PAIEMENT
				$('.nav-tabs a[href="#D"]').tab('show');
			}

		});
	</script>

	<script>
		$(document).ready(function () {
			$( "#GoToPayment" ).click(function() {
				$('#C').addClass( "active in" );
			  $('.nav-tabs a[href="#C"]').tab('show');
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


<!-- Static navbar -->
<!-- ONGLETS -->
<div class="container" style="width:100%">
    <ul class="nav nav-tabs">
        <li class="nav active" style="width:25%" id="lienTabA" name="lienTabA">
					<a href="#A" data-toggle="tab">
					<i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
						&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Panier</font>
					</a>
				</li>
        <li class="nav" style="width:25%" onmouseover="style='cursor:pointer;width:25%'" onmouseover="style='cursor:default;width:25%'">
					<a href="#B" data-toggle="tab">
						<span class="glyphicon glyphicon-user" style="font-size:inherit;color:#555555"></span>
							&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Inscription / Connexion</font>
					</a>
				</li>

				<?php
				$nbArticles = count($_SESSION['panier']);
				if(!isset($_SESSION['nom']) || $nbArticles == 0) {  ?>
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
				 	else {?>
						<li class="nav" style="width:25%" onmouseover="style='cursor:pointer;width:25%'" onmouseover="style='cursor:default;width:25%'">
							<a href="#C" data-toggle="tab" id="lienTabC">
								<i class="fa fa-credit-card" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
									&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Paiement</font>
							</a>
						</li>
						<?php if(isset($_GET['PayPalOk']) && $_GET['PayPalOk'] == "OK") { ?>
										<li class="nav" style="width:25%" onmouseover="style='cursor:pointer;width:25%'" onmouseover="style='cursor:default;width:25%'" id="lienTabD" name="lienTabD">
											<a href="#D" data-toggle="tab">
												<i class="fa fa-check" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
													&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Validation</font>
											</a>
										</li>
									<?php }
						 else { ?>
							 <li class="nav" style="width:25%" onmouseover="style='cursor:not-allowed;width:25%'" onmouseover="style='cursor:default;width:25%'">
 								<a>
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
        <div class="tab-pane fade in active" id="A" name="A">

					<?php if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0) { ?>
							<div class="col-lg-6 col-lg-offset-3 centered">
								<h3>VOTRE PANIER :</h3>
								<hr>
								<p></p> <br />
							</div><br /><br /><br /><br /><br />

							<div class="table-responsive">
								<table class="table table-striped table-bordered" style="margin-left:0 auto;margin-left: 5px;">
									<thead>
										<tr style="font-size:18px;">
											<th style="width:18%;">
												Nom
											</th>
											<th style="width:18%">
												Type
											</th>
											<th style="width:18%">
												Abonnement
											</th>
											<th style="width:18%">
												Quantité
											</th>
											<th style="width:18%">
												Prix Unitaire (EUR)
											</th>
											<th style="width:10%">
												Action
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
												$nbArticles = count($_SESSION['panier']['logiciel']);
												if ($nbArticles <= 0) {

												}
												else
												{
													for ($i=0 ;$i < $nbArticles ; $i++)
													{
														echo "<tr style='padding:2px;'>";
																echo "<td style=\"font-weight:bold;text-align:center\">".$_SESSION['panier']['logiciel'][$i]."</td>";
																echo "<td>".$_SESSION['panier']['type'][$i]."</td>";
																echo "<td>".$_SESSION['panier']['abonnement'][$i]."</td>";
															  echo "<td>".htmlspecialchars($_SESSION['panier']['quantite'][$i])."</td>";
															  echo "<td>".htmlspecialchars(number_format($_SESSION['panier']['prix'][$i], 2, ',', ' '))." &euro;</td>";
																echo '<td>';
																if(!isset($_GET['PayPalOk'])) { ?>
																	<button type="button" class="btn btn-primary" style="height:30px;font-size:15px;padding:0;" id="ModifierItemBasket" name="ModifierItemBasket">
																		<i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;&nbsp;Modifier
																	</button><br/><br />
																		<button type="button" class="btn btn-danger deleteItemBasket" style="height:30px;font-size:15px;padding:0;" id="deleteItemBasket" name="deleteItemBasket">
																			<i class="fa fa-trash" aria-hidden="true"></i>&nbsp;&nbsp;Supprimer
																		</button>
																<?php }
																else { } ?>
																</td>
														</tr>
													<?php }
													echo "<tr style=\"height: 40px !important;background-color: #FFFFFF;\"><td colspan=\"6\"></td></tr>";

																$numberHT = montant_panier();

																echo "<tr><td colspan=\"4\"></td>";
	 															echo "<td><b><font style=\"font-size:20px;\">Total HT</font></b></td>";
																echo "<td style=\"font-size:20px;\"><b><font style=\"font-size:20px;\" >".number_format((float)$numberHT, 2, ',', ' ')." &euro;</font></b></td>";

																if(!isset($_SESSION['remise'])) {
																	$_SESSION['remise'] = 0.00;
																	$_SESSION['nouvprix'] = $numberHT;
																} ?>

																<?php echo "<tr><td colspan=\"4\"></td>";
																echo "<td><b><font style=\"font-size:20px;\">TVA</font></b></td>";
																echo "<td style=\"font-size:20px;\">20,00 %</td></tr>";

																$numberAvecTVA = "";
																$numberAvecTVA = $numberHT * (1 + (20 / 100));
                                $_SESSION['totalTVA'] = $numberAvecTVA;
																$_SESSION['numberHT'] = $numberHT;

																if($nbArticles == 1) {
																	echo "<tr><td colspan=\"4\"></td>";
		 															echo "<td><b><font style=\"font-size:20px;\">Total TTC ( ".$nbArticles." article )</font></b></td>";
																	echo "<td style=\"font-size:20px;\"><b><font style=\"font-size:20px;\" color=\"#e82323!important\">".number_format((float)$numberAvecTVA, 2, ',', ' ')." &euro;</font></b></td>";
																}
																else if($nbArticles > 1) {
																	echo "<tr><td colspan=\"4\"></td>";
		 															echo "<td><b><font style=\"font-size:20px;\">Total TTC ( ".$nbArticles." articles )</font></b></td>";
																	echo "<td style=\"font-size:20px;\"><b><font style=\"font-size:20px;\" color=\"#e82323!important\">".number_format((float)$numberAvecTVA, 2, ',', ' ')." &euro;</font></b></td>";
																}


													echo "</td></tr>";

													echo "</td></tr>";
												}
											?>
									</tbody>
								</table>
								<?php if(!isset($_GET['PayPalOk'])) { ?>
									<!-- <p style="margin-left:0 auto;margin-left: 7px;margin-top: -20px;" id="link_codepromo" onclick="InputCodePromo();">
										<a style="cursor:pointer;">
											Vous avez un code promotion ?
										</a>
									</p> -->
								<?php } ?>

								<br /><br />

								<?php $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									if(parse_url($url, PHP_URL_QUERY) != "PayPalOk") { ?>
										<button type="button" class="btn btn-primary" style="float:left;width:20%;margin-left:1%;font-size: 17px;">
											<a href="index.php" style="text-decoration:none;color:inherit;">
												<span class="glyphicon glyphicon-backward" style="font-size:15px;color:white;"></span>
													&nbsp;&nbsp;Poursuivre mes achats
											</a>
										</button>
										<button type="button" id="GoToPayment" name="GoToPayment" class="btn btn-primary" style="float:right;width:20%;margin-left:1%;font-size: 17px;">
												<span class="glyphicon glyphicon-credit-card" style="font-size:16px;color:white;"></span>
													&nbsp;&nbsp;Procéder au paiement
										</button><br /><br /><br />
								<?php } ?>

							</div>
							<?php
						}
						else { // Message si le panier est vide ?>
							 <br/> <br/>
							<div class="alert alert-info" style="width:50%;text-align:center;float: none;margin: 0 auto;">
							  <strong> <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Votre panier est vide. </strong>
							</div> <br /> <br />
							<div class="container">
								<div class="row" style="width:1800px;margin-left:-320px;">
									<div class="panel panel-default">
										<div class="panel-heading" style="font-family:'Arial Black', Gadget, sans-serif;font-size:16px">Procédure d'achat sur notre site WEB</div>
										<div class="panel-body" style="margin-left:10px;">
											<div class="col-md-3">
												<div class="item">
														<span class="notify-badge">1</span>
												</div>
												<div class="thumbnail" style="height: 298px;">
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
													<div class="thumbnail" style="height: 298px;">
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
												<div class="thumbnail" style="height: 298px;">
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
												<div class="thumbnail" style="height: 298px;">
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
						<?php } ?>
					</div>

        <div class="tab-pane fade" id="B" name="B"><br />
					<?php if(!isset($_SESSION['nom'])) { ?>
						<div class="row mt">
			        <div style="float:left;padding-left:10px;width:75%">
			    			<div role="form" class="col-lg-8 col-lg-offset-2">
			    				<form method="POST" action="modules/Connexion.php" id="login" style="font-size:27px;">
			              <div class="input-group">
			                <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-envelope" style="color:black;font-size:12px;"></span></span>
			                <input type="email" class="form-control" style="width:75%;" name="InputEmail1" placeholder="Email" autocomplete="off" autofocus="on" aria-describedby="sizing-addon2">
			              </div><br />
			              <div class="input-group">
			                <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-lock" style="color:black;font-size:12px;"></span></span>
			                <input type="password" class="form-control" style="width:75%;" name="InputPassword1" placeholder="Mot de passe" autocomplete="off" aria-describedby="sizing-addon2">
			              </div><br />
			              <div align="center">
			                <button type="submit" class="btn btn-success" style="width:75%" id="seconnecter"><span class="glyphicon glyphicon-log-in" style="color:white;font-size:12px;"></span>&nbsp;&nbsp;SE CONNECTER</button>
			              </div>
			    				</form>
			    			</div>
			          <br /> <div class="vertical-row"></div>
			        </div>

			        <div style="float:right;padding-right:10px;width:25%">
			    			<div role="form" class="col-lg-8 col-lg-offset-2">
			              <div><br /><br /><br /><br />
			                <a href="createaccount.php">
			                  <button type="submit" class="btn btn-success" style="width:105%" ><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;Créer un compte</button>
			                </a>
			              </div>
			    			</div>
			        </div>
			  		</div><!-- /row -->

					<?php }
					else { ?><br />

						<div class="alert alert-success" style="margin-left:2%;margin-right:2%;text-align:center;">
							<span><i class="fa fa-check" aria-hidden="true" style="float:left;font-size:50px;margin-top:20px;"></i></span>
							<h3><span style="color:#aab2bc;"></span>Vous êtes connecté en tant que <?php echo $_SESSION['prenom'];?> <?php echo $_SESSION['nom']; ?>.</h3>
							<p>Si vous voulez vous authentifier avec un autre compte, veuillez vous rendre sur la page de connexion, en vous ayant <a href="modules/session_destroyer.php">déconnecté</a> au préalable.</p>
						</div>

					<?php } ?>
				</div>


				<div class="tab-pane fade" id="C" name="C">
					<?php $nbArticles = count($_SESSION['panier']);
					if($nbArticles != 0) {

          $paypal = new PayPal();

					    $params = array(
					      'RETURNURL' => 'http://localhost/atoutprotect/basket.php?PayPalOk=OK',
					      'CANCELURL' => 'http://localhost/atoutprotect/basket.php?ErrPayPal',

					      'PAYMENTREQUEST_0_AMT' => $_SESSION['totalTVA'],
					      'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR'
					    );

                foreach ($_SESSION['panier'] as $key => $value)
                {
                  $params["L_PAYMENTREQUEST_0_NAME$key"] = $_SESSION['panier']['logiciel'];
                  $params["L_PAYMENTREQUEST_0_DESC$key"] = '';
                  $params["L_PAYMENTREQUEST_0_AMT$key"] = $_SESSION['panier']['prix'];
                  $params["L_PAYMENTREQUEST_0_QTY$key"] = $_SESSION['panier']['quantite'];
                }

                $reponse = $paypal->request('SetExpressCheckout', $params);

                if($reponse) {
                  $paypal = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token='.$reponse['TOKEN'];
                }
                else {
                  var_dump($paypal->errors);
                  die('Erreur');
                }	?>

              <br />
              <h3 align="center" style="font-size:20px;">Veuillez choisir votre mode de paiement :</h3><hr>
							<br /><br />
										<!-- <div class="container">
											<div class="row" > -->

												<div class="columns" style="margin-left:30%;">
													<ul class="price">
													<li class="header"><img src="assets/img/PayPal.png"></img>&nbsp;PayPal</li>
													<div style=""></div>
													<li class="grey" style="font-size:14px">PayPal est un service de paiement en ligne qui permet de payer des achats, de recevoir des paiements, ou d’envoyer et de recevoir de l’argent.</li>
													<li class="grey" style="background-color:#FFF"><a href="<?php echo $paypal ?>" class="button">Accéder</a></li>
													</ul>
												</div>

												<!-- <div class="columns" style="margin-left:10%;">
													<ul class="price">
													<li class="header"><img src="assets/img/MasterCard.png"></img>&nbsp;HiPay (ex: AlloPass)</li>
													<li class="grey" style="font-size:14px">AlloPass s’adresse aux marchands et aux internautes pour le micropaiement de biens digitaux (inscriptions ou options payantes sur les sites internet, achat d’articles de presse, ...).</li>
													<li class="grey" style="background-color:#FFF"><a href="#C" class="button">Accéder</a></li>
													</ul>
												</div> -->

											<!-- </div>
										</div> -->

						<?php } ?>
				</div>

				<div class="tab-pane fade" id="D" name="D"><br />

					<?php if (isset($_GET['PayerID'])) {
						// ENREGISTREMENT DE LA COMMANDE
						$req = $maPdoFonction->EnregistrerCommandePayPal($_GET['token'],$_SESSION['totalTVA'],$_SESSION['nom']);
				  ?>

					<br/><div class="alert alert-success" style="margin-left:2%;margin-right:2%;text-align:center;">
						<span><i class="fa fa-check" aria-hidden="true" style="float:left;font-size:50px;margin-top:20px;"></i></span>
						<h3><span style="color:#aab2bc;"></span>Votre paiement PayPal a été validé.</h3>
						<p>Votre numéro de transaction est : <b><?php echo $_GET['token']; ?></b>. Le montant de celle-ci est de <b><?php echo number_format($_SESSION['totalTVA'], 2, ',', ' ') ?> €.</b></p>
						<br /><p>Les clefs de licences commandées ainsi que la facture, vous seront envoyés à l'adresse email suivante : <b><?php echo $_SESSION['email']; ?></b></p><br />
					</div>
				<?php	} ?>

					<?php
						if(!empty($_GET['token'])) {
							$content = '';
							$headers = '';
							$to = '';

							$clef = '';
							$logiciel = '';
							$type_logiciel = '';
							$id_logiciel = '';
							$abo_id = '';
							$abo = '';
							$idlogiciel = '';
							$type_logiciel_mail = '';

							$to = $_SESSION['email'];
						  $subject = "ATOUT PROTECT - ACTIVATION DE LOGCIELS";

								// Générer une licence unique et aléatoire
									function generation_clefs() {
										// CARACTERES ACCECPTES DANS UNE CLEF DE LICENCE
										$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
											// NOMBRE DE CARACTERES PAR SEGMENT DE LA CLEF DE LICENCE
										$segment_chars = 4;
											// NOMBRE DE SEGMENTS DE LA CLEF DE LICENCE
										$num_segments = 4;
											// CLEF GENEREE
										$clef = '';

											// GENERE CHAQUE SEGMENT
										for ($i = 0; $i < $num_segments; $i++) {
											$segment = '';

													// POUR CHAQUE SEGMENT => HASARD DE 5 CARCTERES AUTORISE VIA $caracteres
											for ($j = 0; $j < $segment_chars; $j++) {
											  $segment .= $caracteres[rand(0, 35)];
											}
													// CONCATENE DANS LA CLEF GENEREE
											$clef .= $segment;

											if ($i < ($num_segments - 1)) {
													$clef .= '-';
											}
										}
										return $clef;
									}

									// array_sum — Calcule la somme des valeurs du tableau
								$nbArticles = array_sum($_SESSION['panier']['quantite']);

								if($nbArticles == 1) {
									$clef = generation_clefs();

										for ($i=0 ;$i < $nbArticles ; $i++)
										{
											$nom = $_SESSION['nom'];

											if($_SESSION['panier']['logiciel'][$i] == 'Logiciel1') {
												$logiciel = 'Logiciel 1';
												$idlogiciel = 1;
											}
											else if($_SESSION['panier']['logiciel'][$i] == 'Logiciel2') {
												$logiciel = 'Logiciel 2';
												$idlogiciel = 2;
											}

											if($_SESSION['panier']['type'][$i] == 'standardlogiciel1' || $_SESSION['panier']['type'][$i] == 'standardlogiciel2') {
												$type_logiciel_mail = 'Standard';
											}
											if($_SESSION['panier']['type'][$i] == 'prologiciel1' || $_SESSION['panier']['type'][$i] == 'prologiciel2') {
												$type_logiciel_mail = 'Professionnel';
											}

											$type_logiciel = $_SESSION['panier']['type'][$i];

											if($_SESSION['panier']['abonnement'][$i] == "1") {
												$abo = "1 mois";
												$abo_id = 1;
											}
											else if($_SESSION['panier']['abonnement'][$i] == "3") {
												$abo = "3 mois";
												$abo_id = 3;
											}
											else if($_SESSION['panier']['abonnement'][$i] == "6") {
												$abo = "6 mois";
												$abo_id = 6;
											}
											else if($_SESSION['panier']['abonnement'][$i] == "12") {
												$abo = "1 an";
												$abo_id = 12;
											}
											else if($_SESSION['panier']['abonnement'][$i] == "0") {
												$abo = "A vie";
												$abo_id = 0;
											}
										}

										// PARAMETRES : $clef,$nom,$logiciel,$abo_id
										$req = $maPdoFonction->EnregistrerLicenceBase($clef,$nom,$idlogiciel,$type_logiciel_mail,$abo_id);

										$content = $logiciel.' -- '.$type_logiciel_mail.' -- '.$abo.'  : '.$clef;
										?>

										<?php
										$to      = $_SESSION['email'];
						}
								else if($nbArticles > 1) {

										for ($i=0 ;$i < $nbArticles ; $i++)
										{
											$clef = generation_clefs();
											$nom = $_SESSION['nom'];

											if($_SESSION['panier']['logiciel'][$i] == 'Logiciel1') {
												$logiciel = 'Logiciel 1';
												$idlogiciel = 1;
											}
											else if($_SESSION['panier']['logiciel'][$i] == 'Logiciel2') {
												$logiciel = 'Logiciel 2';
												$idlogiciel = 2;
											}

											if($_SESSION['panier']['type'][$i] == 'standardlogiciel1' || $_SESSION['panier']['type'][$i] == 'standardlogiciel2') {
												$type_logiciel_mail = 'Standard';
											}
											if($_SESSION['panier']['type'][$i] == 'prologiciel1' || $_SESSION['panier']['type'][$i] == 'prologiciel2') {
												$type_logiciel_mail = 'Professionnel';
											}

											$type_logiciel = $_SESSION['panier']['type'][$i];

											if($_SESSION['panier']['abonnement'][$i] == "1") {
												$abo = "1 mois";
												$abo_id = 1;
											}
											else if($_SESSION['panier']['abonnement'][$i] == "3") {
												$abo = "3 mois";
												$abo_id = 3;
											}
											else if($_SESSION['panier']['abonnement'][$i] == "6") {
												$abo = "6 mois";
												$abo_id = 6;
											}
											else if($_SESSION['panier']['abonnement'][$i] == "12") {
												$abo = "1 an";
												$abo_id = 12;
											}
											else if($_SESSION['panier']['abonnement'][$i] == "0") {
												$abo = "A vie";
												$abo_id = 0;
											}

											$content .= $logiciel.' -- '.$type_logiciel_mail.' -- '.$abo.'  : '.$clef.'%0D%0A';

											// PARAMETRES : $clef,$nom,$logiciel,$abo_id
											$req = $maPdoFonction->EnregistrerLicenceBase($clef,$nom,$idlogiciel,$type_logiciel,$abo_id);
										} ?>

										<?php
										$to      = $_SESSION['email'];
						 }

							 // Exemple de génération de devis/facture PDF

							 $date = date('d/m/Y');

							 $pdf = new PDF( 'P', 'mm', 'A4' );
							 $pdf->AddPage();
							 $pdf->addSociete( "\n\n\n\n\n\n\n\n\n\n\n\nATOUT S.A.",
																 "                    ".utf8_decode("52 Rue de Limayrac,\n").
																 "                    31 000 TOULOUSE (FRANCE)\n");
							 $pdf->fact_dev( "Facture_".$_GET['token'], "TEMPO" );
							 $pdf->temporaire( "ATOUT S.A." );
							 $pdf->addDate(date('d/m/Y'));
							 $pdf->addPageNumber("1 / 1");
							 $adresse = "                                                                                                                                     ".utf8_decode($_SESSION['adresse'].",\n")."                                                                                                                                     ".utf8_decode($_SESSION['codepostal'])." ".utf8_decode($_SESSION['ville']);
							 $nom = utf8_decode($_SESSION['nom']).' '.utf8_decode($_SESSION['prenom']);
							 $pdf->addClientAdresse($nom, $adresse);
							 $pdf->addReglement("PayPal");
							 $pdf->addEcheance( date('d/m/Y', strtotime("+31 days")) );

							 $cols=array( "NOM" => 29,
														"TYPE"  => 35,
														"ABONNEMENT" => 35,
														"QUANTITE" => 26,
														"P.U. H.T." => 30,
														"MONTANT H.T." => 35 );
							 $pdf->addCols($cols);
							 // ALIGNEMENT DU TEXTE
							 $cols=array( "NOM"    => "C",
														"TYPE"  => "C",
														"ABONNEMENT"     => "C",
														"QUANTITE"      => "C",
														"P.U. H.T." => "C",
														"MONTANT H.T."          => "C" );
							 $pdf->addLineFormat($cols);
							 $pdf->addLineFormat($cols);

							 $y    = 109;

							 $nbArticles = count($_SESSION['panier']['logiciel']);
							 for ($i=0 ;$i < $nbArticles ; $i++) {
								 $logiciel = "";
								 $type_logiciel = "";
								 $abo = "";
								 if($_SESSION['panier']['logiciel'][$i] == 'Logiciel1') {
									 $logiciel = 'Logiciel 1';
								 }
								 else if($_SESSION['panier']['logiciel'][$i] == 'Logiciel2') {
									 $logiciel = 'Logiciel 2';
								 }
								 if($_SESSION['panier']['type'][$i] == 'standardlogiciel1' || $_SESSION['panier']['type'][$i] == 'standardlogiciel2') {
									 $type_logiciel = 'Standard';
								 }
								 if($_SESSION['panier']['type'][$i] == 'prologiciel1' || $_SESSION['panier']['type'][$i] == 'prologiciel2') {
									 $type_logiciel = 'Professionnel';
								 }

								 if($_SESSION['panier']['abonnement'][$i] == "1") {
									 $abo = "1 mois";
								 }
								 else if($_SESSION['panier']['abonnement'][$i] == "3") {
									 $abo = "3 mois";
								 }
								 else if($_SESSION['panier']['abonnement'][$i] == "6") {
									 $abo = "6 mois";
								 }
								 else if($_SESSION['panier']['abonnement'][$i] == "12") {
									 $abo = "1 an";
								 }
								 else if($_SESSION['panier']['abonnement'][$i] == "0") {
									 $abo = "A vie";
								 }

								 $amountHT = $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];

								 $line = array( "NOM"    => $logiciel,
																"TYPE"  => $type_logiciel,
																"ABONNEMENT"     => $abo,
																"QUANTITE"      => $_SESSION['panier']['quantite'][$i],
																"P.U. H.T." => number_format($_SESSION['panier']['prix'][$i], 2, ',', ' '),
																"MONTANT H.T."          => number_format($amountHT, 2, ',', ' ') );
								 $size = $pdf->addLine( $y, $line );
								 $y   += $size + 2;
							 }


							 $pdf->addTVAs($_SESSION['numberHT'],$_SESSION['totalTVA']);
							 $pdf->addCadreEurosFrancs($_SESSION['numberHT'],$_SESSION['totalTVA']);

							 if (file_exists('C:/wamp/www/AtoutProtect/Facture_ATOUTSA.pdf')) {
								     unlink('C:/wamp/www/AtoutProtect/Facture_ATOUTSA.pdf');
										 sleep(1);
										 $pdf->Output("Facture_ATOUTSA.pdf", "F");
										 sleep(1);
										 $old = 'C:/wamp/www/AtoutProtect/Facture_ATOUTSA.pdf';
										 $new = 'C:/wamp/www/AtoutProtect/factures/'.$_SESSION['nom'].'/Facture_ATOUTSA_'.$_GET['token'].'.pdf';
										 copy($old, $new);
										 sleep(1);
										 unlink('C:/wamp/www/AtoutProtect/Facture_ATOUTSA.pdf');
								} else {
								    $pdf->Output("Facture_ATOUTSA.pdf", "F");
								}

								$mail = new PHPMailer;

								$mail->isSMTP();                                      // Set mailer to use SMTP
								$mail->Host = 'smtp.bouygtel.fr';  // Specify main and backup SMTP servers
								$mail->SMTPAuth = false;                               // Enable SMTP authentication
								$mail->Username = 'atoutlicencemanagement@gmail.com';                 // SMTP username
								$mail->Password = 'atoutprotect';                           // SMTP password
								$mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
								$mail->Port = 25;                                    // TCP port to connect to

								$mail->setFrom('atoutlicencemanagement@gmail.com', 'ATOUT S.A.');
								$mail->addAddress($to, $_SESSION['nom'].' '.$_SESSION['prenom']);     // Add a recipient

								$mail->addAttachment('Facture_ATOUTSA.pdf');         // Add attachments
								$mail->isHTML(true);                                  // Set email format to HTML

								$mail->Subject = $subject;
								$mail->Body    = $content;

								if(!$mail->send()) {
								    echo 'Message could not be sent.';
								    echo 'Mailer Error: ' . $mail->ErrorInfo;
								} else {
								    echo 'Message has been sent';
										sleep(1);
										// similar behavior as an HTTP redirect
										?><script>
											var url_recup = window.location.href;
											var parametres = url_recup.substring(url_recup.lastIndexOf('?')+1);
												window.location.replace("http://localhost/atoutprotect/basket_success.php?"+parametres);
										</script><?php
								}

						}
						else if(empty($_SESSION['panier'])) {

						} ?>

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
