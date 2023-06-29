<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\AddUser;
use App\Forms\ConnectionUser;
use App\Models\Article;
use App\Models\User;

class Security
{

    public function login(): void
    {
        $form = new ConnectionUser();
        $view = new View("Auth/connection", "front");
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            // $errors = Verificator::formConnection($form->getConfig(), $_POST);
            $user = new User();
            $user->setEmail($_POST['user_email']);
            $user->setPassword($_POST['user_password']);
            $user->save();
            echo "Connecter";
        }
    }

    public function register(): void
    {
        $form = new AddUser();
        $view = new View("Auth/register", "connection");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            // $errors = Verificator::formRegister($form->getConfig(), $_POST);
            $user = new User();
            $user->setFirstname($_POST['user_firstname']);
            $user->setLastname($_POST['user_lastname']);
            $user->setEmail($_POST['user_email']);
            $user->setPassword($_POST['user_password']);
            $user->setDateInserted($formattedDate);
            $user->setDateUpdated($formattedDate);
            $user->save();
            echo "Insertion en BDD";
        }
    }

    public function page(): void
    {
        $page = new Article();
        $pages = $page->getAllValue();
        $table = [];
        $user = new User();


        foreach ($pages as $page) {
            $userId = $page['author'];
            $userData = $user->getById($userId);

            $table[] = [
                'id' => $page['id'],
                'title' => $page['title'],
                'content' => $page['content'],
                'author' => $userData['lastname'].' '.$userData['firstname'],
                'category' => $page['category'],
                'date_inserted' => $page['date_inserted'],
                'date_updated' => $page['date_updated']
            ];
        }

        $view = new View("Auth/page", "page");
        $view->assign('table', $table);
    }

    public function logout(): void
    {
        echo "Logout";
    }
}