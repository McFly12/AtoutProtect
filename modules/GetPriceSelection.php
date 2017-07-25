<?php session_start();
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);


$nom = $_GET['nom'];
$type = $_GET['type'];
$abo = $_GET['abo'];

if((isset($nom)) && (isset($type)) && (isset($abo))) {

  $req = $maPdoFonction->RecupPrix($nom,$type,$abo);

  $tab_req = $req->fetchAll(PDO::FETCH_ASSOC);
  	$retour = array(
  								"success" => true,
  								"data" => $tab_req
  								);
  echo json_encode($tab_req);
}

?>
