<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Models\Commentaire;
use App\Models\Signalement;
use App\Models\User;

date_default_timezone_set('Europe/Paris');

class Main
{
    public function index()
    {
        session_start();
        if (isset($_SESSION['user_email'])) {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['user_email']);
            $user_pseudo = $userData['firstname'] . ' ' . $userData['lastname'];
            $user_role = $userData['role'];
            $user_id = $userData['id'];
            $_SESSION['pseudo'] = $user_pseudo;
            $_SESSION['role'] = $user_role;
            $_SESSION['id'] = $user_id;

            $commentaire = new Commentaire();
            $commentaires = $commentaire->getAllValue();
            $table = [];

            foreach ($commentaires as $com) {
                $userId = $com['author'];
                $userData = $user->getById($userId);

                $table[] = [
                    'id' => $com['id'],
                    'content' => $com['content'],
                    'author' => $userData['lastname'] . ' ' . $userData['firstname'],
                    'answer' => $com['answer'],
                    'date_inserted' => $com['date_inserted'],
                    'date_updated' => $com['date_updated']
                ];
            }

            $view = new View("Auth/accueil", "dashboard");
            $view->assign('table', $table);
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);
        } else {
            http_response_code(404);
            include('./Views/Error/404.view.php');
            exit;
        }
    }

    public function installer()
    {
        $view = new View("Auth/installer", "installer");
    }

    public function report()
    {
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'admin') {
            $id = $_GET['id'];
            $comment = new Commentaire();
            $comment->setIdValue($id);
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
                header('Location: accueil?action=reported');
                exit;

            } else {
                http_response_code(404);
                include('./Views/Error/404.view.php');
                exit;
            }
        }
    }

}