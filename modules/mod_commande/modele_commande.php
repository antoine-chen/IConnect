<?php

class ModeleCommande extends connexion {

    //fait une requette pour toute les commandes d'une association
    public function toutesLesCommandes(){
        $req = self::$bdd->prepare("SELECT * from commande where idAssociation= ?");
        $req->execute([$_SESSION['association']]);
        return $req->fetchAll();
    }
    //recupere toutes les ligne de commandes d'une commande
    public function derouléCommande($idCommande){
        $req = self::$bdd->prepare("SELECT idCommande,nom,quantite from ligneCommande inner join produit on idProduit=id where idCommande =? ");
        $req->execute([$idCommande]);
        return $req->fetchAll();
    }
    //aficche toute les ligne de commande
    public function toutesLesLignesCommandes(){
        $req = self::$bdd->prepare("SELECT * from ligneCommande inner join produit on idProduit=id");
        $req->execute();
        return $req->fetchAll();
    }

}