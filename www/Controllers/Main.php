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
}