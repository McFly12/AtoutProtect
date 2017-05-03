<?php
include 'PdoBdd.php';

/*
	S'il ya une erreur SQL informant : "ONLY_FULL_GROUP_BY"
	SOLUTION : ' SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY','')); '
	source : http://stackoverflow.com/questions/23921117/disable-only-full-group-by
*/

class PdoFonction extends PdoBdd {

	/***************************************************************/
	/* 											CONSTRUCTEUR													*/
	public function __construct(){
		parent::__construct();
	}

	/***************************************************************/
	/* 				VERIFIE CONNECTE, SINON REDIRECTION Index.php 			*/
	public function VerifierLogin($mail,$mdp){
		parent::connexion();
		$result = parent::requete('	SELECT U.Nom,U.Prenom,U.Droit_id,U.id
																FROM utilisateur U
																WHERE BINARY U.Email="' . $mail . '" AND BINARY U.Mdp="' . $mdp . '"');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 					 MET A JOUR LA DERNIERE DATE DE CONNEXION 	 		 	*/
	public function MajDateDerniereCo($id){
		parent::connexion();
		$result = parent::requete('UPDATE utilisateur U SET U.DateDerniereConnexion = CURDATE(), U.HeureDerniereConnexion = CURTIME()
															 WHERE U.id="'.$id.'"');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 							 ENREGISTRE LE NOUVEAU COMPTE						 			*/
	public function EnregNouvCompte($nom,$prenom,$tel,$email,$mdp,$adresse,$codepostal,$ville,$droit) {
		parent::connexion();
		$result = parent::requete("INSERT INTO `utilisateur`(`Nom`,`Prenom`,`Tel`,`Email`,`Mdp`,`Adresse`,`CodePostal`,`Ville`,`Droit`)
															 VALUES ('$nom','$prenom','$tel','$email','$mdp','$adresse','$codepostal','$ville','$droit')");
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 			VERIFIE L'ENREGISTREMENT DU NOUVEAU COMPTE			 			*/
	public function VerifEnregNouvCompte($nom,$prenom,$tel,$email,$mdp,$adresse,$codepostal,$ville,$droit) {
		parent::connexion();
		$result = parent::requete(' SELECT *
													FROM utilisateur U
													WHERE U.Nom = "'.$nom.'"
														AND U.Prenom = "'.$prenom.'"
														AND U.Tel = "'.$tel.'"
														AND U.Email = "'.$email.'"
														AND U.Mdp = "'.$mdp.'"
														AND U.Adresse = "'.$adresse.'"
														AND U.CodePostal = "'.$prenom.'"
														AND U.Ville = "'.$ville.'"
														AND U.Droit = "'.$droit.'" ');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 			VERIFIE L'ENREGISTREMENT DU NOUVEAU COMPTE			 			*/
	public function InformationsUtilisateur($nom) {
		parent::connexion();
		$result = parent::requete('SELECT U.Prenom,U.Tel,U.Email,U.Mdp,U.Adresse,U.CodePostal,U.Ville,U.Droit_id,U.DateDeCreation,U.DateDerniereConnexion,U.HeureDerniereConnexion
															 FROM utilisateur U
															 WHERE U.Nom = "'.$nom.'"');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 									 SUPPRIME UN COMPTE									 			*/
	public function SupprimerUtilisateur($id) {
		parent::connexion();
		$result = parent::requete('DELETE FROM utilisateur WHERE id = "'.$id.'"');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 						 VERIFIE LA SUPPRESSION D'UN COMPTE				 			*/
	public function VerifSupprimerUtilisateur($id) {
		parent::connexion();
		$result = parent::requete('SELECT * FROM utilisateur WHERE id = "'.$id.'"');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 			ADMINISTRATEUR : -> COMMANDES			 			*/
	public function Commande() {
		parent::connexion();
		$result = parent::requete('SELECT * FROM commande');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 											RECUP LOGICIELS 											*/
	public function Logiciels() {
		parent::connexion();
		$result = parent::requete('SELECT Nom FROM logiciel');
		parent::deconnexion();
		return $result;
	}

}
?>
