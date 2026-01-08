<?php
include_once 'cont_fournisseur.php';

class ModFournisseur{
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContFournisseur();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'listerFournisseur';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case 'listerFournisseur':
                $this->controleur->listerFournisseur();
                break;
            default:
                echo "action inconnue";
                break;
        }
    }

    public function getAffichage(){
        return $this->controleur->getVue();
    }
}


