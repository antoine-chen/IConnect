<?php
include_once "modele.php";
class ModeleAdmin extends Modele {

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

    public function getUtilisateurNonRole($idAssociation,$role){
        $get = self::$bdd->prepare('
            select distinct id,login,nom,prenom,telephone
            from utilisateurs inner join role on utilisateurs.id = role.idUtilisateur
            where idAssociation = (?) and role != (?)
        ');
        $get->execute([$idAssociation,$role]);
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

    public function listeDemandeAsso()
    {
        $get = self::$bdd->prepare('
            select a.id as assoId,u.id as utilisateurId,a.nom,a.image,u.login 
            from demandeCreationAsso d inner join association a on d.idAsso = a.id inner join utilisateurs u on d.idUtilisateur = u.id
            where a.statut = ?
        ');
        $get->execute(["attente"]);
        return $get->fetchAll();
    }

    public function refuserAsso($idAsso)
    {
        $update = self::$bdd->prepare('
            update association set statut = ? where id = ?
        ');
        $update->execute(["refus",$idAsso]);
    }

    public function accepterAsso($idAsso)
    {
        $update = self::$bdd->prepare('
            update association set statut = ? where id = ?
        ');
        $update->execute(["valide",$idAsso]);
    }

}