<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddArticle;
use App\Forms\AddUser;
use App\Models\Article;
use App\Models\User;

date_default_timezone_set('Europe/Paris');


class Update
{
    public function index()
    {
        $view = new View("Auth/article", "dashboard");
    }

    public function modifyArticle()
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['user_email']);
            $user_pseudo = $userData['firstname'] . ' ' . $userData['lastname'];
            $user_role = $userData['role'];

            $id = $_GET['id'];
            $page = new Article();
            $page->setIdValue($id);
            $date = new \DateTime();
            $result = $page->getById($id);

            $formattedDate = $date->format('Y-m-d H:i:s');
            $view = new View("Auth/addArticle", "article");
            $form = new AddArticle();
            $view->assign('form', $form->getConfig($result));
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

            // Vérifier si l'article existe
            if ($page !== null) {
                if ($form->isSubmit()) {
                    if (empty($_POST['title'])) {
                        header('Location: modifyarticle?action=empty&type=titre&entity=article');
                    } else if (empty($_POST['content'])) {
                        header('Location: modifyarticle?action=empty&type=contenu&entity=article');
                    } else if (empty($_POST['category'])) {
                        header('Location: modifyarticle?action=empty&type=categorie&entity=article');
                    } else {
                        $title = $_POST['title'];
                        $content = $_POST['content'];
                        $category = $_POST['category'];

                        if ($page->existsWith($title, $page->getId())) {
                            header('Location: modifyarticle?action=doublon&type=titre&entity=article');
                        } else {
                            $page->actionArticle($title, $content, $category, null, null, $formattedDate);
                            header('Location: article?action=updated');
                            exit;
                        }
                    }
                }
            }
        } else {
            http_response_code(404);
            include('./Views/Error/404.view.php');
            exit;
        }
    }


    public function modifyUser()
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['user_email']);
            $user_pseudo = $userData['firstname'] . ' ' . $userData['lastname'];
            $user_role = $userData['role'];

            $id = $_GET['id'];
            $user = new User();
            $user->setIdValue($id);
            $date = new \DateTime();
            $result = $user->getById($id);

            $formattedDate = $date->format('Y-m-d H:i:s');
            $view = new View("Auth/addUser", "user");
            $form = new AddUser();
            $view->assign('form', $form->getConfig($result));
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

            // Vérifier si le user existe
            if ($user !== null) {
                if ($form->isSubmit()) {
                    if (empty($_POST['firstname'])) {
                        echo 'L\'article doit avoir un prénom';
                    } else if (empty($_POST['lastname'])) {
                        echo 'L\'article doit avoir un nom';
                    } else if (empty($_POST['email'])) {
                        echo 'L\'article doit avoir une email';
                    } else if (empty($_POST['country'])) {
                        echo 'L\'article doit avoir un pays';
                    } else if (empty($_POST['role'])) {
                        echo 'L\'article doit avoir un role';
                    } else {
                        $firstname = $_POST['firstname'];
                        $lastname = $_POST['lastname'];
                        $pseudo = $_POST['pseudo'];
                        $email = $_POST['email'];
                        $country = $_POST['country'];
                        $role = $_POST['role'];

                        if ($user->existsWithEmail($email, $user->getId())) {
                            header('Location: modifyuser?action=doublon&type=email&entity=utilisateur');
                        } else {
                            $user->registerUser(
                                $firstname,
                                $lastname,
                                $pseudo,
                                $email,
                                null,
                                $country,
                                $role,
                                null,
                                $formattedDate
                            );
                            header('Location: user?action=updated');
                            exit;
                        }
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