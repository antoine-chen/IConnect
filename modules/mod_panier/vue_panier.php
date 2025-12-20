<?php
include_once "vue_generique.php";
class VuePanier extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }
    public function afficherPanier($panier){
        echo '
            <form action="" method="post" class="d-flex flex-column border rounded m-2">
        ';
        foreach ($panier as $produit){
            echo '
                    <a href="index.php?module=panier&action=panier&id='. $produit['id'] .'">
                        <div class="d-flex justify-content-between align-items-center border rounded m-5">
                            <div class="d-flex align-items-center">
                                <img src="'. $produit['image'] .'" alt="">
                                <div>
                                    <p>'.$produit['nom'].'</p>
                                    <p>'.$produit['quantite'] .'</p>
                                </div>
                            </div>
                            <div>
                                <p>'.$produit['prix'] .'€</p>
                            </div>
                        </div>
                    </a>
            ';
        }
        echo '
            <input type="submit" value="Valider" class="btn btn-primary m-4">
            </form>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}