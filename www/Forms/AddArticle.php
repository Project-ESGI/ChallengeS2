<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class AddArticle extends AForm
{

    protected $method = "POST";
    protected $errors = [];

    public function getConfig($row = [], $maj = null): array
    {
        $categories = [
            "match_entrainement" => "Match d'entraînement",
            "exercice" => "Exercice",
            "competition" => "Compétition",
            "tournoi" => "Tournoi"
        ];

        $inputs = [
            "slug" => [
                "type" => "text",
                "placeholder" => "Slug",
                "min" => 2,
                "max" => 45,
                "error" => "Veuillez saisir un slug valide.",
                "value" => $row ? trim($row['slug']) : ''
            ],
            "title" => [
                "type" => "text",
                "placeholder" => "Titre",
                "min" => 2,
                "max" => 45,
                "error" => "Veuillez saisir un titre valide.",
                "value" => $row ? trim($row['title']) : ''
            ],
            "category" => [
                "type" => "select",
                "options" => $categories,
                "error" => "Veuillez sélectionner une catégorie valide.",
                "value" => $row ? trim($row['category']) : ''
            ],
            "content" => [
                "type" => "textarea",
                "placeholder" => "Contenu",
                "min" => 10,
                "max" => 5000,
                "error" => "Veuillez saisir un contenu valide.",
                "value" => $row ? trim($row['content']) : ''
            ],
        ];

        $submit = $maj ? "Modifier" : "Ajouter";

        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "ckeditor" => true,
                "titre" => $submit." un article",
                "errors" => $this->getErrors(),
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
        return $this->errors ?? [];
    }

}