<?php
include_once "vue_generique.php";

class VueAsso extends VueGenerique {
    public function __construct()
    {
        parent::__construct();
    }

    public function afficher() {
        return $this->getAffichage();
    }
}