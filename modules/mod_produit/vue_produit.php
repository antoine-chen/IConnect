<?php
include_once "vue_generique.php";
class VueProduit extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherProduits($listeProduit, $loginClient, $soldeUtilisateur){

        echo '
            <div class="text-center m-3">
        ';
                if (isset($_SESSION['messageOk']))
                    echo '<div class="alert alert-success" role="alert">'.$_SESSION['messageOk'].'</div>';
                if (isset($_SESSION['messagePasOk']))
                    echo '<div class="alert alert-danger" role="alert">'.$_SESSION['messagePasOk'].'</div>';
        echo '
                <div>Solde de '.$loginClient.' : '. $soldeUtilisateur.'€</div>
            </div>
            <div class="d-flex justify-content-center align-items-center flex-wrap w-75 container gap-5 p-3">
        ';
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
                    <a href="index.php?module=panier&action=ajouterDansPanier&id='.$produit['id'].'" class="btn btn-outline-secondary">Ajouter</a>
                  </div>
               </div>
        ';
        }
        echo '
            </div>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}