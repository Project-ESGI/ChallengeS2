<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class AddArticle extends AForm
{
    protected $method = "POST";
    protected $errors = [];

    public function getConfig($row = []): array
    {
        $inputs = [
            "title" => [
                "type" => "text",
                "placeholder" => "Titre",
                "min" => 2,
                "max" => 100,
                "value" => $row ? trim($row['title']) : ''
            ],
            "content" => [
                "type" => "textarea",
                "className" => "form-control",
                "placeholder" => "Contenu de l'article",
                "min" => 10,
                "max" => 500,
                "value" => $row ? trim($row['content']) : ''
            ],
            "category" => [
                "type" => "select",
                "placeholder" => "Catégorie",
                "options" => ["Match entrainement", "Exercice"],
                "value" => $row ? trim($row['category']) : ''
            ]
        ];

        $submit = $row ? "Modifier" : "Créer";
        $typeArticle = $row ? "Modifier" : "Créer";

        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "errors" => $this->getErrors(),
                "submit" => $submit,
                "typeArticle" => $typeArticle
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
        return $this->errors ?? [];
    }
}
