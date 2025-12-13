<?php
include_once 'vue_navbar.php';

class ContNavbar {
    private $vue;

    public function __construct(){
        $this->vue = new VueNavbar();
    }
    public function navbar(){
        if (isset($_SESSION['login'])){
            $this->vue->afficherNavbarAdmin();
        }
    }
    public function getVue(){
        return $this->vue;
    }
}
