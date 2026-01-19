<?php
include_once "modele.php";
class ModeleStock extends Modele {

    public function inventaireActuel()
    {

    }

    // Retourne la liste des produits de l'association
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

    // Retourne le stock actuel des produits du mois actuel
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
            insert into ligneInventaire (idInventaire,idProduit,stock) values (?,?,?)
        ');
        $insert->execute([$idInventaire,$idProduit,$stock]);
    }

    public function ajouterStockReel($idOldInventaire, $idProduit, $quantiteProduit)
    {
        $insert = self::$bdd->prepare('
            update ligneInventaire set stockReel = (?) where idInventaire = (?) and idProduit = (?);
        ');
        $insert->execute([$quantiteProduit,$idOldInventaire,$idProduit]);
    }
}