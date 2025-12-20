<?php
include_once 'modele_panier.php';
include_once 'vue_panier.php';

class ContPanier{
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModelePanier();
        $this->vue = new VuePanier();
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

    /**
     * affiche le panier d'un client dans une association
    */
    public function panier(){
        if ($_SESSION['role'] == 'Client'){
            $idAsso = $_SESSION['asso'];
            $idUtilisateur = $_SESSION['id'];
            $this->vue->afficherPanier(
                $this->modele->getPanier($idAsso, $idUtilisateur)
            );
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}

