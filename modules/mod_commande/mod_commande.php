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
                //affiche les details d'une commande //todo d'une seule association
            case 'details':
                $this->controleur->details();
                break;

            case 'commandesComplete':
                $this->controleur->commandeAvancée();
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