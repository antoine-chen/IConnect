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

    /**
     * si je suis barman je peux donner le role barman à un client de mon asso
     * je peux enlever le role barman et ban l'utilisateur
    */
    public function afficherTabGestionComptes($listeComptes){
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
            <h2 class="text-center">Demandes d\'inscription chez '.$_SESSION['nomAsso'].'</h2>
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

//    public function afficherListeDemandeCreationAsso($demandesAsso)
//    {
//        echo '<div class="container mt-4">
//                <div class="row justify-content-center">
//                    <div class="col-12 table-responsive border rounded-3 p-3">
//                        <table class="table table-bordered table-hover text-center">
//                      <thead>
//                        <tr>
//                            <th>Login</th>
//                            <th>Nom de l\'association</th>
//                            <th>Image</th>
//                        </tr>
//                      </thead>
//                      <tbody>';
//
//        foreach ($demandesAsso as $element) {
//            echo '
//            <tr>
//                <td>' . htmlspecialchars($element['login']) . '</td>
//                <td>' . htmlspecialchars($element['nom']) . '</td>
//                <td>
//                    <img src="' . htmlspecialchars($element['image']) . '" class="img-association" alt="image-Asso">
//                </td>
//            </tr>
//        ';
//        }
//
//        echo '          </tbody>
//                    </table>
//                </div>
//            </div>
//        </div>';
//    }

    public function afficherListeDemandeCreationAsso($demandesAsso)
    {
        echo '<div class="container mt-4">
            <div class="row justify-content-center">';

        foreach ($demandesAsso as $element) {
            echo '
        <div class="col-12 mb-4 border rounded-3 p-3 table-responsive">
            <table class="table table-bordered table-hover text-center mb-3">
                <thead>
                    <tr>
                        <th>Login</th>
                        <th>Nom de l\'association</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>' . htmlspecialchars($element['login']) . '</td>
                        <td>' . htmlspecialchars($element['nom']) . '</td>
                        <td>
                            <img src="' . htmlspecialchars($element['image']) . '" class="img-association" alt="image-Asso">
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="col-12 text-center">
                <a href="index.php?module=admin&action=validerDemandeAsso&assoId=' . $element['assoId'] . '&utilisateurId=' . $element['utilisateurId'] . '" class="btn btn-primary me-2">Valider</a>
                <a href="index.php?module=admin&action=refuserDemandeAsso&assoId=' . $element['assoId'] . '&utilisateurId=' . $element['utilisateurId'] . '" class="btn btn-primary">Refuser</a>
            </div>
        </div>';
        }

        echo '    </div>
        </div>';
    }





}

