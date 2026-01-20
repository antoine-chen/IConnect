<?php
include_once "vue_generique.php";
class VueFournisseur extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherFormAjoutFournisseur(){
        echo '
            
            <form method="post" action="index.php?module=fournisseur&action=ajouterFournisseur" class="container">
            <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
                <h2 class="text-center">Ajouter un fournisseur</h2>
                <div class="form-floating mt-3 mb-2">
                    <input name="nom" class="form-control" placeholder="Nom" required>
                    <label>Nom</label>
                </div>
                <div class="form-floating mt-3 mb-2">
                    <input name="email" class="form-control" placeholder="Email" required>
                    <label>Email</label>
                </div>
                <div class="form-floating mt-3 mb-2">
                    <input name="ville" class="form-control" placeholder="Ville" required>
                    <label>Ville</label>
                </div>
                <div class="form-floating mt-3 mb-2">
                    <input name="telephone" class="form-control" placeholder="Téléphone" required>
                    <label>Téléphone</label>
                </div>
                <input class="btn btn-primary" type="submit" value="Ajouter">
            </form>
        ';
    }

    public function afficherListeFournisseurEtProduits($listeFournisseur, $produitsFournisseur){

        echo '
    <div class="container mt-5">
        <h3 class="text-center mb-4">
            <i class="bi bi-truck"></i> Fournisseurs
        </h3>

        <div class="d-flex flex-column gap-3 align-items-center">
    ';

        foreach ($listeFournisseur as $fournisseur){

            echo '
        <div class="container-color rounded-4 p-4 w-75">
            <div class="row align-items-center">

                <div class="col-md-4">
                    <h5>'.htmlspecialchars($fournisseur['nom']).'</h5>
                    <p><i class="bi bi-envelope"></i> '.htmlspecialchars($fournisseur['email']).'</p>
                    <p><i class="bi bi-geo-alt"></i> '.htmlspecialchars($fournisseur['ville']).'</p>
                    <p><i class="bi bi-telephone"></i> '.htmlspecialchars($fournisseur['tel']).'</p>
                </div>

                <div class="col-md-6">
                    <strong>Produits fournis :</strong>
                    <div class="d-flex flex-wrap gap-2 mt-2">
        ';

            if (!empty($produitsFournisseur[$fournisseur['id']])){
                foreach ($produitsFournisseur[$fournisseur['id']] as $produit){
                    echo '
                        <span class="badge bg-light text-dark border px-3 py-2">
                             '.htmlspecialchars($produit) .'
                        </span>
                    ';
                }
            } else {
                echo '<span class="text-muted">Aucun produit</span>';
            }

            echo '
                    </div>
                </div>

                <div class="col-md-2 d-flex justify-content-end align-items-center">                    
                    <a href="index.php?module=fournisseur&action=supprimerFournisseur&id='.$fournisseur['id'].'"
                       class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </div>

            </div>
        </div>
        ';
        }

        echo '
            </div>
        </div>
    ';
    }


    public function afficher() {
        return $this->getAffichage();
    }
}