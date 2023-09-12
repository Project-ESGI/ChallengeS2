<?php

namespace App\Controllers;

use App\Models\User;

date_default_timezone_set('Europe/Paris');

class AuthorizationHelper
{
    public function __construct()
    {
        if (!self::getCurrentUserData()) {
            self::redirectToLogin();
        }
    }

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
     * Obtient les informations de l'utilisateur actuel à partir de $_SESSION.
     *
     * @return array|null Les informations de l'utilisateur ou null si l'email n'est pas trouvé.
     */
    public static function getCurrentUserData(): ?array
    {
        if (isset($_SESSION['email'])) {
            $user = new User();
            return $user->getByEmail($_SESSION['email']);
        }
        return null;
    }

    /**
     * Effectue une redirection vers la page d'erreur 404.
     * Cette fonction arrête l'exécution du script après la redirection.
     */
    public static function redirectTo404()
    {
        http_response_code(404);
        include('./Views/Error/404.view.php');
        exit;
    }

    /**
     * Effectue une redirection vers la page d'erreur 404.
     * Cette fonction arrête l'exécution du script après la redirection.
     */
    public static function redirectToLogin()
    {
        header('Location: '.'/login');
        exit;
    }
}

