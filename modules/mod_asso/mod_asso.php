<?php

class ModAsso
{
    private $module;

    public function __construct(){
        $mod = isset($_GET['module']) ? $_GET['module'] : 'asso';

        if(isset($_SESSION['role'])) {
            if($_SESSION['role']=='Admin' && $mod == 'asso') {
                $mod = 'admin';
            }
        }

        switch ($mod) {
            case 'produit':
                include_once 'modules/mod_produit/mod_produit.php';
                $this->module = new ModProduit();
                break;
            case 'panier':
                include_once 'modules/mod_panier/mod_panier.php';
                $this->module = new ModPanier();
                break;
            case 'stock':
                include_once 'modules/mod_stock/mod_stock.php';
                $this->module = new ModStock();
                break;
            case 'compte':
                include_once 'modules/mod_compte/mod_compte.php';
                $this->module = new ModCompte();
                break;
            case'commande':
                include_once  'modules/mod_commande/mod_commande.php';
                $this->module = new ModCommande();
                break;
            case 'admin':
                include_once 'modules/mod_admin/mod_admin.php';
                $this->module = new ModAdmin();
                break;
            case 'fournisseur':
                include_once 'modules/mod_fournisseur/mod_fournisseur.php';
                $this->module = new ModFournisseur();
                break;
            case 'asso':
                include_once 'modules/mod_asso/cont_asso.php';
                $this->module = new ContAsso();
                $action = isset($_GET['action']) ? $_GET['action'] : 'afficherAssoInscris';

                switch ($action) {
                    case 'choisiAsso' :
                        $this->module->aChoisitAsso();
                        break;
                    case 'afficherAssoInscris' :
                        $this->module->afficherAssoInscris();
                        break;
                    case 'afficherAssoPasInscris' :
                        $this->module->afficherAssoPasInscris();
                        break;
                    case 'afficherAssoEnAttente':
                        $this->module->afficherAssoEnAttente();
                        break;
                    case 'formAssociation':
                        $this->module->formAssociation();
                        break;
                    case 'ajouterAssociation':
                        $this->module->ajouterAssociation();
                        break;
                }
                break;
            default:
                $this->module = null;
                break;
        }
    }

    public function getAffichage()
    {
        if ($this->module != null) {
            return $this->module->getAffichage();
        } else {
            return $this->module = "module inconnu";
        }
    }
}