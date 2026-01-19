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

    public function afficherListeClient(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire'){
            $this->vue->formAjouterBarman(
                $this->modele->getUtilisateurAsso($_SESSION['asso'])
            );
        }
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
            }
            header('Location: index.php?module=admin&action=afficherListeClient');
        }
    }

    public function enleverRoleBarman(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_GET['id'])){
            $idUtilisateur = $_GET['id'];
            $idAssociation = $_SESSION['asso'];

            if ($this->modele->dejaBarman($idUtilisateur, $idAssociation, "Barman")){
                $this->modele->deleteRoleBarman($idUtilisateur, $idAssociation, "Barman");
            }
            header('Location: index.php?module=admin&action=afficherListeClient');
        }
    }

    public function bannirUtilisateur(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_GET['id'])){
            $idUtilisateur = $_GET['id'];
            $idAssociation = $_SESSION['asso'];

            if ($this->modele->dejaBarman($idUtilisateur, $idAssociation, "Barman")){
                $this->modele->deleteUtilisateur($idUtilisateur, $idAssociation);
            }
            header('Location: index.php?module=admin&action=afficherListeClient');
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
}
