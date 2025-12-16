<?php
class ModeleStock extends Connexion{

    public function stockActuel($idAssociation)
    {
        $get = self::$bdd->prepare('
            select produit.nom, produit.prix, ligneInventaire.stock, ligneInventaire.pertes,inventaire.date from inventaire inner join ligneInventaire on ligneInventaire.idInventaire=inventaire.id
            inner join produit on ligneInventaire.idProduit=produit.id
                                            
            where idAssociation = (?) and extract(month from date) = extract(month from CURRENT_DATE)
            and extract(year from date) = extract(year from CURRENT_DATE);
            ');
        $get->execute([$idAssociation]);
        return $get->fetchAll();
    }
}