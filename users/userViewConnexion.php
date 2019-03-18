<?php
session_start();

require_once "userController.php";

if(isset($_GET['mail']) && isset($_GET['clefConfirm'])) {
    $mail = htmlspecialchars(urldecode($_GET['mail']));
    $clefConfirm = htmlspecialchars(urldecode($_GET['clefConfirm']));
    verificationMail($mail,$clefConfirm);
}


if(isset($_SESSION['id'])) {
    header("Location: ../index.php");
}

if(isset($_SESSION['idSession']) && $_SESSION['idSession'] != session_id()) {
    header("Location: ../index.php");
}

require_once '../utilities/header.php';
?>
    <!-- centre -->
    <div class="container hautPage">
        <!-- Partie connexion -->
        <div class="row">
            <div class="col-lg-12 cadre">
                <h2 class='titrePartie' id="posTitreConnexion">Connexion</h2>
                <?php if(isset($messageErreur) && !$messageErreur['compteConfirme']) { ?>
                    <h4 class="invalid-text">Veuillez confirmer votre compte via le mail que vous avez reçu</h4>
                <?php } ?>

                <?php if(isset($messageErreur) && !$messageErreur['compteValide']) { ?>
                    <h4 class="invalid-text">Adresse mail ou mot de passe incorrect</h4>
                <?php } ?>

                <form action="userViewConnexion.php?&action=connexion" method="post">
                    <div class="col-lg-12">
                        <?php if(isset($messageErreur) && !$messageErreur['mailValide']) { ?>
                        <div class="invalid-text">Format de l'email invalide</div>
                        <input type="text" name="mail" id="mail" class="form-control invalid" placeholder="Adresse Mail" required>
                        <?php } else { ?>
                        <input type="text" name="mail" id="mail" class="form-control zoneTxt" placeholder="Adresse Mail" required>
                        <?php } ?>
                        <br/>

                        <input type="password" name="mdp" id="mdp" class="form-control zoneTxt" placeholder="Mot de passe" required>
                        <br/>
                        <a href="http://localhost/blahTakiCar-master/users/userViewOubliMdp.php">Mot de passe oublié</a>
                        <!-- bouton ok -->
                        <div class="col-lg-12">
                            <button type='submit' class="bouton" id="postionBtnConnexion">Connexion</button>
                        </div>
                        <br/>
                    </div>
                </form>
            </div>
        </div>

    </div>
<?php
if(isset($_COOKIE['nonConnecte'])) {
    $texte = "Vous devez être connecté pour pouvoir réserver un trajet";
    require_once '../utilities/windowModal.php';
}

if(isset($_COOKIE['mdpModifie'])) {
    $texte = 'Votre mot de passe a bien été modifié !';
    require_once '../utilities/windowModal.php';
}

if(isset($_COOKIE['confirme'])) {
    $texte = 'Votre compte a bien été confirmé !';
    require_once '../utilities/windowModal.php';
}

if(isset($_COOKIE['dConfirme'])) {
    $texte = 'Votre compte a déjà été confirmé !';
    require_once '../utilities/windowModal.php';
}


?>
<?php require_once '../utilities/footer.php';
?>