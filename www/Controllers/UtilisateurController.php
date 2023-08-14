<?php

namespace App\Controllers;

use App\Core\Mail;
use App\Core\Menu;
use App\Core\Verificator;
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
        $userData = $user->getByEmail($_SESSION['email']);
        $user_pseudo = $userData['pseudo'];
        $user_role = $userData['role'];

        $form = new AddUser();
        $view = new View("Auth/addUser", "user");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d H:i:s');
        $view->assign('form', $form->getConfig());
        $view->assign('user_pseudo', $user_pseudo);
        $view->assign('user_role', $user_role);

        if ($form->isSubmit()) {

            $error = Verificator::form($form->getConfig(), $_POST);

            foreach ($error as $e => $data) {
                $form->addError($e, $data);
            }

            $view->assign('form', $form->getConfig($_POST));

            if (!$error) {


                $mailDescription = "Inscription via administrateur";

                $mailSubject = "Cher utilisateur,\n\nNous sommes ravis de vous compter parmi nous ! Votre inscription a été confirmée avec succès.\n\nUn administrateur réseau a créé votre compte avec l'adresse mail : " . $_POST['email'] . ".\n\nMerci de faire partie de notre communauté. Vous pouvez maintenant accéder à toutes les fonctionnalités de notre site et profiter de nos services.\n\nSi vous avez des questions ou avez besoin d'aide, n'hésitez pas à nous contacter. Nous sommes toujours là pour vous aider.\n\nEncore une fois, bienvenue !\n\nCordialement,\nL'équipe de UFC Sport";
                $mail = new Mail($_POST['email'], $mailSubject, $mailDescription);
                $mail->sendEmail();
                $user->saveUser(null, $_POST['firstname'], $_POST['lastname'], $_POST['pseudo'], $_POST['email'], $_POST['password'], $_POST['country'], $_POST['role'], $formattedDate, $formattedDate);
                header('Location: user?action=created&entity=utilisateur');
                exit;
            }
        }
    }

    public function modifyUser()
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $userData = AuthorizationHelper::getCurrentUserData();
            $user_pseudo = $userData['pseudo'];
            $user_role = $userData['role'];

            $id = $_GET['id'];
            $user = new User();
            $user->setIdValue($id);
            $date = new \DateTime();
            $result = $user->getById($id);

            $formattedDate = $date->format('Y-m-d H:i:s');
            $view = new View("Auth/addUser", "user");
            $form = new AddUser();
            $view->assign('form', $form->getConfig($result, 1));
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);

            // Vérifier si le user existe
            if ($user !== null) {
                if ($form->isSubmit()) {
                    $error = Verificator::form($form->getConfig(), $_POST);

                    foreach ($error as $e => $data) {
                        $form->addError($e, $data);
                    }

                    $view->assign('form', $form->getConfig($_POST, 1));

                    if (!$error) {
                        $user->saveUser(
                            $id,
                            $_POST['firstname'],
                            $_POST['lastname'],
                            $_POST['pseudo'],
                            $_POST['email'],
                            null,
                            $_POST['country'],
                            $_POST['role'],
                            null,
                            $formattedDate
                        );
                        if ($user->getId() === $_SESSION['id'] && $user->getEmail() !== $_SESSION['email']) {
                            header('Location: logout');
                        } else {
                            header('Location: user?action=updated&entity=utilisateur');
                        }
                        exit;
                    } else {
                        exit;
                    }
                }
            }
        } else {
            AuthorizationHelper::redirectTo404();
        }
    }

    public function user(): void
    {
        if (AuthorizationHelper::hasPermission('admin')) {
            $user = new User();
            $userData = $user->getByEmail($_SESSION['email']);
            $user_pseudo = $userData['pseudo'];
            $user_role = $userData['role'];
            $user = new User();
            $users = $user->getAllValue();
            $table = [];

            foreach ($users as $user) {
                $table[] = [
                    'id' => $user['id'],
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname'],
                    'email' => $user['email'],
                    'date_inserted' => $user['date_inserted'],
                    'date_updated' => $user['date_updated'],
                    'country' => $user['country'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                    'pseudo' => $user['pseudo']
                ];
            }
            $view = new View("Auth/user", "user");
            $view->assign('table', $table);
            $view->assign('user_pseudo', $user_pseudo);
            $view->assign('user_role', $user_role);
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

            $commentaire = new Comment();
            $commentaire->setAuthorId($user->getId());

            $signalement = new Signalement();
            $signalement->deleteByCommentAuthor($user->getId());
            $signalement->deleteByUserId($user->getId()); // Supprime les signalements associés à l'utilisateur

            $article = new Article();
            $article->deleteByAuthor($user->getId());

            if ($user->getId()) {
                $commentaire->deleteByAuthor($user->getId()); // Supprime les commentaires associés à l'auteur

                if ($user->getId() === $_SESSION['id']) {
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

