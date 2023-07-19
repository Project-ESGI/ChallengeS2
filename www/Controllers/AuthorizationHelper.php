<?php

namespace App\Controllers;

session_start();

class AuthorizationHelper
{
    /**
     * Vérifie si l'utilisateur a la permission requise.
     *
     * @param string|null $requiredRole Le rôle requis pour accéder à la fonctionnalité (optionnel)
     * @return bool Retourne true si l'utilisateur a la permission, sinon false
     */
    public static function hasPermission(?string $requiredRole = null): bool
    {
        if (isset($_SESSION['email'])) {
            if ($requiredRole === null || $_SESSION['role'] === $requiredRole) {
                return true;
            }
        }

        return false;
    }


    /**
     * Effectue une redirection vers la page d'erreur 404.
     * Cette fonction arrête l'exécution du script après la redirection.
     */
    public static function redirectTo404() {
        http_response_code(404);
        include('./Views/Error/404.view.php');
        exit;
    }
}

