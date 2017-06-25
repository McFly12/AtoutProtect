<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/logo.png">

    <title>Atout Protect - Accueil</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome core CSS -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

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
  </head>

  <body style="background-color:#f2f2f2;">

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


	<!-- +++++ Projects Section +++++ -->
  <section class="container">

    <script>
    function openCity(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    </script>

    <br /><br />

    <div class="tab">
      <button class="tablinks" onclick="openCity(event, 'Acheteurs')">Acheteurs</button>
        &nbsp;&nbsp;&nbsp;
      <button class="tablinks" onclick="openCity(event, 'LicencesVendues')">Licences vendues</button>
        &nbsp;&nbsp;&nbsp;
      <button class="tablinks" onclick="openCity(event, 'ExportationDeDonnees')">Exportation de données</button>
        &nbsp;&nbsp;&nbsp;
      <button class="tablinks" onclick="openCity(event, 'CodePromotion')">Code promotion</button>
    </div>

    <div id="Acheteurs" class="tabcontent">
      <h3>London</h3>
      <p>London is the capital city of England.</p>
    </div>

    <div id="LicencesVendues" class="tabcontent">
      <h3>Paris</h3>
      <p>Paris is the capital of France.</p>
    </div>

    <div id="ExportationDeDonnees" class="tabcontent">
      <h3>Paris</h3>
      <p>Paris is the capital of France.</p>
    </div>

    <div id="CodePromotion" class="tabcontent">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 style="padding:0;">Gestion des codes promotions</h3>
          </div>
        </div>

        <div class="panel-body row btn-toolbar">
          <div style="padding:0;" class='btn-group'>
            <button class="btn btn-success" style="display:inline-block;width:300px;margin-right: 5px;padding:0;height:30px;">Nouveau Code Promotion</button>
            <?php $req = $maPdoFonction->RecupCodesPromo();
            			if($req->rowCount() >= 1) {
                    ?><button class="btn btn-danger" style="display:inline-block;width:300px;margin-right: 5px;padding:0;height:30px;">Supprimer selection</button><?php
                  } ?>
          </div>
        </div>

        <div class="list-group" style="margin:10px;">
          <?php $req = $maPdoFonction->RecupCodesPromo();
              if($req->rowCount() >= 1) {
                ?> <ul class="list-group"> <?php
                while($donnees = $req->fetch()) {
                  if($donnees['statut'] == "Activé") { ?>
                    <li class="list-group-item" style="background-color:#DFF0D8;">
                      <b><?php echo $donnees['code']; ?></b> -- <b><?php echo $donnees['pourcentage_reduc']; ?> %</b> -- utilisé par <b><?php echo $donnees['beneficiaire']; ?></b>
                    </li>
                  <?php }
                  else { ?>
                      <li class="list-group-item">
                        <input type="checkbox" value="">
                          &nbsp;&nbsp;&nbsp;
                        <b><?php echo $donnees['code']; ?></b> -- <b><?php echo $donnees['pourcentage_reduc']; ?> %</b> -- <b>Non utilisé</b>
                      </li>
                  <?php }
                } ?> </ul>
        <?php  }
        else { ?>
          <div class="alert alert-info">
            <strong>Aucuns code promotions utilisés ou a été généré.</strong>
          </div>
        <?php } ?>
        </div>
    </div>
    <br />
  </section>

  <br />

	<!-- +++++ Footer Section +++++ -->
	<div id="footer">
		<div class="container">
			<div class="row">
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
