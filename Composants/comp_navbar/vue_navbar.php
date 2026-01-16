<?php

class VueNavbar extends VueGenerique {
    private $contenu;

    public function __construct(){
        parent::__construct();
        $this->contenu = "";
    }

    public function afficherNavbar($listeUrlAction, $lien, $quitterOuDeconnexion){
        $this->contenu = '
            <nav class="row align-items-center m-3 p-3">
                <div class="col d-flex justify-content-center align-items-center">
                    <img src="modules/mod_asso/logos/logo.png" class="logo" alt="">
                </div>
                <div class="col-8 d-flex justify-content-center gap-4">';

        foreach ($listeUrlAction as $ligne) {
            $this->contenu .= '<a href="' . $ligne['url'] . '">' . $ligne['action'] . '</a>';
        }

        $this->contenu .= '
                </div>
                <div class="col">
                    <a href="'. $lien .'" class="btn btn-primary"> '.$quitterOuDeconnexion.'</a>
                </div>
            </nav>
        ';
    }

    public function getAffichage(){
        return $this->contenu;
    }
}
