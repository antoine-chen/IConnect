<?php
include_once 'cont_commande.php';
class ModCommande{
private $controleur;
private $action;
    public function __construct(){
        $this->controleur =new ContCommande();
        $this->action = isset($_GET['action']) ? $_GET['action'] : '';
        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case 'commandes':
                $this->controleur->commande();
                break;
            case 'details':
                $id =isset($_GET['id']) ? $_GET['id'] : '';
                $this->controleur->details($id);
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