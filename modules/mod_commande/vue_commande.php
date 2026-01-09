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
        echo'<div class="d-flex flex-column align-items-center ">';
        foreach ($quer as $value1){
            if($value1 ['statut'] == "Encours") {
                echo '<div class="row border rounded-3">'
                    . '<p class="card-title">' . htmlspecialchars('id commande: ' . $value1['id']) . '</p>' .
                    '<div class="col-6">' .
                    htmlspecialchars('date: ' . $value1 ['date']) .
                    '<p class="card-title">' . htmlspecialchars('satuts de la commande: ' . $value1 ['statut']) . '</p>'
                    . '</div>' .
                    '<div class="col-1">' . '</div>';
                foreach ($details as $value2) {
                    if ($value2['idCommande'] == $value1['id'] && $value2['date'] == $value1['date']) {
                        echo htmlspecialchars($value2 ['nom']) . htmlspecialchars('|quantité:' . $value2['quantite']) . htmlspecialchars('|prix: ' . $value2['prix']) . '</br>';
                    }
                }
                echo '</div>';
            }
        }
        echo'</div>';

    }
    public function afficher() {
        return $this->getAffichage();
    }
}