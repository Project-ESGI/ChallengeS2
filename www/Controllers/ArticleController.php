<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddArticle;
use App\Models\Article;
use App\Models\User;

date_default_timezone_set('Europe/Paris');

class ArticleController extends AuthorizationHelper
{
    public function addArticle(): void
    {
        $article = new Article();
        $formData = $_POST;
        $view = new View("Auth/addArticle", "article");
        AuthorizationHelper::modifyCommon($article, null, new AddArticle(), $formData, $view, 0);
    }

    public function modifyArticle()
    {
        $id = $_GET['id'];
        $article = new Article();
        $articleData = $article->getById($id);
        if (!$articleData || $articleData['author'] !== $_SESSION['id']) {
            AuthorizationHelper::redirectTo404();
        } else {
            $formData = $_POST;
            $view = new View("Auth/addArticle", "article");
            AuthorizationHelper::modifyCommon($article, $id, new AddArticle(), $formData, $view, 1);
        }
    }

    public function deleteArticle()
    {
        $id = $_GET['id'];
        $page = new Article();
        $page->setId($id);

        $articleData = $page->getById($id);
        if (!$articleData || $articleData['author'] !== $_SESSION['id']) {
            AuthorizationHelper::redirectTo404();
        }

        if ($page->getId()) {
            $page->delete();
            header('Location: article?action=delete&entity=article');
            exit;
        }
    }

    public function article(): void
    {
        $user = new User();
        $userData = AuthorizationHelper::getCurrentUserData();
        $user_pseudo = $userData['pseudo'];
        $user_role = $userData['role'];

        $page = new Article();
        $pages = $page->getAllValueByUser($_SESSION['id']);
        $table = [];

        foreach ($pages as $page) {
            $userId = $page['author'];
            $userData = $user->getById($userId);

            $table[] = [
                'id' => $page['id'],
                'title' => $page['title'],
                'slug' => $page['slug'],
                'content' => $page['content'],
                'author' => $userData['lastname'] . ' ' . $userData['firstname'] . ' (' . $userData['pseudo'] . ')',
                'category' => $page['category'],
                'date_inserted' => $page['date_inserted'],
                'date_updated' => $page['date_updated']
            ];
        }

        $view = new View("Auth/article", "article");
        $view->assign('table', $table);
        $view->assign('user_pseudo', $user_pseudo);
        $view->assign('user_role', $user_role);
    }
}