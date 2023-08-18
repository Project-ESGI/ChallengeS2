<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddArticle;
use App\Models\Article;

class ArticleController extends AuthorizationHelper
{
    public function addArticle(): void
    {
        $article = new Article();
        $formData = $_POST;
        $view = new View("Auth/addArticle", "article");
        CrudHelper::addOrEdit($article, null, new AddArticle(), $formData, $view, 0);
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
            CrudHelper::addOrEdit($article, $id, new AddArticle(), $formData, $view, 1);
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
        $article = new Article();
        $view = new View("Auth/article", "article");
        CrudHelper::getList($article,$view);
    }
}