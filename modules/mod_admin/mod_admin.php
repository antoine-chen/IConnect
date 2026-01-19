<?php
include_once 'cont_admin.php';

class ModAdmin{
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContAdmin();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'listerAssociation';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case 'listerAssociation':
                $this->controleur->listerAssociation();
                break;
            case 'afficherListeClient':
                $this->controleur->afficherListeClient();
                break;
            case 'donnerRoleBarman':
                $this->controleur->donnerRoleBarman();
                break;
            case 'enleverRoleBarman':
                $this->controleur->enleverRoleBarman();
                break;
            case 'bannirUtilisateur':
                $this->controleur->bannirUtilisateur();
                break;
            case 'listeDemandeCreationAsso' :
                $this->controleur->listeDemandeCreationAsso();
                break;
            case 'validerDemandeAsso' :
                $this->controleur->validerDemandeAsso();
                break;
            case 'refuserDemandeAsso' :
                $this->controleur->refuserDemandeAsso();
                break;
            case 'listerDemandeUtilisateur':
                $this->controleur->listerDemandeUtilisateur();
                break;
            case 'accepterDemande':
                $this->controleur->accepterDemande();
                break;
            case 'refuserDemande':
                $this->controleur->refuserDemande();
                break;
            default:
                echo "Action inconnu";
                break;
        }
    }

    public function getAffichage(){
        return $this->controleur->getVue();
    }
}

