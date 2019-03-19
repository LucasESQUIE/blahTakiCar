<?php session_start();

if(!isset($_SESSION['id'])) {
    header("Location: ../index.php?&action=connexion");
}

if(isset($_SESSION['idSession']) && $_SESSION['idSession'] != session_id()) {
    header("Location: ../index.php");
}

require_once "userController.php";
require_once "userModel.php";
require_once '../utilities/header.php'; ?>


    <br/>
    <br/>
    <?php
    if (isset($_GET['view'])) {
        $valeurResume = $valeurTrajetArchives;
        $view = "view";
    } else if (isset($_GET['view1'])) {
        $valeurResume = $valeurTrajet;
        $view = "view1";
    }
    if (isset($_GET['view']) || isset($_GET['view1'])) {
        $texte = $valeurResume[htmlspecialchars($_GET[$view])]['villeDep'];
        $texte .= ' <span class="glyphicon glyphicon-arrow-right"></span> ';
        $texte .= $valeurResume[htmlspecialchars($_GET[$view])]['villeArr'];
        $texte .= '<br/><span class="glyphicon glyphicon-flag"></span>';
        if (is_null($valeurResume[htmlspecialchars($_GET[$view])]['villeEtape'])) {
            $texte .= ' Direct' ;
        } else {
            foreach (afficheEtapes($valeurResume[htmlspecialchars($_GET[$view])]['villeEtape']) as &$etapes) {
                $texte .= ' - '.$etapes;
            }
        }
        $texte .= '<br/><span class="glyphicon glyphicon-time"> </span> ';
        $texte .= $valeurResume[htmlspecialchars($_GET[$view])]['heureDep'];
        $texte .= '<br/><span class="glyphicon glyphicon-calendar"></span> ';
        $texte .= formatDate($valeurResume[htmlspecialchars($_GET[$view])]['dateDep']);
        $texte .= '<br/><span class="glyphicon glyphicon-user"></span> ';
        if ($valeurResume[htmlspecialchars($_GET[$view])]['idPassagers'] == "") {
            $texte .= ' Aucun passager' ;
        } else {
            foreach (affichePassagers($valeurResume[htmlspecialchars($_GET[$view])]['idPassagers']) as &$passagers) {
                $texte .= ' - '.$passagers;
            }
        }
        $texte .= '<br/><span class="glyphicon glyphicon-euro"></span> ';
        $texte .= $valeurResume[htmlspecialchars($_GET[$view])]['prix'];
        $texte .= '<br/><span class="glyphicon glyphicon-comment "></span> ';
        $texte .= $valeurResume[htmlspecialchars($_GET[$view])]['commentaires'];
        $texte .= '<br/><img src="'.recupInfoUser($valeurResume[htmlspecialchars($_GET[$view])]['idConducteur'])['photoUtilisateur'].'" class="avatarResume img-circle img-thumbnail"/>';
        $texte .= '<img src="'.recupInfoUser($valeurResume[htmlspecialchars($_GET[$view])]['idConducteur'])['photoVoiture'].'" class="avatarResume img-circle img-thumbnail"/>';
        require_once '../utilities/windowModal.php';
    }

    ?>

    <form method="post" action="#" enctype="multipart/form-data">
        <div class="container cadre">
            <div class="row">
                <!-- bannière -->
                <button type="button" class="tablink" onclick="openPage('Profil', this)" id="defaultOpen"><span class="glyphicon glyphicon-user"><br/>Profil</button>
                <button type="button" class="tablink" onclick="openPage('Voiture', this)"><span class="glyphicon glyphicon-dashboard"><br/>Voiture</button>
                <button type="button" class="tablink" onclick="openPage('Trajets', this)"><span class="glyphicon glyphicon-plane"><br/>Trajets</button>
                <button type="button" class="tablink" onclick="openPage('Archives', this)"><span class="glyphicon glyphicon-floppy-disk"><br/>Archives</button>
                <!-- Page profil utilisateur -->
                <div id="Profil" class="tabcontent">
                    <div class="col-lg-4">
                        <img src="<?=$valeur['photoUtilisateur']?>" class="avatar img-circle img-thumbnail" onclick="Fichier()"/>
                        <input type="file" id="my_file" name="imageUser" style="display: none;" /><br/><br/><br/>
                    </div>
                    <div class="col-lg-8">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" class="form-control profilText" value="<?=$valeur['prenom'];?>"><br/><br/>
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" class="form-control profilText" value="<?=$valeur['nom'];?>" ><br/><br/>
                        <label for="mail">Adresse mail</label>
                        <input type="email" name="mail" class="form-control profilText" value="<?=$valeur['mailUtilisateur'];?>" readonly><br/><br/>
                        <label for="tel">Numéro de Téléphone</label>
                        <input type="text" name="tel" class="form-control profilText" value="<?=$valeur['numTel'];?>"><br/><br/>
                        <label for="filiere">Filière</label>
                        <input type="text" name="filiere" class="form-control profilText" value="<?=$valeur['filiere'];?>"><br/><br/>
                    </div>
                </div>

                <!-- Page description voiture -->
                <div id="Voiture" class="tabcontent">
                    <div class="col-lg-4">
                        <img src="<?=$valeur['photoVoiture']?>" class="avatar img-circle img-thumbnail" onclick="Fichier()"/>
                        <input type="file" id="my_file" name="imageVoiture" style="display: none;" /><br/><br/><br/>
                    </div>
                    <div class="col-lg-8">
                        <label for="marque">Marque</label>
                        <input type="text" name="marque" class="form-control profilText" value="<?=$valeur['marqueVoiture'];?>"><br/><br/>
                        <label for="modele">Modèle</label>
                        <input type="text" name="modele" class="form-control profilText" value="<?=$valeur['modeleVoiture'];?>"><br/><br/>
                        <label for="couleur">Couleur</label>
                        <input type="text" name="couleur" class="form-control profilText" value="<?=$valeur['couleurVoiture'];?>"><br/><br/>
                    </div>
                </div>

                <!-- Page trajets en cours -->
                <div id="Trajets" class="tabcontent">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Départ</th>
                            <th scope="col">Arrivée</th>
                            <th scope="col">Date</th>
                            <th scope="col">Heure</th>
                            <th scope="col">Places</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Passagers</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = $nbTrajets['COUNT(*)'];
                        if ($i == 0) { ?>
                            <tr>
                                <td colspan="7">
                                    <h4>Aucun trajet en cours</h4>
                                    <p>Peut-être voulez-vous en <a href="#">proposer</a> un ?</p>
                                </td>
                            </tr>
                        <?php } else {
                            $keys = array_keys($valeurTrajet);
                            while($i-- > 0) { ?>
                                <tr>
                                    <td class="afficheVille" ><?=$valeurTrajet[$keys[$i]]['villeDep'];?></td>
                                    <td class="afficheVilleArr"><?=$valeurTrajet[$keys[$i]]['villeArr'];?></td>
                                    <td><?=formatDate($valeurTrajet[$keys[$i]]['dateDep']);?></td>
                                    <td><?=$valeurTrajet[$keys[$i]]['heureDep'];?></td>
                                    <td><?=$valeurTrajet[$keys[$i]]['nbPassagers'];?></td>
                                    <td><?=$valeurTrajet[$keys[$i]]['prix']."€";?></td>
                                    <?php if($valeurTrajet[$keys[$i]]['idPassagers'] == "") { ?>
                                        <td>Vous n'avez aucun passager.</td>
                                    <?php } else { ?>
                                    <td><?php foreach (affichePassagers($valeurTrajet[$keys[$i]]['idPassagers']) as &$value) { echo $value . " "; }?></td>
                                    <?php }
                                    if ($valeurTrajet[$keys[$i]]['idConducteur'] == $valeur['mailUtilisateur']) { ?>
                                    <td><a href='../trajets/trajetViewProposer.php?modif=<?php echo $keys[$i];?>'><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href='../trajets/trajetViewProposer.php?dupl=<?php echo $keys[$i];?>'><span class="glyphicon glyphicon-plus"></span></a>
                                        <a href='?suppr=<?php echo $keys[$i];?>'><span class="glyphicon glyphicon-remove"></span></a></td>
                                     <?php } else { ?>
                                        <td><span class="glyphicon glyphicon-minus"></span> <span class="glyphicon glyphicon-minus"></span> <span class="glyphicon glyphicon-minus"></span> </td>
                                     <?php } ?>
                                    <td><a href='?view1=<?php echo $keys[$i];?>'><span class="glyphicon glyphicon-search"></span></a></td>
                                </tr>
                        <?php }
                        } ?>
                        </tbody>
                    </table>

                </div>

                <!-- Page trajets archivés -->
                <div id="Archives" class="tabcontent">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Départ</th>
                            <th scope="col">Arrivée</th>
                            <th scope="col">Date</th>
                            <th scope="col">Heure</th>
                            <th scope="col">Places</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Passagers</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = $nbTrajetsArchives['COUNT(*)'];
                        if ($i == 0) { ?>
                            <tr>
                                <td colspan="7">
                                    <h4>Aucun trajet archivés</h4>
                                    <p>Peut-être voulez-vous en <a href="#">proposer</a> un ?</p>
                                </td>
                            </tr>
                        <?php } else {
                            $keys = array_keys($valeurTrajetArchives);
                            while($i-- > 0) { ?>
                                <tr>
                                    <td class="afficheVille" ><?=$valeurTrajetArchives[$keys[$i]]['villeDep'];?></td>
                                    <td class="afficheVilleArr"><?=$valeurTrajetArchives[$keys[$i]]['villeArr'];?></td>
                                    <td><?=formatDate($valeurTrajetArchives[$keys[$i]]['dateDep']);?></td>
                                    <td><?=$valeurTrajetArchives[$keys[$i]]['heureDep'];?></td>
                                    <td><?=$valeurTrajetArchives[$keys[$i]]['nbPassagers'];?></td>
                                    <td><?=$valeurTrajetArchives[$keys[$i]]['prix']."€";?></td>
                                    <?php if($valeurTrajetArchives[$keys[$i]]['idPassagers'] == "") { ?>
                                        <td>Vous n'avez aucun passager.</td>
                                    <?php } else { ?>
                                        <td><?php foreach (affichePassagers($valeurTrajetArchives[$keys[$i]]['idPassagers']) as &$value) { echo $value . " "; }?></td>
                                    <?php } ?>
                                    <td><a href='?view=<?php echo $keys[$i];?>'><span class="glyphicon glyphicon-search"></span></a></td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
                <input type="submit" class="bouton" value="Valider modifications"/><br/><br/>
            </div>
    </form>
    <!-- footer -->
<?php require_once '../utilities/footer2.php'; ?>