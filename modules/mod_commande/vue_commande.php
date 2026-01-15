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
        foreach ($quer as $value) {
            echo htmlspecialchars($value ['nom']) . htmlspecialchars('|quantité:' . $value['quantite']) . htmlspecialchars('|prix: ' . $value['prix']) . '</br>';
        }
    }
    //afiche les commande avec le details
    public function afficheCommandeComplete($quer,$details,$mode){
        echo'<div class="d-flex flex-column align-items-center ">';
                echo '<div class="row border rounded-3">'
                    . '<p class="card-title">' . htmlspecialchars('id commande: ' . $quer['id']) . '</p>' .
                    '<div class="col-6">' .
                    htmlspecialchars('date: ' . $quer ['date']) .
                    '<p class="card-title">' . htmlspecialchars('satuts de la commande: ' . $quer ['statut']) . '</p>'
                    . '</div>' .
                    '<div class="col-1">' . '</div>';
                $this->afficheDetailsCommande($details);
        switch ($mode){
            case 0:
            echo '<button><a href="index.php?module=commande&action=valideCommande&id=' . $quer['id'] . '&date='.$quer['date'].'"> valider</a></button>';
            echo '<button><a href="index.php?module=commande&action=refuserCommande&id=' . $quer['id'] . '&date='.$quer['date'].'"> refuser</a></button></div></div>';
            break;
            default:
                echo'</div></div>';
                break;
        }

    }
    public function afficher() {
        return $this->getAffichage();
    }
}