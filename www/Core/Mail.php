<?php

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once './public/PHPMailer-master/src/PHPMailer.php';
require_once './public/PHPMailer-master/src/SMTP.php';
require_once './public/PHPMailer-master/src/Exception.php';

class Mail
{
    private string $email;
    private string $subject;
    private string $message;

    public function __construct(string $email, string $subject, string $message)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->message = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $this->message);
        $this->subject = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $this->subject);
    }

    public function sendEmail(): bool
    {
        $email = $this->email;
        $subject = $this->subject;
        $message = $this->message;
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = 'ufc608767@gmail.com';
        $mail->Password = 'swbgtukfzvndtjkl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('ufc608767@gmail.com', 'UFC Football');
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->IsHTML(true);

        try {
            if (!$mail->send()) {
                // Erreur lors de l'envoi de l'e-mail
                return false;
            } else {
                // Succès de l'envoi de l'e-mail
                return true;
            }
        } catch (Exception $e) {
            // Une exception s'est produite (par exemple, une erreur de connexion SMTP)
            // Afficher un message d'erreur convivial
            echo 'Erreur, impossible d\'envoyer l\'e-mail. Veuillez vérifier votre connexion Internet.';
            return false;
        }
    }
}

?>