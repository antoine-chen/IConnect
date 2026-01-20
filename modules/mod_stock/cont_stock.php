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
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
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
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $idAsso = $_SESSION['asso'];
            $resultat = $this->modele->listeProduitsAsso($idAsso);

            $this->vue->form_inventaire($resultat);
        }
    }

    public function ajoutInventaire()
    {
        if (isset($_SESSION['role']) && isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
            if ($_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])) {
                $idAsso = $_SESSION['asso'];
                $stockProduits = $_POST['stock'];

                $this->modele->creerInventaire($idAsso);
                $idNewInventaire = $this->modele->idInventaire($idAsso);

                foreach ($stockProduits as $idProduit => $quantiteProduit) {
                    $this->modele->ajouterProduit($idNewInventaire, $idProduit, $quantiteProduit);
                }
            }
            header("Location: index.php?module=stock");
            exit();
        }
    }

    public function formChoixInventaireRapport()
    {
        if ($_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $listeInventaire = $this->modele->getListeInventaires($_SESSION['asso']);
            $this->vue->afficherChoixInventaireRapport($listeInventaire);
        }
    }

    public function rapport()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $idInventaire = isset($_POST['idinventaire']) ? $_POST['idinventaire'] : $this->modele->idInventaire($_SESSION['asso']);
            $dateInventaire = $this->modele->getDateInventaire($idInventaire);
            $valeursTresorerie = $this->modele->getTresorerie($idInventaire, $_SESSION['asso'], $dateInventaire);
            $this->vue->afficherRapport($valeursTresorerie);
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }
}