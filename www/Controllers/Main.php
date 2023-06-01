<?php
namespace App\Controllers;
use App\Core\View;

class Main{
    public function index(){

        //$pseudo = "User";
        $header = new View("Main/header", "Main/footer","front");
        //$index->assign("pseudo", $pseudo);
    }

    public function contact(){
        $view = new View("Main/contact", "front");
    }

    public function dashboard(){
        echo "Mon tableau de bord";
    }
}