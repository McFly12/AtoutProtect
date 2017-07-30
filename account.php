<?php session_start();
if(!isset($_SESSION['nom'])) {
  header('Location: login.php');
}

include 'class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="EDISOFT">
    <link rel="shortcut icon" href="assets/img/logo.png">

    <title>Atout Protect - Espace membre</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome core CSS -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">

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
      var php_emailsession = '<?php echo $_SESSION["email"]; ?>';
      $.ajax({
        type: "GET",
        data: {'email': php_emailsession},
        url: 'modules/InfosUser.php',
        dataType: 'json',
        success: function(json) {
          var len = json.length;
            if(len > 0) {
              $.each(json, function(value, key) {
                $("#nom").val(key.Nom);
                $("#prenom").val(key.Prenom);
                $("#tel").val(key.Tel);
                $("#email").val(php_emailsession);
                $("#adresse").val(key.Adresse);
                $("#codepostal").val(key.CodePostal);
                $("#ville").val(key.Ville);
              });
            }
          }
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
        $("#supmoncompte").on('click', function () {
          $.ajax({
            type: "POST",
            url: "modules/SupCompte.php"
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

    <?php
			if (isset($_GET['SaveOk'])) {
				echo '<br/>
					<div class="isa_success_" style="width:50%;">
						<i class="fa fa-check"></i>
							L\'enregistrement des modifications apportées à votre compte a réussi.
					</div>';
			}	?>
      <?php
        if (isset($_GET['ErrSave'])) {
          echo '<br/>
            <div class="isa_error_" style="width:50%;">
              <i class="fa fa-times-circle"></i>
                L\'enregistrement des modifications apportées à votre compte a échoué. Veuillez ré-essayer.<br />
                &nbsp;&nbsp;&nbsp;&nbsp;Si l\'erreur persiste, veuillez <a href="contact.php" target="_blank">contacter l\'administrateur</a>.
            </div>';
        }	?>

	<!-- +++++ Contact Section +++++ -->
	<div class="container pt">
		<div class="row mt">
			<div class="col-lg-6 col-lg-offset-3 centered">
				<h3>VOS INFORMATIONS :</h3>
				<hr>
			</div>
		</div>

		<div class="row mt">
      <div style="float:left;padding-left:10px;width:62%">
  			<div role="form" class="col-lg-8 col-lg-offset-2">
  				<form method="POST" action="modules/SaveInfosUser.php" id="login">
            <img src="assets/img/user.png" width="140" height="140" class="img-circle" style="margin-left:36%;">
  				  <div class="form-group"><br />
              Nom :
              <input type="text" class="form-control" name="nom" id="nom" autocomplete="off"/>
  				    <br>
  				  </div>
  				  <div class="form-group">
              Prénom :
              <input type="text" class="form-control" name="prenom" id="prenom" autocomplete="off"/>
  				    <br>
  				  </div>
            <div class="form-group">
              Téléphone :
              <input type="text" class="form-control" name="tel" id="tel" autocomplete="off" maxlength="10"/>
  				    <br>
  				  </div>
            <div class="form-group">
              Adresse email :
              <input type="email" class="form-control" name="email" id="email" disabled autocomplete="off"/>
  				    <br>
  				  </div>
            <div class="form-group">
              Adresse :
              <input type="text" class="form-control" name="adresse" id="adresse" autocomplete="off"/>
  				    <br>
  				  </div>
            <div class="form-group">
              Code Postal :
              <input type="text" class="form-control" name="codepostal" id="codepostal" autocomplete="off" maxlength="5"/>
  				    <br>
  				  </div>
            <div class="form-group">
              Ville :
              <input type="text" class="form-control" name="ville" id="ville" autocomplete="off"/>
  				    <br>
  				  </div>
            <div align="center"><br />
              <button type="submit" class="btn btn-success">
                <span style="font-size:15px;color:white;" class="glyphicon glyphicon-floppy-save"></span>
                &nbsp;&nbsp;ENREGISTRER
              </button>
            </div>
  				</form>
			  </div>
          <br /> <div class="vertical-row" style="height:735px;margin-top:20px;margin-left:5%;"></div>
        </div>

        <div style="float:right;padding-right:10px;width:38%">
          <div role="form" class="col-lg-8 col-lg-offset-2">
              <div width="20%;"><br /><br /><br /><br />
                <?php $req = $maPdoFonction->InformationsUtilisateur($_SESSION['email']);
                  			if($req->rowCount() >= 1) { ?>
                          <h4><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;Historique :</h4>
                          <?php while($donnees = $req->fetch()) { ?>
                            &nbsp;&nbsp;Créé le : <b><?php echo date('d-m-Y', strtotime(str_replace ('/', '-', $donnees['DateDeCreation']))); ?></b><br />
                            &nbsp;&nbsp;Dern. co. le : <b><?php echo date('d-m-Y', strtotime(str_replace ('/', '-', $donnees['DateDerniereConnexion']))); ?> à <?php echo $donnees['HeureDerniereConnexion']; ?></b><br />
                          <?php }
                        } ?>
                        <br /><br />
                <a href="modules/SupCompte.php">
                  <button id="supmoncompte" name="supmoncompte" type="submit" class="btnmodalCancel" style="width:130%;font-size:14px;" >
                    <i class="fa fa-trash-o" aria-hidden="true" style="font-size:14px;"></i>
                      &nbsp;&nbsp;SUPPRIMER MON COMPTE
                  </button>
                </a>
              </div>
          </div>
        </div>
		</div><!-- /row -->
	</div><!-- /container -->

	<!-- +++++ Footer Section +++++ -->
  <div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<h4><i class="fa fa-terminal" aria-hidden="true"></i>&nbsp;&nbsp;EDISOFT</h4>
					<p>
            Rue BETEILLE,<br/>
            05 65 01 02 03,<br />
            12 000 RODEZ (FRANCE)
					</p>
				</div><!-- /col-lg-4 -->

				<div class="col-lg-4">
					<h4><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;&nbsp;ATOUT S.A.</h4>
          <p>
            50 rue de Limayrac,<br/>
						05 61 36 08 08, <br/>
						31 000 TOULOUSE (FRANCE)
					</p>
				</div><!-- /col-lg-4 -->

				<div class="col-lg-4">
					<h4>Développé par EDISOFT.</h4>
				</div><!-- /col-lg-4 -->
        <div id="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2889.6394079193233!2d1.4685485158854545!3d43.593226679123376!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12aebcf7254f26bf%3A0x62ddf85fb62c1df4!2sInstitut+Limayrac!5e0!3m2!1sfr!2sfr!4v1501421918862" width="380" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
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
