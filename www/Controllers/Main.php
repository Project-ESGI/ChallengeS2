<?php

namespace App\Controllers;

use App\Core\Menu;
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

    public function addPage(): void
    {
        $form = new AddPage();
        $view = new View("Auth/ajoutPage", "page");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            $page = new Page();
//            if (!$_POST['page_title']){
//                $form->addError();
//            }
            $page->setTitle($_POST['page_title']);
            $page->setDateInserted($formattedDate);
            $page->setDateUpdated($formattedDate);
            $page->save();
            echo "Page créée avec succès";
        }
    }


}