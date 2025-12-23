<?php
include_once 'cont_landingPage.php';

class ModLandingPage {
    private $controleur;
    private $action;

    public function __construct() {
        $this->controleur = new ContLandingPage();
        $this->action = isset($_GET['action']) ? $_GET['action'] : '';
        $this->exec();
    }

    public function exec(){
        switch ($this->action){
            case 'landingPage':
                $this->controleur->landingPage();
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