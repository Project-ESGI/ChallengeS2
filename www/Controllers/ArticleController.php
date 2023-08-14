<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\Verificator;
use App\Core\View;
use App\Forms\AddArticle;
use App\Models\Article;
use App\Models\User;

date_default_timezone_set('Europe/Paris');

class ArticleController extends AuthorizationHelper
{
    /**
     * @Route("/article", name="article")
     * @Security("is_granted('ROLE_ADMIN')")
     */
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

    public function addArticle(): void
    {
        $userData = AuthorizationHelper::getCurrentUserData();
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
//                    header('Location: article?action=created&entity=article');
                $newUrl = "article/" . $_POST['slug'];
                header("Location: " . $newUrl);
                exit;
            } else {
                exit;
            }
        }
    }

    function deleteArticle()
    {
        $id = $_GET['id'];
        $page = new Article();
        $page->getById($id);

        if ($page->getId()) {
            $page->delete();
            header('Location: article?action=deleted&entity=article');
            exit;
        }
    }

    public function modifyArticle()
    {
        $userData = AuthorizationHelper::getCurrentUserData();
        $user_pseudo = $userData['pseudo'];
        $user_role = $userData['role'];

        $id = $_GET['id'];
        $page = new Article();
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
    }
}

