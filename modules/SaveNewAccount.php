<?php
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);


$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$tel = $_POST['tel'];
$email = $_POST['email'];

$mdp = $_POST['mdp'];
$confirmmdp = $_POST['confirmmdp'];

$adresse = $_POST['adresse'];
$codepostal = $_POST['codepostal'];
$ville = $_POST['ville'];


if((isset($nom)) && (isset($prenom)) && (isset($tel)) && (isset($email)) && (isset($mdp)) && (isset($confirmmdp)) && (isset($adresse)) && (isset($codepostal)) && (isset($ville))) {

  if(strcmp($mdp, $confirmmdp) == 0) {

    $u_password = hash('sha256', $mdp);

    $req = $maPdoFonction->EnregNouvCompte($nom,$prenom,$tel,$email,$u_password,$adresse,$codepostal,$ville,'3');
    if($req->rowCount() == 1) {
        $req_verif = $maPdoFonction->VerifEnregNouvCompte($nom,$prenom,$tel,$email,$u_password,$adresse,$codepostal,$ville,'3');
      if($req_verif->rowCount() == 1) {
        header('Location: ../createaccount.php?ErrNewAcc');
      }
      else {
        $folderName = $nom;
          $structure = '../factures/'.$folderName.'/';
            if (!file_exists('./factures/'.$folderName)) {
              mkdir('./factures/'.$folderName, 0400, true);
             }
             sleep(2);
        header('Location: ../login.php?OkNewAcc');
      }
    }
    else {
      header('Location: ../createaccount.php?ErrNewAcc');
    }
  }
  else {
    header('Location: ../createaccount.php?ErrNewAcc');
  }
}
else {
  header('Location: ../createaccount.php?MissChNewAcc');
}

?>
