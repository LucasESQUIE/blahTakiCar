<?php
session_start();

require_once "utilities/input.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="public/style/style.css">
    <script type="text/javascript" src="public/javascript/interface.js"></script>
    <script type="text/javascript" src="public/jquery/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script type="text/javascript" src="public/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.css">
    <link rel="icon" type="image/png" href="public/images/logo.png" />
    <title>BlahTakiCar</title>
</head>
<body>
<!-- Menu -->

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php" alt="Accéder à l'accueil" id="nomSite">BlahTakiCar</a>
        </div>
        <ul class="nav navbar-nav ">
            <li><a href="index.php?&action=rechercher" alt="Rechercher un trajet" class = "liens">Rechercher</a></li>
            <li><a href="index.php?&action=proposer" alt="Proposer un trajet" class = "liens">Proposer</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php
            if(isset($_SESSION['id'])) { ?>
                <li><a href="index.php?&action=profil" alt="Mon Profil" class = "liens"><span class="glyphicon glyphicon-user"></span>Mon profil</a></li>
                <li><a href="index.php?&action=deconnexion" alt="Déconnexion" class = "liens"><span class="glyphicon glyphicon-user"></span>Se déconnecter</a></li>
            <?php }else{ ?>
                <li><a href="index.php?&action=connexion" alt="Se connecter" class = "liens"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a></li>
                <li><a href="index.php?&action=inscription" alt="S'inscrire"><span class="glyphicon glyphicon-user"></span> S'inscrire</a></li>
            <?php } ?>
        </ul>
    </div>
</div>

<!-- centre -->
<div class="container" id="hautPage">
    <div class="row">
        <!-- Image Présentation -->
        <img src="public/images/logo.png" alt="Banniere du site" title="BanniereBTC" id="styleImage">
        <div class="col-lg-12 cadre">
            <p class = "textePresentation">
                <h2 class="titrePartie">Bienvenue à tous !</h2><br />
                Ce site est dédié au covoiturage entre étudiants de l’IUT de Rodez. <br />
                Il a été conçu par des étudiants lors d’un projet tuteuré, <span id="miseEnValeur">ce site a un but convivial et non lucratif</span>.
                <br/>
                <h4>Bonne route à tous !</h4>
            </p>
        </div>
    </div>
    <!-- Partie rechercher -->
    <div class="row">
        <div class="col-lg-12 cadre">
            <h2 class="titrePartie" >Rechercher un trajet :</h2>
            <form action="trajets/trajetViewRecherche.php?&action=recherche" method="post" class="form-inline">
                <div class="col-lg-12  form-group">
                    <input type="text" name="villeDep" id="villeDep" placeholder="Départ" class="form-control zoneTxt positionZone" tabindex="1">
                    <button type="button" onclick="Switch(villeDep.value,villeArr.value)" class="btn bouton_switch"><span class="glyphicon glyphicon-resize-horizontal"></span></button>
                    <input type="text" name="villeArr" id="villeArr" placeholder="Arrivée" class = "form-control zoneTxt positionZone" tabindex="2">
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input type="text" name="date" id="date"
                               data-provide="datepicker"
                               placeholder="Date" class="form-control zoneTxt positionZone" tabindex="3">
                    </div>
                </div>

                <div class="col-lg-12">
                    <button type="submit" class="bouton positionBtn">Rechercher</button>
                </div>
            </form>
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

    <div class="row">
        <div class="col-lg-12 cadre">
            <h2 class="titrePartie">Règles d'usage</h2>
            <ul class = "list-group">
                <li class="list-group-item">Le paiement pour les trajets s'effectuera en main propre selon le prix annoncé par le conducteur.</li>
                <li class="list-group-item">Si malencontreusement certains problèmes survenaient lors d’un trajet
                    au sujet du comportement d’une ou de plusieurs personnes, ou encore d’une prise de risque inconsidérée du conducteur,
                    veuillez le signaler aux responsables du site. <br /></li>
            </ul>


        </div>
    </div>

</div>
<br />
<!-- footer -->
<div class="row">
    <footer class="page-footer font-small">
        <div class="footer-copyright text-center">
            <div class="container-fluid text-center text-md-left">
                <img src="public/images/logo_UT1_Capitole.jpg" alt="logoUT1Capitole" title="logoUT1Capitole" id="styleLogoUT1">
                <img src="public/images/Logo_IUT_Rodez.jpg" alt="logoIutRodez" title="logoIutRodez" id="styleLogoIUT" >
                <br />
                2018 Copyright
                <a href="index.php" alt="Accéder à l'accueil">BlahTakiCar</a>
                <a href="contact/contact.php" alt="ContactAdministration">Nous Contacter</a>
            </div>
        </div>
    </footer>
</div>

<?php
//si l'utilisateur vient de se déconnecter on affiche une fenetre modale pour l'informer
if(isset($_COOKIE['deco'])) {
    $texte = 'Vous avez bien été déconnecté !';
    require_once 'utilities/windowModal.php';
}
//informe l'utilisateur du succès de son inscription
if(isset($_COOKIE['inscrit'])) {
    $texte = 'Un mail vous a été evoyé pour modifier votre mot de passe !';
    require_once 'utilities/windowModal.php';
}

if(isset($_COOKIE['demandeModifMdp'])) {
    $texte = 'Un mail vous a été evoyé pour modifier votre mot de passe !';
    require_once 'utilities/windowModal.php';
}

if(isset($_COOKIE['reserve'])) {
    $texte = "Votre réservation à bien été prise en compte, un email vous a été envoyé";
    require_once 'utilities/windowModal.php';
}

if(isset($_COOKIE['resConducteur'])) {
    $texte = "Vous ne pouvez pas réserver une place dans votre propre trajet !";
    require_once 'utilities/windowModal.php';
}

if(isset($_COOKIE['dejaRes'])) {
    $texte = "Vous avez déjà réservé une place sur ce trajet !";
    require_once 'utilities/windowModal.php';
}

if(isset($_COOKIE['estPropose'])) {
    $texte = "Votre trajet a bien été pris en compte !";
    require_once 'utilities/windowModal.php';
}

if(isset($_COOKIE['support'])) {
    $texte = "Votre demande a bien été envoyé !";
    require_once 'utilities/windowModal.php';
}
?>

</body>
</html>
