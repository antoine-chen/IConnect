<?php

class VueGenerique {

    public function __construct() {
        ob_start();
    }

    public function getAffichage()
    {
        return ob_get_clean();
    }

    /**
     * @param $href utiliser pour le backend
     */
    public function afficherConfirmationModal($titre, $description, $action, $href=""){
        echo '
            <!-- ce bloc est une fenêtre modale, ajoute une animation  -->
            <div class="modal fade" id="confirmer">
                <!-- centre la modal verticalement dans l’écran -->
                <div class="modal-dialog modal-dialog-centered">
                    <!-- modal-content le rectangle blanc contient tout le contenu visible -->
                    <div class="modal-content p-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>'.$titre.'</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div>'.$description.'</div>
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <!-- ferme le modal -->
                            <a class="btn btn-secondary" data-bs-dismiss="modal">Annuler</a>
        ';
                if (!empty($href)) echo '<a href="'.$href.'" class="btn btn-primary">'.$action.'</a>';
                else echo '<button type="submit" class="btn btn-primary">'.$action.'</button>';
        echo '
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    public function confirmationProgressBar(){
        if (isset($_SESSION['messageOk']))
            echo '
                <div class="w-75 text-center mx-auto">
                    <div class="progress" style="height: 4px; background-color: #eee;">
                        <div class="progress-bar bg-success" style="width: 100%; animation: vider 5s linear forwards;"></div> <!-- animation -->
                    </div>
                    <div class="alert alert-success" role="alert">
                            '.$_SESSION['messageOk'].'
                    </div>
                </div>
            ';
        if (isset($_SESSION['messagePasOk']))
            echo '
                <div class="w-75 text-center mx-auto">
                    <div class="progress" style="height: 4px; background-color: #eee;">
                        <div class="progress-bar bg-danger" style="width: 100%; animation: vider 5s linear forwards;"></div> <!-- animation -->
                    </div>
                    <div class="alert alert-danger" role="alert">
                            '.$_SESSION['messagePasOk'].'
                    </div>
                </div>
            ';
    }


}

?>