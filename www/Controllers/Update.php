<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddPage;
use App\Models\Page;

class Main
{
    public function index()
    {
        $view = new View("Auth/page", "dashboard");
    }

    function modifyPage($pageId, $formData)
    {
        $page = new Page();
        $page->setId($pageId);
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d');
        $view = new View("Auth/page", "page");
        $form = new addPage();
        $view->assign('form', $form->getConfig());

        // Vérifier si la page existe
        if ($page->getId() !== 0) {
            if ($form->isSubmit()) {
                $title = $formData['title'];

                $page->setTitle($title);
                $page->setDateUpdated($formattedDate);

                $page->save();

                header('Location: page.php');
                exit;
            }
        } else {
            echo "La page à modifier n'existe pas.";
        }
    }
}