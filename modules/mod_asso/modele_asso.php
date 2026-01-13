<?php
include_once "modele.php";
class ModeleAsso extends Modele {

    public function getListeAssociationInscris($idUtilisateur){
        $getAssoInscris = self::$bdd->prepare('SELECT distinct a.id, a.image, a.nom FROM association a INNER JOIN role r ON a.id = r.idAssociation WHERE r.idUtilisateur = (?)');
        $getAssoInscris->execute([$idUtilisateur]);

        return $getAssoInscris->fetchAll();
    }

    public function getListeAssociationPasIncris($idUtilisateur){
        $getAssoInscris = self::$bdd->prepare('SELECT distinct a.id, a.image, a.nom 
                                                FROM association a
                                                EXCEPT 
                                                SELECT distinct a.id, a.image, a.nom 
                                                FROM association a INNER JOIN role r ON a.id = r.idAssociation 
                                                WHERE r.idUtilisateur = (?)
                                                ');
        $getAssoInscris->execute([$idUtilisateur]);
        return $getAssoInscris->fetchAll();
    }

    public function estPresentDansAsso($idAsso, $login){
        $sql = "select role from role where idUtilisateur = (?) and idAssociation = (?)";
        $donnesBlocTexte = self::$bdd->prepare($sql);
        $donnesBlocTexte->execute([$login,$idAsso]);
        return $donnesBlocTexte->fetch();
    }

    public function attribuerRoleClient($idAsso, $idUtilisateur){
        $insert = self::$bdd->prepare('INSERT INTO role (idUtilisateur,idAssociation,role) VALUES (?, ?, ?)');
        $insert->execute([$idUtilisateur, $idAsso,'Client']);
    }

    public function existeAssociaion ($idAssociation){
        $existe = self::$bdd->prepare('SELECT id FROM association WHERE id = ?');
        $existe->execute([$idAssociation]);
        return $existe->fetch();
    }

}