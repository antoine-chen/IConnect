<?php
include_once "modele.php";
class ModelePanier extends Modele {

    public function getPanier($idAssociation, $idUtilisateur){
        $getPanier = self::$bdd->prepare('SELECT p.* ,l.quantite FROM panier pa 
                                                            INNER JOIN lignePanier l ON pa.id = l.idPanier
                                                            INNER JOIN produit p ON l.idProduit = p.id
                                                            WHERE pa.idAssociation = ? AND pa.idUtilisateur = ? AND l.quantite > 0');
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

    public function assezDeStockProduit($idAssociation, $idProduit, $idInventaire){
        $existe = self::$bdd->prepare('SELECT l.stock FROM inventaire i 
                                                INNER JOIN ligneInventaire l ON l.idInventaire = i.id WHERE i.idAssociation = ? AND l.idProduit = ? AND i.id = ?');
        $existe->execute([$idAssociation ,$idProduit, $idInventaire]);
        return $existe->fetchColumn();
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

    public function updateLignePanierAjouter($idPanier, $idProduit){
        $updateLignePanier = self::$bdd->prepare('UPDATE lignePanier SET quantite = quantite + 1 
                                                        WHERE idPanier = ? AND idProduit = ?');
        $updateLignePanier->execute([$idPanier, $idProduit]);
    }
    public function updateLignePanierEnlever($idPanier, $idProduit){
        $updateLignePanier = self::$bdd->prepare('UPDATE lignePanier SET quantite = quantite - 1 
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

    // quand je valide mon panier je baisse le stock de l'inventaide de l'association
    public function updateLigneInventaire($idInventaire, $idProduit, $quantite){
        $updateLigneInventaire = self::$bdd->prepare('UPDATE ligneInventaire SET stock = stock - ?
                                                                        WHERE idInventaire = ? AND idProduit = ?');
        $updateLigneInventaire->execute([$quantite, $idInventaire, $idProduit]);
    }

    public function recupreDate(){
        $date = self::$bdd->prepare('SELECT NOW()');
        $date->execute();
        return $date->fetchColumn();
    }

    public function idDernierCommandeDuJour($idAssociation, $date){
        $requete = self::$bdd->prepare('SELECT id FROM commande WHERE idAssociation = ? AND CAST(date AS DATE) = CAST(? AS DATE) ORDER BY id DESC LIMIT 1');
        $requete->execute([$idAssociation, $date]);
        return $requete->fetchColumn();
    }

    public function insertCommande($id ,$idUtilisateur, $date, $status, $idAssociation){
        $insertCommande = self::$bdd->prepare('INSERT INTO commande(id ,idUtilisateur, date, statut, idAssociation) VALUES (?,?,?,?,?)');
        $insertCommande->execute([$id, $idUtilisateur, $date, $status, $idAssociation]);
    }

    public function insertLigneCommande($idCommande, $idProduit, $quantite, $date){
        $insertLigneCommande = self::$bdd->prepare('INSERT INTO ligneCommande(idCommande, idProduit, quantite, date) VALUES (?, ?, ?, ?)');
        $insertLigneCommande->execute([$idCommande, $idProduit, $quantite, $date]);
    }

    public function deleteLignePanier($idUtilisateur, $idAssociation){
        $idIdPanierClient =  $this->getIdPanier($idAssociation, $idUtilisateur);

        $deleteLignePanier = self::$bdd->prepare('DELETE FROM lignePanier WHERE idPanier = ? AND quantite = 0');
        $deleteLignePanier->execute([$idIdPanierClient]);
    }

    public function deleteClientPanierEtLignePanier($idUtilisateur, $idAssociation){
        $idIdPanierClient =  $this->getIdPanier($idAssociation, $idUtilisateur);

        $deleteLignePanier = self::$bdd->prepare('DELETE FROM lignePanier WHERE idPanier = ?');
        $deleteLignePanier->execute([$idIdPanierClient]);

        $deleteClientPanier = self::$bdd->prepare('DELETE FROM panier WHERE idAssociation = ? AND idUtilisateur = ?');
        $deleteClientPanier->execute([$idAssociation, $idUtilisateur]);
    }

}