#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: usager
#------------------------------------------------------------

CREATE TABLE usager(
  username Varchar (25) NOT NULL ,
  password Varchar (255) NOT NULL ,
  banni    Bool NOT NULL ,
  admin    Bool NOT NULL ,
  PRIMARY KEY (username )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sujets
#------------------------------------------------------------

CREATE TABLE sujets(
  id_sujets            int (11) Auto_increment  NOT NULL ,
  titre_sujets         Varchar (255) NOT NULL ,
  texte_sujets         Text NOT NULL ,
  date_creation_sujets DATETIME NOT NULL ,
  username             Varchar (25) NOT NULL ,
  PRIMARY KEY (id_sujets )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: reponse
#------------------------------------------------------------

CREATE TABLE reponse(
  id_reponse            int (11) Auto_increment  NOT NULL ,
  titre_reponse         Varchar (255) NOT NULL ,
  texte_reponse         Text NOT NULL ,
  date_creation_reponse DATETIME NOT NULL ,
  id_sujets             Int NOT NULL ,
  username              Varchar (25) NOT NULL ,
  PRIMARY KEY (id_reponse )
)ENGINE=InnoDB;

ALTER TABLE sujets ADD CONSTRAINT FK_sujets_username FOREIGN KEY (username) REFERENCES usager(username);
ALTER TABLE reponse ADD CONSTRAINT FK_reponse_id_sujets FOREIGN KEY (id_sujets) REFERENCES sujets(id_sujets);
ALTER TABLE reponse ADD CONSTRAINT FK_reponse_username FOREIGN KEY (username) REFERENCES usager(username);

#------------------------------------------------------------
# Insertion de données des usagers
#------------------------------------------------------------
#password : admin
INSERT INTO usager (username, password, banni, admin)
VALUES ("admin", "$2y$10$HC7ykfRL/FL51fC4JOhux.XsXd0bGl09W9NPCKBcIXq3kxpWHmHQS", FALSE, TRUE );
#password : toto
INSERT INTO usager (username, password, banni, admin)
VALUES ("toto", "$2y$10$DRQpIRDasyYNUCrk3cBK8uEJhNd.02p7FEeM/2K.jFNnQkwYDbruW", FALSE, FALSE );

#password : banni (password_hash("banni",PASSWORD_DEFAULT))
INSERT INTO usager (username, password, banni, admin)
VALUES ("banni", "$2y$10$ggsXAIC9rrKDQmMHxyEBxusL6G09e3HYaNOpwPX1TayZDDIdgqANG", TRUE, FALSE );

#VALUES ("Guillaume", "Harvey", FALSE, FALSE )
INSERT INTO usager (username, password, banni, admin)
VALUES ("Guillaume", "$2y$10$EJHuSO4GgUAMe0Nmh.tPfuSS7YHt9P6R5xhyVeiK86x6Jiq8b81Qi", FALSE, FALSE );
#password : 1234
INSERT INTO usager (username, password, banni, admin)
VALUES ("harvey", "$2y$10$Q5tV8fTRYCs/f42pLsTj5uYXpOQYE6jGf/3VpT4HxkOvwUx6sKS0y", FALSE, FALSE );
#------------------------------------------------------------
# Insertion de données des sujets
#------------------------------------------------------------
INSERT INTO sujets (id_sujets, titre_sujets, texte_sujets, date_creation_sujets, username)
VALUES (1, "Le premier sujet", "Au moins 11 personnes ont été tuées et 135 blessées dans le nord-ouest d'Haïti, secoué par un séisme d'une magnitude de 5,9 samedi en fin de soirée « créant un début de panique dans plusieurs villes », ont annoncé les autorités.", "2018-10-07 13:17:17","toto" );

INSERT INTO sujets (id_sujets, titre_sujets, texte_sujets, date_creation_sujets, username)
VALUES (2, "Voitures électriques: des bornes de recharge municipales interdites aux employés", "Des gestionnaires municipaux qui avaient interdit à des employés de brancher leurs voitures électriques aux bornes de recharge dans un stationnement de l'arrondissement de Côte-des-Neiges-Notre-Dame-de-Grâce ont récemment été rappelés à l'ordre par la mairesse d'arrondissement, Sue Montgomery, qui a souligné son appui aux moyens de transport qui sont bons pour la planète , ont annoncé les autorités.", "2018-10-07 23:17:17","harvey" );

INSERT INTO sujets (id_sujets, titre_sujets, texte_sujets, date_creation_sujets, username)
VALUES (3, "Explosion et incendie à la raffinerie d'Irving au Nouveau-Brunswick", "Irving Oil fait état d'un « incident majeur » survenu lundi matin à sa raffinerie de Saint-Jean, au Nouveau-Brunswick.", "2018-10-08 11:17:17","banni" );

INSERT INTO sujets (id_sujets, titre_sujets, texte_sujets, date_creation_sujets, username)
VALUES (4, "Une marée d'algues toxiques se répand sur les côtes de la Floride", "Des milliers de poissons morts sur les plages, ainsi que tortues, dauphins, lamantins et même un requin-baleine échoué, tous tués à cause de la marée rouge qui continue de s'étendre en Floride. Au cours des dernières heures, les algues toxiques ont forcé la fermeture de plages du sud-ouest de la Floride, s'étendant de Naples à Sarasota, des endroits prisés par les Québécois en manque de chaleur.", "2018-10-08 12:17:17","toto" );

INSERT INTO sujets (id_sujets, titre_sujets, texte_sujets, date_creation_sujets, username)
VALUES (5, "Santé mentale: les nouveaux élus interpellés", "Des groupes qui oeuvrent en santé mentale interpellent les nouveaux élus de l'Assemblée nationale pour qu'ils effectuent des changements profonds dans leur manière de concevoir la santé mentale.", "2018-10-08 13:17:17","Guillaume" );

INSERT INTO sujets (id_sujets, titre_sujets, texte_sujets, date_creation_sujets, username)
VALUES (6, "La canicule n'a pas fait fondre toute la neige du dernier hiver", "La canicule qui a sévi au Québec cet été n'a pas réussi à faire fondre les abondantes précipitations de neige tombées l'hiver dernier sur Montréal. Un imposant amoncellement se trouve encore au fond de l'ancienne carrière Francon.", "2018-10-08 14:17:17","admin" );

INSERT INTO sujets (id_sujets, titre_sujets, texte_sujets, date_creation_sujets, username)
VALUES (7, "Le Nobel d'économie à deux précurseurs de la croissance verte", "Allier innovation, climat et économie pour plus de croissance verte : le 50e prix Nobel d'économie a été attribué lundi aux Américains William Nordhaus et Paul Romer qui ont décrit les vertus et nuisances de l'activité économique sur le climat..", "2018-10-08 15:17:17","toto" );

INSERT INTO sujets (id_sujets, titre_sujets, texte_sujets, date_creation_sujets, username)
VALUES (8, "L'Inde connaît-elle son heure #metoo?", "Un an après son apparition dans le reste du monde, le mouvement #metoo avait jusqu'ici peu bousculé en Inde. Mais la donne semble changer avec les accusations d'une actrice de Bollywood, qui ont ouvert la boîte de Pandore.", "2018-10-08 16:17:17","harvey" );

INSERT INTO sujets (id_sujets, titre_sujets, texte_sujets, date_creation_sujets, username)
VALUES (9, "Des transformations «sans précédent» sont requises, conclut le GIEC", "Le monde devra engager des transformations « rapides » et « sans précédent », s'il veut limiter le réchauffement climatique à 1,5 °C, souligne le Groupe d'experts intergouvernemental sur l'évolution du climat (GIEC), mettant en garde contre des risques accrus au-delà de ce seuil.", "2018-10-08 17:17:17","toto" );

#------------------------------------------------------------
# Insertion de données des réponses
#------------------------------------------------------------
INSERT INTO reponse (id_reponse, titre_reponse, texte_reponse, date_creation_reponse, id_sujets, username)
VALUES (1, "La première réponse","Le bilan est à ce stade de onze morts, sept d'entre eux dans la ville côtière de Port-de-Paix, capitale du département du Nord-Ouest et quatre à Gros-Morne à une cinquantaine de kilomètres au sud-est de la ville, a déclaré à l'AFP Eddy Jackson Alexis, porte-parole du gouvernement haïtien.", "2018-10-08 17:17:17", 1, "admin");

INSERT INTO reponse (id_reponse, titre_reponse, texte_reponse, date_creation_reponse, id_sujets, username)
VALUES (2, "La réponse 1 du post 4","Selon divers biologistes experts de la question, l'État de la Floride est en train de connaître l'une des pires invasions d'algues toxiques de son histoire. Ces marées rouges sont constituées de dinophytes, des micro-organismes qui se forment à une distance de 15 à 65 kilomètres des côtes. En cas de prolifération, ils émettent des toxines dangereuses chez l'homme, causant migraines, toux et crises d'asthme chez les plus vulnérables.", "2018-10-10 17:17:17", 4, "toto");

INSERT INTO reponse (id_reponse, titre_reponse, texte_reponse, date_creation_reponse, id_sujets, username)
VALUES (3, "La réponse 2 du post 4","Sur les différents réseaux sociaux d'information de la Floride, on conseille de consulter le site Florida Fish and Wildlife Conservation commission avant de planifier une journée de baignade à la plage. La mer autour de Tampa et St. Petersburg est particulièrement touchée. L'une des plages les plus populaires du comté de Palm Beach, Lake Worth Beach, a été interdite au public pendant plusieurs jours pour être finalement rouverte vendredi.", "2018-10-10 18:17:17", 4, "banni");

INSERT INTO reponse (id_reponse, titre_reponse, texte_reponse, date_creation_reponse, id_sujets, username)
VALUES (4, "La réponse 3 du post 4","Pour l'instant, les plages plus au nord de l'autre côté de la côte, dans le secteur d'Orlando, sont épargnées par le phénomène qui n'est pas étranger au réchauffement des océans. Les éclosions d'algues sont en effet associées, entre autres, à la pollution de l'eau par l'humain; eaux de ruissellement, d'égouts ou souterraines..", "2018-10-10 19:17:17", 4, "harvey");

INSERT INTO reponse (id_reponse, titre_reponse, texte_reponse, date_creation_reponse, id_sujets, username)
VALUES (5, "La réponse 4 du post 4","Avec la collaboration de National Ocean Service (États-Unis)", "2018-10-10 20:17:17", 4, "toto");

INSERT INTO reponse (id_reponse, titre_reponse, texte_reponse, date_creation_reponse, id_sujets, username)
VALUES (6, "La réponse 1 du post 2","Le grand Suédois patine au sein du cinquième trio, avec Tomas Plekanec et Nikita Scherbak, deux joueurs laissés de côté dans les deux premiers matchs de la saison.", "2018-10-10 21:17:17", 2, "Guillaume");
