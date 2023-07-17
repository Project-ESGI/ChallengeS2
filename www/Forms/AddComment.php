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
                "min" => 10,
                "max" => 450,
                "value" => $row ? trim($row['content']) : ''
            ],
        ];

        // Exclure le champ du mot de passe si $row est défini
        if (!$row) {
            $inputs["password"] = [
                "type" => "password",
                "min" => 8,
                "max" => 45,
                "placeholder" => "mot de passe",
                "error" => "Mot de passe trop faible."
            ];
        }

        $submit = $row ? "Modifier" : "Créer";
        $typeUser = $row ? "Modifier" : "Créer";

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
