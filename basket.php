<?php
	include_once("gestionpanier.php");
  require("class/PayPal.php");

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

      Default:
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
					 ini_set('error_reporting', E_ALL); ?>

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

			// INIT : A L'OUVERTURE DE LA PAGE
			if(window.location.search == '?PayPalOk') {

				// IMPOSSIBLE DE RE-PAYER
				$('#C').attr('disabled', true);
				$('#lienTabC').attr('href', '');

				// SUPPRIMER LE ACTIF SUR LES li
				$('#lienTabA').removeClass( "nav active" );
				$('#lienTabA').addClass( "nav" );

				// OUVERTURE DU DIV DE LA VALIDATION DU PAIEMENT
				$('#D').addClass( "active in" );
				$('.nav-tabs a[href="#D"]').tab('show');
				$('#lienTabD').addClass( "active" );

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

	</head>

	<body>

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

<?php if(isset($_SESSION['nom'])) { ?>
	<div class="alert alert-warning" style="margin-left:2%;margin-right:2%;text-align:center;">
  	<strong> Attention ! Si vous vous déconnectez de votre compte, votre panier sera perdu. </strong>
	</div><br />
<?php } ?>

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
				 	else {?>
						<li class="nav" style="width:25%" onmouseover="style='cursor:pointer;width:25%'" onmouseover="style='cursor:default;width:25%'">
							<a href="#C" data-toggle="tab" id="lienTabC">
								<i class="fa fa-credit-card" aria-hidden="true" style="font-size:inherit;color:#555555"></i>
									&nbsp;&nbsp;<font color="#555555" style="font-weight:bold;font-size:16px;">Paiement</font>
							</a>
						</li>
						<?php $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							if(parse_url($url, PHP_URL_QUERY) == "PayPalOk") { ?>
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
							</div>

							<div class="table-responsive">
								<table class="table table-striped table-bordered" style="margin-left:0 auto;margin-left: 5px;">
									<thead>
										<tr style="font-size:18px;">
											<th style="width:20%;">
												Nom
											</th>
											<th style="width:20%">
												Type
											</th>
											<th style="width:20%">
												Abonnement
											</th>
											<th style="width:20%">
												Quantité
											</th>
											<th style="width:20%">
												Prix Unitaire (EUR)
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
														echo "<tr>";
															if($_SESSION['panier']['logiciel'][$i] == "Logiciel1") {
																echo "<td style=\"font-weight:bold;text-align:center\">Logiciel 1</td>";
															}
															else if($_SESSION['panier']['logiciel'][$i] == "Logiciel2") {
																echo "<td style=\"font-weight:bold;text-align:center\">Logiciel 2</td>";
															}
															if($_SESSION['panier']['type'][$i] == "debutantlogiciel1" || $_SESSION['panier']['type'][$i] == "debutantlogiciel2") {
																echo "<td>Débutant</td>";
															}
															else if($_SESSION['panier']['type'][$i] == "standardlogiciel1" || $_SESSION['panier']['type'][$i] == "standardlogiciel2") {
																echo "<td>Standard</td>";
															}
															else if($_SESSION['panier']['type'][$i] == "prologiciel1" || $_SESSION['panier']['type'][$i] == "prologiciel2") {
																echo "<td>Professionnel</td>";
															}

															if($_SESSION['panier']['abonnement'][$i] == "1") {
																echo "<td>1 mois</td>";
															}
															else if($_SESSION['panier']['abonnement'][$i] == "3") {
																echo "<td>3 mois</td>";
															}
															else if($_SESSION['panier']['abonnement'][$i] == "6") {
																echo "<td>6 mois</td>";
															}
															else if($_SESSION['panier']['abonnement'][$i] == "12") {
																echo "<td>1 an</td>";
															}
															else if($_SESSION['panier']['abonnement'][$i] == "0") {
																echo "<td>A vie</td>";
															}

															echo "<td>".htmlspecialchars($_SESSION['panier']['quantite'][$i])."</td>";

															echo "<td>".htmlspecialchars(number_format($_SESSION['panier']['prix'][$i], 2, ',', ' '))." &euro;</td>";
														echo "</tr>";
													}
													echo "<tr style=\"height: 40px !important;background-color: #FFFFFF;\"><td colspan=\"5\"></td></tr>";

																$numberHT = montant_panier();

																echo "<tr><td colspan=\"3\"></td>";
	 															echo "<td><b><font style=\"font-size:20px;\">Total HT</font></b></td>";
																echo "<td style=\"font-size:20px;\"><b><font style=\"font-size:20px;\" >".number_format((float)$numberHT, 2, ',', ' ')." &euro;</font></b></td>";

																$remise = 0.00;
																if($remise != 0) {
																	$numberHT = $numberHT - $remise;
																}
																echo "<tr><td colspan=\"3\"></td>";
																echo "<td><b><font style=\"font-size:20px;\">Remise</font></b></td>"; ?>
																			<td style="font-size:20px;"><b><font><?php echo number_format($remise, 2, ',', ' '); ?> &euro;</font></b></td>

																<?php echo "<tr><td colspan=\"3\"></td>";
																echo "<td><b><font style=\"font-size:20px;\">TVA</font></b></td>";
																echo "<td style=\"font-size:20px;\">20,00 %</td></tr>";

																$numberAvecTVA = "";
																$numberAvecTVA = $numberHT * (1 + (20 / 100));
                                $_SESSION['totalTVA'] = $numberAvecTVA;

																if($nbArticles == 1) {
																	echo "<tr><td colspan=\"3\"></td>";
		 															echo "<td><b><font style=\"font-size:20px;\">Total TTC ( ".$nbArticles." article )</font></b></td>";
																	echo "<td style=\"font-size:20px;\"><b><font style=\"font-size:20px;\" color=\"#e82323!important\">".number_format((float)$numberAvecTVA, 2, ',', ' ')." &euro;</font></b></td>";
																}
																else if($nbArticles > 1) {
																	echo "<tr><td colspan=\"3\"></td>";
		 															echo "<td><b><font style=\"font-size:20px;\">Total TTC ( ".$nbArticles." articles )</font></b></td>";
																	echo "<td style=\"font-size:20px;\"><b><font style=\"font-size:20px;\" color=\"#e82323!important\">".number_format((float)$numberAvecTVA, 2, ',', ' ')." &euro;</font></b></td>";
																}


													echo "</td></tr>";

													echo "</td></tr>";
												}
											?>
									</tbody>
								</table>

								<br />

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
							</div>
						<?php }
						echo "</ul>"; ?>
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
					<?php

          $paypal = new PayPal();

					    $params = array(
					      'RETURNURL' => 'http://localhost/atoutprotect/process.php',
					      'CANCELURL' => 'http://localhost/atoutprotect/basket.php?ErrPayPal',

					      'PAYMENTREQUEST_0_AMT' => $numberAvecTVA,
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
                }

							?>

              <br />
              <h3 align="center" style="font-size:20px;">Veuillez choisir votre mode de paiement :</h3><hr>
							<br /><br />
										<!-- <div class="container">
											<div class="row" > -->

												<div class="columns" style="margin-left:10%;">
													<ul class="price">
													<li class="header"><img src="assets/img/PayPal.png"></img>&nbsp;PayPal</li>
													<div style=""></div>
													<li class="grey" style="font-size:14px">PayPal est un service de paiement en ligne qui permet de payer des achats, de recevoir des paiements, ou d’envoyer et de recevoir de l’argent.</li>
													<li class="grey" style="background-color:#FFF"><a href="<?= $paypal ?>" class="button">Accéder</a></li>
													</ul>
												</div>

												<div class="columns" style="margin-left:10%;">
													<ul class="price">
													<li class="header"><img src="assets/img/MasterCard.png"></img>&nbsp;HiPay (ex: AlloPass)</li>
													<li class="grey" style="font-size:14px">AlloPass s’adresse aux marchands et aux internautes pour le micropaiement de biens digitaux (inscriptions ou options payantes sur les sites internet, achat d’articles de presse, ...).</li>
													<li class="grey" style="background-color:#FFF"><a href="#C" class="button">Accéder</a></li>
													</ul>
												</div>

											<!-- </div>
										</div> -->
				</div>

				<div class="tab-pane fade" id="D" name="D"><br />

					<?php
						if(!empty($_SESSION['id_transaction'])) { ?>

							<br/><div class="alert alert-success" style="margin-left:2%;margin-right:2%;text-align:center;">
								<span><i class="fa fa-check" aria-hidden="true" style="float:left;font-size:50px;margin-top:20px;"></i></span>
								<h3><span style="color:#aab2bc;"></span>Votre paiement PayPal a été validé.</h3>
								<p>Votre numéro de transaction est : <b><?php echo $_SESSION['id_transaction']; ?></b>. Le montant de celle-ci est de <b><?php echo $_SESSION['montant_transaction']; ?> €.</b></p>
								<br /><p>Les clefs de licences commandées vous seront envoyés à l'adresse email suivante : <b><?php echo $_SESSION['email']; ?></b></p>
							</div>

							<?php
							$to = "atoutlicencemanagement@gmail.com";
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

								$content = '';

								if($nbArticles == 1) {
									$clef_simple = generation_clefs();

										for ($i=0 ;$i < $nbArticles ; $i++)
										{
											$clef = $clef_simple;
											$nom = $_SESSION['nom'];

											if($_SESSION['panier']['logiciel'][$i] == 'Logiciel1') {
												$logiciel = '1';
											}
											else if($_SESSION['panier']['logiciel'][$i] == 'Logiciel2') {
												$logiciel = '2';
											}

											if($_SESSION['panier']['type'][$i] == 'standardlogiciel1' || $_SESSION['panier']['type'][$i] == 'standardlogiciel2') {
												$type_logiciel = 'standard';
											}
											if($_SESSION['panier']['type'][$i] == 'prologiciel1' || $_SESSION['panier']['type'][$i] == 'prologiciel2') {
												$type_logiciel = 'pro';
											}

											$type_logiciel = $_SESSION['panier']['type'][$i];
											$abo_id = $_SESSION['panier']['abonnement'][$i];
										}

										// PARAMETRES : $clef,$nom,$logiciel,$abo_id
										$req = $maPdoFonction->EnregistrerLicenceBase($clef,$nom,$logiciel,$type_logiciel,$abo_id);

										$content = "Licence 1 : ".$clef_simple;
										?>

										<script>if(window.location.search == '?PayPalOk') {
															var destinataire = '<?php echo $to; ?>';
															window.location = "mailto:" + destinataire + "?subject=<?php echo $subject; ?>&body=<?php echo $content;?>";
														}
										</script>
										<?php $_SESSION['id_transaction']=''; ?>
					<?php	}
								else if($nbArticles > 1) {
									for ($i=0 ;$i < $nbArticles ; $i++)
									{

									}

									?><p style="margin-left:38px;">Pour télécharger votre facture au format PDF, veuillez cliquer sur le lien suivant : </p><?php
						}
						else {
							?><script>alert();</script><?php
						}

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
  					<h4>By EDISOFT.</h4>
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
