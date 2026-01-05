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
        if (!isset($_SESSION['login'])){
            $_SESSION['landing'] = 0;
            $this->vue->form_inscription();
        }
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
        if (!isset($_SESSION['login'])){
            $_SESSION['landing'] = 0;
            if ($_SESSION['landing'] == 0){
                $this->vue->form_connexion();
            }
        }
    }

    public function connexion() {
        if (isset($_POST['login']) && isset($_POST['pwd'])) {
            $login = $_POST['login'];
            $pwd = $_POST['pwd'];

            $utilisateur = $this->modele->getUtilisateur($login);

            if ($utilisateur && password_verify($pwd, $utilisateur['pwd'])) {
                $_SESSION['id'] = $utilisateur['id'];
                $_SESSION['login'] = $utilisateur['login'];
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
        unset($_SESSION['id']);
        unset($_SESSION['asso']);
        unset($_SESSION['role']);
        $_SESSION['landing'] = 1;
    }

    public function getAffichage(){
        return $this->vue->afficher();
    }

}
