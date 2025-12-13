<?php
include_once 'modele_admin.php';
include_once 'vue_admin.php';

class ContAdmin{
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleAdmin();
        $this->vue = new VueAdmin();
    }

    public function formAssociation(){
        $this->vue->afficherFormAssociation();
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}
