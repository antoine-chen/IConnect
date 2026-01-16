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
                   <h3>Recharger son compte</h3>
                   <p>'. $soldeClient.' €</p>
                </div>
                <form method="post" action="index.php?module=compte&action=recharger" class="mt-4 mb-4">
                   <div class="form-floating mb-2">
                       <input name="montant" class="form-control" placeholder="Montant">
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

    public function afficherProfil($profil, $idUtilisateur){
        echo '   
        <div class="container d-flex justify-content-center">
            <div class="container-color rounded-4 p-4 w-75">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center text-white fw-bold" style="height:60px;width:60px;">
                            <i class="bi bi-person fs-3"></i>
                        </div>
                        <h4>Mon profil</h4>
                    </div>

                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modifierProfil">
                        <i class="bi bi-pencil"></i> Modifier
                    </button>
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
        $this->afficherProfilModal($profil, $idUtilisateur, "index.php?module=compte&action=modifierProduit&id=");
    }


    public function afficherProfilModal($listeData, $idUtilisateur, $href){
        echo '
            <div class="modal fade" id="modifierProfil">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Modifier le compte</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="'.$href.$idUtilisateur.'" class="container">
                            <div class="form-floating mt-3 mb-2">
                                <input name="login" class="form-control" value="'. $listeData['login'].'" placeholder="Login" required>
                                <label>Login</label>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <!-- ferme le modal -->
                                <a class="btn btn-secondary" data-bs-dismiss="modal">Annuler</a>
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </div>
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