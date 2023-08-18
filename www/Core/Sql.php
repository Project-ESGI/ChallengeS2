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
     * Vérifie si un enregistrement avec la même valeur existe déjà dans une table spécifique de la base de données.
     *
     * @param string $table Le nom de la table à vérifier.
     * @param string $column Le nom de la colonne à vérifier.
     * @param mixed $value La valeur à vérifier.
     * @param int|null $id L'ID de l'enregistrement actuel (facultatif).
     * @param int|null $authorId L'ID de l'auteur (facultatif).
     * @return bool True si un enregistrement avec la même valeur existe déjà, sinon False.
     */
    public function existsWithValue(string $table, string $column, $value, int $id = null, int $authorId = null): bool
    {
        $query = "SELECT COUNT(*) FROM " . $table . " WHERE $column = :value";
        $parameters = [':value' => $value];

        if ($id !== null) {
            $query .= " AND id <> :id";
            $parameters[':id'] = $id;
        }

        if ($authorId !== null) {
            $query .= " AND author = :authorId";
            $parameters[':authorId'] = $authorId;
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
     * Récupère toutes les valeurs de la table 'esgi_article' associées à un utilisateur spécifique.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @return array Un tableau contenant toutes les valeurs de la table 'esgi_article' associées à l'utilisateur.
     */
    public function getAllValueByUser(int $userId): array
    {
        $query = "SELECT * FROM " . $this->table . " WHERE author = :author";
        $parameters = [':author' => $userId];

        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
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
    public function setIdValue(int $id): ?array
    {
        $data = $this->getById($id);
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $data;
    }

    /**
     * Mettre à jour les données de l'utilisateur par l'id
     * @param int $id
     * @return array|null
     */
    public function setIdValueString(int $id): ?array
    {
        $data = $this->getById($id);
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if ($key === 'report' && is_null($value)) {
                    // Si la clé est "report" et sa valeur est null, définissez la propriété comme 0 (ou toute autre valeur appropriée).
                    $this->$key = 0;
                } else {
                    $this->$key = $value;
                }
            }
            return $data;
        }
        return null;
    }

    /**
     * Vérifie la présence de caractères spéciaux non autorisés dans une valeur donnée.
     *
     * @param string $value La valeur à vérifier.
     * @param string $name Le nom de l'input associé à la valeur.
     * @return array Tableau des champs invalides contenant des caractères spéciaux non autorisés.
     */
    function checkSpecialCharacters($value, $name)
    {
        $invalidFields = [];
        $specialChars = array('/', '*', '+', '°', '$', '#', '!', '&', '%', '^', '(', ')', '[', ']', '{', '}', '=', '<', '>', '~', '`', ':', ';', '|', '@', '\\');

        if ($name === 'email' || $name === 'confirm_email') {
            $specialChars = array_diff($specialChars, ['@']);
        }
        $countDashes = substr_count($value, '-');
        if ($countDashes > 1 || (strlen($value) > 1 && $value[0] === '-' && $value[strlen($value) - 1] === '-')) {
            $invalidFields[] = $value;
        } else {
            foreach ($specialChars as $char) {
                if (strpos($value, $char) !== false) {
                    $invalidFields[] = $value;
                    break;
                }
            }
        }

        return $invalidFields;
    }

    /**
     * Enregistre un nouvel utilisateur dans la base de données ou met à jour un utilisateur existant.
     *
     * @param int|null $id L'ID de l'utilisateur (facultatif).
     * @param string $firstname Le prénom de l'utilisateur.
     * @param string $lastname Le nom de famille de l'utilisateur.
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @param string|null $email L'adresse e-mail de l'utilisateur (facultatif).
     * @param string|null $password Le mot de passe de l'utilisateur (facultatif).
     * @param string $country Le pays de l'utilisateur.
     * @param string $role Le rôle de l'utilisateur.
     * @param string|null $dateInserted La date d'inscription de l'utilisateur (facultatif).
     * @param string $dateUpdated La date de mise à jour de l'utilisateur.
     * @return bool True si l'utilisateur est enregistré ou mis à jour avec succès, sinon False.
     */
    public function saveUser($id = null, $firstname, $lastname, $pseudo, $email = null, $password = null, $country, $role, $dateInserted = null, $dateUpdated)
    {
        $hashedPassword = null;
        $passwordParam = null;
        if ($password !== null) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $passwordParam = ':password';
        }

        if ($id !== null) {
            $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            $statement->execute();
            $count = $statement->fetchColumn();

            if ($count > 0) {
                // L'utilisateur existe déjà, effectuer une mise à jour
                $query = "UPDATE " . $this->table . " SET firstname = :firstname, lastname = :lastname, pseudo = :pseudo";

                if ($email !== null) {
                    $query .= ", email = :email";
                }

                if ($passwordParam !== null) {
                    $query .= ", password = CASE WHEN $passwordParam IS NOT NULL THEN $passwordParam ELSE password END";
                }

                $query .= ", country = :country, role = :role, date_updated = :date_updated";

                if ($dateInserted !== null) {
                    $query .= ", date_inserted = :date_inserted";
                }

                $query .= " WHERE id = :id";

                $statement = $this->pdo->prepare($query);
                $statement->bindValue(':id', $id, \PDO::PARAM_INT);
                $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
                $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
                $statement->bindValue(':pseudo', $pseudo, \PDO::PARAM_STR);

                if ($email !== null) {
                    $statement->bindValue(':email', $email, \PDO::PARAM_STR);
                }

                if ($passwordParam !== null) {
                    $statement->bindValue(':password', $hashedPassword, \PDO::PARAM_STR);
                }

                $statement->bindValue(':country', $country, \PDO::PARAM_STR);
                $statement->bindValue(':role', $role, \PDO::PARAM_STR);
                $statement->bindValue(':date_updated', $dateUpdated, \PDO::PARAM_STR);

                if ($dateInserted !== null) {
                    $statement->bindValue(':date_inserted', $dateInserted, \PDO::PARAM_STR);
                }

                return $statement->execute();
            }
        }

        // L'utilisateur n'existe pas ou l'ID est null, effectuer une insertion
        $query = "INSERT INTO " . $this->table . " (id, firstname, lastname, pseudo, email, password, country, role, date_inserted, date_updated)
        VALUES (DEFAULT, :firstname, :lastname, :pseudo, :email, :password, :country, :role, :date_inserted, :date_updated)";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->bindValue(':pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':password', $hashedPassword, \PDO::PARAM_STR);
        $statement->bindValue(':country', $country, \PDO::PARAM_STR);
        $statement->bindValue(':role', $role, \PDO::PARAM_STR);
        $statement->bindValue(':date_inserted', $dateInserted, \PDO::PARAM_STR);
        $statement->bindValue(':date_updated', $dateUpdated, \PDO::PARAM_STR);

        return $statement->execute();
    }


    /**
     * Effectue la création d'un nouvel article ou met à jour un article existant dans la base de données.
     *
     * @param null $id L'ID de l'article.
     * @param string $title Le titre de l'article.
     * @param string $slug Le slug de l'article.
     * @param string $content Le contenu de l'article.
     * @param string $category La catégorie de l'article.
     * @param null $author L'id de l'auteur de l'article.
     * @param null $dateInserted La date d'insertion de l'article.
     * @param string $dateUpdated La date de mise à jour de l'article.
     * @return bool True si l'article est enregistré avec succès, sinon False.
     */
    public function actionArticle($id = null, $title, $slug, $content, $category, $author = null, $dateInserted = null, $dateUpdated)
    {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE id = :id";
        $parameters = [':id' => $id];

        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);
        $count = $statement->fetchColumn();

        if ($count > 0) {
            // L'article existe déjà, effectuer une mise à jour
            $query = "UPDATE " . $this->table . " SET title = :title, slug = :slug, content = :content, category = :category, date_updated = :date_updated";

            if ($author !== null) {
                $query .= ", author = :author";
            }

            if ($dateInserted !== null) {
                $query .= ", date_inserted = :date_inserted";
            }

            $query .= " WHERE id = :id";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':title', $title, \PDO::PARAM_STR);
            $statement->bindValue(':slug', $slug, \PDO::PARAM_STR);
            $statement->bindValue(':content', $content, \PDO::PARAM_STR);
            $statement->bindValue(':category', $category, \PDO::PARAM_STR);
            $statement->bindValue(':date_updated', $dateUpdated, \PDO::PARAM_STR);

            if ($author !== null) {
                $statement->bindValue(':author', $author, \PDO::PARAM_INT);
            }

            if ($dateInserted !== null) {
                $statement->bindValue(':date_inserted', $dateInserted, \PDO::PARAM_STR);
            }

            $statement->bindValue(':id', $id, \PDO::PARAM_INT);

            return $statement->execute();
        } else {
            // L'article n'existe pas, effectuer une insertion
            $query = "INSERT INTO " . $this->table . " (title, slug, content, category, author, date_inserted, date_updated)
        VALUES (:title, :slug, :content, :category, :author, :date_inserted, :date_updated)";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':title', $title, \PDO::PARAM_STR);
            $statement->bindValue(':slug', $slug, \PDO::PARAM_STR);
            $statement->bindValue(':content', $content, \PDO::PARAM_STR);
            $statement->bindValue(':category', $category, \PDO::PARAM_STR);
            $statement->bindValue(':author', $author, \PDO::PARAM_INT);
            $statement->bindValue(':date_inserted', $dateInserted, \PDO::PARAM_STR);
            $statement->bindValue(':date_updated', $dateUpdated, \PDO::PARAM_STR);

            return $statement->execute();
        }
    }

    /**
     * Sauvegarde un commentaire dans la base de données. Effectue une mise à jour si l'ID existe déjà, sinon effectue une insertion.
     *
     * @param int|null $id L'ID du commentaire à sauvegarder (facultatif).
     * @param string $content Le contenu du commentaire.
     * @param int $author L'ID de l'auteur du commentaire.
     * @param string|null $dateInserted La date d'insertion du commentaire (facultatif).
     * @param string $dateUpdated La date de mise à jour du commentaire.
     * @return bool True en cas de succès, False en cas d'échec.
     */
    public function saveCommentaire($id = null, $content, $author, $dateInserted = null, $dateUpdated)
    {
        // Vérifier si le commentaire existe déjà en comptant le nombre d'occurrences avec l'ID fourni
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE id = :id";
        $parameters = [':id' => $id];

        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);
        $count = $statement->fetchColumn();

        if ($count > 0) {
            // Le commentaire existe déjà, effectuer une mise à jour

            // Requête SQL pour la mise à jour du commentaire
            $query = "UPDATE " . $this->table . " SET content = :content, author = :author, date_updated = :date_updated";

            // Vérifier si la date d'insertion est fournie
            if ($dateInserted !== null) {
                $query .= ", date_inserted = :date_inserted";
            }

            $query .= " WHERE id = :id";

            // Préparation de la requête
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':content', $content, \PDO::PARAM_STR);
            $statement->bindValue(':author', $author, \PDO::PARAM_INT);
            $statement->bindValue(':date_updated', $dateUpdated, \PDO::PARAM_STR);

            // Vérifier si la date d'insertion est fournie et la lier à la requête
            if ($dateInserted !== null) {
                $statement->bindValue(':date_inserted', $dateInserted, \PDO::PARAM_STR);
            }

            $statement->bindValue(':id', $id, \PDO::PARAM_INT);

            // Exécuter la mise à jour et retourner le résultat
            return $statement->execute();
        } else {
            // Le commentaire n'existe pas, effectuer une insertion

            // Requête SQL pour l'insertion du commentaire
            $query = "INSERT INTO " . $this->table . " (content, author, date_inserted, date_updated)
                  VALUES (:content, :author, :date_inserted, :date_updated)";

            // Préparation de la requête
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':content', $content, \PDO::PARAM_STR);
            $statement->bindValue(':author', $author, \PDO::PARAM_INT);

            // Vérifier si la date d'insertion est fournie et la lier à la requête
            if ($dateInserted !== null) {
                $statement->bindValue(':date_inserted', $dateInserted, \PDO::PARAM_STR);
            }

            $statement->bindValue(':date_updated', $dateUpdated, \PDO::PARAM_STR);

            // Exécuter l'insertion et retourner le résultat
            return $statement->execute();
        }
    }

    /**
     * Vérifie si le texte contient des mots vulgaires.
     *
     * @param string $texte Le texte à vérifier.
     * @return bool True si des mots vulgaires sont présents, sinon False.
     */
    function reportTrue($texte)
    {
        $motsVulgaires = array("mot1", "mot2", "mot3");

        $texte = strtolower($texte);

        foreach ($motsVulgaires as $mot) {
            if (strpos($texte, $mot) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Vérifie si un signalement existe déjà pour le commentaire et l'utilisateur actuel.
     *
     * @return bool True si un signalement existe, sinon False.
     */
    public function existeSignalement()
    {
        $query = "SELECT COUNT(*) FROM esgi_signalement WHERE comment_id = :commentId AND user_id = :userId";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':commentId', $this->comment_id, \PDO::PARAM_INT);
        $statement->bindValue(':userId', $this->user_id, \PDO::PARAM_INT);
        $statement->execute();
        $count = $statement->fetchColumn();

        return $count > 0;
    }

    /**
     * Supprime les signalements par ID de commentaire.
     *
     * @param int $commentId L'ID du commentaire.
     * @return void
     */
    public function deleteByCommentId($commentId)
    {
        $query = "DELETE FROM esgi_signalement WHERE comment_id = :comment_id";
        $params = array(':comment_id' => $commentId);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    }

    /**
     * Supprime les enregistrements associés à un auteur par son ID.
     *
     * @param int $authorId L'ID de l'auteur.
     * @return void
     */
    public function deleteByAuthor($authorId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE author = :author";
        $params = array(':author' => $authorId);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    }

    /**
     * Supprime les signalements associés aux commentaires d'un auteur par son ID.
     *
     * @param int $author L'ID de l'auteur.
     * @return void
     */
    public function deleteByCommentAuthor($author)
    {
        $query = "DELETE FROM esgi_signalement WHERE comment_id IN (SELECT id FROM esgi_comment WHERE author = :author)";
        $params = array(':author' => $author);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    }

    /**
     * Supprime les signalements associés à un utilisateur par son ID.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @return void
     */
    public function deleteByUserId($userId)
    {
        $query = "DELETE FROM esgi_signalement WHERE user_id = :user_id";
        $params = array(':user_id' => $userId);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    }

    /**
     * Récupère un article par son slug et l'ID de l'auteur.
     *
     * @param string $slug Le slug de l'article.
     * @param int|null $author L'ID de l'auteur (facultatif).
     * @return array|null Les données de l'article, ou null si l'article n'existe pas ou n'appartient pas à l'auteur.
     */
    public function getBySlug($slug, int $author = null): ?array
    {
        $query = "SELECT * FROM esgi_article WHERE slug = :slug";
        $parameters = [':slug' => $slug];

        if ($author !== null) {
            $query .= " AND author = :author";
            $parameters[':author'] = $author;
        }

        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);

        return $statement->fetch(\PDO::FETCH_ASSOC) ?: null;
    }


    /**
     * Récupère tous les slugs des articles associés à un utilisateur spécifique.
     *
     * @param int $id L'ID de l'utilisateur pour lequel récupérer les slugs.
     * @return array Un tableau contenant tous les slugs associés à l'utilisateur.
     */
    public function getAllSlug($id)
    {
        $query = "SELECT slug FROM esgi_article WHERE author = :id";

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();

        $slugs = $statement->fetchAll(\PDO::FETCH_COLUMN);

        return $slugs;
    }
}
