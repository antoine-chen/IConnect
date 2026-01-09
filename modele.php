<?php
class Modele extends Connexion{

    public function idInventaire($idAsso){
        $get = self::$bdd->prepare('
            select max(id) as id 
            from inventaire
            where idAssociation = (?)
        ');
        $get->execute([$idAsso]);
        return $get->fetch();
    }
    public function getProfilUtilisateur($idUtilisateur){
        $profil = self::$bdd->prepare('SELECT login, nom, prenom, date_naissance, adresse, mail, telephone FROM utilisateurs WHERE id = ?');
        $profil->execute([$idUtilisateur]);
        return $profil->fetch(PDO::FETCH_ASSOC);
    }

}