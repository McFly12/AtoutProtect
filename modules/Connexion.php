<?php session_start();
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
?>

<?php

$mail = $_POST['InputEmail1'];
$mdp = $_POST['InputPassword1'];

  if ((isset($mail)) && (isset($mdp))) {
    $req = $maPdoFonction->VerifierLogin($mail,$mdp);
    if($req->rowCount() == 1){
			while($donnees = $req->fetch()) {
        $_SESSION['nom'] = $donnees['Nom'];
        $_SESSION['prenom'] = $donnees['Prenom'];
        $_SESSION['droit'] = $donnees['Droit'];
        $_SESSION['id'] = $donnees['id'];
      }
      header('Location: ../account.php');
    }
    else {
      header('Location: ../login.php?ErrLog');
    }
  }
  else {
    header('Location: ../login.php?ErrLog');
  }
?>
