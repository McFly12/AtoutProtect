<?php

		include '../class/PdoFonction.php';
		$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction

if(isset($_GET['nomabo'])) {

		$nomabo = $_GET['nomabo'];

		$maPdoFonction->DeleteAbonnement($nomabo);

		$maPdoFonction->DeleteAbonnementTablePrix($nomabo);
}
	?>
