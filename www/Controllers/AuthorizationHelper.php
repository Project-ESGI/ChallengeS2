<?php

namespace App\Controllers;

use App\Models\User;

class AuthorizationHelper
{
    public function __construct()
    {
        if (!self::getCurrentUserData()){
            self::redirectTo404();
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
     * Obtient les informations d'utilisateur à partir des données de l'utilisateur.
     *
     * @param array $userData Les données de l'utilisateur.
     * @return array Le tableau associatif contenant les valeurs de l'utilisateur.
     */
    public static function getUserInfoFromArray(array $userData): array
    {
        $user_name = $userData['firstname'] . ' ' . $userData['lastname'];
        $user_pseudo = $userData['pseudo'];
        $user_role = $userData['role'];
        $user_id = $userData['id'];

        return [
            'user_name' => $user_name,
            'user_pseudo' => $user_pseudo,
            'user_role' => $user_role,
            'user_id' => $user_id,
        ];
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

