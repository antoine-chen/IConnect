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

}