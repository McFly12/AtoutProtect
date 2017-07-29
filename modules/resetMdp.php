<?php session_start();

  include '../class/PdoFonction.php';
  $maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
  error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);
  	require '../PHPMailer/PHPMailerAutoload.php';


	$email = $_POST['mail_reset_mdp'];
  $_SESSION['email_reset_mdp'] = $email;
	$subject="Mot de passe provisoire | ATOUT PROTECT";
	$message = "Voici votre lien de récupération de votre mot de passe : ";
	$newpass = sha1('P@ssw0rd');
	$message.= "http://localhost/atoutprotect/reinitialiser_mdp.php?email=".$email;

  // MAJ MDP
  $reqete = $maPdoFonction->MAJResetMdp($email,$newpass);

  $mail = new PHPMailer;

  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->Host = 'smtp.orange.fr';  // Specify main and backup SMTP servers
  $mail->SMTPAuth = false;                               // Enable SMTP authentication
  $mail->Username = 'atoutlicencemanagement@gmail.com';                 // SMTP username
  $mail->Password = 'atoutprotect';                           // SMTP password
  $mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
  $mail->Port = 25;                                    // TCP port to connect to
  $mail->CharSet = 'UTF-8';

  $mail->setFrom('atoutlicencemanagement@gmail.com', 'ATOUT S.A.');
  $mail->addAddress($email);     // Add a recipient
  $mail->isHTML(true);                                  // Set email format to HTML

  $mail->Subject = $subject;
  $mail->Body    = $message;

  if(!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
  } else {
    header('Location: ../login.php?SendResetOK');
  }

?>
