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
            case 'stockProduitBarman':
                $this->controleur->stockProduitBarman();
                break;
            case 'form_inventaire' :
                $this->controleur->form_inventaire();
                break;
            case 'ajoutInventaire' :
                $this->controleur->ajoutInventaire();
                break;
            case 'formChoixInventaireRapport' :
                $this->controleur->formChoixInventaireRapport();
                break;
            case 'ajouterPertes' :
                $this->controleur->ajouterPertes();
                break;
            case 'rapport' :
                $this->controleur->rapport();
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