<?php session_start();
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);

//récuperation des variables en POST ou GET
$nom = (isset($_POST['nom'])? $_POST['nom']:  (isset($_GET['nom'])? $_GET['nom']:null ));
$quantite = (isset($_POST['quantite'])? $_POST['quantite']:  (isset($_GET['quantite'])? $_GET['quantite']:null ));
$prix = (isset($_POST['prix'])? $_POST['prix']:  (isset($_GET['prix'])? $_GET['prix']:null ));
$type = (isset($_POST['type'])? $_POST['type']:  (isset($_GET['type'])? $_GET['type']:null ));
$abo = (isset($_POST['abo'])? $_POST['abo']:  (isset($_GET['abo'])? $_GET['abo']:null ));


/**
* Ajoute un article dans le panier après vérification que nous ne somme pas en phase de paiement
*
* @param array  $select variable tableau associatif contenant les valeurs de l'article
* @return Mixed Retourne VRAI si l'ajout est effectué, FAUX sinon voire une autre valeur si l'ajout
*               est renvoyé vers la modification de quantité.
* @see {@link modif_qte()}
*/
function ajouterArticle($nom,$quantite,$prix,$type,$abo)
{
    $ajout = false;
    if(!verif_panier($nom,$type,$abo))
    {
        $array_caddy = array(
          'logiciel' => array($nom),
          'quantite' => array($quantite),
          'prix' => array($prix),
          'type' => array($type),
          'abonnement' => array($abo)
        );

        # Mise en session du tableau
        if(sizeof($_SESSION['panier']) == 0) {
          $_SESSION['panier'] = $array_caddy;
        }
        else {
          //Sinon on ajoute le produit
           array_push( $_SESSION['panier']['logiciel'], $nom);
           array_push( $_SESSION['panier']['quantite'], $quantite);
           array_push( $_SESSION['panier']['prix'], $prix);
           array_push( $_SESSION['panier']['type'], $type);
           array_push( $_SESSION['panier']['abonnement'], $abo);
        }

        $ajout = true;
    }
    else
    {
      $nouvel_quantite = "";
      foreach($_SESSION['panier']['quantite'] as $key => $value) {
        $nouvel_quantite = $value + 1;
      }
      $ajout = modif_qte($nom,$type,$abo,$nouvel_quantite);
    }
    return $ajout;
}

/**
* Vérifie la présence d'un article dans le panier
*
* @param String $ref_article référence de l'article à vérifier
* @return Boolean Renvoie Vrai si l'article est trouvé dans le panier, Faux sinon
*/
function verif_panier($nom,$type,$abo)
{
  /* On initialise la variable de retour */
  $present = false;
  /* On vérifie les numéros de références des articles et on compare avec l'article à vérifier */
  if( count($_SESSION['panier']) > 0 && array_search($nom,$_SESSION['panier']['logiciel']) !== false
      && array_search($type,$_SESSION['panier']['type']) !== false
      && array_search($abo,$_SESSION['panier']['abonnement']) !== false)
      {
        $present = true;
      }
  return $present;
}


/**
* Modifie la quantité d'un article dans le panier
*
* @param String $nom   Identifiant de l'article à modifier
* @param Int $quantite              Nouvelle quantité à enregistrer
* @return Boolean              Retourne VRAI si la modification a bien eu lieu, FAUX sinon.
*/
function modif_qte($nom,$type,$abo,$quantite)
{
  /* On compte le nombre d'articles différents dans le panier */
  $nb_articles = count($_SESSION['panier']['logiciel']);

  /* On initialise la variable de retour */
  $ajoute = false;

  /* On parcoure le tableau de session pour modifier l'article précis. */
  for($i = 0; $i < $nb_articles; $i++)
  {
    if($nom == $_SESSION['panier']['logiciel'][$i] && $type == $_SESSION['panier']['type'][$i] && $abo == $_SESSION['panier']['abonnement'][$i])
    {
        $_SESSION['panier']['quantite'][$i] = $quantite;
        $ajoute = true;
    }
  }
  return $ajoute;
}

if((isset($nom)) && (isset($type)) && (isset($abo)) && (isset($quantite))) {
    ajouterArticle($nom,$quantite,$prix,$type,$abo);
}

?>
