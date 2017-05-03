<?php
  class PayPal {

    // IDENTIFIANTS
    private $user = "yvanmarty-facilitator_api1.live.fr";
    private $pwd = "WRJNTZB33C23VEA9";
    private $signature = "AFcWxV21C7fd0v3bYYYRCpSSRl31AcjgbXI9wWtVdx7F98JxzD-ajN4I";

    private $endpoint = 'https://api-3t.sandbox.paypal.com/nvp';

    public $errors = array();

    public function __construct($user = false, $pwd = false, $signature = false) {
      if($user){
        $this->user = $user;
      }
      if($pwd){
        $this->pwd = $pwd;
      }
      if($signature){
        $this->signature = $signature;
      }
    }

    public function request($method, $params) {
      $params = array_merge($params, array(
        'METHOD' => $method,
        'VERSION' => '74.0',
        'USER' => $this->user,
        'SIGNATURE' => $this->signature,
        'PWD' => $this->pwd
      ));

      $params = http_build_query($params);

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $this->endpoint,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_VERBOSE => 1
      ));

      $reponse = curl_exec($curl);
      $reponseArray = array();
      parse_str($reponse, $reponseArray);

      if(curl_errno($curl)) {
        $this->errors = curl_error($curl);
        curl_close($curl);
        return false;
      }
      else {
        if($reponseArray['ACK'] == 'Success') {
          curl_close($curl);
          return $reponseArray;
        }
        else {
            $this->errors = $reponseArray;
            curl_close($curl);
            return false;
        }
      }
    }

  }
    ?>
