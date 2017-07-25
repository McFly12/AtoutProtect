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
        $( ".add-to-cart" ).click(function() {
          // &amp;type_logiciel=prologiciel1
          var id = $(this).closest('div').find('#type_abo').val();
          var type_abo_choisi = $(this).closest('div').find("#type_abo option[value="+id+"]").text();

          var id2 = $(this).closest('div').find('#type_licence').val();
          var type_licence_choisi = $(this).closest('div').find("#type_licence option[value="+id2+"]").text();

          var a = $(this).closest('div').find('a');
          var href = a.attr('href');
              a.attr('href', href + '&type_abonnement='+type_abo_choisi);
          var href2 = a.attr('href');
              a.attr('href', href2 + '&type_logiciel='+type_licence_choisi);
        });
      });
    </script>
	
	<script>
		$(document).ready(function () {
			$( "#select_type" ).change(function() {
			  
			});
		});
	</script>

  </head>

  <body>

    <?php
      unset($_SESSION['panier']);
    ?>

    <!-- Static navbar -->
    <div class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php" id='grostitre' name='grostitre'><img src="assets/img/logo2.png" title="Atout Protect" style="font-size:10px;">&nbsp;&nbsp;ATOUT PROTECT</a><br/>
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

	<div id="myCarousel" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
		<ul class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
		</ul>

    <!-- Carousel -->
		<div class="carousel-inner">
      <div class="item active" style="height:auto;">
          <img src="assets/img/slide1.jpg" alt="First Slide" width="auto">
          <div class="carousel-caption">
  					<h2 style="color:white;">Gestion des licences vendues ou disponibles</h2>
					  <p>&nbsp;</p>
				</div>
      </div>
      <div class="item" style="height:auto;">
          <img src="assets/img/slide2.png" alt="Second Slide" width="auto">
          <div class="carousel-caption">
  					<h2 style="color:white;">Des licences disponibles pour tout vos logiciels du quotidien</h2>
					  <p>&nbsp;</p>
				</div>
      </div>
      <div class="item" style="height:autox;">
          <img src="assets/img/slide3.jpg" alt="Third Slide" width="auto">
          <div class="carousel-caption">
  					<h2 style="color:white;">Disponible 24/24j 7/7j</h2>
					  <p>&nbsp;</p>
				</div>
      </div>

  </div>
</div>

<div style="background-color:#f2f2f2;"><br /></div>
  <!-- +++++ Welcome Section +++++ -->
  <div id="ww">
      <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 centered">
          <img src="assets/img/ATOUTSA.PNG" title="ATOUT S.A.">
          <h1>ATOUT S.A. ,</h1>
          <p>Nous vous proposons 3 types de licences, décrites ci-dessous : </p>
        </div><!-- /col-lg-8 -->
      </div><!-- /row -->
      </div> <!-- /container -->
  </div><!-- /ww -->

<br />

<!-- Modal -->
<div class="modal fade" id="NoSession" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document" style="width:35%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size:28px;">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Connexion requise</h4>
      </div>
      <div class="modal-body">
        Afin de pouvoir ajouter un produit à votre panier, veuillez au préalable <b><a href="login.php" style="color:black;">vous connecter</a></b> .
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>


	<!-- +++++ Projects Section +++++ -->
  <section class="container">
      <?php $reqete = $maPdoFonction->Logiciels();
      			if($reqete->rowCount() > 0) { ?>
				<div class="container">
				<div class="row">
             <?php while($donnees_req = $reqete->fetch()) { ?>
			         <div class="col-md-4">
					  <div class="thumbnail">
						<img src="http://via.placeholder.com/350x200" alt="" class="img-responsive">
						<div class="caption">
						  <h4 class="pull-right"></h4>
						  <h4><?php echo $donnees_req['Nom']; ?></h4>
						  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						</div>
						<div class="btn-ground text-center">
						<?php $modal = "#product_view".$donnees_req['Nom'];?>
							<!-- <button type="button" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Ajouter au panier</button> -->
							<button type="button" class="btn btn-primary" data-target="#product_view<?php echo $donnees_req['Nom']?>" data-toggle="modal" ><i class="fa fa-search"></i>&nbsp;&nbsp;Plus d'informations</button>
						</div>
						<div class="space-ten"></div>
					  </div>
					</div>
            <?php } ?>
			</div><!-- /row -->
			</div><!-- /container -->
        <?php } ?>
		
	<?php $reqete = $maPdoFonction->Logiciels();
			if($reqete->rowCount() > 0) { ?>
			<?php while($donnees_req = $reqete->fetch()) { ?>
					<div class="modal fade product_view" id="product_view<?php echo $donnees_req['Nom']?>">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
									<h3 class="modal-title"><?php echo $donnees_req['Nom']; ?></h3>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-md-6 product_img">
											<img src="http://via.placeholder.com/400x400" class="img-responsive"><br />
										</div>
										<div class="col-md-6 product_content">
											<h4>ID Produit : <span><?php echo $donnees_req['id']; ?></span></h4>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</div>
												<hr width="100%">

											<div class="row" style="margin:1%">
												<div class="col-md-4 col-sm-6 col-xs-12">
													<?php $req_select1 = $maPdoFonction->TypeLicences();
															if($req_select1->rowCount() > 0) { ?>
																<select class="form-control" id="select_type" name="select_type">
																	<option disabled selected>TYPE</option>
																		<?php while($donnees_req_select1 = $req_select1->fetch()) { ?>
																				<option value="<?php echo $donnees_req_select1['id']; ?>"><?php echo $donnees_req_select1['Nom']; ?></option>
																		<?php } } ?>
																</select>
												</div>
												<!-- end col -->
												<div class="col-md-4 col-sm-6 col-xs-12">
													<?php $req_select2 = $maPdoFonction->Abonnements();
															if($req_select2->rowCount() > 0) { ?>
																<select class="form-control" id="select_abonnement" name="select_abonnement">
																	<option disabled selected>ABONNEMENT</option>
																		<?php while($donnees_req_select2 = $req_select2->fetch()) { ?>
																				<option value="<?php echo $donnees_req_select2['duree']; ?>"><?php echo $donnees_req_select2['nom']; ?></option>
																		<?php } } ?>
																</select>
												</div>
												<!-- end col -->
												<div class="col-md-4 col-sm-12">
														Quantité :&nbsp;&nbsp;<input type="number" value="1" min="1" max="100">
												</div>
												<!-- end col -->
											</div>
											<div class="btn-ground">
												<!-- <h5>Total</h5>
												<h3 class="cost" style="float:left;"> 75.00 <span style="color:black;font-size:18px;" class="glyphicon glyphicon-eur"></span></h3>
												-->
												<hr width="100%">
													<p style="margin-left:2%;font-size:16px;">
														Prix total
													</p>
													<p style="margin-left:2%;margin-top:-3%;float:left;font-size:25px;color:black;font-weight:bold;">
														960,00 €
													</p>
													<p style="margin-left:2%;margin-top:-3%;margin-right:3%;float:right;">
														<button 
														type="button" class="btn btn-primary green">
															<span id="spangreen" class="glyphicon glyphicon-shopping-cart"></span>
																Ajouter au panier
														</button>
													</p>
											</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php } } ?>
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
