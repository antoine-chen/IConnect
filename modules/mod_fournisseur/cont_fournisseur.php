<?php
include_once 'modele_fournisseur.php';
include_once 'vue_fournisseur.php';

class ContFournisseur{
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleFournisseur();
        $this->vue = new VueFournisseur();
    }

    public function listerFournisseur(){
        if (isset($_SESSION['asso']) && $_SESSION['role'] == 'Gestionnaire'){
            $this->vue->afficherListeFournisseur(
                $this->modele->getListeFournisseur($_SESSION['asso'])
            );
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}

