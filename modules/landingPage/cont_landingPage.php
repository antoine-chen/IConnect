<?php
include_once 'vue_landingPage.php';
class ContLandingPage {
    private $vue;

    public function __construct(){
        $this->vue = new VueLandingPage();
    }

    public function landingPage(){
        if ($_SESSION['landing'] == 1){
            $this->vue->afficherlandingPage();
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }
}