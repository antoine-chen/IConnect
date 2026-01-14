<?php
include_once 'vue_commande.php';
include_once 'modele_commande.php';

class ContCommande {
    private $modele;
    private $vue;

    public function __construct() {
        $this->modele = new ModeleCommande();
        $this->vue = new VueCommande();
    }
/*
    public function commande(){
        $this->vue->afficheListeCommande(
            $this->modele->toutesLesCommandes()
        );
    }
    public function details(){
        $id =isset($_GET['id']) ? $_GET['id'] : '';
        $this->vue->afficheDetailsCommande(
            $this->modele->derouléCommande($id));
    }
*/
    public function commandeAvancée(){
        $commandes = $this->modele->toutesLesCommandesDuJour();
        foreach ($commandes as $value){
            $ligneCommandes =$this->modele->derouléCommande($value['id'],$value['date']);
            $this->vue->afficheCommandeComplete($value,$ligneCommandes,0);
        }
    }


    public function historique(){
        $commandes = $this->modele->toutesLesCommandes();
        foreach ($commandes as $value){
            $ligneCommandes =$this->modele->derouléCommande($value['id'],$value['date']);
         $this->vue->afficheCommandeComplete($value,$ligneCommandes,1);
        }
    }
    public function valider(){
        $id =isset($_GET['id']) ? $_GET['id'] : '';
        $date =isset($_GET['date']) ? $_GET['date'] : '';
        $this->modele->valideCommande($id,$date);
        header("Location: index.php?module=commande&action=commandeAvancee",true,303);
        exit();
    }
    public function refuser(){
        $id =isset($_GET['id']) ? $_GET['id'] : '';
        $date =isset($_GET['date']) ? $_GET['date'] : '';
        $this->modele->rembourser($id,$this->modele->prixTotal($id,$date));
        $this->modele->refuser($id,$date);
        foreach ($this->modele->derouléCommande($id,$date) as $l1){
            $this->modele->restocker($l1['idProduit']);
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}