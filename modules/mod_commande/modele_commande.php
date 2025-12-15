<?php
class ModeleCommande extends connexion {
    public function toutesLesCommandes(){
        $req = self::$bdd->prepare("SELECT * from commande where idAssociation= ?");
        $req->execute([$_SESSION['association']]);
        return $req->fetchAll();
    }
    public function derouléCommande($idCommande){
        $req = self::$bdd->prepare("SELECT nom,quantité from ligneCommande inner join produit on idProduit=id where idCommande =? ");
        $req->execute([$idCommande]);
        return $req->fetchAll();
    }

}