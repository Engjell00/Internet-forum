#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: usager
#------------------------------------------------------------

CREATE TABLE usager2(
  username Varchar (25) NOT NULL ,
  password Varchar (255) NOT NULL ,
  email    Varchar (25) ,
  PRIMARY KEY (username )
)ENGINE=InnoDB CHARACTER SET utf8;


#------------------------------------------------------------
# Table: motCle
#------------------------------------------------------------

CREATE TABLE motCle2(
  motCle Varchar (25) NOT NULL ,
  PRIMARY KEY (motCle )
)ENGINE=InnoDB CHARACTER SET utf8;

#------------------------------------------------------------
# Table: article
#------------------------------------------------------------

CREATE TABLE article2(
  idArticle    int (11) Auto_increment  NOT NULL ,
  artTitre     Varchar (25) NOT NULL ,
  artTexte     Longtext NOT NULL ,
  dateCreation Date NOT NULL ,
  username     Varchar (25) NOT NULL ,
  PRIMARY KEY (idArticle ),
  FOREIGN KEY (username) REFERENCES usager2(username)
)ENGINE=InnoDB CHARACTER SET utf8;


#------------------------------------------------------------
# Table: recherche
#------------------------------------------------------------

CREATE TABLE recherche2(
  idArticle Int NOT NULL ,
  motCle    Varchar (25) NOT NULL ,
  PRIMARY KEY (idArticle ,motCle),
  FOREIGN KEY (idArticle) REFERENCES article2(idArticle),
  FOREIGN KEY (motCle) REFERENCES motCle2(motCle)
)ENGINE=InnoDB CHARACTER SET utf8;


# OLD VERSION
# ALTER TABLE article ADD CONSTRAINT FK_article_username FOREIGN KEY (username) REFERENCES usager(username);
# ALTER TABLE recherche ADD CONSTRAINT FK_recherche_idArticle FOREIGN KEY (idArticle) REFERENCES article(idArticle);
# ALTER TABLE recherche ADD CONSTRAINT FK_recherche_motCle FOREIGN KEY (motCle) REFERENCES motCle(motCle);
