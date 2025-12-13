<?php

class VueNavbar extends VueGenerique {
    private $contenu;

    public function __construct(){
        parent::__construct();
        $this->contenu = "";
    }

    public function afficherNavbarAdmin(){
        $this->contenu = '
            <nav>
                <a href="index.php?module=admin&action=formAssociation">Créer une association</a>
                <a href="index.php?module=admin&action=listerAssociation">Liste des associations</a>
                <a href="index.php?actionComposant=deconnexion">Se déconnecter</a></p>;
            </nav>
        ';
    }

    public function afficherNavbarClient(){
        $this->contenu = '
            <nav>
                <a href="index.php?actionComposant=deconnexion">Se déconnecter</a></p>;
            </nav>
        ';
    }
    public function getAffichage(){
        return $this->contenu;
    }
}
