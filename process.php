<?php session_start(); unset($_SESSION['remise']);

  require('class/PayPal.php');
  $paypal = new PayPal();

  include 'class/PdoFonction.php';
  $maPdoFonction = new PdoFonction();

  $reponse = $paypal->request('SetExpressCheckout', array(
    'TOKEN' => $_GET['token']
  ));

  if($reponse) {
    if($reponse['CHECKOUTSTATUS'] == 'PaymentActionCompleted') {
      die("Ce paiement a déjà été validé.");
    }
  }
  else {
    var_dump($paypal->errors);
    die();
  }

  $params = array(
    'TOKEN' => $_GET['token'],
    'PAYERID' => $_GET['PayerID'],
    'PAYMENTACTION' => 'Sale',

    'PAYMENTREQUEST_0_AMT' => $_SESSION['totalTVA'],
    'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
    'PAYMENTREQUEST_0_SHIPPINGCART' => $_SESSION['totalTVA'],
    'PAYMENTREQUEST_0_ITEMAMT' => $_SESSION['panier']['quantite'],
    'RETURNURL' => 'http://localhost/atoutprotect/basket.php?PayPalOk=OK',
    'CANCELURL' => 'http://localhost/atoutprotect/basket.php?ErrPayPal'
  );

    foreach ($_SESSION['panier'] as $key => $value)
    {
    //  $params["L_PAYMENTREQUEST_0_NAME$key"] = $_SESSION['panier']['logiciel'];
    //  $params["L_PAYMENTREQUEST_0_DESC$key"] = '';
      //$params["L_PAYMENTREQUEST_0_AMT$key"] = $_SESSION['panier']['prix'];
    //  $params["L_PAYMENTREQUEST_0_QTY$key"] = $_SESSION['panier']['quantite'];
    }

  // PRELEVEMENT POUR LE PAIEMENT
  $reponse = $paypal->request('DoExpressCheckoutPayment', $params);

  if($reponse) {
  var_dump($reponse);

    $idtransaction = $reponse['PAYMENTINFO_0_TRANSACTIONID'];
    $montanttransaction = $reponse['PAYMENTINFO_0_AMT'];
    $_SESSION['id_transaction'] = $idtransaction;
    $_SESSION['montant_transaction'] = $montanttransaction;
  //  header('Location: basket.php?PayPalOk');
    exit();
  }
  else {
    var_dump($paypal->errors);
    die();
  }

 ?>
