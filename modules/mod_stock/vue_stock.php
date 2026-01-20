<?php
include_once "vue_generique.php";
class VueStock extends VueGenerique{
    public function __construct(){
        parent::__construct();
    }

    public function afficherStockActuel($donnes){
        echo '
        <div>
            <h5 class="text-center m-3">Inventaire du : '.$donnes[0]['date'].'</h5>
            <table class="table table-sm table-bordered table-hover text-center table-responsive container taille-tableau">
                <thead>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th style="width: 10%"></th>
                </thead>
    
                <tbody>
        ';
        foreach ($donnes as $produit){
            echo '
               <tr>
                   <td> '.htmlspecialchars($produit['nom']).' </td>
                   <td> '.htmlspecialchars($produit['prix']) .'</td>
                   <td> '.htmlspecialchars($produit['stock']-$produit['pertes']) .'</td>
                   <td>
                        <a href="index.php?module=produit&action=form_modifierProduit&id='.$produit['id'].'" class="btn btn-light border">
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

    public function boutons()
    {
        echo '
            <div class="text-center m-5">
                <a href="index.php?module=produit&action=form_ajouterNouveauProduit" class="btn btn-primary">Ajouter un produit</a>
                <a href="index.php?module=stock&action=form_inventaire" class="btn btn-primary">Faire l\'inventaire</a>
            </div>
            ';
    }

    public function form_inventaire($donnes){
        echo '
            <div class="text-center m-3">'.htmlspecialchars(date('d/m/Y')) .'</div>
            <div class="table-responsive">
            <form method="post" action="index.php?module=stock&action=ajoutInventaire" class="container taille-tableau">
            <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
                <table class="table table-bordered table-hover text-center">
                     <tr>
                         <th style="width: 25%">Nom</th>
                         <th style="width: 25%">Prix</th>
                         <th style="width: 50%">Quantité</th>
                     </tr>
        ';
        foreach ($donnes as $produit) {
            echo '
                    <tr>
                        <td>' . htmlspecialchars($produit['nom']) . '</td>
                        <td>' . htmlspecialchars($produit['prix']) . '</td>
                        <td>
                            <input type="number" name="stock[' . $produit['id'] . ']" min="0" required/>
                        </td>
                    </tr>';
        }
        echo '
               </table>
               <button class="btn btn-primary" type="submit">Valider</button>
           </form>
           </div>
        ';
    }


    public function inventaireVide(){
        echo '<p>Aucune inventaire réalisée pour ce mois ci, veuillez créer un inventaire pour voir le stock actuel</p> ';
    }

    public function afficher() {
        return $this->getAffichage();
    }

    public function afficherRapport($valeursTresorerie)
    {
        echo '
    <div class="container mt-4">
        <h3 class="mb-4"> WAWA Rapport de trésorerie de l\'inventaire</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité initiale</th>
                        <th>Quantité actuel</th>
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
                        <td>'.htmlspecialchars($element['variationstock']).'</td>
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

    public function afficherChoixInventaireRapport($listeInventaire)
    {
        echo '
        <p>Choisissez une date pour générer le rapport :</p>
        <form method="post" action="index.php?module=stock&action=rapport">
            <select name="idinventaire" class="form-select mb-3">
    ';
        foreach ($listeInventaire as $element) {
            echo '<option value="' . htmlspecialchars($element['id']) . '">'
                . htmlspecialchars($element['date']) . '</option>';
        }
        echo '
            </select>
            <button class="btn btn-primary" type="submit">Valider</button>
        </form>
    ';
    }

}