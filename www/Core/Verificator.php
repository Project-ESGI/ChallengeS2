<?php

namespace App\Core;

class Verificator
{

    public static function formRegister(array $config, array $data): array
    {
        $listOfErrors = [];
        if (count($config["inputs"]) != count($data) - 1) {
            die("Tentative de Hack");
        }
        foreach ($config["inputs"] as $name => $input) {
            if (empty($data[$name])) {
                die("Tentative de Hack");
            }

            if ($input["type"] == "text" && !self::checkFirstName($data[$name])) {
                $listOfErrors[] = $input["error"];
            }

            if ($input["type"] == "text" && !self::checkLastName($data[$name])) {
                $listOfErrors[] = $input["error"];
            }

            if ($input["type"] == "email" && !self::checkEmail($data[$name])) {
                $listOfErrors[] = $input["error"];
            }

            if ($input["type"] == "email" && !self::checkConfirmEmail($data["user_confirm_email"], $data[$name])) {
                $listOfErrors[] = $input["error"];
            }

            if ($input["type"] == "password" && !self::checkPassword($data[$name])) {
                $listOfErrors[] = $input["error"];
            }

            if ($input["type"] == "password" && !self::checkConfirmPassword($data["user_confirm_password"], $data[$name])) {
                $listOfErrors[] = $input["error"];
            }
        }
        return $listOfErrors;
    }

    public static function formConnection(array $config, array $data): array
    {
        $listOfErrors = [];
        if (count($config["inputs"]) != count($data) - 1) {
            die("Tentative de Hack");
        }
        foreach ($config["inputs"] as $name => $input) {
            if (empty($data[$name])) {
                die("Tentative de Hack");
            }

            if ($input["type"] == "email" && !self::checkEmail($data[$name])) {
                $listOfErrors[] = $input["error"];
            }

            if ($input["type"] == "password" && !self::checkPassword($data[$name])) {
                $listOfErrors[] = $input["error"];
            }
        }
        return $listOfErrors;
    }

    public static function checkEmail($email): bool
    {
        $filterMail = filter_var($email, FILTER_VALIDATE_EMAIL);
        $pregMail = preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email);
        return $filterMail && $pregMail;
    }

    public static function checkPassword($password): bool
    {
        return preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[a-zA-Z\d!@#$%^&*()]{8,45}$/", $password);
    }

    public static function checkFirstName($firstName): bool
    {
        return preg_match("/^[a-zA-Z]{2,45}$/", $firstName);
    }

    public static function checkLastName($lastName): bool
    {
        return preg_match("/^[a-zA-Z]{2,45}$/", $lastName);
    }

    public static function checkConfirmEmail($email, $confirmEmail): bool
    {
        return $email == $confirmEmail;
    }

    public static function checkConfirmPassword($password, $confirmPassword): bool
    {
        return $password == $confirmPassword;
    }
}