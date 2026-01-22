<?php

class VueNavbar extends VueGenerique {
    private $contenu;

    public function __construct(){
        parent::__construct();
        $this->contenu = "";
    }

    public function afficherNavbar($listeUrlAction, $lien, $quitterOuDeconnexion){
        $this->contenu = '
    <nav class="navbar navbar-expand-lg px-3">
        <div class="container-fluid">

            <a class="navbar-brand" href="#">
                <img src="modules/mod_asso/logos/logo.png" class="logo" alt="">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarMenu">
                <ul class="navbar-nav gap-3">
    ';

        foreach ($listeUrlAction as $ligne) {
            $this->contenu .= '
            <li class="nav-item">
                <a class="nav-link text-dark" href="'.$ligne['url'].'">
                    '.$ligne['action'].'
                </a>
            </li>
        ';
        }

        $this->contenu .= '
                </ul>
            </div>

            <div class="d-flex">
                <a href="'.$lien.'" class="btn btn-primary">
                    '.$quitterOuDeconnexion.'
                </a>
            </div>

        </div>
    </nav>
    ';
    }


    public function getAffichage(){
        return $this->contenu;
    }
}
