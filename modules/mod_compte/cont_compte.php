<?php
include_once 'modele_compte.php';
include_once 'vue_compte.php';

class ContCompte{
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleCompte();
        $this->vue = new VueCompte();
    }
    public function formRecharger(){
        $this->vue->afficherFormRecharger(); // il faut verifier si c'est un client
    }

    /**
     * méthode pour recharger un compte client dans une association
     * regarde si le solde est positive
     * regarde s'il a deja rechargé dans cette association (qui a choisit)
     * jamais recharger -> INSERT
     * deja recharger -> UPDATE (son solde)
     */
    public function recharger(){
        if (isset($_POST['montant']) && isset($_SESSION['id'])){ // il faut verifier si c'est un client
            $montant = $_POST['montant'];
            $idClient = $_SESSION['id']; // $_SESSION['id']
            $idAsso = 1; // $_SESSION['asso'] idAsso quand j'ai choisi l'asso (cont_ass)
            if ($montant > 0){
                if (!$this->modele->chercherClient($idClient, $idAsso)){
                    $this->modele->insertClientSole($idClient, $idAsso, $montant);
                } else {
                    $this->modele->updateClientSolde($idClient, $idAsso, $montant);
                }
            }else {
                $this->vue->afficherFormRecharger();
            }
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}

