<?php
include_once 'cont_admin.php';

class ModAdmin{
    private $controleur;
    private $action;

    public function __construct(){
        $this->controleur = new ContAdmin();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'formAssociation';

        $this->exec();
    }

    public function exec(){
        switch ($this->action) {
            case 'formAssociation':
                $this->controleur->formAssociation();
                break;
            case 'ajouterAssociation':
                $this->controleur->ajouterAssociation();
                break;
            case 'listerAssociation':
                $this->controleur->listerAssociation();
                break;
            case 'formAjouterGestionnaireOuBarman':
                $this->controleur->formAjouterGestionnaireOuBarman();
                break;
            case 'ajouterGestionnaireOuBarman':
                $this->controleur->ajouterGestionnaireOuBarman();
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
                echo "ffffffffffffffffffffffffffffffffffff";
                break;
        }
    }

    public function getAffichage(){
        return $this->controleur->getVue();
    }
}

