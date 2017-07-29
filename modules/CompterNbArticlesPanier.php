<?php session_start();

  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);

$nbArticles = count($_SESSION['panier']['logiciel']);

  $tab_req = $nbArticles;
  	$retour = array(
  								"success" => true,
  								"data" => $tab_req
  								);
  echo json_encode($tab_req);

?>
