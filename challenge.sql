-- Adminer 4.8.1 PostgreSQL 15.2 (Debian 15.2-1.pgdg110+1) dump

DROP TABLE IF EXISTS "esgi_article";
DROP SEQUENCE IF EXISTS esgi_article_id_seq;
CREATE SEQUENCE esgi_article_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."esgi_article" (
    "id" integer DEFAULT nextval('esgi_article_id_seq') NOT NULL,
    "title" character varying NOT NULL,
    "content" text NOT NULL,
    "author" integer NOT NULL,
    "category" character varying NOT NULL,
    "date_inserted" timestamp NOT NULL,
    "date_updated" timestamp NOT NULL,
    CONSTRAINT "esgi_article_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_article" ("id", "title", "content", "author", "category", "date_inserted", "date_updated") VALUES
(26,	'Test',	'Contenu de mon article ! ',	4,	'Match entrainement',	'2023-07-12 10:16:46',	'2023-07-12 12:43:35'),
(40,	'Test2',	'Contenu de mon article ! ',	4,	'Match entrainement',	'2023-07-12 10:16:46',	'2023-07-12 12:43:35');

DROP TABLE IF EXISTS "esgi_commentaire";
DROP SEQUENCE IF EXISTS esgi_commentaire_id_seq;
CREATE SEQUENCE esgi_commentaire_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."esgi_commentaire" (
    "id" integer DEFAULT nextval('esgi_commentaire_id_seq') NOT NULL,
    "content" text NOT NULL,
    "answer" character varying NOT NULL,
    "date_inserted" timestamp NOT NULL,
    "date_updated" timestamp NOT NULL,
    "author" integer NOT NULL,
    "report" integer,
    CONSTRAINT "esgi_commentaire_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_commentaire" ("id", "content", "answer", "date_inserted", "date_updated", "author", "report") VALUES
(9,	'J''ai vu le match de mbappé !',	'',	'2023-07-05 16:56:26.414152',	'2023-07-05 16:56:26.414152',	4,	3),
(14,	'J''ai vu le match de mbappé !',	'',	'2023-07-05 16:56:26.414152',	'2023-07-05 16:56:26.414152',	4,	3),
(12,	'new comment',	'',	'2023-07-05 16:56:26.414152',	'2023-07-05 16:56:26.414152',	4,	3);

DROP TABLE IF EXISTS "esgi_signalement";
DROP SEQUENCE IF EXISTS esgi_signalement_id_seq;
CREATE SEQUENCE esgi_signalement_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."esgi_signalement" (
    "id" integer DEFAULT nextval('esgi_signalement_id_seq') NOT NULL,
    "comment_id" integer NOT NULL,
    "user_id" integer NOT NULL,
    "date_inserted" time without time zone NOT NULL,
    CONSTRAINT "esgi_signalement_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_signalement" ("id", "comment_id", "user_id", "date_inserted") VALUES
(2,	9,	4,	'16:50:39'),
(10,	14,	4,	'17:13:42'),
(11,	12,	4,	'17:14:26'),
(13,	12,	12,	'17:15:51');

DROP TABLE IF EXISTS "esgi_user";
DROP SEQUENCE IF EXISTS esgi_users_idfrf_seq;
CREATE SEQUENCE esgi_users_idfrf_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."esgi_user" (
    "id" integer DEFAULT nextval('esgi_users_idfrf_seq') NOT NULL,
    "firstname" character varying(48) NOT NULL,
    "lastname" character varying(48) NOT NULL,
    "email" character varying(320) NOT NULL,
    "date_inserted" timestamp NOT NULL,
    "date_updated" timestamp NOT NULL,
    "country" character(2) NOT NULL,
    "password" character varying NOT NULL,
    "role" character varying,
    CONSTRAINT "esgi_users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_user" ("id", "firstname", "lastname", "email", "date_inserted", "date_updated", "country", "password", "role") VALUES
(4,	'Prénom',	'NomFamille',	'melvinpierre283@gmail.com',	'2023-06-30 12:49:49',	'2023-06-30 12:49:49',	'FR',	'$2y$10$BHlftqySaKME3R9vaI4m4u8Fez46votPazstT3a3uC09/x/.PrCEa',	'admin'),
(12,	'Prénom',	'NomFamille',	'melvinpierre@gmail.com',	'2023-06-30 12:49:49',	'2023-06-30 12:49:49',	'FR',	'$2y$10$BHlftqySaKME3R9vaI4m4u8Fez46votPazstT3a3uC09/x/.PrCEa',	'admin');

ALTER TABLE ONLY "public"."esgi_article" ADD CONSTRAINT "esgi_article_author_fkey" FOREIGN KEY (author) REFERENCES esgi_user(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."esgi_commentaire" ADD CONSTRAINT "esgi_commentaire_author_fkey" FOREIGN KEY (author) REFERENCES esgi_user(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."esgi_signalement" ADD CONSTRAINT "esgi_signalement_comment_id_fkey" FOREIGN KEY (comment_id) REFERENCES esgi_commentaire(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."esgi_signalement" ADD CONSTRAINT "esgi_signalement_user_id_fkey" FOREIGN KEY (user_id) REFERENCES esgi_user(id) NOT DEFERRABLE;

-- 2023-07-12 16:00:07.779178+00
