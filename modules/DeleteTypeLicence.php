<?php

		include '../class/PdoFonction.php';
		$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction

if(isset($_GET['nomlogiciel'])) {

		$nomlogiciel = $_GET['nomlogiciel'];

		$maPdoFonction->DeleteTypeLogiciel($nomlogiciel);

		$maPdoFonction->DeleteTypeLogicielTablePrix($nomlogiciel);
}
	?>
