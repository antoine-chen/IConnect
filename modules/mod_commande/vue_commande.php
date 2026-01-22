<?php
include_once "vue_generique.php";
class VueCommande extends VueGenerique {
    public function __construct(){
        parent::__construct();
    }
    //afiche toutes les commandes d'une association
    public function afficheListeCommande($quer){
        foreach ($quer as $value) {
            echo '<a href="index.php?module=commande&action=details&id=' . $value['id'] . '">' .
                $value ['id'] .
            $value ['date'] .
            $value ['statut'].'<br>';

        }
    }

    // affiche les details d'une commande
    public function afficheDetailsCommande($quer){
        echo '
        <div class="col-md-3 table-responsive">
            <table class="table table-sm table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr> 
                        <th>Produit</th> 
                        <th>Qté</th>
                        <th>Prix (€)</th> 
                    </tr>
                </thead>
                <tbody>
    ';
        foreach ($quer as $value) {
            echo '
            <tr>
                <td class="fw-semibold">'. htmlspecialchars($value['nom']) .'</td>
                <td>'. htmlspecialchars($value['quantite']) .'</td>
                <td>'. htmlspecialchars($value['prix']) .'</td>
            </tr>
        ';
        }
        echo '
                </tbody>
            </table>
        </div>
    ';
    }

    // affiche la commande avec les détails
    public function afficheCommandeComplete($quer, $details, $mode, $prix,$client,$barman){
        echo '
            <div class="container-color rounded-4 p-4 mb-4 w-50 col-lg-8 mx-auto">
            <div class="p-4 mb-4">
                <div class="row g-3 align-items-start">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">Commande #'. htmlspecialchars($quer['id']) .'</h5>
                        <p>Client : '.htmlspecialchars($client).'</p>
                        <p class="mb-1">
                            <i class="bi bi-calendar-event"></i>
                            <strong>Date :</strong> '. htmlspecialchars($quer['date']) .'
                        </p>
                        <div class="mb-1">
                            <i class="bi bi-info-circle"></i>
                            <strong>Statut : </strong><p class="badge bg-warning text-dark">'. htmlspecialchars($quer['statut']) .'</p>
                            <p><a href="index.php?module=commande&action=afficherProfile&id=' . $quer['id'] . '&date='.$quer['date'].'" class="btn btn-primary"> afficher profil</a></p>                        </div>
    
                        </div>
                        <p class="mb-1">
                            ';
                        if($mode==1) {
                            echo '
                                <strong>Géré par :</strong> '. htmlspecialchars($barman) .'
                        </p>
                            ';
                        }
        echo '
                        </p>
                        <p class="fs-5 fw-bold text-success mt-2">Total : '. htmlspecialchars($prix) .' €</p>
                    </div>
        ';
        $this->afficheDetailsCommande($details);

        switch ($mode){
            case 0:
                echo '
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="index.php?module=commande&action=valideCommande&id=' . $quer['id'] . '&date='.$quer['date'].'" class="btn btn-primary">Valider</a>
                        <a href="index.php?module=commande&action=refuserCommande&id=' . $quer['id'] . '&date='.$quer['date'].'" class="btn btn-danger"> refuser</a>
                    </div>
                ';
                break;
        }

        echo '
                </div>
            </div>
        </div>
        ';
    }

    public function afficherProfilModal($titre,$utilisateur){
        echo '
            <!-- ce bloc est une fenêtre modale, ajoute une animation  -->
            <div class="modal fade" id="profilClient">
                <!-- centre la modal verticalement dans l’écran -->
                <div class="modal-dialog modal-dialog-centered">
                    <!-- modal-content le rectangle blanc contient tout le contenu visible -->
                    <div class="modal-content p-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>'.$titre.'</h4>

                            <a href="index.php?module=commande&action=commandeAvancee" type="button" class="btn-close" aria-label="Close"></a>
                        </div>
                        <div>                            
                            <p>login:'.$utilisateur['login'] .'</p>
                            <p>mail:'.$utilisateur['email'].'</p>
                            <p>solde:'.$utilisateur['solde'].'</p></div>
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <!-- ferme le modal -->
                            <a href="index.php?module=commande&action=commandeAvancee" class="btn btn-secondary"> Fermer</a>
                        </div>
                    </div>
                </div>
            </div>
        ';
        echo '<script>const modal = new bootstrap.Modal(document.getElementById("profilClient"));
        modal.show();</script>';
    }

    public function afficherClientHistorique($historique){
        echo '
        <div class="container mt-5">
            <h3 class="text-center mb-4">
                <i class="bi bi-clock-history"></i> Historique de mes commandes chez '.$_SESSION['nomAsso'].'
            </h3>

            <div class="d-flex flex-column align-items-center gap-3">
    ';

        foreach ($historique as $commande){
            switch ($commande['statut']) {
                case 'Encours':
                    $badge = '<span class="badge bg-secondary">En cours</span>';
                    break;
                case 'rembourser':
                    $badge = '<span class="badge bg-success">Remboursement</span>';
                    break;
                case 'livrée':
                    $badge = '<span class="badge bg-success">Validée</span>';
                    break;
                default:
                    $badge = '<span class="badge bg-warning text-dark">rien</span>';
                    break;
            }

            echo '
            <div class="container-color rounded-4 p-4 w-75">
                <div class="row align-items-center">
                    <!-- Image asso -->
                    <div class="col-md-3 text-center">
                        <img src="'. htmlspecialchars($commande['image']) .'" alt="" class="img-fluid rounded" style="max-height:100px;">
                    </div>
                    <!-- Infos commande -->
                    <div class="col-md-6">
                        <h5 class="mb-1">Commande #'. htmlspecialchars($commande['id']) .'</h5>
                        <p class="mb-1 text-muted">
                            <i class="bi bi-shop"></i>
                            '. htmlspecialchars($commande['nom_association']) .'
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-calendar-event"></i>
                            '. htmlspecialchars($commande['date']) .'
                        </p>
                ';
                        if($commande['barman']) {
                            echo '
                                <p class="mb-1">
                                    <i class="bi bi-person"></i>
                                    Géré par : '.htmlspecialchars($commande['barman']).'
                                </p> 
                            ';
                        }
                echo '
                        <p class="mb-0">'.$badge.'</p>
                    </div>

                    <!-- Totaux -->
                    <div class="col-md-3 text-end">
                        <p class="mb-1"><strong>Articles :</strong> '. htmlspecialchars($commande['nbArticle']) .'</p>
                        <p class="fs-5 fw-bold text-success mb-0">'. $commande['addition'] .' €</p>
                    </div>
                </div>
            </div>
        ';
        }

        echo '
            </div>
        </div>
    ';
    }

    public function afficherHistoriqueCommandeFournisseur($historique){

        echo '
    <div class="container mt-5">
        <h3 class="text-center mb-4">
            <i class="bi bi-clipboard-data"></i> Historique des commandes fournisseurs de '.$_SESSION['nomAsso'].'
        </h3>

        <div class="d-flex flex-column gap-4 align-items-center">
    ';

        foreach ($historique as $commande){

            echo '
        <div class="container-color rounded-4 p-4 w-75">
            <div class="row g-3">

                <!-- Infos commande -->
                <div class="col-md-4">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-box-seam"></i> Commande
                    </h6>
                    <p class="mb-1">
                        <i class="bi bi-calendar-event"></i>
                        <strong>Date :</strong> '.htmlspecialchars($commande['date']).'
                    </p>
                    <p class="mb-1">
                        <strong>Produit :</strong> '.htmlspecialchars($commande['nomProduit']).'
                    </p>
                    <p class="mb-0">
                        <strong>Quantité :</strong> '.htmlspecialchars($commande['quantite']).'
                    </p>
                </div>

                <!-- Fournisseur -->
                <div class="col-md-5">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-truck"></i> Fournisseur
                    </h6>
                    <p class="mb-1"><i class="bi bi-person"></i>'.htmlspecialchars($commande['nom']).'</p>
                    <p class="mb-1 text-muted">
                        <i class="bi bi-envelope"></i> '.htmlspecialchars($commande['email']).'
                    </p>
                    <p class="mb-1">
                        <i class="bi bi-geo-alt"></i> '.htmlspecialchars($commande['ville']).'
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-telephone"></i> '.htmlspecialchars($commande['tel']).'
                    </p>
                </div>

                <!-- Utilisateur -->
                <div class="col-md-3">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-person"></i> Gestionnaire
                    </h6>
                    <span class="badge bg-secondary-subtle text-dark px-3 py-2">
                        '.htmlspecialchars($commande['loginUtilisateur']).'
                    </span>
                </div>

            </div>
        </div>
        ';
        }

        echo '
        </div>
    </div>
    ';
    }

    public function afficherHistoriqueCommandeAsso($commandes)
    {
        echo '
        <div class="container mt-5">
            <h3 class="text-center mb-4">
                <i class="bi bi-clock-history"></i> Historique des commandes clients chez '.$_SESSION['nomAsso'].'
            </h3>

            <div class="d-flex flex-column align-items-center gap-3">
    ';

        foreach ($commandes as $commande){
            switch ($commande['statut']) {
                case 'Encours':
                    $badge = '<span class="badge bg-secondary">En cours</span>';
                    break;
                case 'rembourser':
                    $badge = '<span class="badge bg-success">Remboursement</span>';
                    break;
                case 'livrée':
                    $badge = '<span class="badge bg-success">Validée</span>';
                    break;
                default:
                    $badge = '<span class="badge bg-warning text-dark">rien</span>';
                    break;
            }

            echo '
            <div class="container-color rounded-4 p-4 w-75">
                <div class="row align-items-center">
                    <!-- Image asso -->
                    <div class="col-md-3 text-center">
                        <img src="'. htmlspecialchars($commande['image']) .'" alt="" class="img-fluid rounded" style="max-height:100px;">
                    </div>
                    <!-- Infos commande -->
                    <div class="col-md-6">
                        <h5 class="mb-1">Commande #'. htmlspecialchars($commande['id']) .'</h5>
                        <p class="mb-1 text-muted">
                            <i class="bi bi-shop"></i>
                            '. htmlspecialchars($commande['nom_association']) .'
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-calendar-event"></i>
                            '. htmlspecialchars($commande['date']) .'
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-person"></i>
                            Client : '.htmlspecialchars($commande['client']).'
                        </p> 
                ';
            if($commande['barman']) {
                echo '
                                <p class="mb-1">
                                    <i class="bi bi-person"></i>
                                    Géré par : '.htmlspecialchars($commande['barman']).'
                                </p> 
                            ';
            }
            echo '
                        <p class="mb-0">'.$badge.'</p>
                    </div>

                    <!-- Totaux -->
                    <div class="col-md-3 text-end">
                        <p class="mb-1"><strong>Articles :</strong> '. htmlspecialchars($commande['nbArticle']) .'</p>
                        <p class="fs-5 fw-bold text-success mb-0">'. $commande['addition'] .' €</p>
                    </div>
                </div>
            </div>
        ';
        }

        echo '
            </div>
        </div>
    ';
    }

    public function afficherNomAsso($nbCommandes =""){
        echo '
            <div class="d-flex justify-content-center mb-3">
                <h3>Les commandes du jour chez '.$_SESSION['nomAsso'].'</h3>
                <div class="position-relative d-inline-block">
                    <i class="bi bi-receipt fs-4"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        '.$nbCommandes.'
                    </span>
                </div>
            </div>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}