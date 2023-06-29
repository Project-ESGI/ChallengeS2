<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddPage;
use App\Models\Article;

class Update
{
    public function index()
    {
        $view = new View("Auth/page", "dashboard");
    }

    public function modifyPage()
    {
        $id = $_GET['id'];
        $page = new Article();
        $page->setIdValue($id);
        $date = new \DateTime();
        $result = $page->getById($id);

        $formattedDate = $date->format('Y-m-d H:i:s');
        $view = new View("Auth/addPage", "page");
        $form = new addPage();
        $view->assign('form', $form->getConfig($result));

        // Vérifier si la page existe
        if ($page !== null) {
            if ($form->isSubmit()) {
                if (empty($_POST['title'])) {
                    echo 'La page doit avoir un titre';
                } else if (empty($_POST['content'])) {
                    echo 'L\'article doit avoir un contenu';
                } else if (empty($_POST['category'])) {
                    echo 'L\'article doit avoir une category';
                } else {
                    $title = $_POST['title'];
                    $content = $_POST['content'];
                    $category = $_POST['category'];

                    if ($page->existsWithTitle($title, $page->getId())) {
                        echo 'Une page avec ce titre existe déjà';
                    } else {
                        $page->setTitle($title);
                        $page->setContent($content);
                        $page->setCategory($category);
                        $page->setDateUpdated($formattedDate);
                        header('Location: page?action=updated');
                        $page->save();
                        exit;

                    }
                }
            }
        } else {
            echo "La page à modifier n'existe pas.";
        }
    }

}