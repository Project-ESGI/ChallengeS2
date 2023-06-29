<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Models\Page;

class Liste
{
    public function index()
    {
        $view = new View("Auth/page", "dashboard");
    }

    public function listPages(): array
    {
        $page = new Page();
        $pages = $page->getAllValue();
        $table = [];

        foreach ($pages as $page) {
            $table[] = [
                'title' => $page['title'],
                'date_inserted' => $page['date_inserted'],
                'date_updated' => $page['date_updated']
            ];
        }

        return $table;
    }
}