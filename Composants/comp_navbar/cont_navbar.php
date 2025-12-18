<?php
include_once 'vue_navbar.php';

class ContNavbar {
    private $vue;

    public function __construct(){
        $this->vue = new VueNavbar();
    }
    public function navbar(){
        if (isset($_SESSION['role'])){
            if ($_SESSION['role'] == "Client"){
                echo 'client';
                $this->vue->afficherNavbarClient();
            }
            if ($_SESSION['role'] == "Barman"){
                $this->vue->afficherNavbarBarman();
            }
            if ($_SESSION['role'] == "Gestionnaire"){
                $this->vue->afficherNavbarGestionnaire();
            }
            if ($_SESSION['role'] == "Admin"){
                $this->vue->afficherNavbarAdmin();
            }
        } else {
            echo 'je suis sans role, je dois cliquer sur une association';
            $this->vue->afficherNavbarSansRole();
        }
    }
    public function getVue(){
        return $this->vue;
    }
}
