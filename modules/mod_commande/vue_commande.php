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
    //affiche les details d'une commande
    public function afficheDetailsCommande($quer){
        echo '
            <div class="col-6 table-responsive container">
                <table class="table table-bordered table-hover text-center">
                    <tr> 
                        <th>Nom</th> 
                        <th>Quantité</th>
                        <th>Prix</th> 
                    </tr>    
         ';
        foreach ($quer as $value) {
            echo '
                <tr>
                    <td>'. htmlspecialchars($value ['nom']).'</td>
                    <td>'. htmlspecialchars($value['quantite']).'</td>
                    <td>'. htmlspecialchars($value['prix']) .'</td>
                </tr>
            ';
        }
        echo '
                </table>
            </div>
        ';
    }
    //afiche les commande avec le details
    public function afficheCommandeComplete($quer,$details,$mode,$prix){
        echo'
                <div class="d-flex flex-column align-items-center ">
                    <div class="row border rounded-3">
                        <div class="col-6">
                            <p class="card-title"> #'. htmlspecialchars($quer['id']) . '</p>
                            <p> Date: '. htmlspecialchars($quer['date']) .'</p>
                            <p class="card-title"> Satuts de la commande: '.htmlspecialchars($quer ['statut']).'</p>
                            <p>'.$prix.'€</p>
                        </div>
        ';
                $this->afficheDetailsCommande($details);

        switch ($mode){
            case 0:
                echo '
                    <div class="col-12">
                        <a href="index.php?module=commande&action=valideCommande&id=' . $quer['id'] . '&date='.$quer['date'].'" class="btn btn-primary"> valider</a>
                        <a href="index.php?module=commande&action=refuserCommande&id=' . $quer['id'] . '&date='.$quer['date'].'" class="btn btn-primary"> refuser</a>
                    </div>
                ';
            break;
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