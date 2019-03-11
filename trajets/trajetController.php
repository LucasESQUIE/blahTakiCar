<?php

require_once "trajetModel.php";
require_once "../utilities/input.php";

$actionsTrajet = array('defaultAction', 'recherche', 'propose', 'reserver');

$action = get('action') ?: 'defaultAction';

foreach($actionsTrajet as $act) {
    if($action != $act) {
        $action = 'defaultAction';
    }
}


$action(getPDO());

// TODO verification que le parametre est correct => sinon crash site


/**
 * Fonction par défaut : si on est sur la page rechercher affiche tous les trajets disponibles
 * sinon ne fait rien.
 * @param $pdo object connexion à la bd
 * @return null si on est sur aucune des pages nécssitant une defaultAction
 */
function defaultAction($pdo) {
    if($_SERVER['PHP_SELF'] == "/blahMVC/trajets/trajetViewRecherche.php") {
        global $trajets;
        $trajets = getTrajets($pdo);
    }

    if($_SERVER['PHP_SELF'] == "/blahMVC/trajets/trajetViewReservation.php"){
        global $result;
        $idTrajet = get('id');
        $result = getTrajetById($pdo, $idTrajet);
    }
    return null;


}

/**
 * recherche des trajets en fonction des critères
 * @param $pdo object connexion à la bd
 */
function recherche($pdo) {
    global $trajetRech;

    $villeDep = htmlspecialchars(post('villeDep'));
    $villeArr = htmlspecialchars(post('villeArr'));
    $date = htmlspecialchars(post('date'));

    if(empty($villeDep) && empty($villeArr) && empty($date)) {
        defaultAction($pdo);
    }

    if(empty($date)) {
        $date = date("Y-n-j");
    }

    $trajetRech = getTrajetsBySearch($pdo, $villeDep, $villeArr, $date);


}

/**
 * rajoute un trajet dans la bd
 * @param $pdo object connexion à la bd
 */
function propose($pdo) {

}

/**
 * effectue la réservation d'un trajet
 * @param $pdo object connexion a la bd
 */
function reserver($pdo) {
    $erreur = false;
    defaultAction($pdo);
    $idTrajet = post('id');
    $nomPassager = post('idPassagers').$_SESSION['id'].';';
    $nbPlaces = post('nbPlaces') - 1;
    $conducteur = post('idConducteur');
    $dateDep = strtotime(post('dateDep'));
    $dateActuelle = strtotime(date("Y-m-d"));

    //on recupere l'état du trajet
    $etat = getState($pdo, $idTrajet);
    //si le trajet est plein on ne peut pas réserver une autre place
    if($etat == 1) {
        $erreur = true;
    }

    //un trajet où toutes les places sont affectées n'apparait plus dans la recherche
    if($nbPlaces == 0) {
        setState($pdo, $idTrajet);
    }

    if($dateDep < $dateActuelle) {
        $erreur = true;
    }

    //un utilisateur qui est conducteur sur un trajet ne peut pas réserver une place sur son trajet
    if($_SESSION['id'] === $conducteur){
        $erreur = true;
        header("Location: ../index.php?&etat=resConducteur");
    }

    //si un utilisateur est déjà enregistré sur un trajet, il ne peut pas réserver une autre place
    $passagers = explode(';', post('idPassagers'));
    foreach ($passagers as $passager) {
        if($passager === $_SESSION['id']) {
            $erreur = true;
            header("Location: ../index.php?&etat=dejaRes");

        }
    }

    if(!$erreur) {
        reservation($pdo, $idTrajet, $nomPassager, $nbPlaces);
        require_once '../utilities/mailControl.php';
        require_once '../utilities/corpsMail.php';
        //mail passager
        $mailP = envoiMail($_SESSION['id'], 'blahtakicar@gmail.com', 'Taki Car', 'Confirmation de réservation',
            $corpsReservation);
        //mail conducteur
        $mailC = envoiMail($conducteur, 'blahtakicar@gmail.com', 'Taki Car', 'Quelqu\'un à réservé une place sur votre trajet',
            $corpsInformation);

        if($mailC == true && $mailP == true) {
            header("Location: ../index.php?&etat=reserve");
        }else{
            echo "pb mail";
        }

    }else{
        sleep(2);
    }


}
