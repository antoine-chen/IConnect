<?php
include_once "vue_generique.php";
class VuePanier extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherProduits($listeProduit){

        echo '<div class="d-flex justify-content-center align-items-center flex-wrap w-75 container gap-5  p-3">';
        foreach ($listeProduit as $produit){
            echo '
               <div class="d-flex flex-column align-items-center">
                  <img src="'. $produit["image"] .'" class="img-produit" alt="produit-item">
                  <div class="d-flex justify-content-between align-items-center gap-2 m-3 info-produit">
                    <a href="index.php?module=admin&action=listerAssociation&id=' . $produit['id'] . '" class="text-black" style="text-decoration = none;">
                                <h6 class="card-title"> '. htmlspecialchars($produit['nom']) .'</h6>
                                <p class="card-title"> '. htmlspecialchars($produit['prix']).'€' .'</p>
                                <p class="card-title">Qté :'. htmlspecialchars($produit['stock']) .'</p>
                    </a>
                    <a href="#" class="btn btn-outline-secondary">Ajouter</a>
                  </div>
               </div>
        ';
        }
        echo '</div>';
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