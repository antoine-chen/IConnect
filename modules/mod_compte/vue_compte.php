<?php
include_once "vue_generique.php";
class VueCompte extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherFormRecharger(){
        echo '
            <h2>Recharger son compte</h2>
            <form method="post" action="index.php?module=compte&action=recharger">
               <label>Le montant à recharger</label>
               <input name="montant">
               <input type="submit" value="Confirmer">
            </form>
        ';
    }
    public function afficher() {
        return $this->getAffichage();
    }
}