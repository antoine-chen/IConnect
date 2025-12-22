<?php

class ModeleCompte extends Connexion{

    public function chercherClient($idClient, $idAsso){
        $getUtilisateur = self::$bdd->prepare('SELECT * FROM solde WHERE idUtilisateur = ? AND idAssociation = ?');
        $getUtilisateur->execute([$idClient, $idAsso]);
        return $getUtilisateur->fetch();
    }

    public function insertClientSole($idClient, $idAsso, $montant){
        $insertClientSole = self::$bdd->prepare('INSERT INTO solde(idUtilisateur, idAssociation, solde) VALUES (?, ?, ?)');
        $insertClientSole->execute([$idClient, $idAsso, $montant]);
    }

    public function updateClientSolde($idClient, $idAsso, $montant){
        $insertClientSole = self::$bdd->prepare('UPDATE solde SET solde = solde + ? WHERE idUtilisateur = ? AND idAssociation = ?');
        $insertClientSole->execute([$montant, $idClient, $idAsso]);
    }

    public function getSoldeClient($idClient, $idAssociation){
        $getSolde = self::$bdd->prepare('SELECT solde FROM solde WHERE idUtilisateur = ? AND idAssociation = ? AND solde > 0');
        $getSolde->execute([$idClient, $idAssociation]);
        return $getSolde->fetchColumn();
    }

}