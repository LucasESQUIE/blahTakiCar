<?php session_start();

if(!isset($_SESSION['id'])) {
    header("Location: ../index.php?&action=connexion");
}

if(isset($_SESSION['idSession']) && $_SESSION['idSession'] != session_id()) {
    header("Location: ../index.php");
}

require_once "userController.php";

modifPhotoProfil();
modifPhotoVoiture();
UpdateProfil();

require_once '../utilities/header.php'; ?>

    <br xmlns="http://www.w3.org/1999/html"/><br/>

    <br/>
    <br/>
    <form method="post" action="#" enctype="multipart/form-data">
        <div class="container cadre">
            <div class="row">
                <!-- bannière -->
                <button type="button" class="tablink" onclick="openPage('Profil', this)" id="defaultOpen"><span class="glyphicon glyphicon-user"></button>
                <button type="button" class="tablink" onclick="openPage('Voiture', this)"><span class="glyphicon glyphicon-dashboard"></button>
                <button type="button" class="tablink" onclick="openPage('Trajets', this)"><span class="glyphicon glyphicon-plane"></button>
                <button type="button" class="tablink" onclick="openPage('Archives', this)"><span class="glyphicon glyphicon-floppy-disk"></button>
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
                        <img src="<?=$valeur['photo_voiture']?>" class="avatar img-circle img-thumbnail" onclick="Fichier()"/>
                        <input type="file" id="my_file" name="imageVoiture" style="display: none;" /><br/><br/><br/>
                    </div>
                    <div class="col-lg-8">
                        <label for="marque">Marque</label>
                        <input type="text" name="marque" class="form-control profilText" value="<?=$valeur['marque_voiture'];?>"><br/><br/>
                        <label for="modele">Modèle</label>
                        <input type="text" name="modele" class="form-control profilText" value="<?=$valeur['modele_voiture'];?>"><br/><br/>
                        <label for="couleur">Couleur</label>
                        <input type="text" name="couleur" class="form-control profilText" value="<?=$valeur['couleur_voiture'];?>"><br/><br/>
                    </div>
                </div>

                <!-- Page trajets en cours -->
                <div id="Trajets" class="tabcontent">
                    <h3>Comming soon</h3>
                </div>

                <!-- Page trajets archivés -->
                <div id="Archives" class="tabcontent">
                    <h3>Comming soon</h3>
                </div>
                <br/><br/><input type="submit" class="bouton" value="Valider modifications"/><br/><br/>
            </div>
    </form>
    <script type="text/javascript" src="../public/javascript/interface.js"></script>
    <!-- footer -->
<?php require_once '../utilities/footer2.php'; ?>