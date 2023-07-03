<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddArticle;
use App\Models\Article;
use App\Models\User;

class Delete
{

    function deleteArticle()
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['user_email']);
            $user_pseudo = $userData['firstname'] . ' ' . $userData['lastname'];
            $user_role = $userData['role'];

            $id = $_GET['id'];
            $page = new Article();
            $page->setId($id);
            $page->getById($id);
            $view = new View("Main/header", "dashboard");
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

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
}