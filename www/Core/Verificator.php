<?php

namespace App\Core;

use App\Forms\Registration;
use App\Models\Article;
use App\Models\User;

class Verificator
{
    public static function form(array $config, array $data): array
    {
        $listOfErrors = [];
        $user = new User();
        $article = new Article();

        if (isset($_GET['id'])) {
            $user->setIdValueString($_GET['id']);
            $article->setIdValueString($_GET['id']);
        }

        foreach ($config["inputs"] as $name => $input) {
            if (isset($data[$name])) {
                if ($name === "email" || $name === "pseudo") {
                    if ($user->existsWithValue("esgi_user", $name, $data[$name], $user->getId())) {
                        $listOfErrors[$name] = "Ce " . $name . " est déjà utilisé. Veuillez en choisir un autre.";
                    }
                } elseif (strlen($data[$name]) < 3 && isset($input["error"]) && $name !== "email") {
                    $listOfErrors[$name] = $input["error"];
                } elseif ($name === "title" || $name === "slug") {
                    if ($user->existsWithValue("esgi_article", $name, $data[$name], $article->getId())) {
                        $listOfErrors[$name] = "Ce " . $name . " est déjà utilisé. Veuillez en choisir un autre.";
                    }
                } else {
                    if ($name === "email" || $name === "confirm_email") {
                        if (strlen($data[$name]) < 5 || strpos($data[$name], '@') === false) {
                            $listOfErrors[$name] = $input["error"];
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

                    if ($name !== "password" && $name !== "confirm_password" && $name !== "content") {
                        $invalidFields = $user->checkSpecialCharacters($data[$name], $name);
                        if ($invalidFields) {
                            $listOfErrors[$name] = 'Le champ contient des caractères spéciaux non autorisés.';
                        }
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
