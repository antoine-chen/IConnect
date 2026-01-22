<?php
include_once 'vue_landingPage.php';
class ContLandingPage {
    private $vue;

    public function __construct(){
        $this->vue = new VueLandingPage();
    }

    public function landingPage(){
        $this->vue->afficherlandingPage();
    }
    public function unrecognizedAction(){
        $this->vue->actionNonTrouver();
    }
    public function getVue(){
        return $this->vue->afficher();
    }
}