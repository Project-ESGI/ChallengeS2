<?php
namespace App\Core;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once './public/PHPMailer-master/src/PHPMailer.php';
require_once './public/PHPMailer-master/src/SMTP.php';
require_once './public/PHPMailer-master/src/Exception.php';

class Mail {
    private String $email;
    private String $subject;
    private String $message;

    public function __construct(String $email, String $subject, String $message){
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->message = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $this->message);
        $this->subject = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $this->subject);
    }

    public function sendEmail() :bool{

        $email = $this->email;
        $subject = $this->subject;
        $message = $this->message;
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP
        $mail->Host = 'smtp.gmail.com'; // Spécifier le serveur SMTP
        $mail->SMTPAuth = true; // Activer authentication SMTP
        $mail->SMTPSecure = "ssl";
        $mail->Username = 'ufc608767@gmail.com'; // Votre adresse email d'envoi
        $mail->Password = 'swbgtukfzvndtjkl'; // Le mot de passe de cette adresse email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Accepter SSL
        $mail->Port = 465;

        $mail->setFrom('ufc608767@gmail.com', 'UFC Football'); // Personnaliser l'envoyeur
        $mail->addAddress($email); // Ajouter le destinataire

        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->IsHTML(true);
        // $mail->send();

        if(!$mail->send()) {
            echo 'Erreur, message non envoyé.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return false;
        } else {
            echo 'Le message a bien été envoyé !';
            return true;
        }
    }
}
?>