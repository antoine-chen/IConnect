<?php
include_once 'cont_produit.php';

class ModProduit{
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContProduit();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'listerProduitss';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case "listerProduits":
                $this->controleur->listerProduits();
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