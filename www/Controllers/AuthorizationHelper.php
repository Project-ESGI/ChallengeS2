<?php

namespace App\Controllers;

use App\Core\Mail;
use App\Core\Verificator;
use App\Core\View;
use App\Forms\AddComment;
use App\Models\User;

class AuthorizationHelper
{
    public function __construct()
    {
        if (!self::getCurrentUserData()) {
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

    public static function modifyCommon($object, $id, $form, $formData, $view, $edit)
    {
        $userData = AuthorizationHelper::getCurrentUserData();
        $user_pseudo = $userData['pseudo'];
        $user_role = $userData['role'];

        $date = new \DateTime();
        $formattedDate = $date->format('Y-m-d H:i:s');
        $result = $object->getById($id);

        $view->assign('form', $form->getConfig($result, $edit));
        $view->assign('user_pseudo', $user_pseudo);
        $view->assign('user_role', $user_role);

        if ($form->isSubmit()) {
            $error = Verificator::form($form->getConfig(), $formData);

            foreach ($error as $e => $data) {
                $form->addError($e, $data);
            }
            $view->assign('form', $form->getConfig($formData, $edit));

            if (!$error) {
                $classNameParts = explode('\\', get_class($object));
                $className = end($classNameParts);
                $addFormatedDate = null;
                $existPasswd = null;

                if ($edit !== 1) {
                    $action = "add";
                    $addFormatedDate = $formattedDate;
                    if ($className === 'User') {
                        $existPasswd = $_POST['password'];
                        $mailDescription = "Inscription via administrateur";
                        $mailSubject = "Cher utilisateur,\n\nNous sommes ravis de vous compter parmi nous ! Votre inscription a été confirmée avec succès.\n\nUn administrateur réseau a créé votre compte avec l'adresse mail : " . $_POST['email'] . ".\n\nMerci de faire partie de notre communauté. Vous pouvez maintenant accéder à toutes les fonctionnalités de notre site et profiter de nos services.\n\nSi vous avez des questions ou avez besoin d'aide, n'hésitez pas à nous contacter. Nous sommes toujours là pour vous aider.\n\nEncore une fois, bienvenue !\n\nCordialement,\nL'équipe de UFC Sport";
                        $mail = new Mail($_POST['email'], $mailSubject, $mailDescription);
                    }
                } else {
                    $action = "edit";
                }

                if ($className === 'Article') {
                    $object->actionArticle(
                        $id,
                        $_POST['title'],
                        $_POST['slug'],
                        $_POST['content'],
                        $_POST['category'],
                        $_SESSION['id'],
                        $addFormatedDate,
                        $formattedDate);
                    $newUrl = "article/" . $_POST['slug'];
                    header("Location: " . $newUrl);
                } elseif ($className === 'Comment') {
                    $object->saveCommentaire(
                        $id,
                        $_POST['content'],
                        $_SESSION['id'],
                        $addFormatedDate,
                        $formattedDate
                    );
                    header('Location: accueil?action=' . $action . '&entity=commentaire');
                } elseif ($className === 'User') {
                    $object->saveUser(
                        $id,
                        $_POST['firstname'],
                        $_POST['lastname'],
                        $_POST['pseudo'],
                        $_POST['email'],
                        $existPasswd,
                        $_POST['country'],
                        $_POST['role'],
                        $addFormatedDate,
                        $formattedDate
                    );
                    if ($edit === 1) {
                        if ($object->getId() === $_SESSION['id'] && $object->getEmail() !== $_SESSION['email']) {
                            header('Location: logout');
                        }
                    } else {
                        $mail->sendEmail();
                    }
                    header('Location: user?action=' . $action . '&entity=utilisateur');
                }
                exit;
            }
        }
    }

    /**
     * Obtient les informations d'utilisateur à partir des données de l'utilisateur.
     *
     * @param array $userData Les données de l'utilisateur.
     * @return array Le tableau associatif contenant les valeurs de l'utilisateur.
     */
    public
    static function getUserInfoFromArray(array $userData): array
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
    public
    static function redirectTo404()
    {
        http_response_code(404);
        include('./Views/Error/404.view.php');
        exit;
    }
}

