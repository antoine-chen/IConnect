<?php
include_once 'vue_connexion.php';
include_once 'modele_connexion.php';

class ContConnexion {
    private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new ModeleConnexion();
        $this->vue = new VueConnexion();
    }

    public function menu(){
        $this->vue->menu();
    }

    public function form_inscription() {
        $this->vue->form_inscription();
    }

    public function inscription() {
        if (isset($_POST['login']) && isset($_POST['pwd'])) {
            $login = $_POST['login'];
            $pwd = $_POST['pwd'];

            if (!empty($login) && !empty($pwd)) {
                if (!$this->modele->verifLoginExiste($login)) {
                    $hash = password_hash($pwd, PASSWORD_DEFAULT);
                    $this->modele->ajouterUtilisateur($login, $hash);
                }
            } else {
                $this->vue->form_inscription();
            }
        } else {
            $this->vue->form_inscription();
        }
    }

    public function form_connexion() {
            $this->vue->form_connexion();
    }

    public function connexion() {
        if (isset($_POST['login']) && isset($_POST['pwd'])) {
            $login = $_POST['login'];
            $pwd = $_POST['pwd'];

            $utilisateur = $this->modele->getUtilisateur($login);

            if ($utilisateur && password_verify($pwd, $utilisateur['pwd'])) {
                $_SESSION['id'] = $utilisateur['id'];
                $_SESSION['login'] = $utilisateur['login'];
                $_SESSION['id'] = $utilisateur['id'];
                if ($this->modele->estAdmin($login)) $_SESSION['role'] = $this->modele->estAdmin($login);
            } else {
                $this->vue->form_connexion();
            }
        } else {
            $this->vue->form_connexion();
        }
    }

    public function deconnexion() {
        unset($_SESSION['login']);
        session_destroy();
        $this->menu();
    }

    public function getAffichage()
    {
        return $this->vue->afficher();
    }

}
