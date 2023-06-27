<?php
namespace App\Core;

class Partial {
    private String $template;
    private $data = [];

    public function __construct(String $template = "dashboard"){
        $this->setTemplate($template);
    }

    public function assign(String $key, $value): void {
        $this->data[$key] = $value;
    }

    public function setTemplate(String $template): void {
        $template = "Views/".trim($template).".tpl.php";
        if(!file_exists($template)){
            die("Le template ".$template." n'existe pas");
        }
        $this->template = $template;
    }

    public function renderContent(): void {
        extract($this->data);
        include $this->template;
    }

    public function __destruct(){
        $this->renderContent();
    }
}
