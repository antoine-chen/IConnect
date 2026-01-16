<?php
include_once 'modele_admin.php';
include_once 'vue_admin.php';

class ContAdmin{
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleAdmin();
        $this->vue = new VueAdmin();
    }

    public function listerAssociation(){
        if ($_SESSION['role'] == 'Admin'){
            $listeAssociations = $this->modele->getAssociations();
            $this->vue->afficherListeAssociations($listeAssociations);
        }
    }

    public function formAjouterGestionnaireOuBarman($messageErreur = ""){
        if (isset($_GET['id']) && $_SESSION['role'] == 'Admin'){
            $_SESSION['asso'] = $_GET['id'];
            $comptes = $this->modele->getUtilisateurNonRole($_SESSION['asso'], "Admin");

            $this->vue->afficheFormAjouterGestionnaireOuBarman("Ajouter un gestionnaire",$comptes, $messageErreur);
        }
        if ($_SESSION['role'] == 'Gestionnaire'){
            $comptes = $this->modele->getUtilisateurNonRole($_SESSION['asso'], "Gestionnaire");
            $this->vue->afficheFormAjouterGestionnaireOuBarman("Ajouter un barman",$comptes, $messageErreur);
        }
    }

    /**
     * ajouter un gestionnaire dans une assocation
     *  l'admin a la liste des utilisateurs -> il peut donner le role gestionnaire
     * le gestionnaire a la liste des clients (son asso) -> il peut donner le role barman à un client
    */
    public function ajouterGestionnaireOuBarman(){
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Gestionnaire') && isset($_SESSION['asso'])){

            $idUtilisateur = $_GET['id'];
            $idAssociation = $_SESSION['asso']; // voir formAjouterGestionnaire() si admin

            $this->insertGestionnaireOuBarman($idUtilisateur, $idAssociation);

            if($_SESSION['role'] == 'Gestionnaire') {
                header('Location: index.php?module=stock');
            }
             if($_SESSION['role'] == 'Admin') {
                header('Location: index.php');
            }
        }
    }

    private function insertGestionnaireOuBarman($idUtilisateur, $idAssociation){
        if ($_SESSION['role']){
            if ($_SESSION['role'] == 'Admin'){
                $this->modele->insertRoleGestionnaire($idUtilisateur, $idAssociation, "Gestionnaire");
            }
            if ($_SESSION['role'] == 'Gestionnaire'){
                $this->modele->insertRoleGestionnaire($idUtilisateur, $idAssociation, "Barman");
            }
        }
    }

    /**
     * lister les demandes des utililisateurs (pour rejoindre l'asso du gestionnaire)
     * accepterDemande() -> donne le role client dans l'asso
     * refuserDemande() -> supp la ligne dans role
     */
    public function listerDemandeUtilisateur(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso'])){
            $this->vue->afficherListeDemandeUtilisateur(
                $this->modele->getListeDemandeUtilisateur($_SESSION['asso'])
            );
        }
    }

    public function accepterDemande(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_GET['id'])){
            $this->modele->accepterDemandeUtilisateur(
                $_GET['id'],
                $_SESSION['asso']
            );
            $this->listerDemandeUtilisateur();
        }
    }

    public function refuserDemande(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_GET['id'])){
            $this->modele->refuserDemandeUtilisateur(
                $_GET['id'],
                $_SESSION['asso']
            );
            $this->listerDemandeUtilisateur();
        }
    }

    public function listeDemandeCreationAsso() {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            $demandesAsso = $this->modele->listeDemandeAsso();
            $this->vue->afficherListeDemandeCreationAsso($demandesAsso);
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

    public function validerDemandeAsso()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            $idAsso = $_GET['assoId'];
            $idUtilisateur = $_GET['utilisateurId'];
            $this->modele->accepterAsso($idAsso);
            $this->modele->insertRoleGestionnaire($idUtilisateur,$idAsso,"Gestionnaire");
        }
    }

    public function refuserDemandeAsso()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            $idAsso = $_GET['assoId'];
            $this->modele->refuserAsso($idAsso);
        }
    }
}
