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

    public function dejaBarman($idUtilisateur, $idAssociation, $role){
        $get = self::$bdd->prepare('SELECT u.id FROM utilisateurs u INNER JOIN role r ON u.id = r.idUtilisateur
                                                 WHERE r.idUtilisateur = ? AND r.idAssociation = ? AND r.role = ?');
        $get->execute([$idUtilisateur, $idAssociation, $role]);
        return $get->fetchColumn();
    }

    public function insertRoleBarman($idUtilisateur, $idAssociation, $role){
        $insert = self::$bdd->prepare('INSERT INTO role(idUtilisateur, idAssociation, role) VALUES (?, ?, ?)');
        $insert->execute([$idUtilisateur, $idAssociation, $role]);
    }

    public function deleteRoleBarman($idUtilisateur, $idAssociation, $role){
        $delete = self::$bdd->prepare('DELETE FROM role WHERE idUtilisateur = ? AND idAssociation = ? AND role = ?');
        $delete->execute([$idUtilisateur, $idAssociation, $role]);
    }

    public function deleteUtilisateur($idUtilisateur, $idAssociation){
        $delete = self::$bdd->prepare('DELETE FROM role WHERE idUtilisateur = ? AND idAssociation = ?');
        $delete->execute([$idUtilisateur, $idAssociation]);
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

    public function getUtilisateurAsso($idAssociation){
        $get = self::$bdd->prepare('
            select distinct u.id, u.login, u.nom, u.prenom, u.telephone, r.role
            from utilisateurs u inner join role r on u.id = r.idUtilisateur
            where idAssociation = (?) AND r.role != "Admin" AND r.role != "enCours"
        ');
        $get->execute([$idAssociation]);
        return $get->fetchAll();
    }

    public function getListeDemandeUtilisateur($idAssociation){
        $getAssoInscris = self::$bdd->prepare('SELECT u.id, u.login, u.nom, u.prenom, u.telephone FROM association a 
                                                        INNER JOIN role r ON a.id = r.idAssociation  
                                                        INNER JOIN utilisateurs u ON r.idUtilisateur = u.id
                                                        WHERE a.id = ? AND r.role = "enCours"');
        $getAssoInscris->execute([$idAssociation]);
        return $getAssoInscris->fetchAll();
    }

    public function accepterDemandeUtilisateur($idUtilisateur, $idAssociation){
        $updateRole = self::$bdd->prepare('UPDATE role SET role = "Client" WHERE idUtilisateur = ? AND idAssociation = ? ');
        $updateRole->execute([$idUtilisateur, $idAssociation]);
    }

    public function refuserDemandeUtilisateur($idUtilisateur, $idAssociation){
        $updateRole = self::$bdd->prepare('DELETE FROM role WHERE idUtilisateur = ? AND idAssociation = ?');
        $updateRole->execute([$idUtilisateur, $idAssociation]);
    }

}