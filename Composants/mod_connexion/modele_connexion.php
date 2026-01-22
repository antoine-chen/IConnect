<?php
include_once "modele.php";

class ModeleConnexion extends Modele {
    private $modele;

    public function __construct() {
        $this->modele = new Modele();
    }

    public function ajouterUtilisateur($login, $hash, $nom, $prenom, $telephone="", $email="") {
        $req = self::$bdd->prepare("INSERT INTO utilisateurs (login, pwd, nom, prenom, telephone, email,consentementRgpd) VALUES (?, ?, ?, ?, ?, ?,?)");
        $req->execute([$login, $hash, $nom, $prenom, $telephone, $email,"à consentit à la collecte"]);
    }

    public function getUtilisateur($login) {
        $req = self::$bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $req->execute([$login]);
        return $req->fetch();
    }

    public function verifLoginExiste($login) {
        $req = self::$bdd->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $req->execute([$login]);
        return $req->fetch();
    }

    public function estAdmin($login) {
        $req = self::$bdd->prepare("SELECT r.role FROM utilisateurs u INNER JOIN role r ON r.idUtilisateur = u.id  WHERE login = ? AND role = 'Admin'");
        $req->execute([$login]);
        return $req->fetchColumn();
    }
}
