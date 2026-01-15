<?php
include_once 'modele_compte.php';
include_once 'vue_compte.php';

class ContCompte{
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleCompte();
        $this->vue = new VueCompte();
    }

    /**
     * afficher le formulaire de rechargement + affiche son solde
    */
    public function formRecharger(){
        if ($_SESSION['role'] == 'Client' && isset($_SESSION['asso'])){
            $this->vue->afficherFormRecharger(
                $_SESSION['soldeClient']
            );
        }
    }

    /**
     * méthode pour recharger un compte client dans une association
     * regarde si le solde est positive
     * regarde s'il a deja rechargé dans cette association (qui a choisit)
     * jamais recharger -> INSERT
     * deja recharger -> UPDATE (son solde)
     */
    public function recharger(){
        if ($_SESSION['role'] == 'Client' && isset($_POST['montant']) && isset($_SESSION['id']) && isset($_SESSION['asso'])){
            $montant = $_POST['montant'];
            $idClient = $_SESSION['id'];
            $idAsso = $_SESSION['asso'];
            if ($montant > 0){
                if (!$this->modele->chercherClient($idClient, $idAsso)){
                    $this->modele->insertClientSolde($idClient, $idAsso, $montant);
                } else {
                    $this->modele->updateClientSolde($idClient, $idAsso, $montant);
                }
                $_SESSION['messageOk'] = "Rechargement Réussie";
            }else {
                $_SESSION['messagePasOk'] = "Erreur rechargement";
            }
            header('Location: index.php?module=produit');
            exit;
        }
    }

    public function profil(){
        if (isset($_SESSION['role'])){
            $this->vue->afficherProfil(
                $this->modele->getProfilUtilisateur($_SESSION['id']),
                $_SESSION['id']
            );
        }
    }

    public function modifierProduit(){
        echo $_GET['id'];
        if (isset($_SESSION['role']) && isset($_POST['login'])){
            $this->modele->updataProfilUtilisateur(
                $_SESSION['id'],
                $_POST['login']
            );
            $_SESSION['login'] = $_POST['login'];
            $this->profil();
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}

