<?php

class ModeleConnexion extends Connexion {

    public function ajouterUtilisateur($login, $hash) {
        $req = self::$bdd->prepare("INSERT INTO utilisateurs (login, pwd) VALUES (?, ?)");
        $req->execute([$login, $hash]);
    }

    public function getUtilisateur($login) {
        $req = self::$bdd->prepare("SELECT * FROM utilisateurs u INNER JOIN role r ON r.idUtilisateur = u.id  WHERE login = ?");
        $req->execute([$login]);
        return $req->fetch();
    }

    public function verifLoginExiste($login) {
        $req = self::$bdd->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $req->execute([$login]);
        return $req->fetch();
    }
}
