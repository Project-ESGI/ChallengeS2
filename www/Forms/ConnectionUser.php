<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class ConnectionUser extends AForm
{

    protected $method = "POST";

    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "",
                "enctype" => "",
                "submit" => "Se Connecter",
                "cancel" => "Annuler"
            ],
            "inputs" => [
                "user_email" => [
                    "type" => "email",
                    "min" => 13,
                    "max" => 320,
                    "placeholder" => "email",
                    "error" => "L'email ou le mot de passe est incorrect!"
                ],
                "user_password" => [
                    "type" => "password",
                    "min" => 9,
                    "max" => 50,
                    "placeholder" => "mot de passe",
                    "error" => "L'email ou le mot de passe est incorrect!"
                ],
            ]
        ];
    }
}