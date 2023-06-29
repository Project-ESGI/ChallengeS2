<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddPage;
use App\Models\Page;

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
}