<?php

class ModeleFournisseur extends Connexion{

    public function getListeFournisseur(){
        $fournisseur = self::$bdd->prepare('SELECT * FROM fournisseur');
        $fournisseur->execute();
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
}