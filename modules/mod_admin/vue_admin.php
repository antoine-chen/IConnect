<?php

class VueAdmin {

    public function afficherFormAssociation(){
        echo '
            <form action="index.php?module=admin&action=ajouterAssociation" method="post" enctype="multipart/form-data">
                <label>Nom de lassociation :</label><br>
                <input name="nom"><br><br>
        
                <label>Choisissez une image :</label><br>
                <input type="file" id="image" name="image" accept="image/*" required><br><br>
        
                <button type="submit">Envoyer</button>
            </form>
        
        ';
    }

}