<?php
class ModelePanier extends Connexion{

    public function getProduits($idAsso){
        $getProduits = self::$bdd->prepare('SELECT p.*, l.stock FROM boutique b INNER JOIN produit p ON b.idProduit = p.id 
                                                        INNER JOIN ligneInventaire l ON l.idProduit = p.id
                                                        INNER JOIN inventaire i ON i.id = l.idInventaire
                                            WHERE i.idAssociation = ?');
        $getProduits->execute([$idAsso]);
        return $getProduits->fetchAll();
    }

    public function getPanier($idAssociation, $idUtilisateur){
        $getPanier = self::$bdd->prepare('SELECT p.* ,l.quantite FROM panier pa 
                                                            INNER JOIN lignePanier l ON pa.id = l.idPanier
                                                            INNER JOIN produit p ON l.idProduit = p.id
                                                            WHERE pa.idAssociation = ? AND pa.idUtilisateur = ?');
        $getPanier->execute([$idAssociation, $idUtilisateur]);
        return $getPanier->fetchAll();
    }
}