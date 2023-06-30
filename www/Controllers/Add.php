<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddPage;
use App\Models\Article;
use App\Models\Page;
use App\Models\User;
use App\Forms\AddUser;
class Add
{
    public function addPage(): void
    {
        $form = new AddPage();
        $view = new View("Auth/addPage", "page");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d H:i:s');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            $page = new Article();
            $user = new User();
            if (empty($_POST['title'])) {
                echo 'La page doit avoir un titre';
            } else if (empty($_POST['content'])) {
                echo 'La page doit avoir un contenu';
            } else {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $author = 1;
                $category = $_POST['category'];

                if ($page->existsWith($title)) {
                    echo 'Une page avec ce titre existe déjà';
                } else {
                    $page->setTitle($title);
                    $page->setContent($content);
                    $page->setAuthorId($author); // Définir l'ID de l'auteur
                    $page->setCategory($category);
                    $page->setDateInserted($formattedDate);
                    $page->setDateUpdated($formattedDate);
                    $page->save();
                    header('Location: page?action=created');
                    exit;
                }
            }
        }
    }

    public function addUser(): void
    {
        $form = new AddUser();
        $view = new View("Auth/addUser", "user");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d H:i:s');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            $user = new User();
            var_dump($_POST);
            if (empty($_POST['user_firstname'])) {
                echo 'Le user doit avoir un prénom';
            } else if (empty($_POST['user_lastname'])) {
                echo 'Le user doit avoir un nom';
            } else {
                $firstname = $_POST['user_firstname'];
                $lastname = $_POST['user_lastname'];
                $email = $_POST['user_email'];
                $password = $_POST['user_password'];
                $country = $_POST['country'];

                if ($user->existsWithF($firstname)) {
                    echo 'Un user existe deja avec ce prénom';
                } else {
                    $user->setFirstname($firstname);
                    $user->setLastname($lastname);
                    $user->setEmail($email);
                    $user->setPassword($password);
                    $user->setDateInserted($formattedDate);
                    $user->setDateUpdated($formattedDate);
                    $user->setCountry($country);
                    $user->save();
                    header('Location: user?action=created');
                    exit;
                }
            }
        }
    }
}