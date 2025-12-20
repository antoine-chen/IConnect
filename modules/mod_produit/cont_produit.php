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

}

