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


