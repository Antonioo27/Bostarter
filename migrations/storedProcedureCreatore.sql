-- SQLBook: Code
USE BOSTARTER;

-- Inserimento di un nuovo progetto
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Progetto;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_Progetto(
    IN Nome_Progetto VARCHAR(20), 
    IN Descrizione_Progetto VARCHAR(300), 
    IN Data_Inserimento_Progetto DATE, 
    IN Data_Limite_Progetto DATE, 
    IN Budget_Progetto FLOAT, 
    IN Stato_Progetto VARCHAR(10), -- ENUM NON CONSENTITO
    IN Email_Creatore_Progetto VARCHAR(50)
)
BEGIN
    START TRANSACTION;

    INSERT INTO PROGETTO(Nome, Descrizione, Data_Inserimento, Data_Limite, Budget, Stato, Email_Creatore)
    VALUES (Nome_Progetto, Descrizione_Progetto, Data_Inserimento_Progetto, Data_Limite_Progetto, Budget_Progetto, Stato_Progetto, Email_Creatore_Progetto);

    COMMIT;
END @@
DELIMITER ;

DROP PROCEDURE IF EXISTS Creatore_Inserimento_FotoProgetto;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_FotoProgetto(
    IN Nome_ProgettoFoto VARCHAR(20), 
    IN Foto LONGBLOB
)
BEGIN
    START TRANSACTION;
    INSERT INTO FOTO(Codice_Foto, Nome_Progetto) 
    VALUES (Foto, Nome_ProgettoFoto);
    COMMIT;
END @@
DELIMITER ;


-- Inserimento delle reward per un progetto
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Reward;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_Reward(
    IN Codice_Reward INT, 
    IN Descrizione_Reward VARCHAR(50), 
    IN Foto_Reward LONGBLOB, 
    IN Nome_Progetto VARCHAR(20)
)
BEGIN
    START TRANSACTION;
    INSERT INTO REWARD(Codice, Descrizione, Foto, Nome_Progetto) 
    VALUES (Codice_Reward, Descrizione_Reward, Foto_Reward, Nome_Progetto);
    COMMIT;
END @@
DELIMITER ;

-- Inserimento di una risposta a un commento
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Risposta;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_Risposta(
    IN ID_Commento_Risposta INT, 
    IN Testo_Risposta VARCHAR(350), 
    IN Email_Creatore_Risposta VARCHAR(50)
)
BEGIN
    START TRANSACTION;
    INSERT INTO RISPOSTA(ID_Commento, Testo, Email_Creatore)
    VALUES (ID_Commento_Risposta, Testo_Risposta, Email_Creatore_Risposta);
    COMMIT;
END @@
DELIMITER ;

-- Inserimento di un profilo per un progetto software
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Profilo;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_Profilo(
    IN Nome_ProgettoS VARCHAR(20), 
    IN Nome_ProfiloS VARCHAR(20)
)
BEGIN
    START TRANSACTION;
        IF EXISTS (SELECT 1 FROM PROGETTO WHERE Nome = Nome_ProgettoS) THEN
            INSERT INTO PROFILO_RICHIESTO(Nome_Profilo, Nome_Progetto) VALUES (Nome_ProfiloS, Nome_ProgettoS);
        ELSE
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Errore: Il progetto non esiste';
        END IF;
    COMMIT;
END @@
DELIMITER ;

--Inserimento skill richieste--
DROP PROCEDURE IF EXISTS Creatore_Inserimento_SkillRichieste;
DELIMITER @@
CREATE PROCEDURE Creatore_Inserimento_SkillRichieste(
    IN Nome_Profilo_Skill VARCHAR(20), 
    IN Nome_Competenza_Skill VARCHAR(20),
    IN Nome_Progetto_Skill VARCHAR(20), 
    IN Livello_Skill INT
)
BEGIN
    START TRANSACTION;

    IF EXISTS (SELECT 1 FROM PROGETTO WHERE Nome = Nome_Progetto_Skill) THEN
        IF EXISTS (SELECT 1 FROM COMPETENZA WHERE Nome = Nome_Competenza_Skill) THEN
                INSERT INTO SKILL_RICHIESTE(Nome_Profilo, Nome_Competenza, Livello) VALUES (Nome_Profilo_Skill, Nome_Competenza_Skill, Livello_Skill);
        ELSE
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Errore: La competenza non esiste';
        END IF;
    ELSE
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Errore: Il progetto non esiste';
    END IF;

    COMMIT;
END @@


-- Accettazione di una candidatura
DROP PROCEDURE IF EXISTS Creatore_Accetta_Candidatura;
DELIMITER @@
CREATE PROCEDURE Creatore_Accetta_Candidatura(
    IN Email_Utente_Accettato VARCHAR(50), 
    IN Nome_Profilo_Accettato VARCHAR(20),
    IN NomeProgetto VARCHAR(20)
)
BEGIN
    START TRANSACTION;

        UPDATE CANDIDATURA
        SET Stato = 'Accettata'
        WHERE Email_Utente = Email_Utente_Accettato 
            AND Nome_Profilo = Nome_Profilo_Accettato 
            AND Nome_Progetto = NomeProgetto;

    COMMIT;
END @@
DELIMITER ;
