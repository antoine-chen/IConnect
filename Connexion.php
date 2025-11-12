<?php
class connexion{
    static protected $bdd;
    public function __construct(){
    }

    public static function initConnexion(){
        self::$bdd =new PDO('mysql:dbname=dutinfopw201668;host=database-etudiants.iut.univ-paris8.fr',"dutinfopw201668","bedegaje");
    }
}



//https://database-etudiants.iut.univ-paris8.fr/phpmyadmin/index.php