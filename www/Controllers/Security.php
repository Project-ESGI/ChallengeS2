<?php

namespace App\Controllers;

use App\Controllers\AuthorizationHelper;
use App\Core\Mail;
use App\Core\Verificator;
use App\Core\View;
use App\Forms\ConnectionUser;
use App\Forms\Registration;
use App\Forms\ResetPassword;
use App\Forms\TempoPassword;
use App\Models\Article;
use App\Models\Commentaire;
use App\Models\Signalement;
use App\Models\User;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


date_default_timezone_set('Europe/Paris');

class Security
{

    public function login(): void
    {
        $form = new ConnectionUser();
        $view = new View("Auth/connection", "connection");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $userExists = $user->existUser($user->getEmail(), $_POST['password']);
            if ($userExists) {
                $ip = $_SERVER['REMOTE_ADDR'];

                $mailDescription = "Connexion récente sur votre compte avec l' Adresse IP : $ip";

                $mailSubject = "Connexion UFC Sport";
                $mail = new Mail($_POST['email'], $mailSubject, $mailDescription);
                $mail->sendEmail();
                $_SESSION['email'] = $user->getEmail();
                header('Location: accueil');
                exit;
            } else {
                $form->addError('email', 'Email ou mot de passe incorrect!');
                $form->addError('password', 'Email ou mot de passe incorrect!');
                $view->assign('form', $form->getConfig());
            }
        }
    }

    public function reset(): void
    {
        $form = new ResetPassword();
        $view = new View("Auth/reinitialisation", "reset");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $user = new User();
            $user->setEmail($_POST['email']);
            $userExists = $user->existUser($user->getEmail());
            if ($userExists) {
//                $mail = new PHPMailer(true);
                $_SESSION['email'] = $user->getEmail();
                header('Location: accueil');
                exit;
            } else {
                $form->addError('email', 'Email ou mot de passe incorrect!');
                $view->assign('form', $form->getConfig());
            }
        }
    }

    public function tempo(): void
    {
        $form = new ResetPassword();
        $view = new View("Auth/tempopassword", "tempo");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $user = new User();
            $user->setEmail($_POST['email']);
            $userExists = $user->existUser($user->getEmail());
            if ($userExists) {
//                $mail = new PHPMailer(true);
                $_SESSION['email'] = $user->getEmail();
                header('Location: accueil');
                exit;
            } else {
                $form->addError('email', 'Email ou mot de passe incorrect!');
                $view->assign('form', $form->getConfig());
            }
        }
    }


    public function register(): void
    {
        $form = new Registration();
        $view = new View("Auth/register", "inscription");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $user = new User();
            $date = new \DateTime();
            $formattedDate = $date->format('Y-m-d');

            $error = Verificator::form($form->getConfig(), $_POST);

            foreach ($error as $e => $data) {
                $form->addError($e, $data);
            }

            $view->assign('form', $form->getConfig($_POST));
            if (!$error) {
                // Création de l'utilisateur dans la base de données
                $user->saveUser(null, $_POST['firstname'], $_POST['lastname'], $_POST['pseudo'], $_POST['email'], $_POST['password'], $_POST['country'], 'user', $formattedDate, $formattedDate);
                $_SESSION['email'] = $_POST['email'];

                $mailDescription = "Cher utilisateur,\n\nNous sommes ravis de vous compter parmi nous ! Votre inscription a été confirmée avec succès.\n\nMerci de faire partie de notre communauté. Vous pouvez maintenant accéder à toutes les fonctionnalités de notre site et profiter de nos services.\n\nSi vous avez des questions ou avez besoin d'aide, n'hésitez pas à nous contacter. Nous sommes toujours là pour vous aider.\n\nEncore une fois, bienvenue !\n\nCordialement,\nL'équipe de ufc sport";

                $mail = new Mail($_POST['email'], $mailDescription, "Inscription réussie");
                $mail->sendEmail();
            }

            header('Location: accueil');
            exit;
        }
    }


    public function commentaire()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
            $user_role = $userData['role'];
            $user_id = $userData['id'];
            $_SESSION['pseudo'] = $user_pseudo;
            $_SESSION['role'] = $user_role;
            $_SESSION['id'] = $user_id;

            $commentaire = new Commentaire();
            $signalement = new Signalement();
            $commentaires = $commentaire->getAllValue();
            $table = [];

            foreach ($commentaires as $com) {
                $userId = $com['author'];
                $userData = $user->getById($userId);
                $signalement->setCommentId($com['id']);
                $signalement->setUserId($user_id);

                $table[] = [
                    'id' => $com['id'],
                    'content' => $com['content'],
                    'author' => $userData['lastname'] . ' ' . $userData['firstname'] . ' (' . $userData['pseudo'] . ')',
                    'date_inserted' => strftime('%e %B %Y à %H:%M:%S', strtotime($com['date_inserted'])),
                    'date_updated' => strftime('%e %B %Y à %H:%M:%S', strtotime($com['date_updated'])),
                    'is_reported' => $com['report']
                ];
            }

            $view = new View("Auth/comment", "comment");
            $view->assign('table', $table);
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    /**
     * @Route("/article", name="article")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function article(): void
    {
        if (AuthorizationHelper::hasPermission()) {
            $user = new User();
            $userData = AuthorizationHelper::getCurrentUserData();
            $user_pseudo = $userData['pseudo'];
            $user_role = $userData['role'];

            $page = new Article();
            $pages = $page->getAllValueByUser($_SESSION['id']);
            $table = [];

            foreach ($pages as $page) {
                $userId = $page['author'];
                $userData = $user->getById($userId);

                $table[] = [
                    'id' => $page['id'],
                    'title' => $page['title'],
                    'slug' => $page['slug'],
                    'content' => $page['content'],
                    'author' => $userData['lastname'] . ' ' . $userData['firstname'] . ' (' . $userData['pseudo'] . ')',
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
            AuthorizationHelper::redirectTo404();
        }
    }

    public function user(): void
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
            $user_role = $userData['role'];
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
                    'password' => $user['password'],
                    'role' => $user['role'],
                    'pseudo' => $user['pseudo']
                ];
            }
            $view = new View("Auth/user", "user");
            $view->assign('table', $table);
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    public function logout(): void
    {
        session_unset(); // Supprime toutes les variables de session
        session_destroy(); // Détruit la session
        header('Location: /login');
        exit;
    }
}