<?php
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

    session_start();

    $req_majdatederniereco = $maPdoFonction->MajDateDerniereCo($_SESSION['id']);

    unset($_SESSION['nom']);
    unset($_SESSION['prenom']);
    unset($_SESSION['droit']);
    unset($_SESSION['email']);
    unset($_SESSION['id']);
    unset($_SESSION['adresse']);
    unset($_SESSION['codepostal']);
    unset($_SESSION['ville']);

	header('Location: ../login.php');
?>
