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
                "title" => [
                    "type" => "text",
                    "placeholder" => "Titre",
                    "required" => "required",
                    "value" => trim($row['title']),
                    "min" => 2,
                    "max" => 100,
                    "error" => "Titre incorrect!"
                ],
                "content" => [
                    "type" => "textarea",
                    "placeholder" => "Contenu de l'article",
                    "required" => "required",
                    "value" => trim($row['content']),
                    "min" => 10,
                    "max" => 500,
                    "error" => "Contenu incorrect!"
                ],
//                "author" => [
//                    "type" => "text",
//                    "placeholder" => "ID de l'auteur",
//                    "required" => "required",
//                    "value" => trim($row['author']),
//                    "min" => 1,
//                    "max" => 50,
//                    "error" => "ID d'auteur incorrect!"
//                ],
                "category" => [
                    "type" => "select",
                    "placeholder" => "Catégorie",
                    "required" => "required",
                    "options" => ["Match entrainement", "Exercice"],
                    "value" => trim($row['category'])
                ]
            ];

            $submit = "Modifier";
        } else {
            $inputs = [
                "title" => [
                    "type" => "text",
                    "placeholder" => "Titre",
                    "min" => 2,
                    "max" => 100,
                    "error" => "Titre incorrect!",
                    "value" => ''
                ],
                "content" => [
                    "type" => "textarea",
                    "placeholder" => "Contenu de l'article",
                    "min" => 10,
                    "max" => 500,
                    "error" => "Contenu incorrect!",
                    "value" => ''
                ],
//                "author" => [
//                    "type" => "text",
//                    "placeholder" => "ID de l'auteur",
//                    "min" => 1,
//                    "max" => 50,
//                    "error" => "ID d'auteur incorrect!",
//                    "value" => ''
//                ],
                "category" => [
                    "type" => "select",
                    "placeholder" => "Catégorie",
                    "options" => ["Match entrainement", "Exercice"]
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
