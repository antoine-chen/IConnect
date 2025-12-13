<?php

class ModeleAdmin extends Connexion{

    public function insertAssociation($nom, $imgAsso){
        $insert = self::$bdd->prepare('INSERT INTO association (nom, image) VALUES (?, ?)');
        $insert->execute([$nom, $imgAsso]);
    }

    public function getAssociations(){
        $get = self::$bdd->prepare('SELECT * FROM association');
        $get->execute();
        return $get->fetchAll();
    }

    public function insertGestionnaire(){
        $insert = self::$bdd->prepare('INSERT INTO ');
    }

}