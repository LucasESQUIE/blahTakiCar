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
        <!-- Partie connexion -->
        <div class="row">
            <div class="col-lg-12 cadre">
                <h2 class='titrePartie' id="posTitreConnexion">Modification de mot de passe</h2>
                <?php if(isset($messageErreur)) { ?>
                    <div class="alert alert-danger"><?php echo $messageErreur ?></div><br/>
                <?php } ?>

                <form action="userViewModifMdp.php?&action=modifMdp" method="post">
                    <div class="col-lg-12">
                        <input type="hidden" name = "mail" value = "<?php echo get('mail');?>">
                        <input type="password" class="form-control zoneTxt" name="password" placeholder="Mot de passe">
                        <br/>
                        <input type="password" class="form-control zoneTxt" name="confPassword" placeholder="Confirmer le mot de passe">
                        <br/>
                        <!-- bouton ok -->
                        <button type='submit' class="bouton" id="postionBtnConnexion">Modifier</button>
                        <br/>
                    </div>
                </form>
            </div>
        </div>

    </div>

<?php require_once '../utilities/footer.php';?>