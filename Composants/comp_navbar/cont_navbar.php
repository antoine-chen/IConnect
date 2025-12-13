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
                // navbar du client
                echo "client";
            }
            if ($_SESSION['role'] == "Barman"){
                // navbar du barman
                echo "barman";
            }
            if ($_SESSION['role'] == "Gestionnaire"){
                // navbar du gestionnaire
                echo "gestionnaire";
            }
            if ($_SESSION['role'] == "Admin"){
                $this->vue->afficherNavbarAdmin();
            }
        } else {
            echo 'je suis sans role, je dois cliquer sur une association';
            $this->vue->afficherNavbarClient();
        }
    }
    public function getVue(){
        return $this->vue;
    }
}
