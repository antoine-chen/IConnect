<?php
include_once 'modele_produit.php';
include_once 'vue_produit.php';

class ContProduit{
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleProduit();
        $this->vue = new VueProduit();
    }

    /**
     * affiche la liste des produits d'une association
     */
    public function listerProduits (){
        if ($_SESSION['role'] == 'Client'){
            $idAsso = $_SESSION['asso'];
            $listeProduit = $this->modele->getProduits($idAsso);
            $this->vue->afficherProduits($listeProduit);
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

    public function form_ajouterNouveauProduit()
    {
        if($_SESSION['role']=='Gestionnaire') {
            $this->vue->form_ajoutProduit();
        }
    }

    public function ajouterNouveauProduit()
    {
        if($_SESSION['role']=='Gestionnaire') {
            $idAsso = $_SESSION['asso'];

            $nomProduit = $_POST['nom'];
            $prixProduit = $_POST['prix'];

            $this->modele->insertProduit($nomProduit,$prixProduit);
            $idProduit = $this->modele->lastProduitAjoute();

            $this->modele->associerProduitAuAsso($idAsso,$idProduit['id']);

            $extension = pathinfo($_FILES['imageProduit']['name'], PATHINFO_EXTENSION);
            $cheminFichier = 'modules/mod_produit/img_produits/'.$idProduit['id'].'.'.$extension;
            move_uploaded_file($_FILES['imageProduit']['tmp_name'],$cheminFichier);
            $this->modele->ajoutImage($idProduit['id'],$cheminFichier);

            $idInventaire = $this->modele->idInventaire($idAsso);
            $this->modele->ajoutProduitInventaire($idInventaire['id'],$idProduit['id']);
        }
    }

}

