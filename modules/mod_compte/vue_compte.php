<?php
include_once "vue_generique.php";
class VueCompte extends VueGenerique{

    public function __construct(){
        parent::__construct();
    }

    public function afficherFormRecharger($soldeClient){
        echo '
            <div class="taille-container container p-5 container-color rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                   <h3>Recharger son compte dans '.$_SESSION['nomAsso'] .'</h3>
                   <p>'. $soldeClient.' €</p>
                </div>
                <form method="post" action="index.php?module=compte&action=recharger" class="mt-4 mb-4">
                <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
                   <div class="form-floating mb-2">
                       <input name="montant" class="form-control" placeholder="Montant" type="number" min="1" required>
                       <label>Montant</label>
                   </div>
                   <button type="button" class="btn btn-primary m-4" data-bs-toggle="modal" data-bs-target="#confirmer">Confirmer</button>
        ';
        $this->afficherConfirmationModal("Rechargement de compte", "Êtes vous sûr ?", "Confirmer");
        echo '
                </form>
            </div>
        ';
    }

    public function afficherProfil($profil){
        echo '   
        <div class="container d-flex justify-content-center">
            <div class="container-color rounded-4 p-4 w-75">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center text-white fw-bold" style="height:60px;width:60px;">
                            <i class="bi bi-person fs-3"></i>
                        </div>
            ';
        if(isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {
            echo '
                <h4>Mon profil chez ' . $_SESSION['nomAsso'] . '</h4>
              ';
        }
        echo '
                    </div>

                    <a class="btn btn-outline-primary" href="index.php?module=compte&action=formModifierProfil">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                </div>
                <div class="list-group list-group-flush">
    ';
        foreach ($profil as $attribut => $dataUtilisateur){
            echo '
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <small>'. htmlspecialchars($attribut) .'</small>
                    <div class="fw-bold">'. htmlspecialchars($dataUtilisateur) .'</div>
                </div>
            </div>
        ';
        }
        echo '
                </div>
            </div>
        </div>
    ';
    }


    public function afficherFormModifierProfil($listeData, $idUtilisateur){
        echo '
        <div class="container my-4" style="max-width: 600px;">
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
    ';
        if(isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {
            echo '<h5 class="mb-0">Modifier le compte chez ' . htmlspecialchars($_SESSION['nomAsso']) . '</h5>';
        }
        echo '
                    </div>

                    <form method="post" action="index.php?module=compte&action=modifierProfil&id='.$idUtilisateur.'">
                        <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">

                        <div class="form-floating mb-3">
                            <input name="login" class="form-control" value="'.htmlspecialchars($listeData['login']).'" placeholder="Login" type="text" minlength="3" required>
                            <label>Login</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input name="nom" class="form-control" value="'.htmlspecialchars($listeData['nom']).'" placeholder="Nom" type="text" minlength="2" required>
                            <label>Nom</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input name="prenom" class="form-control" value="'.htmlspecialchars($listeData['prenom']).'" placeholder="Prénom" required>
                            <label>Prénom</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input name="telephone" class="form-control" value="'.htmlspecialchars($listeData['telephone']).'" placeholder="Téléphone" required>
                            <label>Téléphone</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input name="email" class="form-control" value="'.htmlspecialchars($listeData['email']).'" placeholder="Email" required>
                            <label>Email</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input name="pwd" class="form-control" placeholder="Mot de passe">
                            <label>Nouveau mot de passe</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Annuler
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmer">
                                Modifier
                            </button>
                        </div>
    ';
        $this->afficherConfirmationModal(
            "Changement de profil",
            "Êtes-vous sûr de vouloir modifier votre profil ?",
            "Modifier"
        );
        echo '
                    </form>
                </div>
            </div>
        </div>
    ';
    }



    public function afficher() {
        return $this->getAffichage();
    }
}