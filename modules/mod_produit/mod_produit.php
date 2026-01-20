<?php
include_once 'cont_produit.php';

class ModProduit{
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContProduit();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'listerProduits';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case "listerProduits":
                $this->controleur->listerProduits();
                break;
            case "form_ajouterNouveauProduit" :
                $this->controleur->form_ajouterNouveauProduit();
                break;
            case "ajouterNouveauProduit" :
                $this->controleur->ajouterNouveauProduit();
                break;
            case "form_modifierProduit" :
                $this->controleur->form_modifierProduit();
                break;
            case "modifierProduit" :
                $this->controleur->modifierProduit();
                break;
            case "listerProduitsFournisseur":
                $this->controleur->listerProduitsFournisseur();
                break;
            case "restockerProduit":
                $this->controleur->restockerProduit();
                break;
            default:
                echo "action inconnue";
                break;
        }
    }

    public function test()
    {
        echo '
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm">
        Supprimer
    </button>
        ';
    }
    public function getAffichage(){
        return $this->controleur->getVue();
    }
}


