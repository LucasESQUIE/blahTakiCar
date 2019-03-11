<?php session_start();

require_once "../utilities/header.php"; ?>
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
            <form id="formProposer" action="trajetViewProposer.php"  method="post">
                <div class="tab">
                    <h4 class="sousTitre">Départ :</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" name="villeDep" id="villeDep"
                               placeholder="Ville de départ" required>
                    </div>

                    <div class="form-inline">
                        <input type="text" class="form-control" name="dateDep" id="dateDep"
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
                        <input type="text" class="form-control" name="heureDep" id="heureDep"
                               placeholder="Heure de départ" data-container="body" data-toggle="popover" data-trigger="focus"
                               data-placement="top" data-content="Format : 00h00" required>
                    </div>
                </div>
                <div class="tab">
                    <h4 class="sousTitre">Arrivée :</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" name="villeArr" id="villeArr"
                               placeholder="Ville d'arrivée" required>
                    </div>
                    <div class="form-inline">
                        <input type="text" class="form-control facul" name="etape1" id="etape1"
                               placeholder="Ville étape 1 (optionnel)">
                        <input type="text" class="form-control facul" name="etape2" id="etape2"
                               placeholder="Ville étape 2 (optionnel)">
                    </div>
                    <div class="form-group">

                    </div>
                </div>
                <div class="tab">
                    <h4 class="sousTitre aligneDebut">Informations supplémentaires :</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nbPlaces" id="nbPlace"
                               placeholder="Nombre de places" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="prix" id="prix"
                               placeholder="Prix (indicatif)">
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


<?php require_once "../utilities/footer2.php"; ?>