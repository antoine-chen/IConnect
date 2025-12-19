<?php
class ModeleProduit extends Connexion{

    public function getProduits(){
        $getProduits = self::$bdd->prepare('SELECT * FROM produit');
        $getProduits->execute();
        return $getProduits->fetchAll();
    }
}