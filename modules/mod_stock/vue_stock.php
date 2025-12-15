<?php
class VueStock extends VueGenerique{
    public function __construct(){
        parent::__construct();
    }



    public function afficher() {
        return $this->getAffichage();
    }
}