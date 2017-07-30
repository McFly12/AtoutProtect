<?php session_start();
if(!isset($_SESSION['nom']) || $_SESSION['droit'] != 1) {
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/logo.png">

    <title>Atout Protect - Adminsitration</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome core CSS -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script src="assets/js/jquery.toast.js"></script>
    <link href="assets/css/toast.css" rel="stylesheet">

    <script src="assets/js/clipboard/dist/clipboard.js"></script>

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
      function openModalNouvLogiciel(){
          $('#nouvlogiciel').modal();
          $('#nouvlogiciel').find('#nomlogiciel').val('');
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

    <script src="assets/js/jquery.simplePagination.js"></script>
    <script>
    $(document).ready(function() {
      $("table").simplePagination({
        // the number of rows to show per page
        perPage: 10,
        // CSS classes to custom the pagination
        containerClass: '',
        previousButtonClass: 'btn btn-secondary btn-custom-pagination',
        nextButtonClass: 'btn btn-secondary btn-custom-pagination',
        // text for next and prev buttons
        previousButtonText: 'Précédent',
        nextButtonText: 'Suivant',
        // initial page
        currentPage: 1
      });
    });
    </script>

  </head>

  <body style="background-color:#f2f2f2;">

    <div id="snackbar">Veuillez compléter l'ensemble des champs.</div>

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

    <script>
      $(document).ready(function () {
        $("#generer_licence").on('click', function () {
          var beneficiaire = $('#nomlogiciel_genererlicence').val();
          var select_nom = $("#select_logiciel :selected").text();
          var select_type = $("#select_type :selected").text();
          var select_abonnement = $("#select_abonnement :selected").text();


                if(beneficiaire != '') {
                    if(select_nom != "LOGICIEL") {
                      if(select_type != "TYPE") {
                        if(select_abonnement != "ABONNEMENT") {
                          var id_logiciel = $('select[name=select_logiciel]').val();
                          var id_abonnement = $('select[name=select_abonnement]').val();
                          $.ajax({
                            url: "modules/EnregistrerNouvelleLicence.php",
                            data: {'beneficiaire': beneficiaire ,'logiciel': id_logiciel ,'type': select_type ,'abo': id_abonnement},
                            dataType: 'json',
                            success: function(json){
                              var len = json.length;
                              if(len > 0) {
                                new Clipboard('.btnclipboard');
                                $('#clef').val(json);
                                $('#ModalLicenceAdmin').modal('show');
                              }
                            }
                          });
                         }
                         else {
                           $.toast({
                                heading: '<h2 style="float:left;font-size:20px">Erreur</h2><br /><br />',
                                text: '<p>Veuillez indiquer la durée d\'abonnement.</p>',
                                showHideTransition: 'plain',
                                position: 'bottom-center',
                                allowToastClose: false,
                                icon: 'error'
                            })
                         }
                     }
                     else {
                       $.toast({
                            heading: '<h2 style="float:left;font-size:20px">Erreur</h2><br /><br />',
                            text: '<p>Veuillez indiquer le type de la licence.</p>',
                            showHideTransition: 'plain',
                            position: 'bottom-center',
                            allowToastClose: false,
                            icon: 'error'
                        })
                     }
                  }
                  else {
                    $.toast({
                         heading: '<h2 style="float:left;font-size:20px">Erreur</h2><br /><br />',
                         text: '<p>Veuillez indiquer le nom du logiciel.</p>',
                         showHideTransition: 'plain',
                         position: 'bottom-center',
                         allowToastClose: false,
                         icon: 'error'
                     })
                  }
                }
                else {
                  $.toast({
                       heading: '<h2 style="float:left;font-size:20px">Erreur</h2><br /><br />',
                       text: '<p>Veuillez indiquer le nom du bénéficiaire.</p>',
                       showHideTransition: 'plain',
                       position: 'bottom-center',
                       allowToastClose: false,
                       icon: 'error'
                   })
                }
        });
      });
    </script>

    <br /><br />

    <!-- Modal -->
      <div class="modal fade" id="ModalLicenceAdmin" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Votre numéro de licence</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="clef">Licence :</label>
                    <!-- Target -->
                    <input id="clef">

                    <!-- Trigger -->
                    <button class="btnclipboard" data-clipboard-target="#clef">
                        <img src="assets/img/clippy.svg" alt="Copy to clipboard" width="10" height="10">
                    </button>
              </div>
            </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button> -->
            </div>
          </div>

        </div>
      </div>

    <div class="tab">
      <button class="tablinks" onclick="openCity(event, 'Acheteurs')">Acheteurs</button>
        &nbsp;&nbsp;&nbsp;
      <button class="tablinks" onclick="openCity(event, 'LicencesVendues')">Licences vendues</button>
        &nbsp;&nbsp;&nbsp;
      <button class="tablinks" onclick="openCity(event, 'ExportationDeDonnees')">Exportation de données</button>
        &nbsp;&nbsp;&nbsp;
      <button class="tablinks" onclick="openCity(event, 'OffresPromotionnelles')">Offres promotionnelles</button>
        &nbsp;&nbsp;&nbsp;
      <button class="tablinks" onclick="openCity(event, 'Catalogue')">Administration du catalogue</button>
    </div>

    <div id="Acheteurs" class="tabcontent">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 style="padding:0;">Aperçu des acheteurs</h3>
        </div>
      </div>
      <?php $req = $maPdoFonction->Commande();
          if($req->rowCount() >= 1) { ?> <br />

            <table class="table table-bordered table-responsive table-striped" style="margin-left:5%;width:91%;" id="list_commandes" name="list_commandes">
              <thead>
                <tr style="background-color:#2f2f2f;text-align:center;color:white;">
                    <th>
                      N° Commande
                    </th>
                    <th>
                      Acheteur
                    </th>
                    <th>
                      Date
                    </th>
                    <th>
                      Montant total
                    </th>
                    <th>
                      Type de paiement
                    </th>
                    <th>
                      Facture
                    </th>
                </tr>
              </thead>
            <?php while($donnees = $req->fetch()) { ?>
              <tr>
                      <td name='numcommande' id='numcommande' style="text-align:center;"><?php echo $donnees["numTransaction"]; ?></td>
                      <td><?php echo $donnees["emetteur"]; ?></td>
                      <td name='datecommande' id='datecommande' ><?php echo date("d/m/Y", strtotime($donnees["date"])); ?></td>
                      <td name='montanttotalcommande' id='montanttotalcommande' ><?php echo $donnees["montant"]; ?> €</td>
                      <td name='typepaeiementcommande' id='typepaeiementcommande' >
                        <?php if($donnees["typedepaiement_id"] == 1) {
                          echo "PayPal";
                        }
                        else if($donnees["typedepaiement_id"] == 2) {
                          echo "AlloPass";
                        }?>
                      </td>
                      <td>
                        <?php $link = "http://localhost/atoutprotect/factures/".$donnees["emetteur"]."/Facture_ATOUTSA_".$donnees["numTransaction"].".pdf"; ?>
                        <a href="<?php echo $link ?>" target="_blank"/>Facture-<?php echo $donnees["numTransaction"]; ?>.pdf</a>
                      </td>
                  </tr>
            <?php } ?>
            </table>
    <?php }
      else { ?>
        <div class="isa_error_" style="width:66%;">
          <i class="fa fa-times-circle"></i>
            Il n'y a aucune commande enregistré dans la base de données SQL.
        </div><br/><br /><br /><br />
      <?php } ?>
    </div>

    <div id="LicencesVendues" class="tabcontent">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 style="padding:0;">Aperçu des licences vendues</h3>
        </div>
      </div><br />

          <?php $req = $maPdoFonction->RecupLicences();
                if($req->rowCount() >= 1) { ?>
                  <table class="table table-bordered table-responsive table-striped" style="margin-left:5%;width:91%;">
                      <thead>
                        <tr style="background-color:#2f2f2f;text-align:center;color:white;">
                          <th>
                            Clef
                          </th>
                          <th>
                            Date d'achat
                          </th>
                          <th>
                            Date d'activation
                          </th>
                          <th>
                            Date d'expiration
                          </th>
                        </tr>
                      </thead>
                  <?php while($donnees = $req->fetch()) { ?>
                        <tr>
                          <td><?php echo $donnees['clef']; ?></b></td>
                          <td><?php echo date("d/m/Y", strtotime($donnees['date_creation'])); ?></td>
                          <?php if($donnees['date_activation'] != null) { ?>
                            <td><?php echo date("d/m/Y", strtotime($donnees['date_activation'])); ?></td>
                          <?php } else { ?>
                              <td> / </td>
                          <?php } ?>
                          <?php if($donnees['date_expiration'] != null) { ?>
                            <td><?php echo date("d/m/Y", strtotime($donnees['date_expiration'])); ?></td>
                          <?php } else { ?>
                              <td> / </td>
                          <?php } ?>
                    </tr>
                <?php } ?>
                </table>
            <?php } ?>

    </div>

    <div id="ExportationDeDonnees" class="tabcontent">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 style="padding:0;">Exportation de .CSV</h3>
        </div>
      </div>

      <h4 align="center">Voici les exports .CSV possible :</h4>

      <br />
      <div align="center">
        <button style="width:auto" id="CSV_Utilisateurs" name="CSV_Utilisateurs" class="btn btncsv">
          <span style="font-size:14px;color:black;"; class="glyphicon glyphicon-file"></span>
          &nbsp;&nbsp;Utilisateurs
        </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button style="width:auto" id="CSV_Commandes" name="CSV_Commandes" type="button" class="btn btncsv">
          <span style="font-size:14px;color:black;"; class="glyphicon glyphicon-file"></span>
          &nbsp;&nbsp;Commandes
        </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button style="width:auto" id="CSV_Licences" name="CSV_Licences" type="button" class="btn btncsv">
          <span style="font-size:14px;color:black;"; class="glyphicon glyphicon-file"></span>
          &nbsp;&nbsp;Licences
          </button><br />
      </div>
     <br /> <br />

    <script>
         $("#CSV_Utilisateurs").click(function(e){
           <?php $req = $maPdoFonction->CSV_Utilisateurs();
                 if($req->rowCount() >= 1) {
                   $path = 'C:/wamp/www/atoutprotect/csvexport/Utilisateurs_Export_Donnees_Administration.csv';
                    $monfichier = fopen($path, 'w+'); //sert uniquement a effacer le fichier et le créer s'il n'existe pas
                     fputcsv($monfichier,array('id', 'Email', 'Mdp', 'Nom', 'Prenom', 'Adresse', 'Tel', 'CodePostal', 'Ville', 'Droit_id', 'DateDeCreation', 'DateDerniereConnexion', 'HeureDerniereConnexion'),";");
                       while($donnees = $req->fetch()){
                         $droit = "";
                         if($donnees['Droit_id'] == 1) {
                           $droit = "Administrateur";
                         }
                         else if($donnees['Droit_id'] == 2) {
                           $droit = "Webmaster";
                         }
                         else if($donnees['Droit_id'] == 3) {
                           $droit = "Client";
                         }
                         fputcsv($monfichier,array($donnees['id'],$donnees['Email'],$donnees['Mdp'],$donnees['Nom'],$donnees['Prenom'],$donnees['Adresse'],$donnees['Tel'],$donnees['CodePostal'],$donnees['Ville'],$droit,$donnees['DateDeCreation'],$donnees['DateDerniereConnexion'],$donnees['HeureDerniereConnexion']),";");
                       }
                     fclose($monfichier); } ?>

                       window.open('http://localhost/atoutprotect/csvexport/Utilisateurs_Export_Donnees_Administration.csv', 'Download');
         });
    </script>
    <script>
         $("#CSV_Commandes").click(function(e){
           <?php $req = $maPdoFonction->CSV_Commandes();
                 if($req->rowCount() >= 1) {
                   $path = 'C:/wamp/www/atoutprotect/csvexport/Commandes_Export_Donnees_Administration.csv';
                    $monfichier = fopen($path, 'w+'); //sert uniquement a effacer le fichier et le créer s'il n'existe pas
                     fputcsv($monfichier,array('Num transaction','Date','Montant','Methode de Paiement','Emetteur'),";");
                       while($donnees = $req->fetch()){
                         if($donnees['typedepaiement_id'] == 1) {
                           $paiement = "PayPal";
                         }
                         else {
                           $paiement = "AlloPass";
                         }
                         fputcsv($monfichier,array($donnees['numTransaction'],$donnees['date'],$donnees['montant'],$paiement,$donnees['emetteur']),";");
                       }
                     fclose($monfichier); } ?>

                       window.open('http://localhost/atoutprotect/csvexport/Commandes_Export_Donnees_Administration.csv', 'Download');
         });
    </script>
    <script>
         $("#CSV_Licences").click(function(e){
           <?php $req = $maPdoFonction->CSV_Licences();
                 if($req->rowCount() >= 1) {
                   $path = 'C:/wamp/www/atoutprotect/csvexport/Licences_Export_Donnees_Administration.csv';
                    $monfichier = fopen($path, 'w+'); //sert uniquement a effacer le fichier et le créer s'il n'existe pas
                     fputcsv($monfichier,array('Clef','Proprietaire','Logiciel','Type de licence','Abonnement',"Date Creation",'Date Activation','Date Expiration'),";");
                       while($donnees = $req->fetch()){
                         $logiciel = '';
                         $req_logiciel = $maPdoFonction->GetNomLogiciel($donnees['logiciel_id']);
                               if($req_logiciel->rowCount() >= 1) {
                                 while($data = $req_logiciel->fetch()){
                                   $logiciel = $data['Nom'];
                                 }
                               }

                         $abo = '';
                         if($donnees['abonnement_id'] == 1) {
                           $abo = "1 mois";
                         }
                         else if($donnees['abonnement_id'] == 3) {
                           $abo = "3 mois";
                         }
                         else if($donnees['abonnement_id'] == 6) {
                           $abo = "6 mois";
                         }
                         else if($donnees['abonnement_id'] == 12) {
                           $abo = "1 an";
                         }
                         else if($donnees['abonnement_id'] == 0) {
                           $abo = "Perpetuel";
                         }
                         fputcsv($monfichier,array($donnees['clef'],$donnees['proprietaire'],$logiciel,$donnees['typelicence'],$abo,$donnees['date_creation'],$donnees['date_activation'],$donnees['date_expiration']),";");
                       }
                     fclose($monfichier); } ?>

                       window.open('http://localhost/atoutprotect/csvexport/Licences_Export_Donnees_Administration.csv', 'Download');
         });
    </script>
    </div>

    <div id="OffresPromotionnelles" class="tabcontent">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 style="padding:0;">Offres promotionelles</h3>
          </div>
        </div>

        <h4 align="center">Veuillez remplir les informations suivantes afin de générer une licence :</h4>

        <br />
        <div align="center" style="width:50%;margin:auto;">
              <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-user" style="color:black;font-size:12px;"></span></span>
                <input type="text" class="form-control" id="nomlogiciel_genererlicence" name="nomlogiciel_genererlicence" placeholder="Nom du bénéficiaire" aria-describedby="sizing-addon2">
              </div><br />
              <?php $req_select1 = $maPdoFonction->Logiciels();
                  if($req_select1->rowCount() > 0) { ?>
                    <select id="select_logiciel" name="select_logiciel">
                      <option disabled selected>LOGICIEL</option>
                        <?php while($donnees_req_select1 = $req_select1->fetch()) { ?>
                            <option value="<?php echo $donnees_req_select1['id']; ?>"><?php echo $donnees_req_select1['Nom']; ?></option>
                        <?php } } ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php $req_select1 = $maPdoFonction->TypeLicences();
                    if($req_select1->rowCount() > 0) { ?>
                      <select id="select_type" name="select_type">
                        <option disabled selected>TYPE</option>
                          <?php while($donnees_req_select1 = $req_select1->fetch()) { ?>
                              <option value="<?php echo $donnees_req_select1['id']; ?>"><?php echo $donnees_req_select1['Nom']; ?></option>
                          <?php } } ?>
                      </select>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php $req_select2 = $maPdoFonction->Abonnements();
                    if($req_select2->rowCount() > 0) { ?>
                      <select id="select_abonnement" name="select_abonnement">
                        <option disabled selected>ABONNEMENT</option>
                          <?php while($donnees_req_select2 = $req_select2->fetch()) { ?>
                              <option value="<?php echo $donnees_req_select2['id']; ?>"><?php echo $donnees_req_select2['nom']; ?></option>
                          <?php } } ?>
                      </select>&nbsp;&nbsp;&nbsp;&nbsp;
              <div align="center"><br />
                <button type="submit" id="generer_licence" name="generer_licence" class="btn btn-success">
                  <span style="font-size:15px;color:white;" class="glyphicon glyphicon-plus"></span>
                    &nbsp;&nbsp;GENERER</button>
              </div> <br />
          </div>
    </div>

    <div id="Catalogue" class="tabcontent" style="height:940px;">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 style="padding:0;">Logiciels compatibles avec les licences vendues</h3>
        </div>
      </div>

      <div class="panel-body row btn-toolbar">
        <div style="padding:0;" class='btn-group'>
          <button onclick="openModalNouvLogiciel()" class="btn btn-success" style="display:inline-block;width:300px;margin-right: 5px;padding:0;height:30px;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Nouveau logiciel</button>
          <?php $req = $maPdoFonction->Logiciels();
                if($req->rowCount() >= 1) {
                  ?><button onclick="DeleteLogiciel(this.id);" class="btn btn-danger" style="display:inline-block;width:300px;margin-right: 5px;padding:0;height:30px;"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;Supprimer</button><?php
                } ?>
        </div>
      </div>

      <?php $req = $maPdoFonction->Logiciels();
            if($req->rowCount() >= 1) { ?>

              <?php while ($data = $req->fetch()) { ?>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="thumbnail">
                    <input type="checkbox" class="checkbox" id="check0" />
                      <img src="http://via.placeholder.com/350x200" alt="">
                      <div class="caption">
                          <h3><?php echo $data['Nom']; ?></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                      </div>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
  </div>
    <br />  <br />
  </section><br />

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
          <p>50 rue de Limayrac,<br/>
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
