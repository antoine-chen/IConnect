<?php
include_once 'cont_connexion.php';

class ModConnexion {
    private $controleur;
    private $actionComposant;

    public function __construct() {
        $this->controleur = new ContConnexion();
        $this->actionComposant = isset($_GET['actionComposant']) ? $_GET['actionComposant'] : '';
        $this->exec();
    }

    public function exec() {
        switch ($this->actionComposant) {
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
            case 'rgpd':
                $this->controleur->avertissementRgpd();
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
