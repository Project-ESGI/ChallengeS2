<?php
namespace App\Controllers;
use App\Core\View;

class Main{
    public function index(){

        $view = new View("Main/header", "Main/footer","front");
    }

    public function dashboard(){
        echo "Mon tableau de bord";
    }
}