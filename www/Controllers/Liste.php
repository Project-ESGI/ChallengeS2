<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Models\Article;

class Liste
{
    public function index()
    {
        $view = new View("Auth/page", "dashboard");
    }
}