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
                        <h4>Mon profil chez '.$_SESSION['nomAsso'] .'</h4>
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
              <div class="d-flex justify-content-between align-items-center">
                   <h5>Modifier le compte chez '.$_SESSION['nomAsso'] .'</h5>
              </div>
              <form method="post" action="index.php?module=compte&action=modifierProfil&id='.$idUtilisateur.'" class="container">
                   <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
                   <div class="form-floating mb-1 mt-3">
                       <input name="login" class="form-control" value="'. $listeData['login'].'" placeholder="Login" required>
                       <label>Login</label>
                   </div>
                   <div class="form-floating mb-1">
                       <input name="nom" class="form-control" value="'. $listeData['nom'].'" placeholder="Nom" required>
                       <label>Nom</label>
                   </div>
                   <div class="form-floating mb-1">
                       <input name="prenom" class="form-control" value="'. $listeData['prenom'].'" placeholder="Prenom" required>
                       <label>Prenom</label>
                   </div>
                   <div class="form-floating mb-1">
                        <input name="telephone" class="form-control" value="'. $listeData['telephone'].'" placeholder="Telephone" required>
                        <label>Login</label>
                   </div>
                   <div class="form-floating mb-4">
                        <input name="email" class="form-control" value="'. $listeData['email'].'" placeholder="Email" required>
                        <label>Email</label>
                   </div>
                   <div class="d-flex justify-content-end gap-2">
                                <!-- ferme le modal -->
                       <a class="btn btn-secondary" data-bs-dismiss="modal">Annuler</a>
                       <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmer">Modifier</button>
                   </div>
        ';
        $this->afficherConfirmationModal("Changement de profil", "Êtes vous sur de changer votre profil ?", "Modifier");
        echo'
              </form>
        
        ';
    }


    public function afficher() {
        return $this->getAffichage();
    }
}