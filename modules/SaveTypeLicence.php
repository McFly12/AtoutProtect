<?php

		include '../class/PdoFonction.php';
		$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction

if(isset($_GET['nom'])) {

		$nom = $_GET['nom'];

		$maPdoFonction->SaveNouvTypeLicence($nom);

		$arr_type = array();
		$arr_abo = array();

		$arr_standard = array('40','50','60','70','80');
		$arr_professionnel = array('100','110','120','130','140','150');

		 $req_select1 = $maPdoFonction->TypeLicences();
				if($req_select1->rowCount() > 0) {
					while($donnees_req_select1 = $req_select1->fetch()) {
							array_push($arr_type, $donnees_req_select1['Nom']);
					}
				}

		$req_select2 = $maPdoFonction->Abonnements();
			 if($req_select2->rowCount() > 0) {
				 while($donnees_req_select2 = $req_select2->fetch()) {
						 array_push($arr_abo, $donnees_req_select2['nom']);
				 }
			 }

			 for($i = 0, $size_type = count($arr_type); $i < $size_type; ++$i) {
				 $type = $arr_type[$i];
				 if($type == "Standard") {
					 for($j = 0, $size_abo = count($arr_abo); $j < $size_abo; ++$j) {
							 $abo = $arr_abo[$j];
							 $prix = $arr_standard[$j];
							 $maPdoFonction->SavePrixLogiciel($nom,$type,$abo,$prix);
					 }
				 }
				 if($type == "Professionnel") {
					 for($j = 0, $size_abo = count($arr_abo); $j < $size_abo; ++$j) {
							 $abo = $arr_abo[$j];
							 $prix = $arr_standard[$j];
							 $maPdoFonction->SavePrixLogiciel($nom,$type,$abo,$prix);
					 }
				 }
				 else {
					 for($j = 0, $size_abo = count($arr_abo); $j < $size_abo; ++$j) {
							 $abo = $arr_abo[$j];
							 $prix = $arr_standard[$j];
							 $maPdoFonction->SavePrixLogiciel($nom,$type,$abo,$prix);
					 }
				 }
				}
}
	?>
