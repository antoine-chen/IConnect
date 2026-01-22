<?php
include_once "modele.php";
class ModeleCommande extends Modele {

    //fait une requette pour toute les commandes d'une association
    public function toutesLesCommandes(){
        $req = self::$bdd->prepare("SELECT * 
                                    from commande 
                                    where idAssociation= ? 
                                    Except 
                                    select * 
                                    from commande 
                                    where statut='Encours'
                                    order by date");
        $req->execute([$_SESSION['asso']]);
        return $req->fetchAll();
    }

    public function toutesLesCommandesDuJour(){
        $req = self::$bdd->prepare("SELECT * from commande where idAssociation= ? AND statut='Encours' AND Cast(date AS DATE)=Cast(? AS DATE) order by date");
        $req->execute([$_SESSION['asso'],$this->recupererDate()]);
        return $req->fetchAll();
    }

    //recupere toutes les ligne de commandes d'une commande
    public function derouleCommande($idCommande, $date){
        $req = self::$bdd->prepare("SELECT p.nom, SUM(l.quantite) AS quantite, p.prix FROM ligneCommande l INNER JOIN produit p ON l.idProduit = p.id WHERE l.idCommande = ? AND l.date = ? GROUP BY p.nom, p.prix");
        $req->execute([$idCommande, $date]);
        return $req->fetchAll();
    }


    public function valideCommande($idCommande,$date){
        $req = self::$bdd->prepare("UPDATE commande SET statut ='livrée',idBarman = ? where id=? AND date=?");
        $req->execute([$_SESSION['id'],$idCommande,$date]);
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
        $req = self::$bdd->prepare("UPDATE commande SET statut ='rembourser',idBarman = ? where id=? AND date=?");
        $req->execute([$_SESSION['id'],$idCommande,$date]);
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
    public function profilDunUtilisateur(){
        if (isset($_SESSION['role'])&& $_SESSION['role']='barman'&&isset($_GET['id'])){
            $this->vue->afficherProfil(
                $this->modele->getProfilUtilisateur($_GET),
                $_GET['id']
            );
        }
    }

    public function getCommandeClientHistorique($idUtilisateur, $idAssociation){
        $get = self::$bdd->prepare('
                            SELECT c.id, c.date, c.statut,c.code, u1.login as client, u2.login as barman, a.nom AS nom_association, a.image, SUM(l.quantite) AS nbArticle, SUM(p.prix * l.quantite) AS addition
                            FROM commande c INNER JOIN ligneCommande l ON c.id = l.idCommande
                                INNER JOIN association a ON c.idAssociation = a.id    
                                INNER JOIN produit p ON l.idProduit = p.id
                                inner join utilisateurs u1 on c.idUtilisateur = u1.id
                                left join utilisateurs u2 on c.idBarman = u2.id
                            WHERE c.idUtilisateur = ? AND c.idAssociation = ? AND c.date = l.date
                            GROUP BY c.id, c.date, c.statut, a.nom, a.image
                            ORDER BY c.date DESC');
        $get->execute([$idUtilisateur, $idAssociation, ]);
        return $get->fetchAll();
    }

    public function getLoginUtilisateur($idUtilisateur){
        $get = self::$bdd->prepare('
            select login from utilisateurs where id = (?)
        ');
        $get->execute([$idUtilisateur]);
        return $get->fetchColumn();
    }

    public function getCommandeFournisseur ($idAssociation){
        $get = self::$bdd->prepare('SELECT h.date, h.quantite, p.nom AS nomProduit, f.*, u.login AS loginUtilisateur FROM historiqueRestock h INNER JOIN produit p ON h.idProduit = p.id
                                                                INNER JOIN fournisseur f ON h.idFournisseur = f.id
                                                                INNER JOIN utilisateurs u ON h.idGestionnaire = u.id
                                        WHERE h.idAssociation = ?
                                        ORDER BY h.id DESC ');
        $get->execute([$idAssociation]);
        return $get->fetchAll();
    }

    public function getHistoriqueCommandesAsso($asso)
    {
        $get = self::$bdd->prepare('
                            SELECT c.id, c.date, c.statut, u1.login as client, u2.login as barman, a.nom AS nom_association, a.image, SUM(l.quantite) AS nbArticle, SUM(p.prix * l.quantite) AS addition
                            FROM commande c INNER JOIN ligneCommande l ON c.id = l.idCommande
                                INNER JOIN association a ON c.idAssociation = a.id    
                                INNER JOIN produit p ON l.idProduit = p.id
                                inner join utilisateurs u1 on c.idUtilisateur = u1.id
                                left join utilisateurs u2 on c.idBarman = u2.id
                            WHERE c.idAssociation = ?
                            GROUP BY c.id, c.date, c.statut, a.nom, a.image
                            ORDER BY c.date DESC');
        $get->execute([$asso]);
        return $get->fetchAll();
    }
    public function getProfilUtilisateur($idUtilisateur){
        $profil = self::$bdd->prepare('SELECT login, email, solde FROM utilisateurs inner join solde on id=idUtilisateur WHERE id = ?');
        $profil->execute([$idUtilisateur]);
        return $profil->fetch(PDO::FETCH_ASSOC);
    }

    public function getNombreCommandeEnCours ($idAssociation){
        $get = self::$bdd->prepare('SELECT count(*) FROM commande WHERE idAssociation = ? AND statut = "EnCours" AND cast(date AS DATE) = cast(? AS DATE)');
        $get->execute([$idAssociation, $this->recupererDate()]);
        return $get->fetchColumn();
    }
    public function verifCode($code,$idCommande,$date){
        $req = self::$bdd->prepare("select code from commande where id=? AND date=?");
        $req->execute([$idCommande,$date]);
        if($req->fetchColumn()==$code){return true;}return false;
    }

}