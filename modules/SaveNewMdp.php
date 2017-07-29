<?php session_start();
include '../class/PdoFonction.php';
$maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);


$email = $_SESSION['email_reset_mdp'];

$mdp = $_POST['Pass1'];
$confirmmdp = $_POST['ConfirmPass1'];


  if(strcmp($mdp, $confirmmdp) == 0) {echo 'yvan';

    $u_password = sha1($mdp);

    $req = $maPdoFonction->MAJResetMdp($email,$u_password);
    if($req->rowCount() == 1) {
        $req_verif = $maPdoFonction->VerifMAJResetMdp($email,$u_password);
      if($req_verif->rowCount() == 0) {
        header('Location: ../reinitialiser_mdp.php?ErrMdp');
      }
      else {
        unset($_SESSION['email_reset_mdp']);
        header('Location: ../login.php?OkNewMdp');
      }
    }
    else {
      header('Location: ../reinitialiser_mdp.php?ErrMdp');
    }
  }
  else {
    header('Location: ../reinitialiser_mdp.php?ErrMdp');
  }

?>
