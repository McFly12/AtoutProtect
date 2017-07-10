<?php session_start();
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);


$nom = $_GET['nom'];
$type = $_GET['type'];
$abo = $_GET['abo'];
$quantite = $_GET['quantite'];


if((isset($nom)) && (isset($type)) && (isset($abo)) && (isset($quantite))) {
  /* On compte le nombre d'articles différents dans le panier */
  $nb_articles = count($_SESSION['panier']['logiciel']);

  if($nom == "Logiciel 1") {
    $nom = "Logiciel1";

    if($type == "Standard") {
      $type = "standardlogiciel1";
    }
    else if($type == "Professionnel") {
      $type = "prologiciel1";
    }
  }
  else if($nom == "Logiciel 2") {
    $nom = "Logiciel2";

    if($type == "Standard") {
      $type = "standardlogiciel2";
    }
    else if($type == "Professionnel") {
      $type = "prologiciel2";
    }
  }

  /* On initialise la variable de retour */
  $ajoute = false;

  if($abo == "1 mois") {
    $abo = "1";
  }
  else if($abo == "3 mois") {
    $abo = "3";
  }
  else if($abo == "6 mois") {
    $abo = "6";
  }
  else if($abo == "1 an") {
    $abo = "12";
  }
  else if($abo == "A vie") {
    $abo = "0";
  }

  /* On parcoure le tableau de session pour modifier l'article précis. */
  for($i = 0; $i < $nb_articles; $i++)
  {
    if($nom == $_SESSION['panier']['logiciel'][$i] && $type == $_SESSION['panier']['type'][$i] && $abo == $_SESSION['panier']['abonnement'][$i])
    {
        unset($_SESSION['panier']['logiciel'][$i]);
        unset($_SESSION['panier']['type'][$i]);
        unset($_SESSION['panier']['abonnement'][$i]);
        unset($_SESSION['panier']['quantite'][$i]);
        unset($_SESSION['panier']['prix'][$i]);
    }
  }

  $nb_articles_bis = count($_SESSION['panier']['logiciel']);
  if($nb_articles_bis == 0) {
    unset($_SESSION['pnaier']);
  }
}

?>
