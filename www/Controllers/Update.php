<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\Verificator;
use App\Core\View;
use App\Forms\AddArticle;
use App\Forms\AddComment;
use App\Forms\AddUser;
use App\Models\Article;
use App\Models\Commentaire;
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
        if (AuthorizationHelper::hasPermission()) {
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
            $view->assign('form', $form->getConfig($result, 1));
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

            // Vérifier si l'article existe
            if ($page !== null) {
                if ($form->isSubmit()) {
                    $error = Verificator::form($form->getConfig(), $_POST);

                    foreach ($error as $e => $data) {
                        $form->addError($e, $data);
                    }

                    $view->assign('form', $form->getConfig($_POST, 1));

                    if (!$error) {
                        $page->actionArticle($id, $_POST['title'], $_POST['slug'], $_POST['content'], $_POST['category'], $_SESSION['id'], null, $formattedDate);
                        header('Location: article?action=updated&entity=article');
                        exit;
                    } else {
                        exit;
                    }
                }
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }


    public function modifyUser()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
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
            $view->assign('form', $form->getConfig($result, 1));
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

            // Vérifier si le user existe
            if ($user !== null) {
                if ($form->isSubmit()) {
                    $error = Verificator::form($form->getConfig(), $_POST);

                    foreach ($error as $e => $data) {
                        $form->addError($e, $data);
                    }

                    $view->assign('form', $form->getConfig($_POST, 1));

                    if (!$error) {
                        $user->saveUser(
                            $id,
                            $_POST['firstname'],
                            $_POST['lastname'],
                            $_POST['pseudo'],
                            $_POST['email'],
                            null,
                            $_POST['country'],
                            $_POST['role'],
                            null,
                            $formattedDate
                        );
                        if ($user->getId() === $_SESSION['id'] && $user->getEmail() !== $_SESSION['email']) {
                            header('Location: logout');
                        } else {
                            header('Location: user?action=updated&entity=utilisateur');
                        }
                        exit;
                    } else {
                        exit;
                    }
                }
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    public function modifyComment()
    {
        if (AuthorizationHelper::hasPermission()) {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
            $user_role = $userData['role'];

            $commentaire = new Commentaire();
            $id = $_GET['id'];
            $user = new User();
            $user->setIdValueString($id);
            $date = new \DateTime();
            $result = $user->getById($id);


            $formattedDate = $date->format('Y-m-d H:i:s');
            $view = new View("Auth/addComment", "comment");
            $form = new AddComment();
            $view->assign('form', $form->getConfig($result));
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

            if ($user !== null) {
                if ($form->isSubmit()) {
                    $error = false;


                    $view->assign('form', $form->getConfig($_POST, 1));

                    if (!$error) {
                        $commentaire->saveCommentaire($id, $_POST['content'], $_SESSION['id'], null, $formattedDate);

                        // Redirection vers la page de confirmation
                        header('Location: accueil?action=updated&entity=commentaire');
                        exit;
                    }
                }
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }
}