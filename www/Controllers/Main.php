<?php
namespace App\Controllers;
use App\Core\Partial;

class Main{
    public function index(){
        $view = new Partial("Main/header", "Main/footer","dashboard");
    }

}