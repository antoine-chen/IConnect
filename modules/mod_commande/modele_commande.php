<?php
include_once "modele.php";
class ModeleCommande extends Modele {

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
    public function derouleCommande($idCommande, $date){
        $req = self::$bdd->prepare("SELECT idCommande,nom,quantite,prix,idProduit from ligneCommande inner join produit on idProduit=id where idCommande =? AND date =?");
        $req->execute([$idCommande,$date]);
        return $req->fetchAll();
    }

    public function valideCommande($idCommande,$date){
        $req = self::$bdd->prepare("UPDATE commande SET statut ='livrée' where id=? AND date=?");
        $req->execute([$idCommande,$date]);
    }

    public function prixTotal($idCommande,$date){
        $req = self::$bdd->prepare("Select SUM(prix*quantite) from ligneCommande inner join produit on idProduit=id where idCommande =? AND date =? ");
        $req->execute([$idCommande,$date]);
        return $req->fetchColumn();
    }

    public function rembourser($idCommande,$montant){
        $req =self::$bdd->prepare("UPDATE solde SET solde =solde+? where idUtilisateur=? AND idAssociation=?");
        $req->execute([$montant,$idCommande,$_SESSION['asso']]);
    }
    
    public function refuser($idCommande, $date){
        $req = self::$bdd->prepare("UPDATE commande SET statut ='rembourser' where id=? AND date=?");
        $req->execute([$idCommande,$date]);
    }

    private function dernierInventaire(){
        $req = self::$bdd->prepare("select MAX(id) from inventaire where idAssociation=?");
        $req->execute([$_SESSION['asso']]);
        return $req->fetchColumn();
    }

    public function restocker($quantite,$idCommande){
        $req =self::$bdd->prepare("UPDATE ligneInventaire SET stock = stock+? where idProduit=? and idInventaire=?");
        $req->execute([$quantite,$idCommande,$this->dernierInventaire()]);
    }

    public function getClient($idCommande,$date){
      $req = self::$bdd->prepare("select idutilisateur from commande where id=? AND date=?");
      $req->execute([$idCommande,$date]);
      return $req->fetchColumn();
    }

}