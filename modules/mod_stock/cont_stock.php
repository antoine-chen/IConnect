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
        $idAsso = $_SESSION['asso'];
        $resultat = $this->modele->stockActuel($idAsso);

        $this->vue->boutons();
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