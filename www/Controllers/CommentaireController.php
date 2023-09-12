<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Models\Comment;
use App\Models\Signalement;
use App\Forms\AddComment;

class CommentaireController extends AuthorizationHelper
{

    public function addComment()
    {
        $commentaire = new Comment();
        $formData = $_POST;
        $view = new View("Auth/addComment", "comment");
        CrudHelper::addOrEdit($commentaire, null, new AddComment(), $formData, $view, null);
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
            CrudHelper::addOrEdit($commentaire, $id, new AddComment(), $formData, $view, 1);
        }
    }

    public function deleteComment()
    {
        $id = $_GET['id'];
        $commentaire = new Comment();
        $commentData = $commentaire->getById($id);
        if (AuthorizationHelper::hasPermission('admin') || $commentData['author'] !== $_SESSION['id']) {
            $commentaire->setId($id);

            $signalement = new Signalement();
            $signalement->setCommentId($commentaire->getId());
            $signalement->setUserId($_SESSION['id']);

            if ($commentaire->getId()) {
                $signalement->deleteByCommentId($commentaire->getId());
                $commentaire->delete();

                if (isset($_GET['/'])) {
                    $location = "/";
                } else {
                    $location = "comment";
                }
                header('Location: ' . $location . '?action=delete&entity=commentaire');
                exit;
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    public function commentaire()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $commentaire = new Comment();
            $signalement = new Signalement();
            $view = new View("Auth/comment", "comment");
            CrudHelper::getList($commentaire, $view, $signalement);
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
                header('Location: /?action=existreported');
                exit;
            }
            if ($comment->reportTrue($comment->getContent()) || $comment->getReport() >= 4) {
                $signalement->deleteByCommentId($comment->getId());
                $comment->delete();
            }
            header('Location: /');
            exit;
        }
    }
}

