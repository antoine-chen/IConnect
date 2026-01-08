<?php
include_once "vue_generique.php";
class VueFournisseur extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherListeFournisseur($listeFournisseur){
        echo '
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <tr> 
                        <th>Nom</th> 
                        <th>Email</th>
                        <th>Ville</th> 
                        <th>Numéro</th>
                    </tr>    
        ';
        foreach ($listeFournisseur as $fournisseur) {
            echo '
                <tr>
                    <td>'. $fournisseur['nom'].'</td>
                    <td>'. $fournisseur['email'].'</td>
                    <td>'. $fournisseur['ville'].'</td>
                    <td>'. $fournisseur['tel'].'</td>
                </tr>
            ';
        }
        echo '
                </table>
            </div>
        ';
    }
    public function afficher() {
        return $this->getAffichage();
    }
}