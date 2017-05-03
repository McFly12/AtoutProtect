<?php
	if(!isset($_SESSION)) session_start();

		include '../class/PdoFonction.php';
		$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction

if(isset($_SESSION['id'])) {

		$reponse = $maPdoFonction->SupprimerUtilisateur($_SESSION['id']);
		$reponse_verif = $maPdoFonction->VerifSupprimerUtilisateur($_SESSION['id']);
		if($reponse_verif->rowCount() >= 1) {
			// header('Location: ../account.php?ErrSupUtilisateur');
			header('Location: ../account.php');
		}
		else {
			// header('Location: ../login.php?SupUtilisateurOK');
			header('Location: session_destroyer.php');
		}
}
	?>
