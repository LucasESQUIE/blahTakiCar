<?php
session_start();

if(isset($_SESSION['id'])) {
    header("Location: ../index.php");
}

require_once "userController.php";
require_once '../utilities/header.php';
?>


    <!-- centre -->
    <div class="container hautPage">
        <div class="row">
            <div class="col-lg-12 cadre">
                <h2 class='titrePartie' id="posTitreConnexion">Demande de mot de passe</h2>
                <?php if(isset($messageErreur)) { ?>
                    <div class="alert alert-danger"><?php echo $messageErreur ?></div><br/>
                <?php } ?>

                <form action="userViewOubliMdp.php?&action=oubliMdp" method="post">
                    <div class="col-lg-12">
                        <input type="text" name="mail" id="mail" class="form-control zoneTxt" placeholder="Adresse Mail" required>
                        <br/>
                        <!-- bouton ok -->
                        <button type='submit' class="bouton" id="postionBtnConnexion">Envoyer</button>
                        <br/>
                    </div>
                </form>
            </div>
        </div>

    </div>

<?php require_once '../utilities/footer.php';?>