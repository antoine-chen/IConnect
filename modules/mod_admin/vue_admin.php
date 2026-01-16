<?php
include_once "vue_generique.php";
class VueAdmin extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherFormAssociation($messageErreur){
        echo '
            <h2 class="text-center">Ajouter une association</h2>
            <form action="index.php?module=admin&action=ajouterAssociation" method="post" enctype="multipart/form-data" class="container taille-formulaire">
                <p class="text-danger">' . $messageErreur . '</p>
                <div class="form-floating">
                    <input name="nom" class="form-control" placeholder="Nom de l\'association">
                    <label>Nom de l\'association :</label><br>
                </div>
                <div class="mb-3">
                    <label for="imageAso" class="form-label">Choisissez une image :</label>
                    <input type="file" name="imageAso" id="imageAso" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        
        ';
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

    /**
     * si je suis barman je peux donner le role barman à un client de mon asso
     * je peux enlever le role barman et ban l'utilisateur
    */
    public function formAjouterBarman($listeComptes){
        echo '
      <div class="container">  
            <h3 class="text-center mb-4">
                <i class="bi bi-people"></i> Gestion des comptes
            </h3>
       <div class="container-color rounded-4 p-4 w-75 container">    
         <div class="table-responsive container taille-tableau">
            <table class="table table-hover align-middle text-center">
                <tr class="table-light">
                    <th>Login</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Rôle</th>
                    <th style="width: 10%"></th>
                </tr>
            ';
        foreach ($listeComptes as $compte) {
            switch ($compte['role']) {
                case 'Gestionnaire':
                    $badge = '<span class="badge bg-dark">Gestionnaire</span>';
                    break;
                case 'Barman':
                    $badge = '<span class="badge bg-primary">Barman</span>';
                    break;
                default:
                    $badge = '<span class="badge bg-secondary">Client</span>';
            }

            echo '
                <tr>
                    <td>'.htmlspecialchars($compte['login']).'</td>
                    <td>'.htmlspecialchars($compte['prenom']).'</td>
                    <td>'.htmlspecialchars($compte['nom']).'</td>
                    <td>'.htmlspecialchars($compte['telephone']).'</td>
                    <td>'.$badge.'</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">

            ';
            if ($_SESSION['role'] == 'Gestionnaire' && $compte['role'] == 'Client'){
                echo '
                    <a href="index.php?module=admin&action=donnerRoleBarman&id='.$compte['id'].'" class="btn btn-success">
                        <i class="bi bi-arrow-up-circle"></i>
                    </a>
                ';
            }
            if ($_SESSION['role'] == 'Gestionnaire' && $compte['role'] == 'Barman'){
                echo '
                   <a href="index.php?module=admin&action=enleverRoleBarman&id='.$compte['id'].'" class="btn btn-warning">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                   </a>
                ';
            }
            if ($compte['role'] != 'Gestionnaire'){
                echo '
                   <a href="index.php?module=admin&action=bannirUtilisateur&id='.$compte['id'].'" class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                   </a>
                ';
            }
            echo'
                        </div>
                    </td>
                </tr>
            ';
        }

        echo '
            </table>    
           </div>
          </div>  
        </div>  
        ';
    }

    public function afficherListeDemandeUtilisateur($listeDemande){
        echo '
            <div class="table-responsive taille-tableau container">
                <table class="table table-sm table-bordered table-hover text-center">
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