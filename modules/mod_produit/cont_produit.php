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
                $_SESSION['soldeClient'],
                $idInventaire
            );
            unset($_SESSION['messageOk']);
            unset($_SESSION['messagePasOk']);
        }
    }

    public function form_ajouterNouveauProduit()
    {
        if($_SESSION['role']=='Gestionnaire') {
            $this->vue->form_ajoutProduit();
        }
    }

    public function ajouterNouveauProduit()
    {
        if(isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
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
                $this->modele->ajoutProduitInventaire($idInventaire,$idProduit['id']);
            }
        }
    }

    public function form_modifierProduit()
    {
        if($_SESSION['role']=='Gestionnaire') {
            $produit = $this->modele->getProduit($_GET['id']);
            $this->vue->form_modifierProduit($produit);
        }
    }

    public function modifierProduit()
    {
        if(isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
            if ($_SESSION['role'] == 'Gestionnaire') {
                $idAsso = $_SESSION['asso'];
                $idProduit = $_GET['id'];
                $nom = $_POST['nom'];
                $prix = $_POST['prix'];

                $this->modele->updateProduit($idProduit, $nom, $prix);

                if (!empty($_FILES['image']['tmp_name'])) {
                    $ancienProduit = $this->modele->getProduit($idProduit);
                    $ancienChemin = $ancienProduit['image'];
                    unlink($ancienChemin);

                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $cheminNouveauFichier = 'modules/mod_produit/img_produits/' . $idProduit . '.' . $extension;
                    move_uploaded_file($_FILES['image']['tmp_name'], $cheminNouveauFichier);

                    $this->modele->ajoutImage($idProduit, $cheminNouveauFichier);
                    $idInventaire = $this->modele->idInventaire($idAsso);
                    $this->modele->ajoutProduitInventaire($idInventaire, $idProduit);
                }
            }
        }
    }

    public function listerProduitsFournisseur(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire'){
            $listeFournisseur = $this->modele->getListeFournisseur($_SESSION['asso']);
            $produitsBruts = $this->modele->getProduitsFournisseur($_SESSION['asso']);

            $this->vue->afficherListeProduitsFournisseur(
                $listeFournisseur,
                $produitsBruts
            );
        }
    }

    public function restockerProduit(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire'){
            $idProduit = $_GET['id'];
            $quantite = $_POST['quantite'];
            $this->modele->insertRestock($_SESSION['id'], $idProduit, $_POST['quantite'], $_SESSION['asso'], $_GET['idFournisseur']);
            $this->modele->updateLigneInventaire(
                $this->modele->idInventaire($_SESSION['asso']),
                $idProduit,
                $quantite
            );
        }
        header('Location: index.php?module=produit&action=listerProduitsFournisseur');
        exit();
    }

    public function getVue(){
        return $this->vue->afficher();
    }
}

