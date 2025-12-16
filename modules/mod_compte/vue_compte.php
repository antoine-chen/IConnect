<?php
include_once "vue_generique.php";
class VueCompte extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherFormRecharger(){
        echo '
            <div class="container border p-5 ">
                <h2>Recharger son compte</h2>
                <form method="post" action="index.php?module=compte&action=recharger" class="mt-4 mb-4">
                   <div class="form-floating mb-2">
                       <input name="montant" class="form-control" placeholder="Montant">
                       <label>Montant</label>
                   </div>
                   <input class="btn btn-primary" type="submit" value="Confirmer">
                </form>
            </div>
        ';
    }
    public function afficher() {
        return $this->getAffichage();
    }
}