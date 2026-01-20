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
            $idInventaire = $this->modele->idInventaire($idAsso);
            $resultat = $this->modele->stockActuel($idInventaire);

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

    public function ajoutInventaire()
    {
        if (isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
            if ($_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])) {
                $idAsso = $_SESSION['asso'];
                $stockProduits = $_POST['stock'];

                $idOldInventaire = $this->modele->idInventaire($idAsso);
                $this->modele->creerInventaire($idAsso);
                $idNewInventaire = $this->modele->idInventaire($idAsso);

                foreach ($stockProduits as $idProduit => $quantiteProduit) {
                    if ($idOldInventaire !== null) {
                        $this->modele->ajouterStockReel($idOldInventaire, $idProduit, $quantiteProduit);
                    }
                    $this->modele->ajouterProduit($idNewInventaire, $idProduit, $quantiteProduit);
                }
            }
            header("Location: index.php?module=stock");
            exit();
        }
    }

}