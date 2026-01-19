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

    public function formAssociation($messageErreur = ''){
        if ($_SESSION['role'] == 'Admin'){
            $this->vue->afficherFormAssociation($messageErreur);
        }
    }

    /**
     * ajouter une association
     * isset puis regarde si les champs sont vide
     * si pas vide INSERT sinon re affiche le form avec un message d'erreur
    */
    public function ajouterAssociation(){
        if (isset($_POST['nom']) && isset($_FILES['imageAso']) && $_SESSION['role'] == 'Admin') {
            $nomAssociation = $_POST['nom'];

            if (!empty($nomAssociation)){
                $this->modele->insertAssociation($nomAssociation);

                $nomFichier = $this->modele->idAsso($nomAssociation);
                $extension = pathinfo($_FILES['imageAso']['name'], PATHINFO_EXTENSION);
                $cheminFichier = 'modules/mod_asso/logos/'.$nomFichier.'.'.$extension;
                move_uploaded_file($_FILES['imageAso']['tmp_name'], $cheminFichier);
                $this->modele->ajoutImage($nomFichier, $cheminFichier);
            }else {
                $messageErreur = "il faut remplir les champs ";
                $this->formAssociation($messageErreur);
            }
        }
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


    public function getVue(){
        return $this->vue->afficher();
    }

}
