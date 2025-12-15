<?php
include_once "vue_generique.php";

class VueProduit extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }
    public function afficherProduits($listeProduit){

        echo '<div class="d-flex justify-content-center align-items-center flex-wrap w-75 container gap-5  p-3">';
        foreach ($listeProduit as $produit){
            echo '
               <div>
                  <img src="'. $produit["image"] .'" style="height: 250px; width: 200px; object-fit: cover;" alt="produit-item">
                  <div class="d-flex justify-content-between align-items-center gap-2 m-3">
                    <a href="index.php?module=admin&action=listerAssociation&id=' . $produit['id'] . '">
                                ' . '<h6 class="card-title"> '. htmlspecialchars($produit['nom']) .'</h6>'.'
                                ' . '<p class="card-title"> '. htmlspecialchars($produit['prix']).'€' .'</p>' .'
                    </a>
                    <a href="#" class="btn btn-primary">Ajouter</a>
                  </div>
               </div>
        ';
        }
        echo '</div>';
    }

    public function afficher() {
        return $this->getAffichage();
    }

}