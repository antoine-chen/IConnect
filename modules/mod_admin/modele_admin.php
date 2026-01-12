<?php
include_once "modele.php";
class ModeleAdmin extends Modele {

    public function insertAssociation($nom){
        $insert = self::$bdd->prepare('INSERT INTO association (nom,image) VALUES (?, ?)');
        $insert->execute([$nom, "vide"]);
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

    public function insertRoleGestionnaire($idUtilisateur, $idAssociation, $role){
        $insert = self::$bdd->prepare('INSERT INTO role(idUtilisateur, idAssociation, role) VALUES (?, ?, ?)');
        $insert->execute([$idUtilisateur, $idAssociation, $role]);
    }

    public function ajoutImage($idAsso,$image) {
        $insert = self::$bdd->prepare('UPDATE association SET image = (?) where id= (?)');
        $insert->execute([$image, $idAsso]);
    }

    public function idAsso($nomAsso){
        $get = self::$bdd->prepare('SELECT id FROM association where nom = (?)');
        $get->execute([$nomAsso]);
        return $get->fetchColumn();
    }

}