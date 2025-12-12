<?php
class ModLandingPage {
    public function __construct() {
        $this->controleur = new ContConnexion();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'menu';
        $this->exec();
    }

    public function exec()
    {

    }
}