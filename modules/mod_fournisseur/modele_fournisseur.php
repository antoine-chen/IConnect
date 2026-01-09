<?php

class ModeleFournisseur extends Connexion{

    public function getListeFournisseur($idAsso){
        $fournisseur = self::$bdd->prepare('SELECT * FROM fournisseur WHERE id = ?');
        $fournisseur->execute([$idAsso]);
        return $fournisseur->fetchAll();
    }
}