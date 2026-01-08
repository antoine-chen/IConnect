<?php
include_once "vue_generique.php";
class VueStock extends VueGenerique{
    public function __construct(){
        parent::__construct();
    }

    public function afficherStockActuel($donnes){
        echo '
            <table class="table table-bordered table-hover text-center table-responsive container taille-tableau">
                <thead>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Date</th>
                </thead>
    
                <tbody>
        ';
        foreach ($donnes as $produit){
            echo '
               <tr>
                   <td> '.htmlspecialchars($produit['nom']).' </td>
                   <td> '.htmlspecialchars($produit['prix']) .'</td>
                   <td> '.htmlspecialchars($produit['stock']-$produit['pertes']) .'</td>
                   <td> '.htmlspecialchars($produit['date']) .'</td>
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
            <a href="index.php?module=produit&action=form_ajouterNouveauProduit">
            <h6>Ajouter un produit</h6>
            </a>
            ';
    }

    public function inventaireVide(){
        echo '<p>Aucune inventaire réalisée pour ce mois ci</p> ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}