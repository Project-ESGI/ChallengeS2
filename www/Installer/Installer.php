<?php

namespace App\Installer;

use PDO;

class Installer
{
    /**
     * @var PDO
     */
    private $pdo;

    private $queries = [];

    public function getConnection($url, $username, $password)
    {
        try {
            $this->pdo = new \PDO($url, $username, $password);
        } catch (\Exception $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }

    public function execQuery($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function executeQueries()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['step'] === '2') {
                $dbServer = $_POST['db_server'];
                $dbPort = $_POST['db_port'];
                $dbPort = 5432;
                $dbName = $_POST['db_name'];
                $dbUser = $_POST['db_user'];
                $dbPwd = $_POST['db_pass'];
                $adminEmail = $_POST['admin_email'];
                $adminPass = sha1($_POST['admin_pass']);

                $url = "pgsql:host={$dbServer};port={$dbPort};dbname=postgres";
                $this->getConnection($url, $dbUser, $dbPwd);

                $res = $this->execQuery(
                    "SELECT 'CREATE DATABASE ' as query
                     WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = :db)",
                    ['db' => $dbName]
                );
                if (!empty($res)) {
                    $this->execQuery(
                        $res[0]['query'] . $dbName
                    );
                }

                $newDbUrl = "pgsql:host={$dbServer};port={$dbPort};dbname={$dbName}";
                $this->getConnection($newDbUrl, $dbUser, $dbPwd);

                $this->execQuery('DROP TABLE IF EXISTS "esgi_article";');
                $this->execQuery('DROP SEQUENCE IF EXISTS esgi_article_id_seq;');
                $this->execQuery('CREATE SEQUENCE esgi_article_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;');
                $this->execQuery('CREATE TABLE "public"."esgi_article" (
                "id" integer DEFAULT nextval(\'esgi_article_id_seq\') NOT NULL,
                "title" character varying NOT NULL,
                "content" text NOT NULL,
                "author" integer NOT NULL,
                "category" character varying NOT NULL,
                "date_inserted" timestamp DEFAULT CURRENT_TIMESTAMP,
                "date_updated" timestamp NOT NULL,
                "slug" character varying,
                CONSTRAINT "esgi_article_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);');
                $this->execQuery('DROP TABLE IF EXISTS "esgi_signalement";');
                $this->execQuery('DROP SEQUENCE IF EXISTS esgi_signalement_id_seq;');
                $this->execQuery('CREATE SEQUENCE esgi_signalement_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;');
                $this->execQuery('CREATE TABLE "public"."esgi_signalement" (
                "id" integer DEFAULT nextval(\'esgi_signalement_id_seq\') NOT NULL,
                "comment_id" integer NOT NULL,
                "user_id" integer NOT NULL,
                "date_inserted" time without time zone NOT NULL,
                CONSTRAINT "esgi_signalement_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);');
                $this->execQuery('DROP TABLE IF EXISTS "esgi_comment";');
                $this->execQuery('DROP SEQUENCE IF EXISTS esgi_commentaire_id_seq;');
                $this->execQuery('CREATE SEQUENCE esgi_commentaire_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;');
                $this->execQuery('CREATE TABLE "public"."esgi_comment" (
                "id" integer DEFAULT nextval(\'esgi_commentaire_id_seq\') NOT NULL,
                "content" text NOT NULL,
                "date_inserted" timestamp NOT NULL,
                "date_updated" timestamp NOT NULL,
                "author" integer NOT NULL,
                "report" integer,
                CONSTRAINT "esgi_commentaire_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);');
                $this->execQuery('DROP TABLE IF EXISTS "esgi_user";');
                $this->execQuery('DROP SEQUENCE IF EXISTS esgi_users_idfrf_seq;');
                $this->execQuery('CREATE SEQUENCE esgi_users_idfrf_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;');
                $this->execQuery('CREATE TABLE "public"."esgi_user" (
                "id" integer DEFAULT nextval(\'esgi_users_idfrf_seq\') NOT NULL,
                "firstname" character varying(48) NOT NULL,
                "lastname" character varying(48) NOT NULL,
                "email" character varying(320) NOT NULL,
                "date_inserted" timestamp NOT NULL,
                "date_updated" timestamp NOT NULL,
                "country" character(2) NOT NULL,
                "password" character varying NOT NULL,
                "role" character varying NOT NULL,
                "pseudo" character varying NOT NULL,
                CONSTRAINT "esgi_users_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);');
                $this->execQuery('ALTER TABLE ONLY "public"."esgi_comment" ADD CONSTRAINT "esgi_commentaire_author_fkey" FOREIGN KEY (author) REFERENCES esgi_user(id) NOT DEFERRABLE;');
                $this->execQuery('ALTER TABLE ONLY "public"."esgi_signalement" ADD CONSTRAINT "esgi_signalement_comment_id_fkey" FOREIGN KEY (comment_id) REFERENCES esgi_comment(id) NOT DEFERRABLE;');
                $this->execQuery('ALTER TABLE ONLY "public"."esgi_signalement" ADD CONSTRAINT "esgi_signalement_user_id_fkey" FOREIGN KEY (user_id) REFERENCES esgi_user(id) NOT DEFERRABLE;');
                $this->execQuery("INSERT INTO \"public\".\"esgi_user\" (\"firstname\", \"lastname\", \"email\", \"date_inserted\", \"date_updated\", \"country\", \"password\", \"role\", \"pseudo\") VALUES ('Admin', 'Admin', '$adminEmail', now(), now(), 'FR', '$adminPass', 'admin', 'admin');");

            }
        }
        header('Location: login');
    }

    public function installation()
    {
        $this->executeQueries();
        yaml_emit($this->queries);
    }

}