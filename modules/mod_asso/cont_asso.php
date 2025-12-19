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

    public function afficherAsso()
    {
        $this->vue->afficherListeAsso($this->modele->getListe());
    }

    public function aChoisitAsso()
    {
        if(isset($_GET['id']) && isset($_SESSION['login'])) {
            $idAsso = $_GET['id'];
            $_SESSION['asso'] = $idAsso;
            $idUtilisateur = $_SESSION['id'];

            $resultat = $this->modele->estPresentDansAsso($idAsso,$idUtilisateur);

            if(empty($resultat && $this->modele->existeAssociaion($idAsso))) {
                $this->modele->attribuerRoleClient($idAsso,$idUtilisateur);
            }
            switch ($resultat['role']) {
                case 'Barman' :
                    $_SESSION['role'] = 'Barman';
                    header('Location: index.php?module=commande');
                    break;
                case 'Gestionnaire' :
                    $_SESSION['role'] = 'Gestionnaire';
                    header('Location: index.php?module=stock');
                    break;
                default :
                    $_SESSION['role'] = 'Client';
                    header('Location: index.php?module=produit');
                    break;
            }
        }
    }
}