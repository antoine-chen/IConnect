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
            $nbProduis = $this->modele->getNbProduitsDansPanier($_SESSION['asso'], $_SESSION['id']) ? $this->modele->getNbProduitsDansPanier($_SESSION['asso'], $_SESSION['id']) : 0;

                $this->vue->afficherProduits(
                $this->modele->getProduits($idAsso,$idInventaire),
                $loginClient,
                $_SESSION['soldeClient'],
                $nbProduis
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

                $extensionsImagesAutorisees = ['jpg', 'jpeg', 'png', 'webp'];
                $extension = strtolower(pathinfo($_FILES['imageProduit']['name'], PATHINFO_EXTENSION));

                if (in_array($extension, $extensionsImagesAutorisees)) {
                    $cheminFichier = 'modules/mod_produit/img_produits/'.$idProduit['id'].'.'.$extension;
                    move_uploaded_file($_FILES['imageProduit']['tmp_name'], $cheminFichier);
                    $this->modele->ajoutImage($idProduit['id'], $cheminFichier);

                    $idInventaire = $this->modele->idInventaire($idAsso);
                    $this->modele->ajoutProduitInventaire($idInventaire,$idProduit['id']);
                    $_SESSION['messageOk'] = 'Ajout success';
                } else {
                    $this->modele->deleteProduit($idProduit['id']);
                    $this->modele->deleteProduitBoutique($idAsso, $idProduit['id']);
                }
            }
        }
        header('Location: index.php?module=stock');
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
                    $extensionsImagesAutorisees = ['jpg', 'jpeg', 'png', 'webp'];
                    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

                    if (in_array($extension, $extensionsImagesAutorisees)) {
                        $ancienProduit = $this->modele->getProduit($idProduit);
                        $ancienChemin = $ancienProduit['image'];
                        unlink($ancienChemin);

                        $cheminNouveauFichier = 'modules/mod_produit/img_produits/' . $idProduit . '.' . $extension;
                        move_uploaded_file($_FILES['image']['tmp_name'], $cheminNouveauFichier);

                    $this->modele->ajoutImage($idProduit, $cheminNouveauFichier);
                    $idInventaire = $this->modele->idInventaire($idAsso);
                    $this->modele->ajoutProduitInventaire($idInventaire, $idProduit);
                    }
                }
                $_SESSION['messageOk'] = 'Modification du produit '.$nom;
            }else {
                $_SESSION['messagePasOk'] = 'Modification fail ';
            }
        }
        header('Location: index.php?module=stock');
        exit();
    }

    public function listerProduitsFournisseur(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire'){
            $listeFournisseur = $this->modele->getListeFournisseur($_SESSION['asso']);
            $produitsBruts = $this->modele->getProduitsFournisseur($_SESSION['asso']);

            if(empty($listeFournisseur) && empty($produitsBruts)) {
                $this->vue->titreProduitsVide();
            }
            else {
                $this->vue->afficherListeProduitsFournisseur(
                    $listeFournisseur,
                    $produitsBruts
                );
            }
        }
        unset($_SESSION['messageOk']);
        unset($_SESSION['messagePasOk']);
    }

    public function restockerProduit(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_POST['quantite']) && isset($_GET['id'])){
            $idProduit = $_GET['id'];
            $quantite = $_POST['quantite'];
            $this->modele->insertRestock($_SESSION['id'], $idProduit, $_POST['quantite'], $_SESSION['asso'], $_GET['idFournisseur']);
            $this->modele->updateLigneInventaire(
                $this->modele->idInventaire($_SESSION['asso']),
                $idProduit,
                $quantite
            );
            $_SESSION['messageOk'] = "Restock success";
        }else {
            $_SESSION['messagePasOk'] = "Restock fail";
        }
        header('Location: index.php?module=produit&action=listerProduitsFournisseur');
        exit();
    }
    public function unrecognizedAction(){
        $this->vue->actionNonTrouver();
    }
    public function getVue(){
        return $this->vue->afficher();
    }
}

