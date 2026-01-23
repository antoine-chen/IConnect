<?php
include_once "vue_generique.php";
class VueAdmin extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherListeAssociations($listeAssociations){
        echo '
        <h2 class="text-center mb-4">Liste des associations</h2>

        <div class="table-responsive container taille-tableau">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th style="width:50%">Association</th>
                        <th style="width:25%">Ajouter</th>
                        <th style="width:25%">Enlever</th>
                    </tr>
                </thead>
                <tbody>
    ';
        foreach ($listeAssociations as $association){
            echo '
            <tr>
                <td class="fw-semibold">
                    <a class="text-decoration-none"
                       href="index.php?module=admin&action=listerAssociation&id='.$association['id'].'">
                        '.htmlspecialchars($association['nom']).'
                    </a>
                </td>

                <td>
                    <a href="index.php?module=admin&action=ajoutGestionnaire&id='.$association['id'].'"
                       class="btn btn-success btn-sm">
                        <i class="bi bi-person-plus"></i>
                        <span class="d-none d-md-inline">Ajouter</span>
                    </a>
                </td>

                <td>
                    <a href="index.php?module=admin&action=enleverGestionnaire&id='.$association['id'].'"
                       class="btn btn-warning btn-sm">
                        <i class="bi bi-person-dash"></i>
                        <span class="d-none d-md-inline">Enlever</span>
                    </a>
                </td>
            </tr>
        ';
        }
        echo '
                </tbody>
            </table>
        </div>
    ';
    }



    /**
     * si je suis barman je peux donner le role barman à un client de mon asso
     * je peux enlever le role barman et ban l'utilisateur
    */
    public function afficherTabGestionComptes($listeComptes){
        $this->confirmationProgressBar();
        echo '
      <div class="container">  
            <h3 class="text-center mb-4">
                <i class="bi bi-people"></i> Gestion des comptes chez '.$_SESSION['nomAsso'].'
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
            echo'
                   <a class="btn btn btn-danger" href="index.php?module=admin&action=bannirUtilisateur&id='.$compte['id'].'">
                        <i class="bi bi-trash"></i>
                   </a>
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

    public function afficherListeDemandeCreationAsso($demandesAsso)
    {
        echo '<div class="container mt-4">
            <div class="row justify-content-center g-4">';

        foreach ($demandesAsso as $element) {
            echo '
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center align-middle mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Login</th>
                                    <th>Nom de l\'association</th>
                                    <th>Image</th>
                                    <th>Carte d\'identité</th>
                                    <th>Statut Asso</th>
                                    <th>Procès verbal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>' . htmlspecialchars($element['login']) . '</td>
                                    <td>' . htmlspecialchars($element['nom']) . '</td>
                                    <td>
                                        <img src="' . htmlspecialchars($element['image']) . '" class="img-fluid rounded" style="height:100px; object-fit:cover;" alt="image-Asso">
                                    </td>
                                    <td>
                                        <a href="' . htmlspecialchars($element['carteIdentitePDF']) . '" target="_blank" class="btn btn-sm btn-outline-primary">Voir PDF</a>
                                    </td>
                                    <td>
                                        <a href="' . htmlspecialchars($element['statutAssoPDF']) . '" target="_blank" class="btn btn-sm btn-outline-primary">Voir PDF</a>
                                    </td>
                                    <td>
                                        <a href="' . htmlspecialchars($element['procesVerbalPDF']) . '" target="_blank" class="btn btn-sm btn-outline-primary">Voir PDF</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="index.php?module=admin&action=validerDemandeAsso&assoId=' . $element['assoId'] . '&utilisateurId=' . $element['utilisateurId'] . '" class="btn btn-success me-2">Valider</a>
                        <a href="index.php?module=admin&action=refuserDemandeAsso&assoId=' . $element['assoId'] . '&utilisateurId=' . $element['utilisateurId'] . '" class="btn btn-danger">Refuser</a>
                    </div>
                </div>
            </div>
        </div>';
            $this->afficherConfirmationModal('Accepter', 'Voulez vous accepter cette personne à dans l\'association ?','Accepter',  'index.php?module=admin&action=validerDemandeAsso&assoId=' . $element['assoId'] . '&utilisateurId=' . $element['utilisateurId']);
            $this->afficherConfirmationModal('Accepter', 'Voulez vous refuser cette personne à dans l\'association ?', 'Refuser', 'href="index.php?module=admin&action=refuserDemandeAsso&assoId=' . $element['assoId'] . '&utilisateurId=' . $element['utilisateurId']);
        }
        echo '    </div>
        </div>';
    }

    public function afficherTabAjoutGestionnaire($comptes)
    {
        $this->confirmationProgressBar();
        echo '
      <div class="container">  
       <div class="container-color rounded-4 p-4 w-75 container">
       <h2 class="text-center mb-4">Mettre rôle gestionnaire</h2>    
         <div class="table-responsive container taille-tableau">
            <table class="table table-hover align-middle text-center">
                <tr class="table-light">
                    <th>Login</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th style="width: 10%"></th>
                </tr>
            ';
        foreach ($comptes as $compte) {
            echo '
                <tr>
                    <td>'.htmlspecialchars($compte['login']).'</td>
                    <td>'.htmlspecialchars($compte['prenom']).'</td>
                    <td>'.htmlspecialchars($compte['nom']).'</td>
                    <td>'.htmlspecialchars($compte['telephone']).'</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">

            ';
            if ($_SESSION['role'] == 'Admin'){
                echo '
                    <a href="index.php?module=admin&action=donnerRoleGestionnaire&id='.$compte['id'].'" class="btn btn-success">
                        <i class="bi bi-arrow-up-circle"></i>
                    </a>
                ';
            }
        }
        echo '
            </table>    
           </div>
          </div>  
        </div>  
        ';
    }

    public function afficherTabSuppressionGestionnaire($comptes)
    {
        $this->confirmationProgressBar();
        echo '
      <div class="container">  
       <div class="container-color rounded-4 p-4 w-75 container">    
         <div class="table-responsive container taille-tableau">
         <h2 class="text-center mb-4">Enlever rôle gestionnaire</h2>  
            <table class="table table-hover align-middle text-center">
                <tr class="table-light">
                    <th>Login</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th style="width: 10%"></th>
                </tr>
            ';
        foreach ($comptes as $compte) {
            echo '
                <tr>
                    <td>'.htmlspecialchars($compte['login']).'</td>
                    <td>'.htmlspecialchars($compte['prenom']).'</td>
                    <td>'.htmlspecialchars($compte['nom']).'</td>
                    <td>'.htmlspecialchars($compte['telephone']).'</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">

            ';
            if ($_SESSION['role'] == 'Admin'){
                echo '
                    <a href="index.php?module=admin&action=enleverRoleGestionnaire&id='.$compte['id'].'" class="btn btn-danger">
                        <i class="bi bi-arrow-down-circle"></i>
                    </a>
                ';
            }
        }
        echo '
            </table>    
           </div>
          </div>  
        </div>  
        ';
    }

    public function demandeCreationAssoVide()
    {
        echo '
                <h2 class="text-center my-4 fw-bold" style="font-size: 1.8rem;">
                    Aucun utilisateur a fait de demande de création d\'association
                </h2>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }
}

