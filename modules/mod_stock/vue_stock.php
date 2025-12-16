<?php
include_once "vue_generique.php";
class VueStock extends VueGenerique{
    public function __construct(){
        parent::__construct();
    }

    public function afficherStockActuel($donnes)
    {
        ?>
        <table>
            <thead>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Date</th>
            </thead>

            <tbody>
                <?php
                    foreach ($donnes as $produit) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($produit['nom']) ?></td>
                            <td><?php echo htmlspecialchars($produit['prix']) ?></td>
                            <td><?php echo htmlspecialchars($produit['stock']-$produit['pertes']) ?></td>
                            <td><?php echo htmlspecialchars($produit['date']) ?></td>
                        </tr>
                    <?php } ?>
            </tbody>
        </table>
        <?php
    }

    public function inventaireVide()
    {
        ?> <p>Aucune inventaire réalisée pour ce mois ci</p> <?php
    }

    public function afficher() {
        return $this->getAffichage();
    }
}