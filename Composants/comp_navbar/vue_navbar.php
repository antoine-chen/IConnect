<?php

class VueNavbar extends VueGenerique {
    private $contenu;

    public function __construct(){
        parent::__construct();
        $this->contenu = "";
    }

    public function afficherNavbarAdmin(){
        $this->contenu = '
            <nav class="row align-items-center mx-5 border">
                <div class="col">
                    <img src="modules/mod_asso/logos/logo.png" class="logo" alt="">
                </div>
                <div class="col-8 d-flex justify-content-center gap-4">
                    <a href="index.php?module=admin&action=formAssociation">Créer une association</a>
                    <a href="index.php?module=admin&action=listerAssociation">Liste des associations</a>
                </div>
                <div class="col">
                    <a href="index.php?actionComposant=deconnexion" class="btn btn-primary">Se déconnecter</a>
                </div>
            </nav>
        ';
    }
    public function afficherNavbarGestionnaire(){
        $this->contenu = '
            <nav class="row align-items-center mx-5 border">
                <div class="col">
                    <img src="modules/mod_asso/logos/logo.png" class="logo" alt="">
                </div>
                <div class="col-8 d-flex justify-content-center gap-4">
                    <a href="index.php?module=stock&action=stockProduits">Stock</a>
                </div>
                <div class="col">
                    <a href="index.php?actionComposant=deconnexion" class="btn btn-primary">Se déconnecter</a>
                </div>
            </nav>
        ';
    }

    public function afficherNavbarBarman(){
        $this->contenu = '
            <nav class="row align-items-center mx-5 border">
                <div class="col">
                    <img src="modules/mod_asso/logos/logo.png" class="logo" alt="">
                </div>
                <div class="col-8 d-flex justify-content-center gap-4">
                    navbar-item du barman
                </div>
                <div class="col">
                    <a href="index.php?actionComposant=deconnexion" class="btn btn-primary">Se déconnecter</a>
                </div>
            </nav>
        ';
    }

    public function afficherNavbarClient(){
        $this->contenu = '
            <nav class="row align-items-center mx-5 border">
                <div class="col">
                    <img src="modules/mod_asso/logos/logo.png" class="logo" alt="">
                </div>
                <div class="col-8 d-flex justify-content-center gap-4">
                    <a href="index.php?module=compte&action=formRecharger">Recharger</a>
                    <a href="index.php?module=produit&action=listerProduits">Lister les produits</a>
                </div>
                <div class="col">
                    <a href="index.php?actionComposant=deconnexion" class="btn btn-primary">Se déconnecter</a>
                </div>
            </nav>
        ';
    }

    public function afficherNavbarSansRole(){
        $this->contenu = '
           <nav class="row align-items-center mx-5 border">
                <div class="col">
                    <img src="modules/mod_asso/logos/logo.png" class="logo" alt="">
                </div>
                <div class="col-8 d-flex justify-content-center gap-4">
                    <a href="index.php?module=asso&action=afficherAsso">Les associations</a>
                </div>
                <div class="col">
                    <a href="index.php?actionComposant=deconnexion" class="btn btn-primary">Se déconnecter</a>
                </div>
            </nav>
        ';
    }

    public function getAffichage(){
        return $this->contenu;
    }
}
