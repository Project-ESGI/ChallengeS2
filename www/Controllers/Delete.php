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

    function deletePage($pageId)
    {
        $page = new Page();
        $page->setId($pageId);

        // Vérifier si la page existe
        if ($page->getId() !== 0) {
            $page->delete();

            header('Location: page.php');
            exit;
        } else {
            echo "La page à supprimer n'existe pas.";
        }
    }
}