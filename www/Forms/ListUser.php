<?php
namespace App\Forms;
use App\Core\Sql;

use App\Forms\Abstract\AForm;

class ListUser extends AForm implements Sql {

    protected $method = "POST";
        public function getAllUsers() {
            $queryPrepared = $this->pdo->prepare("SELECT * FROM " . $this->table);
            $queryPrepared->execute();
            return $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    // Exemple d'utilisation
    $userSql = new User();
    $users = $userSql->getAllUsers();
    
    // Affichage des utilisateurs
    foreach ($users as $user) {
        echo "ID: " . $user['id'] . ", Nom: " . $user['nom'] . ", Email: " . $user['email'] . "<br>";
    }
}
    