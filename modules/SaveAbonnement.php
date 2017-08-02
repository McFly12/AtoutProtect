<?php

		include '../class/PdoFonction.php';
		$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction

if(isset($_GET['nom'])) {

		$nom = $_GET['nom'];
		$duree = $_GET['duree'];

		$maPdoFonction->SaveNouvAbonnement($nom,$duree);
}
	?>
