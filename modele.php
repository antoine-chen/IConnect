<?php
class Modele extends Connexion{

    public function idInventaire($idAsso){
        $get = self::$bdd->prepare('
            select max(id) as id 
            from inventaire
            where idAssociation = (?)
        ');
        $get->execute([$idAsso]);
        return $get->fetchColumn();
    }

    public function idAsso($nomAsso){
        $get = self::$bdd->prepare('SELECT id FROM association where nom = (?)');
        $get->execute([$nomAsso]);
        return $get->fetchColumn();
    }


    public function getListeFournisseur($idAssociation){
        $fournisseur = self::$bdd->prepare('SELECT id, ville, email, tel, nom FROM fournisseur WHERE idAssociation = ?');
        $fournisseur->execute([$idAssociation]);
        return $fournisseur->fetchAll();
    }

    public function getProduitsFournisseur($idAssociation){
        $get = self::$bdd->prepare(' SELECT f.id AS idFournisseur, pr.id AS idProduit, pr.nom AS nomProduit FROM fournisseur f INNER JOIN produitsFournisseur pf ON f.id = pf.idFournisseur
                                                        INNER JOIN produit pr ON pr.id = pf.idProduit
                                                        WHERE f.idAssociation = ?
                                                        ORDER BY f.id, pr.nom
        ');
        $get->execute([$idAssociation]);
        return $get->fetchAll();
    }

    public function verifLoginExiste($login) {
        $req = self::$bdd->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $req->execute([$login]);
        return $req->fetch();
    }

}