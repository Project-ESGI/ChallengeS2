<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class TempoPassword extends AForm
{

    protected $method = "POST";
    protected $errors = [];

    public function getConfig($row = []): array
    {
        $inputs = [

            "password" => [
                "type" => "password",
                "min" => 8,
                "max" => 45,
                "placeholder" => "Votre mot de passe",
                "error" => "Veuillez saisir un mot de passe valide.",
            ],
            "confirm_password" => [
                "type" => "password",
                "min" => 8,
                "max" => 45,
                "placeholder" => "Confirmation de votre mot de passe",
                "error" => "Veuillez saisir un mot de passe valide.",
                "confirm" => "password",
            ],

        ];
        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "titre" => "Nouveau Mot de passe",
                "errors" => $this->getErrors(),
                "submit" => "Entrer",
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