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
  date_creation_sujets Date NOT NULL ,
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
  date_creation_reponse Date NOT NULL ,
  id_sujets             Int NOT NULL ,
  username              Varchar (25) NOT NULL ,
  PRIMARY KEY (id_reponse )
)ENGINE=InnoDB;

ALTER TABLE sujets ADD CONSTRAINT FK_sujets_username FOREIGN KEY (username) REFERENCES usager(username);
ALTER TABLE reponse ADD CONSTRAINT FK_reponse_id_sujets FOREIGN KEY (id_sujets) REFERENCES sujets(id_sujets);
ALTER TABLE reponse ADD CONSTRAINT FK_reponse_username FOREIGN KEY (username) REFERENCES usager(username);