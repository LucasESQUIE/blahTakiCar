<?php
require_once "adminModel.php";

$action = get('action') ?: 'defaultAction';

$action(getPDO());

function defaultAction($pdo) {
    global $tables;
    $tables = getTable($pdo);

}

function creer($pdo) {
    global $texte;
    $nomTable = htmlspecialchars(post('nomTable'));
    $type = htmlspecialchars(post('type'));
    $nomTable .= $type;
    if(!empty($nomTable)) {
        if(createTable($pdo, $nomTable, $type)){
            $texte = "Table ".$nomTable." créée !";
        }else{
            $texte = "Erreur lors de la création de la table 
                <br> Le nom ne doit pas contenir de caractères spéciaux(sauf le _)";
        }
    }
    defaultAction($pdo);

}

function archiver($pdo) {

    global $texte;

    $tableAarchiver = post('tableCible');
    $tableArchive = post('tableArchive');

    if($tableAarchiver == $tableArchive) {
        $texte = "Erreur lors de l'archivage";
    }

    if($tableAarchiver == 'utilisateurtest') {
        if(archiveUtilisateurs($pdo, $tableAarchiver, $tableArchive)) {
            $texte = "La table ".$tableAarchiver." a été archivée dans la table ".$tableArchive;
        }else{
            $texte = "Erreur lors de l'archivage";
        }
    }else if($tableAarchiver == 'trajettest') {
        if(archiveTrajets($pdo, $tableAarchiver, $tableArchive)) {
            $texte = "La table ".$tableAarchiver." a été archivée dans la table ".$tableArchive;
        }else{
            $texte = "Erreur lors de l'archivage";
        }
    }else{
        $texte = "Erreur lors de l'archivage";
    }
    defaultAction($pdo);
}

function supprimer($pdo) {
    global $texte;
    $nomTable = htmlspecialchars(post('nomTable'));

    if($nomTable == 'trajet' || $nomTable == 'utilisateur') {
        return false;
    }else if(!empty($nomTable)) {
        if(deleteTable($pdo, $nomTable)) {
            $texte = "La table ".$nomTable." a été supprimée";
        }else{
            $texte = "Erreur lors de la suppression";
        }
    }
    defaultAction($pdo);
}

