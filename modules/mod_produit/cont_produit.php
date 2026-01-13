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
     * affiche la liste des produits d'une association [avec un message de selon le cas ex: validation du panier réussie]
     * actualisation du solde de client de l'association
     */
    public function listerProduits (){
        if ($_SESSION['role'] == 'Client' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $idAsso = $_SESSION['asso'];
            $idClient = $_SESSION['id'];
            $loginClient = $_SESSION['login'];
            $_SESSION['soldeClient'] = $this->modele->getSoldeClient($idClient, $idAsso) ? $this->modele->getSoldeClient($idClient, $idAsso) : 0;

            $idInventaire = $this->modele->idInventaire($idAsso);
            $this->vue->afficherProduits(
                $this->modele->getProduits($idAsso,$idInventaire),
                $loginClient,
                $_SESSION['soldeClient']
            );
            unset($_SESSION['messageOk']);
            unset($_SESSION['messagePasOk']);
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

