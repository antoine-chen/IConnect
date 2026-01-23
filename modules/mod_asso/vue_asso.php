<?php
include_once "vue_generique.php";

class VueAsso extends VueGenerique {
    public function __construct(){
        parent::__construct();
    }

    public function titreInscrits()
    {
        echo '
        <h2 class="text-center my-4 fw-bold text-primary" style="font-size: 1.8rem;">
            Voici les associations auxquelles vous êtes inscrits
        </h2>
    ';
    }


    public function titreInscritsVide()
    {
        echo '
              <h2 class="text-center my-4 fw-bold" style="font-size: 1.8rem;">
                Vous n\'êtes inscrit sur aucune association, veuillez appuyer sur "Toutes les associations" ci dessus pour s\'inscrire à une association
              <h2>
        ';
    }

    public function titrePasInscrit()
    {
        echo '
                <h2 class="text-center my-4 fw-bold" style="font-size: 1.8rem;">
                    Voici les associations dont vous n\'êtes pas encore inscrit
                </h2>
        ';
    }

    public function titrePasInscritVide()
    {
        echo '
                <h2 class="text-center my-4 fw-bold" style="font-size: 1.8rem;">
                    Vous êtes inscrit à toutes les associations du site
                </h2>    
        ';
    }

    public function titreAttenteCreationVide()
    {
        echo '
        <h2 class="text-center my-4 fw-bold" style="font-size: 1.8rem;">
            Vous n\'avez aucune demande de création d\'association en cours de traitement.
        </h2>    
    ';
    }

    public function titreAttenteCreation()
    {
        echo '
        <h2 class="text-center my-4 fw-bold" style="font-size: 1.8rem;">
            Voici les associations dont vous avez demandé la création, actuellement en cours de traitement.
        </h2>    
    ';
    }


    public function afficherListeAsso($associations){
        echo '
    <div class="container my-5">
        <div class="row justify-content-center g-4">
    ';
        foreach ($associations as $elementAsso) {
            echo '
            <div class="col-10 col-sm-6 col-md-4 col-lg-3">
                <a href="index.php?module=asso&action=choisiAsso&id='.$elementAsso['id'].'"
                   class="text-decoration-none text-dark">

                    <div class="card h-100 shadow-sm text-center border-0">
                        <img src="'.$elementAsso['image'].'" class="card-img-top img-fluid" alt="">

                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-0">
                                '.htmlspecialchars($elementAsso['nom']).'
                            </h6>
                        </div>
                    </div>
                </a>
            </div>
        ';
        }
        echo '
        </div>
    </div>
    ';
    }


    public function afficherFormAssociation($messageErreur){
        $this->confirmationProgressBar();
        echo '
        <div class="container mt-5" style="max-width: 500px;">
            <div class="card shadow-sm">
                <div class="card-header text-center fw-semibold">
                    Ajouter une association
                </div>
                <div class="card-body">
                    <form action="index.php?module=asso&action=ajouterAssociation" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="tokenCSRF" value="' . htmlspecialchars(Token::genererToken()) . '">
                        <p class="text-danger text-center mb-3">' . $messageErreur . '</p>
                        <div class="form-floating mb-3">
                            <input name="nom" class="form-control" placeholder="Nom de l\'association" required>
                            <label>Nom de l\'association</label>
                        </div>

                        <div class="mb-4">
                            <label for="imageAso" class="form-label fw-semibold">
                                Image de l\'association (png, jpeg, jpg, webp)
                            </label>
                            <input type="file" name="imageAso" id="imageAso" class="form-control" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="carteIdentite" class="form-label fw-semibold">
                                Carte d\'identité de l\'utilisateur (pdf)
                            </label>
                            <input type="file" name="carteIdentite" id="carteIdentite" class="form-control" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="statutAsso" class="form-label fw-semibold">
                                Statut de l\'association (pdf)
                            </label>
                            <input type="file" name="statutAsso" id="statutAsso" class="form-control" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="procesVerbal" class="form-label fw-semibold">
                                Procès verbal (pdf)
                            </label>
                            <input type="file" name="procesVerbal" id="procesVerbal" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            Ajouter l\'association
                        </button>
                    </form>
                </div>
            </div>
        </div>
    ';
    }


    public function choixRole($roles, $idAsso) {
        echo '
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="d-flex flex-column gap-3">
            <h2 class="text-center">Choisir de se connecter en :</h2>
    ';

        foreach ($roles as $role) {
            echo '
        <div class="text-center">
            <a href="index.php?module=asso&action=choisiAsso&role='.$role['role'].'&id='.$idAsso.'" class="btn btn-primary">
                '.htmlspecialchars($role['role']).'
            </a>
        </div>
        ';
        }

        echo '
        </div>
    </div>
    ';
    }

    public function titreAttenteInscriptionVide()
    {
        echo '
        <h2 class="text-center my-4 fw-bold" style="font-size: 1.8rem;">
            Vous n\'avez aucune demande d\'inscription en cours dans une association.
        </h2>    
    ';
    }

    public function titreAttenteInscription()
    {
        echo '
        <h2 class="text-center my-4 fw-bold" style="font-size: 1.8rem;">
            Voici les associations pour lesquelles votre demande d\'inscription est en cours de traitement.
        </h2>    
    ';
    }


    public function afficher() {
        return $this->getAffichage();
    }

}