<?php
include_once 'cont_panier.php';

class ModPanier{
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContPanier();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'listerProduits';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case "listerProduits":
                $this->controleur->listerProduits();
                break;
            case "panier":
                $this->controleur->panier();
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


