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

    public function gestionCompte(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire'){
            $this->vue->afficherTabGestionComptes(
                $this->modele->getUtilisateurAsso($_SESSION['asso'])
            );
        }
        unset($_SESSION['messageOk']);
        unset($_SESSION['messagePasOk']);
    }

    /**
     * si le client n'a pas le role barman alors le gestiionnaire lui donne le role barman dans son asso
    */
    public function donnerRoleBarman(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_GET['id'])){
            $idUtilisateur = $_GET['id'];
            $idAssociation = $_SESSION['asso'];

            if (!$this->modele->dejaBarman($idUtilisateur, $idAssociation, "Barman")){
                $this->modele->insertRoleBarman($idUtilisateur, $idAssociation, "Barman");
                $_SESSION['messageOk'] = 'Promotion success';
            }else{
                $_SESSION['messagePasOk'] = 'Promotion fail, cette personne est déjà barman';
            }
            header('Location: index.php?module=admin&action=gestionCompte');
            exit();
        }
    }

    public function enleverRoleBarman(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_GET['id'])){
            $idUtilisateur = $_GET['id'];
            $idAssociation = $_SESSION['asso'];

            if ($this->modele->dejaBarman($idUtilisateur, $idAssociation, "Barman")){
                $this->modele->deleteRoleBarman($idUtilisateur, $idAssociation, "Barman");
                $_SESSION['messageOk'] = 'Le role barman a bien été enlever';
            }
            header('Location: index.php?module=admin&action=gestionCompte');
            exit();
        }
    }

    public function bannirUtilisateur(){
        if (isset($_SESSION['role']) && ($_SESSION['role'] == 'Gestionnaire' || $_SESSION['role'] == 'Admin') && isset($_SESSION['asso']) && isset($_GET['id'])){
            $idUtilisateur = $_GET['id'];
            $idAssociation = $_SESSION['asso'];
            $loginUtilisateur = $this->modele->getLogin($idUtilisateur);
            $this->modele->deleteUtilisateur($idUtilisateur, $idAssociation);
            $_SESSION['messageOk'] = 'Vous avez banni '.$loginUtilisateur;
            header('Location: index.php?module=admin&action=gestionCompte');
            exit();
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

    public function validerDemandeAsso()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            $idAsso = $_GET['assoId'];
            $idUtilisateur = $_GET['utilisateurId'];
            $this->modele->accepterAsso($idAsso);
            $this->modele->insertRoleGestionnaire($idUtilisateur,$idAsso,"Gestionnaire");
        }
        $this->listeDemandeCreationAsso();
    }

    public function refuserDemandeAsso()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            $idAsso = $_GET['assoId'];
            $this->modele->refuserAsso($idAsso);
        }
        $this->listeDemandeCreationAsso();
    }
    public function unrecognizedAction(){
        $this->vue->actionNonTrouver();
    }

    public function ajoutGestionnaire()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            $comptes = $this->modele->getUtilisateurNonRole($_GET['id'],'Gestionnaire');
            $this->vue->afficherTabAjoutGestionnaire($comptes);
        }
    }

    public function donnerRoleGestionnaire()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin' && isset($_SESSION['asso']) && isset($_GET['id'])){
            $idUtilisateur = $_GET['id'];
            $idAssociation = $_SESSION['asso'];

            if (!$this->modele->dejaBarman($idUtilisateur, $idAssociation, "Gestionnaire")){
                $this->modele->insertRoleBarman($idUtilisateur, $idAssociation, "Gestionnaire");
                $_SESSION['messageOk'] = 'Promotion success';
            }else{
                $_SESSION['messagePasOk'] = 'Promotion fail, cette personne est déjà barman';
            }
            header('Location: index.php?module=admin&action=listerAssociation');
            exit();
        }
    }

    public function enleverRoleGestionnaire()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin' && isset($_SESSION['asso']) && isset($_GET['id'])){
            $idUtilisateur = $_GET['id'];
            $idAssociation = $_SESSION['asso'];

            if ($this->modele->dejaBarman($idUtilisateur, $idAssociation, "Gestionnaire")){
                $this->modele->deleteRoleBarman($idUtilisateur, $idAssociation, "Gestionnaire");
                $_SESSION['messageOk'] = 'Le role barman a bien été enlever';
            }
            header('Location: index.php?module=admin&action=listerAssociation');
            exit();
        }
    }

    public function enleverGestionnaire()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'){
            $comptes = $this->modele->getUtilisateurAvecRole($_GET['id'],'Gestionnaire');
            $this->vue->afficherTabSuppressionGestionnaire($comptes);
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }
}
