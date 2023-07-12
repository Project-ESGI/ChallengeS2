<?php

namespace App\Core;

abstract class Sql
{

    private $pdo;
    private $table;

    public function __construct()
    {
        //Mettre en place un SINGLETON
        try {
            $this->pdo = new \PDO("pgsql:host=database;port=5432;dbname=challenge", "s2", "Test1234");
        } catch (\Exception $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
        $classExploded = explode("\\", get_called_class());
        $this->table = end($classExploded);
        $this->table = "esgi_" . $this->table;
    }

    /**
     * Enregistre l'objet dans la base de données.
     *
     * @return void
     */
    public function save(): void
    {
        $columns = get_object_vars($this);
        $columnsToDeleted = get_class_vars(get_class());
        $columns = array_diff_key($columns, $columnsToDeleted);
        unset($columns["id"]);

        if ($this->getId() !== 0) {
            $columnsUpdate = [];
            foreach ($columns as $key => $value) {
                $columnsUpdate[] = $key . "=:" . $key;
            }
            $queryPrepared = $this->pdo->prepare("UPDATE " . $this->table . " SET " . implode(",", $columnsUpdate) . " WHERE id=:id");
            $columns['id'] = $this->getId();
        } else {
            // Insertion de nouvelles données
            $queryPrepared = $this->pdo->prepare("INSERT INTO " . $this->table . " (" . implode(",", array_keys($columns)) . ") 
                        VALUES (:" . implode(",:", array_keys($columns)) . ")");
        }

        $queryPrepared->execute($columns);
    }

    /**
     * Vérifie si un utilisateur existe dans la base de données avec l'email et le mot de passe donnés.
     *
     * @param string $email L'email de l'utilisateur à vérifier.
     * @param string $password Le mot de passe de l'utilisateur à vérifier.
     * @return bool True si l'utilisateur existe avec les identifiants donnés, sinon False.
     */
    public function existUser($email, $password): bool
    {
        $queryPrepared = $this->pdo->prepare("SELECT password FROM " . $this->table . " WHERE email = :email");
        $queryPrepared->bindValue(':email', $email, \PDO::PARAM_STR);
        $queryPrepared->execute();

        $hash = $queryPrepared->fetchColumn();

        if (!$hash) {
            return false;
        }

        return password_verify($password, $hash);
    }


    /**
     * Supprime l'enregistrement de la base de données.
     *
     * @return void
     */
    public function delete(): void
    {
        $queryPrepared = $this->pdo->prepare("DELETE FROM " . $this->table . " WHERE id=:id");
        $queryPrepared->execute(['id' => $this->getId()]);
    }

    /**
     * Vérifie si un enregistrement avec le même titre existe déjà dans la base de données.
     *
     * @param string $title Le titre à vérifier.
     * @param int|null $id L'ID de l'enregistrement actuel (facultatif).
     * @return bool True si un enregistrement avec le même titre existe déjà, sinon False.
     */
    public function existsWith(string $title, int $id = null): bool
    {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE title = :title";
        $parameters = [':title' => $title];

        if ($id !== null) {
            $query .= " AND id <> :id";
            $parameters[':id'] = $id;
        }

        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->execute($parameters);

        return $queryPrepared->fetchColumn() > 0;
    }

    /**
     * Vérifie si un enregistrement avec le même titre existe déjà dans la base de données.
     *
     * @param string $firstname Le titre à vérifier.
     * @param int|null $id L'ID de l'enregistrement actuel (facultatif).
     * @return bool True si un enregistrement avec le même titre existe déjà, sinon False.
     */
    public function existsWithF(string $firstname, int $id = null): bool
    {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE firstname = :firstname";
        $parameters = [':firstname' => $firstname];

        if ($id !== null) {
            $query .= " AND id <> :id";
            $parameters[':id'] = $id;
        }

        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->execute($parameters);

        return $queryPrepared->fetchColumn() > 0;
    }

    /**
     * Récupère toutes les valeurs de la table.
     *
     * @return array Un tableau contenant toutes les valeurs de la table.
     */
    public function getAllValue(): array
    {
        $queryPrepared = $this->pdo->prepare("SELECT * FROM " . $this->table);
        $queryPrepared->execute();

        return $queryPrepared->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les données d'un enregistrement par son ID.
     *
     * @param int $id L'ID de l'enregistrement à récupérer.
     * @return array|null Les données de l'enregistrement, ou null si l'ID n'existe pas.
     */
    public function getById($id): ?array
    {
        $queryPrepared = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE id = :id");
        $queryPrepared->bindValue(':id', $id, \PDO::PARAM_INT);
        $queryPrepared->execute();

        $pageData = $queryPrepared->fetch(\PDO::FETCH_ASSOC);

        return $pageData ?: null;
    }

    /**
     * Récupère les données d'un utilisateur par son adresse e-mail.
     *
     * @param string $email L'adresse e-mail de l'utilisateur à récupérer.
     * @return array|null Les données de l'utilisateur, ou null si l'adresse e-mail n'existe pas.
     */
    public function getByEmail($email): ?array
    {
        $queryPrepared = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE email = :email");
        $queryPrepared->bindValue(':email', $email, \PDO::PARAM_STR);
        $queryPrepared->execute();

        $userData = $queryPrepared->fetch(\PDO::FETCH_ASSOC);

        return $userData ?: null;
    }

    /**
     * Mettre a jour les données de l'utilisateur par l'id
     * @param int $id
     * @return array
     */
    public function setIdValue(int $id): array
    {
        $data = $this->getById($id);
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $data;
    }

    /**
     * Enregistre un nouvel utilisateur dans la base de données.
     *
     * @param string $firstname Le prénom de l'utilisateur.
     * @param string $lastname Le nom de famille de l'utilisateur.
     * @param string $email L'adresse e-mail de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur.
     * @param string $country Le pays de l'utilisateur.
     * @param string $role Le rôle de l'utilisateur.
     * @param string $dateInserted La date d'inscription de l'utilisateur.
     * @param string $dateUpdated La date de mise à jour de l'utilisateur.
     * @return bool True si l'utilisateur est enregistré avec succès, sinon False.
     */
    public function registerUser($firstname, $lastname, $email, $password, $country, $role, $dateInserted, $dateUpdated)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table . " (firstname, lastname, email, password, country, role, date_inserted, date_updated)
              VALUES (:firstname, :lastname, :email, :password, :country, :role, :date_inserted, :date_updated)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':password', $hashedPassword, \PDO::PARAM_STR); // Utilisation du mot de passe haché
        $statement->bindValue(':country', $country, \PDO::PARAM_STR);
        $statement->bindValue(':role', $role, \PDO::PARAM_STR);
        $statement->bindValue(':date_inserted', $dateInserted, \PDO::PARAM_STR);
        $statement->bindValue(':date_updated', $dateUpdated, \PDO::PARAM_STR);

        return $statement->execute();
    }

    /**
     * Enregistre un nouvel article dans la base de données.
     *
     * @param string $title Le titre de l'article.
     * @param string $content Le contenu de l'article.
     * @param string $category La catégorie de l'article.
     * @param int $authorId L'ID de l'auteur de l'article.
     * @param string $dateInserted La date d'insertion de l'article.
     * @param string $dateUpdated La date de mise à jour de l'article.
     * @return bool True si l'article est enregistré avec succès, sinon False.
     */
    public function actionArticle($title, $content, $category, $author = null, $dateInserted = null, $dateUpdated)
    {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE title = :title";
        $parameters = [':title' => $title];

        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);
        $count = $statement->fetchColumn();

        if ($count > 0) {
            // L'article existe déjà, effectuer une mise à jour
            $query = "UPDATE " . $this->table . " SET content = :content, category = :category, date_updated = :date_updated";

            if ($author !== null) {
                $query .= ", author = :author";
            }

            if ($dateInserted !== null) {
                $query .= ", date_inserted = :date_inserted";
            }

            $query .= " WHERE title = :title";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':content', $content, \PDO::PARAM_STR);
            $statement->bindValue(':category', $category, \PDO::PARAM_STR);
            $statement->bindValue(':date_updated', $dateUpdated, \PDO::PARAM_STR);

            if ($author !== null) {
                $statement->bindValue(':author', $author, \PDO::PARAM_INT);
            }

            if ($dateInserted !== null) {
                $statement->bindValue(':date_inserted', $dateInserted, \PDO::PARAM_STR);
            }

            $statement->bindValue(':title', $title, \PDO::PARAM_STR);

            return $statement->execute();
        } else {
            // L'article n'existe pas, effectuer une insertion
            $query = "INSERT INTO " . $this->table . " (title, content, category, author, date_inserted, date_updated)
        VALUES (:title, :content, :category, :author, :date_inserted, :date_updated)";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':title', $title, \PDO::PARAM_STR);
            $statement->bindValue(':content', $content, \PDO::PARAM_STR);
            $statement->bindValue(':category', $category, \PDO::PARAM_STR);
            $statement->bindValue(':author', $author, \PDO::PARAM_INT);
            $statement->bindValue(':date_inserted', $dateInserted, \PDO::PARAM_STR);
            $statement->bindValue(':date_updated', $dateUpdated, \PDO::PARAM_STR);

            return $statement->execute();
        }
    }
}