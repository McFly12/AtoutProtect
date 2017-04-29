<?php session_start();

  require('class/PayPal.php');
  $paypal = new PayPal();

  $reponse = $paypal->request('GetExpressCheckoutDetails', array(
    'TOKEN' => $_GET['token']
  ));

  if($reponse) {
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
    'PAYMENTREQUEST_0_ITEMAMT' => $_SESSION['panier']['quantite']
  );

    foreach ($_SESSION['panier'] as $key => $value)
    {
      $params["L_PAYMENTREQUEST_0_NAME$key"] = $_SESSION['panier']['logiciel'];
      $params["L_PAYMENTREQUEST_0_DESC$key"] = '';
      $params["L_PAYMENTREQUEST_0_AMT$key"] = $_SESSION['panier']['prix'];
      $params["L_PAYMENTREQUEST_0_QTY$key"] = $_SESSION['panier']['quantite'];
    }

  // PRELEVEMENT POUR LE PAIEMENT
  $reponse = $paypal->request('DoExpressCheckoutPayment', $params);

  if($reponse) {
    var_dump($reponse);
    $idtransaction = $reponse['PAYMENTINFO_0_TRANSACTIONID'];
    $montanttransaction = $reponse['PAYMENTINFO_0_AMT'];
    $_SESSION['id_transaction'] = $idtransaction;
    $_SESSION['montant_transaction'] = $montanttransaction;
    header('Location: basket.php?PayPalOk');
  }
  else {
    var_dump($paypal->errors);
  }


 ?>
