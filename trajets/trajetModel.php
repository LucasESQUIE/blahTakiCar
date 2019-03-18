<?php

require_once "../utilities/dataSource.php";


/**
 * Récupère tous les trajets présents dans la BD
 * @param $pdo object connexion à la BD
 * @return $result les trajets enregistrés
 */
function getTrajets($pdo) {
    try {
        $sql = "SELECT * FROM trajet WHERE dateDep >= CURRENT_DATE() AND plein != 1";
        $requete = $pdo->prepare($sql);
        $requete->execute();

        return $requete;

   } catch (PDOException $e) {
        $e->getMessage();
    }
}

/**
 * Récupère les trajets correspondants aux critères de recherche
 * @param $pdo object connexion a la bd
 * @param $villeDep string ville de départ
 * @param $villeArr string ville d'arrivée
 * @param $date string date de départ du trajet
 * @return mixed le résultat pour l'exploitation dans la vue
 */
function getTrajetsBySearch($pdo, $villeDep, $villeArr, $date) {
    try {
        $sql = "SELECT ID_trajet, villeDep, villeArr, dateDep, heureDep, nbPassagers, idConducteur, prix  
                FROM trajet
                WHERE villeDep LIKE ?
                AND villeArr LIKE ?
                AND dateDep >= ?
                AND plein != 1";
        $requete = $pdo->prepare($sql);

        $requete->execute(["%$villeDep%", "%$villeArr%", $date]);

        return $requete;

    } catch (PDOException $e) {
        $e->getMessage();
    }
}

/**
 * Récupère les informations du trajet dont l'id est passée en paramètre
 * @param $pdo object connexion à la bd
 * @param $idTrajet int identifiant du trajet
 * @return mixed les informations du trajet souhaité
 */
function getTrajetById($pdo, $idTrajet) {
    try{
        $sql = "SELECT * FROM trajet WHERE idTrajet = :idTrajet";
        $requete = $pdo->prepare($sql);
        $requete->execute([':idTrajet'=>$idTrajet]);

        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return $result;
    }catch (PDOException $e) {
        $e->getMessage();
    }
}

function getState($pdo, $idTrajet) {
    try {
        $sql = "SELECT plein FROM trajet WHERE idTrajet = ?";
        $requete = $pdo->prepare($sql);
        $requete->execute([$idTrajet]);

        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return $result;

    }catch (PDOException $e) {
        $e->getMessage();
    }
}

function setState($pdo, $idTrajet) {
    try{
        $sql = "UPDATE trajet SET plein = 1 WHERE idTrajet = ?";
        $requete = $pdo->prepare($sql);
        $requete->execute([$idTrajet]);

    }catch(PDOException $e) {
        $e->getMessage();
    }
}

/**
 * @param $pdo
 * @param $idUser
 * @return mixed
 */
function getImmaById($pdo, $idUser) {
    try{
        $sql = "SELECT immaVoiture FROM utilisateur WHERE mailUtilisateur = ?";
        $requete = $pdo->prepare($sql);
        $requete->execute([$idUser]);

        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return $result;
    }catch (PDOException $e) {
        $e->getMessage();
    }
}

/**
 * @param $pdo
 * @param $idConducteur
 * @param $villeDep
 * @param $dateDep
 * @param $heureDep
 * @param $villeArr
 * @param $villeEtape
 * @param $nbPlaces
 * @param $prix
 * @param $commentaires
 * @param $immatriculation
 * @return bool
 */
function createTrajet($pdo, $idConducteur, $villeDep, $dateDep, $heureDep, $villeArr,
                      $villeEtape, $nbPlaces, $prix, $commentaires, $immatriculation) {
    try {
        $sql = "INSERT INTO trajet SET 
                                   villeDep = ?,
                                   villeArr = ?,
                                   villeEtape = ?,
                                   heureDep = ?,
                                   dateDep = ?,
                                   nbPassagers = ?,
                                   prix = ?,
                                   immaVoiture = ?,
                                   idConducteur = ?,
                                   plein = 0,
                                   commentaires = ?";
        $requete = $pdo->prepare($sql);
        if($requete->execute([$villeDep, $villeArr, $villeEtape, $heureDep,
            $dateDep, $nbPlaces, $prix, $immatriculation, $idConducteur, $commentaires])) {
            return true;
        }
        return false;

    }catch(PDOException $e) {
        $e->getMessage();
    }
}


/**
 * Effectue l'enregitrement d'une réservation dans la bd
 * fait un update sur le nombre de places disponibles
 * puis un insert de l'id de la personne qui effectue la réservation
 * @param $pdo object connexion a la bd
 */
function reservation($pdo, $idTrajet, $nomPassager, $nbPlaces) {

    try{
        $sqlInsert = "UPDATE trajet SET idPassagers = ? WHERE idTrajet = ?";
        $sqlUpdate = "UPDATE trajet SET nbPassagers = ? WHERE idTrajet = ?";

        $pdo->beginTransaction();
        //insertion nom passager
        $stmt1 = $pdo->prepare($sqlInsert);
        $stmt1->execute([$nomPassager, $idTrajet]);
        //update nb places
        $stmt2 = $pdo->prepare($sqlUpdate);
        $stmt2->execute([$nbPlaces, $idTrajet]);

        $pdo->commit();
        return true;
    }catch (PDOException $e) {
        $pdo->rollBack();
        $e->getMessage();
        return false;
    }
}

function formatageDate($date) {
    $dateFormat= explode('/',$date);
    return $dateFormat[2].'-'.$dateFormat[1].'-'.$dateFormat[0];
}

function testDate($date) {
    $dateInt= explode('-',$date);
    $dateTrajet = mktime(0,0,0,$dateInt[1],$dateInt[2],$dateInt[0],-1);
    return $dateTrajet;
}