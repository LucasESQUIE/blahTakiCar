<?php session_start();
require_once "contactController.php";
require_once '../utilities/header.php'; ?>
<br/><br/>
<!-- Bandeau formulaire de contact -->
<div class="container">
	<div class="row">
		<form action="contactController.php" method = "post">
			<div class="col-lg-12 cadre">
					<h2 class="titrePartie">Contact</h2><br/>
                <div class="col-lg-12 form-group" >
                    <?php if(isset($messageErreur) && (!$messageErreur['mailValide'])) { ?>
                        <div class="invalid-text">Mail Invalide</div>
					    <input type="email" class="form-control zoneTxt invalid" name="mail" placeholder="Adresse Mail" required/>
                    <?php } else { ?>
                        <input type="email" class="form-control zoneTxt" name="mail" placeholder="Adresse Mail" required/>
                    <?php } ?>
				</div><br/>
				<div class="col-lg-12 form-group">
                    <label for="description">Type de demande: </label><br/>
					<select name="probleme" class="form-control">
						<option>Problème survenu lors de l'inscription</option>
						<option>Problème survenu lors de la connexion</option>
						<option>Problème survenu lors de la recherche d'un trajet</option>
						<option>Problème survenu lors de la mise en ligne d'un trajet</option>
						<option>Proposer une amélioration du site (visuelle ou fonctionelle)</option>
						<option>Autre...</option>
					</select>
				</div>
				<br/>
				<div class="col-lg-12 form-group">
                <?php if(isset($messageErreur) && (!$messageErreur['descriptionValide'])) { ?>
                    <div class="invalid-text">Description invalide</div>
					<label for="description">Votre message: </label><br/>
					<textarea  class="form-control invalid" name="description" required></textarea>
                <?php } else { ?>
                    <label for="description">Votre message: </label><br/>
                    <textarea  class="form-control" name="description" required></textarea>
                <?php } ?>
				</div><br/>
				<div class="col-lg-12">
					<input type="submit" name="envoyer" value="Envoyer" class="bouton"/>
				</div><br/>
			</div>
		</form>
	</div>
</div>
<?php require_once '../utilities/footer.php';?>