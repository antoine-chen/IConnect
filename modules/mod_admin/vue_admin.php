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
                        <a href="index.php?module=admin&action=formAjouterGestionnaire&id=' . $association['id'] . '">
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

    public function afficheFormAjouterGestionnaire($messageErreur){
        echo '
            <h2 class="text-center">Ajouter un gestionnaire</h2>
            <form method="post" action="index.php?module=admin&action=ajouterGestionnaire" class="container taille-formulaire">
                <p class="text-danger">' . $messageErreur . '</p>
                 <div class="form-floating">
                    <input name="login" class="form-control" placeholder="login"/>
                    <label>Login : </label>
                </div>
                <div class="form-floating">
                    <input name="pwd" class="form-control" placeholder="Mot de passe"/>
                    <label>Mot de passe : </label>
                </div>
                <button class="btn btn-primary" type="submit">Créer un gestionnaire</button>
            </form>
        ';
    }

    public function afficher() {
        return $this->getAffichage();
    }

}