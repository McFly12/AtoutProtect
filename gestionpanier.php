<?php

/**
 * Verifie si le panier existe, le créé sinon
 * @return booleen
 */
function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier'] = array();
      $_SESSION['panier']['id_logiciel'] = array();
      $_SESSION['panier']['qte'] = array();
      $_SESSION['panier']['prix'] = array();
   }
   return true;
}

/**
 * Ajoute un article dans le panier
 * @param string $libelleProduit
 * @param int $qteProduit
 * @param float $prixProduit
 * @return void
 */
function ajouterArticle($libelleProduit,$qteProduit,$prixProduit){

   //Si le panier existe
   if (creationPanier())
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($libelleProduit, $_SESSION['panier']['id_logiciel']);
      if ($positionProduit != false)
      {
         $_SESSION['panier']['qte'][$positionProduit] += $qteProduit ;
      }
      else
      {
         //Sinon on ajoute le produit
         array_push( $_SESSION['panier']['id_logiciel'],$libelleProduit);
         array_push( $_SESSION['panier']['qte'],$qteProduit);
         array_push( $_SESSION['panier']['prix'],$prixProduit);
      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

/**
 * Modifie la quantité d'un article
 * @param $libelleProduit
 * @param $qteProduit
 * @return void
 */
function modifierQTeArticle($libelleProduit,$qteProduit){
   //Si le panier éxiste
   if (creationPanier())
   {
      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($qteProduit > 0)
      {
         //Recharche du produit dans le panier
         $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['id_logiciel']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['qte'][$positionProduit] = $qteProduit ;
         }
      }
      else
      supprimerArticle($libelleProduit);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

/**
 * Supprime un article du panier
 * @param $libelleProduit
 * @return unknown_type
 */
function supprimerArticle($libelleProduit){
   //Si le panier existe
   if (creationPanier())
   {
      //Nous allons passer par un panier temporaire
      $tmp=array();
      $tmp['libelleProduit'] = array();
      $tmp['qteProduit'] = array();
      $tmp['prixProduit'] = array();

      for($i = 0; $i < count($_SESSION['panier']['id_logiciel']); $i++)
      {
         if ($_SESSION['panier']['libelleProduit'][$i] !== $libelleProduit)
         {
            array_push( $tmp['libelleProduit'],$_SESSION['panier']['id_logiciel'][$i]);
            array_push( $tmp['qte'],$_SESSION['panier']['qte'][$i]);
            array_push( $tmp['prix'],$_SESSION['panier']['prix'][$i]);
         }
      }
      //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $tmp;
      //On efface notre panier temporaire
      unset($tmp);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}


/**
 * Montant total du panier
 * @return int
 */
function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['id_logiciel']); $i++)
   {
      $total += $_SESSION['panier']['qte'][$i] * $_SESSION['panier']['prix'][$i];
   }
   return $total;
}


/**
 * Fonction de suppression du panier
 * @return void
 */
function supprimePanier(){
   unset($_SESSION['panier']);
}


/**
 * Compte le nombre d'articles différents dans le panier
 * @return int
 */
function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['id_logiciel']);
   else
   return 0;
}

?>
