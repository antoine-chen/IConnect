<?php

include_once 'vue_commande.php';
include_once 'modele_commande.php';

class ContCommande {
    private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new ModeleCommande();
        $this->vue = new VueCommande();
    }

    public function commande(){
        $this->vue->afficheListeCommande($this->modele->toutesLesCommandes());
    }
    public function details($id){
        $this->vue->afficheDetailsCommande($this->modele->derouléCommande($id));
    }

    public function getVue()
    {
        return $this->vue->afficher();
    }

}