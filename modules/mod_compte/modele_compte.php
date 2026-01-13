<?php
include_once "modele.php";
class ModeleCompte extends Modele {

    public function chercherClient($idClient, $idAsso){
        $getUtilisateur = self::$bdd->prepare('SELECT * FROM solde WHERE idUtilisateur = ? AND idAssociation = ?');
        $getUtilisateur->execute([$idClient, $idAsso]);
        return $getUtilisateur->fetch();
    }

    public function insertClientSolde($idClient, $idAsso, $montant){
        $insertClientSole = self::$bdd->prepare('INSERT INTO solde(idUtilisateur, idAssociation, solde) VALUES (?, ?, ?)');
        $insertClientSole->execute([$idClient, $idAsso, $montant]);
    }

    public function updateClientSolde($idClient, $idAsso, $montant){
        $insertClientSole = self::$bdd->prepare('UPDATE solde SET solde = solde + ? WHERE idUtilisateur = ? AND idAssociation = ?');
        $insertClientSole->execute([$montant, $idClient, $idAsso]);
    }

}