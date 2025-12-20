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
     * affiche le panier d'un client dans une association
    */
    public function panier(){
        if ($_SESSION['role'] == 'Client'){
            $idAsso = $_SESSION['asso'];
            $idUtilisateur = $_SESSION['id'];
            $addition = $this->modele->getPanierAddition($idAsso, $idUtilisateur)>0 ? $this->modele->getPanierAddition($idAsso, $idUtilisateur) : 0;
            $this->vue->afficherPanier(
                $this->modele->getPanier($idAsso, $idUtilisateur),
                $addition
            );
        }
    }

    /**
     * ajoute un produit dans le panier du client de l'association
     * cas 1 -> je n'ai pas de panier -> INSERT panier + INSERT lignePanier
     * cas 2 -> j'ai un panier + j'ai jamais ajoute ce produit dans lignePanier -> INSERT lignePanier
     * cas 3 -> j'ai un panier + j'ai deja ajouté ce produit dans lignePanier -> UPDATE lignePanier
    */
    public function ajouterDansPanier(){
        if (isset($_GET['id']) && $_SESSION['role'] == 'Client'){
            $idProduit = $_GET['id']; // id produit que le client a cliqué
            $idAsso = $_SESSION['asso'];
            $idUtilisateur = $_SESSION['id'];

            if ($this->modele->existeProduit($idProduit)){
                $idPanier = $this->modele->getIdPanier($idAsso, $idUtilisateur);
                if (!$idPanier){
                    $this->modele->insertPanier($idAsso, $idUtilisateur);
                    $idPanier = $this->modele->getIdPanier($idAsso, $idUtilisateur);
                    $this->modele->insertLignePanier($idPanier, $idProduit, 1); // click btn ajouter = 1 produit
                }else {
                    if ($this->modele->dejaAjouter($idPanier, $idProduit)){
                        $this->modele->updateLignePanier($idPanier, $idProduit);
                    } else {
                        $this->modele->insertLignePanier($idPanier, $idProduit, 1);
                    }
                }
            }
        }
    }

    public function validerPanier(){
        if ($_SESSION['role'] == 'Client'){
            $idUtilisateur = $_SESSION['id'];
            $idAsso = $_SESSION['asso'];
            $soldeUtilisateur = $this->modele->getSoldeUtilisateur($idUtilisateur, $idAsso) ? $this->modele->getSoldeUtilisateur($idUtilisateur, $idAsso) : 0;
            $addition = $this->modele->getPanierAddition($idAsso, $idUtilisateur) ? $this->modele->getPanierAddition($idAsso, $idUtilisateur) : 0;

            if ($addition > 0 && $soldeUtilisateur >= $addition){
                $this->modele->updateSoldeUtilisateur($idUtilisateur, $idAsso, $addition);
                // TODO insert dans la table commande et ligneCommande
                // TODO enlever le stock (panier)
                // TODO vider table panier et lignePanier
            }
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}

