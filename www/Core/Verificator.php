<?php

namespace App\Core;

use App\Models\User;

class Verificator
{
    public static function form(array $config, array $data): array
    {
        $listOfErrors = [];
        $user = new User();
        if (isset($_GET['id'])) {
            $user->setIdValue($_GET['id']);
        }

        foreach ($config["inputs"] as $name => $input) {
            if (isset($data[$name])) {
                if (strlen($data[$name]) < 3 && isset($input["error"]) && $name !== "email") {
                    $listOfErrors[$name] = $input["error"];
                } else {
                    if ($name === "email" || $name === "confirm_email") {
                        if (strlen($data[$name]) < 5 || strpos($data[$name], '@') === false) {
                            $listOfErrors[$name] = $input["error"];
                        } elseif ($user->existsWithEmail($data[$name], $user->getId())) {
                            $listOfErrors[$name] = "Cet e-mail est déjà utilisé. Veuillez en choisir un autre.";
                        }
                    }

                    if ($name === "password") {
                        if (strlen($data[$name]) < 8) {
                            $listOfErrors[$name] = "Le mot de passe doit contenir au moins 8 caractères.";
                        } elseif (!preg_match('/[0-9]/', $data[$name])) {
                            $listOfErrors[$name] = "Le mot de passe doit contenir au moins un chiffre.";
                        } elseif (!preg_match('/[A-Z]/', $data[$name])) {
                            $listOfErrors[$name] = "Le mot de passe doit contenir au moins une majuscule.";
                        } elseif (!preg_match('/[^a-zA-Z0-9]/', $data[$name])) {
                            $listOfErrors[$name] = "Le mot de passe doit contenir au moins un caractère spécial.";
                        }
                    }

                    $invalidFields = $user->checkSpecialCharacters($data[$name], $name);
                    if ($invalidFields) {
                        $listOfErrors[$name] = 'Le champ contient des caractères spéciaux non autorisés.';
                    }

                    if ($name === "email" && isset($data['confirm_email'])) {
                        if ($data['email'] !== $data['confirm_email']) {
                            $listOfErrors['confirm_email'] = 'Les deux emails sont différents!';
                        }
                    }

                    if ($name === "password" && isset($data['confirm_password'])) {
                        if ($data['password'] !== $data['confirm_password']) {
                            $listOfErrors['confirm_password'] = 'Les deux mots de passe sont différents!';
                        }
                    }
                }
            }
        }
        return $listOfErrors;
    }
}
