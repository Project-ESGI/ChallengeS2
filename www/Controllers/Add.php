<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddArticle;
use App\Forms\AddUser;
use App\Models\Article;
use App\Models\User;
use App\Forms\AddComment;
use App\Models\Commentaire;

date_default_timezone_set('Europe/Paris');


class Add
{
    public function addArticle(): void
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
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
                        header('Location: article?action=created&entity=article');
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

    function addComment()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
            $user_role = $userData['role'];

            $commentaire = new Commentaire();
            //ICI MODIFIER

            $id = $_GET['id'];
            $user = new User();
            $user->setIdValue($id);
            $date = new \DateTime();
            $result = $user->getById($id);

            $formattedDate = $date->format('Y-m-d H:i:s');
            $view = new View("Auth/addUser", "user");
            $form = new AddComment();
            $view->assign('form', $form->getConfig($result));
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

            if ($user !== null) {
                if ($form->isSubmit()) {
                    if (empty($_POST['content'])) {
                        header('Location: addcomment?action=empty&type=content&entity=commentaire');
                    } else {
                        $content = $_POST['content'];

                        //fonction modifier commentaire meme que ajouter
                        header('Location: accueil?action=updated&entity=commentaire');
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
        if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
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
                if (empty($_POST['firstname'])) {
                    header('Location: adduser?action=empty&type=prenom&entity=utilisateur');
                } else if (empty($_POST['lastname'])) {
                    header('Location: adduser?action=empty&type=nom&entity=utilisateur');
                } else {
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $country = $_POST['country'];
                    $role = $_POST['role'];
                    $pseudo = $_POST['pseudo'];

                    if ($user->existsWithEmail($email)) {
                        header('Location: adduser?action=doublon&type=email&entity=utilisateur');
                    } else {
                        $user->saveUser($firstname, $lastname, $pseudo, $email, $password, $country, $role, $formattedDate, $formattedDate);
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