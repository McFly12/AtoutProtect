<?php
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

    session_start();

    $req_majdatederniereco = $maPdoFonction->MajDateDerniereCo($_SESSION['id']);

	  session_unset();
    session_destroy();

	header('Location: ../index.php');
?>
