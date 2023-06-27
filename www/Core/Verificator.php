<?php
namespace App\Core;

class Verificator{

    public static function form(array $config, array $data): array
    {
        $listOfErrors = [];
        if(count($config["inputs"]) != count($data)-1){
            die("Tentative de Hack");
        }

        foreach ($config["inputs"] as $name=>$input){

            if(empty($data[$name])){
                die("Tentative de Hack");
            }

            if($input["type"]=="email" && !self::checkEmail($data[$name])){
                $listOfErrors[]=$input["error"];
            }

        }

        return $listOfErrors;
    }

    public static function checkEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

}