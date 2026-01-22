<?php
include_once "vue_generique.php";
class VueFournisseur extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherFormAjoutFournisseur(){
        echo '
            <h3 class="text-center mb-3">Ajoutez un fournisseur chez '.$_SESSION['nomAsso'].'</h3>
            <form method="post" action="index.php?module=fournisseur&action=ajouterFournisseur" class="container">
            <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmer">Ajouter</button>
        ';
        $this->afficherConfirmationModal('Ajouter', 'Ajoutez ce fournisseur ?', 'Ajouter');
        echo '
            </form>
        ';
    }

    public function afficherListeFournisseurEtProduits($listeFournisseur, $produitsFournisseur, $produitsPasFournitParFournisseur){

        echo '
    <div class="container mt-5">
        <h3 class="text-center mb-4">
            <i class="bi bi-truck"></i> Gestion des fournisseurs chez '.$_SESSION['nomAsso'].'
        </h3>
                <div class="text-center my-4"><a href="index.php?module=fournisseur&action=formAjouterFournisseur" class="btn btn-primary">Ajouter un fournisseur</a></div>

        <div class="d-flex flex-column gap-4 align-items-center">
    ';

        foreach ($listeFournisseur as $fournisseur){

            echo '
        <div class="container-color rounded-4 p-4 w-75">
            <div class="row g-3 align-items-center">

                <div class="col-md-4">
                    <h5 class="fw-bold mb-2">
                        '.htmlspecialchars($fournisseur['nom']).'
                    </h5>
                    <p class="mb-1">
                        <i class="bi bi-envelope"></i> '.htmlspecialchars($fournisseur['email']).'
                    </p>
                    <p class="mb-1">
                        <i class="bi bi-geo-alt"></i> '.htmlspecialchars($fournisseur['ville']).'
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-telephone"></i> '.htmlspecialchars($fournisseur['tel']).'
                    </p>
                </div>

                <div class="col-md-5">
                    <strong>
                        <i class="bi bi-box-seam"></i> Produits fournis
                    </strong>
                    <div class="d-flex flex-wrap gap-2 mt-2">
        ';

            if (!empty($produitsFournisseur[$fournisseur['id']])){
                foreach ($produitsFournisseur[$fournisseur['id']] as $produit){
                    echo '
                    <span class="badge bg-light text-dark border px-3 py-2">
                        '.htmlspecialchars($produit).'
                    </span>
                ';
                }
            } else {
                echo '<span class="text-muted">Aucun produit</span>';
            }

            echo '
                    </div>
                </div>

                <div class="col-md-3">
                    <form action="index.php?module=fournisseur&action=ajouterProduitFournisseur&idFournisseur='.$fournisseur['id'].'" method="post" class="mb-2">
                        <label class="form-label small mb-1">Ajouter un produit</label>
                        <div class="input-group input-group-sm">
                            <select name="idProduit" class="form-select">
                                <option value="">Choisir</option>
        ';

            if (!empty($produitsPasFournitParFournisseur[$fournisseur['id']])){
                foreach ($produitsPasFournitParFournisseur[$fournisseur['id']] as $produit){
                    echo '
                    <option value="'.$produit['idProduit'].'">
                        '.htmlspecialchars($produit['nom']).'
                    </option>
                ';
                }
            }

            echo '
                            </select>
                            <button class="btn btn-outline-success" type="submit">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                        </div>
                    </form>
                    <a class="btn btn-outline-danger btn-sm w-100" href="index.php?module=fournisseur&action=supprimerFournisseur&id='.$fournisseur['id'].'">
                        <i class="bi bi-trash-fill"></i> Supprimer
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