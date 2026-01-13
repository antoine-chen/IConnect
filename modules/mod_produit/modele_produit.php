<?php
include_once "modele.php";
class ModeleProduit extends Modele {

    public function getProduits($idAsso,$idInventaire){
        $getProduits = self::$bdd->prepare('SELECT p.*, l.stock FROM boutique b INNER JOIN produit p ON b.idProduit = p.id 
                                                        INNER JOIN ligneInventaire l ON l.idProduit = p.id
                                                        INNER JOIN inventaire i ON i.id = l.idInventaire
                                            WHERE i.idAssociation = ? AND l.stock > 0 AND i.id = (?) and l.idInventaire = (?)');
        $getProduits->execute([$idAsso,$idInventaire,$idInventaire]);
        return $getProduits->fetchAll();
    }

    public function getProduit($idProduit)
    {
        $get = self::$bdd->prepare('
            select produit.id,produit.nom as nom, produit.image as image, produit.prix as prix 
            from produit
            where produit.id = (?)
        ');
        $get->execute([$idProduit]);
        return $get->fetch();
    }

    public function getSoldeClient($idClient, $idAssociation){
        $getSolde = self::$bdd->prepare('SELECT solde FROM solde WHERE idUtilisateur = ? AND idAssociation = ? AND solde > 0');
        $getSolde->execute([$idClient, $idAssociation]);
        return $getSolde->fetchColumn();
    }

    public function insertProduit($nomProduit, $prixProduit)
    {
        $insert = self::$bdd->prepare('
            insert into produit (nom,prix,image) values (?,?,?)
        ');
        $insert->execute([$nomProduit,$prixProduit,"vide"]);
    }

    public function lastProduitAjoute()
    {
        $get = self::$bdd->prepare('
            select max(id) as id from produit;
        ');
        $get->execute();
        return $get->fetch();
    }

    public function associerProduitAuAsso($idAsso, $produit)
    {
        $insert = self::$bdd->prepare('
            insert into boutique (idAssociation,idProduit) values (?,?)
        ');
        $insert->execute([$idAsso,$produit]);
    }

    public function ajoutImage($idProduit, $cheminFichier)
    {
        $insert = self::$bdd->prepare('
            update produit set image = (?) where id = (?)
        ');
        $insert->execute([$cheminFichier,$idProduit]);
    }

    public function updateProduit($idProduit,$nom,$prix)
    {
        $update = self::$bdd->prepare('
            update produit set nom = (?), prix = (?) where id = (?)
        ');
        $update->execute([$nom,$prix,$idProduit]);
    }

    public function ajoutProduitInventaire($idInventaire,$idProduit)
    {
        $insert = self::$bdd->prepare('
            insert into ligneInventaire (idInventaire,idProduit,stock,pertes) values (?,?,?,?)
        ');
        $insert->execute([$idInventaire,$idProduit,0,0]);
    }

}