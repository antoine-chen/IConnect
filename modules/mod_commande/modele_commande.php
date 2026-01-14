<?php

class ModeleCommande extends connexion {

    //fait une requette pour toute les commandes d'une association
    public function toutesLesCommandes(){
        $req = self::$bdd->prepare("SELECT * from commande where idAssociation= ? order by date");
        $req->execute([$_SESSION['asso']]);
        return $req->fetchAll();
    }
    public function recupereDate(){
        $date = self::$bdd->prepare('SELECT NOW()');
        $date->execute();
        return $date->fetchColumn();
    }
    public function toutesLesCommandesDuJour(){
        $req = self::$bdd->prepare("SELECT * from commande where idAssociation= ? AND statut='Encours' AND Cast(date AS DATE)=Cast(? AS DATE) order by date");
        $req->execute([$_SESSION['asso'],$this->recupereDate()]);
        return $req->fetchAll();
    }
    //recupere toutes les ligne de commandes d'une commande
    public function derouléCommande($idCommande,$date){
        $req = self::$bdd->prepare("SELECT idCommande,nom,quantite,prix,idProduit from ligneCommande inner join produit on idProduit=id where idCommande =? AND date =?");
        $req->execute([$idCommande,$date]);
        return $req->fetchAll();
    }
    public function valideCommande($id,$date){
        $req = self::$bdd->prepare("UPDATE commande SET statut ='livrée' where id=? AND date=?");
        $req->execute([$id,$date]);
    }
    public function prixTotal($idCommande,$date){
        $req = self::$bdd->prepare("Select SUM(prix) from ligneCommande inner join produit on idProduit=id where idCommande =? AND date =? ");
        $req->execute([$idCommande,$date]);
        return $req->fetch();
    }
    public function rembourser($id,$montant){
        $req =self::$bdd->prepare("UPDATE solde SET solde =solde+? where idUtilisateur=? AND idAssociation=?");
        $montant=(float)$montant;
        $req->execute([$montant,$id,$_SESSION['asso']]);


    }
    public function refuser($id, $date){
        $req = self::$bdd->prepare("UPDATE commande SET statut ='rembourser' where id=? AND date=?");
        $req->execute([$id,$date]);
    }
    private function dernierInventaire(){
        $req = self::$bdd->prepare("select MAX(id) from inventaire where idAssociation=?");
        $req->execute([$_SESSION['asso']]);
        return $req->fetchColumn();
    }
    public function restocker($id){
        $req =self::$bdd->prepare("UPDATE ligneInventaire SET stock = stock+1 where idProduit=? and idInventaire=?");
        $req->execute([$id,$this->dernierInventaire()]);
    }

}