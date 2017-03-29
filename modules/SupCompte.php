<?php
	if(!isset($_SESSION)) session_start();

		include '../class/PdoFonction.php';
		$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction

if(isset($_SESSION['nom'])) {

	$nom = $_SESSION['nom'];
	$prenom = $_SESSION['prenom'];
	$id = $_SESSION['id'];

		$reponse = $maPdoFonction->SupprimerUtilisateur($nom,$prenom,$id);
		$reponse_verif = $maPdoFonction->VerifSupprimerUtilisateur($nom,$prenom,$id);
		if($reponse_verif->rowCount() >= 1) {
			// header('Location: ../account.php?ErrSupUtilisateur');
			header('Location: session_destroyer.php');
		}
		else {
			// header('Location: ../login.php?SupUtilisateurOK');
			header('Location: ../account.php');
		} ?>
}
	?>
