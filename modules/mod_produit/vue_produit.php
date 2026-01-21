<?php
include_once "vue_generique.php";
class VueProduit extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherProduits($listeProduit, $loginClient, $soldeUtilisateur){
        echo '
    <div class="container">
        <div class="text-center mb-4">
    ';
        $this->confirmationProgressBar();
        echo '
            <div class="fw-semibold">
                Solde de <span class="text-primary">'.htmlspecialchars($loginClient).'</span> : '. $soldeUtilisateur.'€
            </div>
        </div>

        <div class="row justify-content-center g-4">
    ';
        foreach ($listeProduit as $produit){
            echo '
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm text-center">
                <div class="ratio ratio-1x1 bg-light">
                    <img src="'. htmlspecialchars($produit["image"]) .'" 
                         class="card-img-top img-fluid"  alt="produit-item"  style="object-fit: contain; padding:10px;">
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <a href="index.php?module=admin&action=listerAssociation&id=' . $produit['id'] . '" class="text-decoration-none text-dark mb-3">
                        <h6 class="fw-semibold mb-1">'. htmlspecialchars($produit['nom']) .'</h6>
                        <p class="mb-1">'. htmlspecialchars($produit['prix']).'€</p>
                        <p class="mb-0">Qté : '. htmlspecialchars($produit['stock']) .'</p>
                    </a>

                    <a href="index.php?module=panier&action=ajouterDansPanier&id='.$produit['id'].'" class="btn btn-outline-primary mt-auto">
                        Ajouter
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



    public function form_ajoutProduit()
    {
        echo '
    <div class="container my-5" style="max-width: 500px;">
        <div class="card shadow-sm">
            <div class="card-header text-center fw-semibold">
                Ajouter un produit
            </div>
            <div class="card-body">
                <form method="post" action="index.php?module=produit&action=ajouterNouveauProduit" enctype="multipart/form-data">

                    <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">

                    <div class="form-floating mb-3">
                        <input name="nom" class="form-control" placeholder="Nom du produit" required>
                        <label>Nom du produit</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input name="prix" class="form-control" placeholder="Prix du produit" required>
                        <label>Prix du produit</label>
                    </div>

                    <div class="mb-4">
                        <label for="imageProduit" class="form-label fw-semibold">Image du produit</label>
                        <input type="file" name="imageProduit" id="imageProduit" class="form-control" required>
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    ';
    }


    public function afficher() {
        return $this->getAffichage();
    }

    public function form_modifierProduit($produit)
    {
        echo '
    <form method="post" action="index.php?module=produit&action=modifierProduit&id='.$produit['id'].'" class="container taille-formulaire" enctype="multipart/form-data">
    <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du produit</label>
            <input type="text" name="nom" class="form-control" value="'.htmlspecialchars($produit['nom']).'">
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix du produit</label>
            <input type="number" name="prix" class="form-control" value="'.htmlspecialchars($produit['prix']).'">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-primary" type="submit">Valider</button>
    </form>
    ';
    }

    public function afficherListeProduitsFournisseur($listeFournisseur, $produitsFournisseur){
        $fournisseursParId = [];
        foreach ($listeFournisseur as $fournisseur) {
            $fournisseursParId[$fournisseur['id']] = $fournisseur;
        }

        echo '<div class="container mt-5">';
        echo '<h3 class="text-center mb-4"><i class="bi bi-box-seam"></i> Produits par Fournisseur</h3>';

        echo '<div class="row g-4">';
        foreach ($produitsFournisseur as $produit) {
            $fId = $produit['idFournisseur'];
            $idProduit = $produit['idProduit'];
            $fournisseur = $fournisseursParId[$fId];

            echo '
            <div class="col-md-6 col-lg-4">
                <form action="index.php?module=produit&action=restockerProduit&idFournisseur='.$fId.'&id='.$idProduit.'" method="post" class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h3><span class="card-title badge bg-success">'.htmlspecialchars($produit['nomProduit']).'</span></h3>
                        <p class="card-text mb-1"><strong>Fournisseur:</strong> '.htmlspecialchars($fournisseur['nom']).'</p>
                        <p class="card-text mb-1"><strong>Email:</strong> '.htmlspecialchars($fournisseur['email']).'</p>
                        <p class="card-text mb-1"><strong>Téléphone:</strong> '.htmlspecialchars($fournisseur['tel']).'</p>
                        <p class="card-text mb-3"><strong>Ville:</strong> '.htmlspecialchars($fournisseur['ville']).'</p>
    
                        <div class="form-floating mb-3">
                            <input name="quantite" type="number" min="0" class="form-control" id="quantite'.$idProduit.'" placeholder="Quantité" required>
                            <label for="quantite'.$idProduit.'">Quantité</label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </div>
                </form>
            </div>
            ';
        }
        echo '</div>';
        echo '</div>';
    }



}