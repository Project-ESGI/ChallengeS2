<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddUser;
use App\Models\Article;
use App\Models\Signalement;
use App\Models\User;
use App\Models\Comment;

date_default_timezone_set('Europe/Paris');

class UtilisateurController extends AuthorizationHelper
{
    public function addUser(): void
    {
        $user = new User();
        $formData = $_POST;
        $view = new View("Auth/addUser", "user");
        CrudHelper::addOrEdit($user, null, new AddUser(), $formData, $view, null);
    }

    public function modifyUser()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $id = $_GET['id'];
            $user = new User();
            $formData = $_POST;
            $view = new View("Auth/addUser", "user");
            CrudHelper::addOrEdit($user, $id, new AddUser(), $formData, $view, 1);
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    public function deleteUser()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $id = $_GET['id'];
            $user = new User();
            $user->setId($id);
            $user->getById($id);

            $commentaire = new Comment();
            $commentaire->setAuthorId($user->getId());

            $signalement = new Signalement();
            $signalement->deleteByCommentAuthor($user->getId());
            $signalement->deleteByUserId($user->getId());

            $article = new Article();
            $article->deleteByAuthor($user->getId());

            if ($user->getId()) {
                $commentaire->deleteByAuthor($user->getId());

                if ($user->getId() === $_SESSION['id']) {
                    header('Location: logout');
                } else {
                    header('Location: user?action=delete&entity=utilisateur');
                }
                $user->delete();
                exit;
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    public function user(): void
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $user = new User();
            $view = new View("Auth/user", "user");
            CrudHelper::getList($user,$view);

        } else {
            AuthorizationHelper::redirectTo404();
        }
    }
}

