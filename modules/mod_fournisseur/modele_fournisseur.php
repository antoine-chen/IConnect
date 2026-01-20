<?php

class ModeleFournisseur extends Connexion{

    public function getListeFournisseur($idAssociation){
        $fournisseur = self::$bdd->prepare('SELECT * FROM fournisseur WHERE idAssociation = ?');
        $fournisseur->execute([$idAssociation]);
        return $fournisseur->fetchAll();
    }

    public function insertFournisseur($nom, $email, $ville, $telephone){
        $insertFournisseur = self::$bdd->prepare('INSERT INTO fournisseur(nom, email, ville, tel) VALUES (?, ?, ?, ?)');
        $insertFournisseur->execute([$nom, $email, $ville, $telephone]);
    }

    public function deleteFournisseur($idFournisseur){
        $deleteFournisseur = self::$bdd->prepare('DELETE FROM fournisseur WHERE id = ?');
        $deleteFournisseur->execute([$idFournisseur]);
    }

    public function getProduitsFournisseur($idAssociation){
        $get = self::$bdd->prepare(' SELECT f.id AS idFournisseur, pr.nom AS nomProduit FROM fournisseur f INNER JOIN produitsFournisseur pf ON f.id = pf.idFournisseur
                                                        INNER JOIN produit pr ON pr.id = pf.idProduit
                                                        WHERE f.idAssociation = ?
                                                        ORDER BY f.id, pr.nom
        ');
        $get->execute([$idAssociation]);
        return $get->fetchAll();
    }

}