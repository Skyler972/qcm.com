#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: professeur
#------------------------------------------------------------

CREATE TABLE professeur(
        IdProf     Int  Auto_increment  NOT NULL ,
        NomProf    Varchar (50) NOT NULL ,
        PrenomProf Varchar (50) NOT NULL ,
        MotDePasse Varchar (50) NOT NULL
	,CONSTRAINT professeur_PK PRIMARY KEY (IdProf)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: question
#------------------------------------------------------------

CREATE TABLE question(
        IdQuest       Int  Auto_increment  NOT NULL ,
        IntituleQuest Varchar (150) NOT NULL
	,CONSTRAINT question_PK PRIMARY KEY (IdQuest)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: reponse
#------------------------------------------------------------

CREATE TABLE reponse(
        IdRep       Int  Auto_increment  NOT NULL ,
        IntituleRep Varchar (50) NOT NULL ,
        Vrai        Int NOT NULL ,
        IdQuest     Int NOT NULL
	,CONSTRAINT reponse_PK PRIMARY KEY (IdRep)

	,CONSTRAINT reponse_question_FK FOREIGN KEY (IdQuest) REFERENCES question(IdQuest)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: epreuve
#------------------------------------------------------------

CREATE TABLE epreuve(
        IdEpreuve  Int  Auto_increment  NOT NULL ,
        NomEpreuve Varchar (150) NOT NULL ,
        IdProf     Int NOT NULL
	,CONSTRAINT epreuve_PK PRIMARY KEY (IdEpreuve)

	,CONSTRAINT epreuve_professeur_FK FOREIGN KEY (IdProf) REFERENCES professeur(IdProf)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: classe
#------------------------------------------------------------

CREATE TABLE classe(
        IdClasse       Int  Auto_increment  NOT NULL ,
        NomClasse      Varchar (50) NOT NULL ,
        NiveauClasse   Varchar (50) NOT NULL ,
        EffectifClasse Int NOT NULL ,
        AnneeScolaire  Varchar (50) NOT NULL
	,CONSTRAINT classe_PK PRIMARY KEY (IdClasse)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: eleve
#------------------------------------------------------------

CREATE TABLE eleve(
        IdEleve        Int  Auto_increment  NOT NULL ,
        NomEleve       Varchar (50) NOT NULL ,
        PrenomEleve    Varchar (50) NOT NULL ,
        PseudoEle      Varchar (50) NOT NULL ,
        JourNaissance  Varchar (50) NOT NULL ,
        MoisNaissance  Varchar (50) NOT NULL ,
        AnneeNaissance Varchar (50) NOT NULL
	,CONSTRAINT eleve_PK PRIMARY KEY (IdEleve)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: calendrierepr
#------------------------------------------------------------

CREATE TABLE calendrierepr(
        IdDateEpreuve Int  Auto_increment  NOT NULL ,
        DateEpreuve   Date NOT NULL
	,CONSTRAINT calendrierepr_PK PRIMARY KEY (IdDateEpreuve)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: constituer
#------------------------------------------------------------

CREATE TABLE constituer(
        IdQuest   Int NOT NULL ,
        IdEpreuve Int NOT NULL ,
        RangQuest Int NOT NULL
	,CONSTRAINT constituer_PK PRIMARY KEY (IdQuest,IdEpreuve)

	,CONSTRAINT constituer_question_FK FOREIGN KEY (IdQuest) REFERENCES question(IdQuest)
	,CONSTRAINT constituer_epreuve0_FK FOREIGN KEY (IdEpreuve) REFERENCES epreuve(IdEpreuve)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: realiser
#------------------------------------------------------------

CREATE TABLE realiser(
        IdEpreuve     Int NOT NULL ,
        IdClasse      Int NOT NULL ,
        IdDateEpreuve Int NOT NULL ,
        IdEleve       Int NOT NULL ,
        Note          Double NOT NULL
	,CONSTRAINT realiser_PK PRIMARY KEY (IdEpreuve,IdClasse,IdDateEpreuve,IdEleve)

	,CONSTRAINT realiser_epreuve_FK FOREIGN KEY (IdEpreuve) REFERENCES epreuve(IdEpreuve)
	,CONSTRAINT realiser_classe0_FK FOREIGN KEY (IdClasse) REFERENCES classe(IdClasse)
	,CONSTRAINT realiser_calendrierepr1_FK FOREIGN KEY (IdDateEpreuve) REFERENCES calendrierepr(IdDateEpreuve)
	,CONSTRAINT realiser_eleve2_FK FOREIGN KEY (IdEleve) REFERENCES eleve(IdEleve)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: accueillir
#------------------------------------------------------------

CREATE TABLE accueillir(
        IdClasse Int NOT NULL ,
        IdEleve  Int NOT NULL
	,CONSTRAINT accueillir_PK PRIMARY KEY (IdClasse,IdEleve)

	,CONSTRAINT accueillir_classe_FK FOREIGN KEY (IdClasse) REFERENCES classe(IdClasse)
	,CONSTRAINT accueillir_eleve0_FK FOREIGN KEY (IdEleve) REFERENCES eleve(IdEleve)
)ENGINE=InnoDB;

