<?php
class PdoBdd extends PDO {

    private $bdd, $moteur, $hote, $login, $mdp, $base;

    public function __construct() {
		$fichier = 'C:/wamp/www/atoutprotect/ini/Setting.ini';
        if(file_exists($fichier)) {
			$config = parse_ini_file($fichier, true);

			$this->moteur = $config['SQL']['moteur'];
			$this->hote   = $config['SQL']['hote'];
			$this->login  = $config['SQL']['login'];
			$this->mdp    = $config['SQL']['mdp'];
			$this->base   = $config['SQL']['base'];
		}
		else{
			echo 'Une erreur de connexion à la base de données est survenue. Veuillez contacter l\'administrateur. (Code erreur : <i><b>Fichier de configuration absent</b></i> )';
			die;
		}
	}
	public function connexion(){
		try {
			$this->bdd = new PDO($this->moteur .':host='. $this->hote .';dbname='. $this->base, $this->login, $this->mdp,
                           array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
			$this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(Exception $e) {
			exit('Une erreur de connexion à la base de données est survenue. Veuillez contacter l\'administrateur. (Code erreur : <i><b>'. $e->getMessage().'</b></i> )');
			die;
		}
	}
	public function deconnexion(){
		$this->bdd = null;
	}

    public function requete($requete) {
    //return $this->bdd->query($requete) or exit(print_r($this->bdd->errorInfo()));
		try {
			return $this->bdd->query($requete);
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
    }

    public function fetch($resultat) {
    return $resultat->fetch();
    }

    public function compteur($resultat) {
        if(is_object($resultat)) {
        echo 'ok';
        } else {
        echo 'pas ok';
        }
    return $resultat->rowCount();
    }

    public function close($resultat) {
    return $resultat->closeCursor();
    }
}
?>
