<?php

namespace App;

session_start();

use App\Models\Article;

spl_autoload_register(function ($class) {
    $class = str_replace("App\\", "", $class);
    $class = str_replace("\\", "/", $class) . ".php";
    if (file_exists($class)) {
        include $class;
    }
});

// Nettoyer l'URI
$uriExploded = explode("?", $_SERVER["REQUEST_URI"]);
$uri = rtrim(strtolower(trim($uriExploded[0])), "/");
$uri = (empty($uri)) ? "/" : $uri;

if (!file_exists("routes.yml")) {
    die("Le fichier de routing n'existe pas");
}

$routes = yaml_parse_file("routes.yml");
// Récupérer tous les slugs depuis la base de données
$article = new Article();
$slugs = null;
if (isset($_SESSION['id'])) {
    $slugs = $article->getAllSlug($_SESSION['id']);

// Créer les routes pour chaque slug
    foreach ($slugs as $slug) {
        $path = "/article/" . $slug;
        $routes[$path] = [
            "controller" => "Main",
            "action" => "show"
        ];
    }
}

//ArticleController 404
if (empty($routes[$uri])) {
    http_response_code(404);
    include('./Views/Error/404.view.php');
    exit;
}

$controller = $routes[$uri]["controller"];
$action = $routes[$uri]["action"];

if (!file_exists("Controllers/" . $controller . ".php")) {
    die("Le fichier Controllers/" . $controller . ".php n'existe pas");
}

include "Controllers/" . $controller . ".php";

$controller = "\\App\\Controllers\\" . $controller;
if (!class_exists($controller)) {
    die("La class " . $controller . " n'existe pas");
}

$objet = new $controller();

if (!method_exists($objet, $action)) {
    die("L'action " . $action . " n'existe pas");
}

$objet->$action();
?>
