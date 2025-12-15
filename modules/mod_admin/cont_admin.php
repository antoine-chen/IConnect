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

    /*
       ajouter une association
       isset puis regarde si les champs sont vide
       si pas vide INSERT sinon re affiche le form avec un message d'erreur
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

    public function formAjouterGestionnaire($messageErreur = ''){
        if (isset($_GET['id']) && $_SESSION['role'] == 'Admin'){
            $_SESSION['asso'] = $_GET['id'];
            $this->vue->afficheFormAjouterGestionnaire($messageErreur);
        }
    }

    /*
        ajouter un gestionnaire dans une assocation
        isset, regarde si les champs sont remplis
        si oui, INSERT un utilisateur et GET l'utilisateur, mettre le role Gestionnaire
     */
    public function ajouterGestionnaire(){
        if ($_SESSION['role'] == 'Admin' && isset($_SESSION['asso']) && isset($_POST['login']) && isset($_POST['pwd'])){
            $login = $_POST['login'];
            $pwd = $_POST['pwd'];
            $idAssociation = $_SESSION['asso'];
            if (!empty($login) && !empty($pwd) && !$this->modele->getUtilisateur($login)){
                // INSERT login pwd
                $hash = password_hash($pwd, PASSWORD_DEFAULT);
                $this->modele->insertUtilisateur($login, $hash);
                // GET utilisateur
                $idUtilisateur = $this->modele->getUtilisateur($login);
                // INSERT role Gestionnaire
                $this->modele->inserRoleGestionnaire($idUtilisateur, $idAssociation);
            }else {
                $messageErreur = "il faut remplir les champs ou login deja existant";
                $this->vue->afficheFormAjouterGestionnaire($messageErreur);
            }
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}
