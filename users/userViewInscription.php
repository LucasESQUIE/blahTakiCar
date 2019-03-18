<?php
session_start();

if(isset($_SESSION['id'])) {
    header("Location: ../index.php");
}
if(isset($_SESSION['idSession']) && $_SESSION['idSession'] != session_id()) {
    header("Location: ../index.php");
}

require_once "userController.php";


require_once '../utilities/header.php';
?>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>
<!-- centre -->
<div class="container hautPage">
    <div class="row cadre">
        <div class="col-lg-12">
            <h2 class="titrePartie posTitreInscrire">Inscription</h2>
            <?php if(isset($messageErreur) && !($messageErreur['enregistre'])) { ?>
                <div class="alert alert-danger">Problème lors de l'enregistrement dans la base de données</div>
            <?php } ?>
            <form action="userViewInscription.php?&action=inscription" method="post">
                <div class="form-group">
                    <?php if(isset($messageErreur) && (!$messageErreur['mailValide'])) { ?>
                        <div class="invalid-text">Email Invalide</div>
                        <input type="email" class="form-control  invalid" name="mail" placeholder="Adresse Mail">
                    <?php }else { ?>
                        <input type="email" class="form-control zoneTxt" data-container="body" data-toggle="popover" data-trigger="focus"
                               data-placement="top" data-content="prenom.nom@iut-rodez.fr" name="mail" placeholder="Adresse Mail" value="<?php echo post('mail'); ?>">
                    <?php } ?>
                </div>

                <div class="form-group">
                    <?php if(isset($messageErreur) && (!$messageErreur['nomValide'])) { ?>
                        <div class="invalid-text">Nom Invalide</div>
                        <input type="text" class="form-control invalid" name="nomUser" placeholder="Nom">
                    <?php }else{ ?>
                        <input type="text" class="form-control zoneTxt" name="nomUser" placeholder="Nom" value="<?php echo post('nomUser'); ?>">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <?php if(isset($messageErreur) && (!$messageErreur['prenomValide'])) { ?>
                        <div class="invalid-text">Prénom Invalide</div>
                        <input type="text" class="form-control invalid" name="prenomUser" placeholder="Prénom">
                    <?php }else{ ?>
                        <input type="text" class="form-control zoneTxt" name="prenomUser" placeholder="Prénom" value="<?php echo post('prenomUser'); ?>">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <?php if(isset($messageErreur) && (!$messageErreur['telValide'])) { ?>
                        <div class="invalid-text">Numéro de téléphone Invalide</div>
                        <input type="text" class="form-control invalid" name="tel" placeholder="Téléphone">
                    <?php }else{ ?>
                        <input type="text" class="form-control zoneTxt" name="tel" placeholder="Téléphone" value="<?php echo post('tel'); ?>">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <select class="form-control" name="filiere">
                        <option value="Informatique" <?php if(post('filiere') == "Informatique") { echo 'selected';} ?>>Informatique</option>
                        <option value="GEA" <?php if(post('filiere') == "GEA") { echo 'selected';} ?>>GEA</option>
                        <option value="CJ" <?php if(post('filiere') == "CJ") { echo 'selected';} ?>>Carrière Juridique</option>
                        <option value="Infocom" <?php if(post('filiere') == "Infocom") { echo 'selected';} ?>>Information Communication</option>
                        <option value="QLIO" <?php if(post('filiere') == "QLIO") { echo 'selected';} ?>>QLIO</option>
                        <option value="Professeur" <?php if(post('filiere') == "Professeur") { echo 'selected';} ?>>Professeur</option>
                        <option value="Autre" <?php if(post('filiere') == "Autre") { echo 'selected';} ?>>Autre formation</option>
                    </select>
                </div>
                <div class="form-group">
                    <?php if(isset($messageErreur) && (!$messageErreur['mdpValide'])) { ?>
                        <div class="invalid-text">Mot de passe Invalide</div>
                        <input type="password" class="form-control invalid" id="mdp" name="password" placeholder="Mot de passe">
                    <?php }else{ ?>
                        <input type="password" class="form-control zoneTxt" id="mdp" name="password" placeholder="Mot de passe">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <?php if(isset($messageErreur) && (!$messageErreur['mdpEgaux'])) { ?>
                        <div class="invalid-text">Mots de passe différents</div>
                        <input type="password" class="form-control invalid" name="confPassword" placeholder="Confirmer le mot de passe">
                    <?php }else{ ?>
                        <input type="password" class="form-control zoneTxt" name="confPassword" placeholder="Confirmer le mot de passe">
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <small id="mdp" class="form-text text-muted">Le mot de passe doit faire 8 caractères de long, contenir au moins
                            une minuscule, une majuscule et un chiffre.</small>
                    </div>
                </div>

                <!-- bouton -->
                <div class="col-lg-12">
                    <button type="submit" class="bouton" id="positionBtnInscrire">S'inscrire</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row cadre">
        <div class="col-lg-12">
            <h2 class="titrePartie posTitreInscrire">Procédure d'inscription</h2>
            <span id="miseEnValeur">Rappel :</span> Vous devez posséder une adresse mail de l'IUT de Rodez pour pouvoir
            vous inscrire.
        </div>
    </div>

</div>

<?php require_once '../utilities/footer2.php';?>