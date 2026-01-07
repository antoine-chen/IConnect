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
            <a href="index.php?module=stock&action=form_inventaire">
            <h6>Faire l inventaire</h6>
            </a>
            ';
    }

    public function form_inventaire($donnes)
    {
        echo '<p>' . htmlspecialchars(date('d/m/Y')) . '</p>';
        echo '<form method="post" action="index.php?module=stock&action=ajoutInventaire" class="container taille-formulaire">';
        echo '<table class="table">';
        echo '<thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
            </tr>
          </thead>';
        echo '<tbody>';
        foreach ($donnes as $produit) {
            echo '<tr>
                <td>' . htmlspecialchars($produit['nom']) . '</td>
                <td>' . htmlspecialchars($produit['prix']) . '</td>
                <td>
                    <input type="number" name="stock[' . $produit['id'] . ']" min="0" required/>
                </td>
              </tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '<button class="btn btn-primary" type="submit">Créer un inventaire</button>';
        echo '</form>';
    }


    public function inventaireVide(){
        echo '<p>Aucune inventaire réalisée pour ce mois ci</p> ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}