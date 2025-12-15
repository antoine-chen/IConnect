<?php
class VueCommande {
    public function afficheListeCommande($quer){
        foreach ($quer as $value) {
            echo '<a href="index.php?module=commande?actionComposant=details?id=' . $value['id'] . '">';
            print $value ['id'] . "\t";
            print  $value ['date'] ."\t";
            print  $value ['status'] . "<br>";
        }
    }
    public function afficheDetailsCommande($quer){
        foreach ($quer as $value) {
            echo $value;
            print $value ['nom'] . "\t";
            print  $value ['quantite'] . "<br>";
        }
    }
}