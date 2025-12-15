<?php
include_once 'cont_stock.php';
class ModStock {
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContStock();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'bienvenue';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case "bienvenue":
                $this->controleur->bienvenue();
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