<?php
include_once "modele.php";
class ModeleStock extends Modele {

    /**
     * Retourne la liste des produits de l'association
    */
    public function listeProduitsAsso($idAssociation)
    {
        $get = self::$bdd->prepare('
        select produit.id, produit.nom, produit.image, produit.prix
        from produit
        inner join boutique on boutique.idproduit = produit.id
        where boutique.idassociation = ?
    ');
        $get->execute([$idAssociation]);
        return $get->fetchAll();
    }

    public function creerInventaire($idAsso)
    {
        $insert = self::$bdd->prepare('
            insert into inventaire (idAssociation) values (?)
        ');
        $insert->execute([$idAsso]);
    }

    /**
     * Retourne les données nécessaires pour afficher le stock du dernier inventaire
     */
    public function stockActuel($idInventaire)
    {
        $get = self::$bdd->prepare('
            select produit.id,produit.nom, produit.prix, ligneInventaire.stock, ligneInventaire.pertes,inventaire.date 
            
            from inventaire inner join ligneInventaire on ligneInventaire.idInventaire=inventaire.id
            inner join produit on ligneInventaire.idProduit=produit.id
                                            
            where inventaire.id = (?)
            ');
        $get->execute([$idInventaire]);
        return $get->fetchAll();
    }

    public function ajouterProduit($idInventaire,$idProduit,$stock)
    {
        $insert = self::$bdd->prepare('
            insert into ligneInventaire (idInventaire,idProduit,stock,stockInitial) values (?,?,?,?)
        ');
        $insert->execute([$idInventaire,$idProduit,$stock,$stock]);
    }

    /**
     * Retourne le date de l'id de l'inventaire en paramètre
     */
    public function getDateInventaire($idInventaire)
    {
        $get = self::$bdd->prepare('
            select date from inventaire where inventaire.id = (?)
        ');
        $get->execute([$idInventaire]);
        return $get->fetchColumn();
    }

    /**
     * Retourne l'id et date des inventaires d'une association
     */
    public function getListeDatesInventaireAsso($asso)
    {
        $get = self::$bdd->prepare('
            select id,date from inventaire
            where idAssociation = (?)
            order by date desc
        ');
        $get->execute([$asso]);
        return $get->fetchAll();
    }

    /**
     * Retourne l'inventaire (id, idAssociation,date) crée juste après celui qu'on a mis en paramètre
     */
    public function getInventaireSuivant($idAssociation, $date) {
        $get = self::$bdd->prepare('
            SELECT * FROM inventaire 
            WHERE idAssociation = ? AND date > ?
            ORDER BY date ASC LIMIT 1
        ');
        $get->execute([$idAssociation, $date]);
        return $get->fetch();
    }

    /**
     * Retourne le stock actuel (stock), stock initial et pertes du produit d'un inventaire
     */
    public function getStockProduit($idInventaire, $idProduit) {
        $get = self::$bdd->prepare('SELECT stock, stockInitial, pertes FROM ligneInventaire WHERE idInventaire = ? AND idProduit = ?');
        $get->execute([$idInventaire, $idProduit]);
        return $get->fetch();
    }

    /**
     * Retourne la quantité d'un produit vendus par entre deux dates pour une association
     */
    public function getVentesProduit($idProduit, $idAssociation, $dateDebut, $dateFin) {
        $get = self::$bdd->prepare('
            SELECT SUM(lC.quantite) as ventes
            FROM ligneCommande lC
            INNER JOIN commande c ON c.id = lC.idCommande
            WHERE lC.idProduit = ? 
              AND c.idAssociation = ?
              AND c.statut = "livrée"
              AND c.date BETWEEN ? AND ?
        ');
        $get->execute([$idProduit, $idAssociation, $dateDebut, $dateFin]);
        return $get->fetchColumn();
    }

    /**
     * Retourne le quantité de produits restockés (reçus par des commandes auprès des fournisseurs) entre 2 dates pour une association
     */
    public function getRestocksProduit($idProduit, $idAssociation, $dateDebut, $dateFin) {
        $get = self::$bdd->prepare('
            SELECT SUM(quantite) as restocks
            FROM historiqueRestock
            WHERE idProduit = ? 
              AND idAssociation = ?
              AND date BETWEEN ? AND ?
        ');
        $get->execute([$idProduit, $idAssociation, $dateDebut, $dateFin]);
        return $get->fetchColumn();
    }

    /**
     * Retourne la date d'aujourd'hui
     */
    public function recupereDateAujourdhui(){
        $date = self::$bdd->prepare('SELECT NOW()');
        $date->execute();
        return $date->fetchColumn();
    }
}