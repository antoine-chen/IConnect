<?php
include_once "vue_generique.php";
class VuePanier extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherPanier($panier, $addition, $solde){
        $this->confirmationProgressBar();
        echo '
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Panier chez '.$_SESSION['nomAsso'].'</h3>
                <p class="mb-0 fw-semibold">Solde actuel : '.$solde.'€</p>
            </div>

            <div class="card-body">
    ';
        foreach ($panier as $produit){
            echo '
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center border rounded mb-3 p-3 shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <img src="'. htmlspecialchars($produit['image']) .'" class="img-fluid rounded" style="height: 120px; width:auto;" alt="">
                <div>
                    <p class="fw-semibold mb-1">'. htmlspecialchars($produit['nom']).'</p>
                    <p class="mb-1">Qté : '. htmlspecialchars($produit['quantite']) .'</p>
                    <a href="index.php?module=panier&action=enleverProduit&id='. $produit['id'].'" class="text-danger small">Supprimer</a>
                </div>
            </div>
            <div class="mt-3 mt-md-0 text-center fw-semibold" style="min-width: 80px;">
                '. htmlspecialchars($produit['prix'] * $produit['quantite']).'€
            </div>
        </div>
        ';
        }
        echo '
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
                <p class="fw-semibold mb-3 mb-md-0">Total : '. $addition .' €</p>
                <div class="d-flex gap-2">
                    <a href="index.php?module=panier&action=viderPanier" class="btn btn-danger">Vider panier</a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmer">Valider</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    ';

        $this->afficherConfirmationModal(
            "Validation",
            "Êtes-vous sûr de confirmer votre panier ?",
            "Valider",
            "index.php?module=panier&action=validerPanier"
        );
    }


    public function afficher() {
        return $this->getAffichage();
    }
}