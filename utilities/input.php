<?php


function get($name) {
    return isset($_GET[$name]) ? $_GET[$name] : null;
}

function post($name) {
    return isset($_POST[$name]) ? $_POST[$name] : null;
}

/**
 * change l'affichage des dates sous la forme : jj/mm/AAAA
 * @param $date
 * @return string
 */
function formatDate($date) {
    $dateFormat = explode('-', $date);
    return $dateFormat[2].'/'.$dateFormat[1].'/'.$dateFormat[0];
}

/**
 * Fonction utilisée pour l'affichage
 * découpe l'id utilisateur et renvoie une chaine du type Prenom Nom
 * @param $mailUtilisateur string id de l'utilisateur
 * @return string
 */
function affichePrenomNom($mailUtilisateur) {
    $nomUser = explode('@', $mailUtilisateur);
    $nomUser = explode('.', $nomUser[0]);

    return ucfirst($nomUser[0]).' '.ucfirst($nomUser[1]);
}

?>