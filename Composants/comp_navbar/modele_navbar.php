<?php

class ModeleNavbar{

    public function getNavbarClient(){
        return array(
            array("url" => "index.php?module=compte&action=formRecharger", "action" => "Recharger"),
            array("url" => "index.php?module=produit&action=listerProduits", "action" => "Lister les produits"),
            array("url" => "index.php?module=panier&action=panier", "action" => "Panier")
        );
    }

    public function getNavbarBarman(){
        return array(
            array("url" => "index.php?module=commande&action=commandes", "action" => "Commandes")
        );
    }

    public function getNavbarGestionnaire(){
        return array(
            array("url" => "index.php?module=stock&action=stockProduits", "action" => "Stock"),
            array("url" => "index.php?module=admin&action=formAjouterGestionnaireOuBarman", "action" => "Ajouter barman")
        );
    }

    public function getNavbarAdmin(){
        return array(
            array("url" => "index.php?module=admin&action=formAssociation", "action" => "Créer une association"),
            array("url" => "index.php?module=admin&action=listerAssociation", "action" => "Liste des associations")
        );
    }

    public function getNavbarSansRole(){
        return array(
            array("url" => "index.php?module=asso&action=afficherAssoInscris", "action" => "Les associations"),
            array("url" => "index.php?module=asso&action=afficherAssoPasInscris", "action" => "Toutes les associations")

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
            array("url" => "index.php?module=asso&action=afficherAsso", "action" => "Quitter" ),
            array("url" => "index.php?actionComposant=deconnexion", "action" => "Se déconnecter" ),
            array("url" => "index.php?actionComposant=form_connexion", "action" => "Se connecter" )
        );
    }

}
