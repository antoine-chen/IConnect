<?php
include_once 'cont_compte.php';

class ModCompte{
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContCompte();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'formRecharger';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case 'formRecharger':
                $this->controleur->formRecharger();
                break;
            case 'recharger':
                $this->controleur->recharger();
                break;
            case 'profil':
                $this->controleur->profil();
                break;
            case 'formModifierProfil':
                $this->controleur->formModifierProfil();
                break;
            case 'modifierProfil':
                $this->controleur->modifierProfil();
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


