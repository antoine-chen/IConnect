<?php
include_once "vue_generique.php";
class VueCommande extends VueGenerique {
    public function __construct(){
        parent::__construct();
    }
    //afiche toutes les commandes d'une association
    public function afficheListeCommande($quer){
        foreach ($quer as $value) {
            echo '<a href="index.php?module=commande&action=details&id=' . $value['id'] . '">' .
                $value ['id'] .
            $value ['date'] .
            $value ['statut'];

        }
    }

    //affiche les details d'une commande
    public function afficheDetailsCommande($quer){
        foreach ($quer as $value) {
            echo $value ['nom'] . $value ['quantite'];
        }
    }
    //afiche les commande avec le details
    public function afficheCommandeComplete($quer,$details){
        foreach ($quer as $value1){
            echo $value1 ['id'] .
                $value1 ['date'] .
              $value1 ['statut'];
            foreach ($details as $value2){
                if($value2['idCommande']==$value1['id']){
                echo $value2 ['nom'] .$value2['quantite'] .$value2['prix'];
                }
            }
        }

    }
    public function afficher() {
        return $this->getAffichage();
    }
}