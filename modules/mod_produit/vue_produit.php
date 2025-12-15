<?php
include_once "vue_generique.php";

class VueProduit extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }
    public function afficherProduits($listeProduit){

        echo '<div class="d-flex justify-content-between align-items-center flex-wrap w-75 container">';
        foreach ($listeProduit as $produit){
            echo '
               <div class="card" style="width: 18rem;">
                  <img src="..." class="card-img-top" alt="...">
                  <div class="card-body">
                    <a href="index.php?module=admin&action=listerAssociation&id=' . $produit['id'] . '">
                                ' . '<h6 class="card-title"> '. htmlspecialchars($produit['nom']) .'</h6>' . '
                                ' . '<h6 class="card-title"> '. htmlspecialchars($produit['prix']) .'</h6>' . '
                    </a>
                    <a href="#" class="btn btn-primary">Ajouter un produit</a>
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