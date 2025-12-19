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
    public function listerProduits (){
        // vérifier le role == Client
        $listeProduit = $this->modele->getProduits();
        $this->vue->afficherProduits($listeProduit);
    }



    public function getVue(){
        return $this->vue->afficher();
    }

}