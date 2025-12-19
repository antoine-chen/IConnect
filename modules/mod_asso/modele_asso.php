<?php
class ModeleAsso extends Connexion{

    public function getListe()
    {
        $sql = "select * from association";
        $donnesBlocTexte = self::$bdd->prepare($sql);
        $donnesBlocTexte->execute();

        return $donnesBlocTexte->fetchAll();
    }

    public function estPresentDansAsso($idAsso, $login)
    {
        $sql = "select * from role where idAssociation = (?) and idUtilisateur = (?)";
        $donnesBlocTexte = self::$bdd->prepare($sql);
        $donnesBlocTexte->execute([$idAsso,$login]);
        return $donnesBlocTexte->fetchAll();
    }

    public function attribuerRoleClient($idAsso, $idUtilisateur)
    {
        $insert = self::$bdd->prepare('INSERT INTO role (idUtilisateur,idAssociation,role) VALUES (?, ?, ?)');
        $insert->execute([$idAsso, $idUtilisateur,'Client']);
    }

    public function existeAssociaion ($idAssociation){
        $existe = self::$bdd->prepare('SELECT id FROM association WHERE id = ?');
        $existe->execute([$idAssociation]);
        return $existe->fetch();
    }

}