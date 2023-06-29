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
<<<<<<< HEAD

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

    public function listUsers(): array
    {
        $user = new User();
        $users = $user->getAllValue();
        $table = [];

        foreach ($users as $user) {
            $table[] = [
                'id' => $user['id'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'email' => $user['email'],
                'date_inserted' => $user['date_inserted'],
                'date_updated' => $user['date_updated'],
                'country' => $user['country'],
                'banned' => $user['banned'],
                'password' => $user['password'],
                'role' => $user['role']
            ];
        }

        return $table;
    }
=======
>>>>>>> 49c78ceabcf1a1104ea0a5b2646f81d462aa750a
}