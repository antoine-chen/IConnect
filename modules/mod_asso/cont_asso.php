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
    public function afficherAsso(){
        if (isset($_SESSION['role']) && isset($_SESSION['asso'])){
            $this->quitterAssoc();
        }
        $this->vue->afficherListeAsso($this->modele->getListe());
    }

    /**
     * permet d'attribuer un role à un utilisateur dans une association : Gestionnaire, Barman ou client
     * si l'utilisateur n'est jamais aller une association il aura le role Client
    */
    public function aChoisitAsso(){
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
                        $_SESSION['role'] = 'Barman';
                        header('Location: index.php?module=commande');
                        break;
                    case 'Gestionnaire' :
                        $_SESSION['role'] = 'Gestionnaire';
                        header('Location: index.php?module=stock');
                        break;
                    default :
                        $_SESSION['role'] = 'Client';
                        header('Location: index.php?module=panier');
                        break;
                }
            } else {
                $this->afficherAsso();
            }

        }
    }
}