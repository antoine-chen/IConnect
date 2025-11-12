<?php
include_once 'vue_connexion.php';
include_once 'modele_connexion.php';

class ContConnexion extends Connexion {
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
        if (isset($_POST['login']) && isset($_POST['mdp'])) {
            $login = $_POST['login'];
            $mdp = $_POST['mdp'];

            if (!empty($login) && !empty($mdp)) {
                if ($this->modele->verifLoginExiste($login)) {
                    $this->vue->message("Ce login existe déjà ");
                } else {
                    $hash = password_hash($mdp, PASSWORD_DEFAULT);
                    $this->modele->ajouterUtilisateur($login, $hash);
                    $this->vue->message("Inscription réussie vous pouvez maintenant vous connecter");
                }
            } else {
                $this->vue->message("Merci de remplir tous les champs");
                $this->vue->form_inscription();
            }
        } else {
            $this->vue->message("Tu dois passer par le formulaire");
            $this->vue->form_inscription();
        }
    }

    public function form_connexion() {
        // si déjà connecté, affiche message
        if (isset($_SESSION['login'])) {
            $this->vue->message("Vous êtes déjà connecté sous l'identifiant <b>" . htmlspecialchars($_SESSION['login']) . "</b>.");
            $this->vue->lien_deconnexion();
        } else {
            $this->vue->form_connexion();
        }
    }

    public function connexion() {
        if (isset($_POST['login']) && isset($_POST['mdp'])) {
            $login = $_POST['login'];
            $mdp = $_POST['mdp'];

            $utilisateur = $this->modele->getUtilisateur($login);

            if ($utilisateur && password_verify($mdp, $utilisateur['mot_de_passe'])) {
                $_SESSION['id'] = $utilisateur['id'];
                $_SESSION['login'] = $utilisateur['login'];
                $_SESSION['role'] = $utilisateur['role'];
                $this->vue->message("Connexion réussie bienvenue, ". htmlspecialchars($login) );
                $this->vue->lien_deconnexion();
            } else {
                $this->vue->message("incorrect");
                $this->vue->form_connexion();
            }
        } else {
            $this->vue->form_connexion();
        }
    }

    public function deconnexion() {
        session_destroy();
        $this->vue->message("Vous avez été déconnecté.");
    }

}
