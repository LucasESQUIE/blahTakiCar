<?php
require_once('../utilities/mailControl.php');
include_once "../utilities/input.php";

if(post('mail') && post('probleme') && post('description')) {

    global $messageErreur;
    $messageErreur = array('mailValide' => true,
                           'descriptionValide' => true);

    $formatMail = " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ";

    $mail = htmlspecialchars(post('mail'));
    $probleme = htmlspecialchars(post('probleme'));
    $description = htmlspecialchars(post('description'));

    // vérification email
    if (!preg_match($formatMail, $mail)) {
        $messageErreur['mailValide'] = false;
    }

    // vérificication description
    if ($description == null) {
        $messageErreur['descriptionValide'] = false;
    }

    // envoi du mail au support
    envoiMail('theo.gutierrez@iut-rodez.fr', $mail, $mail, $probleme, templateMail($probleme, $description, null, null));

    header('Location: ../index.php?&action=support');

}
?>