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
            <div class="d-flex justify-content-center align-items-center flex-wrap container gap-5 p-3">
        ';
        foreach ($listeProduit as $produit){
            echo '
               <div class="d-flex flex-column align-items-center border">
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

    public function form_ajoutProduit()
    {
        echo '
            <form method="post" action="index.php?module=produit&action=ajouterNouveauProduit" enctype="multipart/form-data" class="container taille-formulaire">
                <h6 class="text-center">Ajouter un produit</h6>
                <div class="form-floating mt-3 mb-2">
                    <input name="nom" class="form-control" placeholder="Nom du produit" required>
                    <label>Nom du produit</label>
                </div>
                <div class="form-floating">
                    <input name="prix" class="form-control" placeholder="Prix du produit" required>
                    <label>Prix du produit</label>
                </div>
                <div class="mt-3 mb-3">
                    <input type="file" name="imageProduit" required>
                </div>
                <div>
                   <button class="btn btn-primary" type="submit">Ajouter</button>
                </div>
            </form>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }

    public function form_modifierProduit($produit)
    {
        echo '
    <form method="post" action="index.php?module=produit&action=modifierProduit&id='.$produit['id'].'" class="container taille-formulaire" enctype="multipart/form-data">
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

}