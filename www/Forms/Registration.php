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
                "email" => [
                    "type" => "email",
                    "min" => 5,
                    "max" => 255,
                    "placeholder" => "email",
                    "error" => "email incorrect!"
                ],
                "confirm_email" => [
                    "type" => "email",
                    "min" => 5,
                    "max" => 255,
                    "placeholder" => "Confirmation de l'email",
                    "confirm" => "email",
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
                "country"=>[
                    "type"=>"select",
                    "options"=>["","FR", "PL"],
                    "error"=>"Pays incorrect"
                ]
            ]
        ];
    }
}