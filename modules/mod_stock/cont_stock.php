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
        if ($_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $idAsso = $_SESSION['asso'];
            $resultat = $this->modele->stockActuel($idAsso);

            if(empty($resultat)) {
                $this->vue->inventaireVide();
            }
            else {
                $this->vue->afficherStockActuel($resultat);
            }
            $this->vue->boutons();

        }
    }

    public function form_inventaire() {
        if ($_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $idAsso = $_SESSION['asso'];
            $resultat = $this->modele->listeProduitsAsso($idAsso);

            $this->vue->form_inventaire($resultat);
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

    public function ajoutInventaire() {
        if ($_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $idAsso = $_SESSION['asso'];
            $stockProduits = $_POST['stock'];
            $this->modele->creerInventaire($idAsso);
            $idInventaire = $this->modele->idInventaire($idAsso);
            foreach ($stockProduits as $idProduit => $quantiteProduit) {
                $this->modele->ajouterProduit($idInventaire['id'],$idProduit,$quantiteProduit);
            }
        }
    }
}