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

    public function getTresorerie($idinventaire, $asso, $date)
    {
        $get = self::$bdd->prepare('
        select
            p.id as idProduit,
            p.nom as nom,
            p.prix as prix,
            lI.stock as quantiteInitiale,
            (lI.stock + sum(h.quantite) - sum(lC.quantite)) as quantiteActuel,
            sum(lC.quantite) as ventes,
            lI.pertes,
            ((lI.stock + sum(h.quantite) - sum(lC.quantite)) - lI.stock) as variationstock
        from ligneInventaire lI
        inner join produit p on lI.idproduit = p.id
        left join historiqueRestock h 
            on h.idproduit = p.id and h.idassociation = ? and h.date >= ?
        left join ligneCommande lC
            on lC.idproduit = p.id
            and lC.idCommande in (
                select c.id
                from commande c
                where c.statut = "livrée" and c.date >= ?
            )
        where lI.idinventaire = ?
        group by p.id, p.nom, p.prix, lI.stock, lI.pertes
        order by p.nom ASC
    ');
        $get->execute([$asso, $date, $date, $idinventaire]);
        return $get->fetchAll();
    }





    public function getDateInventaire($idInventaire)
    {
        $get = self::$bdd->prepare('
            select date from inventaire where inventaire.id = (?)
        ');
        $get->execute([$idInventaire]);
        return $get->fetchColumn();
    }

    public function getListeInventaires($asso)
    {
        $get = self::$bdd->prepare('
            select id,date from inventaire
            where idAssociation = (?)
        ');
        $get->execute([$asso]);
        return $get->fetchAll();
    }


}