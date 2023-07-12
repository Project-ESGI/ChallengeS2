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
                    echo 'L\'article doit avoir un titre';
                } else if (empty($_POST['content'])) {
                    echo 'L\'article doit avoir un contenu';
                } else {
                    $title = $_POST['title'];
                    $content = $_POST['content'];
                    $category = $_POST['category'];
                    $author = $_SESSION['id']; // Définir l'ID de l'auteur de la session actuelle

                    if ($page->existsWith($title)) {
                        echo 'Une page avec ce titre existe déjà';
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
        $form = new AddUser();
        $view = new View("Auth/addUser", "user");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d H:i:s');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            $user = new User();
            if (empty($_POST['user_firstname'])) {
                echo 'Le user doit avoir un prénom';
            } else if (empty($_POST['user_lastname'])) {
                echo 'Le user doit avoir un nom';
            } else {
                $firstname = $_POST['user_firstname'];
                $lastname = $_POST['user_lastname'];
                $email = $_POST['user_email'];
                $password = $_POST['user_password'];
                $country = $_POST['user_country'];

                if ($user->existsWithF($firstname)) {
                    echo 'Un user existe deja avec ce prénom';
                } else {
                    $user->setFirstname($firstname);
                    $user->setLastname($lastname);
                    $user->setEmail($email);
                    $user->setPassword($password);
                    $user->setDateInserted($formattedDate);
                    $user->setDateUpdated($formattedDate);
                    $user->setCountry($country);
                    $user->save();
                    header('Location: user?action=created');
                    exit;
                }
            }
        }
    }
}