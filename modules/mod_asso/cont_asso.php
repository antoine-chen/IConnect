<?php
include_once "modele_asso.php";
include_once "vue_asso.php";
class ContAsso {
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleAsso();
        $this->vue = new VueAsso();
    }

    public function getAffichage(){
        return $this->vue->afficher();
    }

    private function quitterAssoc(){
        unset($_SESSION['role']);
        unset($_SESSION['asso']);
    }

    /**
     * si l'utilisateur quitte une association -> unset role et asso
    */
    public function afficherAssoInscris(){
        if (isset($_SESSION['role']) && isset($_SESSION['asso'])){
            $this->quitterAssoc();
        }
        if (isset($_SESSION['id'])){
            $this->vue->afficherListeAsso(
                $this->modele->getListeAssociationInscris($_SESSION['id'])
            );
        }
    }

    public function afficherAssoPasInscris(){
        if (isset($_SESSION['id'])){
            $this->vue->afficherListeAsso(
                $this->modele->getListeAssociationPasIncris($_SESSION['id'])
            );
        }
    }

    public function afficherAssoEnAttente(){
        if (isset($_SESSION['id'])){
            $this->vue->afficherListeAsso(
                $this->modele->getListeAssociationEnAttente($_SESSION['id'])
            );
        }
    }

    /**
     * permet d'attribuer un role à un utilisateur dans une association : Gestionnaire, Barman ou client
     * si l'utilisateur n'est jamais aller une association il aura le role Client
    */
    public function aAppuyeAsso() {
        if(isset($_GET['id']) && isset($_SESSION['login'])) {
            $idAsso = $_GET['id'];
            $_SESSION['asso'] = $idAsso;
            $idUtilisateur = $_SESSION['id'];

            if(!$this->modele->existeAssociaion($idAsso)) {
                $this->afficherAssoPasInscris();
            } else {
                $listeRoles = $this->modele->estPresentDansAsso($idAsso, $idUtilisateur);

                if(empty($listeRoles)) {
                    $this->modele->demandeAccesAssociation($idAsso, $idUtilisateur);
                    $this->afficherAssoEnAttente();
                }
                else if(isset($_GET['role'])) {
                    $roleChoisi = $_GET['role'];
                    $trouve = false;
                    foreach($listeRoles as $element){
                        if($element['role'] == $roleChoisi){
                            $trouve = true;
                            break;
                        }
                    }

                    if($trouve){
                        $_SESSION['role'] = $roleChoisi;

                        if($roleChoisi == 'Barman'){
                            header('Location: index.php?module=commande');
                            exit();
                        }
                        if($roleChoisi == 'Gestionnaire'){
                            header('Location: index.php?module=stock');
                            exit();
                        }
                        if($roleChoisi == 'Client'){
                            header('Location: index.php?module=produit');
                            exit();
                        }
                    } else {
                        header('Location: index.php?module=asso&action=afficherAssoInscris');
                        exit();
                    }
                }
                else if(count($listeRoles) >= 2) {
                    $this->vue->choixRole($listeRoles, $idAsso);
                }
                else {
                    $roleChoisi = $listeRoles[0]['role'];
                    $_SESSION['role'] = $roleChoisi;

                    if($roleChoisi == 'Barman'){
                        header('Location: index.php?module=commande');
                        exit();
                    }
                    if($roleChoisi == 'Gestionnaire'){
                        header('Location: index.php?module=stock');
                        exit();
                    }
                    if($roleChoisi == 'Client'){
                        header('Location: index.php?module=produit');
                        exit();
                    }
                }
            }
        }
    }

    public function formAssociation($messageErreur = ''){
        if (!isset($_SESSION['role'])){
            $this->vue->afficherFormAssociation($messageErreur);
        }
    }

    /**
     * ajouter une association
     * isset puis regarde si les champs sont vide
     * si pas vide INSERT sinon re affiche le form avec un message d'erreur
     */
    public function ajouterAssociation(){
        if (!isset($_SESSION['role'])) {
            $nomAssociation = $_POST['nom'];
            $idUtilisateur = $_SESSION['id'];
                $this->modele->insertAssociation($nomAssociation);

                $nomFichier = $this->modele->idAsso($nomAssociation);
                $extension = pathinfo($_FILES['imageAso']['name'], PATHINFO_EXTENSION);
                $cheminFichier = 'modules/mod_asso/logos/'.$nomFichier.'.'.$extension;
            move_uploaded_file($_FILES['imageAso']['tmp_name'], $cheminFichier);
                $this->modele->ajoutImage($nomFichier, $cheminFichier);
                $this->modele->enregistrerDemande($idUtilisateur,$nomFichier);
        }
        $this->formAssociation();
    }
}