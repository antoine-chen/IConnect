<?php

class ModeleAdmin extends Connexion{

    public function insertAssociation($nom, $imgAsso){
        $insert = self::$bdd->prepare('INSERT INTO association (nom, image) VALUES (?, ?)');
        $insert->execute([$nom, $imgAsso]);
    }
}