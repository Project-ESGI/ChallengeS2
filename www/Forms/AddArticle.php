<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class AddArticle extends AForm
{
    protected $method = "POST";

    public function getConfig($row = []): array
    {
        $inputs = [
            "title" => [
                "type" => "text",
                "placeholder" => "Titre",
                "min" => 2,
                "max" => 100,
                "error" => "Titre incorrect!",
                "value" => $row ? trim($row['title']) : ''
            ],
            "content" => [
                "type" => "textarea",
                "placeholder" => "Contenu de l'article",
                "min" => 10,
                "max" => 500,
                "error" => "Contenu incorrect!",
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
