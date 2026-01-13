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

}

