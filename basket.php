<?php session_start();
	include_once("gestionpanier.php");

	$erreur = false;

	$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
	if($action !== null)
	{
	   if(!in_array($action,array('ajout', 'suppression', 'refresh')))
	   $erreur=true;

	   //récuperation des variables en POST ou GET
	   $logiciel = (isset($_POST['logiciel'])? $_POST['logiciel']:  (isset($_GET['logiciel'])? $_GET['logiciel']:null )) ;
	   $quantite = (isset($_POST['quantite'])? $_POST['quantite']:  (isset($_GET['quantite'])? $_GET['quantite']:null )) ;
	   $prix = (isset($_POST['prix'])? $_POST['prix']:  (isset($_GET['prix'])? $_GET['prix']:null )) ;

	   //Suppression des espaces verticaux
	   $logiciel = preg_replace('#\v#', '',$logiciel);

	   //On traite $q qui peut etre un entier simple ou un tableau d'entier
	   if (is_array($quantite)) {
	      $QteArticle = array();
	      $i=0;
	      foreach ($quantite as $contenu){
	         $QteArticle[$i++] = intval($contenu);
	      }
	   }
	   else
	   $quantite = intval($quantite);
	}

	if (!$erreur){
	   switch($action){
	      Case "ajout":
	         ajouterArticle($logiciel,$quantite,$prix);
	         break;

	      Case "suppression":
	         supprimerArticle($logiciel);
	         break;

	      Case "refresh" :
	         for ($i = 0 ; $i < count($QteArticle) ; $i++)
	         {
	            modifierQTeArticle($_SESSION['panier']['id_logiciel'][$i],round($QteArticle[$i]));
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
		<title>Votre panier</title>
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
            <div id="moncompte">
              <font color="#D8D6D6"><i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;Bienvenue <?php echo $_SESSION['nom']; ?>&nbsp;<?php echo $_SESSION['prenom']; ?></font>&nbsp;&nbsp;<img src="assets/img/download.png"></img>
								<ul style="display:none;">
									<li id="compte" style='color:white'>
										<a href="account.php" style='color:white' onmouseover="this.style.color='#CCCCCC'" onmouseout="this.style.background='';this.style.color='white';"><i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;Mon Compte</a>
									</li>
									<li id="commandes" style='color:white'>
										<a href="orders.php" style='color:white' onmouseover="this.style.color='#CCCCCC'" onmouseout="this.style.background='';this.style.color='white';"><i class="fa fa-files-o" aria-hidden="true"></i>&nbsp;Mes Commandes</a>
									</li>
									<li id="admin" style='color:white'>
                    <a href="admin.php" style='color:white' onmouseover="this.style.color='#CCCCCC'" onmouseout="this.style.background='';this.style.color='white';"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;Administration</a>
                  </li>
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
            <li><a href="basket.php" id="panier" name="panier" ><i class="fa fa-shopping-cart fa-lg" style="color:white;" ></i>&nbsp;&nbsp;Panier</a></li>
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

		<?php
		if (creationPanier())	{
			$nbArticles=count($_SESSION['panier']['id_logiciel']);
			if ($nbArticles > 0) { ?>
				<!-- Affichons maintenant le contenu du panier : -->
				<div class="col-lg-6 col-lg-offset-3 centered">
					<h3>VOTRE PANIER :</h3>
					<hr><br /><br />
				</div>

				<form method="post" action="basket.php">
				<table style="width:80%;margin-left:10%;margin-right:10%;border:1px solid black;" class="table table-bordered table-responsive table-striped">
					<thead style="border:1px solid black;background-color:#C5C5C5">
					<tr>
						<td style="color:black;font-weight:bold;font-size:17px;">Nom du logiciel</td>
						<td style="color:black;font-weight:bold;font-size:17px;">Quantité</td>
						<td style="color:black;font-weight:bold;font-size:17px;">Prix Unitaire</td>
						<td style="color:black;font-weight:bold;font-size:17px;">Action</td>
					</tr>
				</thead>
				<?php for ($i=0 ;$i < $nbArticles ; $i++)
				{
					echo "<tbody style=\"border:1px solid black;\"><tr>";
					echo "<td>".htmlspecialchars($_SESSION['panier']['id_logiciel'][$i])."</ td>";
					echo "<td><input autocomplete=\"off\" type=\"number\" size=\"1\" name=\"q[]\" value=\"".htmlspecialchars($_SESSION['panier']['qte'][$i])."\"/></td>";
					echo "<td><b>".htmlspecialchars($_SESSION['panier']['prix'][$i])." €</b></td>";
					echo "<td><a style='color:red;' href=\"".htmlspecialchars("basket.php?action=suppression&l=".rawurlencode($_SESSION['panier']['id_logiciel'][$i]))."\"><i class='fa fa-trash-o'></i>&nbsp;Supprimer</a></td>";
					echo "</tr></tbody>";
				}

				echo "<tr><td colspan=\"4\"><br />";
				echo "<input type=\"submit\" style=\"color:blue\" value=\"Rafraichir\"></input> ";
				echo "<input type=\"hidden\" name=\"action\" value=\"refresh\"/>";
				echo "<font style='font-size:22px;font-weight:bold;margin-left:300px;' >Total : ".number_format(MontantGlobal(), 2, ',', ' '); echo " €</font>";
				echo "<img style='margin-right:10px;float:right;' src='https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-rect-paypal-34px.png' alt='PayPal' style='float:right;'><br /><br />";
				echo "<img style='margin-right:20px;float:right;' src='assets/img/allopass.png' alt='AlloPass' style='float:right;'><br /><br />";
				echo "</td></tr>";
			}
			else
			{ ?>
				<br /><div class='isa_warning' style='width:50%;'>
					<i class="fa fa-warning"></i>
						Votre panier est vide.
			 </div><br />
			<?php }
		}
		?>
	</table>
	</form>

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
