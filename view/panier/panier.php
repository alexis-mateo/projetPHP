<?php
    $compteurPrix = 0;
    if(empty($tab)) {
        echo 'Le panier est vide !';
    } else {
        echo '<div class="home-content">';
        foreach ($tab as $t){
            $livre = ModelBook::select($t->get('isbn'))[0];
            $bISBN = $livre->get('isbn');
            $resultAuteur = "";
            $auteurs = ModelAuteur::getBookAuteurs($bISBN);

            foreach ($auteurs as $a) {
                $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ", ";
            }

            echo '<div class="livre">';
            if(!$livre->get('image')) {
                echo '<img src="../../ressource/linux.png"/>';
            } else {
                echo '<img src="data:image/jpeg;base64,'.base64_encode($livre->get('image')).'"/>';
            }
            echo '<div class="bookInfo">';
            echo '<p> Auteurs : '. $resultAuteur .'</p>';
            echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a>'. " " . $livre->get('titre') . '</p>';
            echo '<p> Quantité : '. $t->get('quantite') .'</p>';
            echo '<p> Prix : '. $livre->get('prix')*$t->get('quantite') . '€' .  '</p>';
            echo '</div>';
            echo '<div class="panier">';
            echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#book'. $livre->get('isbn') .'"><i class="fas fa-cubes"></i> Modifier la quantite </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="book'. $livre->get('isbn') .'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Modifier la quantite</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="index.php?controller=panier">
                            <div class="modal-body">
                                <div class="content">
                                    <fieldset>
                                            <div class="form-group">
                                                <input type="hidden" name="action" value="update">
                                                <input type="hidden" name="isbn" value=' . rawurlencode($bISBN) . '>
                                                <label for="quantite_id">Nouvelle quantite </label> :
                                                <input type="number" value = "' . $t->get('quantite') . '"name="quantite" id="quantite_id" min="1" required />
                                            </div>
                                     </fieldset>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Valider</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                          </div>
                        </form>
                        </div>
                      </div>
                    </div>';
            echo "<a class='btn btn-warning' role='button' href=\"index.php?controller=panier&action=delete&isbn=" . rawurlencode($bISBN) . "\"><i class=\"fas fa-times\"></i> Supprimer du panier</a>";
            echo '</div>';
            echo '</div>';
            $compteurPrix = $compteurPrix + ($livre->get('prix')*$t->get('quantite'));
        }
        echo '<div>';

        echo '<div class="panier-info">';
        echo 'Le prix total de la commande est de : ' . $compteurPrix . '€';
        echo '<a class="btn btn-success" href="index.php?controller=panier&action=acheterPanier">Passer la commande</a>';
        echo '<a class="btn btn-danger" href="index.php?controller=panier&action=clear">Vider le panier</a>';
        echo '</div>';
    }