<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class Registration extends AForm
{

    protected $method = "POST";

    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "submit" => "S'inscrire",
            ],
            "inputs" => [
                "firstname" => [
                    "type" => "text",
                    "placeholder" => "Prénom",
                    "min" => 2,
                    "max" => 45,
                    "error" => "Prénom incorrect!"
                ],
                "lastname" => [
                    "type" => "text",
                    "placeholder" => "Nom",
                    "min" => 2,
                    "max" => 45,
                    "error" => "Nom incorrect!"
                ],
                "pseudo" => [
                    "type" => "text",
                    "min" => 4,
                    "max" => 255,
                    "placeholder" => "pseudo",
                    "error" => "pseudo incorrect!",
                ],
                "email" => [
                    "type" => "email",
                    "min" => 5,
                    "max" => 255,
                    "placeholder" => "email",
                    "confirm" => "email", // Assurez-vous que cette clé est présente et a la valeur correcte
                    "error" => "email incorrect!"
                ],
                "confirm_email" => [
                    "type" => "email",
                    "min" => 5,
                    "max" => 255,
                    "placeholder" => "Confirmation de l'email",
                    "confirm" => "email", // Assurez-vous que cette clé est présente et a la valeur correcte
                    "error" => "Les deux emails sont différents!"
                ],
                "password" => [
                    "type" => "password",
                    "min" => 8,
                    "max" => 45,
                    "placeholder" => "Votre mot de passe",
                    "error" => "Mot de passe trop faible."
                ],
                "confirm_password" => [
                    "type" => "password",
                    "min" => 8,
                    "max" => 45,
                    "placeholder" => "Confirmation de votre mot de passe",
                    "confirm" => "password",
                    "error" => "Le champ saisie comporte un mot de passe différent du précédent."
                ],
                "country" => [
                    "type" => "select",
                    "options" => ["FR", "PL"],
                    "error" => "Pays incorrect"
                ]
            ]
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

    public function verifyEmailConfirmation(array $data): bool
    {
        $email = $data['email'];
        $confirmEmail = $data['confirm_email'];

        return $email === $confirmEmail;
    }

    public function verifyPasswordConfirmation(array $data): bool
    {
        $password = $data['password'];
        $confirmPassword = $data['confirm_password'];

        return $password === $confirmPassword;
    }

}