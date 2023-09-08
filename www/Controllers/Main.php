<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\ResetPassword;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Signalement;
use App\Models\User;

date_default_timezone_set('Europe/Paris');

class Main extends AuthorizationHelper
{
    public function index()
    {
        $user = new User();
        $userData = $user->getByEmail($_SESSION['email']);
        $user_name = $userData['firstname'] . ' ' . $userData['lastname'];
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
            $commentaireSignale = false;

            if ($signalement->existeSignalement()) {
                $commentaireSignale = true;
            }

            $table[] = [
                'id' => $com['id'],
                'content' => $com['content'],
                'author' => $userData['pseudo'],
                'authorId' => $com['author'],
                'date_inserted' => strftime('%e %B %Y à %H:%M:%S', strtotime($com['date_inserted'])),
                'date_updated' => strftime('%e %B %Y à %H:%M:%S', strtotime($com['date_updated'])),
                'is_reported' => $commentaireSignale
            ];
        }

        $view = new View("Auth/accueil", "dashboard");
        $view->assign('table', $table);
        $view->assign('user_pseudo', $user_pseudo);
        $view->assign('user_name', $user_name);
        $view->assign('user_role', $user_role);
        $view->assign('user_id', $user_id);
    }

    public function show()
    {
        $article = new Article();
        $currentURL = $_SERVER['REQUEST_URI'];
        $slug = basename($currentURL);
        $articleData = $article->getBySlug($slug, $_SESSION['id']);

        $view = new View("Auth/articleNew", "nouveauArticle");
        $view->assign('articleData', $articleData);
    }

    public function reset(): void
    {
        $form = new ResetPassword();
        $view = new View("Auth/reinitialisation", "reset");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $user = new User();
            $user->setEmail($_POST['email']);
            $userExists = $user->existUser($user->getEmail());
            if ($userExists) {
//                $mail = new PHPMailer(true);
                $_SESSION['email'] = $user->getEmail();
                header('Location: accueil');
                exit;
            } else {
                $form->addError('email', 'Email ou mot de passe incorrect!');
                $view->assign('form', $form->getConfig());
            }
        }
    }

    public function tempo(): void
    {
        $form = new ResetPassword();
        $view = new View("Auth/tempopassword", "tempo");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $user = new User();
            $user->setEmail($_POST['email']);
            $userExists = $user->existUser($user->getEmail());
            if ($userExists) {
//                $mail = new PHPMailer(true);
                $_SESSION['email'] = $user->getEmail();
                header('Location: accueil');
                exit;
            } else {
                $form->addError('email', 'Email ou mot de passe incorrect!');
                $view->assign('form', $form->getConfig());
            }
        }
    }
}