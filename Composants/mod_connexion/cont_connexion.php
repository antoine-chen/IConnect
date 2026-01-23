<?php
include_once 'token.php';
include_once 'vue_connexion.php';
include_once 'modele_connexion.php';

class ContConnexion {
    private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new ModeleConnexion();
        $this->vue = new VueConnexion();
    }
    public function avertissementRgpd(){
        if (!isset($_SESSION['login'])){
            $_SESSION['landing'] = 0;
        $this->vue->avertissementModal();
    }}

    public function form_inscription() {
        if (!isset($_SESSION['login'])){
            $_SESSION['landing'] = 0;
            $this->vue->form_inscription();
        }
        unset($_SESSION['messageOk']);
        unset($_SESSION['messagePasOk']);
    }

    public function inscription() {
        if(isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
            if (isset($_POST['login']) && isset($_POST['pwd']) && isset($_POST['nom'])&& isset($_POST['prenom'])) {
                $login = $_POST['login'];
                $pwd = $_POST['pwd'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $telephone = $_POST['telephone'];
                $email = $_POST['email'];

                if (!$this->modele->verifLoginExiste($login)) {
                    if (empty($_POST['telephone']) && empty($_POST['email'])) {
                        $this->form_inscription();
                    }else {
                        $hash = password_hash($pwd, PASSWORD_DEFAULT);
                        $this->modele->ajouterUtilisateur($login, $hash, $nom, $prenom, $telephone, $email);
                        $_SESSION['messageOk'] = "Insciption success";
                        $this->form_inscription();
                    }
                } else {
                    $this->vue->form_inscription();
                    $_SESSION['messagePasOk'] = "Insciption fail le login ".$_POST['login']. ' existe déjà';
                }
            } else {
                $this->vue->form_inscription();
            }
        }
    }

    public function form_connexion() {
        if (!isset($_SESSION['login'])){
            $_SESSION['landing'] = 0;
            $this->vue->form_connexion();
        }
    }

    public function connexion() {
        if(isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
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
        header('Location: index.php?actionComposant=form_connexion');
        exit();
    }

    public function deconnexion() {
        unset($_SESSION['login']);
        unset($_SESSION['id']);
        unset($_SESSION['asso']);
        unset($_SESSION['role']);
        session_destroy();
    }

    public function getAffichage(){
        return $this->vue->afficher();
    }

}
