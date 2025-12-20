<?php
include_once "vue_generique.php";
class VuePanier extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherPanier($panier, $addition){
        echo '
            <div class="d-flex flex-column border rounded m-2">
        ';
        foreach ($panier as $produit){
            echo '
                    <a href="index.php?module=panier&action=panier&id='. $produit['id'] .'">
                        <div class="d-flex justify-content-between align-items-center border rounded m-4">
                            <div class="d-flex align-items-center">
                                <img src="'. htmlspecialchars($produit['image']) .'" alt="">
                                <div>
                                    <p>'. htmlspecialchars($produit['nom']).'</p>
                                    <p>Qté : '. htmlspecialchars($produit['quantite']) .'</p>
                                </div>
                            </div>
                            <div>
                                <p>'. htmlspecialchars($produit['prix'] * $produit['quantite']).'€</p>
                            </div>
                        </div>
                    </a>
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