<?php

require_once "userModel.php";
include_once "../utilities/input.php";

//$actionsUser = array('defaultAction', 'connexion', 'inscription', 'oubliMdp', 'modifMdp');

$action = get('action') ?: 'defaultAction';
//foreach($actionsUser as $act) {
//    if($action != $act) {
//        $action = 'defaultAction';
//    }
//}

$action(getPDO());

// TODO verification que le parametre est correct => sinon crash site

function defaultAction($pdo) {
    if(isset($_SESSION['id'])) {
        global $valeur;
        $valeur = recupInfoUser($pdo, $_SESSION['id']);
    }
    return null;
}


function connexion($pdo) {
    global $messageErreur;
    $login = htmlspecialchars(post('mail'));
    $password = htmlspecialchars(post('mdp'));

    // verification format de l'email
    if(!filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $messageErreur = "Email invalide";
    }

    $requete = verifInfoConnexion($pdo, $login);
    $user = $requete->fetch(PDO::FETCH_OBJ);

    if($user) {
        $mdp = $user->mdp;
        $validPassword = password_verify($password, $mdp);
    }else{
        $messageErreur = false;
    }
    if(isset($validPassword)) {
        $_SESSION['id'] = $login;
        $_SESSION['idSession'] = session_id();

        if($user->role == 1) {
            $_SESSION['role'] = 'admin';
        }else{
            $_SESSION['role'] = 'utilisateur';
            header("Location: ../index.php");
        }
    }else {
        $messageErreur = false;
    }
}

function inscription($pdo) {
    global $messageErreur;

    $messageErreur = array('cptExistant' => true,
                           'mailValide' => true,
                           'nomValide' => true,
                           'prenomValide' => true,
                           'telValide' => true,
                           'mdpEgaux' => true,
                           'mdpValide' => true,
                           'enregistre' => true
                          );

    // regex utilisées pour la verification du formulaire
    $formatMail = '/^[a-zA-Z0-9._%+-]+@iut-rodez\.fr$/';
    $formatNom = "/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ[:blank:]-]{1,75})$/";

    $formatTel = '/(0|\\+33|0033)[1-9][0-9]{8}/';
    $formatPassword = '#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$#'; // doit avoir 1 minuscule, 1 majuscule,
    //un chiffre et doit faire au moins 8 caractères



    $mail = htmlspecialchars(post('mail'));
    $nomUser = htmlspecialchars(post('nomUser'));
    $prenomUser = htmlspecialchars(post('prenomUser'));
    $numTel = htmlspecialchars(post('tel'));
    $filiere = htmlspecialchars(post('filiere'));
    $password = htmlspecialchars(post('password'));
    $confPassword = htmlspecialchars(post('confPassword'));
    $clefConfirm = clefAleatoire();


    if(comptePresent($mail)) {
        $messageErreur['cptExistant'] = false;
    }
    if(!preg_match($formatMail, $mail)) {
        $messageErreur['mailValide'] = false;
    }
    if(!preg_match($formatNom, $nomUser)) {
        $messageErreur['nomValide'] = false;
    }
    if(!preg_match($formatNom, $prenomUser)) {
        $messageErreur['prenomValide'] = false;
    }
    if(!preg_match($formatTel, $numTel)) {
        $messageErreur['telValide'] = false;
    }
    if($password != $confPassword) {
        $messageErreur['mdpEgaux'] = false;
    }
    if(!preg_match($formatPassword, $password)) {
        $messageErreur['mdpValide'] = false;
    }
    if($messageErreur['cptExistant'] == true && $messageErreur['mailValide'] && $messageErreur['nomValide']
       && $messageErreur['prenomValide'] == true && $messageErreur['telValide']
        && $messageErreur['mdpEgaux'] == true && $messageErreur['mdpValide'] == true) {
        //si toutes les données ok on insere dans la BD + envoi mail
        if(newUser($pdo, $mail, $nomUser, $prenomUser, $filiere, password_hash($password, PASSWORD_BCRYPT, array('cost'=>12)), $numTel, $clefConfirm)) {
            require_once "../utilities/mailControl.php";
            $mailE = envoiMail($mail, 'blahtakicar@gmail.com', 'Taki Car', 'Mail de confirmation',
                $corpsInscription);
            if(true != $mailE) {
                /* TODO MSG ERR mail non envoyé */
            } else {
                header('Location: ../index.php?&action=inscrit');
            }
        } else {
            $messageErreur['enregistre'] = false;
        }
    }
}

function oubliMdp($pdo) {
    $mail = htmlspecialchars(post('mail'));
    $clefConfirm = clefAleatoire();
    //Gestion erreur si compte non présent
    if(!comptePresent($mail)) {
        $messageErreur = "Compte non inscrit";
    } else if(modifClefConfirm($mail, $clefConfirm)) {
        require_once "../utilities/mailControl.php";
        $mailE = envoiMail($mail, 'blahtakicar@gmail.com', 'Taki Car', 'Oubli de mot de passe',
            $corpsOubliMdp);
        if(true != $mailE) {
            echo $mailE;
        } else {
            header('Location: ../index.php?&action=demandeModifMdp');
        }
    }else{
        $messageErreur = "Problème lors de l'enregistrement dans la BD";
    }
}

function modifMdp($pdo) {
    global $messageErreur;
    $mail = htmlspecialchars(post('mail'));
    $formatPassword = '#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$#'; // doit avoir 1 minuscule, 1 majuscule,
    $password = htmlspecialchars(post('password'));
    $confPassword = htmlspecialchars(post('confPassword'));
    //Gestion erreur si mots de passes non égaux
    if($password != $confPassword) {
        $messageErreur = "Mots de passe non égaux";
    } else if(!preg_match($formatPassword, $password)) {
        $messageErreur = "Votre mot de passe doit contenir une minuscule, une majuscule et au moins 8 caractères";
    } else if(modificationMdp($pdo, $mail, password_hash($password, PASSWORD_BCRYPT, array('cost'=>12)))){
        header('Location: ../index.php?&action=mdpModifie');
    } else {
        $messageErreur = "Problème de changement de mot de passe BD";
    }
}



function UpdateProfil() {

    // Si on a bien reçu tous les champs nécessaires
    if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['tel']) && isset($_POST['filiere']) && isset($_POST['modele']) && isset($_POST['marque']) && isset($_POST['couleur'])){
        UpdateInfoProfil($_SESSION['id']);
        header('Location: userViewProfil.php');
    }else{
        //TODO Message Erreur Formulaire
        echo 'erreur';
    }
}

/**
 * Modifie la photo de profil de l'utilisateur après un clic puis une séléction d'une image local de celui ci.
 * Le programme va alors télécharger l'image sur le serveur puis y affecter un nom unique et le référencer dans la BD
 */

function modifPhotoProfil() {
    if(isset($_FILES['imageUser']) AND !empty($_FILES['imageUser']['name'])) {
        /* Taille maximum de l'image, on ne veux pas surchager le serveur = 2MO */
        $tailleMax = 2097152;
        /* Types possible de fichiers images que l'utilisateur peut envoyer */
        $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
        /* Vérifie la taille de l'image */
        if ($_FILES['imageUser']['size'] <= $tailleMax) {
            /* Traite la partie extension du fichier pour le rendre homogène */
            $extensionUpload = strtolower(substr(strrchr($_FILES['imageUser']['name'], '.'), 1));
            /* Vérifie si l'extension appartient aux extensions valides pour les images de profil */
            if (in_array($extensionUpload, $extensionsValides)) {
                /* Créer un chemin enregistrable en base de données */
                $chemin = "images/users/" . $_SESSION['id'] . "." . $extensionUpload;
                /* Télécharge l'image sur le serveur */
                $resultat = move_uploaded_file($_FILES['imageUser']['tmp_name'], $chemin);
                /* Si le téléchargement est bien exécuté */
                if ($resultat) {
                    /* Modifie le chemin de l'image en base de données */
                    UpdatePhotoProfil($chemin,$_SESSION['id']);
                    /* Redirige l'utilisateur vers la page profil avec l'image modifiée */
                    header('Location: userViewProfil.php');
                } else {
                    $msg = "Erreur durant l'importation de votre photo de profil";
                }
            } else {
                $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
            }
        } else {
            $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
        }
    }
}

function modifPhotoVoiture() {
    if(isset($_FILES['imageVoiture']) AND !empty($_FILES['imageVoiture']['name'])) {
        /* Taille maximum de l'image, on ne veux pas surchager le serveur */
        $tailleMax = 2097152;
        /* Types possible de fichiers images que l'utilisateur peut envoyer */
        $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
        /* Vérifie la taille de l'image */
        if ($_FILES['imageVoiture']['size'] <= $tailleMax) {
            /* Traite la partie extension du fichier pour le rendre homogène */
            $extensionUploadVoiture = strtolower(substr(strrchr($_FILES['imageVoiture']['name'], '.'), 1));
            /* Vérifie si l'extension appartient aux extensions valides pour les images de profil */
            if (in_array($extensionUploadVoiture, $extensionsValides)) {
                /* Créer un chemin enregistrable en base de données */
                $cheminVoiture = "images/voitures/" . $_SESSION['id'] . "." . $extensionUploadVoiture;
                /* Télécharge l'image sur le serveur */
                $resultat = move_uploaded_file($_FILES['imageVoiture']['tmp_name'], $cheminVoiture);
                /* Si le téléchargement est bien exécuté */
                if ($resultat) {
                    /* Modifie le chemin de l'image en base de données */
                    UpdatePhotoVoiture($cheminVoiture,$_SESSION['id']);
                    /* Redirige l'utilisateur vers la page profil avec l'image modifiée */
                    header('Location: userViewProfil.php');
                } else {
                    $msg = "Erreur durant l'importation de votre photo de profil";
                }
            } else {
                $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
            }
        } else {
            $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
        }
    }
}










/*---------------- FONCTIONS UTILITAIRES POUR LES UTILISATEURS -------------- */

/**
 * Créé une clef aléatoire de 15 caractères
 * @return $clef
 */
function clefAleatoire() {
    $longueur = 15;
    $clef = "";
    for($i=1; $i<$longueur; $i++) {
        $clef .= mt_rand(0,9);
    }
    return $clef;
}



?>