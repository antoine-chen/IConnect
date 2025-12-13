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
            </nav>
        ';
    }
    public function getAffichage(){
        return $this->contenu;
    }
}
