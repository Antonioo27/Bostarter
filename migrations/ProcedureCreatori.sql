USE BOSTARTER;

--Inserimento di un nuovo progetto--
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Progetto;
DELIMITER |
CREATE PROCEDURE Creatore_Inserimento_Progetto(IN Nome_Progetto varchar(20), IN Descrizione_Progetto varchar(50), 
                                               IN Data_Inserimento_Progetto date, IN Data_Limite_Progetto date, 
                                               IN Budget_Progetto double, IN Stato_Progetto ENUM('Aperto','Chiuso'), 
                                               IN Email_Creatore_Progetto varchar(30))
    BEGIN
    START TRANSACTION;
        INSERT INTO PROGETTO(Nome, Descrizione, Data_Inserimento, Data_Limite, Budget, Stato, Email_Creatore)
        VALUES (Nome_Progetto, Descrizione_Progetto, Data_Inserimento_Progetto, Data_Limite_Progetto, Budget_Progetto, Stato_Progetto, Email_Creatore_Progetto);
    COMMIT;
    END
| DELIMITER


--Inserimento delle reward per un progetto--
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Reward;
DELIMITER |
CREATE PROCEDURE Creatore_Inserimento_Reward(IN Codice_Reward int, IN Descrizione_Reward varchar(50), IN Foto_Reward longblob, IN Nome_Progetto varchar(20))
    BEGIN
    START TRANSACTION;
        INSERT INTO REWARD(Codice, Descrizione, Foto, Nome_Progetto) 
        VALUES (Codice_Reward, Descrizione_Reward, Foto_Reward, Nome_Progetto);
    COMMIT;
    END
| DELIMITER


--Inserimento di una risposta ad un commento--
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Risposta;
DELIMITER |
CREATE PROCEDURE Creatore_Inserimento_Risposta(IN ID_Commento_Risposta int, IN Testo_Risposta varchar(200), IN Email_Creatore_Risposta varchar(20))
    BEGIN
    START TRANSACTION;
        INSERT INTO RISPOSTA(ID_Commento, Testo, Email_Creatore)
        VALUES (ID_Commento_Risposta, Testo_Risposta, Email_Creatore_Risposta);
    COMMIT;
    END
| DELIMITER


--Inserimento di un profilo -solo per la realizzazione di un progetto software--
DROP PROCEDURE IF EXISTS Creatore_Inserimento_Profilo;
DELIMITER |
CREATE PROCEDURE Creatore_Inserimento_Profilo(IN Nome_ProgettoS varchar(20), IN Nome_ProfiloS varchar(20))
    BEGIN
    START TRANSACTION;
        IF EXISTS (SELECT 1 FROM PROGETTO WHERE Nome = Nome_ProgettoS) THEN
            IF EXISTS (SELECT 1 FROM PROFILO WHERE Nome = Nome_ProfiloS) THEN
                INSERT INTO COINVOLGIMENTO(Nome_Progetto, Nome_Profilo)
                VALUES (Nome_ProgettoS, Nome_ProfiloS);
            ELSE
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Il profilo non esiste';
            END IF;
        ELSE
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Il progetto non esiste';
        END IF;
    COMMIT;
    END
| DELIMITER


--WIP--
-- --Accettazione o meno di una candidatura--
-- DROP DATABASE IF EXISTS Creatore_Accettazione_Candidatura;
-- DELIMITER |
-- CREATE PROCEDURE Creatore_Accettazione_Candidatura(IN Email_Utente_Accettazione varchar(30), IN Nome_Profilo_Accettazione varchar(20))
--     BEGIN
--     START TRANSACTION;
--         DECLARE Nome_Competenza_Richiesta varchar(20);
--         DECLARE Livello_Competenza_Richiesta int;
--         Nome_Competenza_Richiesta = (SELECT Nome_Competenza FROM SKILL_RICHIESTE WHERE Nome_Profilo = Nome_Profilo_Accettazione);
--         Livello_Competenza_Richiesta = (SELECT Livello FROM SKILL_RICHIESTE WHERE Nome_Profilo = Nome_Profilo_Accettazione);

--         DECLARE Nome_Competenza_Utente varchar(20);
--         DECLARE Livello_Competenza_Utente int;
--         Nome_Competenza_Utente = (SELECT Nome_Competenza FROM SKILL_CURRICULUM WHERE Email_Utente = Email_Utente_Accettazione);
--         Livello_Competenza_Utente = (SELECT Livello FROM SKILL_CURRICULUM WHERE Email_Utente = Email_Utente_Accettazione);

--         IF(Nome_Competenza_Richiesta = Nome_Competenza_Utente AND Livello_Competenza_Utente >= Livello_Competenza_Richiesta) THEN
--             INSERT INTO CANDIDATURA(Email_Utente, Nome_Profilo)
--             VALUES (Email_Utente_Accettazione, Nome_Profilo_Accettazione);
--         ELSE
--             SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Il livello della competenza richiesta non è sufficiente';
--         END IF;
--     COMMIT;
--     END
-- | DELIMITER






