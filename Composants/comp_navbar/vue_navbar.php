<?php

class VueNavbar extends VueGenerique {
    private $contenu;

    public function __construct(){
        parent::__construct();
        $this->contenu = "";
    }

    public function afficherNavbarAdmin(){
        $this->contenu = '
            <nav class="navbar">
                <img src="modules/mod_asso/logos/logo.png" id="logo" alt="">
                <a href="index.php?module=admin&action=formAssociation">Créer une association</a>
                <a href="index.php?module=admin&action=listerAssociation">Liste des associations</a>
                <a href="index.php?actionComposant=deconnexion">Se déconnecter</a>
            </nav>
        ';
    }
    public function afficherNavbarClient(){
        $this->contenu = '
            <nav>
                <img src="modules/mod_asso/logos/logo.png" id="logo" alt="">
                <a href="index.php?module=compte&action=formRecharger">Recharger</a>
                <a href="index.php?actionComposant=deconnexion">Se déconnecter</a>
            </nav>
        ';
    }
    // TODO
    // Modifier cette méthode
    public function afficherNavbarSansRole(){
        $this->contenu = '
            <nav class="navbar">
                <img src="modules/mod_asso/logos/logo.png" id="logo" alt="">
               
                <div class="item-navbar">
                    <a href="index.php?module=compte&action=formRecharger">Recharger</a>
                    <a href="index.php?module=produit&action=listerProduits">Lister les produits</a>
                </div>

                <a href="index.php?actionComposant=deconnexion" class="btn btn-primary">Se déconnecter</a>
            </nav>
        ';
    }
    public function getAffichage(){
        return $this->contenu;
    }
}
