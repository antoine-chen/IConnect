<?php
include_once "vue_generique.php";
class VueStock extends VueGenerique{
    public function __construct(){
        parent::__construct();
    }

    public function afficherStockActuel($donnes){
        echo '
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
                   <td><a href="index.php?module=produit&action=form_modifierProduit&id='.$produit['id'].'">Modifier</a></td>
               </tr>                
                ';
            }
        echo '
            </tbody>
        </table>
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
               <button class="btn btn-primary" type="submit">Créer un inventaire</button>
           </form>
           </div>
        ';
    }


    public function inventaireVide(){
        echo '<p>Aucune inventaire réalisée pour ce mois ci</p> ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}