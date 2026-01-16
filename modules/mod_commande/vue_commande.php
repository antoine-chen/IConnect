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
            <div class="container-color rounded-4 p-4 mb-4 w-75 col-lg-8 mx-auto">
            <div class="p-4 mb-4">
                <div class="row g-3 align-items-start">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">Commande #'. htmlspecialchars($quer['id']) .'</h5>
                        <p class="mb-1">
                            <i class="bi bi-calendar-event"></i>
                            <strong>Date :</strong> '. htmlspecialchars($quer['date']) .'
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-info-circle"></i>
                            <strong>Statut :</strong><p class="badge bg-warning text-dark">'. htmlspecialchars($quer['statut']) .'</p>
                        </p>
    
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
                </div> <!-- row -->
            </div> <!-- padding -->
        </div> <!-- container-color -->
        ';

    }

    public function afficher() {
        return $this->getAffichage();
    }
}