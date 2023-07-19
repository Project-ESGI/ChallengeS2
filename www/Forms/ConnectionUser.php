<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class ConnectionUser extends AForm
{
    protected $method = "POST";
    protected $errors = [];

    public function getConfig(): array
    {
        $inputs = [
            "email" => [
                "type" => "email",
                "min" => 13,
                "max" => 320,
                "placeholder" => "email",
                "error" => "L'email ou le mot de passe est incorrect!"
            ],
            "password" => [
                "type" => "password",
                "min" => 9,
                "max" => 50,
                "placeholder" => "mot de passe",
                "error" => "L'email ou le mot de passe est incorrect!"
            ],
        ];
        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "titre" => "Connexion",
                "errors" => $this->getErrors(),
                "submit" => "Se Connecter",
                "cancel" => "Annuler"
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