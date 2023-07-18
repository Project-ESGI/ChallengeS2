<?php

namespace App\Controllers;

use App\Core\Menu;
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
                    $error = false;
                    $title = $_POST['title'];

                    if (empty($title)) {
                        $form->addError('title', 'Veuillez saisir un titre.');
                        $error = true;
                    } elseif ($page->existsWith($title)) {
                        $form->addError('title', 'Un article avec ce titre existe déjà.');
                        $error = true;
                    }
                    if (empty($_POST['content'])) {
                        $form->addError('content', 'Veuillez saisir votre contenu.');
                        $error = true;
                    }
                    $view->assign('form', $form->getConfig($_POST));

                    if (!$error) {
                        $page->actionArticle($title, $_POST['content'], $_POST['category'], null, null, $formattedDate);
                        header('Location: article?action=updated&entity=article');
                        exit;
                    } else {
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
                    $error = false;
                    $email = $_POST['email'];
                    foreach ($_POST as $key => $value) {
                        var_dump($value);
                        $_POST[$key] = trim($value);
                    }
                    if (strlen($_POST['firstname']) < 3) {
                        $form->addError('firstname', 'Veuillez saisir un prénom valide.');
                        $error = true;
                    }
                    if (strlen($_POST['lastname']) < 3) {
                        $form->addError('lastname', 'Veuillez saisir un nom valide.');
                        $error = true;
                    }
                    if (strlen($_POST['pseudo']) < 3) {
                        $form->addError('pseudo', 'Veuillez saisir un pseudo valide.');
                        $error = true;
                    }
                    if (strlen($_POST['firstname']) < 5 || strpos($email, '@') === false) {
                        $form->addError('email', 'Veuillez saisir un email valide.');
                        $error = true;
                    } elseif ($user->existsWithEmail($email, $user->getId())) {
                        $form->addError('email', 'Cet e-mail est déjà utilisé. Veuillez en choisir un autre.');
                        $error = true;
                    }

                    $fields = array(
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'],
                        'pseudo' => $_POST['pseudo'],
                        'email' => $email,
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
                        $user->saveUser(
                            $_POST['firstname'],
                            $_POST['lastname'],
                            $_POST['pseudo'],
                            $email,
                            null,
                            $_POST['country'],
                            $_POST['role'],
                            null,
                            $formattedDate
                        );
                        header('Location: user?action=updated&entity=utilisateur');
                        exit;
                    } else {
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

    public function modifyComment()
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
            $view = new View("Auth/addComment", "comment");
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
}