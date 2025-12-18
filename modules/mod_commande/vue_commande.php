<?php
include_once "vue_generique.php";
class VueCommande extends VueGenerique {
    public function __construct(){
        parent::__construct();
    }

    public function afficheListeCommande($quer){
        foreach ($quer as $value) {
            echo '<a href="index.php?module=commande&action=details&id=' . $value['id'] . '">';
            print $value ['id'] . "\t";
            print  $value ['date'] ."\t";
            print  $value ['statut']."<br>";
            print '-----------------------------------------------------'."<br>";
        }
    }
    public function afficheDetailsCommande($quer){
        foreach ($quer as $value) {
            print $value ['nom'] . "\t";
            print  $value ['quantite'] . "<br>";
        }
    }
    public function afficher() {
        return $this->getAffichage();
    }
}