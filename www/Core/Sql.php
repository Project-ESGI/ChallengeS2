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
     * Sauvegarde l'objet en base de données.
     */
    public function save(): void
    {
        $columns = get_object_vars($this);
        $columnsToDeleted = get_class_vars(get_class());
        $columns = array_diff_key($columns, $columnsToDeleted);
        unset($columns["id"]);

        if ($this->getId() !== 0) {
            // Mise à jour des données
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
     * @param string $title Le titre à vérifier.
     * @param int|null $id L'ID de l'enregistrement actuel (facultatif).
     * @return bool True si un enregistrement avec le même titre existe déjà, sinon False.
     */
    public function existsWithFirstname(string $firstname, int $id = null): bool
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
     * @param int $id
     */
    public function setIdValue(int $id): array //Mettre à jour les valeurs pour l'id
    {
        $data = $this->getById($id);
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $data;
    }
}