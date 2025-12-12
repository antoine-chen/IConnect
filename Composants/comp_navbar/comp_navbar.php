<?php

include_once 'cont_navbar.php';

class CompNavBar{
    private $controleur;

    public function __construct(){
        $this->controleur = new ContNavbar();
        $this->controleur->navbar();
    }
    public function affiche(){
        echo $this->controleur->getVue()->getAffichage();
    }
}

