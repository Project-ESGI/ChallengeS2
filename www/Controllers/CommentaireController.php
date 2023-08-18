<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\Verificator;
use App\Core\View;
use App\Models\Comment;
use App\Models\Signalement;
use App\Models\User;
use App\Forms\AddComment;

date_default_timezone_set('Europe/Paris');

class CommentaireController extends AuthorizationHelper
{

    public function addComment()
    {
        $commentaire = new Comment();
        $formData = $_POST;
        $view = new View("Auth/addComment", "comment");
        AuthorizationHelper::modifyCommon($commentaire, null, new AddComment(), $formData, $view, null);
    }

    public function modifyComment()
    {
        $id = $_GET['id'];
        $commentaire = new Comment();
        $commentData = $commentaire->getById($id);

        if (!$commentData || $commentData['author'] !== $_SESSION['id']) {
            AuthorizationHelper::redirectTo404();
        } else {
            $formData = $_POST;
            $view = new View("Auth/addComment", "comment");
            AuthorizationHelper::modifyCommon($commentaire, $id, new AddComment(), $formData, $view, 1);
        }
    }

    public function deleteComment()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $id = $_GET['id'];
            $commentaire = new Comment();
            $commentaire->setId($id);

            $commentData = $commentaire->getById($id);
            if (!$commentData || $commentData['author'] !== $_SESSION['id']) {
                AuthorizationHelper::redirectTo404();
            }

            $signalement = new Signalement();
            $signalement->setCommentId($commentaire->getId());
            $signalement->setUserId($_SESSION['id']);

            if ($commentaire->getId()) {
                $signalement->deleteByCommentId($commentaire->getId());
                $commentaire->delete();

                if (isset($_GET['accueil'])) {
                    header('Location: accueil?action=delete&entity=commentaire');
                } else {
                    header('Location: comment?action=delete&entity=commentaire');
                }
                exit;
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    public function commentaire()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
            $user_role = $userData['role'];
            $user_id = $userData['id'];
            $_SESSION['pseudo'] = $user_pseudo;
            $_SESSION['role'] = $user_role;
            $_SESSION['id'] = $user_id;

            $commentaire = new Comment();
            $signalement = new Signalement();
            $commentaires = $commentaire->getAllValue();
            $table = [];

            foreach ($commentaires as $com) {
                $userId = $com['author'];
                $userData = $user->getById($userId);
                $signalement->setCommentId($com['id']);
                $signalement->setUserId($user_id);

                $table[] = [
                    'id' => $com['id'],
                    'content' => $com['content'],
                    'author' => $userData['lastname'] . ' ' . $userData['firstname'] . ' (' . $userData['pseudo'] . ')',
                    'date_inserted' => strftime('%e %B %Y à %H:%M:%S', strtotime($com['date_inserted'])),
                    'date_updated' => strftime('%e %B %Y à %H:%M:%S', strtotime($com['date_updated'])),
                    'is_reported' => $com['report']
                ];
            }

            $view = new View("Auth/comment", "comment");
            $view->assign('table', $table);
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    public function report()
    {
        $id = $_GET['id'];
        $comment = new Comment();
        $comment->setIdValueString($id);
        $report = $comment->getReport() + 1;

        if ($comment->getId()) {
            $signalement = new Signalement();
            $signalement->setCommentId($comment->getId());
            $signalement->setUserId($_SESSION['id']);

            if (!$signalement->existeSignalement()) {
                $signalement->setDateInserted(date('Y-m-d H:i:s'));
                $signalement->save();
                $comment->setReport($report);
                $comment->save();
            } else {
                header('Location: accueil?action=existreported');
                exit;
            }
            if ($comment->reportTrue($comment->getContent()) || $comment->getReport() >= 4) {
                $signalement->deleteByCommentId($comment->getId());
                $comment->delete();
            }
            header('Location: accueil');
            exit;
        }
    }
}

