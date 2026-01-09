<?php

class ModeleCommande extends connexion {

    //fait une requette pour toute les commandes d'une association
    public function toutesLesCommandes(){
        $req = self::$bdd->prepare("SELECT * from commande where idAssociation= ? order by date");
        $req->execute([$_SESSION['asso']]);
        return $req->fetchAll();
    }
    public function NOW(){

    }
    public function toutesLesCommandesDuJour(){
        $req = self::$bdd->prepare("SELECT * from commande where idAssociation= ? where (Cast date as date)=? order by date");
        $req->execute([$_SESSION['asso']]);
        return $req->fetchAll();
    }
    //recupere toutes les ligne de commandes d'une commande
    public function derouléCommande($idCommande,$date){
        $req = self::$bdd->prepare("SELECT idCommande,nom,quantite,prix from ligneCommande inner join produit on idProduit=id where idCommande =? AND date =?");
        $req->execute([$idCommande,$date]);
        return $req->fetchAll();
    }
    public function valideCommande($id,$date){
        $req = self::$bdd->prepare("UPDATE commande SET statut ='livrée' where id=? AND date=?");
        $req->execute([$id,$date]);
    }

}