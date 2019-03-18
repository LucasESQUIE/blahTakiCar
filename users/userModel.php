<?php

require_once "../utilities/dataSource.php";

/**
 * Vérifie si le couple identifiant/ mot de passe passé en paramètre est correct
 * @param $pdo object connexion à la BD
 * @param $mail string identifiant à vérifier
 * @param $password string mot de passe à vérifier
 * @return bool true si le couple est valide, false sinon
 */
function verifInfoConnexion($pdo, $mail) {
    try{
        $sql = "SELECT mailUtilisateur, role, mdp, confirme FROM utilisateur WHERE mailUtilisateur = :mail";
        $requete = $pdo->prepare($sql);
        $requete->execute(['mail'=>$mail]);

        return $requete;

    }catch(PDOException $e) {
        $e->getMessage();
    }
}

/**
 * Ajoute un nouvel utilisateur dans la BD
 * @param $pdo object connexion à la BD
 * @param $userMail string mail de l'utilisateur
 * @param $userName string nom de l'utilisateur
 * @param $userSurname string prenom de l'utilisateur
 * @param $userFiliere string filiere de l'utilisateur
 * @param $password string mot de passe de l'utilisateur (doit etre encodé lors de l'appel de cette fonction
 * @param $userTel string numéro de téléphone de l'utilisateur
 * @param $clefConfirm  string clé nécessaire pour la confirmation de l'inscription de l'utilisateur
 * (générée aléatoirement à l'aide d'une fonction)
 * @return bool true si l'insertion a réussi, false sinon
 */
function newUser($pdo, $userMail, $userName, $userSurname, $userFiliere, $password, $userTel, $clefConfirm) {
    try{
        $sql = "INSERT INTO utilisateur SET 
                                       mailUtilisateur = ?,
                                       nom = ?,
                                       prenom = ?,
                                       filiere = ?,
                                       mdp = ?,
                                       numTel = ?,
                                       cleconfirm = ?";

        $requete = $pdo->prepare($sql);
        if($requete->execute([$userMail, $userName, $userSurname,
            $userFiliere, $password, $userTel, $clefConfirm])) {
            return true;
        }
        return false;

    }catch(PDOException $e){
        $e->getMessage();
    }
}

function getClefConfirm($pdo, $mail) {
    try {
        $sql = "SELECT cleconfirm FROM utilisateur WHERE mailUtilisateur = ?";
        $requete = $pdo->prepare($sql);
        $requete->execute(array($mail));
        $result = $requete->fetch(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

/**
 * Vérifie si l'utilisateur existe déjà dans la BD
 * @param $mailUser string id de l'utilisateur
 * @return bool true si l'utilisateur existe
 *              false si il n'existe pas
 */
function comptePresent($mailUser) {
    $db = getPDO();
    try {
        $requete= $db->prepare("SELECT * FROM utilisateur WHERE mailUtilisateur = :mailUser");
        $requete->execute(array($mailUser));
        if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
            $requete-> closeCursor();
            return true;
        }

    } catch (PDOException $e) {
        $e->getMessage();
        return false;
    }
}

function verificationMail($userMail, $clefConfirm) {
    $db = getPDO();
    try {
        $requete = $db->prepare("SELECT * FROM utilisateur WHERE mailUtilisateur = ? AND cleconfirm = ?");
        $requete->execute(array($userMail, $clefConfirm));
        $mailExist = $requete->rowCount();
        if ($mailExist == 1) {
            $user = $requete->fetch();
            if ($user['confirme'] == 0) {
                $majuser = $db->prepare("UPDATE utilisateur SET confirme = 1 WHERE mailUtilisateur = ? AND cleconfirm = ?");
                $majuser->execute(array($userMail, $clefConfirm));
                echo("<script type='text/javascript'>window.location='../index.php?&action=confirme';</script>");
            } else {
                $messageErreur = "Votre compte a déjà été confirmé !";
                echo("<script type='text/javascript'>window.location='../index.php?&action=dConfirme';</script>");
            }
        } else {
            $messageErreur = "Mail non existant !";
            //echo("<script type='text/javascript'>window.location='../index.php';</script>");
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function verifCompte($mailUser) {
    $db = getPDO();
    try {
        $requete= $db->prepare("SELECT * FROM utilisateur WHERE mailUtilisateur = :mailUser");
        $requete->execute(array($mailUser));
        if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
            $requete-> closeCursor();
            return true;
        }
        return false;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function modifClefConfirm($userMail, $clefConfirm) {
    $db = getPDO();
    try {
        $requete = $db->prepare("UPDATE utilisateur SET cleconfirm = :clefConfirm 
                                          WHERE mailUtilisateur = :userMail");
        if ($requete->execute(array($clefConfirm, $userMail))) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function modificationMdp($pdo ,$userMail, $password) {
    try {
        $requete = $pdo->prepare("UPDATE utilisateur SET mdp = ? WHERE mailUtilisateur = ? ");
        if ($requete->execute(array($password, $userMail))) {
            return true;
        }
        return false;
    } catch (PDOexception $e) {
        $e->getMessage();
    }
}



/* PROFIL */
/**
 * Récupère les informations concernant l'utilisateur dont l'id est passé en paramètre
 * @param $pdo object connexion à la BD
 * @param $idUser string id de l'utilisateur
 * @return mixed un tableau contenant les informations de l'utilisateur
 */
function recupInfoUser($pdo, $idUser) {
    try {
        $sql = "SELECT * FROM utilisateur WHERE mailUtilisateur = :idUser";
        $requete = $pdo->prepare($sql);
        $requete->execute(["idUser"=>$idUser]);
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function UpdateInfoProfil($id) {
    $pdo = getPDO();
    $requete = 'UPDATE utilisateur SET nom = :nom,
                                           prenom = :prenom,
                                           numTel = :tel,
                                           filiere = :filiere,
                                           modele_voiture = :modele,
                                           marque_voiture = :marque,
                                           couleur_voiture = :couleur
                                           WHERE mailUtilisateur = :userMail';
    $update = $pdo->prepare($requete);
    $update->execute([ 'nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'tel' => $_POST['tel'], 'filiere' => $_POST['filiere'], 'modele' => $_POST['modele'], 'marque' => $_POST['marque'], 'couleur' => $_POST['couleur'], 'userMail' => $id ]);
}

/**
 * Met à jour la photo de la voiture dans la base de données
 * @param $pdo object connexion à la BD
 * @param $chemin string chemin relatif de l'image sur le serveur
 * @param $id string id de l'utilisateur
 */
function UpdatePhotoProfil($chemin, $id) {
    $pdo = getPDO();
    try {
        $sql = "UPDATE utilisateur SET photoUtilisateur = :photoUtilisateur WHERE mailUtilisateur = :mailUtilisateur";
        $requete = $pdo->prepare($sql);
        $requete->execute(array($chemin,$id));
        $result = $requete->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

/**
 * Met à jour la photo de la voiture dans la base de données
 * @param $pdo object connexion à la BD
 * @param $chemin string chemin relatif de l'image sur le serveur
 * @param $id string id de l'utilisateur
 */
function UpdatePhotoVoiture($chemin, $id) {
    $pdo = getPDO();
    try {
        $sql = "UPDATE utilisateur SET photo_voiture = :photoVoiture WHERE mailUtilisateur = :mailUtilisateur";
        $requete = $pdo->prepare($sql);
        $requete->execute(array($chemin,$id));
        $result = $requete->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
?>