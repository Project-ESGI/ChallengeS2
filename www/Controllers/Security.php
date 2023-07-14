<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\AddUser;
use App\Forms\ConnectionUser;
use App\Models\Article;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
date_default_timezone_set('Europe/Paris');


class Security
{
    public function login(): void
    {
        session_start();
        $form = new ConnectionUser();
        $view = new View("Auth/connection", "connection");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $user = new User();
            $user->setEmail($_POST['user_email']);
            $user->setPassword($_POST['user_password']);
            $userExists = $user->existUser($user->getEmail(), $_POST['user_password']);
            if ($userExists) {
//                $mail = new PHPMailer(true);
//                $mail->isSMTP();
//                $mail->Host = 'smtp.gmail.com';  // Remplacez par le serveur SMTP de votre choix
//                $mail->SMTPAuth = true;
//                $mail->Username = 'melvinpierre283@gmail.com';  // Votre adresse e-mail
//                $mail->Password = 'votre_mot_de_passe';  // Votre mot de passe
//                $mail->SMTPSecure = 'tls';
//                $mail->Port = 587;
//                $mail->setFrom('melvinpierre283@gmail.com', 'Melvin');  // Adresse d'envoi et nom de l'expéditeur
//
//                $to = $user->getEmail();
//                $subject = 'Connexion à votre compte';
//                $message = "Bonjour,\n\nUne connexion à votre compte a été effectuée avec l'adresse IP : " . $_SERVER['REMOTE_ADDR'];
//                $mail->addAddress($to);
//                $mail->Subject = $subject;
//                $mail->Body = $message;
//                $mail->send();

                $_SESSION['user_email'] = $user->getEmail();
                header('Location: accueil');
                exit;
            } else {
                echo "Email ou mot de passe incorrect!";
            }
        }
    }

    public function register(): void
    {
        session_start();
        $form = new AddUser();
        $view = new View("Auth/register", "inscription");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            // $errors = Verificator::formRegister($form->getConfig(), $_POST);
            $user = new User();
            $user->setFirstname($_POST['user_firstname']);
            $user->setLastname($_POST['user_lastname']);
            $user->setEmail($_POST['user_email']);
            $user->setPassword($_POST['user_password']);
            $user->setCountry($_POST['user_country']);
            $user->setRole('user');
            $user->setDateInserted($formattedDate);
            $user->setDateUpdated($formattedDate);
            if (
                !empty($_POST['user_firstname']) &&
                !empty($_POST['user_lastname']) &&
                !empty($_POST['user_email']) &&
                !empty($_POST['user_password']) &&
                !empty($_POST['user_country'])
            ) {
                $user->save();
                $_SESSION['user_email'] = $user->getEmail();
                header('Location: accueil');
//                $mail = new PHPMailer();
//            $mail->isSMTP();
//            $mail->Host = 'smtp.gmail.com';  // Remplacez par le serveur SMTP de votre choix
//            $mail->SMTPAuth = true;
//            $mail->Username = 'melvinpierre283@gmail.com';  // Votre adresse e-mail
//            $mail->Password = 'votre_mot_de_passe';  // Votre mot de passe
//            $mail->SMTPSecure = 'tls';
//            $mail->Port = 587;
//            $mail->setFrom('melvinpierre283@gmail.com', 'Melvin Pierre');  // Adresse d'envoi et nom de l'expéditeur
//
//            $to = $user->getEmail();
//            $subject = 'Bienvenue sur notre site';
//            $message = "Bonjour " . $user->getFirstname() . ",\n\nBienvenue sur notre site !";
//            $mail->addAddress($to);
//            $mail->Subject = $subject;
//            $mail->Body = $message;
//            $mail->send();
            } else {
                echo "Informations manquantes";
            }
            exit;
        }
    }

    /**
     * @Route("/article", name="article")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function article(): void
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['user_email']);
            $user_pseudo = $userData['firstname'] . ' ' . $userData['lastname'];
            $user_role = $userData['role'];

            $page = new Article();
            $pages = $page->getAllValue();
            $table = [];

            foreach ($pages as $page) {
                $userId = $page['author'];
                $userData = $user->getById($userId);

                $table[] = [
                    'id' => $page['id'],
                    'title' => $page['title'],
                    'content' => $page['content'],
                    'author' => $userData['lastname'] . ' ' . $userData['firstname'],
                    'category' => $page['category'],
                    'date_inserted' => $page['date_inserted'],
                    'date_updated' => $page['date_updated']
                ];
            }

            $view = new View("Auth/article", "article");
            $view->assign('table', $table);
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);
        } else {
            http_response_code(404);
            include('./Views/Error/404.view.php');
            exit;
        }
    }

    public function user(): void
    {

        $user = new User();
        $users = $user->getAllValue();
        $table = [];

        foreach ($users as $user) {
            $table[] = [
                'id' => $user['id'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'email' => $user['email'],
                'date_inserted' => $user['date_inserted'],
                'date_updated' => $user['date_updated'],
                'country' => $user['country'],
                'banned' => $user['banned'],
                'password' => $user['password'],
                'role' => $user['role']
            ];
        }
        $view = new View("Auth/user", "user");
        $view->assign('table', $table);
    }

    public function logout(): void
    {
        session_start();
        session_unset(); // Supprime toutes les variables de session
        session_destroy(); // Détruit la session
        header('Location: /login');
        exit;
    }
}