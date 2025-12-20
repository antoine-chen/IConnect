<?php
include_once 'cont_panier.php';

class ModPanier{
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContPanier();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'panier';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case "panier":
                $this->controleur->panier();
                break;
            case "ajouterDansPanier":
                $this->controleur->ajouterDansPanier();
                break;
            case "validerPanier":
                $this->controleur->validerPanier();
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


