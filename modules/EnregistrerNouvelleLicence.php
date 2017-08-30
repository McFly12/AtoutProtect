<?php
       include '../class/PdoFonction.php';
       $maPdoFonction = new PdoFonction();		//Creation d'une instance de la classe PdoFonction
       error_reporting(E_ALL);
       ini_set('error_reporting', E_ALL);

// Générer une licence unique et aléatoire
  function generation_clefs() {
    // CARACTERES ACCECPTES DANS UNE CLEF DE LICENCE
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      // NOMBRE DE CARACTERES PAR SEGMENT DE LA CLEF DE LICENCE
    $segment_chars = 4;
      // NOMBRE DE SEGMENTS DE LA CLEF DE LICENCE
    $num_segments = 4;
      // CLEF GENEREE
    $clef = '';

      // GENERE CHAQUE SEGMENT
    for ($i = 0; $i < $num_segments; $i++) {
      $segment = '';

          // POUR CHAQUE SEGMENT => HASARD DE 5 CARCTERES AUTORISE VIA $caracteres
      for ($j = 0; $j < $segment_chars; $j++) {
        $segment .= $caracteres[rand(0, 35)];
      }
          // CONCATENE DANS LA CLEF GENEREE
      $clef .= $segment;

      if ($i < ($num_segments - 1)) {
          $clef .= '-';
      }
    }
    return $clef;
  }

$beneficiaire = $_GET['beneficiaire'];
$logiciel = $_GET['logiciel'];
$type = $_GET['type'];
$abo = $_GET['abo'];

$clef = generation_clefs();

$req = $maPdoFonction->EnregistrerLicenceBase($clef,$beneficiaire,$logiciel,$type,$abo);

sleep(1);
$tab_req = $clef;
  $retour = array(
                "success" => true,
                "data" => $tab_req
                );
echo json_encode($tab_req);
?>
