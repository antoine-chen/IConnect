<?php
include_once "vue_generique.php";
class VuePanier extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherPanier($panier, $addition, $solde){
        echo '
            <div class="d-flex flex-column border rounded m-2">
                <div class="d-flex justify-content-between mx-4 mt-2">
                    <h3>Panier</h3>
                    <p>Solde actuel : '.$solde.'€</p>
                </div>
        ';
        foreach ($panier as $produit){
            echo '
                <div class="d-flex justify-content-between align-items-center border rounded mx-5 mb-2">
                    <div class="d-flex align-items-center">
                       <img src="'. htmlspecialchars($produit['image']) .'" class="img-produit" style="height: 200px;" alt="">
                       <div>
                          <p>'. htmlspecialchars($produit['nom']).'</p>
                          <p>Qté : '. htmlspecialchars($produit['quantite']) .'</p>
                          <a href="index.php?module=panier&action=enleverProduit&id='. $produit['id'].'">Supprimer</a>
                       </div>
                    </div>
                    <div class="px-4">
                        <p>'. htmlspecialchars($produit['prix'] * $produit['quantite']).'€</p>
                    </div>
                </div>
            ';
        }
        echo '
                <div class="d-flex justify-content-between align-items-center mx-5">
                    <p>Total : '. $addition .' €</p>
                    <div class="m-4">
                        <a href="index.php?module=panier&action=viderPanier" class="btn btn-danger">Vider panier</a>
                        <button class="btn btn-primary m-4" data-bs-toggle="modal" data-bs-target="#confirmer">Valider</button>
                    </div>
                </div>
        ';
        $this->afficherConfirmationModal("Validation", "Êtes vous sur de confirmer votre panier ?","Valider", "index.php?module=panier&action=validerPanier");
    }

    public function test(){
        echo 'fdkfjlmqsdjfklqsdjfkqsdljqsdkl';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}