<?php

class ModeleFournisseur extends Modele{

    public function insertFournisseur($nom, $email, $ville, $telephone){
        $insertFournisseur = self::$bdd->prepare('INSERT INTO fournisseur(nom, email, ville, tel) VALUES (?, ?, ?, ?)');
        $insertFournisseur->execute([$nom, $email, $ville, $telephone]);
    }

    public function deleteFournisseur($idFournisseur){
        $deleteFournisseur = self::$bdd->prepare('DELETE FROM fournisseur WHERE id = ?');
        $deleteFournisseur->execute([$idFournisseur]);
    }

    public function produitsPasFournitParFournisseur($idAssociation, $idFournisseur){
        $get = self::$bdd->prepare('SELECT pr.nom FROM produit pr INNER JOIN boutique b ON b.idProduit = pr.id WHERE b.idAssociation = ? 
                                    EXCEPT
                                    SELECT pr.nom FROM fournisseur f INNER JOIN produitsFournisseur p ON f.id = p.idFournisseur
                                                                    INNER JOIN produit pr ON pr.id = p.idProduit
                                        WHERE f.idAssociation = ? AND f.id = ?');
        $get->execute([$idAssociation, $idAssociation, $idFournisseur]);
        return $get->fetchAll();
    }

    public function insertProduitFournisseur(){

    }
}