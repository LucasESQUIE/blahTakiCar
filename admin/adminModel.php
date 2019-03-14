<?php
require_once "../utilities/dataSource.php";
require_once "../utilities/input.php";

/**
 * Permet de cloner une table présente dans la bd
 * @param $pdo object connexion à la bd
 * @param $nomTable string nom de la table d'archive
 * @param $typeTable string table à cloner : utilisateur ou trajet
 * @return bool true si la création a bien été effectuée, false sinon
 */
function createTable($pdo, $nomTable, $typeTable) {
    try {
        $sql = "CREATE TABLE IF NOT EXISTS $nomTable LIKE $typeTable";
        $requete = $pdo->prepare($sql);
        $requete->execute();
        return true;
    }catch (PDOException $e) {
        $e->getMessage();
        return false;
    }
}

/**
 * Supprime une table de la base de données
 * @param $pdo object connexion a la BD
 * @param $table string nom de la table à supprimer
 * @return bool true si la table a été supprimée, false sinon
 */
function deleteTable($pdo, $table) {
    try{
        $sql = "DROP TABLE IF EXISTS $table";
        $requete = $pdo->prepare($sql);
        $requete->execute();
        return true;
    }catch (PDOException $e) {
        $e->getMessage();
        return false;
    }
}


/**
 * Archivage d'une table : passage de toutes les données de la table dans une table d'archive
 * puis effaçage des données de la table de départ
 * @param $pdo object connexion a la BD
 * @param $table string table a archiver
 * @param $tableArchive string table d'archive
 * @return true si l'archivage s'est effectué correctement false sinon
 */
function archiveUtilisateurs($pdo, $table, $tableArchive) {
    try {
        $sqlInsert = "INSERT INTO $tableArchive SELECT * FROM $table WHERE role = 0";
        $sqlDelete = "DELETE FROM $table WHERE role = 0";

        $pdo->beginTransaction();

        //insertion des données dans la table d'archive
        $requeteInsert = $pdo->prepare($sqlInsert);
        $requeteInsert->execute();

        //vidage de la table a archiver
        $requeteDelete = $pdo->prepare($sqlDelete);
        $requeteDelete->execute();

        $pdo->commit();
        return true;

    }catch(PDOException $e) {
        $pdo->rollBack();
        $e->getMessage();
        return false;
    }
}

function archiveTrajets($pdo, $table, $tableArchive) {
    try {
        $sqlInsert = "INSERT INTO $tableArchive SELECT * FROM $table";
        $sqlDelete = "DELETE FROM $table";

        $pdo->beginTransaction();

        //insertion des données dans la table d'archive
        $requeteInsert = $pdo->prepare($sqlInsert);
        $requeteInsert->execute();

        //vidage de la table a archiver
        $requeteDelete = $pdo->prepare($sqlDelete);
        $requeteDelete->execute();

        $pdo->commit();
        return true;

    }catch(PDOException $e) {
        $pdo->rollBack();
        $e->getMessage();
        return false;
    }
}

/**
 * récupère la liste des tables présentes dans la BD
 * @param $pdo object connexion a la BD
 * @return mixed tableau contenant les noms des tables
 */
function getTable($pdo) {
    try{
        $sql = "SHOW TABLES FROM blahtakicarv2";
        $requete = $pdo->prepare($sql);
        $requete->execute();

        return $requete;

    }catch(PDOException $e){
        $e->getMessage();
    }
}


