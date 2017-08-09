<?php session_start();
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);


$nom = $_GET['nom'];
$type = $_GET['type'];
$abo = $_GET['abo'];
$quantite = $_GET['quantite'];
$prix = $_GET['prix'];


if((isset($nom)) && (isset($type)) && (isset($abo)) && (isset($quantite)) && (isset($prix))) {
  /* On compte le nombre d'articles différents dans le panier */
  $nb_articles = count($_SESSION['panier']['logiciel']);

  /* On parcoure le tableau de session pour modifier l'article précis. */
  for($i = 0; $i < $nb_articles; $i++)
  {
    if($nom == $_SESSION['panier']['logiciel'][$i] && $type == $_SESSION['panier']['type'][$i] && $abo == $_SESSION['panier']['abonnement'][$i] && $prix == $_SESSION['panier']['prix'][$i])
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
    unset($_SESSION['panier']);
  }
}

?>
