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

    public function getIdUtilisateur($login)
    {
        $sql = "select * from utilisateurs where login=(?)";
        $donnesBlocTexte = self::$bdd->prepare($sql);
        $donnesBlocTexte->execute([$login]);
        return $donnesBlocTexte->fetchColumn();
    }
}