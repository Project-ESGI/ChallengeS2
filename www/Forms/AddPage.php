<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class AddPage extends AForm
{
    protected $method = "POST";

    public function getConfig($row = []): array
    {
        if ($row) {
            $inputs = [
                "page_title" => [
                    "type" => "text",
                    "placeholder" => "Titre de la page",
                    "required" => "required",
                    "value" => trim($row['title']),
                    "min" => 2,
                    "max" => 100,
                    "error" => "Titre incorrect!"
                ]
            ];

            $submit = "Modifier";
        } else {
            $inputs = [
                "page_title" => [
                    "type" => "text",
                    "placeholder" => "Titre de la page",
                    "min" => 2,
                    "max" => 100,
                    "error" => "Titre incorrect!",
                    "value" => ''
                ]
            ];

            $submit = "Créer";
        }

        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "submit" => $submit,
            ],
            "inputs" => $inputs
        ];
    }


    public function addError(string $fieldName, string $errorMessage)
    {
        $this->errors[$fieldName] = $errorMessage;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
