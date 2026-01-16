<?php
class Modele extends Connexion{

    public function idInventaire($idAsso){
        $get = self::$bdd->prepare('
            select max(id) as id 
            from inventaire
            where idAssociation = (?)
        ');
        $get->execute([$idAsso]);
        return $get->fetchColumn();
    }

    public function idAsso($nomAsso){
        $get = self::$bdd->prepare('SELECT id FROM association where nom = (?)');
        $get->execute([$nomAsso]);
        return $get->fetchColumn();
    }



}