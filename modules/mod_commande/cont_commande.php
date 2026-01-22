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
        $idCommande =isset($_GET['id']) ? $_GET['id'] : '';
        $this->vue->afficheDetailsCommande(
            $this->modele->derouléCommande($idCommande));
    }
*/
    public function commandeAvancee(){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Barman') {
            $commandes = $this->modele->toutesLesCommandesDuJour();
            $this->vue->afficherTitreCommandeJour(
                $this->modele->getNombreCommandeEnCours($_SESSION['asso'])
            );
            foreach ($commandes as $value) {
                $ligneCommandes = $this->modele->derouleCommande($value['id'], $value['date']);
                $nomClient = $this->modele->getLoginUtilisateur($this->modele->getClient($value['id'], $value['date']));
                $this->vue->afficheCommandeComplete(
                    $value,
                    $ligneCommandes,
                    0,
                    $this->modele->prixTotal($value['id'], $value['date']),$nomClient,""
                );
            }
        }
    }

    public function historique(){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Barman') {
            $commandes = $this->modele->toutesLesCommandes();
            $this->vue->afficherTitreHistorique();
            foreach ($commandes as $value) {
                $ligneCommandes = $this->modele->derouleCommande($value['id'], $value['date']);
                $nomClient = $this->modele->getLoginUtilisateur($this->modele->getClient($value['id'], $value['date']));
                $barman = $this->modele->getLoginUtilisateur($value['idBarman']);
                $this->vue->afficheCommandeComplete(
                    $value,
                    $ligneCommandes,
                    1,
                    $this->modele->prixTotal($value['id'], $value['date']),$nomClient,$barman
                );
            }
        }
    }

    public function valider($id,$date){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Barman' && isset($id) && isset($date)) {
                $this->modele->valideCommande(
                    $id,
                    $date
                );
        }
        header("Location: index.php?module=commande&action=commandeAvancee", true, 303);
        exit();
    }
    public function confirmationRetrait(){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Barman' && isset($_GET['id']) && isset($_GET['date'])) {
            $this->vue->confirmerRetrait('inserer code de retrait',$_GET['id'],$_GET['date']);
        }
    }
    public function verifierCodeDeRetrait(){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Barman' && isset($_POST['id']) && isset($_POST['date'])&& isset($_POST['code'])) {
            if($this->modele->verifCode($_POST['code'],
                $_POST['id'],
                $_POST['date'])){

                    $this->valider($_POST['id'],$_POST['date']);
            }

        }
    }


    public function refuser(){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Barman' && isset($_GET['id']) && isset($_GET['date'])) {
//            $idCommande = isset($_GET['id']) ? $_GET['id'] : '';
//            $date = isset($_GET['date']) ? $_GET['date'] : '';
            $idCommande = $_GET['id'];
            $date = $_GET['date'];

            $this->modele->rembourser(
                $this->modele->getClient($_GET['id'], $_GET['date']),
                $this->modele->prixTotal($idCommande, $date)
            );
            $this->modele->refuser($idCommande, $date);
            foreach ($this->modele->derouleCommande($idCommande, $date) as $l1) {
                $this->modele->restocker($l1['quantite'], $l1['idProduit']);
            }

        }
        header("Location: index.php?module=commande&action=commandeAvancee", true, 303);
        exit();
    }

    public function historiqueCommandeClient(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Client'){
            $this->vue->afficherClientHistorique(
                $this->modele->getCommandeClientHistorique($_SESSION['id'], $_SESSION['asso'])
            );
        }
    }

    public function historiqueCommandeFournisseur(){
        $this->vue->afficherHistoriqueCommandeFournisseur(
            $this->modele->getCommandeFournisseur($_SESSION['asso'])
        );
    }

    public function historiqueCommandeAsso(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire'){
            $commandes = $this->modele->getHistoriqueCommandesAsso($_SESSION['asso']);
            $this->vue->afficherHistoriqueCommandeAsso($commandes);
        }
    }

    public function afficherProfile(){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Barman' && isset($_GET['id']) && isset($_GET['date'])) {
            $client=$this->modele->getClient($_GET['id'], $_GET['date']);
            $this->profilDunUtilisateur($client);

        }
    }
    private function profilDunUtilisateur($id){
        if (isset($_SESSION['role'])&& $_SESSION['role']=='Barman'&&isset($_GET['id'])){
            $this->vue->afficherProfilModal('client',
                $this->modele->getProfilUtilisateur($id));
        }


    }

    public function getVue(){
        return $this->vue->afficher();
    }

}