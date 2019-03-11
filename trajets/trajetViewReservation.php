<?php
session_start();

if(!isset($_SESSION['id'])) {
    header("Location: ../index.php?&action=connexion&etat=nc");
}

if(isset($_SESSION['idSession']) && $_SESSION['idSession'] != session_id()) {
    header("Location: ../index.php");
}

//TODO si l'id utilisateur est la même que id conducteur redirige vers profil/mesTrajets


require_once "../utilities/header.php";
require_once "../utilities/Input.php";
?>

<div class="container hautPage">
    <div class="row cadre">
        <div class="col-lg-12">
            <h2 class="titrePartie">Réserver un trajet</h2>
        </div>
    </div>
    <?php require_once "trajetController.php";?>
    <div class="row cadre">
        <div class="col-lg-12">
            <h3 class="titrePartie">Informations Trajet</h3>
        </div>
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <table class="tableReservation">
                <tbody>
                <?php if(isset($result['villeDep']) && isset($result['villeArr']) && isset($result['dateDep'])
                         && isset($result['heureDep']) && isset($result['idConducteur'])) { ?>
                    <tr>
                        <th class="ligneReservation">Départ : </th>
                        <td class="afficheVille ligneReservation"><?php echo $result['villeDep']; ?></td>
                    </tr>
                    <tr>
                        <th class="ligneReservation">Arrivée : </th>
                        <td class="afficheVilleArr ligneReservation"><?php echo $result['villeArr']; ?></td>
                    </tr>
                    <tr>
                        <th class="ligneReservation">Date : </th>
                        <td class="ligneReservation"><?php echo formatDate($result['dateDep']); ?></td>
                    </tr>
                    <tr>
                        <th class="ligneReservation">Heure : </th>
                        <td class="ligneReservation"><?php echo $result['heureDep']; ?></td>
                    </tr>
                    <tr>
                        <th class="ligneReservation">Conducteur :</th>
                        <td class="ligneReservation"><?php echo affichePrenomNom($result['idConducteur']); ?></td>
                    </tr>
                    <tr>
                        <th class="ligneReservation">Prix (indicatif) :</th>
                        <td class="ligneReservation"><?php echo $result['prix'].'€'; ?></td>
                    </tr>
                    <tr>
                        <th class="ligneReservation">Commentaires :</th>
                        <td class="ligneReservation"><?php echo $result['commentaires']; ?></td>
                    </tr>
                <?php }else{ ?>
                    <tr>
                        <td class="ligneReservation">Oups, il y a eu un problème... <br>
                            Retour aux résultats de la <a href="trajetViewRecherche.php">recherche</a></a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-2"></div>
    </div>

    <br>
    <div class="row cadre">
        <div class="col-lg-12">
            <form action="trajetViewReservation.php?&action=reserver" method="post">
                <input type="hidden" name="id" value="<?php echo $result['idTrajet'];?>">
                <input type="hidden" name="nbPlaces" value="<?php echo $result['nbPassagers']; ?>">
                <input type="hidden" name="idPassagers" value="<?php echo $result['idPassagers']; ?>">
                <input type="hidden" name="idConducteur" value="<?php echo $result['idConducteur']; ?>">
                <input type="hidden" name="dateDep" value="<?php echo $result['dateDep']; ?>">

                <button class="bouton positionBtn" type="submit">Réserver</button>
            </form>
        </div>
    </div>

</div>


<?php require_once "../utilities/footer2.php" ?>















