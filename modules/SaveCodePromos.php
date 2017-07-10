<?php

		include '../class/PdoFonction.php';
		$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction

if(isset($_GET['pourcentage']) && isset($_GET['codepromo'])) {

		$pourcentage = $_GET['pourcentage'];
		$codepromo = $_GET['codepromo'];

		$maPdoFonction->SaveNouvCodePromo($pourcentage,$codepromo);
}
	?>
