<?php

namespace App\Controllers;

use App\Core\Mail;
use App\Core\Verificator;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

date_default_timezone_set('Europe/Paris');

class CrudHelper
{
    public function __construct()
    {
    }

    public static function addOrEdit($object, $id, $form, $formData, $view, $edit)
    {
        $userData = AuthorizationHelper::getCurrentUserData();
        $user_pseudo = $userData['pseudo'];
        $user_role = $userData['role'];

        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d H:i:s');
        $result = $object->getById($id);

        $view->assign('form', $form->getConfig($result, $edit));
        $view->assign('user_pseudo', $user_pseudo);
        $view->assign('user_role', $user_role);

        if ($form->isSubmit()) {
            $error = Verificator::form($form->getConfig(), $formData);

            foreach ($_POST as $key => $value) {
                $_POST[$key] = htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
            }

            foreach ($error as $e => $data) {
                $form->addError($e, $data);
            }
            $view->assign('form', $form->getConfig($formData, $edit));

            if (!$error) {
                $classNameParts = explode('\\', get_class($object));
                $className = end($classNameParts);
                $addFormatedDate = null;
                $existPasswd = null;

                if ($edit !== 1) {
                    $action = "add";
                    $addFormatedDate = $formattedDate;
                    $existPasswd = $_POST['password'];
                } else {
                    $action = "edit";
                }

                if ($className === 'Article') {
                    $object->actionArticle(
                        $id,
                        $_POST['title'],
                        trim($_POST['slug']),
                        $_POST['content'],
                        $_POST['category'],
                        $_SESSION['id'],
                        $addFormatedDate,
                        $formattedDate);
                    $newUrl = "article/" . $_POST['slug'];
                    header("Location: " . $newUrl);
                } elseif ($className === 'Comment') {
                    $object->saveCommentaire(
                        $id,
                        $_POST['content'],
                        $_SESSION['id'],
                        $addFormatedDate,
                        $formattedDate
                    );
                    header('Location: accueil?action=' . $action . '&entity=commentaire');
                } elseif ($className === 'User') {
                    $object->saveUser(
                        $id,
                        $_POST['firstname'],
                        $_POST['lastname'],
                        $_POST['pseudo'],
                        $_POST['email'],
                        $existPasswd,
                        $_POST['country'],
                        $_POST['role'],
                        $addFormatedDate,
                        $formattedDate
                    );
                    if ($edit === 1) {
                        if ($object->getId() === $_SESSION['id'] && $object->getEmail() !== $_SESSION['email']) {
                            header('Location: logout');
                        }
                    } elseif ($edit !== 1) {
                        $mailSubject = "Inscription via administrateur";
                        $mailDescription = "Cher utilisateur,\n\nNous sommes ravis de vous compter parmi nous ! Votre inscription a été confirmée avec succès.\n\nUn administrateur réseau a créé votre compte avec l'adresse mail : " . $_POST['email'] . ".\n\nMerci de faire partie de notre communauté. Vous pouvez maintenant accéder à toutes les fonctionnalités de notre site et profiter de nos services.\n\nSi vous avez des questions ou avez besoin d'aide, n'hésitez pas à nous contacter. Nous sommes toujours là pour vous aider.\n\nEncore une fois, bienvenue !\n\nCordialement,\nL'équipe de UFC Sport";
                        $mail = new Mail($_POST['email'], $mailSubject, $mailDescription);
                        $mail->sendEmail();
                    }
                    header('Location: user?action=' . $action . '&entity=utilisateur');
                }
                exit;
            }
        }
    }

    public static function getList($object, $view, $object2 = null)
    {
        $user = new User();
        $userData = $user->getByEmail($_SESSION['email']);
        $user_pseudo = $userData['pseudo'];
        $user_role = $userData['role'];
        $user_id = $userData['id'];

        $data = $object->getAllValue();
        if (($object instanceof Article)) {
            $data = $object->getAllValueByUser($_SESSION['id']);
        }
        $table = [];

        foreach ($data as $item) {

            $commonAttributes = [
                'id' => $item['id'],
            ];

            if ($object instanceof Comment) {
                $itemData = $user->getById($item['author']);
                $object2->setCommentId($item['id']);
                $object2->setUserId($user_id);
                $specificAttributes = [
                    'content' => $item['content'],
                    'author' => $itemData['lastname'] . ' ' . $itemData['firstname'] . ' (' . $itemData['pseudo'] . ')',
                    'date_inserted' => strftime('%e %B %Y à %H:%M:%S', strtotime($item['date_inserted'])),
                    'date_updated' => strftime('%e %B %Y à %H:%M:%S', strtotime($item['date_updated'])),
                    'is_reported' => $item['report']
                ];
            } elseif ($object instanceof User) {
                $specificAttributes = [
                    'firstname' => $item['firstname'],
                    'lastname' => $item['lastname'],
                    'email' => $item['email'],
                    'date_inserted' => $item['date_inserted'],
                    'date_updated' => $item['date_updated'],
                    'country' => $item['country'],
                    'password' => $item['password'],
                    'role' => $item['role'],
                    'pseudo' => $item['pseudo']
                ];
            } elseif ($object instanceof Article) {
                $itemData = $user->getById($item['author']);
                $specificAttributes = [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'content' => $item['content'],
                    'author' => $itemData['lastname'] . ' ' . $itemData['firstname'] . ' (' . $itemData['pseudo'] . ')',
                    'category' => $item['category'],
                    'date_inserted' => $item['date_inserted'],
                    'date_updated' => $item['date_updated']
                ];
            }
            $table[] = array_merge($commonAttributes, $specificAttributes);
        }
        $view->assign('table', $table);
        $view->assign('user_pseudo', $user_pseudo);
        $view->assign('user_role', $user_role);
    }
}

