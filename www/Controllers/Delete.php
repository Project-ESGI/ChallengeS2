<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Models\Article;
use App\Models\Commentaire;
use App\Models\Signalement;
use App\Models\User;

class Delete
{

    function deleteArticle()
    {
        if (AuthorizationHelper::hasPermission()) {
            $id = $_GET['id'];
            $page = new Article();
            $page->setId($id);
            $page->getById($id);

            if ($page->getId()) {
                $page->delete();
                header('Location: article?action=deleted&entity=article');
                exit;
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    function deleteComment()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
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
            AuthorizationHelper::redirectTo404();
        }
    }

    function deleteUser()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $id = $_GET['id'];
            $user = new User();
            $user->setId($id);
            $user->getById($id);

            $commentaire = new Commentaire();
            $commentaire->setAuthorId($user->getId());

            $signalement = new Signalement();
            $signalement->deleteByCommentAuthor($user->getId());
            $signalement->deleteByUserId($user->getId()); // Supprime les signalements associés à l'utilisateur

            $article = new Article();
            $article->deleteByAuthor($user->getId());

            if ($user->getId()) {
                $commentaire->deleteByAuthor($user->getId()); // Supprime les commentaires associés à l'auteur

                if($user->getId() === $_SESSION['id']){
                    header('Location: logout');
                } else {
                    header('Location: user?action=deleted&entity=utilisateur');
                }
                $user->delete(); // Supprime l'utilisateur
                exit;
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }
}