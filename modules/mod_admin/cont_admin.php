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
        $this->vue->afficherFormAssociation($messageErreur);
    }

    /*
       ajouter une association
       isset puis regarde si les champs sont vide si pas vide INSERT sinon re affiche le form avec un message d'erreur
    */
    public function ajouterAssociation(){
        if (isset($_POST['nom']) && isset($_FILES['imageAso'])){
            $nomAssociation = $_POST['nom'];
            $nomFichier = $_FILES['imageAso']['name'];

            $cheminFichier = 'modules/mod_asso/logos'. $nomFichier;
            move_uploaded_file($_FILES['imageAso']['tmp_name'], $cheminFichier);

            if (!empty($nomAssociation) && !empty($nomFichier)){
                $this->modele->insertAssociation($nomAssociation, $cheminFichier);
                echo ' ca marche ';
            }else {
                $messageErreur = "il faut remplir les champs ";
                $this->formAssociation($messageErreur);
            }
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}
