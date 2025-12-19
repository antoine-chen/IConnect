<?php
class ModeleProduit extends Connexion{

    public function getProduits($idAsso){
        $getProduits = self::$bdd->prepare('SELECT * FROM boutique b INNER JOIN produit p ON b.idProduit = p.id WHERE p.id = ?');
        $getProduits->execute([$idAsso]);
        return $getProduits->fetchAll();
    }
}