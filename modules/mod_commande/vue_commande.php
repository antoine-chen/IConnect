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
        <div class="col-md-6 table-responsive">
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
    public function afficheCommandeComplete($quer, $details, $mode, $prix){
        echo '
            <div class="container-color rounded-4 p-4 mb-4 w-50 col-lg-8 mx-auto">
            <div class="p-4 mb-4">
                <div class="row g-3 align-items-start">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">Commande #'. htmlspecialchars($quer['id']) .'</h5>
                        <p class="mb-1">
                            <i class="bi bi-calendar-event"></i>
                            <strong>Date :</strong> '. htmlspecialchars($quer['date']) .'
                        </p>
                        <div class="mb-1">
                            <i class="bi bi-info-circle"></i>
                            <strong>Statut : </strong><p class="badge bg-warning text-dark">'. htmlspecialchars($quer['statut']) .'</p>
                        </div>
    
                        <p class="fs-5 fw-bold text-success mt-2">Total : '. htmlspecialchars($prix) .' €</p>
                    </div>
        ';
        $this->afficheDetailsCommande($details);

        switch ($mode){
            case 0:
                echo '
                    <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                        <a href="index.php?module=commande&action=valideCommande&id=' . $quer['id'] . '&date='.$quer['date'].'" class="btn btn-primary"> valider</a>
                        <a href="index.php?module=commande&action=refuserCommande&id=' . $quer['id'] . '&date='.$quer['date'].'" class="btn btn-danger"> refuser</a>
                    </div>
                ';
                break;
            case 1:
                echo '
                    <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                        <a href="index.php?module=commande&action=refuserCommande&id=' . $quer['id'] . '&date='.$quer['date'].'" class="btn btn-success"> rembourser</a>
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

    public function afficherClientHistorique($historique){

        echo '
        <div class="container mt-5">
            <h3 class="text-center mb-4">
                <i class="bi bi-clock-history"></i> Historique de mes commandes
            </h3>

            <div class="d-flex flex-column align-items-center gap-3">
    ';

        foreach ($historique as $commande){
            switch ($commande['statut']) {
                case 'Validée':
                    $badge = '<span class="badge bg-success">Validée</span>';
                    break;
                default:
                    $badge = '<span class="badge bg-warning text-dark">En attente</span>';
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


    public function afficher() {
        return $this->getAffichage();
    }
}