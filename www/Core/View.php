<?php
namespace App\Core;
class View {

    private String $header;
    private String $footer;
    private String $template;
    private $data = [];

    public function __construct(String $header,String $footer,String $template="back"){
        $this->setHeader($header);
        $this->setFooter($footer);
        $this->setTemplate($template);
    }


    public function assign(String $key, $value): void
    {
        $this->data[$key]=$value;
    }

    public function setHeader(String $header): void
    {
        $header = "Views/".trim($header).".view.php";
        if(!file_exists($header)){
            die("La vue ".$header." n'existe pas");
        }
        $this->header = $header;
    }

    public function setFooter(String $footer): void
    {
        $footer = "Views/".trim($footer).".view.php";
        if(!file_exists($footer)){
            die("La vue ".$footer." n'existe pas");
        }
        $this->footer = $footer;
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