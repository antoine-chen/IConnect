<?php
include_once "cont_stock.php";
class ModStock {
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContStock();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'stockProduits';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case 'stockProduits':
                $this->controleur->stockProduits();
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