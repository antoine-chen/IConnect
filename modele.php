<?php
class Modele extends Connexion{

    public function idInventaire($idAsso)
    {
        $get = self::$bdd->prepare('
            select max(id) as id 
            from inventaire
            where idAssociation = (?)
        ');
        $get->execute([$idAsso]);
        return $get->fetchColumn();
    }
}