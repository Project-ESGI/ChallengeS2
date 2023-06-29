<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddPage;
use App\Models\Page;

class Update
{
    public function index()
    {
        $view = new View("Auth/page", "dashboard");
    }

    public function modifyPage()
    {
        $id = $_GET['id'];
        $page = new Page();
        $page->setIdValue($id);
        $date = new \DateTime();
        $result = $page->getById($id);

        $formattedDate = $date->format('Y-m-d');
        $view = new View("Auth/addPage", "page");
        $form = new addPage();
        $view->assign('form', $form->getConfig($result));

        // Vérifier si la page existe
        if ($page !== null) {
            if ($form->isSubmit()) {
                if (empty($_POST['page_title'])) {
                    echo 'La page doit avoir un titre';
                } else {
                    $title = $_POST['page_title'];

                    if ($page->existsWithTitle($title, $page->getId())) {
                        echo 'Une page avec ce titre existe déjà';
                    } else {
                        $page->setTitle($title);
                        $page->setDateInserted($page->getDateInserted());
                        $page->setDateUpdated($formattedDate);

                        $page->save();
                        header('Location: page?action=updated');
                        exit;

                    }
                }
            }
        } else {
            echo "La page à modifier n'existe pas.";
        }
    }


    public function modifyUser()
    {
        $id = $_GET['id'];
        $user = new User();
        $user->setIdValue($id);
        $date = new \DateTime();
        $result = $user->getById($id);

        $formattedDate = $date->format('Y-m-d');
        $view = new View("Auth/addUser", "user");
        $form = new addUser();
        $view->assign('form', $form->getConfig($result));

        // Vérifier si le user existe
        if ($user !== null) {
            if ($form->isSubmit()) {
                if (empty($_POST['user_firstname'])) {
                    echo 'Le user doit avoir un prénom';
                } else {
                    $firstname = $_POST['user_firstname'];

                    if ($user->existsWithFirstname($firstname, $user->getId())) {
                        echo 'Un user avec ce firstname existe déjà';
                    } else {
                        $user->setTitle($firstname);
                        $user->setDateInserted($user->getDateInserted());
                        $user->setDateUpdated($formattedDate);

                        $user->save();
                        header('Location: page?action=updated');
                        exit;

                    }
                }
            }
        } else {
            echo "Le user à modifier n'existe pas.";
        }
    }

}