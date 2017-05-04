<?php
	if(!isset($_SESSION)) session_start();

		include '../class/PdoFonction.php';
		$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction

if(isset($_GET['email'])) {

		$email = $_GET['email'];

		$reponse = $maPdoFonction->InformationsUtilisateur($email);
			$tab_req = $reponse->fetchAll(PDO::FETCH_ASSOC);
			$retour = array(
										"success" => true,
										"data" => $tab_req
										);

			echo json_encode($tab_req);
}
	?>
