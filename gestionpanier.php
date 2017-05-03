<?php

session_start();

/* Initialisation du panier */
 if(!isset($_SESSION['panier']))
 {
   $_SESSION['panier'] = array();
 }

  /**
  * Ajoute un article dans le panier après vérification que nous ne somme pas en phase de paiement
  *
  * @param array  $select variable tableau associatif contenant les valeurs de l'article
  * @return Mixed Retourne VRAI si l'ajout est effectué, FAUX sinon voire une autre valeur si l'ajout
  *               est renvoyé vers la modification de quantité.
  * @see {@link modif_qte()}
  */
  function ajouterArticle($nom,$quantite,$prix,$type)
  {
      $ajout = false;
      if(!verif_panier($nom,$type))
      {
          $array_caddy = array(
            'logiciel' => array($nom),
            'quantite' => array($quantite),
            'prix' => array($prix),
            'type' => array($type)
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
          }

          $ajout = true;
      }
      else
      {
        $nouvel_quantite = "";
        foreach($_SESSION['panier']['quantite'] as $key => $value) {
          $nouvel_quantite = $value + 1;
        }
        $ajout = modif_qte($nom,$type,$nouvel_quantite);
      }
      return $ajout;
  }

  /**
 * Vérifie la présence d'un article dans le panier
 *
 * @param String $ref_article référence de l'article à vérifier
 * @return Boolean Renvoie Vrai si l'article est trouvé dans le panier, Faux sinon
 */
function verif_panier($nom,$type)
{
    /* On initialise la variable de retour */
    $present = false;
    /* On vérifie les numéros de références des articles et on compare avec l'article à vérifier */
    if( count($_SESSION['panier']) > 0 && array_search($nom,$_SESSION['panier']['logiciel']) !== false && array_search($type,$_SESSION['panier']['type']) !== false)
    {
        $present = true;
    }
    return $present;
}


/**
 * Modifie la quantité d'un article dans le panier
 *
 * @param String $ref_article   Identifiant de l'article à modifier
 * @param Int $qte              Nouvelle quantité à enregistrer
 * @return Boolean              Retourne VRAI si la modification a bien eu lieu, FAUX sinon.
 */
function modif_qte($ref_article,$type_article,$qte)
{
    /* On compte le nombre d'articles différents dans le panier */
    $nb_articles = count($_SESSION['panier']['logiciel']);

    /* On initialise la variable de retour */
    $ajoute = false;

    /* On parcoure le tableau de session pour modifier l'article précis. */
    for($i = 0; $i < $nb_articles; $i++)
    {
      if($ref_article == $_SESSION['panier']['logiciel'][$i] && $type_article == $_SESSION['panier']['type'][$i])
      {
          $_SESSION['panier']['quantite'][$i] = $qte;
          $ajoute = true;
      }
    }
    return $ajoute;
}

/**
 * Calcule le montant total du panier
 *
 * @return Double
 */
function montant_panier()
{
    /* On initialise le montant */
    $montant = 0;
    /* Comptage des articles du panier */
    $nb_articles = count($_SESSION['panier']['logiciel']);
    /* On va calculer le total par article */
    for($i = 0; $i < $nb_articles; $i++)
    {
        $montant += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
    }
    /* On retourne le résultat */
    return $montant;
}

?>
