<?php
include_once 'modele_navbar.php';
include_once 'vue_navbar.php';

class ContNavbar {
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleNavbar();
        $this->vue = new VueNavbar();
    }

    /**
     * gestion de la navbar
     * regarde si connecter à une association
     * si oui affiche la navbar selon le role (tableau 2 dimensions dans le modele)
     * sinon affiche la navbar (sans role)
     */
    public function navbar(){
        $acces = $this->modele->acces();
        if (!isset($_SESSION['login'])){
            $this->vue->afficherNavbar(
                $this->modele->getNavbarLandingPage(),
                $acces[2]['url'],
                $acces[2]['action']
            );
        } else {
            if (isset($_SESSION['role'])){
                if ($_SESSION['role'] == "Client"){
                    $this->vue->afficherNavbar(
                        $this->modele->getNavbarClient(),
                        $acces[0]['url'],
                        $acces[0]['action']
                    );
                }
                if ($_SESSION['role'] == "Barman"){
                    $this->vue->afficherNavbar(
                        $this->modele->getNavbarBarman(),
                        $acces[0]['url'],
                        $acces[0]['action']
                    );
                }
                if ($_SESSION['role'] == "Gestionnaire"){
                    $this->vue->afficherNavbar(
                        $this->modele->getNavbarGestionnaire(),
                        $acces[0]['url'],
                        $acces[0]['action']
                    );
                }
                if ($_SESSION['role'] == "Admin"){
                    $this->vue->afficherNavbar(
                        $this->modele->getNavbarAdmin(),
                        $acces[1]['url'],
                        $acces[1]['action']
                    );
                }
            } else {
                echo 'je suis sans role, je dois cliquer sur une association';
                $this->vue->afficherNavbar(
                    $this->modele->getNavbarSansRole(),
                    $acces[1]['url'],
                    $acces[1]['action']
                );
            }
        }

    }
    public function getVue(){
        return $this->vue;
    }
}
