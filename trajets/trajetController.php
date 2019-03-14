<?php

require_once "trajetModel.php";
require_once "../utilities/input.php";


$action = get('action') ?: 'defaultAction';
$action(getPDO());

// TODO verification que le parametre est correct => sinon crash site


/**
 * Fonction par défaut : si on est sur la page rechercher affiche tous les trajets disponibles
 * sinon ne fait rien.
 * @param $pdo object connexion à la bd
 * @return null si on est sur aucune des pages nécssitant une defaultAction
 */
function defaultAction($pdo) {
    if($_SERVER['PHP_SELF'] == "/blahMVCv1.1/trajets/trajetViewRecherche.php") {
        global $trajets;
        $trajets = getTrajets($pdo);
    }

    if($_SERVER['PHP_SELF'] == "/blahMVCv1.1/trajets/trajetViewReservation.php"){
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

    global $messageErreur;
    global $messageErreurBD;

    $messageErreurBD = true;
    $messageErreur = array('villeDepValide' => true,
                           'dateValide' => true,
                           'heureValide' => true,
                           'villeArrValide' => true,
                           'villeEt1Valide' => true,
                           'villeEt2Valide' => true,
                           'nbPlacesValide' => true,
                           'prixValide' => true
    );
    $formatVille = "/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ[:blank:]-]{1,75})$/";
    $formatDate ="/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
    $formatHeure="/^([01][0-9]|2[0-3])h([0-5][0-9])$/";

    $idConducteur = $_SESSION['id'];
    $villeDep = post('villeDep');
    $dateDep = formatageDate(post('dateDep'));
    $heureDep = post('heureDep');
    $villeArr = post('villeArr');
    $etape1 = post('etape1');
    $etape2 = post('etape2');
    $nbPlaces = post('nbPlaces');
    $prix = post('prix');
    if($prix == '') {
        $prix = 0;
    }
    $commentaires = post('commentaires');
    $villeEtape = $etape1.';'.$etape2;
    //récupération de l'immatriculation
    $immatriculation = getImmaById($pdo, $idConducteur)['immaVoiture'];

    date_default_timezone_set('UTC');
    $dateActuelle = mktime(0,0,0,date('n'),date('j'),date('y'),-1);

    if(!preg_match($formatVille, $villeDep)) {
        $messageErreur['villeDepValide'] = false;
    }

    if(!preg_match($formatVille, $villeArr)) {
        $messageErreur['villeArrValide'] = false;
    }

    if(!preg_match($formatVille, $etape1) && $etape1 !="") {
        $messageErreur['villeEt1Valide'] = false;
    }

    if(!preg_match($formatVille, $etape2) && $etape2 !="") {
        $messageErreur['villeEt2Valide'] = false;
    }

    if(!preg_match($formatDate, $dateDep) || $dateActuelle > testDate($dateDep)) {
        $messageErreur['dateValide'] = false;
    }

    if(!preg_match($formatHeure, $heureDep)) {
        $messageErreur['heureValide'] = false;
    }

    if(!ctype_digit($nbPlaces) || $nbPlaces>6) {
        $messageErreur['nbPlacesValide'] = false;
    }

    if((!ctype_digit($prix) || $prix>50)&& $prix != "") {
        $messageErreur['prixValide'] = false;
    }
    if($messageErreur['villeDepValide'] && $messageErreur['villeArrValide'] && $messageErreur['dateValide'] &&
       $messageErreur['heureValide'] && $messageErreur['villeEt1Valide'] && $messageErreur['villeEt2Valide'] &&
       $messageErreur['nbPlacesValide'] && $messageErreur['prixValide']) {
        if(createTrajet($pdo, $idConducteur, $villeDep, $dateDep, $heureDep, $villeArr,
            $villeEtape, $nbPlaces, $prix, $commentaires, $immatriculation)) {
            header('Location: ../index.php?action=estPropose');
        } else {
            $messageErreurBD = false;
        }
    }
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
        $mailP = envoiMail($_SESSION['id'], 'blahtakicar@gmail.com', 'Blah Taki Car', 'Confirmation de réservation',
            templateMail('Confirmation de réservation','Votre réservation a bien été pris en compte !',null,null));
        //mail conducteur
        $mailC = envoiMail($conducteur, 'blahtakicar@gmail.com', ' Blah Taki Car', 'Place réservée sur votre trajet',
            templateMail('Réservation effectuée','Une place a été prise dans votre trajet !',null,null));

        if($mailC == true && $mailP == true) {
            header("Location: ../index.php?&etat=reserve");
        }else{
            echo "pb mail";
        }

    }else{
        echo "pb reservation";
    }




    //renvoi vers page d'accueil avec fenetre modale qui informe de la bonne inscription

}
