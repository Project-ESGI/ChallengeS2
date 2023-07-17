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
                $error = false;
                $title = $_POST['title'];
                $content = $_POST['content'];

                if (empty($title)) {
                    $form->addError('title', 'Veuillez saisir un titre.');
                    $error = true;
                } elseif ($page->existsWith($title)) {
                    $form->addError('title', 'Un article avec ce titre existe déjà.');
                    $error = true;
                }
                if (empty($content)) {
                    $form->addError('content', 'Veuillez saisir votre contenu.');
                    $error = true;
                }

                $view->assign('form', $form->getConfig($_POST));

                if (!$error) {
                    $page->actionArticle($title, $content, $_POST['category'], $_SESSION['id'], $formattedDate, $formattedDate);
                    header('Location: article?action=created&entity=article');
                    exit;
                } else {
                    exit;
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
                        exit;
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
                $error = false;
                $email = $_POST['email'];

                if (empty($_POST['firstname'])) {
                    $form->addError('firstname', 'Veuillez saisir votre prénom.');
                    $error = true;
                }
                if (empty($_POST['lastname'])) {
                    $form->addError('lastname', 'Veuillez saisir votre nom.');
                    $error = true;
                }
                if (empty($_POST['pseudo'])) {
                    $form->addError('pseudo', 'Veuillez saisir votre pseudo.');
                    $error = true;
                }
                if (empty($email)) {
                    $form->addError('email', 'Veuillez saisir votre email.');
                    $error = true;
                } elseif ($user->existsWithEmail($email)) {
                    $form->addError('email', 'Cet e-mail est déjà utilisé. Veuillez en choisir un autre.');
                    $error = true;
                }
                if (empty($_POST['password'])) {
                    $form->addError('password', 'Veuillez saisir votre mot de passe.');
                    $error = true;
                }

                $fields = array(
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'pseudo' => $_POST['pseudo'],
                    'email' => $_POST['email'],
                    'country' => $_POST['country'],
                    'role' => $_POST['role']
                );

                $invalidFields = $user->checkSpecialCharacters($fields);
                foreach ($invalidFields as $field) {
                    $form->addError($field, 'Le champ ' . $field . ' contient des caractères spéciaux non autorisés.');
                    $error = true;
                }

                $view->assign('form', $form->getConfig($_POST));

                if (!$error) {
                    $user->saveUser($_POST['firstname'], $_POST['lastname'], $_POST['pseudo'], $email, $_POST['password'], $_POST['country'], $_POST['role'], $formattedDate, $formattedDate);
                    header('Location: user?action=created&entity=utilisateur');
                    exit;
                }
            }
        } else {
            http_response_code(404);
            include('./Views/Error/404.view.php');
            exit;
        }
    }
}