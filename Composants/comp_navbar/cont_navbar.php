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
        $quitterOuDeconnexion = $this->modele->quitterOuDeconnexion();
        if (isset($_SESSION['role'])){
            if ($_SESSION['role'] == "Client"){
                $this->vue->afficherNavbar(
                    $this->modele->getNavbarClient(),
                    $quitterOuDeconnexion[0]['url'],
                    $quitterOuDeconnexion[0]['action']
                );
            }
            if ($_SESSION['role'] == "Barman"){
                $this->vue->afficherNavbar(
                    $this->modele->getNavbarBarman(),
                    $quitterOuDeconnexion[0]['url'],
                    $quitterOuDeconnexion[0]['action']
                );
            }
            if ($_SESSION['role'] == "Gestionnaire"){
                $this->vue->afficherNavbar(
                    $this->modele->getNavbarGestionnaire(),
                    $quitterOuDeconnexion[0]['url'],
                    $quitterOuDeconnexion[0]['action']
                );
            }
            if ($_SESSION['role'] == "Admin"){
                $this->vue->afficherNavbar(
                    $this->modele->getNavbarAdmin(),
                    $quitterOuDeconnexion[1]['url'],
                    $quitterOuDeconnexion[1]['action']
                );
            }
        } else {
            echo 'je suis sans role, je dois cliquer sur une association';
            $this->vue->afficherNavbar(
                $this->modele->getNavbarSansRole(),
                $quitterOuDeconnexion[1]['url'],
                $quitterOuDeconnexion[1]['action']
            );
        }
    }
    public function getVue(){
        return $this->vue;
    }
}
