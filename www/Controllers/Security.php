<?php

namespace App\Controllers;

use App\Core\Verificator;
use App\Core\View;
use App\Forms\ConnectionUser;
use App\Forms\Registration;
use App\Forms\ResetPassword;
use App\Models\Article;
use App\Models\Commentaire;
use App\Models\Signalement;
use App\Models\User;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Controllers\AuthorizationHelper;

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
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $userExists = $user->existUser($user->getEmail(), $_POST['password']);
            if ($userExists) {
//                $mail = new PHPMailer(true);
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
        session_start();
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


    public function register(): void
    {
        session_start();
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

                // Envoi de l'e-mail de confirmation d'inscription
                $userEmail = 'jackmbappekoum@outlook.fr';// Assurez-vous que cette variable contient l'adresse e-mail du destinataire



                $mail = new PHPMailer(true);
                // Configurer les paramètres du serveur SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.live.com'; // Remplacez par l'adresse de votre serveur SMTP
                $mail->SMTPAuth   = true;
                $mail->Username   = 'jackmbappekoum@outlook.fr'; // Remplacez par l'adresse e-mail de l'expéditeur
                $mail->Password   = 'DouglasCosta90!'; // Remplacez par le mot de passe de l'expéditeur
                $mail->SMTPSecure = 'ssl'; // Selon votre serveur, utilisez 'ssl' ou 'tls'
                $mail->Port       = 587; // Remplacez par le port SMTP souhaité

                // Paramètres de l'expéditeur et du destinataire
                $mail->setFrom('jmbappekoum@myges.fr', 'Jasam'); // Remplacez par l'adresse e-mail de l'expéditeur
                $mail->addAddress($userEmail); // Adresse e-mail du destinataire

                // Contenu de l'e-mail
                $mail->isHTML(true);
                $mail->Subject = 'Confirmation d\'inscription';
                $mail->Body    = 'Bienvenue ! Votre inscription a été confirmée.';

                // Envoyer l'e-mail
                try {
                    $mail->send();
                    // E-mail envoyé avec succès
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo; // Erreur lors de l'envoi de l'e-mail, vous pouvez afficher un message d'erreur ou journaliser l'erreur
                }

                header('Location: accueil');
                exit;
            }
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
            $userData = $user->getByEmail($_SESSION['email']);
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
        session_start();
        session_unset(); // Supprime toutes les variables de session
        session_destroy(); // Détruit la session
        header('Location: /login');
        exit;
    }
}