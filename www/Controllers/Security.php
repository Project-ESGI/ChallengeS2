<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\AddUser;
use App\Forms\ConnectionUser;
use App\Models\Users;
use App\Core\Verificator;

class Security
{

    public function login(): void
    {
        $form = new ConnectionUser();
        $view = new View("Auth/connection", "front");
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            $errors = Verificator::formConnection($form->getConfig(), $_POST);
            if (empty($errors)) {
                $user = new Users();
                $user->setEmail($_POST['user_email']);
                $user->setPassword($_POST['user_password']);
                $user->save();
                echo "Connecter";
            } else {
                $view->assign('errors', $errors);
            }
        }
    }

    public function register(): void
    {
        $form = new AddUser();
        $view = new View("Auth/register", "connection");
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            $errors = Verificator::formRegister($form->getConfig(), $_POST);
            if (empty($errors)) {
                $user = new Users();
                $user->setFirstname($_POST['user_firstname']);
                $user->setLastname($_POST['user_lastname']);
                $user->setEmail($_POST['user_email']);
                $user->setPassword($_POST['user_password']);
                $user->save();
                echo "Insertion en BDD";
            } else {
                $view->assign('errors', $errors);
            }
        }
    }

    public function logout(): void
    {
        echo "Logout";
    }
}