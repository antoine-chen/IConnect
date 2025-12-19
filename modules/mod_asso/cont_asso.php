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

            if($this->modele->existeAssociaion($idAsso)) {
                if(empty($resultat)) {
                    $this->modele->attribuerRoleClient($idAsso,$idUtilisateur);
                }
                switch ($resultat['role']) {
                    case 'Barman' :
                        header('Location: index.php?module=commande');
                        break;
                    case 'Gestionnaire' :
                        header('Location: index.php?module=stock');
                        break;
                    default :
                        header('Location: index.php?module=produit');
                        break;
                }
            } else {
                $this->afficherAsso();
            }

        }
    }
}