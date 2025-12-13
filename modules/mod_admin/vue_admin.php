<?php
include_once "vue_generique.php";
class VueAdmin extends VueGenerique{
    public function __construct()
    {
        parent::__construct();
    }

    public function afficherFormAssociation($messageErreur){
        echo '
            <form action="index.php?module=admin&action=ajouterAssociation" method="post" enctype="multipart/form-data">
                <p>' . $messageErreur . '</p>
                <label>Nom de l\'association :</label><br>
                <input name="nom"><br><br>
        
                <label>Choisissez une image :</label><br>
                <input type="file" name="imageAso"><br><br>
        
                <button type="submit">Envoyer</button>
            </form>
        
        ';
    }

    public function afficherListeAssociations($listeAssociations){
        foreach ($listeAssociations as $association){
            echo "<a href='index.php?module=admin&action=listerAssociation&id=" . $association['id'] . "'>"
                . htmlspecialchars($association['nom']) . "</a>";
            echo "<button>Ajouter un gestionnaire</button> <br>";
        }
    }

    public function afficher() {
        return $this->getAffichage();
    }

}