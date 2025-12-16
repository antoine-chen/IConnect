<?php
include_once "modele_stock.php";
include_once "vue_stock.php";

class ContStock {
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleStock();
        $this->vue = new VueStock();
    }
    
    public function stockProduits(){
        $idAsso = 1;
        $resultat = $this->modele->stockActuel($idAsso);
        if(empty($resultat)) {
            $this->vue->inventaireVide();
        }
        else {
            $this->vue->afficherStockActuel($resultat);
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }
}