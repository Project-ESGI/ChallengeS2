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
(12,	't',	'u',	1,	'Match entrainement',	'2023-06-29 10:55:36',	'2023-06-30 08:01:37'),
(23,	'iehit',	'do',	4,	'Exercice',	'2023-07-04 15:58:25',	'2023-07-04 18:19:16');

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
    CONSTRAINT "esgi_commentaire_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_commentaire" ("id", "content", "answer", "date_inserted", "date_updated", "author") VALUES
(1,	'J''ai vu le match de mbappé !',	'',	'2023-07-05 16:56:26.414152',	'2023-07-05 16:56:26.414152',	4);

DROP TABLE IF EXISTS "esgi_page";
DROP SEQUENCE IF EXISTS "Page_id_seq";
CREATE SEQUENCE "Page_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."esgi_page" (
    "id" integer DEFAULT nextval('"Page_id_seq"') NOT NULL,
    "title" character varying(48) NOT NULL,
    "date_inserted" date,
    "date_updated" date,
    CONSTRAINT "Page_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_page" ("id", "title", "date_inserted", "date_updated") VALUES
(1,	'h',	'2023-06-29',	'2023-06-29');

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
    "banned" boolean,
    "password" character varying NOT NULL,
    "role" character varying,
    CONSTRAINT "esgi_users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_user" ("id", "firstname", "lastname", "email", "date_inserted", "date_updated", "country", "banned", "password", "role") VALUES
(1,	'Test',	'Test',	'Test@email.com',	'2023-06-29 08:54:35.26107',	'2023-06-29 08:54:35.26107',	'Fr',	'f',	'knvijerberh',	'admin'),
(3,	'Mpfvjibhi',	'NVIOEHFBOIFE',	'dzneiohei@gmail',	'2023-06-30 12:46:12',	'2023-06-30 12:46:12',	'FR',	NULL,	'$2y$10$Uv0Y3fJ2V0wM62Xh4dYOZe2SarJBsMX.qfA7wmgCXSiB2j.ibmIuy',	NULL),
(5,	'Seoh',	'NBTBROI',	'bitijt@gmail',	'2023-07-03 00:00:00',	'2023-07-03 00:00:00',	'PL',	NULL,	'$2y$10$rwa8G69gU.gxN3N1DEl4pujFD95xDxhwJnjZuLHAwWz2aAYqDp2Vq',	NULL),
(4,	'Prénom',	'NomFamille',	'melvinpierre283@gmail.com',	'2023-06-30 12:49:49',	'2023-06-30 12:49:49',	'FR',	NULL,	'$2y$10$BHlftqySaKME3R9vaI4m4u8Fez46votPazstT3a3uC09/x/.PrCEa',	'admin');

ALTER TABLE ONLY "public"."esgi_article" ADD CONSTRAINT "esgi_article_author_fkey" FOREIGN KEY (author) REFERENCES esgi_user(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."esgi_commentaire" ADD CONSTRAINT "esgi_commentaire_author_fkey" FOREIGN KEY (author) REFERENCES esgi_user(id) NOT DEFERRABLE;