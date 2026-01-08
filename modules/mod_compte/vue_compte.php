<?php
include_once "vue_generique.php";
class VueCompte extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherFormRecharger($soldeClient){
        echo '
            <div class="container border p-5 ">
                <div class="d-flex justify-content-between align-items-center">
                   <h3>Recharger son compte</h3>
                   <p>'. $soldeClient.' €</p>
                </div>
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