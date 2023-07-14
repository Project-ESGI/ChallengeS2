<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddArticle;
use App\Models\Article;
use App\Models\User;
use App\Forms\AddUser;

date_default_timezone_set('Europe/Paris');


class Add
{
    public function addArticle(): void
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['user_email']);
            $user_pseudo = $userData['firstname'] . ' ' . $userData['lastname'];
            $user_role = $userData['role'];

            $form = new AddArticle();
            $view = new View("Auth/addArticle", "article");
            $date = new \DateTime();
            $formattedDate = $date->format('Y-m-d H:i:s');

            $view->assign('form', $form->getConfig());
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);
            if ($form->isSubmit()) {
                $page = new Article();
                if (empty($_POST['title'])) {
                    header('Location: addarticle?action=empty&type=titre&entity=article');
                } else if (empty($_POST['content'])) {
                    header('Location: addarticle?action=empty&type=contenu&entity=article');
                } else {
                    $title = $_POST['title'];
                    $content = $_POST['content'];
                    $category = $_POST['category'];
                    $author = $_SESSION['id']; // Définir l'ID de l'auteur de la session actuelle

                    if ($page->existsWith($title)) {
                        header('Location: addarticle?action=doublon&type=titre&entity=article');
                    } else {
                        $page->actionArticle($title, $content, $category, $author, $formattedDate, $formattedDate);
                        header('Location: article?action=created');
                        exit;
                    }
                }
            }
        } else {
            http_response_code(404);
            include('./Views/Error/404.view.php');
            exit;
        }
    }

    public function addUser(): void
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['user_email']);
            $user_pseudo = $userData['firstname'] . ' ' . $userData['lastname'];
            $user_role = $userData['role'];

            $form = new AddUser();
            $view = new View("Auth/addUser", "user");
            $date = new \DateTime();
            $formattedDate = $date->format('Y-m-d H:i:s');
            $view->assign('form', $form->getConfig());
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

            if ($form->isSubmit()) {
                $user = new User();
                if (empty($_POST['user_firstname'])) {
                    header('Location: adduser?action=empty&type=prenom&entity=utilisateur');
                } else if (empty($_POST['user_lastname'])) {
                    header('Location: adduser?action=empty&type=nom&entity=utilisateur');
                } else {
                    $firstname = $_POST['user_firstname'];
                    $lastname = $_POST['user_lastname'];
                    $email = $_POST['user_email'];
                    $password = $_POST['user_password'];
                    $country = $_POST['user_country'];
                    $role = $_POST['user_role'];

                    if ($user->existsWithEmail($email)) {
                        header('Location: adduser?action=doublon&type=email&entity=utilisateur');
                    } else {
                        $user->registerUser($firstname, $lastname, $email, $password, $country, $role, $formattedDate, $formattedDate);
                        header('Location: user?action=created&entity=utilisateur');
                        exit;
                    }
                }
            }
        } else {
            http_response_code(404);
            include('./Views/Error/404.view.php');
            exit;
        }
    }
}