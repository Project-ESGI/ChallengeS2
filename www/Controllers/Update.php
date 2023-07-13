<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddArticle;
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
        $id = $_GET['id'];
        $user = new User();
        $user->setIdValue($id);
        $date = new \DateTime();
        $result = $user->getById($id);

        $formattedDate = $date->format('Y-m-d');
        $view = new View("Auth/addUser", "user");
        $form = new addUser();
        $view->assign('form', $form->getConfig($result));

        // Vérifier si le user existe
        if ($user !== null) {
            if ($form->isSubmit()) {
                if (empty($_POST['user_firstname'])) {
                    echo 'Le user doit avoir un prénom';
                } else {
                    $firstname = $_POST['user_firstname'];

                    if ($user->existsWithFirstname($firstname, $user->getId())) {
                        echo 'Un user avec ce firstname existe déjà';
                    } else {
                        $user->setTitle($firstname);
                        $user->setDateInserted($user->getDateInserted());
                        $user->setDateUpdated($formattedDate);

                        $user->save();
                        header('Location: article?action=updated');
                        exit;

                    }
                }
            }
        } else {
            echo "Le user à modifier n'existe pas.";
        }
    }

}