<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddPage;
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
        $formattedDate = $date->format('Y-m-d');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            $page = new Page();
            if (empty($_POST['page_title'])) {
                echo 'La page doit avoir un titre';
            } else {
                $title = $_POST['page_title'];

                if ($page->existsWithTitle($title)) {
                    echo 'Une page avec ce titre existe déjà';
                } else {
                    $page->setTitle($title);
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
        $formattedDate = $date->format('Y-m-d');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            $user = new User();
            if (empty($_POST['user_firstname'])) {
                echo 'Le user doit avoir un prénom';
            } else {
                $firstname = $_POST['user_firstname'];

                if ($user->existsWithFirstname($firstname)) {
                    echo 'Un user avec ce titre prénom déjà';
                } else {
                    $user->setFirstname($firstname);
                    $user->setDateInserted($formattedDate);
                    $user->setDateUpdated($formattedDate);
                    $user->save();
                    header('Location: user?action=created');
                    exit;
                }
            }
        }
    }
}