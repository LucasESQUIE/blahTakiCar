<?php
session_start();

require_once "utilities/input.php";
require_once "utilities/dataSource.php";

/* controleur frontal */

$action = get('action');

//Si aucune action n'est spécifiée on renvoie à la page d'accueil
if($action == 'defaultAction' || empty($action)) {
    header("Location: accueilView.php");
}

// TODO verification que le parametre est correct => sinon crash site

//connexion admin
if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header("Location: admin/adminView.php");
}


//Gestion des pages concernant les utilisateurs
if($action == 'connexion') {
    header("Location: users/userViewConnexion.php");
}
if($action == 'inscription') {
    header("Location: users/userViewInscription.php");
}
if($action == 'profil') {
    header("Location: users/userViewProfil.php");
}
if($action == 'deconnexion'){
    session_destroy();
    setcookie('deco', 1, time()+1);
    header("Location: accueilView.php");
    exit();
}
if($action == 'modifMdp') {
    header("Location: users/userViewModifMdp.php");
}

//envoi de cookies pour création des alertes popup
if($action == 'mdpModifie') {
    setcookie('mdpModifie', 1, time()+1);
    header("Location: users/userViewConnexion.php");
}

if($action == 'demandeModifMdp') {
    setcookie('demandeModifMdp', 1, time()+1);
    header("Location: accueilView.php");
}

if($action == 'inscrit') {
    setcookie('inscrit', 1, time()+1);
    header("Location: accueilView.php");
}

if($action == 'confirme') {
    setcookie('confirme', 1, time()+1);
    header("Location: users/userViewConnexion.php");
}

if($action == 'dConfirme') {
    setcookie('dConfirme', 1, time()+1);
    header("Location: users/userViewConnexion.php");
}

if($action == 'estPropose') {
    setcookie('estPropose', 1, time()+1);
    header("Location: accueilView.php");
}

if($action == 'support') {
    setcookie('support', 1, time()+1);
    header("Location: accueilView.php");
}



//Gestion des pages concernant les trajets
if($action == 'rechercher') {
    header("Location: trajets/trajetViewRecherche.php");
}
if($action == 'proposer') {
    header("Location: trajets/trajetViewProposer.php");
}


// cookies pour l'affichage des informations avec les fenêtres pop-ups
if(get('etat') == 'nc') {
    setcookie('nonConnecte', 1, time()+1);
}

if(get('etat') == 'reserve') {
    setcookie('reserve', 1, time()+1);
}
if(get('etat') == 'resConducteur') {
    setcookie('resConducteur', 1, time()+1);
}
if(get('etat') == 'dejaRes') {
    setcookie('dejaRes', 1, time()+1);
}
