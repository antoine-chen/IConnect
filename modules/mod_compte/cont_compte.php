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
                $_SESSION['messageOk'] = "Rechargement réussi";
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

    public function formModifierProfil(){
        if (isset($_SESSION['role'])){
            $this->vue->afficherFormModifierProfil(
                $this->modele->getProfilUtilisateur($_SESSION['id']),
                $_SESSION['id']
            );
        }
    }

    public function modifierProfil(){
        if(isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
            if (isset($_SESSION['role']) && isset($_POST['login']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['email'])) {
                if (!$this->modele->verifLoginExisteProfil($_POST['login'],$_SESSION['id'])){
                    $this->modele->updataProfilUtilisateur($_SESSION['id'], $_POST['login'], $_POST['nom'], $_POST['prenom'], $_POST['telephone'], $_POST['email']);
                    if (!empty($_POST['pwd'])) {
                        $hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
                        $this->modele->updatePassword($_SESSION['id'], $hash);
                    }
                    $_SESSION['login'] = $_POST['login'];
                    $_SESSION['messageOk'] = "Votre profil a été modifié avec succès";
                } else {
                    $_SESSION['messagePasOk'] = "Le login existe déjà ";
                }
            }
        }
        switch ($_SESSION['role']) {
            case 'Client' :
                header('Location: index.php?module=produit');
                exit();
            case 'Barman' :
                header('Location: index.php?module=commande');
                exit();
            case 'Gestionnaire' :
                header('Location: index.php?module=stock');
                exit();
            case 'Admin' :
                header('Location: index.php?module=admin');
                exit();
        }
    }
    public function unrecognizedAction(){
        $this->vue->actionNonTrouver();
    }
    public function getVue(){
        if (isset($_SESSION['role'])&&$_SESSION['role']!='Admin') {
            return $this->vue->afficher();
        }else{header("Location: index.php", true, 303);
        exit();}

    }

    public function modalSuprimerProfil(){
        $this->vue->modalSuprimer();
    }
    public function suprimerProfil(){
        if (isset($_SESSION['role'])&&$_SESSION['role']!='Admin') {
            $this->modele->suprimerProfil($_SESSION['id'], $_SESSION['login']);
        }header("Location: index.php", true, 303);
        exit();
    }

}

