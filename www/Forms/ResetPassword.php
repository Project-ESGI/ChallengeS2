<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class ResetPassword extends AForm
{

    protected $method = "POST";
    protected $errors = [];

    public function getConfig($row = []): array
    {
        $inputs = [

            "email" => [
                "type" => "email",
                "min" => 5,
                "max" => 255,
                "placeholder" => "email",
                "confirm" => "email",
                "error" => "Veuillez saisir un email valide.",
                "value" => $row ? trim($row['email']) : ''
            ],
            "confirm_email" => [
                "type" => "email",
                "min" => 5,
                "max" => 255,
                "placeholder" => "Confirmation de l'email",
                "error" => "Veuillez saisir un email valide.",
                "confirm" => "email",
            ],
        ];
        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "titre" => "Inscription",
                "errors" => $this->getErrors(),
                "submit" => "Envoyer un e-mail de récupération",
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