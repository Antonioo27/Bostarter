DROP DATABASE IF EXISTS BOSTARTER;
CREATE DATABASE BOSTARTER;
USE BOSTARTER;

CREATE TABLE UTENTE (
    Email varchar(50) PRIMARY KEY,
    Nome varchar(20),
    Cognome varchar(20),
    Anno_Nascita smallint,
    Luogo_Nascita varchar(30),
    Nickname varchar(30),
    Password varchar(60)
) ENGINE = INNODB;

CREATE TABLE AMMINISTRATORE (
    Email_Amministratore varchar(50) PRIMARY KEY REFERENCES UTENTE(Email) ON DELETE CASCADE,
    Codice_Sicurezza int
) ENGINE = INNODB;

CREATE TABLE CREATORE(
    Email_Creatore varchar(50) PRIMARY KEY REFERENCES UTENTE(Email) ON DELETE CASCADE,
    Numero_Progetti int DEFAULT 0,
    Affidabilita float DEFAULT 0
) ENGINE = INNODB;

CREATE TABLE PROFILO_RICHIESTO(
    Nome varchar(50),
    Nome_Progetto varchar(50) REFERENCES PROGETTO(Nome) ON DELETE CASCADE, 
    PRIMARY KEY(Nome, Nome_Progetto)
) ENGINE = INNODB;

CREATE TABLE PROGETTO(
    Nome varchar(50) PRIMARY KEY,
    Descrizione varchar(500),
    Data_Inserimento date,
    Data_Limite date,
    Budget float,
    Stato ENUM('Aperto','Chiuso') NOT NULL,
    Email_Creatore varchar(50) REFERENCES CREATORE(Email_Creatore) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE PROGETTO_SOFTWARE(
    Nome_Progetto varchar(50) PRIMARY KEY REFERENCES PROGETTO(Nome) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE PROGETTO_HARDWARE(
    Nome_Progetto varchar(50) PRIMARY KEY REFERENCES PROGETTO(Nome) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE COMPONENTE(
    Nome varchar(30) PRIMARY KEY,
    Descrizione varchar(50),
    Prezzo float,
    Quantita int
) ENGINE = INNODB;

CREATE TABLE UTILIZZO(
    Nome_Progetto varchar(50) REFERENCES PROGETTO_HARDWARE(Nome_Progetto) ON DELETE CASCADE,
    Nome_Componente varchar(30) REFERENCES COMPONENTE(Nome) ON DELETE CASCADE,
    PRIMARY KEY(Nome_Progetto, Nome_Componente)
) ENGINE = INNODB;

CREATE TABLE COMPETENZA(
    Nome varchar(30) PRIMARY KEY
) ENGINE = INNODB;

CREATE TABLE SKILL_CURRICULUM(
    Email_Utente varchar(50) REFERENCES UTENTE(Email) ON DELETE CASCADE,
    Nome_Competenza varchar(30) REFERENCES COMPETENZA(Nome) ON DELETE CASCADE,
    Livello int CHECK (Livello >= 0 AND Livello <= 5 ),
    PRIMARY KEY(Email_Utente, Nome_Competenza)
) ENGINE = INNODB;

CREATE TABLE SKILL_RICHIESTE(
    Nome_Profilo varchar(50) REFERENCES PROFILO_RICHIESTO(Nome) ON DELETE CASCADE,
    Nome_Progetto varchar(50) REFERENCES PROGETTO(Nome) ON DELETE CASCADE,
    Nome_Competenza varchar(30) REFERENCES COMPETENZA(Nome) ON DELETE CASCADE,
    Livello int CHECK (Livello >= 0 AND Livello <= 5 ),
    PRIMARY KEY(Nome_Profilo, Nome_Progetto, Nome_Competenza)
) ENGINE = INNODB;

CREATE TABLE CANDIDATURA(
    Email_Utente varchar(50) REFERENCES UTENTE(Email) ON DELETE CASCADE,
    Nome_Profilo varchar(50) REFERENCES PROFILO_RICHIESTO(Nome) ON DELETE CASCADE,
    Nome_Progetto varchar(50) REFERENCES PROGETTO(Nome) ON DELETE CASCADE,
    Stato ENUM('In Attesa', 'Accettata', 'Rifiutata') NOT NULL,
    PRIMARY KEY(Email_Utente, Nome_Profilo, Nome_Progetto)
) ENGINE = INNODB;

CREATE TABLE REWARD(
    Codice int AUTO_INCREMENT PRIMARY KEY,
    Descrizione varchar(50),
    Foto longblob,
    Nome_Progetto varchar(50) REFERENCES PROGETTO(Nome) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE FINANZIAMENTO(
    ID int AUTO_INCREMENT PRIMARY KEY,
    Email_Utente varchar(50) REFERENCES UTENTE(Email) ON DELETE CASCADE,
    Nome_Progetto varchar(50) REFERENCES PROGETTO(Nome) ON DELETE CASCADE,
    Data date,
    Codice_Reward int REFERENCES REWARD(Codice) ON DELETE CASCADE,
    Importo float
) ENGINE = INNODB;

CREATE TABLE COMMENTO(
    ID int AUTO_INCREMENT PRIMARY KEY,
    Data date,
    Testo varchar(350),
    Nome_Progetto varchar(50) REFERENCES PROGETTO(Nome) ON DELETE CASCADE,
    Email_Utente varchar(50) REFERENCES UTENTE(Email) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE RISPOSTA(
    ID_Commento int REFERENCES COMMENTO(ID) ON DELETE CASCADE,
    Testo varchar(200),
    Email_Creatore varchar(50) REFERENCES CREATORE(Email_Creatore) ON DELETE CASCADE,
    PRIMARY KEY(ID_Commento)
) ENGINE = INNODB;


CREATE TABLE FOTO(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Codice_Foto longblob,
    Nome_Progetto varchar(50) REFERENCES PROGETTO(Nome) ON DELETE CASCADE
) ENGINE = INNODB;


CREATE TABLE COINVOLGIMENTO(
    Email_Utente varchar(50) REFERENCES UTENTE(Email) ON DELETE CASCADE,
    Nome_Progetto varchar(50) REFERENCES PROGETTO_SOFTWARE(Nome_Progetto) ON DELETE CASCADE,
    Nome_Profilo varchar(20) REFERENCES PROFILO_RICHIESTO(Nome) ON DELETE CASCADE,
    PRIMARY KEY(Nome_Progetto, Nome_Profilo)
) ENGINE = INNODB;

