<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class Registration extends AForm
{

    protected $method = "POST";
    protected $errors = [];

    public function getConfig($row = []): array
    {
        $inputs = [
            "firstname" => [
                "type" => "text",
                "placeholder" => "Prénom",
                "min" => 2,
                "max" => 45,
                "error" => "Veuillez saisir un prénom valide.",
                "value" => $row ? trim($row['firstname']) : ''
            ],
            "lastname" => [
                "type" => "text",
                "placeholder" => "Nom",
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
            "country" => [
                "type" => "select",
                "options" => ["FR", "PL"],
            ]
        ];
        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "titre" => "Inscription",
                "errors" => $this->getErrors(),
                "submit" => "S'inscrire",
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

//    public function verifyEmailConfirmation(array $data): bool
//    {
//        $email = $data['email'];
//        $confirmEmail = $data['confirm_email'];
//
//        return $email === $confirmEmail;
//    }
//
//    public function verifyPasswordConfirmation(array $data): bool
//    {
//        $password = $data['password'];
//        $confirmPassword = $data['confirm_password'];
//
//        return $password === $confirmPassword;
//    }

}