<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\Verificator;
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
        if (AuthorizationHelper::hasPermission()) {
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
                $error = Verificator::form($form->getConfig(), $_POST);

                foreach ($error as $e => $data) {
                    $form->addError($e, $data);
                }

                $view->assign('form', $form->getConfig($_POST));

                if (!$error) {
                    $page->actionArticle(null, $_POST['title'], $_POST['slug'], $_POST['content'], $_POST['category'], $_SESSION['id'], $formattedDate, $formattedDate);
                    header('Location: article?action=created&entity=article');
                    exit;
                } else {
                    exit;
                }
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    function addComment()
    {
        if (AuthorizationHelper::hasPermission()) {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
            $user_role = $userData['role'];

            $commentaire = new Commentaire();

            $result = null;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $user = new User();
                $user->setIdValueString((int)$id); // Convertir la valeur de $id en un entier
                $date = new \DateTime();
                $result = $user->getById($id);
                // Reste du code ici...
            }

            $date = new \DateTime();
            $formattedDate = $date->format('Y-m-d H:i:s');
            $view = new View("Auth/addUser", "user");
            $form = new AddComment();
            $view->assign('form', $form->getConfig($result));
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

            if ($user !== null) {
                if ($form->isSubmit()) {
                    $error = Verificator::form($form->getConfig(), $_POST);

                    foreach ($error as $e => $data) {
                        $form->addError($e, $data);
                    }

                    $view->assign('form', $form->getConfig($_POST));

                    if (!$error) {
                        $commentaire->saveCommentaire(null, $_POST['content'], $_SESSION['id'], $formattedDate, $formattedDate);
                        header('Location: accueil?action=created&entity=commentaire');
                        exit;
                    }
                }
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    public function addUser(): void
    {
        if (AuthorizationHelper::hasPermission('admin')) {
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

                $error = Verificator::form($form->getConfig(), $_POST);

                foreach ($error as $e => $data) {
                    $form->addError($e, $data);
                }

                $view->assign('form', $form->getConfig($_POST));

                if (!$error) {
                    $user->saveUser(null, $_POST['firstname'], $_POST['lastname'], $_POST['pseudo'], $_POST['email'], $_POST['password'], $_POST['country'], $_POST['role'], $formattedDate, $formattedDate);
                    header('Location: user?action=created&entity=utilisateur');
                    exit;
                }
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }
}

