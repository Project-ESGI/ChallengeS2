<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddArticle;
use App\Models\Article;

   session_start();
    if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $id = $_GET['id'];
            $page = new Article();
            $page->setId($id);
            $page->getById($id);

            if ($page->getId()) {
                $page->delete();
                header('Location: article?action=deleted&entity=article'
                exit;
            }
        } else {
    http_response_code(404);
    include('./Views/Error/404.view.php');
    exit;

    }

    function deleteComment()
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $id = $_GET['id'];
            $commentaire = new Commentaire();
            $commentaire->setId($id);
            $commentaire->getById($id);
            $signalement = new Signalement();
            $signalement->setCommentId($commentaire->getId());
            $signalement->setUserId($_SESSION['id']);

            if ($commentaire->getId()) {
                $signalement->deleteByCommentId($commentaire->getId());
                $commentaire->delete();
                header('Location: comment?action=deleted&entity=commentaire');
                exit;
            }
        } else {
            http_response_code(404);
            include('./Views/Error/404.view.php');
            exit;
        }
    }

    function deleteUser()
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $id = $_GET['id'];
            $user = new User();
            $user->setId($id);
            $user->getById($id);

            if ($user->getId()) {
                $user->delete();
                header('Location: user?action=deleted');
                exit;
            } else {
                echo "Le user supprimé n'existe pas.";
            }

        }  else {
            http_response_code(404);
            include('./Views/Error/404.view.php');
            exit;
        }


}