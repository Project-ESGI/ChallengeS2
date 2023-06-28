<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\Sql;
use App\Core\View;
use App\Forms\AddPage;
use App\Forms\ListPage;
use App\Core\Partial;
use App\Models\Page;
use App\Forms\ListUser;

class Main
{
    public function index()
    {
        $dashboard = "dashboard";
        $view = new Partial();
        $view->setTemplate($dashboard);
    }

    public function listPages(): void
    {
        $page = new Page();
        $pages = $page->getAllPage();

        foreach ($pages as $page) {
            echo "Titre : " . $page['title'] . "<br>";
            echo "Date d'insertion : " . $page['date_inserted'] . "<br>";
            echo "Date de mise à jour : " . $page['date_updated'] . "<br>";
            echo "-----------------------------------<br>";
        }
    }

    public function addPage(): void
    {
        $form = new AddPage();
        $view = new View("Auth/ajoutPage", "page");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d');
        $view->assign('form', $form->getConfig());


        if ($form->isSubmit()) {
            $page = new Page();
            $error = false;

            if (empty($_POST['page_title'])) {
                echo 'La page doit avoir un titre';
                $error = true;
            } else {
                $title = $_POST['page_title'];

                if ($page->existsWithTitle($title)) {
                    echo 'Une page avec ce titre existe déjà';
                    $error = true;
                } else {
                    $page->setTitle($title);
                    $page->setDateInserted($formattedDate);
                    $page->setDateUpdated($formattedDate);
                    $page->save();
                    echo "Page créée avec succès";
                }
            }
//            if ($error) {
//                $form->addError('page_title', 'Le champ "Titre de la page" est obligatoire ou déjà utilisé.');
//            }
        }
    }
}