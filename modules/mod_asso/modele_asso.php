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
        $sql = "select role from role where idUtilisateur = (?) and idAssociation = (?)";
        $donnesBlocTexte = self::$bdd->prepare($sql);
        $donnesBlocTexte->execute([$login,$idAsso]);
        return $donnesBlocTexte->fetch();
    }

    public function attribuerRoleClient($idAsso, $idUtilisateur)
    {
        $insert = self::$bdd->prepare('INSERT INTO role (idUtilisateur,idAssociation,role) VALUES (?, ?, ?)');
        $insert->execute([$idUtilisateur, $idAsso,'Client']);
    }

}