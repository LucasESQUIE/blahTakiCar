<?php
  use PHPMailer\PHPMailer\PHPMailer;
  require_once"PHPMailer-master/src/PHPMailer.php";
  require_once"PHPMailer-master/src/Exception.php";
  require_once"PHPMailer-master/src/SMTP.php";
  require_once"corpsMail.php";

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
        $mail->Subject = utf8_decode($sujet);
        $mail->Body = utf8_decode($contenu);
        $mail->AddAddress($dest);
        if (!$mail->Send()) {
            return 'Erreur mail: ' . $mail->ErrorInfo;
        } else {
            return true;
        }
    }
?>