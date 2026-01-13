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
                   <button type="button" class="btn btn-primary m-4" data-bs-toggle="modal" data-bs-target="#confirmer">Confirmer</button>
        ';
        $this->afficherConfirmationModal("Rechargement de compte", "Êtes vous sûr ?", "Confirmer");
        echo '
                </form>
            </div>
        ';
    }

    public function afficherProfil($profil){
        echo '   
            <div class="position-relative">
                <div class="bg-primary position-absolute" style="height: 60px; width: 60px; top: 30%; left: 27%;"></div>
                <div class="bg-secondary mx-auto w-50" style="height: 60px;"></div>
                <div class="bg-dark mx-auto w-50" style="height: 60px;"></div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="w-50">
        ';
        foreach ($profil as $attribut => $dataUtilisateur){
            echo '
               <div class="d-flex justify-content-between align-items-center px-3 py-2 border">
                  <div>
                      <h6>'. $attribut.'</h6>
                      <p>'. $dataUtilisateur.'</p>
                  </div>
                  <a href="" class="btn btn-secondary">Modifier</a>
               </div>
            ';
        }
        echo '
                </div>
            </div>
        ';
    }


    public function afficher() {
        return $this->getAffichage();
    }
}