<?php if(!isset($_SESSION)) session_start();
  if(isset($_SESSION['nom'])) {
  header('Location: account.php');
} ?>

<!DOCTYPE html>
<html lang="en">
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

  <script language="Javascript">
    $(document).ready(function () {
      $('#mdp').keypress(function(e) {
        if($('#mdp').val().length >= 0) {
          var s = String.fromCharCode( e.which );
           if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
             document.getElementById('CapsLock').style.visibility = 'visible';
             document.getElementById('CapsLock2').style.visibility = 'hidden';
           }
           else {
             document.getElementById('CapsLock').style.visibility = 'hidden';
             document.getElementById('CapsLock2').style.visibility = 'hidden';
           }
        }
        else {
          document.getElementById('CapsLock').style.visibility = 'hidden';
          document.getElementById('CapsLock2').style.visibility = 'hidden';
        }
      });
    });
  </script>
  <script language="Javascript">
    $(document).ready(function () {
      $('#confirmmdp').keypress(function(e) {
        if($('#confirmmdp').val().length >= 0) {
          var s = String.fromCharCode( e.which );
           if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
             document.getElementById('CapsLock2').style.visibility = 'visible';
             document.getElementById('CapsLock').style.visibility = 'hidden';
           }
           else {
             document.getElementById('CapsLock2').style.visibility = 'hidden';
             document.getElementById('CapsLock').style.visibility = 'hidden';
           }
        }
        else {
          document.getElementById('CapsLock2').style.visibility = 'hidden';
          document.getElementById('CapsLock').style.visibility = 'hidden';
        }
      });
    });
  </script>

  <script>
    function isNumberKey(evt) {
    	var charCode = (evt.which) ? evt.which : evt.keyCode;
    	// Added to allow decimal, period, or delete
    	if (charCode == 110 || charCode == 190 || charCode == 46)
    		return true;

    	if (charCode > 31 && (charCode < 48 || charCode > 57))
    		return false;

    	return true;
    }
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
     $(document).ready(function() {
       $('#login').attr('disabled', 'disabled');
        $('.input-group > input').keyup(function() {
          var empty = false;
          $('.input-group > input').each(function() {
              if ($(this).val().length == 0) {
                  empty = true;
              }
          });
          if (empty == true) {
              $('#creer_compte').attr('disabled', 'disabled');
          } else {
              $('#creer_compte').removeAttr('disabled');
          }
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

	<!-- +++++ Contact Section +++++ -->
	<div class="container pt">
		<div class="row mt">
			<div class="col-lg-6 col-lg-offset-3 centered">
				<h3>VOTRE DEMANDE D'INSCRIPTION :</h3>
				<hr>
        <p>Veuillez compléter ce formulaire :</p>
        <?php
  				if (isset($_GET['ErrNewAcc'])){
  					echo '<div class="isa_error_">L\'enregistrement de votre compte a échoué. Veuillez re-essayer. Si l\'erreur persiste, contactez votre administrateur.</div><br />';
  				}
  			?>
        <?php
  				if (isset($_GET['MissChNewAcc'])){
  					echo '<div class="isa_error_">Veuillez compléter l\'ensemble des champs.</div><br />';
  				}
  			?>
			</div>
		</div>

		<div class="row mt">
			<div role="form" class="col-lg-8 col-lg-offset-2">
				<form method="POST" action="modules/SaveNewAccount.php" id="login">
          <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-user" style="color:black;font-size:12px;"></span></span>
            <input type="text" class="form-control" name="nom" placeholder="Nom" aria-describedby="sizing-addon2">
          </div><br />
          <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-user" style="color:black;font-size:12px;"></span></span>
            <input type="text" class="form-control" name="prenom" placeholder="Prénom" aria-describedby="sizing-addon2">
          </div><br />
          <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-earphone" style="color:black;font-size:12px;"></span></span>
            <input type="text" class="form-control" name="tel" placeholder="Télephone" aria-describedby="sizing-addon2">
          </div><br />
          <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-envelope" style="color:black;font-size:12px;"></span></span>
            <input type="email" class="form-control" name="email" placeholder="Email" aria-describedby="sizing-addon2">
          </div><br />
          <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-lock" style="color:black;font-size:12px;"></span></span>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" aria-describedby="sizing-addon2"><div id="CapsLock" style="visibility:hidden;float:right;"><font color='#ffa500'>Caps Lock is on.</font></div>
          </div><br />
          <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-lock" style="color:black;font-size:12px;"></span></span>
            <input type="password" class="form-control" id="confirmmdp" name="confirmmdp" placeholder="Confirmation Mot de passe" aria-describedby="sizing-addon2"><div id="CapsLock" style="visibility:hidden;float:right;"><font color='#ffa500'>Caps Lock is on.</font></div>
          </div><br />
          <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-home" style="color:black;font-size:12px;"></span></span>
            <input type="text" class="form-control" name="adresse" placeholder="Adresse" aria-describedby="sizing-addon2">
          </div><br />
          <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-home" style="color:black;font-size:12px;"></span></span>
            <input type="text" class="form-control" name="codepostal" autocomplete="off" maxlength="5" onkeypress="return isNumberKey(event)" placeholder="Code Postal" aria-describedby="sizing-addon2">
          </div><br />
          <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-home" style="color:black;font-size:12px;"></span></span>
            <input type="text" class="form-control" name="ville" placeholder="Ville" autocomplete="off" aria-describedby="sizing-addon2">
          </div><br />
          <div align="center"><br />
            <button type="submit" id="creer_compte" name="creer_compte" class="btn btn-success">ENREGISTRER</button>
          </div>
				</form>
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
            52 Rue de Limayrac,<br/>
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
