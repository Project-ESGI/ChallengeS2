<?php

namespace App\Core;
class View
{

    private string $view;
    private string $template;
    private $data = [];

    public function __construct(string $view, string $template)
    {
        $this->setView($view);
        $this->setTemplate($template);
    }


    public function assign(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function setView(string $view): void
    {
        $view = "Views/" . trim($view) . ".view.php";
        if (!file_exists($view)) {
            die("La vue " . $view . " n'existe pas");
        }
        $this->view = $view;
    }

    public function setTemplate(string $template): void
    {
        $template = "Views/" . trim($template) . ".tpl.php";
        if (!file_exists($template)) {
            die("Le template " . $template . " n'existe pas");
        }
        $this->template = $template;
    }

    public function modal($name, $config): void
    {
        include "Views/Modals/" . $name . ".php";
    }

    public function __destruct()
    {
        extract($this->data);
        include $this->template;
    }

}