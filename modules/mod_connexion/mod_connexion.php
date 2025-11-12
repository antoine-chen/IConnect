<?php
include_once 'cont_connexion.php';

class ModConnexion {
    private $controleur;
    private $action;

    public function __construct() {
        $this->controleur = new ContConnexion();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'form_connexion';
        $this->exec();
    }

    public function exec() {
        switch ($this->action) {
            case 'menu':
                $this->controleur->menu();
                break;
            case 'form_inscription':
                $this->controleur->form_inscription();
                break;
            case 'inscription':
                $this->controleur->inscription();
                break;
            case 'form_connexion':
                $this->controleur->form_connexion();
                break;
            case 'connexion':
                $this->controleur->connexion();
                break;
            case 'deconnexion':
                $this->controleur->deconnexion();
                break;
            default:
                echo "action inconnue";
        }
    }
}
