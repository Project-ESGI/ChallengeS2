<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class AddComment extends AForm
{

    protected $method = "POST";

    public function getConfig($row = []): array
    {
        $inputs = [
            "content" => [
                "type" => "text",
                "placeholder" => "message",
                "min" => 3,
                "max" => 450,
                "error" => "Veuillez saisir un contenu valide.",
                "value" => $row ? trim($row['content']) : ''
            ],
        ];


        $submit = $row ? "Ajouter" : "Créer";
        $typeUser = $row ? "Ajouter" : "Créer";

        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "submit" => $submit,
                "typeUser" => $typeUser
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
