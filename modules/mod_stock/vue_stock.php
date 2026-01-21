<?php
include_once "vue_generique.php";
class VueStock extends VueGenerique{
    public function __construct(){
        parent::__construct();
    }

    /**
     * Affiche l'inventaire le plus récent
     */
    public function afficherStockActuel($donnes){
        echo '
    <div>
        <h5 class="text-center m-3">Inventaire de '.$_SESSION['nomAsso'].' du '.$donnes[0]['date'].'</h5>
        <table class="table table-sm table-bordered table-hover text-center table-responsive container taille-tableau align-middle">
            <thead>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Pertes</th>
                <th style="width: 20%">Ajouter une perte</th>
                <th style="width: 10%">Modifier</th>
            </thead>

            <tbody>
    ';
        $token = Token::genererToken();
        foreach ($donnes as $produit){
            echo '
           <tr>
               <td>'.htmlspecialchars($produit['nom']).'</td>
               <td>'.htmlspecialchars($produit['prix']).'</td>
               <td>'.htmlspecialchars($produit['stock']).'</td>
               <td>'.htmlspecialchars($produit['pertes']).'</td>
               <td>
                    <form method="post"
                          action="index.php?module=stock&action=ajouterPertes&id='.$produit['id'].'"
                          class="d-flex justify-content-center align-items-center gap-2">
                        <input type="hidden" name="tokenCSRF" value="'.htmlspecialchars($token).'">
                        <input type="number"
                               name="perte"
                               min="0"
                               required
                               class="form-control form-control-sm w-50">

                        <button class="btn btn-sm btn-primary" type="submit">
                            ✔
                        </button>
                    </form>
               </td>
               <td>
                    <a href="index.php?module=produit&action=form_modifierProduit&id='.$produit['id'].'"
                       class="btn btn-light btn-sm border">
                        <i class="bi bi-gear"></i>
                    </a>
               </td>
           </tr>
        ';
        }
        echo '
        </tbody>
    </table>
    </div>
    ';
    }

    /**
     * Affiche les boutons pour ajouter un produit ou faire un inventaire
     */
    public function boutons()
    {
        echo '
            <div class="text-center m-5">
                <a href="index.php?module=produit&action=form_ajouterNouveauProduit" class="btn btn-primary">Ajouter un produit</a>
                <a href="index.php?module=stock&action=form_inventaire" class="btn btn-primary">Faire l\'inventaire</a>
            </div>
            ';
    }

    /**
     * Affiche le formulaire d'inventaire
     */
    public function form_inventaire($donnes){
        echo '
        <div class="container mt-4" style="max-width: 900px;">
            <div class="card shadow-sm">
                <div class="card-header text-center fw-semibold">
                    Inventaire du '.htmlspecialchars(date('d/m/Y')).' chez '.$_SESSION['nomAsso'].'
                </div>

                <div class="card-body p-0">
                    <form method="post" action="index.php?module=stock&action=ajoutInventaire" class="table-responsive">

                        <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">

                        <table class="table table-hover table-bordered text-center align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 30%">Nom</th>
                                    <th style="width: 20%">Prix</th>
                                    <th style="width: 50%">Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
    ';
        foreach ($donnes as $produit) {
            echo '
                                <tr>
                                    <td>'.htmlspecialchars($produit['nom']).'</td>
                                    <td>'.htmlspecialchars($produit['prix']).'</td>
                                    <td>
                                        <input type="number" name="stock['.$produit['id'].']" min="0" required class="form-control form-control-sm mx-auto" style="max-width: 120px;">
                                    </td>
                                </tr>';
        }
        echo '
                            </tbody>
                        </table>

                        <div class="p-3 text-center">
                            <button type="button" class="btn btn-primary m-4" data-bs-toggle="modal" data-bs-target="#confirmer">Valider</button>
                        </div>
        ';
        $this->afficherConfirmationModal('Valider', 'Êtes vous sur de faire un inventaire', 'Valider');
        echo '                
                        
                    </form>
                </div>
            </div>
        </div>
    ';
    }


    /**
     * Affiche cette phrase quand aucune inventaire a été crée pour l'association
     */
    public function inventaireVide(){
        echo '<p>Aucune inventaire a été réalisé pour cette association, veuillez créer un inventaire pour voir le stock actuel</p> ';
    }

    /**
     * Affiche le rapport d'un inventaire
     */
    public function afficherRapport($valeursTresorerie,$dateChoisi)
    {
        echo '
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light text-center fw-semibold">
                Rapport de trésorerie — inventaire du '.$dateChoisi.'
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center align-middle mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Quantité initiale</th>
                                <th>Quantité actuelle</th>
                                <th>Ventes</th>
                                <th>Pertes</th>
                                <th>Variation de stock</th>
                            </tr>
                        </thead>
                        <tbody>
    ';
        foreach ($valeursTresorerie as $element) {
            echo '
                            <tr>
                                <td>'.htmlspecialchars($element['nom']).'</td>
                                <td>'.htmlspecialchars($element['prix']).'</td>
                                <td>'.htmlspecialchars($element['quantiteInitiale']).'</td>
                                <td>'.htmlspecialchars($element['quantiteActuel']).'</td>
                                <td>'.htmlspecialchars($element['ventes']).'</td>
                                <td>'.htmlspecialchars($element['pertes']).'</td>
                                <td class="fw-semibold">
                                    '.htmlspecialchars($element['variationstock']).'
                                </td>
                            </tr>
        ';
        }
        echo '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    ';
    }


    /**
     * Affiche un formulaire pour choisir la date d'un inventaire pour générer son rapport
     */
    public function afficherChoixInventaireRapport($listeInventaire)
    {
        echo '
    <div class="container mt-4" style="max-width: 420px;">
        <p class="text-center fw-semibold mb-3">
            Choisissez une date pour générer le rapport chez '.$_SESSION['nomAsso'].'
        </p>
        <form method="post" action="index.php?module=stock&action=rapport" class="card p-3 shadow-sm">
            <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">

            <select name="idinventaire" class="form-select mb-3">
    ';
        foreach ($listeInventaire as $element) {
            echo '
                <option value="' . htmlspecialchars($element['id']) . '">
                    ' . htmlspecialchars($element['date']) . '
                </option>';
        }
        echo '
            </select>
            <button class="btn btn-primary w-100" type="submit">
                Générer le rapport
            </button>
        </form>
    </div>
    ';
    }

    public function stockProduitBarman($donnes)
    {
        echo '
    <div class="container my-4">
        <h5 class="text-center mb-4">Stock du : '.htmlspecialchars($donnes[0]['date']).' chez '.$_SESSION['nomAsso'].'</h5>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
    ';

        foreach ($donnes as $produit){
            echo '
                    <tr>
                        <td>'.htmlspecialchars($produit['nom']).'</td>
                        <td>'.htmlspecialchars($produit['prix']).'€</td>
                        <td>'.htmlspecialchars($produit['stock']).'</td>
                    </tr>
        ';
        }

        echo '
                </tbody>
            </table>
        </div>
    </div>
    ';
    }

    public function afficher() {
        return $this->getAffichage();
    }

}