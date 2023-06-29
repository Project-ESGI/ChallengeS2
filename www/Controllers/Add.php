<?php

namespace App\Controllers;

use App\Core\Menu;
use App\Core\View;
use App\Forms\AddPage;
use App\Models\Article;
use App\Models\User;

class Add
{
    public function addPage(): void
    {
        $form = new AddPage();
        $view = new View("Auth/addPage", "page");
        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d H:i:s');
        $view->assign('form', $form->getConfig());
        if ($form->isSubmit()) {
            $page = new Article();
            $user = new User();
            if (empty($_POST['title'])) {
                echo 'La page doit avoir un titre';
            } else if (empty($_POST['content'])) {
                echo 'La page doit avoir un contenu';
            }  else {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $author = 1;
                $category = $_POST['category'];

                if ($page->existsWithTitle($title)) {
                    echo 'Une page avec ce titre existe déjà';
                } else {
                    $page->setTitle($title);
                    $page->setContent($content);
                    $page->setAuthorId($author); // Définir l'ID de l'auteur
                    $page->setCategory($category);
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