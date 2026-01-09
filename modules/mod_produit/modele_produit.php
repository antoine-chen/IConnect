<?php
include_once "modele.php";
class ModeleProduit extends Connexion {
    private $modele;

    public function getProduits($idAsso,$idInventaire){
        $getProduits = self::$bdd->prepare('SELECT p.*, l.stock FROM boutique b INNER JOIN produit p ON b.idProduit = p.id 
                                                        INNER JOIN ligneInventaire l ON l.idProduit = p.id
                                                        INNER JOIN inventaire i ON i.id = l.idInventaire
                                            WHERE i.idAssociation = ? AND l.stock > 0 AND i.id = (?) and l.idInventaire = (?)');
        $getProduits->execute([$idAsso,$idInventaire,$idInventaire]);
        return $getProduits->fetchAll();
    }

    public function getSoldeClient($idClient, $idAssociation){
        $getSolde = self::$bdd->prepare('SELECT solde FROM solde WHERE idUtilisateur = ? AND idAssociation = ? AND solde > 0');
        $getSolde->execute([$idClient, $idAssociation]);
        return $getSolde->fetchColumn();
    }

    public function idInventaire($idAsso)
    {
        $this->modele = new Modele();
        return $this->modele->idInventaire($idAsso);
    }


}