<?php
include_once "vue_generique.php";
class VuePanier extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherPanier($panier, $addition, $messageValidationPanier = ""){
        echo '
            <div class="d-flex flex-column border rounded m-2">
                <p class="text-center">'. $messageValidationPanier .'</p>
                <div class="d-flex justify-content-between mx-4 mt-2">
                    <h3>Panier</h3>
                    <p>Solde actuel : €</p>
                </div>
        ';
        foreach ($panier as $produit){
            echo '
                <div class="d-flex justify-content-between align-items-center border rounded m-4">
                    <div class="d-flex align-items-center">
                       <img src="'. htmlspecialchars($produit['image']) .'" class="img-produit" alt="">
                       <div>
                          <p>'. htmlspecialchars($produit['nom']).'</p>
                          <p>Qté : '. htmlspecialchars($produit['quantite']) .'</p>
                          <a href="index.php?module=panier&action=enleverProduit&id='. $produit['id'].'">Supprimer</a>
                       </div>
                    </div>
                    <div>
                        <p>'. htmlspecialchars($produit['prix'] * $produit['quantite']).'€</p>
                    </div>
                </div>
            ';
        }
        echo '
                <div class="d-flex justify-content-between align-items-center mx-5">
                    <p>Total : '. $addition .' €</p>
                    <a href="index.php?module=panier&action=validerPanier" class="btn btn-primary m-4">Valider</a>
                </div>
            </div>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}