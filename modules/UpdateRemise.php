<?php session_start();

		include '../class/PdoFonction.php';
		$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction

if(isset($_GET['pourcentage_reduc'])) {

		$pourcentage_reduc = $_GET['pourcentage_reduc'];

		$_SESSION['remise'] = $pourcentage_reduc;
}
	?>
