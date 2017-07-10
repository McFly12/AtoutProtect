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

    <script>
      function DeleteLogiciel(id) {
        var button = document.getElementById(id);

        if( $('#Catalogue :checkbox:checked').length > 0 ) {
          $('#Catalogue :checkbox:checked').each(function () {
            var nomlogiciel = $(this).closest('.thumbnail').find('h3').text();

              $.ajax({
                type: "GET",
                url: "modules/DeleteLogiciels.php",
                data: {'nomlogiciel': nomlogiciel},
                success: function() {
                 // window.location.href = "admin.php?id=CodePromotion";
                }
              });
          });

            window.location.href = "admin.php?id=Catalogue";
        }
      }
    </script>

    <script type="text/javascript">
      function openModalNouvCodePromo(){
          $('#discountBuild').modal();
          $('#discountBuild').find('#codepromo').val('');
      }
    </script>

    <script type="text/javascript">
      function openModalNouvLogiciel(){
          $('#nouvlogiciel').modal();
          $('#nouvlogiciel').find('#nomlogiciel').val('');
      }
    </script>

    <script type="text/javascript">
      function GenererCodePromo(id){
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        for (var i = 0; i < 10; i++)
          text += possible.charAt(Math.floor(Math.random() * possible.length));

          var button = document.getElementById(id);
          $(button).closest('div').find('#codepromo').val(text);
      }
    </script>

    <script type="text/javascript">
      function savecpbdd(id){
        var button = document.getElementById(id);

        if( document.getElementById("num_pourcentage_promo").value != "a" ) {
          if( document.getElementById("codepromo").value != 0 ) {
            var pourcent = document.getElementById("num_pourcentage_promo").value;
            var codepromo = document.getElementById("codepromo").value;

            $.ajax({
              type: "GET",
              url: "modules/SaveCodePromos.php",
              data: {'pourcentage': pourcent, 'codepromo': codepromo},
              success: function() {
               window.location.href = "admin.php?id=CodePromotion";
              }
          });
          }
          else {
            // Get the snackbar DIV
            var x = document.getElementById("snackbar")

            // Add the "show" class to DIV
            x.className = "show";

            // After 3 seconds, remove the show class from DIV
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
          }
        }
        else {
          // Get the snackbar DIV
          var x = document.getElementById("snackbar")

          // Add the "show" class to DIV
          x.className = "show";

          // After 3 seconds, remove the show class from DIV
          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
      }
    </script>

    <script type="text/javascript">
      function savelogicielbdd(id){
        var button = document.getElementById(id);

        if( document.getElementById("nomlogiciel").value != "" ) {
            var nom = document.getElementById("nomlogiciel").value;

            $.ajax({
              type: "GET",
              url: "modules/SaveLogiciel.php",
              data: {'nom': nom},
              success: function() {
               window.location.href = "admin.php?id=Catalogue";
              }
          });
        }
        else {
          // Get the snackbar DIV
          var x = document.getElementById("snackbar")

          // Add the "show" class to DIV
          x.className = "show";

          // After 3 seconds, remove the show class from DIV
          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
      }
    </script>

    <script>
      $(document).ready(function () {
        // INIT : A L'OUVERTURE DE LA PAGE
        if(window.location.search == '') {
          var element = document.getElementById('Acheteurs');
    			element.style.display = "block";

    			var tab_parents = document.getElementsByClassName("tablinks");
    			tab_parents[0].className += " active";
        }
        if(window.location.search == '?id=CodePromotion') {
          var element = document.getElementById('CodePromotion');
    			element.style.display = "block";

    			var tab_parents = document.getElementsByClassName("tablinks");
    			tab_parents[3].className += " active";
        }
        if(window.location.search == '?id=Catalogue') {
          var element = document.getElementById('Catalogue');
    			element.style.display = "block";

    			var tab_parents = document.getElementsByClassName("tablinks");
    			tab_parents[4].className += " active";
        }
      });
    </script>

  </head>

  <body style="background-color:#f2f2f2;">

    <div id="snackbar">Veuillez compléter l'ensemble des champs.</div>

    <!--- Discount Builder --->
    <div class="modal fade" id="discountBuild">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Générer un nouveau code promotion</h4>
          </div>
          <div class="modal-body">
            <div class="btn-group btn-group-justified" role="group" id="myTabs">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-default" id="buton_cpromo" style="height:34px;width:88px;border-radius:5px;" onclick="GenererCodePromo(this.id);">Générer</button>
                <input type="text" class="form-control" id="codepromo" placeholder="Code" style="margin-left:100px;width:250px;height:34px;" readonly required/>

                <br /><br />

                  <div class="input-group">
                    <span class="input-group-addon" ><i class="fa fa-percent" style="font-size: 1.2em;color: black;"></i></span>
                    <input id="num_pourcentage_promo" type="number" class="form-control" min="1" max="99" name="num_pourcentage_promo" placeholder="Pourcentage de réduction" required />
                  </div>
              </div>
            </div>
            <br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="savecpbdd(this.id);" style="width:100px;height:35px;">Enregistrer</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" style="width:100px;height:35px;">Annuler</button>
          </div>
        </div>
      </div>
    </div>

    <!--- Discount Builder --->
    <div class="modal fade" id="nouvlogiciel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nouveau logiciel</h4>
          </div>
          <div class="modal-body">
            <div class="btn-group btn-group-justified" role="group" id="myTabs">
              <div class="btn-group" role="group">
                <br /><br />
                    <input id="nomlogiciel" type="text" class="form-control" name="nomlogiciel" placeholder="Nom du logiciel" required />
              </div>
            </div>
            <br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="savelogicielbdd(this.id);" style="width:100px;height:35px;">Enregistrer</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" style="width:100px;height:35px;">Annuler</button>
          </div>
        </div>
      </div>
    </div>


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
        &nbsp;&nbsp;&nbsp;
      <button class="tablinks" onclick="openCity(event, 'Catalogue')">Administration du catalogue</button>
    </div>

    <div id="Acheteurs" class="tabcontent">
      <h3>London</h3>
      <p>London is the capital city of England.</p>
    </div>

    <div id="LicencesVendues" class="tabcontent">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 style="padding:0;">Aperçu des licences vendues</h3>
        </div>
      </div>

      <div class="panel-body row btn-toolbar">
        <div style="padding:0;" class='btn-group'>
          <?php $req = $maPdoFonction->RecupLicences();
                if($req->rowCount() >= 1) {
                  while($donnees = $req->fetch()) {
                    if($donnees['date_activation'] != null) { ?>
                      <li class="list-group-item" style="background-color:#DFF0D8;">
                        &nbsp;&nbsp;&nbsp;
                        <b><?php echo $donnees['clef']; ?></b> -- Activé le <b><?php echo date("d/m/Y", strtotime($donnees['date_activation'])); ?></b> -- valable jusqu'au <b><?php echo date("d/m/Y", strtotime($donnees['date_expiration'])); ?></b> -- acheté le <b><?php echo date("d/m/Y", strtotime($donnees['date_creation'])); ?></b>
                      </li>
                    <?php }
                    else { ?>
                        <li class="list-group-item">
                            &nbsp;&nbsp;&nbsp;
                            <b><?php echo $donnees['clef']; ?></b> -- Acheté par <b><?php echo $donnees['proprietaire']; ?> -- </b>Non utilisé</b>
                        </li>
                    <?php }
                  }
              } ?>
        </div>
      </div>

    </div>

    <div id="ExportationDeDonnees" class="tabcontent">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 style="padding:0;">Exportation de .CSV</h3>
        </div>
      </div>
    </div>

    <div id="CodePromotion" class="tabcontent">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 style="padding:0;">Gestion des codes promotions</h3>
          </div>
        </div>

        <div class="panel-body row btn-toolbar">
          <div style="padding:0;" class='btn-group'>
            <button onclick="openModalNouvCodePromo()" class="btn btn-success" style="display:inline-block;width:300px;margin-right: 5px;padding:0;height:30px;">Nouveau Code Promotion</button>
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

    <div id="Catalogue" class="tabcontent" style="height:640px;">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 style="padding:0;">Logiciels compatibles avec les licences vendues</h3>
        </div>
      </div>

      <div class="panel-body row btn-toolbar">
        <div style="padding:0;" class='btn-group'>
          <button onclick="openModalNouvLogiciel()" class="btn btn-success" style="display:inline-block;width:300px;margin-right: 5px;padding:0;height:30px;">Nouveau logiciel</button>
          <?php $req = $maPdoFonction->Logiciels();
                if($req->rowCount() >= 1) {
                  ?><button onclick="DeleteLogiciel(this.id);" class="btn btn-danger" style="display:inline-block;width:300px;margin-right: 5px;padding:0;height:30px;">Supprimer</button><?php
                } ?>
        </div>
      </div>

      <?php $req = $maPdoFonction->Logiciels();
            if($req->rowCount() >= 1) { $i = ''; $nb = 0;
              $items = ['msoffice', 'oracle', 'phpstorm', 'ps', 'vs'];
              while ($data = $req->fetch()) {
                if($nb == 0) { ?>
                <div class="row text-center">
                    <div class="col-md-3 col-sm-6 hero-feature">
                        <div class="thumbnail">
                          <input type="checkbox" class="checkbox" id="check0" />
                            <img src="assets/img/logiciels/<?php
                              echo $i = "oracle"; ?>.jpg" alt="">
                            <div class="caption">
                                <h3><?php echo $data['Nom']; ?></h3>
                                <?php if($i == "vs") { ?>
                                    <p>Ensemble complet d'outils de développement permettant de générer des applications web ASP.NET, des services web XML, des applications bureautiques et des applications mobiles.</p>
                                <?php }
                                else if($i == "ps") { ?>
                                    <p>Logiciel de retouche, de traitement et de dessin assisté par ordinateur.</p>
                                <?php }
                                else if($i == "msoffice") { ?>
                                    <p>Suite bureautique</p>
                                <?php }
                                else if($i == "oracle") { ?>
                                    <p>Système de gestion de base de données</p>
                                <?php }
                                else if($i == "phpstorm") { ?>
                                    <p>IDE</p>
                                <?php }
                                else { ?>
                                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                 </div>
              <?php }
              else if($nb == 1) { ?>
                <div class="row text-center">
                    <div class="col-md-3 col-sm-6 hero-feature">
                        <div class="thumbnail">
                          <input type="checkbox" class="checkbox" id="check1" />
                            <img src="assets/img/logiciels/<?php
                              echo $i = "msoffice"; ?>.jpg" alt="">
                            <div class="caption">
                                <h3><?php echo $data['Nom']; ?></h3>
                                <?php if($i == "vs") { ?>
                                    <p>Ensemble complet d'outils de développement permettant de générer des applications web ASP.NET, des services web XML, des applications bureautiques et des applications mobiles.</p>
                                <?php }
                                else if($i == "ps") { ?>
                                    <p>Logiciel de retouche, de traitement et de dessin assisté par ordinateur.</p>
                                <?php }
                                else if($i == "msoffice") { ?>
                                    <p>Suite bureautique</p>
                                <?php }
                                else if($i == "oracle") { ?>
                                    <p>Système de gestion de base de données</p>
                                <?php }
                                else if($i == "phpstorm") { ?>
                                    <p>IDE</p>
                                <?php }
                                else { ?>
                                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                 </div>
              <?php }
              else if($nb == 2) { ?>
                <div class="row text-center">
                    <div class="col-md-3 col-sm-6 hero-feature">
                        <div class="thumbnail">
                          <input type="checkbox" class="checkbox" id="check2" />
                            <img src="assets/img/logiciels/<?php
                              echo $i = "phpstorm"; ?>.jpg" alt="">
                            <div class="caption">
                                <h3><?php echo $data['Nom']; ?></h3>
                                <?php if($i == "vs") { ?>
                                    <p>Ensemble complet d'outils de développement permettant de générer des applications web ASP.NET, des services web XML, des applications bureautiques et des applications mobiles.</p>
                                <?php }
                                else if($i == "ps") { ?>
                                    <p>Logiciel de retouche, de traitement et de dessin assisté par ordinateur.</p>
                                <?php }
                                else if($i == "msoffice") { ?>
                                    <p>Suite bureautique</p>
                                <?php }
                                else if($i == "oracle") { ?>
                                    <p>Système de gestion de base de données</p>
                                <?php }
                                else if($i == "phpstorm") { ?>
                                    <p>IDE</p>
                                <?php }
                                else { ?>
                                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                 </div>
              <?php } $nb++; }
            } ?>
    </div>
    <br />
  </section>

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
