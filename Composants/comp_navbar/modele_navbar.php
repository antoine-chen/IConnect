<?php

class ModeleNavbar extends Modele{

    public function getNavbarClient(){
        return array(
            array("url" => "index.php?module=compte&action=profil", "action" => "Profil"),
            array("url" => "index.php?module=compte&action=formRecharger", "action" => "Recharger"),
            array("url" => "index.php?module=produit&action=listerProduits", "action" => "Lister les produits"),
            array("url" => "index.php?module=panier&action=panier", "action" => "Panier"),
            array("url" => "index.php?module=commande&action=historiqueCommandeClient", "action" => "Historique")
        );
    }

    public function getNavbarBarman(){
        return array(
            array("url" => "index.php?module=compte&action=profil", "action" => "Profil"),
            array("url" => "index.php?module=commande&action=commandeAvancee", "action" => "Commandes du jour"),
            array("url" => "index.php?module=commande&action=historique", "action" => "Historique"),
            array("url" => "index.php?module=stock&action=stockProduitBarman", "action" => "Stock")
        );
    }

    public function getNavbarGestionnaire(){
        return array(
            array("url" => "index.php?module=compte&action=profil", "action" => "Profil"),
            array("url" => "index.php?module=stock&action=stockProduits", "action" => "Stock"),
            array("url" => "index.php?module=admin&action=gestionCompte", "action" => "Gestion comptes"),
            array("url" => "index.php?module=fournisseur&action=listerFournisseur", "action" => "Liste des fournisseurs"),
            array("url" => "index.php?module=admin&action=listerDemandeUtilisateur", "action" => "Demande"),
            array("url" => "index.php?module=stock&action=formChoixInventaireRapport", "action" => "Rapports"),
            array("url" => "index.php?module=produit&action=listerProduitsFournisseur", "action" => "Restocker"),
            array("url" => "index.php?module=commande&action=historiqueCommandeFournisseur", "action" => "Historique des restocks"),
            array("url" => "index.php?module=commande&action=historiqueCommandeAsso", "action" => "Commandes clients"),
        );
    }

    public function getNavbarAdmin(){
        return array(
            array("url" => "index.php?module=compte&action=profil", "action" => "Profil"),
            array("url" => "index.php?module=admin&action=listeDemandeCreationAsso", "action" => "Demandes de création d'associations"),
            array("url" => "index.php?module=admin&action=listerAssociation", "action" => "Liste des associations")
        );
    }

    public function getNavbarSansRole(){
        return array(
            array("url" => "index.php?module=asso&action=afficherAssoInscris", "action" => "Mes associations"),
            array("url" => "index.php?module=asso&action=afficherAssoPasInscris", "action" => "Toutes les associations"),
            array("url" => "index.php?module=asso&action=afficherAssoInscriptionEnAttente", "action" => "En attente d'inscription"),
            array("url" => "index.php?module=asso&action=afficherAssoCreationEnAttente", "action" => "Demandes de création en attente"),
            array("url" => "index.php?module=asso&action=formAssociation", "action" => "Créer une association"),
        );
    }

    public function getNavbarLandingPage(){
        return array(
            array("url" => "#accueil", "action" => "Accueil"),
            array("url" => "#produits", "action" => "Produits"),
            array("url" => "#fonctionnalités", "action" => "Fonctionnalités")
        );
    }

    public function acces(){
        return array(
            array("url" => "index.php?module=asso&action=afficherAssoInscris", "action" => "Quitter" ),
            array("url" => "index.php?actionComposant=deconnexion", "action" => "Se déconnecter" ),
            array("url" => "index.php?actionComposant=form_connexion", "action" => "Se connecter" )
        );
    }

}
