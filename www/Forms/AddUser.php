<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class AddUser extends AForm
{

    protected $method = "POST";
    protected $errors = [];

    public function getConfig($row = [], $maj = null): array
    {
        $inputs = [
            "firstname" => [
                "type" => "text",
                "placeholder" => "prénom",
                "min" => 2,
                "max" => 45,
                "error" => "Veuillez saisir un prénom valide.",
                "value" => $row ? trim($row['firstname']) : ''
            ],
            "lastname" => [
                "type" => "text",
                "placeholder" => "nom",
                "min" => 2,
                "max" => 45,
                "error" => "Veuillez saisir un nom valide.",
                "value" => $row ? trim($row['lastname']) : ''
            ],
            "pseudo" => [
                "type" => "text",
                "min" => 4,
                "max" => 255,
                "placeholder" => "pseudo",
                "error" => "Veuillez saisir un pseudo valide.",
                "value" => $row ? trim($row['pseudo']) : ''
            ],
            "email" => [
                "type" => "email",
                "min" => 5,
                "max" => 255,
                "placeholder" => "email",
                "error" => "Veuillez saisir un email valide.",
                "value" => $row ? trim($row['email']) : ''
            ],
            "country" => [
                "type" => "select",
                "options" => ["FR", "PL"],
                "value" => $row ? trim($row['country']) : '',
            ],
            "role" => [
                "type" => "select",
                "options" => ["user", "admin"],
                "value" => $row ? trim($row['role']) : '',
            ],
        ];

        // Exclure le champ du mot de passe si $row est défini
        if (!$maj) {
            $inputs["password"] = [
                "type" => "password",
                "min" => 8,
                "max" => 45,
                "placeholder" => "mot de passe",
                "error" => "Mot de passe trop faible."
            ];
        }

        $submit = $maj ? "Modifier" : "Créer";
        $typeUser = $maj ? "Modifier" : "Créer";

        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "errors" => $this->getErrors(),
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
        return $this->errors ?? [];
    }
}
