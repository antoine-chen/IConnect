<?php
include_once 'cont_connexion.php';

class ModConnexion {
    private $controleur;
    private $actionMenu;

    public function __construct() {
        $this->controleur = new ContConnexion();
        $this->actionMenu = isset($_GET['actionMenu']) ? $_GET['actionMenu'] : 'menu';
        $this->exec();
    }

    public function exec() {
        switch ($this->actionMenu) {
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
                echo "action inconnue ";
                break;
        }
    }

    public function getAffichage(){
        return $this->controleur->getAffichage();
    }
}
