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

    public function getUtilisateur($login) {
        $req = self::$bdd->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $req->execute([$login]);
        return $req->fetchColumn(); // renvoie un int et pas un tableau
    }

    public function insertUtilisateur($login, $hash){
        $insert = self::$bdd->prepare('INSERT INTO utilisateurs (login, pwd) VALUES (?, ?)');
        $insert->execute([$login, $hash]);
    }

    public function inserRoleGestionnaire($idUtilisateur, $idAssociation){
        $role = "Gestionnaire";
        $insert = self::$bdd->prepare('INSERT INTO role(idUtilisateur, idAssociation, role) VALUES (?, ?, ?)');
        $insert->execute([$idUtilisateur, $idAssociation, $role]);
    }

}