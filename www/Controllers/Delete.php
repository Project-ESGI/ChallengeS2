<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddArticle;
use App\Models\Article;
use App\Forms\AddUser;
use App\Models\User;

class Delete
{

    function deleteArticle()
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $id = $_GET['id'];
            $page = new Article();
            $page->setId($id);
            $page->getById($id);

            if ($page->getId()) {
                $page->delete();
                header('Location: article?action=deleted');
                exit;
            } else {
                echo "L'article à supprimer n'existe pas.";
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

}