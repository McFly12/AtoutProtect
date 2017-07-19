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
	/* 											RECUP LOGICIELS 											*/
	public function Logiciels() {
		parent::connexion();
		$result = parent::requete('SELECT Nom FROM logiciel');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 									 SUPPRIME UN COMPTE									 			*/
	public function DeleteLogiciel($nomlogiciel) {
		parent::connexion();
		$result = parent::requete('DELETE FROM logiciel WHERE nom = "'.$nomlogiciel.'"');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/*									RECUP TYPES D'ABONNEMENTS									*/
	public function Abonnements() {
		parent::connexion();
		$result = parent::requete('SELECT id,nom,durée FROM abonnement');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 				VERIFIE CONNECTE, SINON REDIRECTION Index.php 			*/
	public function VerifierLogin($mail,$mdp){
		parent::connexion();
		$result = parent::requete('	SELECT *
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
	/* 			RECUPERE LES INFORMATIONS D'UN COMPTE			 			*/
	public function InformationsUtilisateur($mail) {
		parent::connexion();
		$result = parent::requete('SELECT DISTINCT U.Nom,U.Prenom,U.Tel,U.Mdp,U.Adresse,U.CodePostal,U.Ville,U.Droit_id,U.DateDeCreation,U.DateDerniereConnexion,U.HeureDerniereConnexion
															 FROM utilisateur U
															 WHERE U.Email = "'.$mail.'"');
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
	/* 			ADMINISTRATEUR : -> AFFICHAGE DE TOUTE LES COMMANDES 			*/
	public function Commande() {
		parent::connexion();
		$result = parent::requete('SELECT * FROM commande');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 			CLIENT OU AUTRE : -> AFFICHAGE DE TOUTE LES COMMANDES 			*/
	public function CommandePerso($nom) {
		parent::connexion();
		$result = parent::requete('SELECT * FROM commande WHERE emetteur = "'.$nom.'"');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 					ENREGISTRE UNE NOUVELLE COMMANDE EN BASE	 				*/
	public function EnregistrerCommandePayPal($numtransaction,$montant,$nom) {
		parent::connexion();
		$result = parent::requete('INSERT INTO commande (numtransaction,date,montant,typedepaiement_id,emetteur)
															 VALUES ("'.$numtransaction.'",CURDATE(),"'.$montant.'",1,"'.$nom.'")');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 					ENREGISTRE UNE NOUVELLE LICENCE EN BASE	 				*/
	public function EnregistrerLicenceBase($clef,$nom,$logiciel,$type_logiciel,$abo_id) {
		parent::connexion();
		$result = parent::requete('INSERT INTO licence VALUES ("'.$clef.'","'.$nom.'","'.$logiciel.'","'.$type_logiciel.'","'.$abo_id.'",CURDATE(),NULL,NULL)');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 					RECUPERE LES CODES PROMOTIONS ENREGISTRES	 				*/
	public function RecupCodesPromo() {
		parent::connexion();
		$result = parent::requete('SELECT * FROM codepromo');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 					RECUPERE LES CODES PROMOTIONS ENREGISTRES	 				*/
	public function RecupLicences() {
		parent::connexion();
		$result = parent::requete('SELECT * FROM licence');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 					ENREGISTRE UN NOUVEAU CODE PROMO	 				*/
	public function SaveNouvCodePromo($pourcentage,$codepromo) {
		parent::connexion();
		$result = parent::requete('INSERT INTO codepromo (`code`, `pourcentage_reduc`, `statut`, `beneficiaire`) VALUES ("'.$codepromo.'","'.$pourcentage.'","Non-Activé",NULL)');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 					VERIFIER UN CODE PROMO	 				*/
	public function VerifierCodePromotion($code) {
		parent::connexion();
		$result = parent::requete('SELECT * FROM codepromo WHERE code = "'.$code.'"');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 							 ENREGISTRE LE NOUVEAU LOGICIEL						 			*/
	public function SaveNouvLogiciel($nom) {
		parent::connexion();
		$result = parent::requete("INSERT INTO `logiciel`(`id`,`Nom`)
															 VALUES (default,'$nom')");
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 					 MET A JOUR LES INFOS DE L'UTILISATEUR 	 		 	*/
	public function SaveInfosUtilisateur($nom,$prenom,$adresse,$tel,$cp,$ville){
		parent::connexion();
		$result = parent::requete('UPDATE utilisateur U SET U.Adresse="'.$adresse.'", U.Tel="'.$tel.'", U.CodePostal="'.$cp.'", U.Ville="'.$ville.'"
															 WHERE U.Nom="'.$nom.'" AND U.Prenom="'.$prenom.'"');
		parent::deconnexion();
		return $result;
	}

	/***************************************************************/
	/* 					CSV UTILISATEURS	 				*/
	public function CSV_Utilisateurs() {
		parent::connexion();
		$result = parent::requete('SELECT * FROM utilisateur');
		parent::deconnexion();
		return $result;
	}

}
?>
