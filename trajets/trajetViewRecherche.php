<?php session_start();


require_once '../utilities/header.php';
require "trajetController.php";

?>

    <div class="container hautPage">
        <!-- Partie rechercher -->
        <div class="row">
            <div class="col-lg-12 cadre">
                <h2 class="titrePartie" >Rechercher un trajet :</h2>
                <form action="trajetViewRecherche.php?&action=recherche" method="post" class="form-inline">
                    <div class="col-lg-12  form-group">
                        <input type="text" name="villeDep" id="villeDep" placeholder="Départ" class="form-control zoneTxt positionZone" value="<?php if(isset($_POST['villeDep'])) { echo post('villeDep');} ?>" tabindex="1">
                        <button type="button" onclick="Switch(villeDep.value,villeArr.value)" class="btn bouton_switch"><span class="glyphicon glyphicon-resize-horizontal"></span></button>
                        <input type="text" name="villeArr" id="villeArr" placeholder="Arrivée" class = "form-control zoneTxt positionZone" value="<?php if(isset($_POST['villeArr'])) { echo post('villeArr');} ?>" tabindex="2">
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="text" id="date" name="date" placeholder="Date" class="form-control zoneTxt positionZone" tabindex="3">
                        </div>
                    </div>
                    <script>
                        $( function() {
                            $( "#date" ).datepicker({
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

                    <div class="col-lg-12">
                        <button type="submit" class="bouton positionBtn">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row cadre">
            <div class="col-lg-12">
                <h2 class="titrePartie">Trajets</h2>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Départ</th>
                    <th scope="col">Arrivée</th>
                    <th scope="col">Date</th>
                    <th scope="col">Heure</th>
                    <th scope="col">Places</th>
                    <th scope="col">Prix (indicatif)</th>
                    <th scope="col">Conducteur</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    global $tmp;
                    if(isset($trajetRech)) {
                        $tmp = $trajetRech;
                    }else if(isset($trajets)){
                        $tmp = $trajets;
                    }
                    $nbResults = $tmp->rowCount();
                    ?>

                    <?php if($nbResults == 0) { ?>
                        <tr>
                            <td colspan="7">
                                <h4>Aucun trajet disponible</h4>
                                <p>Peut-être voulez-vous en <a href="#">proposer</a> un ?</p>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php while($row = $tmp->fetch()) {  ?>
                        <tr onclick="document.location.href='trajetViewReservation.php?&id=<?php echo $row['idTrajet']; ?>'">
                            <td class="afficheVille" ><?php echo $row['villeDep']; ?></td>
                            <td class="afficheVilleArr"><?php echo $row['villeArr']; ?></td>
                            <td><?php echo formatDate($row['dateDep']); ?></td>
                            <td><?php echo $row['heureDep']; ?></td>
                            <td><?php echo $row['nbPassagers']; ?></td>
                            <td><?php echo $row['prix']."€"; ?></td>
                            <td><?php echo affichePrenomNom($row['idConducteur']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="../public/javascript/interface.js"></script>

<?php




?>

<?php require_once '../utilities/footer2.php'; ?>