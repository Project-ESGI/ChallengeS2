-- Adminer 4.8.1 PostgreSQL 15.3 (Debian 15.3-1.pgdg110+1) dump

DROP TABLE IF EXISTS "esgi_article";
DROP SEQUENCE IF EXISTS esgi_article_id_seq;
CREATE SEQUENCE esgi_article_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."esgi_article" (
    "id" integer DEFAULT nextval('esgi_article_id_seq') NOT NULL,
    "title" character varying NOT NULL,
    "content" text NOT NULL,
    "author" integer NOT NULL,
    "category" character varying NOT NULL,
    "date_inserted" timestamp DEFAULT CURRENT_TIMESTAMP,
    "date_updated" timestamp NOT NULL,
    "slug" character varying,
    CONSTRAINT "esgi_article_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_article" ("id", "title", "content", "author", "category", "date_inserted", "date_updated", "slug") VALUES
(1,	'Préparation entrainement session1',	'<p>Article 1: Exercices d&#39;entra&icirc;nement pour am&eacute;liorer votre jeu de football</p>

<p>Le football est un sport exigeant qui n&eacute;cessite une combinaison de comp&eacute;tences techniques, tactiques et physiques. Pour am&eacute;liorer votre jeu, il est essentiel de s&#39;entra&icirc;ner r&eacute;guli&egrave;rement et de mani&egrave;re cibl&eacute;e. Voici trois exercices d&#39;entra&icirc;nement qui vous aideront &agrave; d&eacute;velopper vos comp&eacute;tences en football :</p>

<ol>
	<li>
	<p>Contr&ocirc;le du ballon avec le pied et la poitrine :</p>

	<ul>
		<li>Placez-vous face &agrave; un mur et faites rebondir le ballon contre celui-ci.</li>
		<li>Contr&ocirc;lez le ballon avec l&#39;int&eacute;rieur du pied et ensuite avec votre poitrine.</li>
		<li>Essayez de garder le ballon proche de vous en utilisant des touches l&eacute;g&egrave;res.</li>
	</ul>
	</li>
	<li>
	<p>Passe et d&eacute;placement :</p>

	<ul>
		<li>Formez un petit groupe avec des co&eacute;quipiers.</li>
		<li>Passez le ballon rapidement entre vous en utilisant des passes courtes et pr&eacute;cises.</li>
		<li>D&eacute;placez-vous constamment pour offrir des options de passe &agrave; vos co&eacute;quipiers.</li>
	</ul>
	</li>
	<li>
	<p>Dribble et finition :</p>

	<ul>
		<li>Mettez en place un parcours d&#39;obstacles avec des c&ocirc;nes.</li>
		<li>Dribblez rapidement &agrave; travers les obstacles en utilisant des feintes et des changements de direction.</li>
		<li>Une fois que vous atteignez la fin du parcours, tirez au but avec pr&eacute;cision.</li>
	</ul>
	</li>
</ol>

<p>En vous entra&icirc;nant r&eacute;guli&egrave;rement avec ces exercices, vous d&eacute;velopperez vos comp&eacute;tences techniques, votre agilit&eacute; et votre prise de d&eacute;cision sur le terrain. N&#39;oubliez pas de rester concentr&eacute; et pers&eacute;v&eacute;rant, car l&#39;am&eacute;lioration n&eacute;cessite du temps et de l&#39;effort.</p>
',	12,	'Exercice',	'2023-07-21 01:56:40',	'2023-07-21 01:57:30',	'Mbappe'),
(3,	'Ligue des champions',	'<p>Article 2: La Ligue des Champions - Une comp&eacute;tition de football l&eacute;gendaire</p>

<p>La Ligue des Champions, &eacute;galement connue sous le nom de Champions League, est l&#39;une des comp&eacute;titions de football les plus prestigieuses et les plus suivies au monde. Organis&eacute;e par l&#39;Union des associations europ&eacute;ennes de football (UEFA), cette comp&eacute;tition rassemble les meilleures &eacute;quipes de clubs d&#39;Europe qui s&#39;affrontent pour d&eacute;crocher le titre de champion.</p>

<p>La Ligue des Champions se d&eacute;roule en plusieurs phases, commen&ccedil;ant par une phase de groupes o&ugrave; les &eacute;quipes sont r&eacute;parties en groupes et se rencontrent en matches aller-retour. Les meilleures &eacute;quipes de chaque groupe progressent ensuite vers les phases &agrave; &eacute;limination directe, notamment les huiti&egrave;mes de finale, les quarts de finale, les demi-finales et enfin, la finale.</p>

<p>La finale de la Ligue des Champions est un &eacute;v&eacute;nement majeur dans le monde du football, attirant l&#39;attention des fans du monde entier. Les grands stades europ&eacute;ens sont le th&eacute;&acirc;tre de ces finales &eacute;piques o&ugrave; les &eacute;quipes rivalisent pour atteindre l&#39;apog&eacute;e du succ&egrave;s.</p>

<p>Remporter la Ligue des Champions est l&#39;accomplissement ultime pour un club de football, et cela leur donne &eacute;galement la qualification pour la Supercoupe de l&#39;UEFA et la Coupe du monde des clubs de la FIFA.</p>

<p>Chaque saison de la Ligue des Champions apporte son lot de moments de gloire, de surprises et de performances &eacute;poustouflantes qui restent grav&eacute;s dans l&#39;histoire du football. Les grands noms du football laissent leur marque, tandis que de nouveaux talents &eacute;mergent et se font conna&icirc;tre sur la sc&egrave;ne mondiale.</p>

<p>Article 3: Les prochains tournois organis&eacute;s par notre club de football</p>

<p>Notre club de football est fier d&#39;annoncer les prochains tournois excitants que nous organisons pour les joueurs de tous les niveaux et de tous les &acirc;ges. Ces tournois offrent une occasion unique de vivre des exp&eacute;riences footballistiques inoubliables et de rivaliser avec d&#39;autres &eacute;quipes passionn&eacute;es.</p>
',	12,	'Compétition',	'2023-07-21 02:24:50',	'2023-07-21 02:24:50',	'MbappeK'),
(4,	'Tournois du club',	'<ol>
	<li>
	<p>Tournoi de jeunes talents :</p>

	<ul>
		<li>Date : 15 ao&ucirc;t 2023</li>
		<li>Cat&eacute;gories d&#39;&acirc;ge : U-10, U-12, U-14</li>
		<li>Lieu : Stade du club</li>
		<li>Ce tournoi mettra en vedette les jeunes talents de la r&eacute;gion et leur permettra de montrer leurs comp&eacute;tences sur le terrain. Des scouts seront pr&eacute;sents pour rep&eacute;rer les futurs espoirs du football.</li>
	</ul>
	</li>
	<li>
	<p>Tournoi amical des v&eacute;t&eacute;rans :</p>

	<ul>
		<li>Date : 1er septembre 2023</li>
		<li>Cat&eacute;gories d&#39;&acirc;ge : 35 ans et plus</li>
		<li>Lieu : Terrain de football local</li>
		<li>Les anciens joueurs et les passionn&eacute;s de football se retrouveront pour un tournoi amical. Cet &eacute;v&eacute;nement promet des moments de camaraderie, de comp&eacute;tition amusante et de souvenirs partag&eacute;s.</li>
	</ul>
	</li>
	<li>
	<p>Tournoi de pr&eacute;paration de la saison :</p>

	<ul>
		<li>Date : 25 septembre 2023</li>
		<li>Cat&eacute;gories d&#39;&acirc;ge : U-16, U-18, Seniors</li>
		<li>Lieu : Stade du club</li>
		<li>Ce tournoi marquera le d&eacute;but de la nouvelle saison de football. Les &eacute;quipes se pr&eacute;pareront pour la comp&eacute;tition &agrave; venir en affrontant des adversaires de qualit&eacute;.</li>
	</ul>
	</li>
</ol>

<p>Chaque tournoi sera organis&eacute; avec une attention particuli&egrave;re &agrave; la s&eacute;curit&eacute;, au fair-play et &agrave; l&#39;esprit sportif. Nous invitons chaleureusement tous les passionn&eacute;s de football &agrave; se joindre &agrave; nous pour ces &eacute;v&eacute;nements excitants. Que vous soyez joueur, spectateur ou simplement un amoureux du sport, vous &ecirc;tes les bienvenus</p>
',	12,	'Tournoi',	'2023-07-21 02:26:10',	'2023-07-21 02:26:10',	'MbappeKo');

DROP TABLE IF EXISTS "esgi_commentaire";
DROP SEQUENCE IF EXISTS esgi_commentaire_id_seq;
CREATE SEQUENCE esgi_commentaire_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."esgi_commentaire" (
    "id" integer DEFAULT nextval('esgi_commentaire_id_seq') NOT NULL,
    "content" text NOT NULL,
    "date_inserted" timestamp NOT NULL,
    "date_updated" timestamp NOT NULL,
    "author" integer NOT NULL,
    "report" integer,
    CONSTRAINT "esgi_commentaire_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_commentaire" ("id", "content", "date_inserted", "date_updated", "author", "report") VALUES
(1,	'La Ligue des Champions est tout simplement incroyable ! J''attends toujours avec impatience chaque saison pour voir les meilleures équipes d''Europe s''affronter. La compétition est remplie de suspense, de retournements de situation et de moments inoubliables. J''espère vivre un jour l''expérience d''assister à la finale en direct. Allez le football',	'2023-07-21 02:32:27',	'2023-07-21 02:32:27',	24,	NULL),
(2,	'Super article ! Les exercices proposés sont vraiment intéressants et vont m''aider à améliorer mes compétences en football. J''ai toujours eu du mal avec le contrôle du ballon, mais je vais certainement essayer l''exercice de contrôle avec la poitrine. Merci pour les conseils utiles !"',	'2023-07-21 02:33:36',	'2023-07-21 02:33:36',	23,	NULL),
(3,	'Ces prochains tournois semblent passionnants ! J''ai hâte de participer au tournoi de jeunes talents avec mon fils qui joue dans la catégorie U-12. C''est une excellente occasion pour lui de montrer ses compétences et peut-être de se faire remarquer par des recruteurs. Merci à notre club de football pour ces opportunités de compétition et de développement des jeunes talents."',	'2023-07-21 02:35:02',	'2023-07-21 02:35:02',	25,	NULL);

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
    "role" character varying NOT NULL,
    "pseudo" character varying NOT NULL,
    CONSTRAINT "esgi_users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "esgi_user" ("id", "firstname", "lastname", "email", "date_inserted", "date_updated", "country", "password", "role", "pseudo") VALUES
(4,	'Melvin',	'Pierre',	'melvin.pierre.mp@gmail.com',	'2023-06-30 12:49:49',	'2023-07-19 14:15:05',	'FR',	'$2y$10$BHlftqySaKME3R9vaI4m4u8Fez46votPazstT3a3uC09/x/.PrCEa',	'admin',	'maloss'),
(12,	'Jack-Sam',	'mbappé',	'jacksam@outlook.fr',	'2023-06-30 12:49:49',	'2023-07-19 14:15:15',	'FR',	'$2y$10$BHlftqySaKME3R9vaI4m4u8Fez46votPazstT3a3uC09/x/.PrCEa',	'admin',	'jambappe'),
(23,	'Paul',	'Becue',	'jacksamdu12@outlook.fr',	'2023-07-21 00:00:00',	'2023-07-21 00:00:00',	'FR',	'$2y$10$GokUCwXUell1P6hM/orm2uNTKdBXk2n8F0VzZdT5GXPEsqIiBikBu',	'user',	'PBecue'),
(24,	'Bilel',	'Saigh',	'jackmbappekoum@outlook.fr',	'2023-07-21 00:00:00',	'2023-07-21 00:00:00',	'FR',	'$2y$10$KpKMAbHL36.pboJKz4asL.Mf3FCXgR3xUue.86xL6IXl0HkWd4mza',	'user',	'BSaigh'),
(25,	'Mhao',	'Njoya',	'jmbappekoum@myges.fr',	'2023-07-21 00:00:00',	'2023-07-21 02:34:25',	'FR',	'$2y$10$fTDSweDe.nIASvNm57OTIuW.e..M0jggllaww3NZvAuZymMsVm80W',	'user',	'MNjoya');

ALTER TABLE ONLY "public"."esgi_commentaire" ADD CONSTRAINT "esgi_commentaire_author_fkey" FOREIGN KEY (author) REFERENCES esgi_user(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."esgi_signalement" ADD CONSTRAINT "esgi_signalement_comment_id_fkey" FOREIGN KEY (comment_id) REFERENCES esgi_commentaire(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."esgi_signalement" ADD CONSTRAINT "esgi_signalement_user_id_fkey" FOREIGN KEY (user_id) REFERENCES esgi_user(id) NOT DEFERRABLE;

-- 2023-07-21 08:05:53.061231+00
