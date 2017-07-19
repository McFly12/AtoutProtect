<?php session_start();
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
?>

<?php

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$tel = $_POST['tel'];
$cp = $_POST['codepostal'];
$ville = $_POST['ville'];

  if ((isset($nom)) && (isset($prenom))) {
    $req = $maPdoFonction->SaveInfosUtilisateur($nom,$prenom,$adresse,$tel,$cp,$ville);
      header('Location: ../account.php?SaveOk');
    }
    else {
      header('Location: ../account.php?ErrSave');
    }
?>
