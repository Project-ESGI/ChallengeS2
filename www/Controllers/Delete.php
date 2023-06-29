<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddPage;
use App\Models\Page;

class Delete
{

    function deletePage()
    {
        $id = $_GET['id'];
        $page = new Page();
        $page->setId($id);
        $page->getById($id);

        if ($page->getId()) {
            $page->delete();
            header('Location: page?action=deleted');
            exit;
        } else {
            echo "La page à supprimer n'existe pas.";
        }
    }
}