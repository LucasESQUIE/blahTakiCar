<?php
  use PHPMailer\PHPMailer\PHPMailer;
  require_once"PHPMailer-master/src/PHPMailer.php";
  require_once"PHPMailer-master/src/Exception.php";
  require_once"PHPMailer-master/src/SMTP.php";

  define('USER','blahtakicar@gmail.com'); //nom d'utilisateur de l'adresse d'envoi
  define('MDP','BlTkCa@75'); //mot de passe de l'adresse d'envoi

    function envoiMail($dest, $emet, $nomEmet, $sujet, $contenu ) {

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = USER;
        $mail->Password = MDP;
        $mail->SetFrom($emet, $nomEmet);
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body = $contenu;
        $mail->AddAddress($dest);
        if (!$mail->Send()) {
            return 'Erreur mail: ' . $mail->ErrorInfo;
        } else {
            return true;
        }
    }

    $corpsInscription = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Mail de confirmation</title>
            <style type="text/css">
                
            </style>
        </head>
        <body>
        <a href="http://localhost/blahMVC/users/userViewConnexion.php?&mail='
        .urlencode($mail).'&clefConfirm='.urlencode($clefConfirm).'">
            Cliquez sur le lien pour confirmer votre inscription</a>
        </body>
    </html>';

    $corpsOubliMdp = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Modification de mot de passe</title>
            <style type="text/css">
                
            </style>
        </head>
        <body>
        <a href="http://localhost/BlahMVC/users/userViewModifMdp.php?&mail='
    .urlencode($mail).'&clefConfirm='.urlencode($clefConfirm).'">
            Cliquez sur le lien pour modifier votre mot de passe</a>
        </body>
    </html>';



?>