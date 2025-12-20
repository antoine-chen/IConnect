<?php
class ModelePanier extends Connexion{

    public function getPanier($idAssociation, $idUtilisateur){
        $getPanier = self::$bdd->prepare('SELECT p.* ,l.quantite FROM panier pa 
                                                            INNER JOIN lignePanier l ON pa.id = l.idPanier
                                                            INNER JOIN produit p ON l.idProduit = p.id
                                                            WHERE pa.idAssociation = ? AND pa.idUtilisateur = ?');
        $getPanier->execute([$idAssociation, $idUtilisateur]);
        return $getPanier->fetchAll();
    }

    public function getPanierAddition($idAssociation, $idUtilisateur){
        $getPanier = self::$bdd->prepare('SELECT SUM(p.prix * l.quantite) FROM panier pa 
                                                            INNER JOIN lignePanier l ON pa.id = l.idPanier
                                                            INNER JOIN produit p ON l.idProduit = p.id
                                                            WHERE pa.idAssociation = ? AND pa.idUtilisateur = ?');
        $getPanier->execute([$idAssociation, $idUtilisateur]);
        return $getPanier->fetchColumn();
    }

    public function existeProduit($idProduit){
        $existe = self::$bdd->prepare('SELECT id FROM produit WHERE id = ?');
        $existe->execute([$idProduit]);
        return $existe->fetch();
    }
    public function insertPanier($idAssociation, $idUtilisateur){
        $insertPanier = self::$bdd->prepare('INSERT INTO panier (idAssociation, idUtilisateur) VALUES (?, ?)');
        $insertPanier->execute([$idAssociation, $idUtilisateur]);
    }
    public function getIdPanier($idAssociation, $idUtilisateur){
        $getIdPanier = self::$bdd->prepare('SELECT id FROM panier WHERE idAssociation = ? AND idUtilisateur = ?');
        $getIdPanier->execute([$idAssociation, $idUtilisateur]);
        return $getIdPanier->fetchColumn();
    }

    public function insertLignePanier($idPanier, $idProduit, $quantite){
        $insertLignePanier = self::$bdd->prepare('INSERT INTO lignePanier (idPanier, idProduit, quantite) VALUES (?, ?, ?)');
        $insertLignePanier->execute([$idPanier, $idProduit, $quantite]);
    }

    public function dejaAjouter($idPanier, $idProduit){
        $dejaAjouter = self::$bdd->prepare('SELECT idPanier FROM lignePanier WHERE idPanier = ? AND idProduit = ? ');
        $dejaAjouter->execute([$idPanier, $idProduit]);
        return $dejaAjouter->fetch();
    }

    public function updateLignePanier($idPanier, $idProduit){
        $updateLignePanier = self::$bdd->prepare('UPDATE lignePanier SET quantite = quantite + 1 
                                                        WHERE idPanier = ? AND idProduit = ?');
        $updateLignePanier->execute([$idPanier, $idProduit]);
    }

    public function getSoldeUtilisateur($idUtilisateur, $idAssociation){
        $getSolde = self::$bdd->prepare('SELECT solde FROM solde WHERE idUtilisateur = ? AND idAssociation = ?');
        $getSolde->execute([$idUtilisateur, $idAssociation]);
        return $getSolde->fetchColumn();
    }

    public function updateSoldeUtilisateur($idUtilisateur, $idAssociation, $addition){
        $updateSolde = self::$bdd->prepare('UPDATE solde SET solde = solde - ?  WHERE idUtilisateur = ? AND idAssociation = ?');
        $updateSolde->execute([$addition, $idUtilisateur, $idAssociation]);
    }

    public function deleteClientPanierEtLignePanier($idUtilisateur, $idAssociation){
        $deleteClientPanierEtLignePanier = self::$bdd->prepare('DELETE FROM panier WHERE idAssociation = ? AND idUtilisateur = ?');
        $deleteClientPanierEtLignePanier->execute([$idUtilisateur, $idAssociation]);

        $idIdPanierClient =  $this->getIdPanier($idAssociation, $idUtilisateur);
        $deleteLignePanier = self::$bdd->prepare('DELETE FROM lignePanier WHERE idPanier = ?');
        $deleteLignePanier->execute([$idIdPanierClient]);
    }

}