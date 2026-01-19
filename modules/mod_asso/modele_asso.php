<?php
include_once "modele.php";
class ModeleAsso extends Modele {

    public function getListeAssociationInscris($idUtilisateur){
        $getAssoInscris = self::$bdd->prepare('SELECT distinct a.id, a.image, a.nom FROM association a INNER JOIN role r ON a.id = r.idAssociation WHERE r.idUtilisateur = (?) AND r.role != "enCours" AND a.statut="valide"');
        $getAssoInscris->execute([$idUtilisateur]);

        return $getAssoInscris->fetchAll();
    }

    public function getListeAssociationPasIncris($idUtilisateur){
        $sql = '
        SELECT DISTINCT a.id, a.image, a.nom
        FROM association a
        WHERE a.id not in (
            SELECT r.idAssociation
            FROM role r
            WHERE r.idUtilisateur = ?
        ) AND a.statut = "valide"
    ';
        $stmt = self::$bdd->prepare($sql);
        $stmt->execute([$idUtilisateur]);
        return $stmt->fetchAll();
    }


    public function getListeAssociationEnAttente($idUtilisateur){
        $getAssoInscris = self::$bdd->prepare('SELECT distinct a.id, a.image, a.nom FROM association a INNER JOIN role r ON a.id = r.idAssociation WHERE r.idUtilisateur = (?) AND r.role = "enCours" AND a.statut="valide"');
        $getAssoInscris->execute([$idUtilisateur]);

        return $getAssoInscris->fetchAll();
    }

    public function estPresentDansAsso($idAsso, $login){
        $sql = "select role from role where idUtilisateur = (?) and idAssociation = (?)";
        $donnesBlocTexte = self::$bdd->prepare($sql);
        $donnesBlocTexte->execute([$login,$idAsso]);
        return $donnesBlocTexte->fetch();
    }

    public function demandeAccesAssociation($idAsso, $idUtilisateur){
        $insert = self::$bdd->prepare('INSERT INTO role (idUtilisateur,idAssociation,role) VALUES (?, ?, ?)');
        $insert->execute([$idUtilisateur, $idAsso,'enCours']);
    }

    public function existeAssociaion ($idAssociation){
        $existe = self::$bdd->prepare('SELECT id FROM association WHERE id = ?');
        $existe->execute([$idAssociation]);
        return $existe->fetch();
    }

    public function insertAssociation($nom){
        $insert = self::$bdd->prepare('INSERT INTO association (nom,image,statut) VALUES (?,?,?)');
        $insert->execute([$nom, "vide","attente"]);
    }

    public function ajoutImage($idAsso,$image) {
        $insert = self::$bdd->prepare('UPDATE association SET image = (?) where id= (?)');
        $insert->execute([$image, $idAsso]);
    }

    public function enregistrerDemande($idUtilisateur, $idAsso)
    {
        $insert = self::$bdd->prepare('insert into demandeCreationAsso (idUtilisateur,idAsso) values (?,?)');
        $insert->execute([$idUtilisateur,$idAsso]);
    }

}