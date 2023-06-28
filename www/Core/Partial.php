<?php
namespace App\Core;
class Partial {

    private String $viewList;
    private String $viewAdd;
    private String $template;
    private $data = [];

    public function __construct(String $viewList,String $viewAdd,String $template="dashboard"){
        $this->setviewList($viewList);
        $this->setviewAdd($viewAdd);
        $this->setTemplate($template);
    }


    public function assign(String $key, $value): void
    {
        $this->data[$key]=$value;
    }

    public function setviewList(String $viewList): void
    {
        $viewList = "Views/".trim($viewList).".view.php";
        if(!file_exists($viewList)){
            die("La vue ".$viewList." n'existe pas");
        }
        $this->viewList = $viewList;
    }

    public function setviewAdd(String $viewAdd): void
    {
        $viewAdd = "Views/".trim($viewAdd).".view.php";
        if(!file_exists($viewAdd)){
            die("La vue ".$viewAdd." n'existe pas");
        }
        $this->viewAdd = $viewAdd;
    }

    public function setTemplate(String $template): void
    {
        $template = "Views/".trim($template).".tpl.php";
        if(!file_exists($template)){
            die("Le template ".$template." n'existe pas");
        }
        $this->template = $template;
    }

    public function modal($name, $config):void
    {
        include "Views/Modals/".$name.".php";
    }

    public function __destruct(){
        extract($this->data);
        include $this->template;
    }

}