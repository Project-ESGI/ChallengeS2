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
        if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
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
                        header('Location: modifyarticle?id=' . $id . '&action=empty&type=titre&entity=article');
                    } else if (empty($_POST['content'])) {
                        header('Location: modifyarticle?id=' . $id . '&action=empty&type=contenu&entity=article');
                    } else if (empty($_POST['category'])) {
                        header('Location: modifyarticle?id=' . $id . '&action=empty&type=categorie&entity=article');
                    } else {
                        $title = $_POST['title'];
                        $content = $_POST['content'];
                        $category = $_POST['category'];

                        if ($page->existsWith($title, $page->getId())) {
                            header('Location: modifyarticle?id=' . $id . '&action=doublon&type=titre&entity=article');
                        } else {
                            $page->actionArticle($title, $content, $category, null, null, $formattedDate);
                            header('Location: article?action=updated&entity=article');
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
        if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
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
                        header('Location: modifyuser?id=' . $id . '&action=empty&type=prenom&entity=utilisateur');
                    } else if (empty($_POST['lastname'])) {
                        header('Location: modifyuser?id=' . $id . '&action=empty&type=nom&entity=utilisateur');
                    } else if (empty($_POST['email'])) {
                        header('Location: modifyuser?id=' . $id . '&action=empty&type=email&entity=utilisateur');
                    } else if (empty($_POST['country'])) {
                        header('Location: modifyuser?id=' . $id . '&action=empty&type=pays&entity=utilisateur');
                    } else {
                        $firstname = $_POST['firstname'];
                        $lastname = $_POST['lastname'];
                        $pseudo = $_POST['pseudo'];
                        $email = $_POST['email'];
                        $country = $_POST['country'];
                        $role = $_POST['role'];

                        if ($user->existsWithEmail($email, $user->getId())) {
                            header('Location: modifyuser?id=' . $id . '&action=doublon&type=email&entity=utilisateur');
                        } else {
                            $user->saveUser(
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
                            header('Location: user?action=updated&entity=utilisateur');
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

    public function modifyContent()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
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

            if ($user !== null) {
                if ($form->isSubmit()) {
                    if (empty($_POST['content'])) {
                        header('Location: modifycomment?id=' . $id . '&action=empty&type=content&entity=commentaire');
                    } else {
                        $firstname = $_POST['firstname'];
                        $lastname = $_POST['lastname'];
                        $pseudo = $_POST['pseudo'];
                        $email = $_POST['email'];
                        $country = $_POST['country'];
                        $role = $_POST['role'];

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
}