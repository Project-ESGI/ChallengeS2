<?php

namespace App\Controllers;

use App\Core\Mail;
use App\Core\Verificator;
use App\Core\View;
use App\Forms\ConnectionUser;
use App\Forms\Registration;
use App\Models\User;

date_default_timezone_set('Europe/Paris');

class Security
{

    public function login(): void
    {
        $form = new ConnectionUser();
        $view = new View("Auth/connection", "connection");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $userExists = $user->existUser($user->getEmail(), $_POST['password']);
            if ($userExists) {
                $ip = $_SERVER['REMOTE_ADDR'];
                $mailDescription = "Connexion récente sur votre compte avec l'Adresse IP : $ip";
                $mailSubject = "Connexion UFC Sport";
                $mail = new Mail($_POST['email'], $mailSubject, $mailDescription);
                $mail->sendEmail();
                $_SESSION['email'] = $user->getEmail();
                header('Location: accueil');
                exit;
            } else {
                $form->addError('email', 'Email ou mot de passe incorrect!');
                $form->addError('password', 'Email ou mot de passe incorrect!');
                $view->assign('form', $form->getConfig());
            }
        }
    }

    public function register(): void
    {
        $form = new Registration();
        $view = new View("Auth/register", "inscription");
        $view->assign('form', $form->getConfig());

        if ($form->isSubmit()) {
            $user = new User();
            $date = new \DateTime();
            $formattedDate = $date->format('Y-m-d');

            $error = Verificator::form($form->getConfig(), $_POST);

            foreach ($error as $e => $data) {
                $form->addError($e, $data);
            }

            $view->assign('form', $form->getConfig($_POST));
            if (!$error) {
                $user->saveUser(null, $_POST['firstname'], $_POST['lastname'], $_POST['pseudo'], $_POST['email'], $_POST['password'], $_POST['country'], 'user', $formattedDate, $formattedDate);
                $_SESSION['email'] = $_POST['email'];

                $mailDescription = "Cher utilisateur,\n\nNous sommes ravis de vous compter parmi nous ! Votre inscription a été confirmée avec succès.\n\nMerci de faire partie de notre communauté. Vous pouvez maintenant accéder à toutes les fonctionnalités de notre site et profiter de nos services.\n\nSi vous avez des questions ou avez besoin d'aide, n'hésitez pas à nous contacter. Nous sommes toujours là pour vous aider.\n\nEncore une fois, bienvenue !\n\nCordialement,\nL'équipe de ufc sport";

                $mail = new Mail($_POST['email'], "Inscription réussie", $mailDescription);
                $mail->sendEmail();
                header('Location: accueil');
            }
            exit;
        }
    }

    public function logout(): void
    {
        session_unset(); // Supprime toutes les variables de session
        session_destroy(); // Détruit la session
        header('Location: /login');
        exit;
    }

    public function installer()
    {
        new View("Auth/installer", "installer1");
    }

    public function setupapi()
    {
        new View("Auth/installer", "installer2");
    }

    public function site()
    {
        new View("Auth/installer", "installer3");
    }
}