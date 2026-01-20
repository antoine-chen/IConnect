<?php

class ModeleFournisseur extends Connexion{

    public function getListeFournisseur(){
        $fournisseur = self::$bdd->prepare('SELECT * FROM fournisseur where idAssociation = (?)');
        $fournisseur->execute([$_SESSION['asso']]);
        return $fournisseur->fetchAll();
    }

    public function insertFournisseur($nom, $email, $ville, $telephone){
        $insertFournisseur = self::$bdd->prepare('INSERT INTO fournisseur(nom, email, ville, tel,idAssociation) VALUES (?, ?, ?, ?,?)');
        $insertFournisseur->execute([$nom, $email, $ville, $telephone,$_SESSION['asso']]);
    }

    public function deleteFournisseur($idFournisseur){
        $deleteFournisseur = self::$bdd->prepare('DELETE FROM fournisseur WHERE id = ?');
        $deleteFournisseur->execute([$idFournisseur]);
    }
}