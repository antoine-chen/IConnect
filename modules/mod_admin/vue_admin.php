<?php
include_once "vue_generique.php";
class VueAdmin extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherListeAssociations($listeAssociations){
        echo '
            <h2 class="text-center">Liste des associations</h2>
            <div class="table-responsive container taille-tableau">
                <table class="table table-bordered table-hover text-center"> 
                    <tr> 
                        <th style="width:70%;">Nom de l\'association</th> 
                        <th style="width:30%;"></th> 
                    </tr>    
        ';
        foreach ($listeAssociations as $association){
            echo '
                <tr>
                   <th>
                        <a href="index.php?module=admin&action=listerAssociation&id=' . $association['id'] . '">
                        ' . htmlspecialchars($association['nom']) . '
                        </a>
                    </th> 
                    <th>
                        <a href="index.php?module=admin&action=formAjouterGestionnaireOuBarman&id=' . $association['id'] . '">
                            <button type="button" class="btn btn-primary">
                                Ajouter un gestionnaire
                            </button>
                        </a>
                    </th>
                </tr>
            
            ';
        }
        echo '
                </table>
            </div>
        ';
    }

    public function afficheFormAjouterGestionnaireOuBarman($titre,$listeComptes, $messageErreur = ""){
        echo '
            <h2 class="text-center">'.$titre.'</h2>
            <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <tr>
                    <th>Login</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Ajouter</th>
                </tr>
            ';
        foreach ($listeComptes as $compte) {
            echo '
                <tr>
                    <td>'.htmlspecialchars($compte['login']).'</td>
                    <td>'.htmlspecialchars($compte['prenom']).'</td>
                    <td>'.htmlspecialchars($compte['nom']).'</td>
                    <td>'.htmlspecialchars($compte['telephone']).'</td>
                    <td><a href="index.php?module=admin&action=ajouterGestionnaireOuBarman&id='.$compte['id'].'">Ajouter</a></td>
                </tr>
            ';
        }

        echo '
            </table>    
            </div>
        ';
    }

    public function afficherListeDemandeUtilisateur($listeDemande){
        echo '
            <div class="table-responsive container">
                <table class="table table-bordered table-hover text-center">
                    <tr> 
                        <th>Login</th> 
                        <th>Nom</th>
                        <th>Prénom</th> 
                        <th>Télephone</th>
                        <th style="width: 10%;"></th>
                    </tr>    
        ';
        foreach ($listeDemande as $demande) {
            echo '
                <tr>
                    <td>'. $demande['login'].'</td>
                    <td>'. $demande['nom'].'</td>
                    <td>'. $demande['prenom'].'</td>
                    <td>'. $demande['telephone'].'</td>
                    <td>
                        <a href="index.php?module=admin&action=accepterDemande&id='.$demande['id'].'" class="btn btn-light border">
                            <i class="bi bi-check-lg"></i>
                        </a>
                        <a href="index.php?module=admin&action=refuserDemande&id='.$demande['id'].'" class="btn btn-light border">
                            <i class="bi bi-ban"></i>
                        </a>
                    </td>
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