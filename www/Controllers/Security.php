<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\AddUser;
use App\Forms\ConnectionUser;
use App\Forms\Registration;
use App\Models\Article;
use App\Models\Commentaire;
use App\Models\Signalement;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//use PHPMailer\PHPMailer\Exception;
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
                echo "Email ou mot de passe incorrect!";
            }
        }
    }

    public function register(): void
    {
        session_start();
        $form = new Registration();
        $view = new View("Auth/register", "inscription");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            // $errors = Verificator::formRegister($form->getConfig(), $_POST);
            $user = new User();
            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $user->setCountry($_POST['country']);
            $user->setRole('user');
            $user->setDateInserted($formattedDate);
            $user->setDateUpdated($formattedDate);
            if (
                !empty($_POST['user_firstname']) &&
                !empty($_POST['user_lastname']) &&
                !empty($_POST['email']) &&
                !empty($_POST['password']) &&
                !empty($_POST['user_country'])
            ) {
                $user->save();
                $_SESSION['email'] = $user->getEmail();
                header('Location: accueil');
//                $mail = new PHPMailer();
            } else {
                echo "Informations manquantes";
            }
            exit;
        }
    }

    public function commentaire()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
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
                if ($signalement->existeSignalement()) {
                    $commentaireSignale = true;
                } else {
                    $commentaireSignale = false;
                }
                $table[] = [
                    'id' => $com['id'],
                    'content' => $com['content'],
                    'author' => $userData['lastname'] . ' ' . $userData['firstname'].' ('.$userData['pseudo'].')',
                    'answer' => $com['answer'],
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
            http_response_code(404);
            include('./Views/Error/404.view.php');
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
        if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
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
                    'author' => $userData['lastname'] . ' ' . $userData['firstname'].' ('.$userData['pseudo'].')',
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
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
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
            http_response_code(404);
            include('./Views/Error/404.view.php');
            exit;
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