<?php
include_once 'modele_fournisseur.php';
include_once 'vue_fournisseur.php';

class ContFournisseur{
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleFournisseur();
        $this->vue = new VueFournisseur();
    }

    public function formAjouterFournisseur(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == "Gestionnaire"){
            $this->vue->afficherFormAjoutFournisseur();
        }
    }

    public function ajouterFournisseur(){
        if(isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
            if (isset($_SESSION['role']) && $_SESSION['role'] == "Gestionnaire") {
                if (isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["ville"]) && isset($_POST["telephone"])) {
                    $nom = $_POST['nom'];
                    $email = $_POST["email"];
                    $ville = $_POST["ville"];
                    $telephone = $_POST["telephone"];

                    $this->modele->insertFournisseur($nom, $email, $ville, $telephone, $_SESSION['asso']);
                    $this->listerFournisseur();
                } else {
                    $this->formAjouterFournisseur();
                }
            }
        }
        header('Location: index.php?module=fournisseur&action=listerFournisseur');
    }

    public function listerFournisseur(){
        if (isset($_SESSION['asso']) && $_SESSION['role'] === 'Gestionnaire'){

            $listeFournisseur = $this->modele->getListeFournisseur($_SESSION['asso']);
            $produitsBruts = $this->modele->getProduitsFournisseur($_SESSION['asso']);

            $produitsParFournisseur = [];
            foreach ($produitsBruts as $ligne){
                $produitsParFournisseur[$ligne['idFournisseur']][] = $ligne['nomProduit'];
            }

            $produitsNonFournis = [];
            foreach ($listeFournisseur as $fournisseur){
                $produitsNonFournis[$fournisseur['id']] =
                    $this->modele->produitsPasFournitParFournisseur(
                        $_SESSION['asso'],
                        $fournisseur['id']
                    );
            }

            $this->vue->afficherListeFournisseurEtProduits(
                $listeFournisseur,
                $produitsParFournisseur,
                $produitsNonFournis
            );
        }
    }

    public function ajouterProduitFournisseur(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire'){
            $this->modele->insertProduitFournisseur($_POST['idProduit'], $_GET['idFournisseur']);
        }
        $this->listerFournisseur();
    }

    public function supprimerFournisseur(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_GET['id'])){
            $this->modele->deleteFournisseur(
                $_GET['id'] // id du fourniseur lorsque le gestionnaire click sur le btn supp
            );
            $this->listerFournisseur();
        }
    }
    public function unrecognizedAction(){
        $this->vue->actionNonTrouver();
    }
    public function getVue(){
        return $this->vue->afficher();
    }

}

