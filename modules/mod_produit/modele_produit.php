<?php
class ModeleProduit extends Connexion{

    public function getProduits($idAsso){
        $getProduits = self::$bdd->prepare('SELECT p.*, l.stock FROM boutique b INNER JOIN produit p ON b.idProduit = p.id 
                                                        INNER JOIN ligneInventaire l ON l.idProduit = p.id
                                                        INNER JOIN inventaire i ON i.id = l.idInventaire
                                            WHERE i.idAssociation = ?');
        $getProduits->execute([$idAsso]);
        return $getProduits->fetchAll();
    }
}