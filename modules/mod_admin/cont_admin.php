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
        ajouter un gestionnaire dans une assocation
        isset, regarde si les champs sont remplis
        si oui, INSERT un utilisateur et GET l'utilisateur, mettre le role Gestionnaire
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

    public function getVue(){
        return $this->vue->afficher();
    }

}
