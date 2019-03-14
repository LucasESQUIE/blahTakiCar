<?php session_start();

if(!isset($_SESSION['id'])) {
    header("Location: ../index.php?&action=connexion");
}

if(isset($_SESSION['idSession']) && $_SESSION['idSession'] != session_id()) {
    header("Location: ../index.php");
}
require_once "trajetController.php";

require_once "../utilities/header.php";

if(isset($messageErreur) && (!$messageErreur['heureValide'])) {
    $texteErreurHeure="et heure ";
} else {
    $texteErreurHeure = "";
}
?>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>

    <div class="container hautPage">
        <div class="row cadre">
            <div class="col-lg-12">
                <h2 class="titrePartie">Votre  trajet</h2>
            </div>
        </div>
        <div class="row cadre">
            <div class="col-lg-12">
                <form id="formProposer" action="trajetViewProposer.php?&action=propose"  method="post">
                    <div class="tab">
                        <?php if(isset($messageErreurBD) && (!$messageErreurBD)) { ?>
                            <div class="alert alert-danger">Problème lors de l'enregistrement dans la base de données</div>
                        <?php } ?>
                        <h4 class="sousTitre">Départ :</h4>
                        <div class="form-group">
                            <?php if(isset($messageErreur) && (!$messageErreur['villeDepValide'])) { ?>
                                <div class="invalid-text">Ville invalide</div>
                                <input type="text" class="form-control invalid" name="villeDep"
                                       placeholder="Ville de départ" required>
                            <?php } else {?>
                            <input type="text" class="form-control" name="villeDep" id="villeDep"
                                   placeholder="Ville de départ" required value = "<?php echo post('villeDep'); ?>">
                            <?php } ?>

                        </div>

                        <div class="form-inline">
                            <?php if(isset($messageErreur) && (!$messageErreur['dateValide'])) { ?>
                                <div class="invalid-text">Date <?php echo $texteErreurHeure;?>invalide </div>
                                <input type="text" class="form-control invalid" name="dateDep" id="dateDep"
                                       placeholder="Date de départ" required>
                                <script>
                                    $( function() {
                                        $( "#dateDep" ).datepicker({
                                            altField: "#datepicker",
                                            closeText: 'Fermer',
                                            prevText: 'Précédent',
                                            nextText: 'Suivant',
                                            currentText: 'Aujourd\'hui',
                                            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                                            monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                                            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                                            dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
                                            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                                            weekHeader: 'Sem.',
                                            dateFormat: 'dd/mm/yy',
                                            minDate:0,

                                        });
                                    });
                                </script>

                            <?php } else {
                                    if($texteErreurHeure == "et heure ") {?>
                                        <div class="invalid-text">Heure invalide </div>
                                    <?php } ?>
                            <input type="text" class="form-control" name="dateDep" id="dateDep"
                                   placeholder="Date de départ" required value= "<?php echo post('dateDep'); ?>">
                            <script>
                                $( function() {
                                    $( "#dateDep" ).datepicker({
                                        altField: "#datepicker",
                                        closeText: 'Fermer',
                                        prevText: 'Précédent',
                                        nextText: 'Suivant',
                                        currentText: 'Aujourd\'hui',
                                        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                                        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                                        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                                        dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
                                        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                                        weekHeader: 'Sem.',
                                        dateFormat: 'dd/mm/yy',
                                        minDate:0,

                                    });
                                });
                            </script>
                            <?php } ?>
                            <?php if($texteErreurHeure == "et heure ") { ?>
                                <input type="text" class="form-control invalid" name="heureDep" id="heureDep"
                                       placeholder="Heure de départ" data-container="body" data-toggle="popover" data-trigger="focus"
                                       data-placement="top" data-content="Format : 00h00" required>
                            <?php }else { ?>
                                <input type="text" class="form-control" name="heureDep" id="heureDep"
                                       placeholder="Heure de départ" data-container="body" data-toggle="popover" data-trigger="focus"
                                       data-placement="top" data-content="Format : 00h00" required value = "<?php echo post('heureDep'); ?>">
                            <?php } ?>

                        </div>
                    </div>
                    <div class="tab">
                        <h4 class="sousTitre">Arrivée :</h4>
                        <div class="form-group">
                            <?php if(isset($messageErreur) && (!$messageErreur['villeArrValide'])) { ?>
                                <div class="invalid-text">Ville invalide</div>
                                <input type="text" class="form-control invalid" name="villeArr" id="villeArr"
                                   placeholder="Ville d'arrivée" required>
                            <?php } else { ?>
                                <input type="text" class="form-control" name="villeArr" id="villeArr"
                                   placeholder="Ville d'arrivée" required value = "<?php echo post('villeArr'); ?>">
                            <?php } ?>
                        </div>
                        <div class="form-inline">
                            <?php if(isset($messageErreur) && (!$messageErreur['villeEt1Valide'])) { ?>
                                <div class="invalid-text">Ville invalide</div>
                                <input type="text" class="form-control facul invalid" name="etape1" id="etape1"
                                   placeholder="Ville étape 1 (optionnel)">
                            <?php } else {
                                    if(isset($messageErreur) && (!$messageErreur['villeEt2Valide'])) {?>
                                        <div class="invalid-text">Ville invalide</div>
                                    <?php } ?>
                                <input type="text" class="form-control facul" name="etape1" id="etape1"
                                   placeholder="Ville étape 1 (optionnel)" value = "<?php echo post('etape1'); ?>">
                            <?php } if(isset($messageErreur) && (!$messageErreur['villeEt2Valide'])) { ?>
                                <input type="text" class="form-control facul invalid" name="etape2" id="etape2"
                                   placeholder="Ville étape 2 (optionnel)">
                            <?php } else { ?>
                                <input type="text" class="form-control facul" name="etape2" id="etape2"
                                   placeholder="Ville étape 2 (optionnel)" value = "<?php echo post('etape2'); ?>">
                            <?php } ?>
                        </div>
                        <div class="form-group">

                        </div>
                    </div>
                    <div class="tab">
                        <h4 class="sousTitre aligneDebut">Informations supplémentaires :</h4>
                        <div class="form-group">
                            <?php if(isset($messageErreur) && (!$messageErreur['nbPlacesValide'])) { ?>
                                <div class="invalid-text">Nombre de places invalide</div>
                                <input type="text" class="form-control invalid" name="nbPlaces" id="nbPlace"
                                   placeholder="Nombre de places" required>
                            <?php } else { ?>
                                <input type="text" class="form-control" name="nbPlaces" id="nbPlace"
                                   placeholder="Nombre de places" required value = "<?php echo post('nbPlaces'); ?>">
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <?php if(isset($messageErreur) && (!$messageErreur['prixValide'])) { ?>
                                <div class="invalid-text">Prix invalide</div>
                                <input type="text" class="form-control invalid" name="prix" id="prix"
                                   placeholder="Prix (indicatif)">
                            <?php } else { ?>
                                <input type="text" class="form-control" name="prix" id="prix"
                                   placeholder="Prix (indicatif)" value = "<?php echo post('prix'); ?>">
                            <?php } ?>
                        </div>
                        <div class="form-group">
                        <textarea class="form-control" name="commentaires"
                                  placeholder="Commentaires (lieu de départ, d'arrivée précis,...)"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="bouton" id="btnSubmit">Proposer</button>
                    </div>
                </form>
            </div>
        </div>
        <script src="../public/javascript/proposerGUI.js"></script>
    </div>


<?php
require_once "../utilities/footer2.php"; ?>