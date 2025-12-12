<?php
include_once 'vue_navbar.php';

class ContNavbar {
    private $vue;

    public function __construct(){
        $this->vue = new VueNavbar();
    }
    public function navbar(){
        if (isset($_SESSION['login'])){
            if (isset($_SESSION['role']) == 'Admin'){
                $this->vue->afficherNavbarAdmin();
            }
        }
    }
    public function getVue(){
        return $this->vue;
    }
}
