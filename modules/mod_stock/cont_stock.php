<?php
include_once 'modele_stock.php';
include_once 'vue_stock.php';

class ContStock {
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleStock();
        $this->vue = new VueStock();
    }



    public function getVue(){
        return $this->vue->afficher();
    }

    public function bienvenue()
    {

    }
}