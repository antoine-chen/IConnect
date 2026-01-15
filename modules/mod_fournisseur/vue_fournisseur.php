<?php
include_once "vue_generique.php";
class VueFournisseur extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherFormAjoutFournisseur(){
        echo '
            
            <form method="post" action="index.php?module=fournisseur&action=ajouterFournisseur" class="container">
                <h2 class="text-center">Ajouter un fournisseur</h2>
                <div class="form-floating mt-3 mb-2">
                    <input name="nom" class="form-control" placeholder="Nom" required>
                    <label>Nom</label>
                </div>
                <div class="form-floating mt-3 mb-2">
                    <input name="email" class="form-control" placeholder="Email" required>
                    <label>Email</label>
                </div>
                <div class="form-floating mt-3 mb-2">
                    <input name="ville" class="form-control" placeholder="Ville" required>
                    <label>Ville</label>
                </div>
                <div class="form-floating mt-3 mb-2">
                    <input name="telephone" class="form-control" placeholder="Téléphone" required>
                    <label>Téléphone</label>
                </div>
                <input class="btn btn-primary" type="submit" value="Ajouter">
            </form>
        ';
    }

    public function afficherListeFournisseur($listeFournisseur){
        echo '
            <div class="table-responsive container">
                <table class="table table-bordered table-hover text-center">
                    <tr> 
                        <th>Nom</th> 
                        <th>Email</th>
                        <th>Ville</th> 
                        <th>Télephone</th>
                    </tr>    
        ';
        foreach ($listeFournisseur as $fournisseur) {
            echo '
                <tr>
                    <td>'. $fournisseur['nom'].'</td>
                    <td>'. $fournisseur['email'].'</td>
                    <td>'. $fournisseur['ville'].'</td>
                    <td>'. $fournisseur['tel'].'</td>
                    <td>
                        <a href="index.php?module=fournisseur&action=supprimerFournisseur&id='.$fournisseur['id'].'" class="btn btn-light border">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                    </td>
                </tr>
            ';
        }
        echo '
                </table>
            </div>
            <div class="text-center m-3">
                <a href="index.php?module=fournisseur&action=formAjouterFournisseur" class="btn btn-primary">Ajouter un fournisseur</a>
            </div>
        ';
    }
    public function afficher() {
        return $this->getAffichage();
    }
}