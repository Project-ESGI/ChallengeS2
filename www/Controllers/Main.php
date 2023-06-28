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

    public function page(): void
    {
        $page = new Page();
        $pages = $page->getAllPage();
        $table = [];

        foreach ($pages as $page) {
            $table[] = [
                'title' => $page['title'],
                'date_inserted' => $page['date_inserted'],
                'date_updated' => $page['date_updated']
            ];
        }

        $view = new View("Auth/page", "page");
        $view->assign('table', $table);


    }
}