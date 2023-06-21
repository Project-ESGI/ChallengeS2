<?php
namespace App\Controllers;

use App\Core\Partial;
use App\Models\Page;
use App\Forms\ListPage;
use App\Forms\ListUser;


class Main{
    public function index(){
        $view = new Partial("Main/header", "Main/footer","dashboard");
    }

    public function page(): void
{
  //  $listPage = new ListPage();
  //  $pages = $listPage->getAllPages();
    
   $view = new Partial("Main/header", "Main/footer","page");
}

}