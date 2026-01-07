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

        $this->vue->boutons($idAsso);
        if(empty($resultat)) {
            $this->vue->inventaireVide();
        }
        else {
            $this->vue->afficherStockActuel($resultat);
        }
    }

    public function form_inventaire()
    {
        $idAsso = $_SESSION['asso'];
        $resultat = $this->modele->stockActuel($idAsso);

        $this->vue->form_inventaire($idAsso,$resultat);
    }

    public function getVue(){
        return $this->vue->afficher();
    }

    public function ajoutInventaire()
    {
        $idAsso = $_SESSION['asso'];
        $stockProduits = $_POST['stock'];
        $this->modele->creerInventaire($idAsso);
        $idInventaire = $this->modele->idInventaire($idAsso);
        foreach ($stockProduits as $idProduit => $quantiteProduit) {
            $this->modele->ajouterProduit($idInventaire,$idProduit,$quantiteProduit);
        }
    }
}