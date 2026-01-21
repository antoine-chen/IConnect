<?php
include_once "modele_stock.php";
include_once "vue_stock.php";

class ContStock {
    private $modele;
    private $vue;

    public function __construct(){
        $this->modele = new ModeleStock();
        $this->vue = new VueStock();
    }

    /**
     * Affiche le dernier inventaire, si aucun inventaire a été crée, affiche une phrase pour demander à l'utilsateur de créer
     */
    public function stockProduits(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $idAsso = $_SESSION['asso'];
            $idInventaire = $this->modele->idInventaire($idAsso);
            $resultat = $this->modele->stockActuel($idInventaire);

            if(empty($resultat)) {
                $this->vue->inventaireVide();
            }
            else {
                $this->vue->afficherStockActuel($resultat);
            }
            $this->vue->boutons();
        }
        unset($_SESSION['messageOk']);
        unset($_SESSION['messagePasOk']);
    }

    /**
     * Affiche le formulaire pour faire l'inventaire pour une association, vérifie toutefois le role et session, login avant d'afficher
     */
    public function form_inventaire() {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $idAsso = $_SESSION['asso'];
            $resultat = $this->modele->listeProduitsAsso($idAsso);

            $this->vue->form_inventaire($resultat);
        }
    }

    /**
     * Ajout un nouveau inventaire dans la bd, fonctionne de cette manière :
     *      1 : Récupère le tableau contenant les données issus du formulaire de l'inventaire
     *      2 : Crée un inventaire (id, idAssociation,date) puis récupère son id
     *      3 : For each des produits du tableau
     *              A : Ajoute le produit (id et quantité) dans ligneInventaire
     */
    public function ajoutInventaire()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login']) && isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
                $idAsso = $_SESSION['asso'];
                $stockProduits = $_POST['stock'];

                $this->modele->creerInventaire($idAsso);
                $idNewInventaire = $this->modele->idInventaire($idAsso);

                foreach ($stockProduits as $idProduit => $quantiteProduit) {
                    $this->modele->ajouterProduit($idNewInventaire, $idProduit, $quantiteProduit);
                }
            $_SESSION['messageOk'] = 'Nouveau inventaire success';
            header("Location: index.php?module=stock");
            exit();
        }
    }

    /**
     * Affiche le formulaire pour choisir la date d'un inventaire pour faire le rapport, vérifie toutefois le role et session, login avant d'afficher
     */
    public function formChoixInventaireRapport()
    {
        if ($_SESSION['role'] == 'Gestionnaire' && isset($_SESSION['asso']) && isset($_SESSION['login'])) {
            $listeInventaire = $this->modele->getListeDatesInventaireAsso($_SESSION['asso']);
            $this->vue->afficherChoixInventaireRapport($listeInventaire);
        }
    }

    /**
     * Calcule les valeurs affichés par le rapport de l'inventaire choisit, il fonctionne de cette manière :
     *         1 : Récupère l'id/date du inventaire choisit ainsi que le prochain inventaire (celui crée après celui qu'on a choisi, càd si on a choisit un ancien inventaire)
     *              --> Si ce prochain inventaire existe pas (càd si on a pris l'inventaire le plus récent, alors on prend la date d'aujourd'hui)
     *         2 : For each des produits de l'association
     *              A : Récupère les pertes, stock initial et stock (stock actuel) du produit de l'inventaire choisit
     *              B : Récupère les ventes et restocks du produit dans la période entre la date de l'inventaire choisit et la date du prochain inventaire crée/aujourd'hui
     *              C : Récupère la variation de stock par une simple soustraction
     *              D : Envoie les donnnées dans la méthode de la vue pour afficher
     */
    public function rapport() {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
            $idAssociation = $_SESSION['asso'];
            $idInventaireChoisi = $_POST['idinventaire'];
            $dateChoisi = $this->modele->getDateInventaire($idInventaireChoisi);
            $inventaireSuivant = $this->modele->getInventaireSuivant($idAssociation, $dateChoisi);

            if ($inventaireSuivant) {
                $dateSuivant = $inventaireSuivant['date'];
            }
            else {
                $dateSuivant = $this->modele->recupereDateAujourdhui();
            }

            $produits = $this->modele->listeProduitsAsso($idAssociation);
            $rapport = [];
            foreach ($produits as $produit) {
                $idProduit = $produit['id'];
                $stockLigneDebut = $this->modele->getStockProduit($idInventaireChoisi, $idProduit);

                if ($stockLigneDebut && isset($stockLigneDebut['stockInitial'])) {
                    $quantiteInitiale = $stockLigneDebut['stockInitial'];
                }
                else {
                    $quantiteInitiale = 0;
                }

                if ($stockLigneDebut && isset($stockLigneDebut['stock'])) {
                    $quantiteActuelle = $stockLigneDebut['stock'];
                }
                else {
                    $quantiteActuelle = 0;
                }

                if ($stockLigneDebut && isset($stockLigneDebut['pertes'])) {
                    $pertes = $stockLigneDebut['pertes'];
                }
                else {
                    $pertes = 0;
                }

                $ventes = $this->modele->getVentesProduit($idProduit, $idAssociation, $dateChoisi, $dateSuivant);
                if (!$ventes) {
                    $ventes = 0;
                }

                $restocks = $this->modele->getRestocksProduit($idProduit, $idAssociation, $dateChoisi, $dateSuivant);
                if (!$restocks) {
                    $restocks = 0;
                }

                $variation = $quantiteActuelle - $quantiteInitiale;
                $rapport[] = [
                    'idProduit' => $idProduit,
                    'nom' => $produit['nom'],
                    'prix' => $produit['prix'],
                    'quantiteInitiale' => $quantiteInitiale,
                    'quantiteActuel' => $quantiteActuelle,
                    'ventes' => $ventes,
                    'pertes' => $pertes,
                    'variationstock' => $variation
                ];
            }
            $this->vue->afficherRapport($rapport,$dateChoisi);
        }
    }

    /**
     * Traite le formulaire pour ajouter une perte à un produit, fonctionne comme ceci :
     *      1 : Vérifie le role et le token
     *      2 : Récupère les données du formulaire (idProduit, pertes) ainsi que l'idiventaire actuel, et le stock actuel du produit qu'on veut modifier les pertes
     *      3 : Vérifie si stock actuel - pertes >= 0 (on doit pas pouvoir indiquer 6 de pertes si on a que 5 en stock par exemple), si oui on modifie la table
     */
    public function ajouterPertes()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Gestionnaire' && isset($_POST['tokenCSRF']) && Token::verifierToken($_POST['tokenCSRF'])) {
            $idProduit = $_GET['id'];
            $pertes = $_POST['perte'];
            $idInventaire = $this->modele->idInventaire($_SESSION['asso']);
            $stockProduit = $this->modele->getStockProduit($idInventaire,$idProduit);

            if($stockProduit['stock'] - $pertes >= 0) {
                $this->modele->updatePerte($idInventaire,$idProduit,$pertes);
                $_SESSION['messageOk'] = 'Enregistrement des '.$pertes.' perte(s) success';
            }else {
                $diff = $pertes -$stockProduit['stock'];
                $_SESSION['messagePasOk'] = 'Erreur les pertes sont supérieur au stock de '. $diff;
            }
        }
        $this->stockProduits();
    }

    public function stockProduitBarman()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Barman' && isset($_SESSION['asso']) && isset($_SESSION['login'])){
            $idAsso = $_SESSION['asso'];
            $idInventaire = $this->modele->idInventaire($idAsso);
            $resultat = $this->modele->stockActuel($idInventaire);

            $this->vue->stockProduitBarman($resultat);
        }
    }

    public function getVue(){
        return $this->vue->afficher();
    }
}