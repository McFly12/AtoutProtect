<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/img/logo.png">

    <title>Atout Protect - Contact</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
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

	<!-- +++++ Contact Section +++++ -->

	<div class="container pt">
		<div class="row mt">
			<div class="col-lg-6 col-lg-offset-3 centered">
				<h3>NOUS CONTACTER</h3>
				<hr>
				<p>Veuillez compléter ce formulaire :</p>
			</div>
		</div>
		<div class="row mt">
			<div class="col-lg-8 col-lg-offset-2">
				<form role="form">
				  <div class="form-group">
				    <input type="text" class="form-control" id="NameInputEmail1" name="NameInputEmail1" placeholder="Votre nom">
				    <br>
				  </div>
				  <div class="form-group">
				    <input type="email" class="form-control" id="exampleInputEmail1" name="exampleInputEmail1" placeholder="Adresse email">
				    <br>
				  </div>
				  <div class="form-group">
				    <input type="text" class="form-control" id="subjectEmail1" name="subjectEmail1" placeholder="Objet">
				    <br>
				  </div>
				  <textarea id="textEmail1" name="textEmail1" style="resize: none;" class="form-control" rows="6" placeholder="Votre demande"></textarea>
				    <br>
				</form>
        <button class="btn btn-success" onclick="Toast()"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>&nbsp;&nbsp;ENVOYER</button>
			</div>
		</div><!-- /row -->
	</div><!-- /container -->

<div id="snackbar">Merci de votre demande. Nous vous contacterons dans les meilleurs delais.</div>

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
            52 Rue de Limayrac,<br/>
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

    <script>
      function Toast() {
        if($("#NameInputEmail1").val().length != 0 && $("#exampleInputEmail1").val().length != 0 && $("#subjectEmail1").val().length != 0 && $("#textEmail1").val().length != 0) {
          var x = document.getElementById("snackbar")
          x.className = "show";
          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

          $("#NameInputEmail1").val("");
          $("#exampleInputEmail1").val("");
          $("#subjectEmail1").val("");
          $("#textEmail1").val("");
        }
        else {

        }
      }
    </script>

  </body>
</html>
