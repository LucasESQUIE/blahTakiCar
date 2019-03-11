<?php
require_once "../utilities/dataSource.php";

/**
 * Permet de cloner une table présente dans la bd
 * @param $pdo object connexion à la bd
 * @param $nomTable string nom de la table d'archive
 * @param $typeTable string table à cloner : utilisateur ou trajet
 * @return bool true si la création a bien été effectuée, false sinon
 */
function createTable($pdo, $nomTable, $typeTable) {
    try {
        $sql = "CREATE TABLE ? LIKE ?";
        $requete = $pdo->prepare($sql);
        $requete->execute([$nomTable, $typeTable]);

        return true;
    }catch (PDOException $e) {
        $pdo->rollBack();
        $e->getMessage();
        return false;
    }
}

function copyTable($pdo, $tableArchive, $tableSource) {
    try {
        $sql = "INSERT INTO ? SELECT * FROM ? WHERE role = 0";
        $requete = $pdo->prepare($sql);
        $requete->execute([$tableArchive, $tableSource]);
        return true;
    }catch(PDOException $e){
        $e->getMessage();
        return false;
    }
}

