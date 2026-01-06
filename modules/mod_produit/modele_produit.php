<?php
class ModeleProduit extends Connexion{

    public function getProduits($idAsso){
        $getProduits = self::$bdd->prepare('SELECT p.*, l.stock FROM boutique b INNER JOIN produit p ON b.idProduit = p.id 
                                                        INNER JOIN ligneInventaire l ON l.idProduit = p.id
                                                        INNER JOIN inventaire i ON i.id = l.idInventaire
                                            WHERE i.idAssociation = ? AND l.stock > 0');
        $getProduits->execute([$idAsso]);
        return $getProduits->fetchAll();
    }

    public function getSoldeClient($idClient, $idAssociation){
        $getSolde = self::$bdd->prepare('SELECT solde FROM solde WHERE idUtilisateur = ? AND idAssociation = ? AND solde > 0');
        $getSolde->execute([$idClient, $idAssociation]);
        return $getSolde->fetchColumn();
    }
}