<?php
include_once 'modele_panier.php';
include_once 'vue_panier.php';

class ContPanier{
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModelePanier();
        $this->vue = new VuePanier();
    }

    /**
     * affiche le panier d'un client dans une association
    */
    public function panier(){
        if ($_SESSION['role'] == 'Client'){
            $idAsso = $_SESSION['asso'];
            $idUtilisateur = $_SESSION['id'];
            $addition = $this->modele->getPanierAddition($idAsso, $idUtilisateur)>0 ? $this->modele->getPanierAddition($idAsso, $idUtilisateur) : 0;
            $this->modele->deleteLignePanier($idUtilisateur, $idAsso);
            $this->vue->afficherPanier(
                $this->modele->getPanier($idAsso, $idUtilisateur),
                $addition,
                $_SESSION['soldeClient']
            );
        }
    }

    /**
     * ajoute un produit dans le panier du client de l'association
     * cas 1 -> je n'ai pas de panier -> INSERT panier + INSERT lignePanier
     * cas 2 -> j'ai un panier + j'ai jamais ajoute ce produit dans lignePanier -> INSERT lignePanier
     * cas 3 -> j'ai un panier + j'ai deja ajouté ce produit dans lignePanier -> UPDATE lignePanier
    */
    public function ajouterDansPanier(){
        if (isset($_GET['id']) && $_SESSION['role'] == 'Client'){
            $idProduit = $_GET['id']; // id produit que le client a cliqué
            $idAsso = $_SESSION['asso'];
            $idUtilisateur = $_SESSION['id'];

            if ($this->modele->assezDeStockProduit($idAsso ,$idProduit)){
                $idPanier = $this->modele->getIdPanier($idAsso, $idUtilisateur);
                if (!$idPanier){
                    $this->modele->insertPanier($idAsso, $idUtilisateur);
                    $idPanier = $this->modele->getIdPanier($idAsso, $idUtilisateur);
                    $this->modele->insertLignePanier($idPanier, $idProduit, 1); // click btn ajouter = 1 produit
                }else {
                    if ($this->modele->dejaAjouter($idPanier, $idProduit)){
                        $this->modele->updateLignePanierAjouter($idPanier, $idProduit);
                    } else {
                        $this->modele->insertLignePanier($idPanier, $idProduit, 1);
                    }
                }
                header('Location: index.php?module=produit');
                exit;
            }
        }
    }

    public function enleverProduit(){
        if (isset($_GET['id']) && $_SESSION['role'] == 'Client'){
            $this->modele->updateLignePanierEnlever(
                $this->modele->getIdPanier($_SESSION['asso'], $_SESSION['id']),
                $_GET['id'] // idProduit
            );
            $this->panier();
        }
    }

    /**
     * valide ou non le panier du client de l'association
     * si pour chaque produit du panier du client il y a assez de produit dans le stock de l'inventaire
     * alors je rentre dans la condition if ($assezStock == 1) et j'execute les actions de la validation du panier (voir le commantaire correspondant)
     * sinon je fais rien
    */
    public function validerPanier(){
        if ($_SESSION['role'] == 'Client'){
            $idUtilisateur = $_SESSION['id'];
            $idAsso = $_SESSION['asso'];
            $soldeUtilisateur = $this->modele->getSoldeUtilisateur($idUtilisateur, $idAsso) ? $this->modele->getSoldeUtilisateur($idUtilisateur, $idAsso) : 0;
            $addition = $this->modele->getPanierAddition($idAsso, $idUtilisateur) ? $this->modele->getPanierAddition($idAsso, $idUtilisateur) : 0;

            if ($addition > 0 && $soldeUtilisateur >= $addition){
                $panierClient = $this->modele->getPanier($idAsso, $idUtilisateur);
                // regarde pour chaque produit s'il y a assez de stock
                $assezStock = 1;
                foreach ($panierClient as $lignePanier){
                    if ($this->modele->assezDeStockProduit($idAsso, $lignePanier['id']) < 0) $assezStock = 0;
                }
                if ($assezStock == 1){
                    $this->insertCommandeEtLigneCommande($idUtilisateur, $panierClient, $idAsso);
                    $this->enleverStock($idAsso, $panierClient);
                    $this->modele->updateSoldeUtilisateur($idUtilisateur, $idAsso, $addition); // client paye son panier
                    $_SESSION['messageOk'] = "Votre panier a été validé, veuillez recuperer votre commande";
                }else {
                    $_SESSION['messagePasOk'] = "Erreur de stock, veuillez re faire à nouveau votre panier";
                }
            }
            $this->modele->deleteClientPanierEtLignePanier($idUtilisateur, $idAsso); // vide panier et ligne panier
            header("Location: index.php?module=produit");
            exit;
        }
    }
    // insert dans table commande et ligneCommande qui correspond au panier du client de l'association
    private function insertCommandeEtLigneCommande($idUtilisateur, $panierClient, $idAsso){
        $date = $this->modele->recupreDate();
        $idDerniereCommande = $this->modele->idDernierCommandeDuJour($idAsso, $date);

        $this->modele->insertCommande($idDerniereCommande+1, $idUtilisateur, $date, "Encours", $idAsso);
        foreach ($panierClient as $lignePanier){
            $this->modele->insertLigneCommande($idDerniereCommande+1, $lignePanier['id'], $lignePanier['quantite'], $date);
        }
    }

    // update le stock -> ce que le client a acheté
    private function enleverStock($idAsso, $panierClient){
        $idInventaire = $this->modele->idInventaire($idAsso);
        foreach ($panierClient as $lignePanier){
            $this->modele->updateLigneInventaire($idInventaire, $lignePanier['id'], $lignePanier['quantite']);
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }

}

