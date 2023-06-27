<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class AddPage extends AForm
{
    protected $method = "POST";

    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "submit" => "Créer",
            ],
            "inputs" => [
                "page_title" => [
                    "type" => "text",
                    "placeholder" => "Titre de la page",
                    "min" => 2,
                    "max" => 100,
                    "error" => "Titre incorrect!"
                ]
            ]
        ];
    }
}
