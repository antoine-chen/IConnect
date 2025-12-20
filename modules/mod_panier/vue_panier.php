<?php
include_once "vue_generique.php";
class VuePanier extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherPanier($panier, $addition){
        echo '
            <form action="" method="post" class="d-flex flex-column border rounded m-2">
        ';
        foreach ($panier as $produit){
            echo '
                    <a href="index.php?module=panier&action=panier&id='. $produit['id'] .'">
                        <div class="d-flex justify-content-between align-items-center border rounded m-4">
                            <div class="d-flex align-items-center">
                                <img src="'. $produit['image'] .'" alt="">
                                <div>
                                    <p>'.$produit['nom'].'</p>
                                    <p>Qté : '.$produit['quantite'] .'</p>
                                </div>
                            </div>
                            <div>
                                <p>'.$produit['prix'] * $produit['quantite'].'€</p>
                            </div>
                        </div>
                    </a>
            ';
        }
        echo '
            <div class="d-flex justify-content-between align-items-center mx-5">
                <p>Total : '. $addition.' €</p>
                <input type="submit" value="Valider" class="btn btn-primary m-4">
            </div>
            </form>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}